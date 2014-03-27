<?php
App::import('Vendor', 'solarium');
App::uses('HttpSocket', 'Network/Http');
App::uses('Xml', 'Utility');
App::uses('MyTools', 'Lib');
/**
 * SolariumSource base class
 */

class SolrSource extends DataSource {
	/**
	 * An optional description of your datasource
	 */
	public $description = 'Solarium datasource';

	/**
	 * Are we connected to the DataSource?
	 *
	 * @var boolean
	 */
	public $connected = false;

	/**
	 * The default configuration of a specific DataSource
	 *
	 * @var array
	 */
	protected $_baseConfig = array(
			'driver' => 'solr',
			'path' => '/solr/',
			'schema' => 'schema'
	);

	/**
	 * The DataSource configuration
	 *
	 * @var array
	 */
	public $config = array();


	protected $_schema = null;


	/**
	 * Whether or not source data like available tables and schema descriptions
	 * should be cached
	 *
	 * @var boolean
	 */
	public $cacheSources = true;



	/**
	 * The starting character that this DataSource uses for quoted identifiers.
	 *
	 * @var string
	 */
	public $startQuote = null;

	/**
	 * The ending character that this DataSource uses for quoted identifiers.
	 *
	 * @var string
	 */
	public $endQuote = null;



	/**
	 * Constructor.
	 *
	 * @param array $config Array of configuration information for the datasource.
	 */
	public function __construct($config = null, $autoConnect = true) {
		parent::__construct($config);
		$this->setConfig($config);
		$this->solr = new Solarium_Client(array('adapteroptions' => $this->config));
		if($this->ping())
			$this->_schema = $this->schema();
	}

	public function schema() {
		$uri = 'http://'.$this->config['host'].':'.$this->config['port'];
		$uri .= $this->config['path'].'admin/file/?file='.$this->config['schema'].'.xml';
		$xml = Xml::build($uri);
		if(!$xml)
			throw new HttpException('Solr Schema is unavailable');
		$arr = Xml::toArray($xml->fields);
		$unique = Xml::toArray($xml->uniqueKey);
		$unique = $unique['uniqueKey'];

		foreach($arr['fields']['field'] as $field) {
			$_schema[$field['@name']] = array(
					'type' => key_exists('@multiValued', $field)? 'multi'.$field['@type']:$field['@type'],
					'null' => true,
					'length' => null,
					//'multiValue' => key_exists('@multiValued', $field),
			);
			if($field['@name'] === $unique) {
				$_schema[$field['@name']]['null'] = false;
				$_schema[$field['@name']]['key'] = 'primary';
			}
		}
		return $_schema;
	}


	/**
	 * Caches/returns cached results for child instances
	 *
	 * @param mixed $data
	 * @return array Array of sources available in this datasource.
	 */
	public function listSources($data = null) {
		return null;
	}

	/**
	 * Returns a Model description (metadata) or null if none found.
	 *
	 * @param Model|string $model
	 * @return array Array of Metadata for the $model
	 */
	public function describe($model) { //IMPORTANTISIMO es el que devuelve el schema al Modelo
		return $this->_schema;
	}



	/**
	 * Used to create new records. The "C" CRUD.
	 *
	 *
	 * @param Model $model The Model to be created.
	 * @param array $fields An Array of fields to be saved.
	 * @param array $values An Array of values to save.
	 * @return boolean success
	 */
	public function create(Model $model, $fields = array(), $values = array()) {
		/*if($this->ping() && !$this->_schema)
		 $this->_schema = $this->schema();*/
		$this->ping();

		if (empty($fields)) {
			unset($fields, $values);
			$fields = array_keys($model->data[$model->alias]);
			$values = array_values($model->data[$model->alias]);
		}
			
		if (($data = array_combine($fields, $values)) === false) {
			return false;
		}

		array_walk_recursive($data, function(&$item) {
			if(strpos($item, SOLRGLUEFIELD) !== false)
				$item = explode(SOLRGLUEFIELD, $item);
			$item = MyTools::utf8($item);
		});

		echo '<pre>', print_r($data), '</pre>';
			
		$update = $this->solr->createUpdate();
		$doc = $update->createDocument();

		foreach ($data as $field => $value) {
			$doc->{$field} = $value;
		}
			
		$update->addDocument($doc);
		$update->addCommit();
		$resultset = $this->solr->update($update);

		if($resultset->getStatus() == 0)
			return true;
		return false;
	}


	/**
	 * Used to read records from the Datasource. The "R" in CRUD
	 *
	 * To-be-overridden in subclasses.
	 *
	 * @param Model $model The model being read.
	 * @param array $queryData An array of query data used to find the data you want
	 * @return mixed
	 */
	public function read(Model $model, $queryData = array(), $recursive = NULL) {
		//$this->ping();
		$results = array();
		$conditions = ltrim($this->_generateCondition($queryData), 'query:');
		$conditions = str_replace("{$model->alias}.", "", $conditions);

		$options = array();
		if (isset($queryData['options'])) {
			$options = $queryData['options'];
		}

		if ($conditions !== '') {
			$_query = $this->solr->createSelect();
			$_query->setQuery($conditions);

			if(!empty($queryData['fields']))
				$_query->setFields(str_replace("{$model->alias}.", "", $queryData['fields']));

			if(!empty($queryData['order']))
			{
				$condition = str_replace("{$model->alias}.", "", $queryData['order'][0][0]);
				$item = explode(' ', $condition);
				if ($item[1] == 'ASC' ) {
					$_query->addSort($item[0], $_query::SORT_ASC);
				}
				elseif ($item[1] == 'DESC')
				{
					$_query->addSort($item[0], $_query::SORT_DESC);
				}
					
			}


			$_query->setStart($queryData['offset'])->setRows($queryData['limit']);
			$resultset = $this->solr->select($_query, $options);

			if(empty($queryData['offset']) && empty($queryData['limit'])) {
				$_query->setStart(0)->setRows($resultset->getNumFound());
				$resultset = $this->solr->select($_query, $options);
			}

			$this->affected = $this->numRows = $resultset->getNumFound();

			if ($model->findQueryType === 'count') {
				$count = 0;
				if (isset($resultset)) {
					$count = $resultset->getNumFound();
				}
				return array(array(array('count' => $count)));
			} else {
				//$docs = $resultset->response->docs;
				//unset($results);
				if (isset($options['response']) && $options['response'] === 'class') {
					// if options['response'] equals 'class', return value type is iterator class
					return $resultset;
				} else {
					foreach ($resultset as $doc) {
						$tmp[] = array($model->alias => (array)$doc->getIterator());
					}
					return isset($tmp) ? $tmp : array();
				}
			}
		} else {
			//host inaccesible
			//throw new InternalErrorException('Apache Solr - No Service Available');
		}
		//$model->onError();
		return false;
	}

	public function _generateCondition($query = null) {
		$conditions = "*:*";
		//$conditions = "";
		if (!empty($query['conditions'])) {
			$conditions = $query['conditions'];
			if (is_array($conditions)) {
				$queryString = '';
				foreach ($conditions as $key => $value) {
					if ($key === 'AND' || $key === 'OR') {
						if (is_array($value)) {
							foreach ($value as $k => $v) {
								if (is_array($v)) {
									foreach ($v as $vv) {
										$this->_generateQuery($queryString, $key, $k, $vv);
									}
								} else {
									$this->_generateQuery($queryString, $key, $k, $v);
								}
							}
						}
					} else {
						if (is_array($value)) {
							foreach ($value as $v) {
								$this->_generateQuery($queryString, 'OR', $key, $v);
							}
						} else {
							$this->_generateQuery($queryString, 'OR', $key, $value);
						}
					}
				}
				if (get_magic_quotes_gpc() == 1) {
					$queryString = stripslashes($queryString);
				}
				$conditions = &$queryString;
			}
		}
		return $conditions;
	}

	public function _generateQuery(&$query, $operator, $key, $value) {
		if(!isset($value)){
			return $query;
		}
		$first = empty($query);
		if ($operator === 'AND') {
			if (!$first) {
				$query .= ' AND ';
			}
		} else {
			if (!$first) {
				$query .= ' OR ';
			}
		}
		$first = false;
		$query .= $key.':'.$value;
		return $query;
	}

	/**
	 * Update a record(s) in the datasource.
	 *
	 * To-be-overridden in subclasses.
	 *
	 * @param Model $model Instance of the model class being updated
	 * @param array $fields Array of fields to be updated
	 * @param array $values Array of values to be update $fields to.
	 * @return boolean Success
	 */
	public function update(Model $model, $fields = null, $values = null, $conditions = null) {
		$this->create($model, $fields, $values);
	}

	/**
	 * Delete a record(s) in the datasource.
	 *
	 * To-be-overridden in subclasses.
	 *
	 * @param Model $model The model class having record(s) deleted
	 * @param mixed $conditions The conditions to use for deleting.
	 * @return void
	 */
	public function delete(Model $model, $id = null) {
		$update = $this->solr->createUpdate();
		$id = $id["{$model->alias}.{$model->primaryKey}"];
		if(is_array($id)) {
			$query = $id;
			array_walk($query, function(&$id, $key, $pKey) {
				$id = "$pKey:$id";
			}, $model->primaryKey);
			$update->addDeleteQueries($query);
		} else {
			$query = "{$model->primaryKey}:".$id;
			$update->addDeleteQuery($query);
		}
		$update->addCommit();
		$result = $this->solr->update($update);
		return $result->getStatus() === 0;
	}


	public function query($method, $params = array(), Model &$model = null) {
		// return $this->{$method}($params, $model);
		echo "query is not implemeted in Solr Datasource";
	}

	public function ping() {
		try {
			$result = $this->solr->ping($this->solr->createPing());
			return $result->getData();
		}
		catch(Solarium_Exception $e){
			throw new HttpException('Solr Service is unavailable');
		}

	}

	public function calculate(Model $Model, $func, $params = array()) {
		return 'count';
	}


	/*public function logQuery($sql, $params = array()) {
		$this->_queriesCnt++;
	$this->_queriesTime += $this->took;
	$this->_queriesLog[] = array(
			'query'		=> $sql,
			'params'	=> $params,
			'affected'	=> $this->affected,
			'numRows'	=> $this->numRows,
			'took'		=> $this->took
	);
	if (count($this->_queriesLog) > $this->_queriesLogMax) {
	array_pop($this->_queriesLog);
	}
	}*/

}
?>
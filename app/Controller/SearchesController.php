<?php

class SearchesController extends AppController {
	//public $helpers = array('Html','Form');
	public $name = 'Searches';

	function index() { //FUNCIONA el buscar

		/******** Ejemplos *****/
		//$conditions = array('Search.v13_t' => 'Experimental ','Search.v76_t' => 'PERROS'); //Analogia en Solr: Filter Query (fq)
		//$conditions = array('Search.v13_t' => array('Experimental', 'acute'));
		//$conditions = array('AND' => array('Search.v13_t' => 'Experimental ','Search.v76_t' => 'PERROS'));
		$fields = array('Search.v108_t', 'Search.v99_t', 'Search.v83_t'); //Analogia en Solr: Field List (fl)
		//$order = array('Search.v91_t ASC');
		//$result = $this->Search->find('all', compact('conditions', 'order', 'fields'));
		$result2 = $this->Search->find('first');

		$stopAqui = 'fdfsd';
	}

	function view($id = null) { //FUNCIONA el leer un documento
		$this->Search->id = '6b4a9cc97cc6521f7edf2a55b3003a01';  //El id debe existir	
		$fidel = $this->Search->read();

		$stopAqui = 'fdfsd';
	}

	function add() { //FUNCIONA

		/* FUNCIONA el insertar un documento, siempre y cuando los fields esten en el
		 * schema. Por tanto los campos dinamicos *_t no se pueden indexar. Se debe definir
		* en schema.xml de Solr los fields del lildbi.
		* */

		$fidel['Search']['id'] = '555555555555555555555555555';  //Siempre tiene que tener un id
		$fidel['Search']['title'] = 'Mi nombfre es fidel el quemao';
		//$fidel['Search']['v100_t'] = 'ES to es un prueba';

		$this->Search->save($fidel);
		
		$stopAqui = 'fdfsd';
	}

	function edit($id = null) {  //FUNCIONA
		$this->Search->id = '555555555555555555555555555'; //NO es necesario
		$fidel['Search']['id'] = '555555555555555555555555555'; //Se tiene que pasar tambien el id (debe existir) juntos con los datos a modificar
		$fidel['Search']['title'] = 'Te volvi a editar COCINEROOOOOOOOOOOO'; //Dato a modificar
		$this->Search->save($fidel);

		$stopAqui = 'fdfsd';
	}

	function delete($id) {   //FUNCIONA
		
		$this->Search->delete('555555555555555555555555555'); //El id debe existir	
				
		$stopAqui = 'fdfsd';
	}
}
?>
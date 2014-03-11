<?php
class IndexaTask extends Shell {
    
    public $uses = array('Source');
    
    public function execute() {       
        if(Configure::restore('for_indexa_uses', 'default')) {
            if(Configure::read('Indexa.busy') == 'yes')
                return 0;    
        }
        Configure::write('Indexa.busy', 'yes');
        Configure::store('for_indexa_uses', 'default');
        
        $params = array(
            'conditions' => array(
                'Source.enabled' => true, 
                'OR' => array(
                    'Source.indexed <=' => CakeTime::format('Y-m-d', '-2 days'),
                    'Source.indexed' => null
                )
            ),
            'recursive' => -1,
            'order' => array('Source.indexed', 'Source.priority'),
            'group' => array('Source.priority'),
        );
                           
        foreach($this->Source->find('all', $params) as $source) {
            $this->Source->id = $source['Source']['id'];
            $length_before = (int)$this->Source->field('length');
            //print_r($source['Source']);
            
            try {
                @$this->Source->scanSource($source);
                if($length_before == (int)$this->Source->field('length'))
                    $this->Source->saveField('priority', 3);
                else
                    $this->Source->saveField('priority', 1);   
            }
            catch(InternalErrorException $e) {
                CakeLog::write('indexing_error', json_encode(array(
                            'source_id' => $this->Source->id,
                            'message' => $e->getMessage()
                        ))
                );
                $this->out($e->getMessage());
                $this->Source->saveField('priority', 0);
            }
        }
        Configure::delete('Indexa.busy'); 
        Configure::store('for_indexa_uses', 'default');        
    }
}
?>
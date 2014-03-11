<?php 
App::uses('CakeLogInterface', 'Log');
App::uses('CakeTime', 'Utility');
App::import('Model', 'Log');

class DatabaseLogger implements CakeLogInterface {
    
    public function __construct($options = array()) {        
        $this->Log = new Log;
    }

    public function write($type, $message) {      
        $this->Log->create();
        return $this->Log->save(array(
            'type' => strtolower($type),
            'time' => CakeTime::format('Y-m-d H:i:s', 'now'),
            'message' => $message
        ));
    }
}
?>
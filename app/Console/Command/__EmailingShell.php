<?php
App::uses('My', 'Lib');

class IndexaShell extends AppShell {
    public $uses = array('Issue');
    
    public function main() {
        $params = array(
            'conditions' => array("Issue.emaled" => 0),
            'recursive' => 1,
            'order' => 'Issue.created',
        );
        
        foreach($this->Issue->find('all', $params) as $issue) {
            $this->Issue->id = $issue['Issue']['id'];
            $this->Issue->email();
        }
    }
}
?>
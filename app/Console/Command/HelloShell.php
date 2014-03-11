<?php
class HelloShell extends AppShell {
	
	public $uses = array('User');
	
	
    public function main() {
        $this->out('Hello world.');
    }
    
	 public function hey_there() {
        $this->out('Hey there ' . $this->args[0]);
    }
    
    
    public function show() {
    	$user = $this->User->findByUsername($this->args[0]);
    	$this->out(print_r($user, true));
    }
}
?>
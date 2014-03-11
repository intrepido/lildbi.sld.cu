<?php
App::uses('CakeTime', 'Utility');

class IndexaShell extends AppShell {
    
    public $tasks = array('Indexa');
    
    public function manually() {        
        $this->out('> Indexa executed by you...');
        if(!$this->Indexa->execute())
            $this->out('> Indexa are busy.');
        else
            $this->out('> OK');
    }
    
    public function main() {       
        extract(Configure::read('Cron.schedule'), EXTR_PREFIX_ALL, 'cron');
        
        $start = CakeTime::fromString($cron_start);
        $end = CakeTime::fromString($cron_end);
        $end += $start > $end? DAY:0;
        $now = CakeTime::fromString('NOW');
        
        $this->out(compact('start', 'now', 'end'));
        
        $this->out(CakeTime::format('Y-m-d H:i:s', $start));
        $this->out(CakeTime::format('Y-m-d H:i:s', $now));
        $this->out(CakeTime::format('Y-m-d H:i:s', $end));
        
        if($start <= $now && $now <= $end)            
            $this->manually();
        else {
            $this->out('> Indexa does not work after hours set. You may want to modify <info>"myconf.php" file</info> in Config.');
            $this->out('> To manually run this command, type <info>cake indexa manually</info>');
        }
    }
}
?>
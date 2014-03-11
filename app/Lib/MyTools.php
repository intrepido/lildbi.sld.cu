<?php

/**
 * @author yasser
 * @copyright 2012
 */
 define('SOLRFIELDTOKEN', '>)*/*{<');
 App::uses('CrontabManager', 'Lib');
 /**
  * MyTools
  * 
  * @package cake-mb
  * @author Yasser
  * @copyright 2012
  * @version $Id$
  * @access public
  */
 class MyTools {
    
/**
 * utf8() encode any string or array in UTF8.
 * 
 * @param mixed $data can be string or array of strings.
 * @return utf8 encoded data 
 */
    /**
     * MyTools::utf8()
     * 
     * @param mixed $mixed
     * @return
     */
    public function utf8($mixed) {        
        mb_detect_order(array(
            'ISO-8859-1', 'ISO-8859-2', 'ISO-8859-3',
            'ISO-8859-4', 'ISO-8859-5', 'ISO-8859-6',
            'ISO-8859-7', 'ISO-8859-8', 'ISO-8859-9',
            'ISO-8859-10', 'ISO-8859-13', 'ISO-8859-14',
            'ISO-8859-15', 'ASCII', 'EUC-JP', 'SJIS',
            'eucJP-win', 'SJIS-win', 'JIS', 'ISO-2022-JP',
            'WINDOWS-1252', 'UTF-7', 'UTF-8' 
        ));
        
        if (is_array($mixed)) {
            array_walk($mixed, function (&$item) {
                $item = MyTools::utf8($item);                
            });
        } 
        elseif(!mb_check_encoding($mixed, 'UTF-8')) {           
            $enc = mb_detect_encoding($mixed);
            $mixed = mb_convert_encoding($mixed, 'UTF-8', $enc);
            $mixed = MyTools::utf8($mixed);
        }
        return $mixed;
    }
    
    /**
     * MyTools::collapseFields()
     * 
     * @param mixed $arr
     * @return
     */
    
    /**
     * MyTools::expandFields()
     * 
     * @param mixed $data
     * @param mixed $fields
     * @return
     */
    
    
/**
 * MyTools::cron()
 * 
 * @return
 */
    public function cron() {
        $action = VENDORS.'cakeshell hello';
        $cli = '-cli '.DS.'usr'.DS.'bin';
        $console = '-console '.CAKE.'Console';
        $app = '-app '.APP;
        
        $crontab = new CrontabManager();
        $job = $crontab->newJob();
        $job->on("*/1 * * * *")->doJob("$action $cli $console $app". " >> ".VENDORS."/PRUEBAAAAAA.log");         
        
        Configure::restore('for_crontab_uses', 'default');
        $cron = Configure::read('Cron');
        
        if(strpos(trim($crontab->listJobs()), $job->render(false)) === false) {
            if(@strpos(trim($crontab->listJobs()), $cron['entry']) === false)
                $crontab->add($job);
            else
                $crontab->replace($crontab->newJob($cron['entry']), $job);
            $crontab->save();
            Configure::write('Cron.entry', $job->render(false)); 
            Configure::store('for_crontab_uses', 'default');
        }
    }
    
    
    public static function parse($data_type, $data) {
        if(strpos($data_type, 'text') == 0 || strpos($data_type, 'string') == 0)
            $data_type = 'text';
        switch($data_type){
            case 'date':
                extract(date_parse($data));
                if($error_count == 0) {
                    $data = sprintf('%sZ', date('c', mktime ($hour, $minute, $second, $month, $day, $year)));;
                }
                break;
            case 'text':
                $data = MyTools::utf8($data);
                break;
            default:
                $arr = array();                          
                if(is_array($data)) {
                    foreach ($data as $data_item){
                        $arr[] = MyTools::parse(str_ireplace('multi', '', $data_type), $data_item);
                    }
                }                
                $data = $arr;            
        }
        return $data;
    }
    
    
    function clean_special_characters($s) {
        $s = ereg_replace("[áàâãªä@]","a",$s);
        $s = ereg_replace("[ÁÀÂÃÄ]","A",$s);
        $s = ereg_replace("[éèêë]","e",$s);
        $s = ereg_replace("[ÉÈÊË]","E",$s);
        $s = ereg_replace("[íìîï]","i",$s);
        $s = ereg_replace("[ÍÌÎÏ]","I",$s);
        $s = ereg_replace("[óòôõºö]","o",$s);
        $s = ereg_replace("[ÓÒÔÕÖ]","O",$s);
        $s = ereg_replace("[úùûü]","u",$s);
        $s = ereg_replace("[ÚÙÛÜ]","U",$s);
        $s = str_replace("[¿?\]","_",$s);
        $s = str_replace(" ","-",$s);
        $s = str_replace("ñ","n",$s);
        $s = str_replace("Ñ","N",$s);
        return $s;
    }
 };
?>
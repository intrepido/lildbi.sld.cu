<?php

/**
 * @author Yasser
 * @copyright 2013
 */

define('FIELD_DELIMITER', '<>>>');
define('FIELD_DELIMITER_SECOND_LEVEL', ';');
define('EXTRACTS', TMP.'extracts\\');
define('LOG_INDEX_ALERT', 'index alert');

// Debe Coincidir conn la configuracion de Apache Solr in Config.php
define('EXTRACT_DOCUMENT_KEY', 'document');

App::uses('MyTools', 'Lib');
MyTools::cron();

$config = array(
    'App' => array(
        'name' => 'Indexa'
    ),
    'Cron' => array(
        'schedule' => array(
            'start' => '14:00', //example 22:00
            'end' => '05:30',
        ),
    ),    
    'System' => array(
        'services' => array(
            'xmlrpc' => 'XML-RPC', 
            'oai' => 'OAI'
        )
    ),
    'Superadmin' => array(
        'username' => 'superadmin',
        'password' => 'password',
        'fullname' => 'Super Administrador',
        'alerts' => false
    )
);
?>
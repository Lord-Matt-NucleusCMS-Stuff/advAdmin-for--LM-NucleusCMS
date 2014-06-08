<?php
/**
 * A boot loader to get things loaded that the advAdmin project will use
 * 
 */

ini_set('display_errors',1); 
error_reporting(E_ALL);

//require_once($DIR_NUCLEUS.'advAdmin/advAdmin_singleton.php');
require_once($DIR_NUCLEUS.'advAdmin/advAdmin_factory.php');
require_once($DIR_NUCLEUS.'advAdmin/advAdmin_admin.php');
require_once($DIR_NUCLEUS.'advAdmin/advAdmin_simpleXML.php');

// paranoia :-P
if(!isset($CONF)){
    global $CONF, $FACTORY;
}
$CONF['advAdmin']=true;

$FACTORY = advAdmin_factory::getInstance();
$FACTORY->on_start();
$FACTORY->setOverRide('ADMIN','advAdmin_admin');
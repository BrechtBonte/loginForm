<?php
    session_start();
    
    define('APLICATION_PATH', __DIR__ . '/../../');
    
    /* AutoLoader */
    require_once(APLICATION_PATH . 'core/bin/autoload.php');
    
    /* config */
    $config = new Zend_Config_Ini(APLICATION_PATH . 'core/config/config.ini', 'testing');
    ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . $config->path->includes);
    
    require_once($config->path->entities . '/User.php');
    require_once($config->path->entities . '/Language.php');
    require_once($config->path->entities . '/Group.php');
//    require_once('UserMysqlDatastore.php');
    require_once('UserPasswordGenerator.php');
    require_once('Page.php');
    

    /* Initialize properties */
//    $userDatastore = UserMysqlDatastore::getInstance();
    $userPassGen = UserPasswordGenerator::getInstance();
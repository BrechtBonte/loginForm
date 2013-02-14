<?php
    session_start();
    
    define('APLICATION_PATH', __DIR__ . '/../../');
    
    /* AutoLoader */
    require_once('autoload.php');
    
    /* config */
    require_once('Config.php');
    $config = new Zend_Config_Ini(APLICATION_PATH . 'core/config/config.ini', 'testing');
    ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . $config->path->includes);
    
    require_once('User.php');
    require_once('UserMysqlDatastore.php');
    require_once('UserPasswordGenerator.php');
    require_once('Page.php');

    /* Initialize properties */
    $userDatastore = UserMysqlDatastore::getInstance();
    $userPassGen = UserPasswordGenerator::getInstance();
<?php
    session_start();
    
    /* AutoLoader */
    require_once('autoload.php');
    
    /* config */
    require_once('Config.php');
    $config = new Config(__DIR__ . '/../config/config.ini', 'testing');
    ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . $config->path->includes);
    
    require_once('User.php');
    require_once('UserMysqlDatastore.php');
    require_once('UserPasswordGenerator.php');
    require_once('Page.php');

    /* Initialize properties */
    $userDatastore = UserMysqlDatastore::getInstance();
    $userPassGen = UserPasswordGenerator::getInstance();
<?php
    session_start();
    
    ini_set('memory_limit', '1024M');
    
    define('APLICATION_PATH', __DIR__ . '/../../');
    
    /* AutoLoader */
    require_once(APLICATION_PATH . 'autoload.php');
    
    
    // Config
    $config = new Zend_Config_Ini(APLICATION_PATH . 'core/config/config.ini', 'sqliteDev');
    ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . $config->path->includes);

    // Doctrine
    $em = require_once(APLICATION_PATH . 'core/bin/loadDoctrine.php');
    
    require_once($config->path->entities . '/User.php');
    require_once($config->path->entities . '/Language.php');
    require_once($config->path->entities . '/Group.php');
    require_once('UserPasswordGenerator.php');
    require_once('Page.php');
    

    /* Initialize properties */
    $userPassGen = LoginForm\Includes\UserPasswordGenerator::getInstance();
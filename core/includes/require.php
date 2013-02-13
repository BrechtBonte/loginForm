<?php
    session_start();

    /* Requires */
    require_once('core/includes/Config.php');
    
    /* Zend AutoLoader */
    require_once('Zend/Loader/Autoloader.php');
    $autoloader = Zend_Loader_Autoloader::getInstance();

    /* Twig Autoloader */
    require_once('Twig/Autoloader.php');
    Twig_Autoloader::Register();
    
    require_once('Template.php');
    require_once('User.php');
    require_once('UserMysqlDatastore.php');
    require_once('UserPasswordGenerator.php');
    require_once('Page.php');

    /* Initialize properties */
    $userDatastore = UserMysqlDatastore::getInstance();
    $userPassGen = UserPasswordGenerator::getInstance();
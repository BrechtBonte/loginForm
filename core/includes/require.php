<?php
    session_start();

    /* Requires */
    require_once('core/includes/Config.php');
    
    /* AutoLoader */
    require_once('autoload.php');
    require_once('User.php');
    require_once('UserMysqlDatastore.php');
    require_once('UserPasswordGenerator.php');
    require_once('Page.php');

    /* Initialize properties */
    $userDatastore = UserMysqlDatastore::getInstance();
    $userPassGen = UserPasswordGenerator::getInstance();
<?php
    session_start();

    /* Requires */
    require_once('core/includes/Config.php');
    
    /* Zend AutoLoader */
    require_once('Zend/Loader/Autoloader.php');
    $autoloader = Zend_Loader_Autoloader::getInstance();
    
    require_once('Template.php');
    require_once('User.php');

    /* Initialize datastore */
    $userDatastore = UserMysqlDatastore::getInstance();

?>

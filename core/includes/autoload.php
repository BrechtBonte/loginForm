<?php
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . ZEND_LIB);

$loader = require_once(VENDOR . '/autoload.php');
$loader->add('Zend', ZEND_LIB);
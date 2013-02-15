<?php

// Zend
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . APLICATION_PATH . 'core/vendor/marlon-be/zend-framework/library');

$loader = require_once(APLICATION_PATH . 'core/vendor/autoload.php');
$loader->add('Zend', APLICATION_PATH . 'core/vendor/marlon-be/zend-framework/library');
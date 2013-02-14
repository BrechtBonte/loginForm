<?php
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . __DIR__ . '/../../vendor/marlon-be/zend-framework/library');

$loader = require_once(__DIR__ . '/../../vendor/autoload.php');
$loader->add('Zend', __DIR__ . '/../../vendor/marlon-be/zend-framework/library');
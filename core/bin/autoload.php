<?php

// Zend
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . APLICATION_PATH . 'core/vendor/marlon-be/zend-framework/library');

$loader = require_once(APLICATION_PATH . 'core/vendor/autoload.php');
$loader->add('Zend', APLICATION_PATH . 'core/vendor/marlon-be/zend-framework/library');

// Config
$config = new Zend_Config_Ini(APLICATION_PATH . 'core/config/config.ini', 'testing');
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . $config->path->includes);

// Doctrine
$em = require_once(APLICATION_PATH . 'core/bin/loadDoctrine.php');
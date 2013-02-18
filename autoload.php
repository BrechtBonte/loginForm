<?php

$loader = require_once(APLICATION_PATH . 'vendor/autoload.php');

// set include path
set_include_path(
        get_include_path() . PATH_SEPARATOR .
        APLICATION_PATH . 'vendor/marlon-be/zend-framework/library' . PATH_SEPARATOR .
        APLICATION_PATH . 'core/entities'
);

$loader->setUseIncludePath(true);
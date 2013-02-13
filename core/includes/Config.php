<?php
/* 
 * This file contains configurable variables.
 */

    /* Database variables */

    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', 'B00nt33');
    define('DB_DB', 'loginform');


    /* Path variables */

    define('INCLUDES', __DIR__);
    define('CORE', INCLUDES . '/..');
    define('TEMPLATES', CORE . '/layout');
    define('LIBRARY', CORE . '/../library');

    define('MAINTPL', TEMPLATES . '/general/main.tpl');

    /* set include paths */
    ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . INCLUDES);
    ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . LIBRARY);


?>

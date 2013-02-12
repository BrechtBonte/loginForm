<?php
    session_start();

    /* Requires */
    require_once('core/includes/Config.php');
    require_once('core/includes/Template.php');
    require_once('core/includes/User.php');

    /* redir checks */
    if(!isset($_SESSION['userId']) || !User::exists($_SESSION['userId'])) {
        header('location: login.php');
        exit(0);
    }

    /* variables */

    /* Load template */
    $mainTpl = Template::getInstance(MAINTPL);
    $pageTpl = Template::getInstance(TEMPLATES . '/index.tpl');



    /* parse template */

        /* main template */
        $mainTpl->setVar('title', 'index');


        /* finalize */
        $mainTpl->setVar('content', $pageTpl->getContent());
        echo $mainTpl->getContent();
?>
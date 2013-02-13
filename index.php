<?php
    require_once('core/includes/require.php');

    /* redir checks */
    if(!isset($_SESSION['userId']) || !User::exists($_SESSION['userId'])) {
        header('location: login.php');
        exit(0);
    }

    /* variables */
    $users = User::getAll();
    $user = User::getUserById($_SESSION['userId']);
    $username = $user->getName();

    /* Load template */
    $mainTpl = Template::getInstance(MAINTPL);
    $pageTpl = Template::getInstance(TEMPLATES . '/index.tpl');


    /* build strings */
    $usersString = '';
    foreach($users as $usr) {
        $usersString .= sprintf("<div>%s</div>\n", $usr->getName());
    }



    /* parse template */

        /* main template */
        $mainTpl->setVar('title', 'index');

        /* page template */
        $pageTpl->setVar('username', $username);
        $pageTpl->setVar('users', $usersString);


        /* finalize */
        $mainTpl->setVar('content', $pageTpl->getContent());
        echo $mainTpl->getContent();
?>
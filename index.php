<?php
    require_once('core/includes/require.php');

    /* redir checks */
    if(!isset($_SESSION['userId']) || !$userDatastore->userExists($_SESSION['userId'])) {
        header('location: login.php');
        exit(0);
    }

    /* variables */
    $users = $userDatastore->getAll();
    $user = $userDatastore->getUserById($_SESSION['userId']);
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
        $pageTpl->setVars(array(
            'username'  => $username,
            'users'     => $usersString
        ));


        /* finalize */
        $mainTpl->setVar('content', $pageTpl->getContent());
        echo $mainTpl->getContent();
?>
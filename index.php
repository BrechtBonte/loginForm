<?php
    require_once('core/includes/require.php');

    /* redir checks */
    if(!isset($_SESSION['userId']) || !$em->find('LoginForm\Users\User', $_SESSION['userId'])) {
        header('location: login.php');
        exit(0);
    }

    /* variables */
    $users = $em->getRepository('LoginForm\Users\User')->findAll();
    $user = $em->find('LoginForm\Users\User', $_SESSION['userId']);
    $username = $user->getName();

    /* Load page */
    $page = new Page('index');
    
    /* parse template */
    $page->setVars(array(
        'username'  => $username,
        'users'     => $users
    ));

    echo $page->render();
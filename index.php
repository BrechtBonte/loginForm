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

    /* Load page */
    $page = new Page('index');
    
    /* parse template */
    $page->setVars(array(
        'username'  => $username,
        'users'     => $users
    ));

    echo $page->render();
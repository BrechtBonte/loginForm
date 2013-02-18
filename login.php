<?php
    require_once('core/includes/require.php');
    
    /* get repo's */
    $userRep = $em->getRepository('LoginForm\Users\User');

    /* redir checks */
    if(isset($_SESSION['userId']) && $em->find('LoginForm\Users\User', $_SESSION['userId'])) {
        header('location: index.php');
        exit(0);
    }


    /* Variables */
    $username = isset($_POST['txtName'])? $_POST['txtName'] : '';
    $errName = '';
    $errPass = '';

    /* Load template */
    $page = new LoginForm\Includes\Page('login');

    /* Actions */
    if(isset($_POST['submit'])) {
        $allOk = true;

        $password = $_POST['txtPass'];

        if($username == '') {
            $errName = 'Please enter a username';
            $allOk = false;
        }

        if($password == '') {
            $errPass = 'Please enter a password';
            $allOk = false;
        }

        if($allOk) {
            if(!$userRep->findByName($username)) {
                $errName = 'There is no user with this username';
            } else {
                $user = $userRep->findOneByName($username);

                if(!$userPassGen->checkPass($user, $password)) {
                    $errPass = 'This password is not right for the specified user';
                    
                } else {
                    $_SESSION['userId'] = $user->getId();
                    header('location: index.php');
                }
            }
        }

    }


    /* parse template */
    $page->setVars(array(
        'action'        => $_SERVER['PHP_SELF'],
        'username'      => htmlentities($username),
        'errUsername'   => $errName,
        'errPass'       => $errPass
    ));

    echo $page->render();
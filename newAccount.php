<?php
    require_once('core/includes/require.php');

    /* redir checks */
    if(!isset($_SESSION['userId']) || !$userDatastore->userExists($_SESSION['userId'])) {
        header('location: login.php');
        exit(0);
    }

    /* variables */
    $username = isset($_POST['txtName'])? $_POST['txtName'] : '';
    $errName = '';
    $errPass = '';
    $errRePass = '';

    /* Load template */
    $mainTpl = Template::getInstance(MAINTPL);
    $pageTpl = Template::getInstance(TEMPLATES . '/newAccount.tpl');



    /* Actions */
    if(isset($_POST['submit'])) {
        $allOk = true;

        $pass = $_POST['txtPass'];
        $repass = $_POST['txtRePass'];

        if($username == '') {
            $errName = 'Please fill in a username';
            $allOk = false;

        } else {
            if(strlen($username) > 20) {
                $errName = 'Please limit your username to 20 characters';
                $allOk = false;
            } else {
                if($userDatastore->usernameExists($username)) {
                    $errName = 'this username is already taken';
                    $allOk = false;
                }
            }
        }

        if($pass == '') {
            $errPass = 'Please fill in a password';
            $allOk = false;
        } else {
            if(strlen($pass) > 12) {
                $errPass = 'Please limit your password to 12 characters';
                $allOk = false;
            } else {
                if($repass == '') {
                    $errRePass = 'Please re-enter the password';
                    $allOk = false;
                } else  {
                    if($pass != $repass) {
                        $errPass = 'The passwords did not match';
                        $allOk = false;
                    }
                }
            }
        }

        if($allOk) {
            $userDatastore->addUser($username, $pass);
            header('location: index.php');
            exit(0);
        }
    }




    /* parse template */

        /* main template */
        $mainTpl->setVar('title', 'add new account');

        /* page template */
        $pageTpl->setVars(array(
            'action'        => $_SERVER['PHP_SELF'],
            'username'      => $username,
            'errUsername'   => $errName,
            'errPass'       => $errPass,
            'errRePass'     => $errRePass
        ));


        /* finalize */
        $mainTpl->setVar('content', $pageTpl->getContent());
        echo $mainTpl->getContent();
?>
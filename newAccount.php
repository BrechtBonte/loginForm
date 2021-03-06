<?php
    require_once('core/includes/require.php');

    /* redir checks */
//    if(!isset($_SESSION['userId']) || !$em->find('LoginForm\Users\User', $_SESSION['userId'])) {
//        header('location: login.php');
//        exit(0);
//    }

    /* variables */
    $username = isset($_POST['txtName'])? $_POST['txtName'] : '';
    $errName = '';
    $errPass = '';
    $errRePass = '';

    /* Load template */
    $page = new LoginForm\Includes\Page('newAccount');



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
                if($em->getRepository('LoginForm\Users\User')->findByName($username)) {
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
            list($password, $salt) = $userPassGen->encrypt($pass);
            $em->persist(new LoginForm\Users\User($username, $password, $salt));
            $em->flush();
            header('location: index.php');
            exit(0);
        }
    }

    /* parse template */
    $page->setVars(array(
        'action'        => $_SERVER['PHP_SELF'],
        'username'      => $username,
        'errUsername'   => $errName,
        'errPass'       => $errPass,
        'errRePass'     => $errRePass
    ));

    echo $page->render();
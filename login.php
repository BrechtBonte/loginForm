<?php
    session_start();

    /* Requires */
    require_once('core/includes/Config.php');
    require_once('core/includes/Template.php');
    require_once('core/includes/User.php');

    /* redir checks */
    if(isset($_SESSION['userId'])) {
        header('location: index.php');
        exit(0);
    }


    /* Variables */
    $username = isset($_POST['txtName'])? $_POST['txtName'] : '';
    $errName = '';
    $errPass = '';

    /* Load template */
    $mainTpl = Template::getInstance(MAINTPL);
    $pageTpl = Template::getInstance(TEMPLATES . '/login.tpl');



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
            if(!User::checkName($username)) {
                $errName = 'There is no user with this username';
            } else {
                $user = User::getUserByName($username);

                if(!$user->checkPass($password)) {
                    $errPass = 'This password is not right for the specified user';
                } else {
                    $_SESSION['userId'] = $user->id;
                    header('location: index.php');
                }
            }
        }

    }


    /* parse template */

        /* main template */
        $mainTpl->setVar('title', 'login');

        /* Page templte */
        $pageTpl->setVar('action', $_SERVER['PHP_SELF']);
        $pageTpl->setVar('username', htmlentities($username));
        $pageTpl->setVar('errUsername', $errName);
        $pageTpl->setVar('errPass', $errPass);

        /* finalize */
        $mainTpl->setVar('content', $pageTpl->getContent());
        echo $mainTpl->getContent();
?>

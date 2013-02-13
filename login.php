<?php
    require_once('core/includes/require.php');

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
            if(!$userDatastore->usernameExists($username)) {
                $errName = 'There is no user with this username';
            } else {
                $user = $userDatastore->getUserByName($username);

                if(!$userDatastore->checkPass($user, $password)) {
                    $errPass = 'This password is not right for the specified user';
                    
                } else {
                    $_SESSION['userId'] = $user->getId();
                    header('location: index.php');
                }
            }
        }

    }


    /* parse template */

        /* main template */
        $mainTpl->setVar('title', 'login');

        /* Page templte */
        $pageTpl->setVars(array(
            'action'        => $_SERVER['PHP_SELF'],
            'username'      => htmlentities($username),
            'errUsername'   => $errName,
            'errPass'       => $errPass
        ));

        /* finalize */
        $mainTpl->setVar('content', $pageTpl->getContent());
        echo $mainTpl->getContent();
?>

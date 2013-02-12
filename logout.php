<?php
    session_start();

    unset($_SESSION['userId']);
    header('location: login.php');
    exit(0);
?>

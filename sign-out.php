<?php

session_start();
if (!isset($_SESSION['EXPIRES']) || $_SESSION['EXPIRES'] < time()+3600) {
    session_destroy();
    unset($_SESSION['id']);
    $_SESSION = array();
    header('location:sign-in.php');
}
$_SESSION['EXPIRES'] = time() + 3600;
unset($_SESSION['id']);
// echo $_SESSION['id'];
// header('location:sign-in.php');
?>
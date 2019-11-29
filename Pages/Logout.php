<?php
session_start();
unset($_SESSION['LoginUserID']);
unset($_SESSION['LoginUserName']);
session_destroy();
header('Location:../index.php');
?>
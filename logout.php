<?php
//PUT THIS HEADER ON TOP OF EACH UNIQUE PAGE
session_start();
ob_start();
if (!isset($_SESSION['username'])) {
    header("location:login.php");
}
?>

<?php

    session_destroy();
    unset($_SESSION['username']);
    //header("location:login.php");

    printf("You are now logged out.<br>");
    printf("<br><a href=login.php>Return to login page.</a>");
?>

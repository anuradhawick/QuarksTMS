<?php
/*
  if the login variable are set the user will be directed to the home page
  else the user will be directed back to the login page
 */
session_start();
if (isset($_SESSION['qis_logged']) && $_SESSION['qis_logged'] == true) {
    header('Location: my/');
}
?>

<!DOCTYPE html>
<!-- 
Coded by W.A. Anuradha Wickramarachchi
-->
<html>
    <head>
        <title>Training management system</title>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/ver-center.js"></script>
        <link rel="stylesheet" type="text/css" href="/css/basic.css">
        <?php //require 'loader.php'; ?>
        <script type="text/javascript" src="/js/loader.js"></script>
        <link rel="stylesheet" type="text/css" href="css/default.css">
    </head>
    <body>
        <?php require 'header.php'; ?>
        <?php require 'login.php'; ?>
        <?php require 'footer.php'; ?>
    </body>
</html>
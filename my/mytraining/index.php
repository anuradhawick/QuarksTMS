<!DOCTYPE html>
<html>
    <head>
        <title>Training management system</title>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../../js/ver-center.js"></script>
        <link rel="stylesheet" type="text/css" href="../../css/default.css">
    </head>
    <body>
        <?php require '../navbar.php'; ?>
        <?php
        if (isset($_REQUEST['pg']) && $_REQUEST['pg'] == 'history') {
            require 'history.php';
        } elseif (isset($_REQUEST['pg']) && $_REQUEST['pg'] == 'pending') {
            require 'pending.php';
        } elseif (isset($_REQUEST['pg']) && $_REQUEST['pg'] == 'selected') {
            require 'selected.php';
        } elseif (isset($_REQUEST['pg']) && $_REQUEST['pg'] == 'request') {
            require 'request.php';
        } elseif (isset($_REQUEST['pg']) && $_REQUEST['pg'] == 'upcom') {
            require 'upcoming.php';
        } else {
            echo "Please check the link and try again, or contact administrator";
        }
        ?>
        <?php require '../../footer.php'; ?>
    </body>
</html>
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
        if (isset($_REQUEST['pg']) && $_REQUEST['pg'] == 'view') {
            require 'view.php';
        } elseif (isset($_REQUEST['pg']) && $_REQUEST['pg'] == 'edit') {
            require 'edit.php';
        } else {
            require 'view.php';
        }
        ?>
        <?php require '../../footer.php'; ?>
    </body>
</html>
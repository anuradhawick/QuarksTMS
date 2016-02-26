<!DOCTYPE html>
<html>
    <head>
        <title>Quarks TMS</title>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../../css/default.css">
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src="/quarks/js/ver-center.js"></script>
    </head>
    <body>
        <?php require '../navbar.php'; ?>
        <div class="container">
            <?php
            if (isset($_GET['pg']) && $_GET['pg'] == 'grant') {
                require 'grant.php';
            } elseif(isset($_GET['pg']) && $_GET['pg'] == 'approve') {
                require 'approve.php';
            } elseif(isset($_GET['pg']) && $_GET['pg'] == 'setup') {
                require 'setup.php';
            } elseif(isset($_GET['pg']) && $_GET['pg'] == 'log') {
                require 'log.php';
            } else {
                require 'addusers.php';
            }
            ?>
        </div>
        <?php require '../../footer.php'; ?>
    </body>
</html>
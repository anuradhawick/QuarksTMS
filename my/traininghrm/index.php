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
    </head>
    <body>
        <?php require '../navbar.php'; ?>
        <div class="container">
            <?php
            if (isset($_GET['pg']) && $_GET['pg'] == 'attendance') {
                /*
                  Page that confirms attendance
                 */
                require 'attendance.php';
            } elseif (isset($_GET['pg']) && $_GET['pg'] == 'enrolments') {
                /*
                  Page that display enrolments
                 */
                require 'enrolments.php';
            } elseif (isset($_GET['pg']) && $_GET['pg'] == 'selected_users') {
                /*
                  Page that display selected users for a particular training program
                 */
                require 'selected_users.php';
            } else if(isset($_GET['pg']) && $_GET['pg'] == 'view_history'){
                /*
                  Page to show training history in common
                */
                require 'hr_history.php';            
            } else {
                /*
                  Page that approve enrolments
                 */
                require 'approve.php';
            }
            ?>
        </div>
        <?php require '../../footer.php'; ?>
    </body>
</html>
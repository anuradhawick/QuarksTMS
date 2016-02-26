<?php
/*
  Checks for the session and if not redirect to the login screen
 */
if (session_id() == '') {
    session_start();
}
if (!isset($_SESSION['qis_logged']) || !$_SESSION['qis_logged'] == true) {
    header('Location: /quarks/');
}
?>
<style type="text/css">
    .navbar{
        border-radius: 0px;
    }
    body{
        margin-top: 70px;
    }
</style>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $(document).on('click', "#logout", function (event) {
            event.preventDefault();
            $.post('/quarks/controller/authentication/logout.php', function (data, textStatus, xhr) {
                if ($.parseJSON(data) == true) {
                    location.reload();
                }
                ;
            });
        });
    });
</script>
<?php
$emp_number = $_SESSION['qis_emp'];
require_once dirname(__FILE__) . '/../API/admin/AccessPrivilegeDBHandler.php';
$emp = new Employee();
$emp->setEmpNumber($emp_number);
$arr = AccessPrivilegeDBHandler::getAllUseCases($emp);
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="http://quarksis.com" target="_blank" data-toggle="tooltip" title="Visit our web site">Quarks TMS</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li class=""><a href="/quarks/">Home</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">My details 
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/quarks/my/mydetails?pg=view">Personal details</a></li>
                        <li><a href="/quarks/my/mydetails?pg=edit">Update details</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">My training
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/quarks/my/mytraining?pg=history">Training history</a></li>
                        <li><a href="/quarks/my/mytraining?pg=pending">Pending training</a></li>
                        <li><a href="/quarks/my/mytraining?pg=selected">View selected training</a></li>
                        <li><a href="/quarks/my/mytraining?pg=upcom">Upcoming training</a></li>
                        <li><a href="/quarks/my/mytraining?pg=request">Request training</a></li>
                    </ul>
                </li>
                <?php
                if (in_array(1, $arr)) {
//                    echo 'true';
                    ?>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">Post new training
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/quarks/my/posttraining?ty=1">In-house</a></li>
                            <li><a href="/quarks/my/posttraining?ty=2">Local</a></li>
                            <li><a href="/quarks/my/posttraining?ty=3">Foreign</a></li>
                        </ul>
                    </li>
                    <?php
                }
                if (in_array(2, $arr) || in_array(3, $arr) || in_array(4, $arr) || in_array(5, $arr) || in_array(11, $arr)) {
//                    echo 'true';
                    ?>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">Training HRM
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <?php
                            if (in_array(2, $arr)) {
//                                echo 'true';
                                ?>
                                <li><a href="/quarks/my/traininghrm?pg=attendance">Confirm attendance</a></li>
                                <?php
                            }
                            if (in_array(3, $arr)) {
//                                echo 'true';
                                ?>
                                <li><a href="/quarks/my/traininghrm?pg=enrolments">View enrolments</a></li>
                                <?php
                            }
                            if (in_array(4, $arr)) {
//                                echo 'true';
                                ?>
                                <li><a href="/quarks/my/traininghrm?pg=selected_users">View selected users</a></li>
                                <?php
                            }
                            if (in_array(5, $arr)) {
//                                echo 'true';
                                ?>
                                <li><a href="/quarks/my/traininghrm?pg=approve">Approve training enrolments</a></li>
                                <?php
                            }
                            if (in_array(11, $arr)) {
//                                echo 'true';
                                ?>
                                <li><a href="/quarks/my/traininghrm?pg=view_history">View training history</a></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </li>
                    <?php
                }
                if (in_array(6, $arr) || in_array(7, $arr) || in_array(8, $arr) || in_array(9, $arr) || in_array(10, $arr)) {
                    ?>

                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">Administration
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <?php
                            if (in_array(6, $arr)) {
                                ?>

                                <li><a href="/quarks/my/admin?pg=approve">Approve training programs</a></li>
                                <?php
                            }
                            if (in_array(7, $arr)) {
                                ?>
                                <li><a href="/quarks/my/admin?pg=grant">Grant permission</a></li>
                                <?php
                            }
                            if (in_array(8, $arr)) {
                                ?>
                                <li><a href="/quarks/my/admin?pg=setup">Setup training categories</a></li>
                                <?php
                            }
                            if (in_array(9, $arr)) {
                                ?>
                                <li><a href="/quarks/my/admin?pg=add">Add users</a></li>
                                <?php
                            }
                            if (in_array(10, $arr)) {
                                ?>
                                <li><a href="/quarks/my/admin?pg=log">View log</a></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a id="logout" onclick="logout();" href="javascript:void(0);"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- For modals to be displayed -->
<div id="modal_handler">

</div>
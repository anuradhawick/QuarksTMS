<!DOCTYPE html>
<html>
    <head>
        <title>Training management system</title>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/ver-center.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/default.css">
        <link rel="stylesheet" type="text/css" href="../css/w3.css">
    </head>
    <body>
        <?php
        require 'navbar.php';
        ?>
        <?php
        require_once './../API/employee/Employee.php';
        require_once './../API/employee/DatabaseHandler/EmployeeDBHandler.php';
        $emp = EmployeeDBHandler::getEmployeeById($_SESSION['qis_emp']);

        require_once '../API/employee/Workplace.php';
        require_once '../API/employee/DatabaseHandler/WorkplaceDBHandler.php';
        $workplace = WorkplaceDBHandler::getWorkplace($_SESSION['qis_emp']);
        ?>
        <div class="container">
            <div class="col-sm-12 well">
                <div class="col-sm-4">
                    <img src="../images/Generic_Avatar.png" height="200px" width="200px">
                </div>
                <div class="col-sm-8">
                    <table class="">
                        <tbody>
                            <tr>
                                <td class="col-sm-3">Name:<hr/></td>
                                <td><?php echo $emp->getEmpFirstname() . " " . $emp->getEmpLastname(); ?><hr/></td>        			  
                            </tr>
                            <tr>
                                <td class="col-sm-3">Nic:<hr/></td>
                                <td><?php echo $emp->getEmpNicNo(); ?><hr/></td>
                            </tr>
                            <tr>
                                <td class="col-sm-3">Birth day:<hr/></td>
                                <td><?php echo $emp->getEmpBirthday(); ?><hr/></td>
                            </tr>
                            <tr>
                                <td class="col-sm-3">Workplace:<hr/></td>
                                <td><?php echo $workplace->getWorkplaceName(); ?><hr/></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-4 well" style="height: 400px">
                <h4>Up coming training</h4>
                <hr/>
                <blockquote>
                    <p>Now you can view upcoming training programs</p>
                    <?php
                    require_once '../API/traininghrm/TrainingHRMDBHandler.php';
                    if (session_id() == '') {
                        session_start();
                    }
                    $arr = TrainingHRMDBHandler::getUpComingTraining($emp_number);
                    $arr = array_reverse($arr);
                    $i = 0;
                    foreach ($arr as $tp) {
                        $i++;
                        if ($i > 2) {
                            break;
                        }
                        ?>
                        <ul>
                            <li>
                                <p>Name: <span><?php echo $tp[1]; ?></span></p>                                
                                <p>Type: <span><?php echo $tp[6]; ?></span></p>                                
                            </li>
                        </ul>

                        <?php
                    }
                    ?>
                </blockquote>
                <!-- <a class="btn btn-default btn-block" href='mytraining/?pg=upcom'>Goto page</a> -->

            </div>
            <div class="col-sm-4 well" style="height: 400px">
                <h4>Selected training</h4>
                <hr/>
                <blockquote>
                    <p>View your selected training</p>
                    <?php
//            require_once '../../controller/mytraining/selectedTraining.php';
                    require_once '../API/training/DBClasses/TrainingDBHandler.php';
                    require_once '../API/employee/Employee.php';
                    if (session_id() == '') {
                        session_start();
                    }
                    $empnum = $_SESSION['qis_emp'];
                    $employee = new Employee();
                    $employee->setEmpNumber($empnum);
                    $trainingarray = TrainingDBHandler::getEmployeeSelectedTraining($employee);
                    $i = 0;
                    foreach (array_reverse($trainingarray) as $arr) {
                        $i++;
                        if ($i > 2) {
                            break;
                        }
                        $idtraining = $arr[0];
                        $name = $arr[1];
                        $conducting_auth = $arr[2];
                        $idduration = $arr[4];
                        $from = $arr[5];
                        $to = $arr[6];
                        $no_of_days = $arr[7];
                        ?>
                        <ul>
                            <li>
                                <p>Name: <span><?php echo $name ?></span></p>                                
                                <p>Authority: <span><?php echo $conducting_auth; ?></span></p>                                
                            </li>
                        </ul>  
                        <?php
                    }
                    ?>                              
                </blockquote>
                <!-- <a class="btn btn-default btn-block" href='mytraining/?pg=request'>Goto page</a> -->
            </div>
            <div class="col-sm-4 well" style="height: 400px">
                <h4>View training history</h4>
                <hr/>
                <blockquote>
                    <p>Now you can view your training history</p>
                    <?php
                    require_once '../API/traininghrm/TrainingHRMDBHandler.php';
                    if (session_id() == '') {
                        session_start();
                    }
                    $emp_number = $_SESSION['qis_emp'];
                    $arr = TrainingHRMDBHandler::getTrainingHistoryAsStrings($emp_number);
                    $arr = array_reverse($arr);
                    $i = 0;
                    foreach ($arr as $value) {
                        if ($i > 4) {
                            break;
                        }
                        ?>
                        <ul>
                            <li>
                                <p>Name: <span><?php echo $value[1] ?></span></p>                                                 
                            </li>
                        </ul>  
                        <?php
                    }
                    ?>
                </blockquote>
                <!-- <a class="btn btn-default btn-block" href='mytraining/?pg=history'>Goto page</a> -->
            </div>
        </div>
        <?php require '../footer.php'; ?>
    </body>
</html>
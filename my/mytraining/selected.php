<div class="container">
    <div class="col-sm-12 well">
        <h4>Selected training</h4>
    </div>
    <div class="col-sm-12 well">
        <table class="table table-striped">
            <thead>
                <tr>
                    <!-- date, name, type, authority -->
                    <th class="col-sm-2">Name</th>
                    <th class="col-sm-2">Details</th>
                    <th class="col-sm-8"></th>
                </tr>
            </thead>
            <tbody id="history">
                <?php
//            require_once '../../controller/mytraining/selectedTraining.php';
                require_once '../../API/training/DBClasses/TrainingDBHandler.php';
                require_once '../../API/employee/Employee.php';
                if (session_id() == '') {
                    session_start();
                }
                $empnum = $_SESSION['qis_emp'];
                $employee = new Employee();
                $employee->setEmpNumber($empnum);
                $trainingarray = TrainingDBHandler::getEmployeeSelectedTraining($employee);
                foreach ($trainingarray as $arr) {
                    $idtraining = $arr[0];
                    $name = $arr[1];
                    $conducting_auth = $arr[2];
                    $idduration = $arr[4];
                    $from = $arr[5];
                    $to = $arr[6];
                    $no_of_days = $arr[7];

                    if ($arr[3] == 0) {
                        //This block is belong to local foreign training
                        $country = $arr[11];
//                        echo $idtraining . " " . $name . " " . $conducting_auth . " " . $idduration . " " . $from . " " . $to . " " . $no_of_days . " " . $country;
                        ?>
                        <tr>
                            <td>Foreign training</td>
                            <td>Name</td>
                            <td><?php echo $name; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Conducting authority</td>
                            <td><?php echo $conducting_auth; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Duration: from</td>
                            <td><?php echo $from; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Duration: to</td>
                            <td><?php echo $to; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>No. of days</td>
                            <td><?php echo $no_of_days; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Country</td>
                            <td><?php echo $country; ?></td>
                        </tr>
                        
                        <?php
                    } else if ($arr[3] == 1) {
                        //This block  belong to local training
                        $place = $arr[9];
                        $location_address = $arr[10];
//                        echo $idtraining . " " . $name . " " . $conducting_auth . " " . $idduration . " " . $from . " " . $to . " " . $no_of_days . " " . $place . " " . $location_address;
                    
                        ?>
                        <tr>
                            <td>Local training</td>
                            <td>Name</td>
                            <td><?php echo $name; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Conducting authority</td>
                            <td><?php echo $conducting_auth; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Duration: from</td>
                            <td><?php echo $from; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Duration: to</td>
                            <td><?php echo $to; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>No. of days</td>
                            <td><?php echo $no_of_days; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Place</td>
                            <td><?php echo $place; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Address</td>
                            <td><?php echo $location_address; ?></td>
                        </tr>
                        
                        <?php
                    } else {
                        //This block belongs to inhouse training
                        $location = $arr[8];
//                        echo $idtraining . " " . $name . " " . $conducting_auth . " " . $idduration . " " . $from . " " . $to . " " . $no_of_days . " " . $location;
                    
                        ?>
                        <tr>
                            <td>In-house training</td>
                            <td>Name</td>
                            <td><?php echo $name; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Conducting authority</td>
                            <td><?php echo $conducting_auth; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Duration: from</td>
                            <td><?php echo $from; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Duration: to</td>
                            <td><?php echo $to; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>No. of days</td>
                            <td><?php echo $no_of_days; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Location</td>
                            <td><?php echo $location; ?></td>
                        </tr>
                        
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
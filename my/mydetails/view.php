<?php
require_once '../../API/employee/Employee.php';
require_once '../../API/employee/DatabaseHandler/EmployeeDBHandler.php';
$emp = new Employee();
$emp = EmployeeDBHandler::getEmployeeById($_SESSION['qis_emp']);

require_once '../../API/employee/Workplace.php';
require_once '../../API/employee/DatabaseHandler/WorkplaceDBHandler.php';
$workplace = WorkplaceDBHandler::getWorkplace($_SESSION['qis_emp']);
?>
<div class="container" >
    <div class="col-sm-12 well">
        <div class="col-sm-4">
            <img src="../../images/Generic_Avatar.png" height="200px" width="200px">
        </div>
        <div class="col-sm-8">
            <table class="">
                <tbody>
                    <tr>
                        <td class="col-sm-3">First name:<hr/></td>
                        <td><?php echo $emp->getEmpFirstname(); ?><hr/></td>        			  
                    </tr>
                    <tr>
                        <td class="col-sm-3">Last name:<hr/></td>
                        <td><?php echo $emp->getEmpLastname(); ?><hr/></td>        			  
                    </tr>				      	
                    <tr>
                        <td class="col-sm-3">Birth day:<hr/></td>
                        <td><?php echo $emp->getEmpBirthday(); ?><hr/></td>
                    </tr>
                    <tr>
                        <td class="col-sm-3">Nic:<hr/></td>
                        <td><?php echo $emp->getEmpNicNo(); ?><hr/></td>
                    </tr>
                    <tr>
                        <td class="col-sm-3">Nic date:<hr/></td>
                        <td><?php echo $emp->getEmpNicDate();?><hr/></td>
                    </tr>
                    <tr>
                        <td class="col-sm-3">Gender:<hr/></td>
                        <td><?php echo $emp->getEmpGender();?><hr/></td>
                    </tr>
                    <tr>
                        <td class="col-sm-3">Work place:<hr/></td>
                        <td><?php echo $workplace->getWorkplaceName();?><hr/></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
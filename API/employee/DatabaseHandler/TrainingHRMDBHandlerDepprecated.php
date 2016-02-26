<?php

/*
 * ***** Coded by D. R. ATAPATTU *****
 */
require_once dirname(__FILE__) . '/../../Constants/DatabaseCredentials.php';
require_once dirname(__FILE__) . '/../Employee.php';
require_once dirname(__FILE__) . '/../../training/TrainingProgram.php';


require_once dirname(__FILE__) . '/../../Constants/DatabaseCredentials.php';
require_once dirname(__FILE__) . '/../../employee/Employee.php';
require_once dirname(__FILE__) . '/../../training/LocalTraining.php';
require_once dirname(__FILE__) . '/../../training/InhouseTraining.php';
require_once dirname(__FILE__) . '/../../training/ForeignTraining.php';
require_once dirname(__FILE__) . '/../../training/ExternalTrainer.php';
require_once dirname(__FILE__) . '/../../training/Duration.php';

class TrainingHRMDBHandler {

    public static function enrollForTaining($employee, $training) {
        $enrol_staus = 0;
        $completed_percentage = 0;
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Database connection failed. " . $conn->connect_error);
        } else {
            $stmt = $conn->prepare("INSERT INTO enrol_training (enrol_staus, idtraining, emp_number, completed_percentage) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiii", $enrol_staus, $training->getIdTraining(), $employee->getEmpNumber(), $completed_percentage);
            $stmt->execute();
            $stmt->close();
        }
        $conn->close();
    }

    public static function respondToTraining($employee, $training, $response) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Database connection failed. " . $conn->connect_error);
        } else {
            $stmt = $conn->prepare("UPDATE enrol_training SET `enrol_staus`=? WHERE idtraining=? AND emp_number=?");
            $stmt->bind_param("iii", $response, $training->getIdTraining(), $employee->getEmployeeId());
            $stmt->execute();
            $stmt->close();
        }
        $conn->close();
    }

    public static function getTrainingHistory($employee) {
        $trainingPrograms = array();
        $emp_number = $employee->getEmpNumber();
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Database connection failed. " . mysqli_error($dbc));
        $query = "SELECT `idtraining` FROM `enrol_training` WHERE `emp_number`='$emp_number' AND `completed_percentage`=100;";
        $result_all_trainings = mysqli_query($dbc, $query) or die("Get training enrollment from DB failed. " . mysqli_error($dbc));

        while ($row_all_trainings = mysqli_fetch_row($result_all_trainings)) {
            $query = "SELECT * FROM `training_program` WHERE `idtraining`='$row_all_trainings[0]]' AND `approval`=3;";
            $result_approved_trainings = mysqli_query($dbc, $query) or die("Get training program from DB failed. " . mysqli_error($dbc));
            $row_approved_trainings = mysqli_fetch_array($result_approved_trainings);

            $idtraining = $row_approved_trainings['idtraining'];
            if ($row_training['main_program_type'] = 0) {
//                Foreign trainng     
                $query = "SELECT `country`, `location_address` FROM `foreign_training` WHERE `idforeign_training`='$idtraining';";
                $result_foreign_training = mysqli_query($dbc, $query) or die("Get foreign training program from DB failed. " . mysqli_error($dbc));
                $row_foreign_training = mysqli_fetch_array($result_foreign_training);

                $trainingProgram = new ForeignTraining();
                $trainingProgram->setCountry($row_foreign_training['country']);
                $trainingProgram->setLocationAddress($row_foreign_training['location_address']);
            } elseif ($row_training['main_program_type'] = 1) {
//                Local trainng
                $query = "SELECT `place`, `location_address` FROM `local_training` WHERE `idlocal_training`='$idtraining';";
                $result_local_training = mysqli_query($dbc, $query) or die("Get local training program from DB failed. " . mysqli_error($dbc));
                $row_local_training = mysqli_fetch_array($result_local_training);

                $trainingProgram = new LocalTraining();
                $trainingProgram->setPlace($row_local_training['place']);
                $trainingProgram->setLocationAddress($row_local_training['location_address']);
            } elseif ($row_training['main_program_type'] = 2) {
//                In house training
                $query = "SELECT `location` FROM `inhouse_training` WHERE `idinhouse_training`='$idtraining';";
                $result_inhouse_training = mysqli_query($dbc, $query) or die("Get inhouse training program from DB failed. " . mysqli_error($dbc));
                $row_inhouse_training = mysqli_fetch_array($result_inhouse_training);

                $trainingProgram = new InhouseTraining();
                $trainingProgram->setLocation($row_inhouse_training['location']);
            }

            $trainingProgram->setIdTraining($row_approved_trainings['idtraining']);
            $trainingProgram->setName($row_approved_trainings['name']);
            $trainingProgram->setConductingAuthority($row_approved_trainings['conducting_authority']);
            $trainingProgram->setMainProgramType($row_approved_trainings['main_program_type']);
            $trainingProgram->setTrainerType($row_approved_trainings['trainer_type']);
            $trainingProgram->setLevelOfTraining($row_approved_trainings['idlevel_of_training']);
            $trainingProgram->setMinorCategory($row_approved_trainings['idminor_training']);
            $trainingProgram->setProgramType($row_approved_trainings['idprogram_type']);
            $trainingProgram->setRequirements($row_approved_trainings['requirements']);
            $trainingProgram->setApproval($row_approved_trainings['approval']);
            $trainingProgram->setOtherDetails($row_approved_trainings['other_details']);

            $idtraining = $trainingProgram->getIdTraining();
            if ($trainingProgram->getTrainerType() == 1) {
//                External trainer
                $query = "SELECT external_trainer_assignment.idoutside_trainer, `name`, `qualifications` FROM `external_trainer_assignment` JOIN `external_trainer` ON external_trainer_assignment.idoutside_trainer=external_trainer.idoutside_trainer  WHERE `idtraining`='$idtraining';";
                $result_trainer = mysqli_query($dbc, $query);
                $row_trainer = mysqli_fetch_array($result_trainer);

                $externalTrainer = new ExternalTrainer();
                $externalTrainer->setName($row_trainer['name']);
                $externalTrainer->setQualifications($row_trainer['qualifications']);
                $externalTrainer->setTrainerID($row_trainer['idoutside_trainer']);
                $externalTrainer->setTrainingID($idtraining);

                $trainingProgram->setTrainer($externalTrainer);
            } elseif ($trainingProgram->getTrainerType() == 2) {
//                Internal trainer
                $query = "SELECT * FROM `hs_hr_employee` LEFT JOIN `internal_trainer_assignment` ON hs_hr_employee.emp_number=internal_trainer_assignment.emp_number  WHERE `idtraining`='$idtraining';";
                $result_trainer = mysqli_query($dbc, $query);
                $row_trainer = mysqli_fetch_array($result_trainer);

                $internalTrainer = new Employee();
                $internalTrainer->setEmpNumber($row_trainer['emp_number']);
                $internalTrainer->setEmployeeId($row_trainer['employee_id']);
                $internalTrainer->setEmpLastname($row_trainer['emp_lastname']);
                $internalTrainer->setEmpFirstname($row_trainer['emp_firstname']);
                $internalTrainer->setEmpNicNo($row_trainer['emp_nic_no']);
                $internalTrainer->setEmpNicDate($row_trainer['emp_nic_date']);
                $internalTrainer->setEmpBirthday($row_trainer['emp_birthday']);

                $trainingProgram->setTrainer($internalTrainer);
            }

            $query = "SELECT * FROM `duration` WHERE `idtraining`='$idtraining';";
            $result_duration = mysqli_query($dbc, $query);
            while ($row_duration = mysqli_fetch_array($result_duration)) {
                $duration = new Duration();
                $duration->setIdduration($row_duration['idduration']);
                $duration->setFrom($row_duration['from']);
                $duration->setTo($row_duration['to']);
                $duration->setNoOfDays($row_duration['no_of_days']);
                $duration->setNoOfHours($row_duration['no_of_hours']);
                $duration->setClosingDate($row_duration['closing_date']);
                $duration->setNoOfParticipants($row_duration['no_of_participants']);
                $duration->setSession($row_duration['session']);
                $duration->setIdTraining($row_duration['idtraining']);

                $trainingProgram->setDuration($duration);
            }

            array_push($trainingPrograms, $trainingProgram);
        }

        mysqli_close($dbc);
        return $trainingPrograms;
    }

    public static function getTrainingHistoryAsStrings($emp_number) {
        $trainingPrograms = array();
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Database connection failed. " . mysqli_error($dbc));
        $query = "SELECT `idtraining` FROM `enrol_training` WHERE `emp_number`='$emp_number' AND `completed_percentage`=100;";
        $result_all_trainings = mysqli_query($dbc, $query) or die("Get training enrollment from DB failed. " . mysqli_error($dbc));

        while ($row_all_trainings = mysqli_fetch_row($result_all_trainings)) {
            $training = array();
            $query = "SELECT * FROM `training_program` WHERE `idtraining`='$row_all_trainings[0]]' AND `approval`=3;";
            $result_approved_trainings = mysqli_query($dbc, $query) or die("Get training program from DB failed. " . mysqli_error($dbc));
            $row_approved_trainings = mysqli_fetch_array($result_approved_trainings);

            if (!empty($row_approved_trainings)) {
                $idtraining = $row_approved_trainings['idtraining'];

                $query = "SELECT * FROM `duration` WHERE `idtraining`='$idtraining';";
                $result_duration = mysqli_query($dbc, $query);
                while ($row_duration = mysqli_fetch_array($result_duration)) {
                    array_push($training, $row_duration['from']);
                }

                array_push($training, $row_approved_trainings['name']);

                if ($row_training['main_program_type'] = 0) {
                    array_push($training, 'Foreign Training');
                } elseif ($row_training['main_program_type'] = 1) {
                    array_push($training, 'Local Training');
                } elseif ($row_training['main_program_type'] = 2) {
                    array_push($training, 'In House Training');
                }

                array_push($training, $row_approved_trainings['conducting_authority']);
                array_push($trainingPrograms, $training);
            }
        }
        mysqli_close($dbc);
        return $trainingPrograms;
    }

    public static function getTrainingProgramById($idtraining) {
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Database connection failed. " . mysqli_error($dbc));
        $query = "SELECT * FROM `training_program` WHERE `idtraining`='$idtraining';";
        $result_training = mysqli_query($dbc, $query) or die("Get training program from DB failed. " . mysqli_error($dbc));
        $row_training = mysqli_fetch_array($result_training);

        if ($row_training['main_program_type'] = 0) {
//                Foreign trainng     
            $query = "SELECT `country`, `location_address` FROM `foreign_training` WHERE `idforeign_training`='$idtraining';";
            $result_foreign_training = mysqli_query($dbc, $query) or die("Get foreign training program from DB failed. " . mysqli_error($dbc));
            $row_foreign_training = mysqli_fetch_array($result_foreign_training);

            $trainingProgram = new ForeignTraining();
            $trainingProgram->setCountry($row_foreign_training['country']);
            $trainingProgram->setLocationAddress($row_foreign_training['location_address']);
        } elseif ($row_training['main_program_type'] = 1) {
//                Local trainng
            $query = "SELECT `place`, `location_address` FROM `local_training` WHERE `idlocal_training`='$idtraining';";
            $result_local_training = mysqli_query($dbc, $query) or die("Get local training program from DB failed. " . mysqli_error($dbc));
            $row_local_training = mysqli_fetch_array($result_local_training);

            $trainingProgram = new LocalTraining();
            $trainingProgram->setPlace($row_local_training['place']);
            $trainingProgram->setLocationAddress($row_local_training['location_address']);
        } elseif ($row_training['main_program_type'] = 2) {
//                In house training
            $query = "SELECT `location` FROM `inhouse_training` WHERE `idinhouse_training`='$idtraining';";
            $result_inhouse_training = mysqli_query($dbc, $query) or die("Get inhouse training program from DB failed. " . mysqli_error($dbc));
            $row_inhouse_training = mysqli_fetch_array($result_inhouse_training);

            $trainingProgram = new InhouseTraining();
            $trainingProgram->setLocation($row_inhouse_training['location']);
        }

        $trainingProgram->setIdTraining($row_training['idtraining']);
        $trainingProgram->setName($row_training['name']);
        $trainingProgram->setConductingAuthority($row_training['conducting_authority']);
        $trainingProgram->setMainProgramType($row_training['main_program_type']);
        $trainingProgram->setTrainerType($row_training['trainer_type']);
        $trainingProgram->setLevelOfTraining($row_training['idlevel_of_training']);
        $trainingProgram->setMinorCategory($row_training['idminor_training']);
        $trainingProgram->setProgramType($row_training['idprogram_type']);
        $trainingProgram->setRequirements($row_training['requirements']);
        $trainingProgram->setApproval($row_training['approval']);
        $trainingProgram->setOtherDetails($row_training['other_details']);

        if ($trainingProgram->getTrainerType() == 1) {
//                External trainer
            $query = "SELECT external_trainer_assignment.idoutside_trainer, `name`, `qualifications` FROM `external_trainer_assignment` JOIN `external_trainer` ON external_trainer_assignment.idoutside_trainer=external_trainer.idoutside_trainer  WHERE `idtraining`='$idtraining';";
            $result_trainer = mysqli_query($dbc, $query);
            $row_trainer = mysqli_fetch_array($result_trainer);

            $externalTrainer = new ExternalTrainer();
            $externalTrainer->setName($row_trainer['name']);
            $externalTrainer->setQualifications($row_trainer['qualifications']);
            $externalTrainer->setTrainerID($row_trainer['idoutside_trainer']);
            $externalTrainer->setTrainingID($idtraining);

            $trainingProgram->setTrainer($externalTrainer);
        } elseif ($trainingProgram->getTrainerType() == 2) {
//                Internal trainer
            $query = "SELECT * FROM `hs_hr_employee` LEFT JOIN `internal_trainer_assignment` ON hs_hr_employee.emp_number=internal_trainer_assignment.emp_number  WHERE `idtraining`='$idtraining';";
            $result_trainer = mysqli_query($dbc, $query);
            $row_trainer = mysqli_fetch_array($result_trainer);

            $internalTrainer = new Employee();
            $internalTrainer->setEmpNumber($row_trainer['emp_number']);
            $internalTrainer->setEmployeeId($row_trainer['employee_id']);
            $internalTrainer->setEmpLastname($row_trainer['emp_lastname']);
            $internalTrainer->setEmpFirstname($row_trainer['emp_firstname']);
            $internalTrainer->setEmpNicNo($row_trainer['emp_nic_no']);
            $internalTrainer->setEmpNicDate($row_trainer['emp_nic_date']);
            $internalTrainer->setEmpBirthday($row_trainer['emp_birthday']);

            $trainingProgram->setTrainer($internalTrainer);
        }

        $query = "SELECT * FROM `duration` WHERE `idtraining`='$idtraining';";
        $result_duration = mysqli_query($dbc, $query);
        while ($row_duration = mysqli_fetch_array($result_duration)) {
            $duration = new Duration();
            $duration->setIdduration($row_duration['idduration']);
            $duration->setFrom($row_duration['from']);
            $duration->setTo($row_duration['to']);
            $duration->setNoOfDays($row_duration['no_of_days']);
            $duration->setNoOfHours($row_duration['no_of_hours']);
            $duration->setClosingDate($row_duration['closing_date']);
            $duration->setNoOfParticipants($row_duration['no_of_participants']);
            $duration->setSession($row_duration['session']);
            $duration->setIdTraining($row_duration['idtraining']);

            $trainingProgram->setDuration($duration);
        }
        mysqli_close($dbc);
        return $trainingProgram;
    }

}

?>
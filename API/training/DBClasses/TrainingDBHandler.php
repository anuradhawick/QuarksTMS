<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TrainingDBHandler
 *
 * @author Ravidu
 */
require_once dirname(__FILE__) . '/../../Constants/DatabaseCredentials.php';

class TrainingDBHandler {
    /* This method is used to enter details about a new training program into the database.If the training program is Foreign training MainProgramType
     * should be 0.If Local training then it should be 1 and if training is inhouse training mainProgramType should be 2 
     * main_program_type variable  :- Foreign Training =0
     *                                Local Training = 1
     *                                Inhouse Training = 2
     * approval variable   :-    rejected approval = 0
     *                           approved, attendance not confirmed = 1
     *                           pending approval = 2
     *                           approved, attendance confirmed = 3
     *                           
     * trainer_type variable  :- no trainer assigned= 0
     *                           external trainer assigned= 1
     *                           internal trainer assigned = 2
     */

    public static function postNewTraining(TrainingProgram $training, Duration $duration, $trainerid) {
        $id = 0;
        $name = $training->getName();
        $conducting_authority = $training->getConductingAuthority();
        $trainer_type = $training->getTrainerType();
        $requirements = $training->getRequirements();
        $approval = $training->getApproval();
        $other_details = $training->getOtherDetails();
        $idminor_training = $training->getMinorCategory()->getIdminorTraining();
        $idprogram_type = $training->getProgramType()->getIdprogramType();
        $idlevel_of_training = $training->getLevelOfTraining()->getIdlevelOfTraining();

        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return false;
        }

        $stmt = $conn->prepare("INSERT INTO training_program(name,conducting_authority,main_program_type,trainer_type,requirements,approval,other_details,idminor_training,idprogram_type,idlevel_of_training) VALUES(?,?,?,?,?,?,?,?,?,?)");
        if (!$stmt) {
            echo 'Error occured';
            return FALSE;
        }

        if ($training->getMainProgramType() == 0) {
            $main_program_type = $training->getMainProgramType();
            $stmt->bind_param("ssiisisiii", $name, $conducting_authority, $main_program_type, $trainer_type, $requirements, $approval, $other_details, $idminor_training, $idprogram_type, $idlevel_of_training);
            @$stmt->execute();
            $stmt->close();

            $id = mysqli_insert_id($conn);
            $idduration = TrainingDBHandler::addinternalDuration($duration, $conn, $id);

            $idforeign_training = $id;
            $country = $training->getCountry();
            $location_address = $training->getLocationAddress();
            $stmt_foreign = $conn->prepare("INSERT INTO foreign_training(idforeign_training,country,location_address,idduration) VALUES (?,?,?,?)");
            $stmt_foreign->bind_param("issi", $idforeign_training, $country, $location_address, $idduration);
            @$stmt_foreign->execute();
            $stmt_foreign->close();
        } else if ($training->getMainProgramType() == 1) {
            $main_program_type = $training->getMainProgramType();
            $stmt->bind_param("ssiisisiii", $name, $conducting_authority, $main_program_type, $trainer_type, $requirements, $approval, $other_details, $idminor_training, $idprogram_type, $idlevel_of_training);
            @$stmt->execute();
            $stmt->close();

            $id = mysqli_insert_id($conn);
            $idduration = TrainingDBHandler::addinternalDuration($duration, $conn, $id);

            $idlocal_training = $id;
            $place = $training->getPlace();
            $location_address = $training->getLocationAddress();
            $stmt_local = $conn->prepare("INSERT INTO local_training(idlocal_training,place,location_address,idduration) VALUES (?,?,?,?)");
            $stmt_local->bind_param("issi", $idlocal_training, $place, $location_address, $idduration);
            @$stmt_local->execute();
            $stmt_local->close();
        } else {
            $main_program_type = $training->getMainProgramType();
            $stmt->bind_param("ssiisisiii", $name, $conducting_authority, $main_program_type, $trainer_type, $requirements, $approval, $other_details, $idminor_training, $idprogram_type, $idlevel_of_training);
            @$stmt->execute();
            $stmt->close();

            $id = mysqli_insert_id($conn);
            $idduration = TrainingDBHandler::addinternalDuration($duration, $conn, $id);

            $idinhouse_training = $id;
            $location = $training->getlocation();
            $stmt_inhouse = $conn->prepare("INSERT INTO inhouse_training(idinhouse_training,location,idduration) VALUES (?,?,?)");
            $stmt_inhouse->bind_param("isi", $idinhouse_training, $location, $idduration);
            @$stmt_inhouse->execute();
            $stmt_inhouse->close();
        }

        if ($trainer_type == 1) {

            $stmt_external = $conn->prepare("INSERT INTO external_trainer_assignment(idoutside_trainer,idtraining) VALUES (?,?)");
            $stmt_external->bind_param("ii", $trainerid, $id);
            @$stmt_external->execute();
            $stmt_external->close();
        } else if ($trainer_type == 2) {

            $stmt_internal = $conn->prepare("INSERT INTO internal_trainer_assignment(idtraining,emp_number) VALUES (?,?)");
            if (!$stmt_internal) {
                echo $stmt_internal->error;
            }
            $stmt_internal->bind_param("ii", $id, $trainerid);
            @$stmt_internal->execute();
            $stmt_internal->close();
        }

        $conn->close();
        return True;
    }

    /* This method is used by the above function to store data about duration
     */

    private static function addinternalDuration(Duration $duration, $conn, $id) {
        $from = $duration->getFrom();
        $to = $duration->getTo();
        $no_of_days = $duration->getNoOfDays();
        $no_of_hours = $duration->getNoOfHours();
        $closing_date = $duration->getClosingDate();
        $no_of_participants = $duration->getNoOfParticipants();
        $session = $duration->getSession();
        $idtraining = $id;
        $stmt_duration = $conn->prepare("INSERT INTO duration(`from`, `to`, no_of_days, no_of_hours, closing_date, no_of_participants, session, idtraining) VALUES(?,?,?,?,?,?,?,?)");
        $stmt_duration->bind_param("ssidsiii", $from, $to, $no_of_days, $no_of_hours, $closing_date, $no_of_participants, $session, $idtraining);
        @$stmt_duration->execute();
        $stmt_duration->close();
        return mysqli_insert_id($conn);
    }

    /* This function is used to enter data about a new duration(seesion) of previously existed training program
     */

    public static function addDuration(Duration $duration) {

        $from = $duration->getFrom();
        $to = $duration->getTo();
        $no_of_days = $duration->getNoOfDays();
        $no_of_hours = $duration->getNoOfHours();
        $closing_date = $duration->getClosingDate();
        $no_of_participants = $duration->getNoOfParticipants();
        $session = $duration->getSession();
        $idtraining = $duration->getTrainingProgram()->getIdTraining();

        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return FALSE;
        }

        $stmt_duration = $conn->prepare("INSERT INTO duration(`from`, `to`, no_of_days, no_of_hours, closing_date, no_of_participants, session, idtraining) VALUES(?,?,?,?,?,?,?,?)");
        if ($stmt_duration) {
            $stmt_duration->bind_param("ssidsiii", $from, $to, $no_of_days, $no_of_hours, $closing_date, $no_of_participants, $session, $idtraining);
            @$stmt_duration->execute();
            $stmt_duration->close();
            $conn->close();
            return True;
        }

        $conn->close();
        return FALSE;
    }

    /* This function can be used to insert data about a MajorCategory to database
     */

    public static function addMajorcategory(MajorCategory $majorcategory) {
        $type = $majorcategory->getType();
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return FALSE;
        }

        $stmt_major = $conn->prepare("INSERT INTO major_category(type) VALUES (?)");
        if ($stmt_major) {
            $stmt_major->bind_param("s", $type);
            @$stmt_major->execute();
            $stmt_major->close();
            $conn->close();
            return True;
        }

        $conn->close();
        return FALSE;
    }

    /* This function can be used to insert data to the minor_category table
     */

    public static function addMinorCategory(MinorCategory $minorcategory) {

        $type = $minorcategory->getType();
        $idmajor_training = $minorcategory->getMajorCategory()->getIdmajorTraining();
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return FALSE;
        }

        $stmt_minor = $conn->prepare("INSERT INTO minor_category(type,idmajor_training) VALUES(?,?)");
        if ($stmt_minor) {
            $stmt_minor->bind_param("si", $type, $idmajor_training);
            @$stmt_minor->execute();
            $stmt_minor->close();
            $conn->close();
            return True;
        }
        $conn->close();
        return FALSE;
    }

    /* This function is used to insert data into pdf_upload table which stores pdfs about trainings
     */

    public static function addPdfUpload(PdfUpload $pdfupload) {

        $name = $pdfupload->getName();
        $pdf_link = $pdfupload->getPdfLink();
        $idtraining = $pdfupload->getTrainingProgram()->getIdTraining();

        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return FALSE;
        }
        $stmt_pdf = $conn->prepare("INSERT INTO pdf_upload(name,pdf_link,idtraining) VALUES(?,?,?)");
        if ($stmt_pdf) {
            $stmt_pdf->bind_param("ssi", $name, $pdf_link, $idtraining);
            @$stmt_pdf->execute();
            $stmt_pdf->close();
            $conn->close();
            return True;
        }
        $conn->close();
        return FALSE;
    }

    /* This function is used to insert data into program_type table 
     */

    public static function addProgramType(ProgramType $programtype) {
        $type = $programtype->getType();

        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return FALSE;
        }
        $stmt_program = $conn->prepare("INSERT INTO program_type(type) VALUES(?)");
        if ($stmt_program) {
            $stmt_program->bind_param("s", $type);
            @$stmt_program->execute();
            $stmt_program->close();
            $conn->close();
            return True;
        }
        $conn->close();
        return FALSE;
    }

    /* This function is used to insert data into level_of_training table 
     */

    public static function addLevelOfTraining(LevelOfTraining $leveloftrainig) {
        $level = $leveloftrainig->getLevel();

        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return FALSE;
        }
        $stmt_level = $conn->prepare("INSERT INTO level_of_training(level) VALUES(?)");
        if ($stmt_level) {
            $stmt_level->bind_param("s", $level);
            @$stmt_level->execute();
            $stmt_level->close();
            $conn->close();
            return True;
        }
        $conn->close();
        return FALSE;
    }

    /* This function is used to insert data into program_links table which store necessary links to a training
     */

    public static function addProgramLinks(ProgramLinks $programlinks) {
        $link = $programlinks->getLink();
        $idtraining = $programlinks->getTrainingProgram()->getIdTraining();
        $link_name = $programlinks->getLinkName();

        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return FALSE;
        }

        $stmt_program = $conn->prepare("INSERT INTO program_links(link,idtraining,link_name) VALUES (?,?,?)");
        if ($stmt_program) {
            $stmt_program->bind_param("sis", $link, $idtraining, $link_name);
            @$stmt_program->execute();
            $stmt_program->close();
            $conn->close();
            return True;
        }
        $conn->close();
        return FALSE;
    }

    /* This function is used to insert data into training_request table 
     */

    public static function addTrainingRequest(TrainingRequest $trainingrequest) {
        $subject = $trainingrequest->getTrainingSubject();
        $type = $trainingrequest->getTrainingType();
        $description = $trainingrequest->getTrainingDescription();
        $importance = $trainingrequest->getTrainingImportance();
        $emp_number = $trainingrequest->getEmployee();

        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return FALSE;
        }
        $stmt_request = $conn->prepare("INSERT INTO training_request(subject,type,description,importance,emp_number) VALUES(?,?,?,?,?)");
        if ($stmt_request) {
            $stmt_request->bind_param("sisss", $subject, $type, $description, $importance, $emp_number);
            @$stmt_request->execute();
            $stmt_request->close();
            $conn->close();
            return True;
        }
        $conn->close();
        return FALSE;
    }

    /* This function is used to approve a training or reject a training
     */

    public static function approveTraining(TrainingProgram $training, $approval) {
        $idtraining = $training->getIdTraining();

        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return FALSE;
        }

        $stmt = $conn->prepare("UPDATE training_program SET approval=? WHERE idtraining=?");
        if ($stmt) {
            $stmt->bind_param("ii", $approval, $idtraining);
            @$stmt->execute();
            $stmt->close();
            $conn->close();
            return True;
        }
        $conn->close();
        return FALSE;
    }

    /* Output the pending approval training programs
     */

    public static function pendingTraining() {

        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return FALSE;
        }
        $trainingprogramlist = array();
        $result_foreign = mysqli_query($conn, "SELECT * FROM training_program JOIN duration ON training_program.idtraining=duration.idtraining JOIN foreign_training ON training_program.idtraining=foreign_training.idforeign_training WHERE training_program.approval=2");
        while ($row = mysqli_fetch_row($result_foreign)) {

            $training_foreign = new ForeignTraining();
            $training_foreign->setIdTraining($row[0]);
            $training_foreign->setName($row[1]);
            $training_foreign->setConductingAuthority($row[2]);
            $training_foreign->setMainProgramType($row[3]);
            $training_foreign->setRequirements($row[5]);
            $training_foreign->setOtherDetails($row[7]);
            $training_foreign->setMinorCategory($row[8]);
            $training_foreign->setProgramType($row[9]);
            $training_foreign->setLevelOfTraining($row[10]);
            $training_foreign->setCountry($row[21]);
            $training_foreign->setLocationAddress($row[22]);
            $duration = new Duration();
            $duration->setIdduration($row[11]);
            $duration->setFrom($row[12]);
            $duration->setTo($row[13]);
            $duration->setNoOfDays($row[14]);
            $duration->setNoOfHours($row[15]);
            $duration->setClosingDate($row[16]);
            $duration->setNoOfParticipants($row[17]);
            $duration->setSession($row[18]);
            $training_foreign->setDuration($duration);
            array_push($trainingprogramlist, $training_foreign);
        }

        $result_local = mysqli_query($conn, "SELECT * FROM training_program JOIN duration ON training_program.idtraining=duration.idtraining JOIN local_training ON training_program.idtraining=local_training.idlocal_training WHERE training_program.approval=2");
        while ($row = mysqli_fetch_row($result_local)) {

            $training_local = new LocalTraining();
            $training_local->setIdTraining($row[0]);
            $training_local->setName($row[1]);
            $training_local->setConductingAuthority($row[2]);
            $training_local->setMainProgramType($row[3]);
            $training_local->setRequirements($row[5]);
            $training_local->setOtherDetails($row[7]);
            $training_local->setMinorCategory($row[8]);
            $training_local->setProgramType($row[9]);
            $training_local->setLevelOfTraining($row[10]);
            $training_local->setPlace($row[21]);
            $training_local->setLocationAddress($row[22]);
            $duration = new Duration();
            $duration->setIdduration($row[11]);
            $duration->setFrom($row[12]);
            $duration->setTo($row[13]);
            $duration->setNoOfDays($row[14]);
            $duration->setNoOfHours($row[15]);
            $duration->setClosingDate($row[16]);
            $duration->setNoOfParticipants($row[17]);
            $duration->setSession($row[18]);
            $training_local->setDuration($duration);
            array_push($trainingprogramlist, $training_local);
        }

        $result_inhouse = mysqli_query($conn, "SELECT * FROM training_program JOIN duration ON training_program.idtraining=duration.idtraining JOIN inhouse_training ON training_program.idtraining=inhouse_training.idinhouse_training WHERE training_program.approval=2");
        while ($row = mysqli_fetch_row($result_inhouse)) {

            $training_inhouse = new InhouseTraining();
            $training_inhouse->setIdTraining($row[0]);
            $training_inhouse->setName($row[1]);
            $training_inhouse->setConductingAuthority($row[2]);
            $training_inhouse->setMainProgramType($row[3]);
            $training_inhouse->setRequirements($row[5]);
            $training_inhouse->setOtherDetails($row[7]);
            $training_inhouse->setMinorCategory($row[8]);
            $training_inhouse->setProgramType($row[9]);
            $training_inhouse->setLevelOfTraining($row[10]);
            $training_inhouse->setLocation($row[21]);
            $duration = new Duration();
            $duration->setIdduration($row[11]);
            $duration->setFrom($row[12]);
            $duration->setTo($row[13]);
            $duration->setNoOfDays($row[14]);
            $duration->setNoOfHours($row[15]);
            $duration->setClosingDate($row[16]);
            $duration->setNoOfParticipants($row[17]);
            $duration->setSession($row[18]);
            $training_inhouse->setDuration($duration);
            array_push($trainingprogramlist, $training_inhouse);
        }
        $conn->close();
        return $trainingprogramlist;
    }

    public static function confirmTrainingAttendance() {

        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return FALSE;
        }

        $trainingprogramlist = array();
        $result_foreign = mysqli_query($conn, "SELECT * FROM training_program JOIN duration ON training_program.idtraining=duration.idtraining JOIN foreign_training ON training_program.idtraining=foreign_training.idforeign_training WHERE training_program.approval=1");
        while ($row = mysqli_fetch_row($result_foreign)) {

            $training_foreign = new ForeignTraining();
            $training_foreign->setIdTraining($row[0]);
            $training_foreign->setName($row[1]);
            $training_foreign->setConductingAuthority($row[2]);
            $training_foreign->setMainProgramType($row[3]);
            $training_foreign->setRequirements($row[5]);
            $training_foreign->setOtherDetails($row[7]);
            $training_foreign->setMinorCategory($row[8]);
            $training_foreign->setProgramType($row[9]);
            $training_foreign->setLevelOfTraining($row[10]);
            $training_foreign->setCountry($row[21]);
            $training_foreign->setLocationAddress($row[22]);
            $duration = new Duration();
            $duration->setIdduration($row[11]);
            $duration->setFrom($row[12]);
            $duration->setTo($row[13]);
            $duration->setNoOfDays($row[14]);
            $duration->setNoOfHours($row[15]);
            $duration->setClosingDate($row[16]);
            $duration->setNoOfParticipants($row[17]);
            $duration->setSession($row[18]);
            $training_foreign->setDuration($duration);
            array_push($trainingprogramlist, $training_foreign);
        }

        $result_local = mysqli_query($conn, "SELECT * FROM training_program JOIN duration ON training_program.idtraining=duration.idtraining JOIN local_training ON training_program.idtraining=local_training.idlocal_training WHERE training_program.approval=1");
        while ($row = mysqli_fetch_row($result_local)) {

            $training_local = new LocalTraining();
            $training_local->setIdTraining($row[0]);
            $training_local->setName($row[1]);
            $training_local->setConductingAuthority($row[2]);
            $training_local->setMainProgramType($row[3]);
            $training_local->setRequirements($row[5]);
            $training_local->setOtherDetails($row[7]);
            $training_local->setMinorCategory($row[8]);
            $training_local->setProgramType($row[9]);
            $training_local->setLevelOfTraining($row[10]);
            $training_local->setPlace($row[21]);
            $training_local->setLocationAddress($row[22]);
            $duration = new Duration();
            $duration->setIdduration($row[11]);
            $duration->setFrom($row[12]);
            $duration->setTo($row[13]);
            $duration->setNoOfDays($row[14]);
            $duration->setNoOfHours($row[15]);
            $duration->setClosingDate($row[16]);
            $duration->setNoOfParticipants($row[17]);
            $duration->setSession($row[18]);
            $training_local->setDuration($duration);
            array_push($trainingprogramlist, $training_local);
        }

        $result_inhouse = mysqli_query($conn, "SELECT * FROM training_program JOIN duration ON training_program.idtraining=duration.idtraining JOIN inhouse_training ON training_program.idtraining=inhouse_training.idinhouse_training WHERE training_program.approval=1");
        while ($row = mysqli_fetch_row($result_inhouse)) {

            $training_inhouse = new InhouseTraining();
            $training_inhouse->setIdTraining($row[0]);
            $training_inhouse->setName($row[1]);
            $training_inhouse->setConductingAuthority($row[2]);
            $training_inhouse->setMainProgramType($row[3]);
            $training_inhouse->setRequirements($row[5]);
            $training_inhouse->setOtherDetails($row[7]);
            $training_inhouse->setMinorCategory($row[8]);
            $training_inhouse->setProgramType($row[9]);
            $training_inhouse->setLevelOfTraining($row[10]);
            $training_inhouse->setLocation($row[21]);
            $duration = new Duration();
            $duration->setIdduration($row[11]);
            $duration->setFrom($row[12]);
            $duration->setTo($row[13]);
            $duration->setNoOfDays($row[14]);
            $duration->setNoOfHours($row[15]);
            $duration->setClosingDate($row[16]);
            $duration->setNoOfParticipants($row[17]);
            $duration->setSession($row[18]);
            $training_inhouse->setDuration($duration);
            array_push($trainingprogramlist, $training_inhouse);
        }
        $conn->close();
        return $trainingprogramlist;
    }

    public static function getTrainer(TrainingProgram $trainingprogram) {

        $trainertype = $trainingprogram->getTrainerType();
        $idtraining = $trainingprogram->getIdTraining();

        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return FALSE;
        }

        if ($trainertype == 1) {
            $external_stmt = mysqli_query($conn, "SELECT training_program.idtraining, external_trainer.*
                                                  FROM training_program 
                                                  JOIN external_trainer_assignment ON training_program.idtraining = external_trainer_assignment.idtraining
                                                  JOIN external_trainer ON external_trainer.idoutside_trainer = external_trainer_assignment.idoutside_trainer 
                                                  WHERE training_program.idtraining='$idtraining'");

            if ($row = mysqli_fetch_row($external_stmt)) {

                $externaltrainer = new ExternalTrainer();
                $externaltrainer->setTrainerID($row[1]);
                $externaltrainer->setName($row[2]);
                $externaltrainer->setQualifications($row[3]);
                $conn->close();
                return $externaltrainer;
            }
        } else {

            $internal_stmt = mysqli_query($conn, "SELECT training_program.idtraining, hs_hr_employee.employee_id, hs_hr_employee.emp_firstname, hs_hr_employee.emp_lastname
                                                  FROM training_program 
                                                  JOIN internal_trainer_assignment ON training_program.idtraining = internal_trainer_assignment.idtraining
                                                  JOIN hs_hr_employee ON hs_hr_employee.emp_number = internal_trainer_assignment.emp_number 
                                                  WHERE training_program.idtraining='$idtraining'");
            if ($row = mysqli_fetch_row($internal_stmt)) {

                $internaltrainer = new Employee();
                $internaltrainer->setEmployeeId($row[1]);
                echo $internaltrainer->getEmployeeId();
                $internaltrainer->setEmpFirstname($row[2]);
                $internaltrainer->setEmpLastname($row[3]);
                $conn->close();
                return $internaltrainer;
            }
        }

        $conn->close();
        return NULL;
    }

    public static function getEnrolledEmployees($trainingprogram) {

        $idtraining = $trainingprogram->getIdTraining();
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return FALSE;
        }
        $employeelist = array();
        $training_stmt = mysqli_query($conn, "SELECT enrol_training.enrol_staus,hs_hr_employee.*
                                              FROM training_program 
                                              JOIN enrol_training ON training_program.idtraining = enrol_training.idtraining
                                              JOIN hs_hr_employee ON hs_hr_employee.emp_number = enrol_training.emp_number 
                                              WHERE training_program.idtraining='$idtraining'");
        while ($row = mysqli_fetch_array($training_stmt)) {
            $employee = array($row["employee_id"], $row["emp_firstname"], $row["emp_lastname"], $row["enrol_staus"]);
            array_push($employeelist, $employee);
        }
        return $employeelist;
    }

    public static function getEmpsForAttendance($trainingprogram){
        $idtraining = $trainingprogram->getIdTraining();
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return FALSE;
        }
        $employeelist = array();
        $training_stmt = mysqli_query($conn, "SELECT enrol_training.enrol_staus,hs_hr_employee.*
                                                FROM training_program 
                                                JOIN enrol_training ON training_program.idtraining = enrol_training.idtraining
                                                JOIN hs_hr_employee ON hs_hr_employee.emp_number = enrol_training.emp_number 
                                                WHERE training_program.idtraining='$idtraining' AND enrol_training.enrol_staus=1 AND training_program.approval=1");
        while ($row = mysqli_fetch_array($training_stmt)) {
            $employee = array($row["emp_number"],$row["employee_id"], $row["emp_firstname"], $row["emp_lastname"]);
            array_push($employeelist, $employee);
        }
        return $employeelist;
    }

    public static function confirmEmployeeAttendance(TrainingProgram $training, $employee_array) {
        $idtraining = $training->getIdTraining();
        $completed_percentage = "100";
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return FALSE;
        }

        foreach ($employee_array as $employee) {
            $employee_id = $employee->getEmpNumber();
            $stmt_update = $conn->prepare("UPDATE enrol_training SET completed_percentage=? WHERE idtraining=? AND emp_number=?");
            $stmt_update->bind_param("sii", $completed_percentage, $idtraining, $employee_id);
            @$stmt_update->execute();
            $stmt_update->close();
        }

        $update = $conn->prepare("UPDATE training_program SET approval=3 WHERE idtraining=?");
        $update->bind_param("i", $idtraining);
        $update->execute();
        $update->close();

        $conn->close();
        return TRUE;
    }

    public static function viewSelectedEmployees(TrainingProgram $trainingprogram) {
        $idtraining = $trainingprogram->getIdTraining();
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return FALSE;
        }
        $employeearray = array();
        $result = mysqli_query($conn, "SELECT hs_hr_employee.* FROM enrol_training
                                       JOIN hs_hr_employee ON hs_hr_employee.emp_number=enrol_training.emp_number
                                       WHERE enrol_training.idtraining='$idtraining' AND enrol_training.enrol_staus=1
                                       GROUP BY hs_hr_employee.emp_number");
        while ($row = mysqli_fetch_array($result)) {
            $employee = array($row["emp_number"], $row["employee_id"], $row["emp_lastname"], $row["emp_firstname"], $row["emp_nic_no"]);
            array_push($employeearray, $employee);
        }

        $conn->close();
        return $employeearray;
    }

    public static function viewEmployeeDetails($employeeid) {

        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return FALSE;
        }

        $result = mysqli_query($conn, "SELECT * FROM hs_hr_employee WHERE emp_number='$employeeid'");
        if ($row = mysqli_fetch_array($result)) {
            $employee = new Employee();
            $employee->setEmpNumber($row["emp_number"]);
            $employee->setEmployeeId($row["employee_id"]);
            $employee->setEmpLastname($row["emp_lastname"]);
            $employee->setEmpFirstname($row["emp_firstname"]);
            $employee->setEmpNicNo($row["emp_nic_no"]);
            $employee->setEmpNicDate($row["emp_nic_date"]);
            $employee->setEmpBirthday($row["emp_birthday"]);
        }
        $conn->close();
        return $employee;
    }

    public static function getApprovedTraining() {

        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return FALSE;
        }
        $trainingarray = array();
        $result = mysqli_query($conn, "SELECT * FROM training_program WHERE approval=1 OR approval=3");
        while ($row = mysqli_fetch_array($result)) {
            $training = array($row["idtraining"], $row["name"], $row["conducting_authority"]);
            array_push($trainingarray, $training);
        }
        $conn->close();
        return $trainingarray;
    }

    public static function getEmployeeSelectedTraining(Employee $employee) {
        $emp_number = $employee->getEmpNumber();
        date_default_timezone_set('Asia/Colombo');
        $info = getdate();
        $date = $info['mday'];
        $month = $info['mon'];
        $year = $info['year'];
        $current_date = $year . "-" . $month . "-" . $date;

        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return FALSE;
        }

        $trainingarray = array();
        $result = mysqli_query($conn, "SELECT  t.idtraining,t.`name`,t.conducting_authority,t.main_program_type,d.idduration,d.`from`,d.`to`,d.no_of_days,i.location,l.place,l.location_address,f.country FROM enrol_training
                                       JOIN training_program t ON enrol_training.idtraining=t.idtraining
                                       JOIN duration d ON d.idtraining=enrol_training.idtraining
                                       LEFT JOIN foreign_training f ON f.idforeign_training=enrol_training.idtraining
                                       LEFT JOIN local_training l ON l.idlocal_training=enrol_training.idtraining
                                       LEFT JOIN inhouse_training i ON i.idinhouse_training=enrol_training.idtraining
                                       WHERE enrol_training.enrol_staus=1 AND d.`from` >'$current_date' AND t.approval=1 AND enrol_training.emp_number='$emp_number'");
        while ($row = mysqli_fetch_array($result)) {
            $training = array($row["idtraining"], $row["name"], $row["conducting_authority"], $row["main_program_type"], $row["idduration"], $row["from"], $row["to"], $row["no_of_days"], $row["location"], $row["place"], $row["location_address"], $row["country"]);
            array_push($trainingarray, $training);
        }

        $conn->close();
        return $trainingarray;
    }

    public static function getPendingTraining(Employee $employee) {

        $emp_number = $employee->getEmpNumber();
        date_default_timezone_set('Asia/Colombo');
        $info = getdate();
        $date = $info['mday'];
        $month = $info['mon'];
        $year = $info['year'];
        $current_date = $year . "-" . $month . "-" . $date;

        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return FALSE;
        }

        $trainingarray = array();
        $result = mysqli_query($conn, "SELECT  t.idtraining,t.`name`,t.conducting_authority,t.main_program_type,d.idduration,d.`from`,d.`to`,d.no_of_days,i.location,l.place,l.location_address,f.country FROM enrol_training
                                       JOIN training_program t ON enrol_training.idtraining=t.idtraining
                                       JOIN duration d ON d.idtraining=enrol_training.idtraining
                                       LEFT JOIN foreign_training f ON f.idforeign_training=enrol_training.idtraining
                                       LEFT JOIN local_training l ON l.idlocal_training=enrol_training.idtraining
                                       LEFT JOIN inhouse_training i ON i.idinhouse_training=enrol_training.idtraining
                                       WHERE enrol_training.enrol_staus=0 AND d.`from` >'$current_date' AND t.approval=1 AND enrol_training.emp_number='$emp_number'");
        while ($row = mysqli_fetch_array($result)) {
            $training = array($row["idtraining"], $row["name"], $row["conducting_authority"], $row["main_program_type"], $row["idduration"], $row["from"], $row["to"], $row["no_of_days"], $row["location"], $row["place"], $row["location_address"], $row["country"]);
            array_push($trainingarray, $training);
        }

        $conn->close();
        return $trainingarray;
    }

    public static function getApprovalPendingEmployees(TrainingProgram $trainingprogram) {
        $idtraining = $trainingprogram->getIdTraining();
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return FALSE;
        }
        $employeelist = array();
        $result = mysqli_query($conn, "SELECT h.emp_number,h.employee_id,h.emp_firstname,h.emp_lastname,h.emp_nic_no FROM enrol_training
                                       JOIN hs_hr_employee h ON enrol_training.emp_number=h.emp_number
                                       WHERE enrol_training.idtraining='$idtraining' AND enrol_training.enrol_staus=0;");
        while ($row = mysqli_fetch_array($result)) {
            $employee = array($row["emp_number"], $row["employee_id"], $row["emp_firstname"], $row["emp_lastname"], $row["emp_nic_no"]);
            array_push($employeelist, $employee);
        }
        return $employeelist;
    }
    
    public static function getTrainingForApproveEnrolments() {
        date_default_timezone_set('Asia/Colombo');
        $info = getdate();
        $date = $info['mday'];
        $month = $info['mon'];
        $year = $info['year'];
        $current_date = $year . "-" . $month . "-" . $date;
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return FALSE;
        }

        $trainingprogramlist = array();
        $result_foreign = mysqli_query($conn, "SELECT * FROM training_program 
                                               JOIN duration ON training_program.idtraining=duration.idtraining 
                                               JOIN foreign_training ON training_program.idtraining=foreign_training.idforeign_training 
                                               WHERE training_program.approval=1 AND duration.`from`>'$current_date'");
        while ($row = mysqli_fetch_row($result_foreign)) {

            $training_foreign = new ForeignTraining();
            $training_foreign->setIdTraining($row[0]);
            $training_foreign->setName($row[1]);
            $training_foreign->setConductingAuthority($row[2]);
            $training_foreign->setMainProgramType($row[3]);
            $training_foreign->setRequirements($row[5]);
            $training_foreign->setOtherDetails($row[7]);
            $training_foreign->setMinorCategory($row[8]);
            $training_foreign->setProgramType($row[9]);
            $training_foreign->setLevelOfTraining($row[10]);
            $training_foreign->setCountry($row[21]);
            $training_foreign->setLocationAddress($row[22]);
            $duration = new Duration();
            $duration->setIdduration($row[11]);
            $duration->setFrom($row[12]);
            $duration->setTo($row[13]);
            $duration->setNoOfDays($row[14]);
            $duration->setNoOfHours($row[15]);
            $duration->setClosingDate($row[16]);
            $duration->setNoOfParticipants($row[17]);
            $duration->setSession($row[18]);
            $training_foreign->setDuration($duration);
            array_push($trainingprogramlist, $training_foreign);
        }

        $result_local = mysqli_query($conn, "SELECT * FROM training_program 
                                             JOIN duration ON training_program.idtraining=duration.idtraining 
                                             JOIN local_training ON training_program.idtraining=local_training.idlocal_training 
                                             WHERE training_program.approval=1 AND duration.`from`>'$current_date'");
        while ($row = mysqli_fetch_row($result_local)) {

            $training_local = new LocalTraining();
            $training_local->setIdTraining($row[0]);
            $training_local->setName($row[1]);
            $training_local->setConductingAuthority($row[2]);
            $training_local->setMainProgramType($row[3]);
            $training_local->setRequirements($row[5]);
            $training_local->setOtherDetails($row[7]);
            $training_local->setMinorCategory($row[8]);
            $training_local->setProgramType($row[9]);
            $training_local->setLevelOfTraining($row[10]);
            $training_local->setPlace($row[21]);
            $training_local->setLocationAddress($row[22]);
            $duration = new Duration();
            $duration->setIdduration($row[11]);
            $duration->setFrom($row[12]);
            $duration->setTo($row[13]);
            $duration->setNoOfDays($row[14]);
            $duration->setNoOfHours($row[15]);
            $duration->setClosingDate($row[16]);
            $duration->setNoOfParticipants($row[17]);
            $duration->setSession($row[18]);
            $training_local->setDuration($duration);
            array_push($trainingprogramlist, $training_local);
        }

        $result_inhouse = mysqli_query($conn, "SELECT * FROM training_program 
                                               JOIN duration ON training_program.idtraining=duration.idtraining 
                                               JOIN inhouse_training ON training_program.idtraining=inhouse_training.idinhouse_training 
                                               WHERE training_program.approval=1  AND duration.`from`>'$current_date'");
        while ($row = mysqli_fetch_row($result_inhouse)) {

            $training_inhouse = new InhouseTraining();
            $training_inhouse->setIdTraining($row[0]);
            $training_inhouse->setName($row[1]);
            $training_inhouse->setConductingAuthority($row[2]);
            $training_inhouse->setMainProgramType($row[3]);
            $training_inhouse->setRequirements($row[5]);
            $training_inhouse->setOtherDetails($row[7]);
            $training_inhouse->setMinorCategory($row[8]);
            $training_inhouse->setProgramType($row[9]);
            $training_inhouse->setLevelOfTraining($row[10]);
            $training_inhouse->setLocation($row[21]);
            $duration = new Duration();
            $duration->setIdduration($row[11]);
            $duration->setFrom($row[12]);
            $duration->setTo($row[13]);
            $duration->setNoOfDays($row[14]);
            $duration->setNoOfHours($row[15]);
            $duration->setClosingDate($row[16]);
            $duration->setNoOfParticipants($row[17]);
            $duration->setSession($row[18]);
            $training_inhouse->setDuration($duration);
            array_push($trainingprogramlist, $training_inhouse);
        }
        $conn->close();
        return $trainingprogramlist;
    }

}

?>

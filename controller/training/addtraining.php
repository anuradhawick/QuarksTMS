<?php

/*
 * Coded by W.A.Anuradha Wickramarachchi
 * 
 * Used to add new training programs of all types
 */
// UI data assignments
// 1 - external trainer
// 2 - internal trainer
// 1 - inhouse
// 2 - local
// 3 - foreign
// 
// 
//Array
//(
//    [training_type] => 1
//    [type] => 1
//    [level] => lv
//    [major] => 1
//    [minor] => 1
//    [name] => 
//    [participants] => 
//    [authority] => 
//    [requirements] => 
//    [location] => 
//    [loc_details] => 
//    [from_date] => 
//    [to_date] => 
//    [closing_date] => 
//    [days] => 
//    [hrs] => 
//    [sessions] => 
//    [trainer_type] => 1
//    [trainer_id] => 7
//)

require_once '../../API/training/ForeignTraining.php';
require_once '../../API/training/LocalTraining.php';
require_once '../../API/training/InhouseTraining.php';
require_once '../../API/training/Duration.php';
require_once '../../API/training/MinorCategory.php';
require_once '../../API/training/LevelOfTraining.php';
require_once '../../API/training/ProgramType.php';
require_once '../../API/training/DBClasses/TrainingDBHandler.php';


$training_type = $_POST['training_type'];
$type = $_POST['type'];
$level = $_POST['level'];
$major = $_POST['major'];
$minor = $_POST['minor'];
$name = $_POST['name'];
$participants = $_POST['participants'];
$authority = $_POST['authority'];
$requirements = $_POST['requirements'];
$location = $_POST['location'];
$loc_details = $_POST['loc_details'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$closing_date = $_POST['closing_date'];
$days = $_POST['days'];
$hrs = $_POST['hrs'];
$sessions = $_POST['sessions'];
$trainer_type = $_POST['trainer_type'];
$trainer_id = $_POST['trainer_id'];


switch ($training_type) {
    case 1:
        //inhouse training
        $minor_category = new MinorCategory();
        $minor_category->setIdminorTraining($minor);
        $program_type = new ProgramType();
        $program_type->setIdprogramType($type);
        $level_training = new LevelOfTraining();
        $level_training->setIdlevelOfTraining($level);
        $training_program = InhouseTraining::withRow($name, $authority, 2, $trainer_type, $requirements, 2, NULL, $level_training, $minor_category, $program_type, $location);
        $duration = Duration::withRow($training_program, $from_date, $to_date, $days, $hrs, $closing_date, $participants, $sessions);
        TrainingDBHandler::postNewTraining($training_program, $duration, $trainer_id);
        break;

    case 2:
        //local training
        $minor_category = new MinorCategory();
        $minor_category->setIdminorTraining($minor);
        $program_type = new ProgramType();
        $program_type->setIdprogramType($type);
        $level_training = new LevelOfTraining();
        $level_training->setIdlevelOfTraining($level);
        $training_program = LocalTraining::withRow($name, $authority, 1, $trainer_type, $requirements, 2, NULL, $level_training, $minor_category, $program_type, $location, $loc_details);
        $duration = Duration::withRow($training_program, $from_date, $to_date, $days, $hrs, $closing_date, $participants, $sessions);
        TrainingDBHandler::postNewTraining($training_program, $duration, $trainer_id);

        break;

    case 3:
        //foreign training
        $minor_category = new MinorCategory();
        $minor_category->setIdminorTraining($minor);
        $program_type = new ProgramType();
        $program_type->setIdprogramType($type);
        $level_training = new LevelOfTraining();
        $level_training->setIdlevelOfTraining($level);
        $training_program = ForeignTraining::withRow($name, $authority, 0, $trainer_type, $requirements, 2, NULL, $level_training, $minor_category, $program_type, $location, $loc_details);
        $duration = Duration::withRow($training_program, $from_date, $to_date, $days, $hrs, $closing_date, $participants, $sessions);
        TrainingDBHandler::postNewTraining($training_program, $duration, $trainer_id);
        break;
}

require_once '../../API/logger/Logger.php';
$logger = Logger::getLogger();
$logger->postNewTraining();
echo json_encode(TRUE);
?>
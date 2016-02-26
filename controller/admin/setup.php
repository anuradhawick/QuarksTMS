<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../../API/training/DBClasses/TrainingDBHandler.php';
require_once '../../API/training/ProgramType.php';
require_once '../../API/training/LevelOfTraining.php';
require_once '../../API/training/MajorCategory.php';
require_once '../../API/training/MinorCategory.php';
$data = $_GET['data'];
switch ($_GET['cmd']) {
    case 'type':
        $programtype = new ProgramType();
        $programtype->setType($data);
        TrainingDBHandler::addProgramType($programtype);
        break;
    case 'level':
        $leveloftrainig = new LevelOfTraining();
        $leveloftrainig->setLevel($data);
        TrainingDBHandler::addLevelOfTraining($leveloftrainig);
        break;
    case 'major':
        $majorcategory = new MajorCategory();
        $majorcategory->setType($data);
        TrainingDBHandler::addMajorcategory($majorcategory);
        break;

    case 'minor':
        $major_id = $_GET['major_id'];
        $majorcategory = new MajorCategory();
        $majorcategory->setIdmajorTraining($major_id);
        $minorcategory = new MinorCategory();
        $minorcategory->setMajorCategory($majorcategory);
        $minorcategory->setType($data);
        TrainingDBHandler::addMinorCategory($minorcategory);
        break;
}
echo json_encode(TRUE);
?>

<?php  
require_once '../../API/training/DBClasses/TrainingDBHandler.php';
require_once '../../API/training/LocalTraining.php';
//Array
//(
//    [type] => reject /approve
//    [id] => 16
//)
$type = $_POST['type'];
$id = $_POST['id'];
if ($type == 'approve') {
    $tr = new LocalTraining();
    $tr->setIdTraining($id);
    TrainingDBHandler::approveTraining($tr, 1);
} else {
    $tr = new LocalTraining();
    $tr->setIdTraining($id);
    TrainingDBHandler::approveTraining($tr, 0);
}
require_once '../../API/logger/Logger.php';
$logger = Logger::getLogger();
$logger->approveNewTraining();
echo  json_encode(TRUE);
?>
<?php

require_once dirname(__FILE__) . '/../../API/admin/AccessPrivilegeDBHandler.php';
require_once dirname(__FILE__) . '/../../API/admin/UserLevel.php';
require_once dirname(__FILE__) . '/../../API/admin/UseCase.php';


$userlevelid = $_POST["user_level"];
$usecases = array($_POST["usecases"]);
// print_r($usecases);
$userlevel = new UserLevel();
$userlevel->setUserLevel_ID($userlevelid);



$usecase_array = array();
foreach ($usecases as $usecase) {

    $use_case = new UseCase();
    $use_case->setUsecase_ID($usecase);
    if (AccessPrivilegeDBHandler::isUseCaseAlreadyIn($usecase, $userlevelid)) {

        echo json_encode(TRUE);
        return;
    } else {

        array_push($usecase_array, $use_case);
    }
}

AccessPrivilegeDBHandler::assignUsecases($userlevel, $usecase_array);
echo json_encode(TRUE);
?>
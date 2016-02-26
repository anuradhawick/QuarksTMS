<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserLevelDBHandler
 *
 * @author Pamoda
 */
//require_once '../Constants/DatabaseCredentials.php';
require_once dirname(__FILE__) . '/../Constants/DatabaseCredentials.php';
require_once dirname(__FILE__) . '/UserLevel.php';
require_once dirname(__FILE__) . '/../employee/Employee.php';
require_once dirname(__FILE__) . '/UseCase.php';
require_once dirname(__FILE__) . '/../employee/DatabaseHandler/EmployeeDBHandler.php';

class AccessPrivilegeDBHandler {

    //create a new userlevel 
    public static function createUserLevel(UserLevel $UserLevel) {
        $user_level_type = $UserLevel->getUserLevel_type();
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->error);
        }

        $stmt = $conn->prepare("INSERT INTO user_level(user_level_type) VALUES(?)");
        $stmt->bind_param("s", $user_level_type);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

    //assign the set of usecases to a user level identified by its ID
    public static function assignUsecases(UserLevel $userLevel, $useCases) {
        $user_level_ID = $userLevel->getUserLevel_ID();
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->error);
        }
        foreach ($useCases as $item) {
            $use_case_ID = $item->getUsecase_ID();
            $stmt = $conn->prepare("INSERT INTO user_use_case(iduser_level,iduse_case) VALUES(?,?)");
            $stmt->bind_param("ii", $user_level_ID, $use_case_ID);
            $stmt->execute();
            $stmt->close();
        }
        $conn->close();
    }

    //assign the set of users to a user level identified by its ID
    public static function assignUsers(UserLevel $userLevel, $users) {
        $user_level_ID = $userLevel->getUserLevel_ID();
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->error);
        }
//        print_r($users[0]->getEmpNumber());
        foreach ($users as $item) {
            $user_ID = $item->getEmpNumber();
            $stmt = $conn->prepare("INSERT INTO person_user_level(iduser_level,emp_number) VALUES(?,?);");
            $stmt->bind_param("ii", $user_level_ID, $user_ID);
            $stmt->execute();
            $stmt->close();
        }

        $conn->close();
    }

    //get a user level object by the given user_level_ID
    public static function getUserLevelByID($user_level_ID) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->error);
        }
        //retrieve user_level_type of the given user_level_ID accessing the table user_level
        $user_level_type = "";
        $stmt1 = $conn->prepare("SELECT user_level_type FROM user_level WHERE iduser_level=?");
        $stmt1->bind_param("i", $user_level_ID);
        $stmt1->execute();
        $stmt1->bind_result($user_level_type);
        $stmt1->fetch();
        $stmt1->close();

        //retrieve set of usecases of the given userlvel accessing the associate table user_use_case
        $usecase_ID = array();
        $usecase = array();
        $use_case_ID = null;
        $stmt2 = $conn->prepare("SELECT iduse_case FROM user_use_case WHERE iduser_level=?");
        $stmt2->bind_param("i", $user_level_ID);
        $stmt2->execute();
        $stmt2->bind_result($use_case_ID);
        while ($stmt2->fetch()) {
            array_push($usecase_ID, $use_case_ID);
            array_push($usecase, self::getUsecaseByID($use_case_ID));
        }
        $stmt2->close();

        //retrieve set of users of the given user level accessing the associate table person_user_level
        $employee_ID = array();
        $users = array();
        $emp_number = null;
        $stmt3 = $conn->prepare("SELECT emp_number FROM person_user_level WHERE iduser_level=?");
        $stmt3->bind_param("i", $user_level_ID);
        $stmt3->execute();
        $stmt3->bind_result($emp_number);
        while ($stmt3->fetch()) {
            array_push($employee_ID, $emp_number);
            array_push($users, EmployeeDBHandler::getEmployeeByID($emp_number));
        }
        $stmt3->close();

        $conn->close();
        return UserLevel::withRow($user_level_ID, $user_level_type, $usecase, $users);
    }

    //get a usecase object when a usecase_ID is given accessing the table usecase
    public static function getUsecaseByID($usecase_ID) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if ($conn->connect_error) {
            die("Connection failed" . $conn->error);
        }

        $use_case_name = "";
        $stmt1 = $conn->prepare("SELECT use_case_name FROM use_case WHERE iduse_case=?");
        $stmt1->bind_param("i", $usecase_ID);
        $stmt1->execute();
        $stmt1->bind_result($use_case_name);
        $stmt1->fetch();
        $stmt1->close();
        return UseCase::withRow($usecase_ID, $use_case_name);
    }

    public static function getUseCases() {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if ($conn->connect_error) {
            die("Connection failed" . $conn->error);
        }

        $result = $conn->query("SELECT * FROM use_case");
        $conn->close();
        $usecasearray = array();
        while ($row = mysqli_fetch_row($result)) {
            array_push($usecasearray, $row);
        }
        return $usecasearray;
    }

    public static function getUserLevels() {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if ($conn->connect_error) {
            die("Connection failed" . $conn->error);
        }

        $result = $conn->query("SELECT * FROM user_level");
        $conn->close();
        $userlevelsarray = array();
        while ($row = mysqli_fetch_row($result)) {
            array_push($userlevelsarray, $row);
        }
        return $userlevelsarray;
    }

    public static function getUseCasesByLevel($level_id) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if ($conn->connect_error) {
            die("Connection failed" . $conn->error);
        }

        $result = $conn->query("SELECT use_case.iduse_case,use_case.use_case_name
                                FROM user_level
                                JOIN user_use_case
                                ON user_level.iduser_level = user_use_case.iduser_level
                                JOIN use_case
                                ON user_use_case.iduse_case = use_case.iduse_case
                                WHERE user_level.iduser_level = '" . $level_id . "'");

        $conn->close();
        $usecasearray = array();
        while ($row = mysqli_fetch_row($result)) {
            array_push($usecasearray, $row);
        }
        return $usecasearray;
    }

    public static function getAllUseCases(Employee $employee) {
        $emp_number = $employee->getEmpNumber();
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if ($conn->connect_error) {
            die("Connection failed" . $conn->error);
            return FALSE;
        }
        $usecase_array = array();
        $result = mysqli_query($conn, "SELECT use_case.iduse_case FROM person_user_level
                                    JOIN user_level ON user_level.iduser_level=person_user_level.iduser_level
                                    JOIN user_use_case ON user_use_case.iduser_level=user_level.iduser_level
                                    JOIN use_case ON use_case.iduse_case=user_use_case.iduse_case
                                    WHERE person_user_level.emp_number='$emp_number'
                                    GROUP BY use_case.iduse_case");
        while ($row = mysqli_fetch_array($result)) {
            array_push($usecase_array, $row["iduse_case"]);
        }

        $conn->close();
        return $usecase_array;
    }

    public static function isUseCaseAlreadyIn($idusecase, $iduserlevel) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->error);
            return FALSE;
        }

        $result = mysqli_query($conn, "SELECT * FROM user_use_case WHERE iduser_level='$iduserlevel' AND iduse_case='$idusecase'");
        if ($row = mysqli_fetch_array($result)) {
            $conn->close();
            return TRUE;
        } else {
            $conn->close();
            return FALSE;
        }
    }

}

//$emp = new Employee();
//$emp->setEmpNumber(0);
//$arr = AccessPrivilegeDBHandler::getAllUseCases($emp);
//print_r($arr);
//echo '<br/>';
//if (in_array(4, $arr)) {
//    echo 'true';
//} else {
//    echo 'false';
//}

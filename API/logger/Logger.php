<?php

/*
 * ***** Coded by D. R. ATAPATTU *****
 */
define('KEY_LOGGER_OBJECT', 'logger');
require_once dirname(__FILE__) . '/LoggerDBHandler.php';
require_once dirname(__FILE__) . '/../Constants/UseCases.php';

class Logger {

    var $db;

    private function __construct() {
        
    }

    public static function getLogger() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // $semRes = sem_get($_SESSION[1001], 1, 0666, 0); 
        if (!array_key_exists(KEY_LOGGER_OBJECT, $_SESSION)) {
            // if(sem_acquire($semRes)){
            if (!array_key_exists(KEY_LOGGER_OBJECT, $_SESSION)) {
                $logger = new Logger();
                $logger->db = new LoggerDBHandler();
                $_SESSION[KEY_LOGGER_OBJECT] = $logger;
            }
            // }
        }
        return $_SESSION[KEY_LOGGER_OBJECT];
    }

    public function signIn() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->db->startLogSession($_SESSION['qis_emp']);
        $this->db->addLog(USECASE_SIGNIN, 'Signed in.');
    }

    public function signOut() {
        $this->db->endLogSession();
        $this->db->addLog(USECASE_SIGNOUT, 'Signed out.');
    }

    public function updatePassword() {
        $this->db->addLog(USECASE_UPDATE_PASSWORD, 'Password updated.');
    }

    //deprecated
    public function updatePicture() {
        $this->db->addLog(USECASE_UPDATE_PICTURE, 'Profile picture updated.');
    }

    public function requestNewTraining() {
        $this->db->addLog(USECASE_REQUEST_NEW_TRAINING, 'Requested for a new training program from the management level.');
    }

    public function enrollTraining() {
        $this->db->addLog(USECASE_ENROLL_TRAINING, 'Enrolled for a new training program.');
    }

    public function postNewTraining() {
        $this->db->addLog(USECASE_POST_NEW_TRAINING, 'Posted new training program.');
    }

    public function respondToEnrollment() {
        $this->db->addLog(USECASE_RESPOND_TO_ENROLLMENT, 'Responded to enrollment request.');
    }

    //deprecated
    public function respondToTrainingRequest() {
        $this->db->addLog(USECASE_RESPOND_TO_TRAING_REQUEST, 'Responded to training request of employee.');
    }

    public function generateReport() {
        $this->db->addLog(USECASE_GENERATE_REPORT, 'Report generated.');
    }

    public function approveNewTraining() {
        $this->db->addLog(USECASE_APPROVE_NEW_TRAINING, 'New training program approved.');
    }

    public function addUserLevel() {
        $this->db->addLog(USECASE_ADD_USER_LEVEL, 'New user level added.');
    }

    public function assignUseCase() {
        $this->db->addLog(USECASE_ASSIGN_USECASE, 'A new use case was assigned to user level.');
    }

    public function addUserToUserLevel() {
        $this->db->addLog(USECASE_ADD_USER_TO_USERLEVEL, 'A new user was added to user level');
    }

}

?>
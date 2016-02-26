<?php

/*
 * ***** Coded by D. R. Atapattu *****
 */

/*
 * This class contains following methods.
 * 
 * SignIn($emp_number, $pass)
 * isUserExists($username)
 * addUser($emp_number, $name, $nic)
 * changePassword($emp_number, $pass_old, $pass_new)
 */

/*
 * Constants.php file contains all constant values.
 */

require_once './../../API/Constants/DatabaseCredentials.php';
require_once './../../API/employee/Employee.php';

class Authenticator {

    var $dbc;

    public function __construct() {
        
    }

    /*
     * Call SignIn function using an object of Authenticator class whenever you wamt to sign in to the system.
     * Pass emp_number and password directly as parameters.
     */

    function SignIn($emp_id, $pass) {

        $this->dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Failed to connect to MySQL database. " . mysqli_error());
        $query = "SELECT * FROM hs_hr_employee WHERE employee_id = '$emp_id'";
        $result = mysqli_query($this->dbc, $query) or die("Signing in failed. " . mysqli_error($this->dbc));
        $row = mysqli_fetch_array($result);
        $emp_number = $row['emp_number'];
        $query = "SELECT * FROM login WHERE emp_number = '$emp_number'";
        $result = mysqli_query($this->dbc, $query) or die("Signing in failed. " . mysqli_error($this->dbc));
        $row = mysqli_fetch_array($result);
        $hash = $row['password'];
        mysqli_close($this->dbc);
        if (empty($row)) {

            return FALSE;
        } else if (hash_equals($hash, crypt($pass, $hash))) {
            /*
             * Match hashed password stored in database with password entered by user.
             */
            return $emp_number;
        } else {
            return FALSE;
        }
    }

    /*
     * isUserExists($username) function can be used to check whether emp_number has been taken already.
     * 
     * Pass emp_number which you want to validate as parameter.
     * Return TRUE if username currently does not exists.
     */

    function isUserExists($employee_id) {
        $this->dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Failed to connect to MySQL database. " . mysqli_error());
        $query = "SELECT * FROM hs_hr_employee where employee_id = '$employee_id'";
        $result = mysqli_query($this->dbc, $query) or die("Checking failed. " . mysqli_error($this->dbc));
        $row = mysqli_fetch_array($result);
        mysqli_close($this->dbc);

        if (!empty($row)) {
            $this->dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Failed to connect to MySQL database. " . mysqli_error());
            $emp_number = $row['emp_number'];
            $query = "SELECT * FROM login where emp_number = '$emp_number'";
            $result = mysqli_query($this->dbc, $query) or die("Checking failed. " . mysqli_error($this->dbc));
            $row1 = mysqli_fetch_array($result);
            mysqli_close($this->dbc);
            if (empty($row1)) {
                return $emp_number;
            }
            return FALSE;
        } else {
            return FALSE;
        }
    }

    /*
     * addUser($emp_number, $nic) method can be used to add a new user with a default password.
     */

    function addUser($emp_number, $nic) {

        $this->dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Failed to connect to MySQL database. " . mysqli_error());
//        $query = "INSERT INTO `person`(`emp_number`, `name`, `nic`) VALUES ('$emp_number','$name','$nic')";
//        $result = mysqli_query($this->dbc, $query) or die("Adding user failed 1. " . mysqli_errno($this->dbc));
        $query = "INSERT INTO `login`(`password`, `emp_number`) VALUES ('" . $this->hashPassword($nic) . "', '$emp_number')";
        $result = mysqli_query($this->dbc, $query) or die("Adding user failed 2. " . mysqli_errno($this->dbc));
        mysqli_close($this->dbc);
        return TRUE;
    }

    /*
     * changePassword($emp_number, $pass_old, $pass_new

      ) method can be used to change the password of a existing user.
     */

    function changePassword($emp_number, $pass_old, $pass_new) {

        $this->dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Failed to connect to MySQL database. " . mysqli_error());
        $query = "SELECT * FROM login where emp_number = '$emp_number'";
        $result = mysqli_query($this->dbc, $query) or die(mysqli_error($this->dbc));
        $row = mysqli_fetch_array($result);

        if (empty($row)) {

            return FALSE;
        } else if (hash_equals($row['password'], crypt($pass_old, $row['password']))) {

            $query = "UPDATE login SET password = '" . $this->hashPassword($pass_new) . "' WHERE emp_number = '$emp_number'";
            $result = mysqli_query($this->dbc, $query) or die("Change password failed. " . mysqli_error($this->dbc));
            return TRUE;
        } else {

            return FALSE;
        }

        mysqli_close($this->dbc);
    }

    /*
     * This is a private function used to make the hash of a given password.
     */

    private function hashPassword($password) {

        /*
         * A higher "cost" is more secure but consumes more processing power
         */
        $cost = 10;
        $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

        /*
         *  Prefix information about the hash so PHP knows how to verify it later.
         *    "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameters.
         */
        $salt = sprintf("$2a$%02d$", $cost) . $salt;

        /*
         *  Hash the password with the salt using crypt function in PHP.
         *  Only hash value is stored in database.
         */
        $hash = crypt($password, $salt);
        return $hash;
    }

}

?>

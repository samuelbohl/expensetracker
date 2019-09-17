<?php

class Authentication{
    
    protected $connection;
    
    public function __construct(){
        require '../php/dbconnection.inc.php';
        $this->connection = $link;
    }
    
    public function logout(){

        unset($_SESSION);
        setcookie("id", "", time() - 60*60);
        $_COOKIE["id"] = "";
        session_destroy();

    }

    public function cookies_are_valid(){

        return (array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id']);

    }

    public function validate_session(){

        session_start();

        if (array_key_exists("id", $_COOKIE)) {

            $_SESSION['id'] = $_COOKIE['id'];

        }

        if (array_key_exists("id", $_SESSION)) {

        } else {

            header("Location: login.php");

        }

    }

    public function validate_form(){

        $error = "";

        if (!$_POST['email']) {

            $error .= "An email address is required<br>";
        } 

        if (!$_POST['password']) {

            $error .= "A password is required<br>";
        } 

        if ($error != "") {

            $error = "<p>There were error(s) in your form:</p>".$error;   
        }

        return $error;
    }

    public function sign_up(){

        $error = "";

        $query = "SELECT id FROM `users` WHERE email = '".mysqli_real_escape_string($this->connection, $_POST['email'])."' LIMIT 1";

        $result = mysqli_query($this->connection, $query);

        if (mysqli_num_rows($result) > 0) {

            $error = "That email address is taken.";

        } else {
            //escaping strings for security reasons
            $firstname = mysqli_real_escape_string($this->connection, $_POST['firstname']);
            $lastname = mysqli_real_escape_string($this->connection, $_POST['lastname']);
            $email = mysqli_real_escape_string($this->connection, $_POST['email']);
            $password = mysqli_real_escape_string($this->connection, $_POST['password']);

            $query = "INSERT INTO `users` (`firstname`, `lastname`,`email`, `password`) VALUES ('$firstname', '$lastname','$email', '$password')";

            //error display
            if (!mysqli_query($this->connection, $query)) {

                $error = "<p>Could not sign you up - please try again later.</p>";
                $error = mysqli_error($this->connection);

            } else {

                //salting + hashing of password
                $query = "UPDATE `users` SET password = '".md5(md5(mysqli_insert_id($this->connection)).$_POST['password'])."' WHERE id = ".mysqli_insert_id($this->connection)." LIMIT 1";

                mysqli_query($this->connection, $query);

                //insertion id for login system
                $_SESSION['id'] = mysqli_insert_id($link);

                //geting userid for later user identification
                $query = "SELECT * FROM `users` WHERE email = '$email'";
                $result = mysqli_query($this->connection, $query);
                $row = mysqli_fetch_array($result);

                $_SESSION['userid'] = $row['id'];
                header("Location: dashboard.php");

            }

        }

        return $error;
    }

    public function login(){

        $query = "SELECT * FROM `users` WHERE email = '".mysqli_real_escape_string($this->connection, $_POST['email'])."'";

        $result = mysqli_query($this->connection, $query);

        $row = mysqli_fetch_array($result);

        if (isset($row)) {

            $hashedPassword = md5(md5($row['id']).$_POST['password']);

            if ($hashedPassword == $row['password']) {

                $_SESSION['id'] = $row['id'];

                if ($_POST['stayLoggedIn'] == '1') {

                    setcookie("id", $row['id'], time() + 60*60*24*365);

                }
                $_SESSION['userid'] = $row['id'];
                header("Location: dashboard.php");

            } else {

                $error = "That email/password combination could not be found.";

            }

        } else {

            $error = "That email/password combination could not be found.";

        }

        return $error;

    }
}

?>
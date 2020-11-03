<?php

class User {
    
    /**
     * Database connection link
     * 
     * @var mysqli (FALSE when connection failed, otherwise its an mysqli object)
     */
    protected $connection;
    
    /**
     * User constructor
     */ 
    public function __construct(){
        require '../php/dbconnection.inc.php';
        $this->connection = $link;
        
    }
    
    /**
     * gets userinformation from database and returns the full name
     * 
     * @return String
     */ 
    public function get_fullname(){
    
        $userid = $_SESSION['userid'];
        $query = "SELECT * FROM users WHERE id = $userid";
        $result = mysqli_query($this->connection, $query);
        $row = mysqli_fetch_array($result);
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];

        return $firstname.' '.$lastname;

    }
    
    /**
     * gets user information from database and returns an array with that information
     * 
     * @return Array
     */ 
    public function get_account_info(){

        $userid = $_SESSION['userid'];
        $query = "SELECT * FROM users WHERE id = $userid";
        $result = mysqli_query($this->connection, $query);

        $row = mysqli_fetch_array($result);
        $accountInfo= array("firstname" => $row['firstname'], 
                            "lastname" => $row['lastname'], 
                            "email" => $row['email']);

        return $accountInfo;

    }
}

?>
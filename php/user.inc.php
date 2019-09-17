<?php

class User{
    
    protected $connection;
    
    public function __construct(){
        require '../php/dbconnection.inc.php';
        $this->connection = $link;
        
    }
    
    function get_fullname(){
    
        $userid = $_SESSION['userid'];
        $query = "SELECT * FROM users WHERE id = $userid";
        $result = mysqli_query($this->connection, $query);
        $row = mysqli_fetch_array($result);
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];

        return $firstname.' '.$lastname;

    }
    
    function get_account_info(){

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
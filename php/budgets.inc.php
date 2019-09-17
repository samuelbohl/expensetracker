<?php

class Budgets{
    
    protected $connection;
    protected $categories;
    
    public function __construct() {
        require '../php/dbconnection.inc.php';
        $this->connection = $link;
        $this->categories = new Categories();
    }
    
    public function get_budgets(){

        $userid = $_SESSION['userid'];//POST for transition into microservices
        $query = "SELECT * FROM budgets WHERE user_id = $userid";
        $result = mysqli_query($this->connection, $query);
        
        $return_arr = [];

        while($row = mysqli_fetch_array($result)){
            $categoryId = (int)$row['category_id'];
            $categoryName = $row['category_name'];
            $budget = $row['budget'];
            $periodicity = (int)$row['periodicity'];


            $return_arr[] = array("categoryId" => $categoryId,
                                  "categoryName" => $categoryName,
                                  "budget" => $budget,
                                  "periodicity" => $periodicity);
        }
        return json_encode($return_arr);
    }
    
    public function add_budget(){

        $userid = $_SESSION['userid'];
        $categoryId = $_POST['category'];
        $budget = $_POST['amount'];
        $periodicity = $_POST['periodicity'];

        //duplicate checking 
        if($this->check_for_id_duplicate($categoryId)){
            return "ERROR: Cannot create multiple Budgets for same Category";
        } 

        $categoryName = $this->categories->get_category_name($categoryId);

        $query = "INSERT INTO `budgets` (user_id, category_id, category_name, budget, periodicity) VALUES ($userid, $categoryId, '$categoryName', $budget, $periodicity)";

        mysqli_query($this->connection, $query);

    }
    
    //helper function for add_budget(): duplicate checking for budgets table
    protected function check_for_id_duplicate($categoryId){
        
        $userid = $_SESSION['userid'];
        $query = "SELECT category_id FROM `budgets` WHERE category_id = $categoryId AND user_id = $userid";
        $result = mysqli_query($this->connection, $query);
        if(mysqli_fetch_array($result)){
            return true;
        } else {
            return false;
        }

    }
    
    public function delete_budget(){

        $categoryId = $_POST['categoryId'];
        $query = "DELETE FROM `budgets` WHERE category_id = $categoryId";

        mysqli_query($this->connection, $query);

    }

}



?>
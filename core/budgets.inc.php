<?php

class Budgets {
    
    /**
     * Database connection link
     * 
     * @var mysqli (FALSE when connection failed, otherwise its an mysqli object)
     */
    protected $connection;

    /**
     * Categories
     * 
     * @var Categories 
     */
    protected $categories;
    
    /**
     * Budgets constructor
     */
    public function __construct() {
        require '../core/dbconnection.inc.php';
        $this->connection = $link;
        $this->categories = new Categories();
    }
    
    /**
     * retireves all budgets from the database and encodes it in a JSON String
     * 
     * @return String (in JSON format)
     */ 
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
    
    /**
     * adds new budget to databse - gets the data via POST and returns an error message if ist a duplicate
     * 
     * @return String
     */ 
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

        return "";

    }
    
    /**
     * helper function for add_budget(): duplicate checking for budgets table
     * 
     * @return Boolean
     */ 
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
    
    /**
     * deletes budget by the categoryId given via POST
     */ 
    public function delete_budget(){

        $categoryId = $_POST['categoryId'];
        $query = "DELETE FROM `budgets` WHERE category_id = $categoryId";

        mysqli_query($this->connection, $query);

    }

}



?>
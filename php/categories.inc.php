<?php

class Categories{
    
    protected $connection;
    
    public function __construct() {
        require '../php/dbconnection.inc.php';
        $this->connection = $link;
    }
    
    //returns all categories in JSON format
    //categoryId will be value of the options
    public function get_categories(){

        $userid = $_SESSION['userid'];
        $query = "SELECT * FROM categories WHERE user_id = 0 OR user_id = $userid";

        $result = mysqli_query($this->connection, $query);

        while($row = mysqli_fetch_array($result)){
            $categoryId = (int)$row['category_id'];
            $categoryName = $row['name'];


            $return_arr[] = array("categoryId" => $categoryId,
                                  "categoryName" => $categoryName);
        }
        return json_encode($return_arr);

    }
    
    public function get_category_name($categoryId){
        
        $query = "SELECT * FROM `categories` WHERE category_id = $categoryId";

        $result = mysqli_query($this->connection, $query);
        $row = mysqli_fetch_array($result);
        return $row['name'];
    
    }
    
    public function add_category(){
    
        require './php/dbconnection.inc.php';

        $userid = $_SESSION['userid'];
        $categoryName = $_POST['categoryName'];

        //duplicate checking 
        if(check_for_name_duplicate($categoryName)){
            return "ERROR: Cannot create multiple Budgets for same Category";
        } 

        $query = "INSERT INTO `categories` (user_id, name) VALUES ($userid, '$categoryName')";

        if(!mysqli_query($this->connection, $query)){
            return mysqli_error($this->connection);
        }
    }
    
    //helper function for add_category(): duplicate checking for categories table
    protected function check_for_name_duplicate($name){

        require './php/dbconnection.inc.php';

        $query = "SELECT category_id FROM `categories` WHERE name = '$name'";
        $result = mysqli_query($this->connection, $query);
        if(mysqli_fetch_array($result)){
            return true;
        } else {
            return false;
        }

    }
    
    //returns html for options in Categories selector
    //categoryId is value because the delete function needs to know what to delete..
    public function get_html_select_options(){

        $options = "";
        $categoriesArray = json_decode($this->get_categories(), true);

        foreach ($categoriesArray as $category){

            $options .= "<option value='";
            $options .= $category['categoryId'];
            $options .= "'>";
            $options .= $category['categoryName'];
            $options .= "</option>";
        }

        return $options;
    }
    
    public function delete_category(){

        $categoryId = $_POST['categoryId'];
        
        $query = "DELETE FROM `categories` WHERE category_id = $categoryId AND user_id != 0";

        mysqli_query($this->connection, $query);

    }

}



?>
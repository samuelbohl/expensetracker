<?php

class Categories {
    
    /**
     * Database connection link
     * 
     * @var mysqli (FALSE when connection failed, otherwise its an mysqli object)
     */ 
    protected $connection;
    
    /**
     * Categories Contructor
     */ 
    public function __construct() {
        require '../php/dbconnection.inc.php';
        $this->connection = $link;
    }
    
    /**
     * returns all categories from the database in JSON format
     * categoryId will be value of the options
     * 
     * @return String (in JSON fromat)
     */ 
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
    
    /**
     * retrieves the category name from the database
     * 
     * @param Integer 
     * 
     * @return String
     */ 
    public function get_category_name($categoryId){
        
        $query = "SELECT * FROM `categories` WHERE category_id = $categoryId";

        $result = mysqli_query($this->connection, $query);
        $row = mysqli_fetch_array($result);
        return $row['name'];
    
    }

    /**
     * gets user information from SESSION and new category name from POST and adds the new category to the database
     * 
     * @return Boolean
     */ 
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
    
    
    /**
     * helper function for add_category(): duplicate checking 
     * 
     * @param String
     * 
     * @return Boolean
     */ 
    private function check_for_name_duplicate($name){

        require './php/dbconnection.inc.php';

        $query = "SELECT category_id FROM `categories` WHERE name = '$name'";
        $result = mysqli_query($this->connection, $query);
        if(mysqli_fetch_array($result)){
            return true;
        } else {
            return false;
        }

    }
    
    /**
     * generates html for options in Categories selector
     * categoryId is value because the delete function needs to know what to delete.
     * 
     * @return String
     */ 
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
    
    /**
     * gets cetegoryId from POST and deletes the corresponding row from the database
     * 
     * @return Boolean
     */ 
    public function delete_category(){

        $categoryId = $_POST['categoryId'];
        
        $query = "DELETE FROM `categories` WHERE category_id = $categoryId AND user_id != 0";

        return mysqli_query($this->connection, $query);

    }

}



?>
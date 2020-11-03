<?php

//TODO: test
class Transactions {
    
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
     * Transactions constructor
     */ 
    public function __construct() {
        
        require './core/dbconnection.inc.php';
        $this->connection = $link;
        $this->categories = new Categories();
        
    }
    
    /**
     * retrieves all transactions of the current user (gets userid via POST) and encodes it in a JSON String
     * 
     * @return String (in JSON Fromat)
     */ 
    public function get_transactions(){
        
        $userid = $_SESSION['userid']; //mayb with hidden POST for microservices
        $query = "SELECT * FROM transactions WHERE user_id = $userid";
        $result = mysqli_query($this->connection, $query);

        if(!$result){
            echo "Error: " . $query . "<br>" . mysqli_error($link);
        }
        
        $return_arr = [];

        while($row = mysqli_fetch_array($result)){
            $expense = $row['expense'];
            $date = $row['date'];
            $amount = (int)$row['amount'];
            $currency = $row['currency'];
            $categoryId = $row['category_id'];
            $category = $row['category_name'];
            $notes = $row['notes'];
            $account = $row['account'];
            $transactionId = $row['transaction_id'];

            $return_arr[] = array("expense" => $expense,
                                  "date" => $date,
                                  "amount" => $amount,
                                  "currency" => $currency,
                                  "category" => $category,
                                  "categoryId" => $categoryId,
                                  "notes" => $notes,
                                  "account" => $account,
                                  "transactionId" => $transactionId);
        }

        return json_encode($return_arr);
    }
    
    /**
     * adds new transaction to database (gets data from POST) and returns an error message if it failed
     * 
     * @return String 
     */ 
    public function add_transaction(){
        
        //TODO
        //works, better solution for category_id is needed in case of income

        $userid = $_SESSION['userid'];
        $expense = $_POST['expense'];
        $date = $_POST['date'];
        $amount = $_POST['amount'];
        $currency = $_POST['currency'];
        $categoryId = $_POST['category_id'];
        $periodicity = $_POST['periodicity'];
        $notes = $_POST['notes'];
        $account = 1; //possible later feature for multiple accounts

        //if it is an income
        if($expense == 0){
            $categoryName = "-";
        } else {
            $categoryName = $this->categories->get_category_name($categoryId);
        }

        $query = "INSERT INTO transactions (user_id, expense, date, amount, currency, category_id, category_name, periodicity, notes, account) VALUES ($userid, $expense, '$date', $amount, '$currency', $categoryId, '$categoryName', $periodicity, '$notes', $account)";

        if(!mysqli_query($this->connection, $query)){
            return mysqli_error($link);
        }  
    }
    
    /**
     * deletes transaction by id (from POST)
     */ 
    public function delete_transaction(){
        
        $userid = $_SESSION['userid'];
        
        $transactionId = $_POST['transactionId'];
        
        $query = "DELETE FROM `transactions` WHERE transaction_id = $transactionId AND user_id = $userid";

        mysqli_query($this->connection, $query);
        
    }
    
    
}


?>

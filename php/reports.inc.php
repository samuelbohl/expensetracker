<?php

class Reports {
    
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
     * Categories
     * 
     * @var Transactions 
     */
    protected $transactions;

    /**
     * Budgets
     * 
     * @var Budgets 
     */
    protected $budgets;


    /**
     * Reports constructor
     */ 
    public function __construct() {
        require '../php/dbconnection.inc.php';
        $this->connection = $link;
        $this->categories = new Categories();
        $this->transactions = new Transactions();
        $this->budgets = new Budgets();
    }
    
    /**
     * returns all categories that have expenses and for each category the amount spent is summed up
     * 
     * @return String (in JSON Fromat)
     */ 
    public function get_summed_expenses_by_categories(){

        $transactions = $this->transactions->get_transactions();
        $transactionsArray = json_decode($transactions, true);

        $categories = $this->categories->get_categories();
        $categoriesArray = json_decode($categories, true);

        $return_arr = [];


        foreach($categoriesArray as $category){

            $created = false;

            foreach($transactionsArray as $transaction){

                if($transaction['categoryId'] == $category['categoryId'] && $created){

                    $return_arr[$transaction['categoryId']]['amount'] += $transaction['amount'];

                //$transaction['categoryId'] == 0 for all incomes, we need only expenses.
                } else if(!$created && $transaction['categoryId'] != 0 && !array_key_exists($transaction['categoryId'], $return_arr)){

                    //return Array: Index is CategoryId
                    $return_arr[$transaction['categoryId']] = array("categoryName" => $transaction['category'],
                                                                    "amount" => $transaction['amount']);
                    $created = true;
                }
            }
        }

        return json_encode($return_arr);
    }

    /**
     * summes up all expenses by the month
     * 
     * @return String (in JSON Fromat)
     */ 
    public function get_summed_expenses_by_month(){
        
        //TODO only for the past year (because of transactions in the future..)

        $transactions = $this->transactions->get_transactions();
        $transactionsArray = json_decode($transactions, true);

        $return_arr = [];

        //initializing array for the 12 months of a year
        for($i = 0; $i < 12; $i++){
            $return_arr[$i] = 0;
        }

        foreach($transactionsArray as $transaction){

            if($transaction['expense'] == 1){

                //extract month number: 'm'=09, 'n'=9, 'M'=Sep
                $month = date('n',strtotime($transaction['date']));

                //sums expenses of each month and put it into return_arr[month-1];
                $return_arr[$month-1] += $transaction['amount'];
            }
        }

        //returns return_arr and insert the array as data for datatable
        return json_encode($return_arr);

    }

    /**
     * calculates percentage of every budget goal
     * 
     * @return String (in JSON Fromat)
     */ 
    function get_percentage_of_budget_goals(){

        $summedExpensesByCategories = json_decode($this->get_summed_expenses_by_categories(), true);

        $budgetGoals = json_decode($this->budgets->get_budgets(), true);

        $percentageOfBudgetGoals = [];

        $index = 0;

        foreach($budgetGoals as $budgetGoal){

            $id = $budgetGoal['categoryId'];

            $percentageOfBudgetGoals[$index] = array(0 => $summedExpensesByCategories[$id]['amount'] / (float) $budgetGoal['budget'],
                                                     1 => $budgetGoal['categoryName']);

            $index++;

        }

        return json_encode($percentageOfBudgetGoals);
    }


}



?>
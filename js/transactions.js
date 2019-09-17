//Set the Date input fields to today
document.getElementById('date').valueAsDate = new Date();
//document.getElementById('dateInc').valueAsDate = new Date();

//get the Expense inputs and pass it to addTransaction
function addExpense(){
	//console.log("add");
	var id = $_GET('userid');
	console.log(id);
	var date = $('#date').val();
	var amount = $('#amount').val();
	var category = $("#category option:selected").val();
	var notes = $('#notes').val();
	addTransaction(1, date, amount, category, notes);
}
//get the Income inputs and pass it to addTransaction
function addIncome(){
	var date = $('#dateInc').val();
	var amount = $('#amountInc').val();
	var periodicity = $("#peridicity option:selected").val()
	var notes = $('#notesInc').val();
	addTransaction(0, date, amount, periodicity, notes);
}
//recieves inputs and calls the BackendPHP script to save it to the DB
function addTransaction(exp, date, amount, category, notes){
	
	var id = $_GET('userid');
	console.log(id);
	$.ajax(
	{
	type: "POST",
	url: "php/add_transaction.php",
	data: {'userid': id,
		'exp': 1,
	'date': date,
	'amount': amount,
	'currency': 'CHF',
	'category': category,
	'notes': notes,
	'account': 1
	},

	success: function(html)
	{
	alert(html);
	},
	error: function(html)
	{
	alert(html);
	}
	});
}

function $_GET(q,s) {
	s = (s) ? s : window.location.search;
	var re = new RegExp('&amp;'+q+'=([^&amp;]*)','i');
	return (s=s.replace(/^\?/,'&amp;').match(re)) ?s=s[1] :s='';
}

//recieves all the transactions from the DB (via Backend PHP script) and adds it to the table (echo $transactions = getTransactions();)
function getTransactions(responseFromDB){

        var transactions = JSON.stringify(responseFromDB);
        var jsonTransactions = JSON.parse(transactions);
        console.log(transactions);
        var len = jsonTransactions.length;
    
    	for(var i = 0; i < len; i++){
            var expense = jsonTransactions[i].expense;
            var date = jsonTransactions[i].date;
            var amount = jsonTransactions[i].amount;
            var currency = jsonTransactions[i].currency;
            var category = jsonTransactions[i].category;
            var notes = jsonTransactions[i].notes;
            var account = jsonTransactions[i].account;
            var transactionId = jsonTransactions[i].transactionId;

            //if its an expense display as negative
            if(expense == 1){ amount = 0 - amount;}
            
            //Append to Datatable
            var t = $('#dataTable').DataTable();
            t.row.add( [
                date,
                account,
                category,
                notes,
                amount+" "+currency,
                "<form method='post' style='margin: 0; padding: 0;'><button type='submit' name='delete' value='Delete'><i class='fas fa-trash-alt'></i><input type='hidden' name='transactionId' value='"+transactionId+"'></button></form>"
            ] ).draw( false );
		
	} 
}

//recieves all the transactions from the DB (via Backend PHP script) and adds it to the table
/*
function getTransactions(){
	var id = $_GET('userid');
	console.log(id);
	$.ajax({
	type: "GET",
	url: "php/get_transactions.php",
	data: { 'userid': id},
	dataType: 'JSON',
	success: function(response){
	var len = response.length;
	for(var i = 0; i < len; i++){
		var date = response[i].date;
		var amount = response[i].amount;
		var currency = response[i].currency;
		var categoryid = response[i].categoryid;
		var category = response[i].category;
		var notes = response[i].notes;
		var account = response[i].account;
		
		//inserting in table with datatables instead of manually
		var t = $('#dataTable').DataTable();
		t.row.add( [
            date,
			account,
            category,
            notes,
            amount+" "+currency
        ] ).draw( false );
		
		/*
		var tr_str = "<tr>" +
                    "<td>" + date + "</td>" +
                    "<td>" + category + "</td>" +
                    "<td>" + notes + "</td>" +
                    "<td>" + amount + "</td>" +
                    "</tr>";
		var table = $("#dataTable tbody").html();
		$("#dataTable tbody").html(table+tr_str);
		*/
/*
	}
	}
	});
}
*/

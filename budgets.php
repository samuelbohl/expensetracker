<?php

//Display errors
ini_set('display_errors', 1);
error_reporting(~0);

//require all include files
require './core/config.inc.php';

//authenticate user
$authentication = new Authentication();
$authentication->validate_session();

//get user information
$user = new User();
$name = $user->get_fullname();

$budgets = new Budgets();

//if user wants to delete a budget
if(array_key_exists("delete", $_POST)){
    $budgets->delete_budget();
}

//if user wants to add a budget
if(array_key_exists("submit", $_POST)){
    $budgets->add_budget();
}

//get all the budget information from the database
$budgetsArray = $budgets->get_budgets();

//get all the categories
$categories = new categories();
$optionsHTML = $categories->get_html_select_options();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Expense Tracker</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
                <i class="fas fa-coins fa-2x"></i>
                <div class="sidebar-brand-text mx-3">Expense Tracker</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Transactions -->
            <li class="nav-item">
                <a class="nav-link" href="transactions.php" style="padding-top: 0;">
                    <i class="fas fa-fw fa-exchange-alt"></i>
                    <span>Transactions</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Reports -->
            <li class="nav-item">
                <a class="nav-link" href="reports.php" style="padding-top: 0;">
                    <i class="fas fa-fw fa-chart-bar"></i>
                    <span>Reports</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Budgets -->
            <li class="nav-item active">
                <a class="nav-link" href="budgets.php" style="padding-top: 0;">
                    <i class="fas fa-fw fa-chart-pie"></i>
                    <span>Budgets</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Categories -->
            <li class="nav-item">
                <a class="nav-link" href="categories.php" style="padding-top: 0;">
                    <i class="fas fa-fw fa-tags"></i>
                    <span>Categories</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
  
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $name; ?></span>
                                <i class="fas fa-user-circle"></i>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="./profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile
                                </a>
                                <a class="dropdown-item" href="settings.php">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> Settings
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Content Row -->
                    <div class="row justify-content-center">

                        <div class="col-lg-11">

                            <!-- Basic Card Example -->
                            <div class="card shadow mb-4 border-left-primary">
                                <div class="card-header py-3">
                                    <h4 class="m-0 font-weight-bold text-primary">Your Budgets <a href="#" data-toggle="modal" data-target="#budgetModal" class="float-right d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Add New Budget</a></h4>

                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-md-6">

                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="budgetTable" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>Category</th>
                                                            <th>Budget</th>
                                                            <th>Time period</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Data Tables inserst here -->
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                        <div class="col-md-4">

                                            <div class="chart-pie pt-4 pb-2">
                                                <canvas id="myPieChart"></canvas>
                                            </div>
                                            <div class="mt-4 text-center small" id="pieChartLables">
                                                
                                                <!-- Insert Labels Here -->
                                                
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Samuel Bohl 2019</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.php?logout=1">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Budget Modal-->
    <div class="modal fade" id="budgetModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="m-0 font-weight-bold text-primary">Add New Budget</h6>
                </div>
                <div class="modal-body">

                    <form class="form-row" method="post">
                        <div class="form-group col-md-6">
                            <select id="category" name="category" class="form-control">
                                <option value="0" selected>Category</option>
                                <?php echo $optionsHTML; ?>
                                <!--
                                <option value="1">Food</option>
                                <option value="2">Household</option>
                                <option value="3">Gas</option>
                                <option value="4">Snacks</option>
                                <option value="5">Tickets</option>
                                -->
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="amount" class="form-control" id="amount" placeholder="0.00 CHF" required>
                        </div>

                        <div class="col-md-6">
                            <input type="submit" name="submit" value="Add Budget" class="btn btn-primary btn-user btn-block">
                            <!--
                            <a href="" class="btn btn-primary btn-icon-split"><span class="icon text-white-50">
                  			<i class="fas fa-plus"></i>
                    	</span>
                    	<span class="text">Add Budget</span>
                    	</a>
-->
                        </div>

                        <div class="col-md-6">
                            <select id="durations" name="periodicity" class="form-control">
                                <option value="0" selected>Time period</option>
                                <option value="7">Week</option>
                                <option value="30">Month</option>
                                <option value="356">Year</option>
                            </select>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    

    <script type="text/javascript" src="js/transactions.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    
    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    
    <script type="text/javascript">
        
        addBudgetsToTable();
        
        function addBudgetsToTable(){

            var budgets = JSON.stringify(<?php echo $budgetsArray; ?>);
            var jsonBudgets = JSON.parse(budgets);
            var len = jsonBudgets.length;
            
            for(var i = 0; i < len; i++){
                //append to table
                var t = $('#budgetTable').DataTable();
                t.row.add( [
                    jsonBudgets[i].categoryName,
                    jsonBudgets[i].budget+" "+"CHF",
                    valueAsPeriod(jsonBudgets[i].periodicity),
                    "<form method='post' ><button type='submit' name='delete' value='Delete'> <input type='hidden' name='categoryId' value='"+jsonBudgets[i].categoryId+"'><i class='fas fa-trash-alt'></i></button></form>"
                ] ).draw( false );
            }
            
        }
        
        function valueAsPeriod(value){
            if(value == 7){
                return "Weekly";
            } else if(value == 30){
                return "Monthly";
            } else if(value = 356){
                return "Yearly";
            } else {
                return "N/a";
            }
        }
        
        getBudgetsAndCreatePieChart();
        
        function getBudgetsAndCreatePieChart(){
            
            var budgets = JSON.stringify(<?php echo $budgetsArray; ?>);
            var jsonBudgets = JSON.parse(budgets);
            var len = jsonBudgets.length;
            
            var budgetLabels = [];
            var budgets = [];
            for(var i = 0; i < len; i++){
                budgetLabels[i] = jsonBudgets[i].categoryName;
                budgets[i] = jsonBudgets[i].budget;
               
            }
            
            var ctx = document.getElementById("myPieChart");
            var myPieChart = new Chart(ctx, {
              type: 'doughnut',
              data: {
                labels: budgetLabels,
                datasets: [{
                  data: budgets,
                  backgroundColor: ['#0275d8', '#5cb85c', '#5bc0de', '#f0ad4e', '#d9534f', '#868e96', '#343a40', 'f8f9fa'],
                  hoverBackgroundColor: ['#0275d8', '#5cb85c', '#5bc0de', '#f0ad4e', '#d9534f', '#868e96', '#343a40', 'f8f9fa'],
                  hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
              },
              options: {
                maintainAspectRatio: false,
                tooltips: {
                  backgroundColor: "rgb(255,255,255)",
                  bodyFontColor: "#858796",
                  borderColor: '#dddfeb',
                  borderWidth: 1,
                  xPadding: 15,
                  yPadding: 15,
                  displayColors: false,
                  caretPadding: 10,
                },
                legend: {
                  display: false
                },
                cutoutPercentage: 80,
              },
            });
            
            //Labels
            var labels = "";
            //['#0275d8', '#5cb85c', '#5bc0de', '#f0ad4e', '#d9534f', '#868e96', '#343a40', 'f8f9fa']
            var colours = ["primary", "success", "info", "warning", "danger", "secondary", "dark", "light"];
            for(var i = 0; i < budgetLabels.length; i++){
                labels+="<span class='mr-2'><i class='fas fa-circle text-"+colours[i]+"'></i>"+" "+budgetLabels[i]+"</span>";
            }

            //insert labels into html
            $('#pieChartLables').append(labels);
            
        }
    
    </script>

</body>

</html>

<!--  -->
<?php

//Display errors
ini_set('display_errors', 1);
error_reporting(~0);

//require all include files
require './php/config.inc.php';

//authenticate user
$authentication = new Authentication();
$authentication->validate_session();

//get user information
$user = new User();
$name = $user->get_fullname();

$transactions = new Transactions();
$categories = new Categories();

//if user added a transaction
if(array_key_exists("submit", $_POST)){
    $transactions->add_transaction();
}

//if user wants to delete transaction
if(array_key_exists("delete", $_POST)){
    $transactions->delete_transaction();
}

//get all transactions
$transactionsArray = $transactions->get_transactions();

//get all categories
$optionsHTML = $categories->get_html_select_options();

?>

<html lang="en"><head>

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

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
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
            <li class="nav-item active">
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
            <li class="nav-item">
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
            <template>

                <!-- Heading -->
                <div class="sidebar-heading">
                    Interface
                </div>

                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Budgets</span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Custom Components:</h6>
                            <a class="collapse-item" href="buttons.html">Buttons</a>
                            <a class="collapse-item" href="cards.html">Cards</a>
                        </div>
                    </div>
                </li>

                <!-- Nav Item - Utilities Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fas fa-fw fa-wrench"></i>
                        <span>Utilities</span>
                    </a>
                    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Custom Utilities:</h6>
                            <a class="collapse-item" href="utilities-color.html">Colors</a>
                            <a class="collapse-item" href="utilities-border.html">Borders</a>
                            <a class="collapse-item" href="utilities-animation.html">Animations</a>
                            <a class="collapse-item" href="utilities-other.html">Other</a>
                        </div>
                    </div>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Addons
                </div>

                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Pages</span>
                    </a>
                    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Login Screens:</h6>
                            <a class="collapse-item" href="login.html">Login</a>
                            <a class="collapse-item" href="register.html">Register</a>
                            <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                            <div class="collapse-divider"></div>
                            <h6 class="collapse-header">Other Pages:</h6>
                            <a class="collapse-item" href="404.html">404 Page</a>
                            <a class="collapse-item" href="blank.html">Blank Page</a>
                        </div>
                    </div>
                </li>

                <!-- Nav Item - Charts -->
                <li class="nav-item">
                    <a class="nav-link" href="charts.html">
                        <i class="fas fa-fw fa-chart-area"></i>
                        <span>Charts</span></a>
                </li>

                <!-- Nav Item - Tables -->
                <li class="nav-item">
                    <a class="nav-link" href="tables.html">
                        <i class="fas fa-fw fa-table"></i>
                        <span>Tables</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">
            </template>
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
                                <a class="dropdown-item" href="#">
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
                        <div class="col-md-11 justify-content-center">
                            <!-- Basic Card Example -->
                            <div class="card shadow mb-4 border-left-primary">
                                <div class="card-header py-3  d-sm-flex align-items-center justify-content-between">
                                    <h4 class="m-0 font-weight-bold text-primary">Your Transactions</h4>
                                    <div class="">

                                        <a href="#" data-toggle="modal" data-target="#expenseModal" class=" d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Track New Expense</a>
                                        <a href="#" data-toggle="modal" data-target="#incomeModal" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Add New Income</a>
                                        <a href="#" data-toggle="modal" data-target="#recieptModal" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Upload Reciept</a>

                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                  <th>Date</th>
                                                  <th>Account</th>
                                                  <th>Category</th>
                                                  <th>Notes</th>
                                                  <th>Amount</th>
                                                  <th></th>
                                                </tr>
                                              </thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
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
                        <span>Copyright © Samuel Bohl 2019</span>
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
                    <a class="btn btn-primary" href="href='login.php?logout=1'">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Expense Modal-->
    <div class="modal fade" id="expenseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Track New Expense</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-row" method="post">
                        <div class="form-group col-md-8">
                            <select id="category" name="category_id" class="form-control">
                                <option value="0" selected="">Category</option>
                                <?php echo $optionsHTML; ?>                          
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="amount" id="amount" placeholder="0.00 CHF" required="">
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="notes" id="notes" placeholder="Notes" required="">
                        </div>
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="date" id="date" value="2018-12-02" required="">
                        </div>
                        <div class="col-md-4" style="margin-top: 20px;">
                            <input type="hidden" name="periodicity" value="0">
                            <input type="hidden" name="currency" value="CHF">
                            <input type="hidden" name="expense" value="1">
                            <input type="submit" name="submit" value="Add Expense" class="btn btn-primary btn-user btn-block">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Income Modal-->
    <div class="modal fade" id="incomeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Income</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-row" method="post">
                        <div class="form-group col-md-8">
                            <select id="periodicity" name="periodicity" class="form-control">
                                <option value="0" selected="">Periodicity</option>
                                <option value="1">Once</option>
                                <option value="30">Monthly</option>
                                <option value="90">Every 3 Months</option>
                                <option value="180">Every 6 Months</option>
                                <option value="365">Every Year</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="amount" id="amountInc" placeholder="0.00 CHF" required="">
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="notes" id="notesInc" placeholder="Notes" required="">
                        </div>
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="date" id="dateInc" required="">
                        </div>
                        <div class="col-md-4" style="margin-top: 20px;">
                            <input type="hidden" name="category_id" value="0">
                             <input type="hidden" name="currency" value="CHF">
                            <input type="hidden" name="expense" value="0">
                            <input type="submit" name="submit" value="Add Income" class="btn btn-primary btn-user btn-block">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reciept Modal-->
    <div class="modal fade" id="recieptModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Reciept</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-row" method="post">
                        <div class="form-group col-md-8">
                            <select id="category" name="category_id" class="form-control">
                                <option value="0" selected="">Category</option>
                                <?php echo $optionsHTML; ?>                          
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="amount" id="amount" placeholder="0.00 CHF" required="">
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="notes" id="notes" placeholder="Notes" required="">
                        </div>
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="date" id="date" value="2018-12-02" required="">
                        </div>
                        <div class="col-md-8" style="margin-top: 20px;"><input type="file" name="uploadfile" size="60" maxlength="255"></div>
                        <div class="col-md-4" style="margin-top: 20px;">
                            <input type="hidden" name="periodicity" value="0">
                            <input type="hidden" name="currency" value="CHF">
                            <input type="hidden" name="expense" value="1">
                            <input type="submit" name="upload" value="Upload" class="btn btn-primary btn-user btn-block">
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
        // Call the dataTables jQuery plugin
        $(document).ready(function() {
            $('#dataTable').DataTable();
            
            getTransactions(<?php echo $transactionsArray; ?>);
        });
    </script>




</body></html>
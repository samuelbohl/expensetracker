<?php

//require all include files
require './core/config.inc.php';

session_start();

//logout
$authentication = new Authentication();
$authentication->logout();

session_destroy();


// Redirect to the login page:
header('Location: login.php');
?>
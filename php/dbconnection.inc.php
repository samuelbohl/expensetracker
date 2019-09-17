<?php

    
$link = mysqli_connect("localhost:3306", "root", "root", "expensetracker");

//$link = mysqli_connect("db5000130631.hosting-data.io", "dbu347873", "@3xpenceTrack", "dbs125420");


if (mysqli_connect_error()) {

    die ("Database Connection Error");

}

?>

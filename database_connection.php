<?php 

//database_connection.php

$connect = new PDO("mysql:host=localhost;dbname=testing", "root", "");

// $con = mysqli_connect("localhost","root","","LoginSystem");

$con = mysqli_connect("localhost","root","","LoginSystem");
    // Check connection
    if (mysqli_connect_errno()){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
?>
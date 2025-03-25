<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "dubudubu_tracker";

// create connection
// $conn = new mysqli($servername, $username, $password, $database);
$conn = mysqli_connect("$host", "$username", "$password","$database")or die("cannot connect"); 
    // mysqli_select_db($conn,"$db_name")or die("cannot select DB");
?>

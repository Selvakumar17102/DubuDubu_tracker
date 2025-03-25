<?php
session_start();
include("../include/connection.php");

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $status = 0;

        $sql = "SELECT * FROM designation WHERE desig_id='$id'";
        $result = $conn->query($sql);
        $row = mysqli_fetch_array($result);
        if($row['status'] == 0){
            $status = 1;
        }

        $sql = "UPDATE designation SET status='$status' WHERE desig_id='$id'";
        if($conn->query($sql) === TRUE){
            echo 'true';
        }
}
?>

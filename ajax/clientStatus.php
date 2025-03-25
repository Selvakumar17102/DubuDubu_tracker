<?php
session_start();
include("../include/connection.php");

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $status = 0;

        $sql = "SELECT * FROM client WHERE client_id='$id'";
        $result = $conn->query($sql);
        $row = mysqli_fetch_array($result);
        if($row['client_status'] == 0){
            $status = 1;
        }

        $sql = "UPDATE client SET client_status='$status' WHERE client_id='$id'";
        if($conn->query($sql) === TRUE){
            echo 'true';
        }
}
?>

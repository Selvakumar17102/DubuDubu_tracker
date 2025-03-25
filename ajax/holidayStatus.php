<?php
session_start();
include("../include/connection.php");

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $status = 'active';

        $sql = "SELECT * FROM holidays WHERE id='$id'";
        $result = $conn->query($sql);
        $row = mysqli_fetch_array($result);
        if($row['status'] == 'active'){
            $status = 'inactive';
        }

        $sql = "UPDATE holidays SET status='$status' WHERE id='$id'";
        if($conn->query($sql) === TRUE){
            echo 'true';
        }
}
?>

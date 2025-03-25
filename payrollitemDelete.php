<?php
include('include/connection.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM payroll_details WHERE id='$id'";
    if($conn->query($sql) === TRUE){
        header("Location: payrollitem.php");
    }
}
?>
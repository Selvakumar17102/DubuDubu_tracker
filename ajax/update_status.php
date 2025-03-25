<?php
include "../include/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emp_id = $_POST['emp_id'];
    $status = $_POST['status'];

    if($status != "Active"){
        $date = date('Y-m-d');
    }else{
        $date = NULL;
    }

    $query = "UPDATE employee SET emp_status = ?, resign_date = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $status, $date, $emp_id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
    $conn->close();
}
?>

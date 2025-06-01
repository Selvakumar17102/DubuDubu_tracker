<?php
session_start();
include("../include/connection.php");

if (isset($_SESSION['id'])) {
    $emp_id = $_SESSION['id'];

    $query = "UPDATE employee SET online_status = 'Offline' WHERE id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $emp_id);
    $stmt->execute();
    $stmt->close();

    // Destroy the session
    session_destroy();
    echo 'success';
} else {
    echo 'No active session';
}
?>

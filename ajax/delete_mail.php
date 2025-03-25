<?php
header('Content-Type: application/json');
session_start();
include("../include/connection.php");

if (isset($_POST['mail_id'])) {
    $mail_id = $_POST['mail_id'];

    $sql = "UPDATE mail SET status = 'deleted' WHERE mail_id = '$mail_id' AND status = 'pending'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Email undone successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
    }
}

?>
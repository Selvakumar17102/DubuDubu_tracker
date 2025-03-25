<?php
header('Content-Type: application/json');
session_start();
include("../include/connection.php");


if (isset($_POST['mail_id'])) {
    $mail_id = $_POST['mail_id'];

    $query = "SELECT * FROM mail WHERE mail_id='$mail_id' AND status='pending'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $sql = "UPDATE mail SET status='sent' WHERE mail_id='$mail_id'";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Email sent successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
        }
            
        
    } else {
        echo json_encode(["status" => "error", "message" => "Email was undone."]);
    }
}

?>
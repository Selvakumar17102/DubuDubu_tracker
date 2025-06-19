<?php
session_start();
include("../include/connection.php");

if (isset($_POST['message'])) {
    $message = trim($_POST['message']);
    $user_id = $_SESSION['id'];
    $created_at = date("Y-m-d H:i:s");

    $stmt = $conn->prepare("INSERT INTO announcements (user_id, message, created_at) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $message, $created_at);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "DB insert failed"]);
    }
}
?>

<?php
session_start();
include("../include/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["mail_id"])) {
    $mailId = intval($_POST["mail_id"]);
    $userId = $_SESSION["id"];

    
    $query = "SELECT deleted_at FROM mail WHERE mail_id = $mailId";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $deletedAt = $row['deleted_at'];

    $deletedUsers = !empty($deletedAt) ? explode(",", $deletedAt) : [];
    if (!in_array($userId, $deletedUsers)) {
        $deletedUsers[] = $userId;
    }

    $updatedDeletedAt = implode(",", $deletedUsers);

    $updateQuery = "UPDATE mail SET deleted_at = '$updatedDeletedAt' WHERE mail_id = $mailId";
    if ($conn->query($updateQuery)) {
        echo "success";
    } else {
        echo "error";
    }

    $conn->close();
}
?>

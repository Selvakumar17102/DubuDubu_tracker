<?php
session_start();
include("../include/connection.php");

$userId = $_SESSION['id'];
$mailId = $_POST['mail_id'];
$isChecked = $_POST['is_checked'];

if ($userId && $mailId) {
    $query = "SELECT starred FROM mail WHERE mail_id = '$mailId'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $starredUsers = explode(',', $row['starred']);

    if ($isChecked) {
        if (!in_array($userId, $starredUsers)) {
            $starredUsers[] = $userId;
        }
    } else {
        $starredUsers = array_diff($starredUsers, [$userId]);
    }

    $updatedStarred = implode(',', $starredUsers);
    $updateQuery = "UPDATE mail SET starred = '$updatedStarred' WHERE mail_id = '$mailId'";
    if ($conn->query($updateQuery)) {
        echo "Success";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

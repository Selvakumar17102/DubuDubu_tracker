<?php
include("../include/connection.php");
$result = $conn->query("SELECT message, created_at FROM announcements ORDER BY id DESC LIMIT 1");

$announcements = [];
while ($row = $result->fetch_assoc()) {
    $announcements[] = $row;
}

echo json_encode($announcements);
?>

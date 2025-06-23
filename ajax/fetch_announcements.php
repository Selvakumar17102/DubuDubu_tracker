<?php
// include("../include/connection.php");
// $result = $conn->query("SELECT message, created_at FROM announcements ORDER BY id DESC LIMIT 1");

// $announcements = [];
// while ($row = $result->fetch_assoc()) {
//     $announcements[] = $row;
// }

// echo json_encode($announcements);

include("../include/connection.php");
$date = date("Y-m-d");

$query = "SELECT * FROM announcements WHERE from_date <= ? AND to_date >= ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $date, $date);
$stmt->execute();
$result = $stmt->get_result();

$announcements = [];
while ($row = $result->fetch_assoc()) {
    $announcements[] = $row;
}

echo json_encode($announcements);

?>

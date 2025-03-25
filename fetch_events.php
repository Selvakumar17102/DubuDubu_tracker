<?php
include("include/connection.php");

$sql = "SELECT * FROM events";
$result = $conn->query($sql);

$events = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = [
            "title" => $row["title"],
            "venue" => $row["venue"],
            "start" => $row["start_date"],
            "end" => $row["end_date"] ?: null,
            "description" => $row["description"],
            "className" => $row["event_type"]
        ];
    }
}

// Return JSON response
echo json_encode($events);

?>
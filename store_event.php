<?php
include("include/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $venue = $_POST['venue'];
    $sdate = $_POST['sdate'];
    $edate = $_POST['edate'];
    $description = $_POST['description'];
    $event_type = $_POST['event_type'];

    // Insert query
    $sql = "INSERT INTO events (title, venue, start_date, end_date, description, event_type) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $title, $venue, $sdate, $edate, $description, $event_type);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Event added successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to add event"]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
?>

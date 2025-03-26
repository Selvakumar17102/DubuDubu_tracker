<?php
include("include/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $candidateId = $_POST["candidate_id"];
    $newStatus = $_POST["status"];

    $stmt = $conn->prepare("UPDATE job_applications SET candidate_status = ? WHERE id = ?");
    $stmt->bind_param("si", $newStatus, $candidateId);
    $success = $stmt->execute();

    echo json_encode(["success" => $success]);
}
?>

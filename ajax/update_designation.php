<?php
include "../include/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emp_id = $_POST['emp_id'];
    $designation = $_POST['designation'];

    // Validate input
    if (!empty($emp_id) && !empty($designation)) {
        $query = "UPDATE employee SET designation = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $designation, $emp_id);

        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "error";
    }
}
?>

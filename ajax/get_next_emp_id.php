<?php
session_start();
include("../include/connection.php");

if (isset($_POST['company_id']) && isset($_POST['short_name'])) {
    $company_id = $_POST['company_id'];
    $short_name = strtoupper($_POST['short_name']);

    $sql = "SELECT emp_id FROM employee WHERE emp_id LIKE '$short_name%' ORDER BY emp_id DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        preg_match('/(\d+)/', $row['emp_id'], $matches);
        $next_id_number = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
    } else {
        $next_id_number = 1;
    }

    $new_emp_id = $short_name . " " . str_pad($next_id_number, 4, '0', STR_PAD_LEFT);

    echo $new_emp_id;
}
?>

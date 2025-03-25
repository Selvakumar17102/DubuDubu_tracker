<?php
session_start();
include("../include/connection.php");
date_default_timezone_set('Asia/Kolkata');


$employee_id = $_SESSION['id']; 
$date = date("Y-m-d");

$action = $_POST['action'];

if ($action == "punch_in") {
    $punch_in_time = date("H:i:s");

    $check = $conn->query("SELECT * FROM attendance_records WHERE employee_id = '$employee_id' AND date = '$date'");
    if ($check->num_rows == 0) {
        $conn->query("INSERT INTO attendance_records (employee_id, date, punch_in_time) VALUES ('$employee_id', '$date', '$punch_in_time')");
        echo json_encode(["status" => "success", "punch_in_time" => $punch_in_time]);
    } else {
        echo json_encode(["status" => "error", "message" => "Already punched in"]);
    }
}


if ($_POST['action'] == "break") {
    $break_time = date("H:i:s");

    $result = $conn->query("SELECT break_times FROM attendance_records WHERE employee_id='$employee_id' AND date='$date'");
    $row = $result->fetch_assoc();
    
    $break_times = json_decode($row['break_times'], true);
    if (!$break_times) {
        $break_times = [];
    }

    // Append new break start time
    $break_times[] = ["start" => $break_time, "end" => null];

    $break_times_json = json_encode($break_times);
    $conn->query("UPDATE attendance_records SET break_times='$break_times_json' WHERE employee_id='$employee_id' AND date='$date'");
    
    echo json_encode(["status" => "success", "break_time" => $break_time]);
}

if ($_POST['action'] == "resume") {
    $break_end_time = date("H:i:s");

    $result = $conn->query("SELECT break_times FROM attendance_records WHERE employee_id='$employee_id' AND date='$date'");
    $row = $result->fetch_assoc();
    
    $break_times = json_decode($row['break_times'], true);
    
    if ($break_times && count($break_times) > 0) {
        $last_index = count($break_times) - 1;
        $break_times[$last_index]['end'] = $break_end_time;

        $break_times_json = json_encode($break_times);
        $conn->query("UPDATE attendance_records SET break_times='$break_times_json' WHERE employee_id='$employee_id' AND date='$date'");
        
        echo json_encode(["status" => "success", "break_end_time" => $break_end_time]);
    } else {
        echo json_encode(["status" => "error", "message" => "No active break found."]);
    }
}

// if ($action == "break") {
//     $break_time = date("H:i:s");
//     $conn->query("UPDATE attendance SET break_start = '$break_time' WHERE employee_id = $employee_id AND date = '$date'");
//     echo json_encode(["status" => "success", "break_time" => $break_time]);
// }

// if ($action == "resume") {
//     $resume_time = date("H:i:s");
//     $conn->query("UPDATE attendance SET break_end = '$resume_time' WHERE employee_id = $employee_id AND date = '$date'");
//     echo json_encode(["status" => "success", "resume_time" => $resume_time]);
// }

if ($action == "punch_out") {
    $punch_out_time = date("H:i:s");
    $conn->query("UPDATE attendance_records SET punch_out_time = '$punch_out_time' WHERE employee_id = '$employee_id' AND date = '$date'");
    echo json_encode(["status" => "success", "punch_out_time" => $punch_out_time]);
}


// if ($_POST['action'] == 'punch_in') {
//     $date = date('Y-m-d');
//     $punch_in_time = date('Y-m-d H:i:s');

//     $stmtsql = "SELECT id FROM attendance_records WHERE employee_id = '$id' AND date = '$date'";
// 	$stmtRes = $conn->query($stmtsql);

//     if ($stmtRes->num_rows == 0) {
//         $insertSql = "INSERT INTO attendance_records (employee_id, date, punch_in_time) VALUES ('$id', '$date', '$punch_in_time')";
//         $insertRes = $conn->query($insertSql);
//         echo json_encode(['status' => 'success', 'punch_in_time' => $punch_in_time]);
//     } else {
//         echo json_encode(['status' => 'already_punched_in']);
//     }
// }

// if ($_POST['action'] == 'break') {
//     $date = date('Y-m-d');
//     $break_time = date('Y-m-d H:i:s');

//     $stmtsql = "SELECT break_times FROM attendance_records WHERE employee_id = '$id' AND date = '$date'";
//     $stmtRes = $conn->query($stmtsql);
//     $row = $stmtRes->fetch_assoc();

//     $breaks = json_decode($row['break_times'], true) ?? [];
//     $breaks[] = ['start' => $break_time];

//     $break_json = json_encode($breaks);

//     $breakSql = "UPDATE attendance_records SET break_times = '$break_json' WHERE employee_id = '$id' AND date = '$date'";
//     $breakRes = $conn->query($breakSql);
    
//     echo json_encode(['status' => 'success', 'break_time' => $break_time]);
// }


// if ($_POST['action'] == 'punch_out') {
//     $date = date('Y-m-d');
//     $punch_out_time = date('Y-m-d H:i:s');

//     $punchoutSql = "UPDATE attendance_records SET punch_out_time = '$punch_out_time' WHERE employee_id = '$id' AND date = '$date'";
//     $punchoutRes = $conn->query($punchoutSql);

//     echo json_encode(['status' => 'success', 'punch_out_time' => $punch_out_time]);
// }

?>

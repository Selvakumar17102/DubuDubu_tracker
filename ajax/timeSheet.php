<?php
session_start();
include "../include/connection.php";
include "../timeSheet-function.php";

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $hours = $_POST['hours'];
    $appBy = $_POST['approvBy'];
    $pro_id = $_POST['pro_id'];
    $t_id = $_POST['t_id'];
    $task_type = $_POST['task_type'];
    $status = 2;

    $sql = "UPDATE time_sheet SET approval_hrs='$hours', approved_by='$appBy', time_sheet_status='$status' WHERE id='$id'";
    if ($conn->query($sql) === true) {
        if($task_type == 1){
                $project_sql = "SELECT c.billing_hours AS billing_hrs,
                SEC_TO_TIME(SUM(CASE WHEN b.task_type = 1 THEN TIME_TO_SEC(a.approval_hrs) END)) AS app_bill_hrs FROM time_sheet a
                LEFT OUTER JOIN task b ON a.task_id = b.id
                LEFT OUTER JOIN project c ON c.id = a.project_id WHERE c.id = '$pro_id' AND a.time_sheet_status = 2";
                // echo $project_sql;exit();
            $project_result = $conn->query($project_sql);
            $project_row = mysqli_fetch_array($project_result);
            $app_bill_hrs = $project_row['app_bill_hrs'];
            $bill_hrs = $project_row['billing_hrs'];
            $sql = "UPDATE project SET approved_b_hrs = '$app_bill_hrs' WHERE id = '$pro_id'";
            if ($conn->query($sql)) {
                echo 'Bill hrs updated';
            }
        }
        else{
            $project_sql = "SELECT c.non_billing_hours AS non_billing_hrs,
                SEC_TO_TIME(SUM(CASE WHEN b.task_type = 2 THEN TIME_TO_SEC(a.approval_hrs) END)) AS app_non_bill_hrs FROM time_sheet a
                LEFT OUTER JOIN task b ON a.task_id = b.id
                LEFT OUTER JOIN project c ON c.id = a.project_id WHERE c.id = '$pro_id' AND a.time_sheet_status = 2";
                // echo $project_sql;exit();
            $project_result = $conn->query($project_sql);
            $project_row = mysqli_fetch_array($project_result);
            $app_non_bill_hrs = $project_row['app_non_bill_hrs'];
            $non_bill_hrs = $project_row['non_billing_hrs'];
            $sql = "UPDATE project SET approved_non_b_hrs = '$app_non_bill_hrs' WHERE id = '$pro_id'";
            if ($conn->query($sql)) {
                echo 'Non Bill hrs updated';
            }
        }
    }
}

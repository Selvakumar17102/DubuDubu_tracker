<?php

include('../include/connection.php');

$today = date('Y-m-d');

if(isset($_POST['name'])){
    $task_id = $_POST['id'];
    $user_id = $_POST['name'];
    $project_id = $_POST['project'];
    $task = $_POST['task_name'];
    $date = $_POST['date'];
    $hrs = $_POST['hrs'];

    if($task_id == ""){
        $task_sql = "INSERT INTO task (project_id, user_id, task_name, assigned_date, created_date, updated_date, hrs, status, del_status) VALUES ('$project_id', '$user_id', '$task', '$date', '$today', '$today', '$hrs', 0, 0)";
        if($conn->query($task_sql)){
            echo "Success";
        }
    }
    else{
        $task_sql = "UPDATE task SET project_id='$project_id', user_id='$user_id', task_name='$task', assigned_date='$date', updated_date='$today', hrs='$hrs' WHERE id='$task_id'";
        if($conn->query($task_sql)){
            echo "Updated";
        }
    }
}
?>
<?php

include('../include/connection.php');

if(isset($_POST['id'])){
    $id = $_POST['id'];
    // echo $id;

    $task_sql = "SELECT * FROM task WHERE project_id = '$id' AND del_status = 0";
    $task_result = $conn->query($task_sql);
    while($task_row = mysqli_fetch_array($task_result)){
        echo '<option value="'.$task_row['id'].'">'.$task_row['task_name'].'</option>';
    }
}
?>
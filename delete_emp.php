<?php
include('include/connection.php');
if(isset($_GET['edit_id'])){
    $id = $_GET['edit_id'];
    
    $sql = "UPDATE employee SET del_status=1 WHERE id=$id";
    $result =$conn->query($sql);
    if($result == TRUE){
        header('location:user-list.php?msg=Employee Deleted!&type=danger');
    }
}

if(isset($_POST['id'])){
    $emp_id = $_POST['id'];
    $colomn = $_POST['colomn'];
    $file = $_POST['file'];
    $path = $_POST['path'];
    
    if(unlink($path.$file)){
        $fileSql = "UPDATE employee SET $colomn = NULL WHERE id = $emp_id";
        if($conn->query($fileSql) == TRUE){
            echo "True";
        }
    }
}
?>
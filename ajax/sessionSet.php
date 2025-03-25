<?php
    session_start();
    include('../include/connection.php');

    if(isset($_POST['login'])){
        $emp_id = $_POST['login'];
        // echo $emp_id; exit();
        $token = $_POST['token'];
        
        $sql = "SELECT * FROM employee WHERE id = '$emp_id' AND emp_token = '$token'";
        // echo $sql;
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $_SESSION['id'] = $_POST['login'];
            echo 'true';
        }
        else{
            echo 'false';
        }
    }
    else{
        echo 'false';
    }
?>
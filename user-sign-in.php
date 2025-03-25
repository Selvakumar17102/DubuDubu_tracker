<?php

session_start();
include("include/connection.php");
if(isset($_POST['name'])){
    $name = $_POST['name'];
    $pass = $_POST['pass'];
    
    $emp_sql = "SELECT * FROM employee WHERE username='$name' AND password='$pass'";
    $emp_result = $conn->query($emp_sql);
    if($emp_result->num_rows > 0){
        if($emp_row = mysqli_fetch_array($emp_result)){
            $user_id = $emp_row['id'];
            $length = 10;
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for($i = 0; $i < $length; $i++) {
                $randomString .= $characters[random_int(0, $charactersLength - 1)];
            }
            $emp_token = $randomString;
            
            $employee = [];
            
            $emp_sql1 = "UPDATE employee SET emp_token = '$emp_token' WHERE id = '$user_id'";
            if($conn->query($emp_sql1)){
                $employee = [
                    'emp_token' => $emp_token,
                    'emp_id' => $user_id
                ];
            }
            echo json_encode($employee);
            // echo $id;
        }
    }
    else{
        echo "Invalid username or Password";
    }
}
?>
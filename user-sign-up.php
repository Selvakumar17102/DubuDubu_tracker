<?php

include("include/connection.php");
if(isset($_POST['signup'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];
  
    if($pass == $cpass){
      $emp_sql = "SELECT * FROM employee WHERE oemail='$email'";
      $emp_result = $conn->query($emp_sql);
      if($emp_row = $emp_result->num_rows > 0){
        $id = $emp_row['id'];
        $emp_sql1 = "UPDATE employee SET username='$username', password='$pass' WHERE id='$id'";
        $emp_result1 = $conn->query($emp_sql1);
        if($emp_result1 == TRUE){
          $_SESSION['id'] = $id;
          header('location:index.php');
        }
      }
      else{
        echo "Enter your Valid Email";
      }
    }
    else{
      echo "Passwords are mismatched";
    }
  }
?>
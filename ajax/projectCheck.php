<?php

include('../include/connection.php');

if(isset($_POST['client'])){
    $client = $_POST['client'];
    $project = $_POST['project'];

    $dep = $_POST['dept'];
    $department =implode(",",$dep);
    
    $startDate = $_POST['stDate'];
    $deadline =$_POST['endDate'];
    $manhour =$_POST['bhrs'];
    $nonbill = $_POST['nonbhrs'];
    $status =$_POST['status'];

		$pro_sql = "SELECT * FROM project WHERE project_name = '$project' AND project_status != 'Closed'";
		$pro_result = $conn->query($pro_sql);
		if($pro_result->num_rows > 0){
                  echo "Already Exists";
		}
		else{
			$insertSql = "INSERT INTO project (client_id,project_name,dept_id,start_date,dead_line_date,billing_hours,approved_b_hrs,non_billing_hours,approved_non_b_hrs,project_status) VALUES('$client','$project','$department','$startDate','$deadline','$manhour','00:00:00','$nonbill','00:00:00','$status')";
    		      if($conn->query($insertSql) == TRUE){
                      echo "Added";
    		      }
		}
}
?>
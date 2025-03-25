<?php

include('../include/connection.php');

if(isset($_POST['editId'])){
	$id = $_POST['editId'];
    $client = $_POST['client'];
    $project = $_POST['project'];

    $dep = $_POST['dept'];
    $department = implode(",",$dep);
    
    $startDate = $_POST['stDate'];
    $deadline =$_POST['endDate'];
    $manhour =$_POST['bhrs'];
	$nonbill = $_POST['nonbhrs'];
    $status =$_POST['status'];

		$pro_sql = "SELECT * FROM project WHERE project_name = '$project' AND project_status != 'Closed' AND id != '$id'";
		$pro_result = $conn->query($pro_sql);
		if($pro_result->num_rows > 0){
            echo "Exists";
		}
		else{
			$updateSql = "UPDATE project SET client_id='$client', project_name='$project', dept_id='$department', start_date='$startDate', dead_line_date='$deadline', billing_hours='$manhour', non_billing_hours='$nonbill', project_status='$status' WHERE id='$id'" ;
		    if($conn->query($updateSql) == TRUE){
                echo "Updated";
    	    }
		}
}
?>
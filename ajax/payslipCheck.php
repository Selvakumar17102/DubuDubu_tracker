<?php

include('../include/connection.php');

if(isset($_POST['value'])){
    $value = $_POST['value'];
    $month = date('m', strtotime($value));
	$year = date('Y', strtotime($value));
	$firstDay = $year."-".$month."-".'01';
	$lastDay = date('Y-m-t', strtotime($firstDay));

    $sql = "SELECT * FROM employee WHERE del_status = 0 AND control != 5 AND doj <= '$lastDay' AND
    id NOT IN (SELECT id FROM employee WHERE emp_status != 'Active' AND resign_date <= '$firstDay')
    ORDER BY fname ASC";
    $result = $conn->query($sql);
    while($row = mysqli_fetch_array($result)){
        // if($row['resign_date'] == "" || $row['resign_date'] > $lastDay || $row['resign_date'] = $lastDay){
            echo '<option value="'.$row['id'].'">'.$row['fname']." ".$row['lname'].'</option>';
        // }
    }
}
?>
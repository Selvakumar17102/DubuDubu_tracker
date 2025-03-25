<?php

include('../include/connection.php');

$array = [];

if(!empty($_POST['dateValue'])){
    $dateValue = $_POST['dateValue'];

    $sql = "SELECT * FROM employee WHERE del_status = 0 AND control != 5 AND doj <= '$dateValue' AND
    id NOT IN (SELECT id FROM employee WHERE emp_status != 'Active' AND resign_date <= '$dateValue')
    ORDER BY fname ASC";
    $result = $conn->query($sql);
    $i = 1;
    while($row = mysqli_fetch_array($result)){
        $name = '<option value="'.$row['id'].'">'.$row['fname']." ".$row['lname'].'</option>';
        $array[$i]['employee_name'] = $name;
        $i++;
    }
}
echo json_encode($array);

?>
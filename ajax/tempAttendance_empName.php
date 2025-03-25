<?php

include('../include/connection.php');

if(isset($_POST['nameValue'])){
    $id = $_POST['nameValue'];

    $sql = "SELECT * FROM employee WHERE id = '$id'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result);

    echo $row['team'];
}
?>
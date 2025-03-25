<?php
session_start();
include("../include/connection.php");

if(isset($_POST['client_id'])){
    $client_id = $_POST['client_id'];
    $client_short_name = $_POST['client_short_name'];

    if($client_id){   
        $sql = "SELECT * FROM client WHERE client_short_name='$client_short_name' AND client_id!='$client_id'";
        $result = $conn->query($sql);
        if(!$result->num_rows){
            echo 'true';
        } else{
            echo 'false';
        }
    } else{
        $sql = "SELECT * FROM client WHERE client_short_name='$client_short_name'";
        $result = $conn->query($sql);
        if(!$result->num_rows){
            echo 'true';
        } else{
            echo 'false';
        }
    }
}
?>

<?php
	ini_set('display_errors', 'off');
	include('../include/connection.php');
	date_default_timezone_set("Asia/Calcutta");

	$output = array();

	if(!empty($_POST['client_id'])){
		$client_id = $_POST['client_id'];

		$sql = "SELECT * FROM client WHERE client_id='$client_id'";
		$result = $conn->query($sql);
		if($result->num_rows){
			$row = $result->fetch_assoc();

			$output['client_address'] = $row['client_address'];

			$output['status'] = true;
		} else{
			$output['status'] = false;
		}
	} else{
		$output['status'] = false;
	}

	echo json_encode($output);
?>
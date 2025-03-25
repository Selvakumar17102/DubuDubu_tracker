<?php

session_start();
// if(empty($_SESSION['id'])){
// 	header('location: sign-in.php');
// }
ini_set('display_errors','off');
include("include/connection.php");
$task = 'active';
$taskBoolean = 'true';

	$today = date('Y-m-d');
	$time = date('h:i:sa');

if(isset($_POST['addTask'])){
	$id = $_POST['task_id'];
	$project = $_POST['project'];
	// echo $project; exit();

	$task = $_POST['task_name'];
	$type = $_POST['task_type'];

	$value = count($task);
	// print_r($type);
	// echo $value; exit();
	for($i=0; $i<$value; $i++){
		$task1 = $task[$i];
		$type1 = $type[$i];

		$task_sql = "INSERT INTO task (project_id, task_name, task_type, created_date, updated_date, del_status) VALUES ('$project', '$task1', '$type1', '$today', '$today', 0)";
		$task_result = $conn->query($task_sql);
	}
	if($task_result == TRUE){
		header('location: all-tasks.php?msg=Task Added !&type=success');
		// $msg='<div class="alert alert-warning" id="alert_msg">Client Updated Successfully !</div>';
	}
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="ekka - Admin Dashboard HTML Template.">

	<title>DUBU DUBU - Add Task</title>

	<!-- GOOGLE FONTS -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

	<link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />

	<!-- PLUGINS CSS STYLE -->
	<link href="assets/plugins/simplebar/simplebar.css" rel="stylesheet" />

	<!-- ekka CSS -->
	<link id="ekka-css" rel="stylesheet" href="assets/css/ekka.css" />

	<!-- FAVICON -->
	<link href="assets/img/favicon.png" rel="shortcut icon" />

</head>

<body class="ec-header-fixed ec-sidebar-fixed ec-sidebar-dark ec-header-light" id="body">

	<!-- WRAPPER -->
	<div class="wrapper">

		<!-- LEFT MAIN SIDEBAR -->
		<?php include("include/side-bar.php"); ?>

		<!-- PAGE WRAPPER -->
		<div class="ec-page-wrapper">

			<!-- Header -->
			<?php include("include/header.php"); ?>

			<!-- CONTENT WRAPPER -->
			<div class="ec-content-wrapper">
				<div class="content">
					<div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
						<div>
							<h1>Add Task</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Add Task</p>
						</div>
						<div>
							<a href="javascript:history.go(-1)" class="btn btn-primary">Back</a>
						</div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card card-default">
								<div class="card-header card-header-border-bottom">
									<h2>Add Task</h2>
								</div>
								<div class="card-body">
									<div class="row ec-vendor-uploads">
										<div class="col-lg-12">
											<div class="ec-vendor-upload-detail">
												<form id="add_task" method="post" enctype="multipart/form-data">
													<?php
														if(isset($_GET['pro_id'])){
															$id = $_GET['pro_id'];
															$sql = "SELECT *,a.project_id AS project_id FROM task a
															LEFT OUTER JOIN project b ON a.project_id = b.id WHERE a.project_id = $id";
															$result = $conn->query($sql);
															$row = mysqli_fetch_array($result);
														}
													?>
													<div class="row">
													<div class="col-md-6">
														<label class="form-label">Select Project</label>
														<select name="project" id="project" class="form-select" required>
															<option value="">-- Select Project --</option>
                                                            <?php
                                                                $task_sql1 = "SELECT * FROM project WHERE project_status != 'Closed'";
                                                                $task_result1 = $conn->query($task_sql1);
                                                                while($task_row1 = mysqli_fetch_array($task_result1)){
                                                            ?>
																<option value="<?php echo $task_row1['id']; ?>" <?php if($row['project_id'] == $task_row1['id']) { echo "Selected"; }?>><?php echo $task_row1['project_name']; ?></option>
                                                            <?php
                                                            }
                                                            ?>
														</select>
													</div>
													</div>
													<div class="row">
														<div class="col-md-7">
															<label class="form-label">Task Name</label>
															<input type="text" name="task_name[]" id="task_name" required>
														</div>
														<div class="col-md-4">
															<label class="form-label">Task Type</label>
															<select name="task_type[]" id="task_type" class="form-select">
																<!-- <option value="">-- Select HRS --</option> -->
                                                        	    <option value="1">Billing</option>
                                                        	    <option value="2">Non Billing</option>
															</select>
														</div>
														<div class="col-md-1">
															<label class="form-label">Add</label>
															<button type="button" name="add" id="add" class="btn btn-primary form-control">+</button>
														</div>
													</div>
													<div id="next"></div>
                                                    <div class="col-md-12">
														<input type="hidden" name="task_id" id="task_id" value="<?php echo $id; ?>">
														<?php
															if($id > 0){
														?>
																<button type="submit" name="addTask" id="addTask" class="btn btn-success">Save</button>
														<?php
															} else{
														?>
																<button type="submit" name="addTask" id="addTask" class="btn btn-success">Submit</button>
														<?php
															}
														?>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div> <!-- End Content -->
			</div> <!-- End Content Wrapper -->

			<!-- Footer -->
			<?php include("include/footer.php"); ?>

		</div> <!-- End Page Wrapper -->
	</div> <!-- End Wrapper -->

	<!-- Common Javascript -->
	<script src="assets/plugins/jquery/jquery-3.5.1.min.js"></script>
	<script src="assets/js/bootstrap.bundle.min.js"></script>                                                              
	<script src="assets/plugins/tags-input/bootstrap-tagsinput.js"></script>
	<script src="assets/plugins/simplebar/simplebar.min.js"></script>
	<script src="assets/plugins/jquery-zoom/jquery.zoom.min.js"></script>
	<script src="assets/plugins/slick/slick.min.js"></script>

	<!-- Option Switcher -->
	<script src="assets/plugins/options-sidebar/optionswitcher.js"></script>

	<!-- ekka Custom -->
	<script src="assets/js/ekka.js"></script>
	<script src="assets/js/manual.js"></script>
</body>

</html>

<script>
	var i = 0;
	$('#add').click(function(){
		i++;
		$('#next').append('<div class="row"><div class="col-md-7"><input type="text" name="task_name[]" id="task_name" required></div><div class="col-md-4"><select name="task_type[]" id="task_type" class="form-select"><option value="1">Billing</option><option value="2">Non Billing</option></select></div><div class="col-md-1"><button type="button" name="delete" id="delete['+i+']" class="btn btn-danger form-control" onclick="deleteRow(this)">X</button></div></div>');
	})

	function deleteRow(btn){
		var row = btn.parentNode.parentNode;
		row.parentNode.removeChild(row);
	}
</script>
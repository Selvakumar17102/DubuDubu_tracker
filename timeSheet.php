<?php
session_start();
ini_set("display_errors",'off');
include("include/connection.php");
$timeSheet = 'active';
$timeBoolean = 'true';
$time_show = 'show';
$timeSheet_apply ='Active';

$projectSql ="SELECT * FROM project WHERE project_status != 'Closed'";
$projectRes = $conn->query($projectSql);

$taskSql ="SELECT * FROM task";
$taskRes = $conn->query($taskSql);


if(isset($_POST['submit'])){
	$emp_id =$_SESSION['id'];
    $date = $_POST['date'];
    $project = $_POST['project'];
    $task =$_POST['task'];
    $working_hrs = $_POST['whrs'];
    $desc = $_POST['thrs'];
	$status = 1;

    $sql = "INSERT INTO time_sheet (employee, date, project_id, task_id, working_hrs, description, time_sheet_status) VALUES ('$emp_id', '$date', '$project', '$task', '$working_hrs', '$desc', '$status')";
    if($conn->query($sql) == TRUE){
		header('location:timeSheet.php?msg=Time Sheet Added !&type=success');
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Ekka - Admin Dashboard HTML Template.">

	<title>DUBU DUBU - Time Sheet</title>

	<!-- GOOGLE FONTS -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

	<link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />

	<!-- PLUGINS CSS STYLE -->
	<link href="assets/plugins/simplebar/simplebar.css" rel="stylesheet" />

	<!-- Data-Tables -->
	<link href='assets/plugins/data-tables/datatables.bootstrap5.min.css' rel='stylesheet'>
	<link href='assets/plugins/data-tables/responsive.datatables.min.css' rel='stylesheet'>

	<!-- Ekka CSS -->
	<link id="ekka-css" rel="stylesheet" href="assets/css/ekka.css" />

	<!-- FAVICON -->
	<link href="assets/img/favicon.png" rel="shortcut icon" />

	<style>
		input[type=time]::-webkit-datetime-edit-ampm-field {
  			display: none;
		}
	</style>
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
							<h1>Time Sheet</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Time Sheet</p>
						</div>
					</div>
						<div class="form-group">
        					<div class="col-sm-12 ">
            					<?php echo $msg; ?>
        					</div>
    					</div>
					<?php
					if($_GET['type'] == 'success'){
					?>
						<div class="alert alert-success text-center" role="alert" id="alert_msg">
							<?php echo $_REQUEST['msg']; ?>
						</div>
					<?php
					}
					elseif($_GET['type'] == 'warning'){
					?>
						<div class="alert alert-warning text-center" role="alert" id="alert_msg">
							<?php echo $_REQUEST['msg']; ?>
						</div>
					<?php
					}
					elseif($_GET['type'] == 'failed'){
					?>
						<div class="alert alert-danger text-center" role="alert" id="alert_msg">
							<?php echo $_REQUEST['msg']; ?>
						</div>
					<?php
					}
					?>
                    <div class="row m-b30">
						<div class="col-12">
							<div class="card card-default"> 
								<div class="card-header card-header-border-bottom">
									<h2>Create Time Sheet</h2>
								</div>
								<div class="card-body">
									<div class="row ec-vendor-uploads">
										<div class="col-lg-12">
											<div class="ec-vendor-upload-detail">
												<form method="post" class="row g-3" enctype="multipart/form-data">
                                                    <?php $todayDate = date('Y-m-d')?>
                                                    <div class="col-md-6">
														<label class="form-label">Date <span style="color:red;font-weight:bold">*</span></label>
														<input type="date" class="form-control" name="date" id="date" value="<?php echo $todayDate;?>" max="<?php echo $todayDate; ?>">
													</div>
                                                    <div class="col-md-6">
										                <div class="form-group mb-4">
										                	<label class="form-label">Project<span style="color:red;font-weight:bold">*</span></label>
										                	<select name="project" id="project" class="form-control" required>
										                			<option value="" data-display="Team">Select Project</option>
                                                                    <?php
                                                                    while($proRow = mysqli_fetch_array($projectRes)){
                                                                        ?>
                                                                        <option value="<?php echo $proRow['id']?>"><?php echo $proRow['project_name']?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
										                	</select>
										                </div>
										            </div>
													<div class="col-md-6">
														<label class="form-label">Task<span style="color:red;font-weight:bold">*</span></label>
														<select name="task" id="task" class="form-control" required>
										                	<option value="" data-display="Team">Select Project First</option>
										                </select>
													</div>
                                                    <div class="col-md-6">
														<label class="form-label">Working Hours<span style="color:red;font-weight:bold">*</span></label>
														<input class="form-control" name="whrs" type="text" id="timePicker" autocomplete="off" required/>
													</div>
                                                    <div class="col-md-12">
														<label class="form-label">Description<span style="color:red;font-weight:bold">*</span></label>
                                                        <textarea name="thrs" id="thrs" cols="10" rows="5" placeholder="Enter Description" required></textarea>
														<!-- <input type="time" class="form-control" name="thrs" id="thrs" placeholder="Total Working Hours" required> -->
													</div>
													<div class="modal-footer">
														<button type="submit" name="submit" id="submit" class="btn btn-success">Submit</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
        				<div class="col-sm-12">
							<span id="alertmeg"></span>
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
	<script src="assets/plugins/simplebar/simplebar.min.js"></script>
	<script src="assets/plugins/jquery-zoom/jquery.zoom.min.js"></script>
	<script src="assets/plugins/slick/slick.min.js"></script>

	<!-- Datatables -->
	<script src='assets/plugins/data-tables/jquery.datatables.min.js'></script>
	<script src='assets/plugins/data-tables/datatables.bootstrap5.min.js'></script>
	<script src='assets/plugins/data-tables/datatables.responsive.min.js'></script>

	<!-- Option Switcher -->
	<script src="assets/plugins/options-sidebar/optionswitcher.js"></script>

	<!-- ekka Custom -->
	<script src="assets/js/ekka.js"></script>
	<script src="assets/js/manual.js"></script>
</body>
</html>

<link rel="stylesheet" href="assets/css/timePicker.css">
<script src="assets/js/jquery-timepicker.js"></script>

<script>
	$('#project').on('change', function(){
    var proId = $(this).val();
    $.ajax({
        type : 'POST',
        url : 'ajax/time-sheet-check.php',
        data : {
            id : proId,
        },
        success : function(html){
            // alert(data);
            $('#task').html(html);
        }
    });
	});

	$("#timePicker").hunterTimePicker();
</script>

<?php

session_start();
ini_set('display_errors', 'off');
include("include/connection.php");
$attendance = 'active';
$atten_boolean = 'true';
$attendance_show = 'show';
$daily_attendance = 'active';

$today = date('Y-m-d');
// $today1 = date('d/m/Y');

if(isset($_POST['search'])){
	$defaultDate = $_POST['date'];
	// $date = $_POST['getDate'];
}
else{
	$defaultDate = $today;
	// $date = $_POST['getDate'];
	// if($_POST['getDate']){
	// 	$date = $_POST['getDate'];
	// 	// echo $date;die();
	// }
	// else{
	// 	$date = $today;
	// }
}

if(isset($_POST['submit'])){
	$idCount = count($_POST['ids']);
	
	// $date = $_POST['date'];
	$date = $_POST['getDate'];
	// echo $date;exit();

	$attend_sql = "SELECT * FROM attendance WHERE date='$date'";
	// echo $attend_sql;exit();
	$attend_result = $conn->query($attend_sql);

	if($attend_result->num_rows > 0){
		// $attend_sql2 = "DELETE FROM attendance WHERE date = '$today'";
		// echo $attend_sql2; exit();

		// if($conn->query($attend_sql2) == TRUE){

			for($i=0;$i<$idCount;$i++){

				$id = $_POST['ids'][$i];
				// echo $id; exit();
				$status = $_POST['attStatus'][$i];
				$location = $_POST['presentStatus'][$i];
				$informStatus = $_POST['informValue'][$i];
				$type = $_POST['reason'][$i];
				$range = $_POST['range'][$i];
				$absent_status = $_POST['fn_an_status'][$i];

				if($status == 0){
					$type = $informStatus = 0;
					$range = 1;
					$absent_status = 3;
				}
				else{
					$location = 0;
				}

				$attend_sql3 = "UPDATE attendance SET emp_id='$id', status='$status', type='$type', count='$range', inform_status='$informStatus', location='$location', fn_an_status='$absent_status' WHERE emp_id='$id' AND date='$date'";

				// $attend_sql3 = "INSERT INTO attendance (date,emp_id,status,type,count,inform_status,location) VALUES ('$today', '$id', '$status', '$type', '$range', '$informStatus', '$location')";
				if($conn->query($attend_sql3) == TRUE){
					header('location: attendance.php?msg=Attendance Updated!&type=warning');
				}
			}
		// }
	}
	else{
		for($i=0;$i<$idCount;$i++){

			$id = $_POST['ids'][$i];
			$status = $_POST['attStatus'][$i];
			$location = $_POST['presentStatus'][$i];
			$informStatus = $_POST['informValue'][$i];
			$type = $_POST['reason'][$i];
			$range = $_POST['range'][$i];
			$absent_status = $_POST['fn_an_status'][$i];

			if($status == 0){
				$type = $informStatus = 0;
				$range = 1;
				$absent_status = 3;
			}
			else{
				$location = 0;
			}

			$attend_sql3 = "INSERT INTO attendance (date,emp_id,status,type,count,inform_status,location,fn_an_status) VALUES ('$date', '$id', '$status', '$type', '$range', '$informStatus', '$location', '$absent_status')";
			if($conn->query($attend_sql3) == TRUE){
				header('location: attendance.php?msg=Attendance Added!&type=success');
			}
		}
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

	<title>DUBU DUBU - Attendance</title>

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
							<h1>Attendance</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Attendance</p>
						</div>
						<!-- <div>
							<a href="product-list.php" class="btn btn-primary">Attendance Report</a>
						</div> -->
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
									<h2>Attendance</h2>
								</div>
								<div class="card-body">
									<div class="row ec-vendor-uploads">
										<div class="col-lg-12">
											<div class="ec-vendor-upload-detail">
												<form method="post" class="row g-3">
													<label class="form-label">Date</label>
													<div class="col-md-6">
														<!-- <label class="form-label">Date</label> -->
														<?php
														if($_POST['getDate']){
															$d = $_POST['date'];
														}
														else{
															$d = $today;
														}
														?>
														<input type="date" class="form-control" name="date" id="date" value="<?php echo $defaultDate; ?>" max="<?php echo $today; ?>" onchange="getdate(this.value)">
														<input type="hidden" id="getDate" name="getDate" value="<?php echo $defaultDate;?>">
														<!-- <input type="hidden" id="changeDate" name="changeDate" value="<?php echo $date;?>"> -->
													</div>
													<div class="col-md-6">
														<!-- <input type="submit" name="request" id="request" value="Request" class="btn btn-primary"/> -->
														<button type="submit" name="search" id="search" class="btn btn-success">Search</button>
													</div>
												<!-- </form> -->
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row m-b30">
						<div class="col-12">
							<div class="card card-default">
								<div class="card-body">
									<div class="table-responsive">
										<!-- <form method="post"> -->
										<table id="responsive-data-table" class="table" style="width:100%">
											<thead>
												<tr>
													<th>ID</th>
													<th>Name</th>
													<th>Team</th>
													<th>Status</th>
													<th>Description</th>
												</tr>
											</thead>
											<tbody>
												<?php
												// $attend_sql = "SELECT max(date) as maxDate FROM attendance";
												// $attend_result = $conn->query($attend_sql);
												// $attend_row = mysqli_fetch_array($attend_result);
												// echo $attend_row['maxDate'];
												// echo $date;
												// die();
												$attend_sql = "SELECT * FROM attendance WHERE date='$defaultDate'";
												// echo $attend_sql;die();
												$attend_result = $conn->query($attend_sql);
												// $attend_row = mysqli_fetch_array($attend_result);
												// echo $attend_result->num_rows;die();
												if($attend_result->num_rows > 0){
													$join_attendance = "LEFT OUTER JOIN attendance b on a.id = b.emp_id";
													$filterDate = "AND b.date='".$defaultDate."'";
												}
												else{
													$join_attendance = "";
													$filterDate = "";
													// $join_attendance = "LEFT OUTER JOIN attendance b on a.id = b.emp_id";
													// $filterDate = "AND b.date='".$date."'";
												}
												// $fetch_sql = "SELECT * FROM employee WHERE del_status=0 ORDER BY fname ASC";
												$fetch_sql = "SELECT *,a.id as employee_id FROM employee a
												$join_attendance WHERE a.del_status = 0 AND a.doj <= '$defaultDate' AND a.control != 5 $filterDate 
												AND a.id NOT IN (SELECT id FROM employee WHERE emp_status != 'Active' AND resign_date <= '$defaultDate') GROUP BY a.id ORDER BY fname ASC";
												// echo $fetch_sql;die();
												$fetch_result = $conn->query($fetch_sql);
												$count = 1;
												$a = 0;
												while($row=mysqli_fetch_array($fetch_result)){
													$id = $row['employee_id'];
												?>
												<tr>
													<td><?php echo $count++;?></td>
													<input type="hidden" value="<?php echo $id;?>" name="ids[<?php echo $a;?>]">
													<td><?php echo $row['fname'];?> <?php echo $row['lname'];?></td>
													<td><?php echo $row['team'];?></td>
													<td>
														<div class="col-sm-12">
															<select name="attStatus[<?php echo $a;?>]" id="attStatus<?php echo $a;?>" class="form-select" onchange="persentValue(<?php echo $a;?>)">
																<option value="0" <?php if($row['status'] == 0){ echo "selected"; }?>>Present</option>
																<option value="1" <?php if($row['status'] == 1){ echo "selected"; }?>>Absent</option>
															</select>
														</div>
													</td>
													<td>
														<?php
														if($row['status'] == 0){
															$display = "block";
														}
														else{
															$display = "none";
														}
														?>
														<div class="col-sm-12 presentOption<?php echo $a;?>" style="display: <?php echo $display;?>">
															<select name="presentStatus[<?php echo $a;?>]" id="presentStatus" class="form-select">
																<option value="1" <?php if($row['location'] == 1){ echo "selected"; }?>>Office</option>
																<option value="2" <?php if($row['location'] == 2){ echo "selected"; }?>>Client Meet</option>
																<option value="3" <?php if($row['location'] == 3){ echo "selected"; }?>>Work from Home</option>
															</select>
														</div>
														<?php
														if($row['status'] == 0){
															$display1 = "none";
														}
														else{
															$display1 = "block";
														}
														?>
														<div class="col-sm-12 absentOption<?php echo $a;?>" style="display: <?php echo $display1;?>">
															<div class="row">
																<div class="col">
																	<select name="informValue[<?php echo $a;?>]" id="informValue<?php echo $a;?>" class="form-select" onchange="informStatus(<?php echo $a; ?>)">
																			<option value="1" <?php if($row['inform_status'] == 1){ echo "selected"; }?>>Informed</option>
																			<option value="2" <?php if($row['inform_status'] == 2){ echo "selected"; }?>>Uninformed</option>
																	</select>
																</div>
																<?php
																if($row['inform_status'] == 2){
																	$display2 = "none";
																}
																else{
																	$display2 = "block";
																}
																?>
																<div class="col reason<?php echo $a;?>" style="display: <?php echo $display2;?>">
																	<select name="reason[<?php echo $a;?>]" class="form-select">
																		<option value="1" <?php if($row['type'] == 1){ echo "selected"; }?>>Casual Leave</option>
																		<option value="2" <?php if($row['type'] == 2){ echo "selected"; }?>>Sick Leave</option>
																		<option value="3" <?php if($row['type'] == 3){ echo "selected"; }?>>Loss Of Pay</option>
																	</select>
																</div>
																<div class="col">
																	<select name="range[<?php echo $a;?>]" id="range<?php echo $a;?>" class="form-select" onclick="fnanStatus('<?php echo $a;?>')">
																		<option value="1" <?php if($row['count'] == 1){ echo "selected"; }?>>Full Day</option>
																		<option value="2" <?php if($row['count'] == 2){ echo "selected"; }?>>Half A Day</option>
																	</select>
																</div>
																<?php
																if($row['count'] == 2){
																	$display3 = "block";
																}
																else{
																	$display3 = "none";
																}
																?>
																<div class="col absent_status<?php echo $a;?>" style="display: <?php echo $display3;?>">
																	<select name="fn_an_status[<?php echo $a;?>]" id="fn_an_status<?php echo $a;?>" class="form-select">
																		<option value="1" <?php if($row['fn_an_status'] == 1){ echo "selected"; }?>>FN</option>
																		<option value="2" <?php if($row['fn_an_status'] == 2){ echo "selected"; }?>>AN</option>
																	</select>
																</div>
															</div>
														</div>
													</td>
												</tr>
												<?php
												$a++;
												}
												?>
												<tr>
													<td><button class="btn btn-success" id="submit" name="submit" onclick="getvalue()">Submit</button></td>
												</tr>
												</tbody>
										</table>
										</form>
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
	<script src="assets/plugins/simplebar/simplebar.min.js"></script>
	<script src="assets/plugins/jquery-zoom/jquery.zoom.min.js"></script>
	<script src="assets/plugins/slick/slick.min.js"></script>

	<!-- Data-Tables -->
	<script src='assets/plugins/data-tables/jquery.datatables.min.js'></script>
	<script src='assets/plugins/data-tables/datatables.bootstrap5.min.js'></script>
	<script src='assets/plugins/data-tables/datatables.responsive.min.js'></script>

	<!-- Option Switcher -->
	<script src="assets/plugins/options-sidebar/optionswitcher.js"></script>

	<!-- Ekka Custom -->
	<script src="assets/js/ekka.js"></script>
	<script src="assets/js/manual.js"></script>
</body>

</html>
<script>
		// Absent and Present control
		function persentValue(val){
			// alert(val);
			var att = $('#attStatus'+val).val();
			// alert(att);
			if(att == 1){
			$('.presentOption'+val).hide();
			$('.absentOption'+val).show();
			}else{
				$('.presentOption'+val).show();
				$('.absentOption'+val).hide();
			}
		};
		// Inform and Uninformed control
		function informStatus(val1){
			var day = $('#informValue'+val1).val();
			// alert(day);
			if(day == 2){
				$('.reason'+val1).hide();
			}else{
				$('.reason'+val1).show();
			}
		};

		function fnanStatus(val){
			// alert("kjhj");
			var fnanStatus = $('#range'+val).val();
			// alert(fnanStatus);
			if(fnanStatus == 1){
				$('.absent_status'+val).hide();
			}
			else{
				$('.absent_status'+val).show();
			}
		}

		function getdate(val){
			// alert(val);
			$('#getDate').val(val);
		}

		function getvalue(){
			// alert("kjhg");
			var getdate = document.getElementById('date').value;
			// alert(getdate);
			$('#getDate').val(getdate);
			// alert(getdate);
		}
</script>
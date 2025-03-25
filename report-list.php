<?php

session_start();
ini_set('display_errors', 'off');
include("include/connection.php");
$report = 'active';
$report_boolean = 'true';
$report_show = 'show';
$attendance_details = 'active';

// $today = date('Y-m-d');

if(isset($_POST['search'])){
	$fd = $_POST['fDate'];
	$td = $_POST['tDate'];
}
else{
	$fd = date('Y-m-01');
	$td = date('Y-m-d');
}


// if($fd == ""){
// 	$start = date('Y-m-01');
// 	$end = date('Y-m-d');
// }
// else{
// 	$start = $fd;
// 	$end = $td;
// }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Ekka - Admin Dashboard HTML Template.">

	<title>DUBU DUBU - Attendance Report</title>

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

<style>
	table, th, td{
		border-width: 3px;
		white-space: nowrap;
	}

	@media print {
  		@page {
  		  size: landscape;
		  /* margin: 16cm; */
  		}
	}
</style>

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
							<h1>Attendance Report</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Attendance Report</p>
						</div>
						<!-- <div>
							<a href="product-list.php" class="btn btn-primary">Attendance Report</a>
						</div> -->
					</div>

                    <div class="row m-b30">
						<div class="col-12">
							<div class="card card-default">
								<div class="card-header card-header-border-bottom">
									<h2>Attendance Report</h2>
								</div>
								<div class="card-body">
									<div class="row ec-vendor-uploads">
										<div class="col-lg-12">
											<div class="ec-vendor-upload-detail">
												<form id="apply_leave" method="post" class="row g-3" enctype="multipart/form-data">
													<div class="col-md-6">
														<label class="form-label">From</label>
														<input type="date" class="form-control" name="fDate" id="fDate" value="<?php echo $fd; ?>" required>
													</div>
													<div class="col-md-6">
														<label class="form-label">To</label>
														<input type="date" class="form-control" name="tDate" id="tDate" value="<?php echo $td; ?>" required>
													</div>
													<div class="col-md-12">
														<!-- <input type="submit" name="request" id="request" value="Request" class="btn btn-primary"/> -->
														<button type="submit" name="search" id="search" class="btn btn-success">Search</button>
													</div>
												</form>
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
								<div class="card-header card-header-border-bottom">
									<h2 style="text-align: center">DUBU DUBU Attendance Report</h2>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<div class="new_table">
										<table id="data_table" class="table" style="width:100%">
											<thead style="border-width:5px">
												<tr>
													<th>S.No</th>
													<?php
													?>
													<th>Name</th>
													<?php
													for($loopDate = $fd; $loopDate <= $td; $loopDate = date('Y-m-d', strtotime($loopDate.'+1 day'))){
														// $month = date($loopDate, 'm');
														// $monthNum  = $month;
														// $dateObj   = DateTime::createFromFormat('!m', $monthNum);
														// $monthName = $dateObj->format('F'); // March
														?>
														<th><?php echo date('d',strtotime($loopDate));?></th>
														<?php
													}
													?>
													<th>Present</th>
													<th>Absent - Full Day</th>
													<th>Absent - Half Day</th>
													<th>Work From Home</th>
													<th>Client Meet</th>
												</tr>
											</thead>

											<tbody>
												<?php
												$employee_sql = "SELECT * FROM employee WHERE del_status = 0 AND control != 5 AND doj <= '$td' AND
												id NOT IN (SELECT id FROM employee WHERE emp_status != 'Active' AND resign_date <= '$fd') ORDER BY fname ASC";
												// $employee_sql = "SELECT *,a.id AS employee_id FROM employee a LEFT OUTER JOIN attendance b ON a.id = b.emp_id WHERE a.del_status = 0 AND b.date = $loopDate ORDER BY fname ASC";
												// echo $employee_sql; die();
												$employee_result = $conn->query($employee_sql);
												$count = 1;
												while($employee_row = mysqli_fetch_array($employee_result)){
													$id = $employee_row['id'];
													$p = $af = $ah = $wfh = $cm = 0;
													$empStatus = $employee_row['emp_status'];
													$resignDate = $employee_row['resign_date'];
													?>
												<tr>
													<td><?php echo $count++; ?></td>
													<td><?php echo $employee_row['fname']; ?>&nbsp;<?php echo $employee_row['lname']; ?></td>
													<?php
													for($loopDate = $fd; $loopDate <= $td; $loopDate = date('Y-m-d', strtotime($loopDate.'+1 day'))){
														$status = "";
														$color = "";
														$attend_sql = "SELECT * FROM attendance WHERE date = '$loopDate' AND emp_id = '$id'";
														// echo $attend_sql;die();
														$attend_result = $conn->query($attend_sql);
														if($attend_result->num_rows > 0){
															if($resignDate != "" && $resignDate <= $loopDate){
																$color = "background-nonactive-color";
																if($empStatus == 'Resign'){
																	$status = "R";
																}
																elseif($empStatus == 'Abscond'){
																	$status = "AB";
																}
																elseif($empStatus == 'Terminated'){
																	$status = "T";
																}
															}
															else{
															// if($empStatus == 'Active'){
															$attend_row = mysqli_fetch_array($attend_result);
																if($attend_row['status'] == 0){
																	if($attend_row['location'] == 1){
																		$status = "P";  // Present
																	}
																	elseif($attend_row['location'] == 2){
																		$status = "CM";  // Client Meet
																		$color = "background-cm";
																		$cm++;
																	}
																	elseif($attend_row['location'] == 3){
																		$status = "WFH";  // Work From Home
																		$color = "background-wfh";
																		$wfh++;
																	}
																	$p++;
																}
																elseif($attend_row['status'] == 2){
																	// $status = "CO";
																	// $color = "bg-primary";
																	if($attend_row['count'] == 1){
																		$status = "CO";  // Comp Off Full Day
																		$color = "background-primary";
																	}
																	else{
																		$status = "CH";  // Comp Off Half Day
																		$color = "background-primary";
																	}
																}
																else{
																	if($attend_row['count'] == 1){
																		$status = "A";  // Absent
																		$af++;
																		$color = "background-failed";
																	}
																	else{
																		$status = "AH";  // Absent Half Day
																		$ah++;
																		$color = "background-warning";
																	}
																}
															}
															// else{
															// 	$status = "R";
															// }
															?>
															<td style="text-align:center" class='<?php echo $color; ?>'><?php echo $status;?></td>
															<?php
														}else{
															if($resignDate != "" && $resignDate <= $loopDate){
																$endColor = "background-nonactive-color";
																if($empStatus == 'Resign'){
																	$endStatus = "R";
																}
																elseif($empStatus == 'Abscond'){
																	$endStatus = "AB";
																}
																elseif($empStatus == 'Terminated'){
																	$endStatus = "T";
																}
															}
															else{
																$endStatus = "H";  // Holiday
																$endColor = "bg-secondary";
															}
														?>
														<td style="text-align:center" class="<?= $endColor; ?>"><?php echo $endStatus;?></td>
														<?php
														}
													}
													?>
													<td style="text-align:center"><?php echo $p;?></td>
													<td style="text-align:center"><?php echo $af;?></td>
													<td style="text-align:center"><?php echo $ah;?></td>
													<td style="text-align:center"><?php echo $wfh;?></td>
													<td style="text-align:center"><?php echo $cm;?></td>
												</tr>
												<?php
												}
												?>
											</tbody>
										</table>
										</div>
									</div>
								</div>
							<!-- </div> -->
						</div>
					</div>
					</div>

					<!-- <div class="row m-b30">
						<div class="col-xl-5 col-md-12 p-b-15">
							<div id="user-acquisition" class="card card-default">
								<div class="card-header">
									<h2>Notes</h2>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table" style="width:100%">
											<tbody>
													<tr>
														<td>Present</td>
														<td><span class="badge bg-success">P</span></td>
													</tr>
													<tr>
														<td>Absent</td>
														<td><span class="badge bg-failed">A</span></td>
													</tr>
													<tr>
														<td>Absent - Half Day</td>
														<td><span class="badge bg-warning">AH</span></td>
													</tr>
													<tr>
														<td>Comp Off</td>
														<td><span class="badge bg-primary">CO</span></td>
													</tr>
													<tr>
														<td>Holiday</td>
														<td><span class="badge bg-secondary">H</span></td>
													</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div> -->

					<div class="container bootstrap snippets bootdeys">
						<div class="row">
    						<div class="col-md-4 col-sm-8 content-card">
    						    <div class="card-big-shadow">
    						        <div class="card card-just-text" data-background="color" data-color="yellow" data-radius="none">
    						            <div class="content">
    						                <h6 class="category">Notes</h6>
    						                <!-- <h4 class="title"><a href="#">Blue Card</a></h4>
    						                <p class="description">What all of these have in common is that they're pulling information out of the app or the service and making it relevant to the moment. </p> -->
											<div class="row p-3">
												<ul class="noteslist" style="color: black; list-style: disc text-align: left">
													<li><b>P</b> - Present</li>
													<li><b>WFH</b> - Work From Home</li>
													<li><b>CM</b> - Client Meet</li>
													<li><b>A</b> - Absent</li>
													<li><b>AH</b> - Absent Half Day</li>
													<li><b>CO</b> - Comp Off Full Day</li>
													<li><b>CH</b> - Comp Off Half Day</li>
													<li><b>H</b> - Holiday</li>
													<li><b>R</b> - Resigned</li>
													<li><b>AB</b> - Abscond</li>
													<li><b>T</b> - Terminated</li>
												</ul>
											</div>
    						            </div>
    						        </div> <!-- end card -->
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

	<!-- Datatables -->
	<!-- <script src='assets/plugins/data-tables/jquery.datatables.min.js'></script>
	<script src='assets/plugins/data-tables/datatables.bootstrap5.min.js'></script>
	<script src='assets/plugins/data-tables/datatables.responsive.min.js'></script> -->

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>

	<!-- Option Switcher -->
	<script src="assets/plugins/options-sidebar/optionswitcher.js"></script>

	<!-- ekka Custom -->
	<script src="assets/js/ekka.js"></script>
	<script src="assets/js/manual.js"></script>
</body>
</html>

<script>
	var exampleTable = $('#data_table').DataTable( {
  		// lengthChange: false,
		  pageOrientation: 'landscape',
  		buttons: [ 'copy', 'excel', 'pdf', 'print' ]
	});

	exampleTable.buttons().container()
  		.appendTo( '#data_table_wrapper .col-md-6:eq(0)' );
</script>

<?php

session_start();
ini_set('display_errors', 'off');
include("include/connection.php");
$report = 'active';
$report_boolean = 'true';
$report_show = 'show';
$project_details = 'active';

// $today = date('Y-m-d');

// if(isset($_POST['search'])){
// 	$fd = $_POST['fDate'];
// 	$td = $_POST['tDate'];
// }
// else{
// 	$fd = date('Y-m-01');
// 	$td = date('Y-m-d');
// }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Ekka - Admin Dashboard HTML Template.">

	<title>Dubu Dubu - Project Report List</title>

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
							<h1>Project Report</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Project Report</p>
						</div>
						<div>
							<a href="javascript:history.go(-1)" class="btn btn-primary">Back</a>
						</div>
					</div>

                    <!-- <div class="row m-b30">
						<div class="col-12">
							<div class="card card-default">
								<div class="card-header card-header-border-bottom">
									<h2>Project Report</h2>
								</div>
								<div class="card-body">
									<div class="row ec-vendor-uploads">
										<div class="col-lg-12">
											<div class="ec-vendor-upload-detail">
												<form id="apply_leave" method="post" class="row g-3" enctype="multipart/form-data">
													<div class="col-md-6">
														<label class="form-label">From</label>
														<input type="date" class="form-control" name="fDate" id="fDate" value="<?php echo $fd; ?>">
													</div>
													<div class="col-md-6">
														<label class="form-label">To</label>
														<input type="date" class="form-control" name="tDate" id="tDate" value="<?php echo $td; ?>">
													</div>
													<div class="col-md-12">
														<button type="submit" name="search" id="search" class="btn btn-success">Search</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div> -->

					<div class="row m-b30">
						<div class="col-12">
							<div class="card card-default">
								<div class="card-header card-header-border-bottom">
									<h2 style="text-align: center">DUBU DUBU Project Report</h2>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<div class="new_table">
										<table id="data_table" class="table" style="width:100%">
											<thead style="border-width:5px">
												<tr>
													<th>S.No</th>
													<th>Project Name</th>
													<th>Task Name</th>
													<th>Total Working Hours</th>
													<th>Billing Hours</th>
													<th>Approved Billing Hours</th>
													<th>Non Billing Hours</th>
													<th>Approved Non Billing Hours</th>
												</tr>
											</thead>

											<tbody>
                                                <?php
                                                	if(isset($_GET['pro_id'])){
                                                	    $pro_id = $_GET['pro_id'];
                                                	}
                                                	$sql = "SELECT *,b.id AS task_id, a.id AS project_id FROM project a
                                                		LEFT OUTER JOIN task b ON b.project_id = a.id WHERE a.id = '$pro_id'";
													// echo $sql;
                                                	$result = $conn->query($sql);
                                                	$a = 1;
                                                	while($row = mysqli_fetch_array($result)){
														$project_id = $row['project_id'];
														$task_id = $row['task_id'];
                                                ?>
												    <tr>
                                                        <td><?php echo $a++;?></td>
                                                        <td><?php echo $row['project_name'];?></td>
                                                        <td><?php echo $row['task_name'];?></td>
														<?php
															$task_sql2 = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(working_hrs))) AS task_wr_hrs FROM time_sheet a WHERE project_id = '$project_id' AND task_id = '$task_id'";
															$task_result2 = $conn->query($task_sql2);
															$task_row2 = mysqli_fetch_array($task_result2);
															if($task_row2['task_wr_hrs'] != NULL){
																$wrk_hrs = $task_row2['task_wr_hrs'];
															}
															else{
																$wrk_hrs = "Yet To Start";
															}
														?>
														<td style="text-align: center"><?php echo $wrk_hrs; ?></td>
                                                        <td style="text-align: center"><?php echo $row['billing_hours'];?></td>
                                                        <?php
															if($row['task_type'] == 1){
                                                        		$task_sql = "SELECT SEC_TO_TIME(SUM(CASE WHEN b.task_type = 1 THEN TIME_TO_SEC(a.approval_hrs) END)) AS app_bill_hrs FROM time_sheet a
																	LEFT OUTER JOIN task b ON b.id = a.task_id
																	LEFT OUTER JOIN project c ON c.id = a.project_id WHERE c.id = '$project_id' AND b.id = '$task_id' AND a.time_sheet_status = 2";
																// echo $task_sql;
                                                        		$task_result = $conn->query($task_sql);
																$task_row = mysqli_fetch_array($task_result);
																if($task_row['app_bill_hrs'] != NULL){
																	$bill_value = $task_row['app_bill_hrs'];
																}
																else{
																	$bill_value = "00:00:00";
																}
															}
															else{
																$bill_value = "-";
															}
														?>
														<td style="text-align: center"><?php echo $bill_value; ?></td>
														<td style="text-align: center"><?php echo $row['non_billing_hours'];?></td>
														<?php
															if($row['task_type'] == 2){
                                                        		$task_sql1 = "SELECT SEC_TO_TIME(SUM(CASE WHEN b.task_type = 2 THEN TIME_TO_SEC(a.approval_hrs) END)) AS app_non_bill_hrs FROM time_sheet a
																	LEFT OUTER JOIN task b ON b.id = a.task_id
																	LEFT OUTER JOIN project c ON c.id = a.project_id WHERE c.id = '$project_id' AND b.id = '$task_id' AND a.time_sheet_status = 2";
                                                        		$task_result1 = $conn->query($task_sql1);
																$task_row1 = mysqli_fetch_array($task_result1);
																if($task_row1['app_non_bill_hrs'] != NULL){
																	$non_bill_value = $task_row1['app_non_bill_hrs'];
																}
																else{
																	$non_bill_value = "00:00:00";
																}
															}
															else{
																$non_bill_value = "-";
															}
														?>
														<td style="text-align: center"><?php echo $non_bill_value; ?></td>
                                                    </tr>
                                                <?php
                                                	}
                                                ?>
											</tbody>
										</table>
										</div>
									</div>
								</div>
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

					<!-- <div class="container bootstrap snippets bootdeys">
						<div class="row">
    						<div class="col-md-4 col-sm-6 content-card">
    						    <div class="card-big-shadow">
    						        <div class="card card-just-text" data-background="color" data-color="yellow" data-radius="none">
    						            <div class="content">
    						                <h6 class="category">Notes</h6>
											<div class="row p-3">
												<ul class="noteslist" style="color: black; list-style: disc text-align: left">
													<li><b>P</b> - Present</li>
													<li><b>A</b> - Absent</li>
													<li><b>AH</b> - Absent Half Day</li>
													<li><b>CO</b> - Comp Off Full Day</li>
													<li><b>CH</b> - Comp Off Half Day</li>
													<li><b>H</b> - Holiday</li>
												</ul>
											</div>
    						            </div>
    						        </div>
    						    </div>
    						</div>
						</div>
					</div> -->

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
  		buttons: [ 'copy', 'excel', 'pdf', 'print' ]
	});

	exampleTable.buttons().container()
  		.appendTo( '#data_table_wrapper .col-md-6:eq(0)' );
</script>

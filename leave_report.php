<?php

session_start();
ini_set('display_errors', 'off');
include("include/connection.php");
$report = 'active';
$report_boolean = 'true';
$report_show = 'show';
$leave_details = 'active';

$today = date('Y-m-d');

if(isset($_POST['search'])){
	$fd = $_POST['fDate'];
	$td = $_POST['tDate'];
    $status = $_POST['status'];
	if($_POST['leave_per'] == 1){
    	$leave_per = $_POST['leave_per'];
		$div_title = "DUBU DUBU Leave Report";
		$title = "Leave Report";
	}
	else{
		$leave_per = $_POST['leave_per'];
		$div_title = "DUBU DUBU Permission Report";
		$title = "Permission Report";
	}
}
else{
	$fd = date('Y-m-01');
	$td = $today;
    $status = "";
    if($leave_per = "1"){
		$div_title = "DUBU DUBU Leave Report";
		$title = "Leave Report";
	}
	else{
		$div_title = "DUBU DUBU Permission Report";
		$title = "Permission Report";
	}
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

	<title id="lp_title">DUBU DUBU - <?= $title; ?></title>

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
		table, th, td{
		  border-width: 3px;
		  white-space: nowrap;
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
							<h1 id="lp_h1"><?= $title; ?></h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span><?= $title; ?></p>
						</div>
						<!-- <div>
							<a href="product-list.php" class="btn btn-primary">Attendance Report</a>
						</div> -->
					</div>

                    <div class="row m-b30">
						<div class="col-12">
							<div class="card card-default">
								<div class="card-header card-header-border-bottom">
									<h2><?= $div_title; ?></h2>
								</div>
								<div class="card-body">
									<div class="row ec-vendor-uploads">
										<div class="col-lg-12">
											<div class="ec-vendor-upload-detail">
												<form id="apply_leave" method="post" class="row g-3" enctype="multipart/form-data">
													<div class="col-md-3">
														<label class="form-label">FROM</label>
														<input type="date" class="form-control" name="fDate" id="fDate" value="<?= $fd; ?>">
													</div>
                                                    <div class="col-md-3">
														<label class="form-label">TO</label>
														<input type="date" class="form-control" name="tDate" id="tDate" value="<?= $td; ?>">
													</div>
													<div class="col-md-3">
														<label class="form-label">Request Type</label>
														<select name="leave_per" id="leave_per" class="form-control" value="<?= $leave_per; ?>" onchange="getRequestType(this.value)">
										    			    <option value="1" <?php if($leave_per == '1') { echo "Selected"; }?>>Leave</option>
										    			    <option value="2" <?php if($leave_per == '2') { echo "Selected"; }?>>Permission</option>
										    	        </select>
													</div>
                                                    <div class="col-md-3">
														<label class="form-label">Status</label>
														<select name="status" id="status" class="form-control" value="<?= $status; ?>">
										    			    <option value="">-- Select Leave Status --</option>
										    			    <option value="1" <?php if($status == '1') { echo "Selected"; }?>>Accepted</option>
										    			    <option value="2" <?php if($status == '2') { echo "Selected"; }?>>Rejected</option>
										    	        </select>
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
					</div>

					<div class="row m-b30">
						<div class="col-12">
							<div class="card card-default">
								<div class="card-header card-header-border-bottom">
									<h2 style="text-align: center"><?= $div_title; ?></h2>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<div class="new_table">
										<table id="data_table" class="table">
											<thead style="border-width:5px">
												<tr>
													<th>S.No</th>
													<th>Name</th>
													<th>Designation</th>
                                                    <th style="text-align: center">Applied Date</th>
                                                    <th>Type</th>
                                                    <th>Range</th>
                                                    <th style="text-align: center">Leave Date</th>
                                                    <th>Reason</th>
                                                    <th style="text-align: center">Status</th>
                                                    <th>Reject Reason</th>
												</tr>
											</thead>

											<tbody>
												<?php
													if($fd != "" && $td != ""){
														$fdSql = "AND applied_date BETWEEN '$fd' AND '$td'";
														$tdSql = "";
													}
													else{
														if($fd != ""){
															$fdSql = "AND applied_date = '$fd'";
														}
														else{
															$fdSql = "";
														}
														if($td != ""){
															$tdSql = "AND applied_date = '$td'";
														}
														else{
															$tdSql = "";
														}
													}

													// getting type value
													if($leave_per == 2){
														$leave_perSql = "AND count = 3";
													}
													elseif($leave_per == 1){
														$leave_perSql = "AND count != 3";
													}

													// getting status value
													if($status != ""){
														$statusSql = "AND tl_status = '$status'";
													}
													else{
														$statusSql = "";
													}

                                                    $sql = "SELECT *,a.emp_id as employee_id, a.id as leave_id FROM employee_leave a
													LEFT OUTER JOIN employee b ON b.id=a.emp_id
													WHERE a.tl_status != 0 $fdSql $tdSql $statusSql $leave_perSql ORDER BY a.applied_date DESC";
													// echo $sql;
                                                    $result = $conn->query($sql);
                                                    $count = 1;
                                                    while($row = mysqli_fetch_array($result)){
												?>
												    <tr>
                                                        <td><?= $count++; ?></td>
                                                        <td><?= $row['fname']." ".$row['lname']; ?></td>
                                                        <td><?= $row['designation']; ?></td>
                                                        <td style="text-align: center"><?= date('d-m-Y', strtotime($row['applied_date'])); ?></td>
                                                        <td><?= $row['type']; ?></td>
														<?php
															if($row['count'] == 1){
																$range = "Full Day";
															}
															elseif($row['count'] == 2){
																$range = "Half Day";
															}
															elseif($row['count'] == 4){
																$range = "More than 1 Day";
															}
															else{
																$range = "Permission";
															}
														?>
                                                        <td><?= $range; ?></td>
														<?php
															if($row['count'] == 4){
																$leave_date = date('d-m-Y', strtotime($row['from_date'])). " - " .date('d-m-Y', strtotime($row['to_date']));
															}
															else{
																$leave_date = date('d-m-Y', strtotime($row['from_date']));
															}
														?>
                                                        <td style="text-align: center"><?= $leave_date; ?></td>
                                                        <td><?= $row['reason']; ?></td>
                                                        <?php
                                                            if($row['tl_status'] == '1'){
                                                                $empStatus = 'Accepted';
                                                                $class = 'badge-success';
                                                            }
                                                            else{
                                                                $empStatus = 'Rejected';
                                                                $class = 'badge-danger';
                                                            }
                                                        ?>
                                                        <td><span class="badge <?= $class; ?>"><?= $empStatus;?></span></td>
														<?php
															if($row['tl_status'] == '2'){
																$reject_reason = $row['tl_reason'];
															}
															else{
																$reject_reason = "-";
															}
														?>
                                                        <td><?= $reject_reason; ?></td>
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

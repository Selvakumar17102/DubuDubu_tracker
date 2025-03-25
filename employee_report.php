<?php

session_start();
ini_set('display_errors', 'off');
include("include/connection.php");
$report = 'active';
$report_boolean = 'true';
$report_show = 'show';
$employee_details = 'active';

$today = date('Y-m-d');

if(isset($_POST['search'])){
	$fd = $_POST['fDate'];
	$td = $_POST['tDate'];
    $status = $_POST['status'];
    $location = $_POST['location'];
    $team = $_POST['team'];
}
else{
	$fd = date('Y-01-01');
	$td = $today;
    $status = "";
    $location = "";
    $team = "";
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

	<title>DUBU DUBU - Employee Report</title>

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
							<h1>Employee Report</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Employee Report</p>
						</div>
						<!-- <div>
							<a href="product-list.php" class="btn btn-primary">Attendance Report</a>
						</div> -->
					</div>

                    <div class="row m-b30">
						<div class="col-12">
							<div class="card card-default">
								<div class="card-header card-header-border-bottom">
									<h2>Employee Report</h2>
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
													<div class="col-md-2">
														<label class="form-label">Location</label>
														<select name="location" id="location" class="form-control" value="<?= $location; ?>">
										    			    <option value="">-- Select Location --</option>
															<?php
																$employee_sql = "SELECT * FROM employee GROUP BY location";
																$employee_result = $conn->query($employee_sql);
																while($employee_row = mysqli_fetch_array($employee_result)){
															?>
										    			    		<option value="<?= $employee_row['location']; ?>" <?php if($location == $employee_row['location']) { echo "Selected"; }?>><?= $employee_row['location']; ?></option>
															<?php
																}
															?>
										    	        </select>
													</div>
													<div class="col-md-2">
														<label class="form-label">Team</label>
														<select name="team" id="team" class="form-control" value="<?= $team; ?>">
										    			    <option value="">-- Select Team --</option>
															<option value="Development" <?php if($team == 'Development'){ echo "selected"; }?>>Development</option>
															<option value="Digital Marketing" <?php if($team =='Digital Marketing'){ echo "selected"; }?>>Digital Marketing</option>
															<option value="Design" <?php if($team =='Design'){ echo "selected"; }?>>Design</option>
															<option value="HR" <?php if($team =='HR'){ echo "selected"; }?>>HR</option>
															<option value="Business Development" <?php if($team =='Business Development'){ echo "selected"; }?>>Business Development</option>
										    	        </select>
													</div>
													<div class="col-md-2">
														<label class="form-label">Status</label>
														<select name="status" id="status" class="form-control" value="<?= $status; ?>">
										    			    <option value="">-- Select Employee Status --</option>
										    			    <option value="Active" <?php if($status == 'Active') { echo "Selected"; }?>>Active</option>
										    			    <option value="Resign" <?php if($status == 'Resign') { echo "Selected"; }?>>Resign</option>
														    <option value="Abscond" <?php if($status == 'Abscond') { echo "Selected"; }?>>Abscond</option>
														    <option value="Terminated" <?php if($status == 'Terminated') { echo "Selected"; }?>>Terminated</option>
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
									<h2 style="text-align: center">DUBU DUBU Employee Report</h2>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<div class="new_table">
										<table id="data_table" class="table">
											<thead style="border-width:5px">
												<tr>
													<th>S.No</th>
													<th>Emp ID</th>
													<th>Name</th>
													<th>Designation</th>
                                                    <th style="text-align: center">Phone Number</th>
                                                    <th>Personal Email</th>
                                                    <th style="text-align: center">DOB</th>
                                                    <th style="text-align: center">Gender</th>
                                                    <th>Current Address</th>
                                                    <th style="text-align: center">DOJ</th>
                                                    <th style="text-align: center">Location</th>
                                                    <th style="text-align: center">Status</th>
												</tr>
											</thead>

											<tbody>
												<?php
													// getting from-date and to-date value
													if($fd != "" && $td != ""){
														$fdSql = "AND doj BETWEEN '$fd' AND '$td'";
														$tdSql = "";
													}
													else{
														if($fd != ""){
															$fdSql = "AND doj = '$fd'";
														}
														else{
															$fdSql = "";
														}
	
														if($td != ""){
															$tdSql = "AND doj = '$td'";
														}
														else{
															$tdSql = "";
														}
													}

													// getting status value
													if($status != ""){
														$statusSql = "AND emp_status = '$status'";
													}
													else{
														$statusSql = "";
													}

													// getting location value
													if($location != ""){
														$locationSql = "AND location = '$location'";
													}
													else{
														$locationSql = "";
													}

													// getting team value
													if($team != ""){
														$teamSql = "AND team = '$team'";
													}
													else{
														$teamSql = "";
													}

                                                    $sql = "SELECT * FROM employee
													WHERE del_status = 0 AND control != 5 $fdSql $tdSql $statusSql $locationSql $teamSql ORDER BY fname ASC";
													// echo $sql; exit();
                                                    $result = $conn->query($sql);
                                                    $count = 1;
                                                    while($row = mysqli_fetch_array($result)){
												?>
												    <tr>
                                                        <td><?= $count++; ?></td>
                                                        <td><?= $row['emp_id']; ?></td>
                                                        <td><?= $row['fname']." ".$row['lname']; ?></td>
                                                        <td><?= $row['designation']; ?></td>
                                                        <td style="text-align: center"><?= $row['pphno']; ?></td>
                                                        <td><?= $row['pemail']; ?></td>
                                                        <td style="text-align: center"><?= date('d-m-Y', strtotime($row['dob'])); ?></td>
                                                        <td style="text-align: center"><?= $row['gender']; ?></td>
                                                        <td><?= $row['caddress']; ?></td>
                                                        <td style="text-align: center"><?= date('d-m-Y', strtotime($row['doj'])); ?></td>
                                                        <td style="text-align: center"><?= $row['location']; ?></td>
                                                        <?php
                                                            if($row['emp_status'] == 'Active'){
                                                                $empStatus = $row['emp_status'];
                                                                $class = 'badge-success';
                                                            }
                                                            else{
                                                                $empStatus = $row['emp_status'];
                                                                $class = 'badge-danger';
                                                            }
                                                        ?>
                                                        <td style="text-align: center"><span class="badge <?= $class; ?>"><?= $empStatus;?></span></td>
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

<?php

session_start();
ini_set("display_errors",'off');

include("include/connection.php");
$dashboard = "active";
$dashboardBoolean = 'true';
$dash_show = 'show';
$dash_apply = 'active';

$today = date('Y-m-d');
$today1 = date('d-m-Y');

$employee_sql1 = "SELECT * FROM employee WHERE del_status = 0 AND doj <= '$today' AND control != 5 AND emp_status = 'Active'";
$employee_result1 = $conn->query($employee_sql1);
$count = $employee_result1->num_rows;

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="ekka - Admin Dashboard eCommerce HTML Template.">

	<title>DUBU DUBU - Dashboard</title>

	<!-- GOOGLE FONTS -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet"> 

	<link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />

	<!-- PLUGINS CSS STYLE -->
	<link href="assets/plugins/daterangepicker/daterangepicker.css" rel="stylesheet">
	<link href="assets/plugins/simplebar/simplebar.css" rel="stylesheet" />

	<!-- ekka CSS -->
	<link id="ekka-css" href="assets/css/ekka.css" rel="stylesheet" />

	<!-- FAVICON -->
	<link href="assets/img/favicon.png" rel="shortcut icon" />

</head>

<body onload="updateImage()" class="ec-header-fixed ec-sidebar-fixed ec-sidebar-light ec-header-light" id="body">

	<!--  WRAPPER  -->
	<div class="wrapper">
		
		<!-- LEFT MAIN SIDEBAR -->
		<?php include("include/side-bar.php"); ?>

		<!--  PAGE WRAPPER -->
		<div class="ec-page-wrapper">

			<!-- Header Begins -->
			<?php include("include/header.php"); ?>
			<!-- Header End -->

			<!-- CONTENT WRAPPER -->
			<div class="ec-content-wrapper">
				<div class="content">
					<!-- Employee -->
					<div class="row">
						<div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
							<div class="card card-mini dash-card card-1">
								<div class="card-body new-class">
									<h2 class="mb-1"><?php echo $count;?></h2>
									<p>Total Employees</p>
									<span class="mdi mdi-account-group"></span>
								</div>
							</div>
						</div>

						<?php
						$count_sql = "SELECT COUNT(location) AS locationcount, location FROM employee
						WHERE del_status = 0 AND doj <= '$today' AND control != 5 AND emp_status = 'Active' GROUP BY location";
						$count_result = $conn->query($count_sql);
						while($count_row = mysqli_fetch_array($count_result)){
						?>
							<div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
								<div class="card card-mini dash-card card-2">
									<div class="card-body new-class">
										<h2 class="mb-1"><?php echo $count_row['locationcount']; ?></h2>
										<p><?php echo $count_row['location']; ?></p>
										<span class="mdi mdi-account-multiple"></span>
									</div>
								</div>
							</div>
						<?php
						}
						?>
						<!-- <div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
							<div class="card card-mini dash-card card-3">
								<div class="card-body">
									<h2 class="mb-1">15,503</h2>
									<p>Daily Order</p>
									<span class="mdi mdi-package-variant"></span>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
							<div class="card card-mini dash-card card-4">
								<div class="card-body">
									<h2 class="mb-1">$98,503</h2>
									<p>Daily Revenue</p>
									<span class="mdi mdi-currency-usd"></span>
								</div>
							</div>
						</div> -->
					</div>

					<!-- Attendance Table -->
					<div class="row">
						<div class="col-xl-7 col-md-12 p-b-15">
							<!-- Team Report -->
							<div id="user-acquisition" class="card card-default">
								<div class="card-header">
									<h2>DUBU DUBU Team Wise Attendance - <?php echo $today1;?></h2>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="responsive-data-table" class="table" style="width:100%">
											<thead>
												<tr>
													<th>S.No</th>
													<th>Team</th>
													<th style="text-align: center">Total Employees</th>
													<th style="text-align: center">Today Present</th>
												</tr>
											</thead>
											<tbody>
												<?php
												// $team_count_sql = "SELECT COUNT(team) AS team_count, team FROM employee WHERE del_status = 0 AND emp_status = 'Active' GROUP BY team";
												// echo $employee_sql;
												// $team_count_result = $conn->query($team_count_sql);
												$sql = "SELECT a.department, COUNT(a.department) AS teamcount,
												COUNT(CASE WHEN b.status=0 THEN 1 END) AS present FROM employee a
												LEFT OUTER JOIN attendance b ON a.id = b.emp_id
												WHERE a.del_status = 0 AND a.emp_status = 'Active' AND b.date='$today' GROUP BY a.department";
												// echo $sql;
												$result = $conn->query($sql);
												$a = 1;
												if($result->num_rows > 0){
												while($row = mysqli_fetch_array($result)){
												?>
													<tr>
														<td><?php echo $a++; ?></td>
														<td><?php echo $row['department']; ?></td>
														<td style="text-align: center"><?php echo $row['teamcount']; ?></td>
														<td style="text-align: center"><?php echo $row['present']; ?></td>
													</tr>
												<?php
												}
												}
												else{
												?>
													<tr><td colspan="4" style="text-align: center">Today Attendance Not updated</td></tr>
												<?php
												}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>

						<div class="col-xl-5 col-md-12 p-b-15">
							<!-- Total Report -->
							<div id="user-acquisition" class="card card-default">
								<div class="card-header">
									<h2>Attendance - <?php echo $today1; ?></h2>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="responsive-data-table" class="table" style="width:100%">
											<tbody>
												<?php
												$sql1 = "SELECT COUNT(CASE WHEN a.status = 0 THEN 1 END) AS present,
												COUNT(CASE WHEN a.status = 1 THEN 1 END) AS absent,
												COUNT(CASE WHEN count = 1 && a.status = 1 THEN 1 END) AS fullday,
												COUNT(CASE WHEN count = 2 THEN 1 END) AS halfday FROM attendance a
												LEFT OUTER JOIN employee b ON b.id = a.emp_id WHERE a.date='$today' AND b.emp_status = 'Active';";
												$result1 = $conn->query($sql1);
												// if($result->num_rows > 0){
												while($row1 = mysqli_fetch_array($result1)){
												?>
													<tr>
														<td colspan="2">Total Employees <h3 style="display: contents"><span class="badge bg-primary float-end"><?php echo $count; ?></span></h3></td>
													</tr>
													<tr>
														<td colspan="2">Total Present <h3 style="display: contents"><span class="badge bg-success float-end"><?php echo $row1['present']; ?></span></h3></td>
													</tr>
													<tr>
														<td colspan="2">Total Absent <h3 style="display: contents"><span class="badge bg-failed float-end"><?php echo $row1['absent']; ?></span></h3></td>
													</tr>
													<tr>
														<td>Full Day <h3 style="display: contents"><span class="badge bg-orange float-end" style="background-color: #e45b259e"><?php echo $row1['fullday']; ?></span></h3></td>
														<td style="color: #56606e; font-weight: 500">Half Day <h3 style="display: contents"><span class="badge bg-warning float-end"><?php echo $row1['halfday']; ?></span></h3></td>
													</tr>
												<?php
													if($row1['present'] == 0 && $row1['fullday'] == 0 && $row1['halfday'] == 0){
														?>
														<tr><h3><td colspan="2" style="text-align: center">Today Attendance Not updated</td></h3></tr>
														<?php
													}
												}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Leave Details -->
					<div class="row">
						<div class="col-xl-7 col-md-12 p-b-15">
						<div id="user-acquisition" class="card card-default">
							<div class="card-header">
								<h2 style="text-align: center">Leave Details</h2>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col col-md-12 p-b-15">
										<!-- <h4 style="text-align: center">Informed</h4> -->
											<div class="row">
												<div class="col-6">
													<div class="table-responsive">
														<table id="responsive-data-table" class="table" style="width:100%, border-width:5px solid black">
															<thead>
																<tr>
																	<th colspan="2" style="text-align: center">Full Day</th>
																</tr>
															</thead>
															<tbody>
																<?php
																$attend_sql = "SELECT * FROM attendance a
																LEFT OUTER JOIN employee b ON a.emp_id=b.id WHERE a.date='$today' AND a.status=1 AND a.inform_status=1 AND a.count=1 AND b.emp_status = 'Active'";
																$attend_result = $conn->query($attend_sql);
																$a = 1;
																while($attend_row = mysqli_fetch_array($attend_result)){
																	if($attend_row['type'] == 1){
																		$type = "Casual Leave";
																	}
																	elseif($attend_row['type'] == 2){
																		$type = "Sick Leave";
																	}
																	elseif($attend_row['type'] == 3){
																		$type = "LOP";
																	}
																?>
																	<tr>
																		<td><?php echo $a++; ?></td>
																		<td><?php echo $attend_row['fname'];?>&nbsp;<?php echo $attend_row['lname'];?>&nbsp;<?php echo "- ".$type;?></td>
																	</tr>
																<?php
																}
																?>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-6">
													<div class="table-responsive">
														<table id="responsive-data-table" class="table" style="width:100%">
															<thead>
																<tr>
																	<th colspan="2" style="text-align: center">Half Day</th>
																</tr>
															</thead>
															<tbody>
																<?php
																$attend_sql1 = "SELECT * FROM attendance a
																LEFT OUTER JOIN employee b ON a.emp_id=b.id WHERE a.date='$today' AND a.status=1 AND a.inform_status=1 AND a.count=2";
																$attend_result1 = $conn->query($attend_sql1);
																$a = 1;
																while($attend_row1 = mysqli_fetch_array($attend_result1)){
																	if($attend_row1['type'] == 1){
																		$type = "Casual Leave";
																	}
																	elseif($attend_row1['type'] == 2){
																		$type = "Sick Leave";
																	}
																	elseif($attend_row1['type'] == 3){
																		$type = "LOP";
																	}
																?>
																	<tr>
																		<td><?php echo $a++; ?></td>
																		<td><?php echo $attend_row1['fname'];?>&nbsp;<?php echo $attend_row1['lname'];?>&nbsp;<?php echo "- ".$type;?></td>
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
									<!-- <div class="col-xl-6 col-md-12 p-b-15">
										<h4 style="text-align: center">Uninformed</h4>
											<div class="row">
												<div class="col-6">
													<div class="table-responsive">
														<table id="responsive-data-table" class="table" style="width:100%">
															<thead>
																<tr>
																	<th colspan="2" style="text-align: center">Full Day</th>
																</tr>
															</thead>
															<tbody>
																<?php
																$attend_sql2 = "SELECT * FROM attendance a
																LEFT OUTER JOIN employee b ON a.emp_id=b.id WHERE a.date='$today' AND a.status=1 AND a.inform_status=2 AND a.count=1";
																$attend_result2 = $conn->query($attend_sql2);
																$a = 1;
																while($attend_row2 = mysqli_fetch_array($attend_result2)){
																?>
																	<tr>
																		<td><?php echo $a++; ?></td>
																		<td><?php echo $attend_row2['fname'];?>&nbsp;<?php echo $attend_row2['lname'];?></td>
																	</tr>
																<?php
																	}
																?>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-6">
													<div class="table-responsive">
														<table id="responsive-data-table" class="table" style="width:100%">
															<thead>
																<tr>
																	<th colspan="2" style="text-align: center">Half Day</th>
																</tr>
															</thead>
															<tbody>
																<?php
																$attend_sql3 = "SELECT * FROM attendance a
																LEFT OUTER JOIN employee b ON a.emp_id=b.id WHERE a.date='$today' AND a.status=1 AND a.inform_status=2 AND a.count=2";
																$attend_result3 = $conn->query($attend_sql3);
																$a = 1;
																while($attend_row3 = mysqli_fetch_array($attend_result3)){
																?>
																	<tr>
																		<td><?php echo $a++; ?></td>
																		<td><?php echo $attend_row3['fname'];?>&nbsp;<?php echo $attend_row3['lname'];?></td>
																	</tr>
																<?php
																	}
																?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
									</div> -->
								</div>
							</div>
						</div>
						</div>
						<div class="col-xl-5 col-md-12 p-b-15">
						<div id="user-acquisition" class="card card-default">
							<div class="card-header">
								<h2 style="text-align: center">New Joinees</h2>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col">
										<div class="table-responsive">
											<table id="responsive-data-table" class="table" style="width:100%">
												<thead>
													<tr>
														<th>S.No</th>
														<th>Name</th>
														<th>Designation</th>
														<th>Location</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$emp_sql = "SELECT * FROM employee WHERE del_status = 0 AND emp_status = 'Active'";
													$emp_result = $conn->query($emp_sql);
													$a = 1;
													while($emp_row = mysqli_fetch_array($emp_result)){
														$date = $emp_row['doj'];
														$endDate = date('Y-m-d',strtotime($date. '+7 days'));
														if(($date <= $today) && ($endDate >= $today)){
													?>
														<tr>
															<td><?php echo $a++; ?></td>
															<td><?php echo $emp_row['fname'];?> <?php echo $emp_row['lname'];?></td>
															<td><?php echo $emp_row['designation'];?></td>
															<td><?php echo $emp_row['location'];?></td>
														</tr>
													<?php
														}
													}
													?>
												</tbody>
											</table>
										</div>
									</div>
									<!-- <div class="col">
										<div class="table-responsive">
											<table id="responsive-data-table" class="table" style="width:100%">
												<thead>
													<tr>
														<th colspan="2" style="text-align: center">Resign</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$attend_sql = "SELECT * FROM attendance a
													LEFT OUTER JOIN employee b ON a.emp_id=b.id WHERE a.date='2023-04-11' AND a.status=0 AND a.location=3";
													$attend_result = $conn->query($attend_sql);
													$a = 1;
													while($attend_row = mysqli_fetch_array($attend_result)){
													?>
														<tr>
															<td><?php echo $a++; ?></td>
															<td><?php echo $attend_row['fname'];?>&nbsp;<?php echo $attend_row['lname'];?></td>
														</tr>
													<?php
													}
													?>
												</tbody>
											</table>
										</div>
									</div>
									<div class="col">
										<div class="table-responsive">
											<table id="responsive-data-table" class="table" style="width:100%">
												<thead>
													<tr>
														<th colspan="2" style="text-align: center">Terminate</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$attend_sql = "SELECT * FROM attendance a
													LEFT OUTER JOIN employee b ON a.emp_id=b.id WHERE a.date='2023-04-11' AND a.status=0 AND a.location=3";
													$attend_result = $conn->query($attend_sql);
													$a = 1;
													while($attend_row = mysqli_fetch_array($attend_result)){
													?>
														<tr>
															<td><?php echo $a++; ?></td>
															<td><?php echo $attend_row['fname'];?>&nbsp;<?php echo $attend_row['lname'];?></td>
														</tr>
													<?php
													}
													?>
												</tbody>
											</table>
										</div>
									</div> -->
								</div>
							</div>
						</div>
						</div>
					</div>

					<!-- OD Details -->
					<div class="row">
						<div class="col col-md-12 p-b-15">
						<div id="user-acquisition" class="card card-default">
							<div class="card-header">
								<h2 style="text-align: center">OD Details</h2>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col">
										<div class="table-responsive">
											<table id="responsive-data-table" class="table" style="width:100%">
												<thead>
													<tr>
														<th colspan="2" style="text-align: center">Client Meet</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$attend_sql4 = "SELECT * FROM attendance a
													LEFT OUTER JOIN employee b ON a.emp_id=b.id WHERE a.date='$today' AND a.status=0 AND a.location=2";
													$attend_result4 = $conn->query($attend_sql4);
													$a = 1;
													while($attend_row4 = mysqli_fetch_array($attend_result4)){
													?>
														<tr>
															<td><?php echo $a++; ?></td>
															<td><?php echo $attend_row4['fname'];?>&nbsp;<?php echo $attend_row4['lname'];?></td>
														</tr>
													<?php
													}
													?>
												</tbody>
											</table>
										</div>
									</div>
									<div class="col">
										<div class="table-responsive">
											<table id="responsive-data-table" class="table" style="width:100%">
												<thead>
													<tr>
														<th colspan="2" style="text-align: center">Work From Home</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$attend_sql5 = "SELECT * FROM attendance a
													LEFT OUTER JOIN employee b ON a.emp_id=b.id WHERE a.date='$today' AND a.status=0 AND a.location=3";
													$attend_result5 = $conn->query($attend_sql5);
													$a = 1;
													while($attend_row5 = mysqli_fetch_array($attend_result5)){
													?>
														<tr>
															<td><?php echo $a++; ?></td>
															<td><?php echo $attend_row5['fname'];?>&nbsp;<?php echo $attend_row5['lname'];?></td>
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
					</div>

					<!-- Employee Details -->
					<!-- <div class="row">
						<div class="col-xl-4 col-md-12 p-b-15">
						<div id="user-acquisition" class="card card-default">
							<div class="card-header">
								<h2 style="text-align: center">Employee Details</h2>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col">
										<div class="table-responsive">
											<table id="responsive-data-table" class="table" style="width:100%">
												<thead>
													<tr>
														<th colspan="2" style="text-align: center">New Joinee</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$emp_sql = "SELECT * FROM employee WHERE del_status=0 AND emp_status = 'Active'";
													$emp_result = $conn->query($emp_sql);
													$a = 1;
													while($emp_row = mysqli_fetch_array($emp_result)){
														$date = $emp_row['doj'];
														$endDate = date('Y-m-d',strtotime($date. '+7 days'));
														if(($date <= $today) && ($endDate >= $today)){
													?>
														<tr>
															<td><?php echo $a++; ?></td>
															<td><?php echo $emp_row['fname'];?> <?php echo $emp_row['lname'];?> <?php echo "- ".$emp_row['designation'];?></td>
														</tr>
													<?php
														}
													}
													?>
												</tbody>
											</table>
										</div>
									</div>
									<!-- <div class="col">
										<div class="table-responsive">
											<table id="responsive-data-table" class="table" style="width:100%">
												<thead>
													<tr>
														<th colspan="2" style="text-align: center">Resign</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$attend_sql = "SELECT * FROM attendance a
													LEFT OUTER JOIN employee b ON a.emp_id=b.id WHERE a.date='2023-04-11' AND a.status=0 AND a.location=3";
													$attend_result = $conn->query($attend_sql);
													$a = 1;
													while($attend_row = mysqli_fetch_array($attend_result)){
													?>
														<tr>
															<td><?php echo $a++; ?></td>
															<td><?php echo $attend_row['fname'];?>&nbsp;<?php echo $attend_row['lname'];?></td>
														</tr>
													<?php
													}
													?>
												</tbody>
											</table>
										</div>
									</div>
									<div class="col">
										<div class="table-responsive">
											<table id="responsive-data-table" class="table" style="width:100%">
												<thead>
													<tr>
														<th colspan="2" style="text-align: center">Terminate</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$attend_sql = "SELECT * FROM attendance a
													LEFT OUTER JOIN employee b ON a.emp_id=b.id WHERE a.date='2023-04-11' AND a.status=0 AND a.location=3";
													$attend_result = $conn->query($attend_sql);
													$a = 1;
													while($attend_row = mysqli_fetch_array($attend_result)){
													?>
														<tr>
															<td><?php echo $a++; ?></td>
															<td><?php echo $attend_row['fname'];?>&nbsp;<?php echo $attend_row['lname'];?></td>
														</tr>
													<?php
													}
													?>
												</tbody>
											</table>
										</div>
									</div> -->
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

	<!-- Chart -->
	<script src="assets/plugins/charts/Chart.min.js"></script>
	<script src="assets/js/chart.js"></script>

	<!-- Google map chart -->
	<script src="assets/plugins/charts/google-map-loader.js"></script>
	<script src="assets/plugins/charts/google-map.js"></script>

	<!-- Date Range Picker -->
	<script src="assets/plugins/daterangepicker/moment.min.js"></script>
    <script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
	<script src="assets/js/date-range.js"></script>

	<!-- Option Switcher -->
	<script src="assets/plugins/options-sidebar/optionswitcher.js"></script>

	<!-- ekka Custom -->
	<script src="assets/js/ekka.js"></script>
	<script src="assets/js/manual.js"></script>
</body>

</html>
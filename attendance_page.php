<?php

session_start();
ini_set("display_errors",'off');
date_default_timezone_set('Asia/Kolkata');
$current_time = date('d/m/Y H:i:s');
include("include/connection.php");
$attendance = "active";
$atten_boolean = 'true';
$attendance_show = 'show';
$attendance_page = 'active';

$id = $_SESSION['id'];
$sql = "SELECT * FROM employee a LEFT JOIN designation b ON a.designation = b.desig_id WHERE a.id = '$id'";
$result = $conn->query($sql);
$sessionrow = $result->fetch_assoc();

$weeksql = "SELECT COALESCE(SUM(TIMESTAMPDIFF(HOUR, punch_in_time, punch_out_time)),0) AS total_hours,
    COALESCE(SUM(GREATEST(TIMESTAMPDIFF(HOUR, punch_in_time, punch_out_time) - 8, 0)),0) AS overtime_hours 
	FROM attendance_records WHERE employee_id = '$id' 
    	AND punch_out_time IS NOT NULL
    	AND YEARWEEK(date, 1) = YEARWEEK(NOW(), 1)";
$weekresult = $conn->query($weeksql);
$weekrow = $weekresult->fetch_assoc();

$monthsql = "SELECT COALESCE(SUM(TIMESTAMPDIFF(HOUR, punch_in_time, punch_out_time)),0) AS total_hours,
    COALESCE(SUM(GREATEST(TIMESTAMPDIFF(HOUR, punch_in_time, punch_out_time) - 8, 0)),0) AS overtime_hours
	FROM attendance_records WHERE employee_id = '$id' 
    	AND punch_out_time IS NOT NULL
    	AND YEAR(date) = YEAR(NOW()) 
    	AND MONTH(date) = MONTH(NOW())";
$monthresult = $conn->query($monthsql);
$monthrow = $monthresult->fetch_assoc();



$today = date("Y-m-d");
$todaysql = "SELECT punch_in_time, punch_out_time, break_times FROM attendance_records 
        WHERE employee_id = '$id' AND DATE(date) = '$today'";

		
$totayresult = $conn->query($todaysql);
$todayrow = $totayresult->fetch_assoc();

$punch_in = new DateTime($todayrow['punch_in_time']);
$punch_out = new DateTime($todayrow['punch_out_time']);
$break_times = json_decode($todayrow['break_times'], true);

$total_duration = $punch_in->diff($punch_out);

$total_break_minutes = 0;
foreach ($break_times as $break) {
    $start = new DateTime($today . " " . $break['start']);
    $end = new DateTime($today . " " . $break['end']);
    $interval = $start->diff($end);
    $total_break_minutes += ($interval->h * 60) + $interval->i + round($interval->s / 60);
}

$break_duration = minutes_to_interval($total_break_minutes);
$formatbreak_duration = format_minutes(interval_to_minutes($break_duration));

$production_duration = subtract_intervals($total_duration, $break_duration);
$formatted_production_hours = format_minutes(interval_to_minutes($production_duration));

$standard_working_hours = new DateInterval("PT8H");
$overtime = max(0, interval_to_minutes($total_duration) - interval_to_minutes($standard_working_hours));

$total_hrs = format_interval($total_duration);
// $break_hrs = format_interval($break_duration);
$break_hrs = $formatbreak_duration;
$production_hrs = $formatted_production_hours;
$overtime_hrs = format_minutes($overtime);


function add_intervals($interval1, $interval2) {
    $total = new DateTime("@0");
    $total->add($interval1);
    $total->add($interval2);
    return $total->diff(new DateTime("@0"));
}

function subtract_intervals($interval1, $interval2) {
    $total_minutes = interval_to_minutes($interval1) - interval_to_minutes($interval2);
    return minutes_to_interval($total_minutes);
}

function interval_to_minutes($interval) {
    return ($interval->h * 60) + $interval->i + ($interval->s / 60);
}

function minutes_to_interval($minutes) {
    return new DateInterval("PT" . floor($minutes) . "M");
}

function format_interval($interval) {
    return sprintf("%02d hrs %02d min", $interval->h, $interval->i);
}

function format_minutes($minutes) {
    return sprintf("%02d hrs %02d min", floor($minutes / 60), $minutes % 60);
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="ekka - Admin Dashboard eCommerce HTML Template.">

	<title>DUBU DUBU - Attendance</title>

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

	<!-- Data-Tables -->
	<link href='assets/plugins/data-tables/datatables.bootstrap5.min.css' rel='stylesheet'>
	<link href='assets/plugins/data-tables/responsive.datatables.min.css' rel='stylesheet'>



</head>
<style>
    	.timeline-container {
            width: 100%;
            max-width: 800px;
        }
        .timeline-bar {
            display: flex;
            align-items: center;
            background: #f5f5f5;
            border-radius: 10px;
            padding: 10px;
            overflow: show;
        }
        .time-slot {
            height: 20px;
            border-radius: 10px;
            margin: 0 2px;
        }
        
		.profile-pic img {
			width: 100px;
			height: 100px;
			background: #f8c02d;
		}

		.text-muted {
			font-size: 12px;
		}

		.badge-warning {
			background: #ffc107;
			padding: 5px 10px;
			font-size: 14px;
			border-radius: 5px;
		}

		.rounded-circle {
			border-radius: 50px !important;
		}

		.icon-box {
			width: 50px;
			height: 50px;
			display: flex;
			align-items: center;
			justify-content: center;
			background-color: #1e293b;
			color: white;
			border-radius: 10px;
			margin: 0 auto 10px;
			font-size: 24px;
		}

		.text-muted {
			font-size: 14px;
			color: #6c757d;
		}

		.bottom-label {
			font-weight: bold;
			color: #444;
		}

		hr {
			width: 50%;
			margin: 10px auto;
			border-top: 1px solid #ddd;
		}

		.m-4 {
			margin: 15px !important;
		}

</style>
<style>
    .time-slot {
        position: relative;
        display: inline-block;
        cursor: pointer;
        margin: 2px;
    }

    .time-slot::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background-color: rgba(0, 0, 0, 0.8);
        color: #fff;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
        white-space: nowrap;
        visibility: hidden;
        opacity: 0;
        transition: opacity 0.2s ease-in-out;
    }

    .time-slot:hover::after {
        visibility: visible;
        opacity: 1;
    }
</style>


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
					<div class="row">

						<div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
							<div class="card card-mini dash-card card-1">
								<div class="card-body new-class">
									<div class="d-flex align-items-center">
										<div class="profile-pic">
											<img src="https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png" alt="Profile" class="rounded-circle">
										</div>
										<div class="ml-4">
											<small class="text-muted" id="time"><?= $current_time ?></small>
											<h4 class="mb-0"><?= $sessionrow['fname']; ?> <?= $sessionrow['lname']; ?></h4>
											<p class="text-muted"><?= $sessionrow['designation_name']; ?></p>
											<div class="badge badge-warning">Production : <?= $production_hrs;?></div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-xl-2 col-sm-6 p-b-15 lbl-card">
							<div class="card card-mini dash-card card-2">
								<div class="card-body text-center">
									<div class="icon-box">
										<i class="mdi mdi-calendar-range"></i>
									</div>
									<h5 class="mb-0"><strong><?= $weekrow['total_hours'];?>/48 hrs</strong></h5>
									<p class="text-muted">Total hrs</p>
									<hr>
									<p class="bottom-label">This Week</p>
								</div>
							</div>
						</div>

						<div class="col-xl-2 col-sm-6 p-b-15 lbl-card">
							<div class="card card-mini dash-card card-2">
								<div class="card-body text-center">
									<div class="icon-box">
										<i class="mdi mdi-calendar-multiselect"></i>
									</div>
									<h5 class="mb-0"><strong><?= $monthrow['total_hours'];?>/160 hrs</strong></h5>
									<p class="text-muted">Total hrs</p>
									<hr>
									<p class="bottom-label">This Month</p>
								</div>
							</div>
						</div>
						
						<div class="col-xl-2 col-sm-6 p-b-15 lbl-card">
							<div class="card card-mini dash-card card-3">
								<div class="card-body text-center">
									<div class="icon-box">
										<i class="mdi mdi-calendar-clock"></i>
									</div>
									<h5 class="mb-0"><strong><?= $weekrow['overtime_hours'];?> hrs</strong></h5>
									<p class="text-muted">OT hrs</p>
									<hr>
									<p class="bottom-label">This Week</p>
								</div>
							</div>
						</div>


						<div class="col-xl-2 col-sm-6 p-b-15 lbl-card">
							<div class="card card-mini dash-card card-3">
								<div class="card-body text-center">
									<div class="icon-box">
										<i class="mdi mdi-calendar-clock"></i>
									</div>
									<h5 class="mb-0"><strong><?= $monthrow['overtime_hours'];?> hrs</strong></h5>
									<p class="text-muted">OT hrs</p>
									<hr>
									<p class="bottom-label">This Month</p>
								</div>
							</div>
						</div>
					</div>

					<div class="row m-b30">
						<div class="col-12">
							<div class="card card-default">
								<div class="card-body">
									<div class="row ec-vendor-uploads">
										<div class="col-md-3">
											<b class="text-danger m-3"><span id="punch_in_time">__:__</span></b>
											<button id="punch_in_btn" class="btn btn-primary m-4">Punch In</button>
											<button id="break_btn" class="btn btn-warning m-4" style="display:none;">Break</button>
											<button id="resume_btn" class="btn btn-success m-4" style="display:none;">Resume</button>
											<button id="punch_out_btn" class="btn btn-danger m-4" style="display:none;">Punch Out</button>
										</div>
										<div class="col-md-9">
											<div class="d-flex">
												<p class="mx-2"><span class="time-label">Total Hrs:</span> <span class="text-success" style="color: green;"><?= $total_hrs;?></span></p> | 
												<p class="mx-2"><span class="time-label">Production Hrs:</span> <span class="text-success" style="color: green;"><?= $production_hrs;?></span></p> | 
												<p class="mx-2"><span class="time-label">Break Hrs:</span> <span class="text-danger" style="color: red;"><?= $break_hrs;?></span></p> | 
												<p class="mx-2"><span class="time-label">Over Time Hrs:</span> <span class="text-primary" style="color: blue;"><?= $overtime_hrs;?></span></p>
											</div>

											<div class="timeline-container">
												<div class="timeline-bar">
												<?php

													$sql = "SELECT * FROM attendance_records WHERE employee_id = '$id' and date = '$today'";
													$result = $conn->query($sql);
													$row = $result->fetch_assoc();
													$attendance = [
														'punch_in_time' => $row['punch_in_time'],
														'break_times' => $row['break_times'],
														'punch_out_time' => $row['punch_out_time']
													];

													$breaks = json_decode($attendance['break_times'], true);
													$punchIn = strtotime($attendance['punch_in_time']);
													$punchOut = strtotime($attendance['punch_out_time']);

													$totalWork = 0;
													$lastPunch = $punchIn;

													echo "<div class='time-slot work' style='background: #18c6a7; flex: 1;' 
															data-tooltip='Work Start: " . date('H:i', $punchIn) . "'></div>";

													if (is_array($breaks) && count($breaks) > 0) {
														foreach ($breaks as $break) {
															if (isset($break['start'], $break['end'])) {
																$breakStart = strtotime($break['start']);
																$breakEnd = strtotime($break['end']);

																$workDuration = $breakStart - $lastPunch;
																$totalWork += $workDuration;

																echo "<div class='time-slot work' style='background: #18c6a7; flex: " . max($workDuration, 1) . ";' 
																		data-tooltip='Work: " . date('H:i', $lastPunch) . " - " . date('H:i', $breakStart) . "'></div>";

																echo "<div class='time-slot break' style='background: #ff6b5b; flex: " . max(($breakEnd - $breakStart), 1) . ";' 
																		data-tooltip='Break: " . date('H:i', $breakStart) . " - " . date('H:i', $breakEnd) . "'></div>";

																$lastPunch = $breakEnd;
															}
														}
													}

													$finalWork = $punchOut - $lastPunch;
													$totalWork += $finalWork;

													echo "<div class='time-slot work' style='background: #18c6a7; flex: " . max($finalWork, 1) . ";' 
															data-tooltip='Work: " . date('H:i', $lastPunch) . " - " . date('H:i', $punchOut) . "'></div>";


													echo "<div class='time-slot work' style='background: #18c6a7; flex: 1;' 
															data-tooltip='Work End: " . date('H:i', $punchOut) . "'></div>";


													$standardWorkDuration = 8 * 3600;
													$overtime = max(0, $totalWork - $standardWorkDuration);
													if ($overtime > 0) {
														echo "<div class='time-slot overtime' style='background: #4285f4; flex: " . max($overtime, 1) . ";' 
																data-tooltip='Overtime: " . gmdate('H:i', $overtime) . "'></div>";
													}
												?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xl col-md-12 p-b-15">
							<div id="user-acquisition" class="card card-default">
								<div class="card-body">
									<div class="row">
										<div class="col">
											<div class="table-responsive">
												<table id="responsive-data-table" class="table">
													<thead>
														<tr>
															<th>Date</th>
															<th>Status</th>
															<th>Punch in</th>
															<th>Punch out</th>
															<th>Break</th>
															<th>Overtime</th>
															<th>Production Hrs</th>
															<th>Total Hrs</th>
														</tr>
													</thead>
													<tbody>
														<?php
														$start_date = date('Y-m-01');
														$end_date = date('Y-m-d');
														$dates = new DatePeriod(new DateTime($start_date), new DateInterval('P1D'), new DateTime($end_date . ' +1 day'));

														foreach ($dates as $dateObj) {
															$current_date = $dateObj->format('Y-m-d');
															$day_of_week = $dateObj->format('l');

															$sql = "SELECT * FROM attendance_records WHERE employee_id = '$id' AND date = '$current_date'";
															$result = $conn->query($sql);
															$row = mysqli_fetch_array($result);

															$punch_in = $row['punch_in_time'] ?? null;
															$punch_out = $row['punch_out_time'] ?? null;

															if ($day_of_week === 'Sunday') {
																$status = "<span style='color: orange;'>Weekoff</span>";
																$total_time = $break_time = $production_time = $overtime_time = "-";
															} elseif (!empty($punch_in)) {
																$status = "<span style='color: green;'>Present</span>";

																$punch_in_time = strtotime($punch_in);
																$punch_out_time = strtotime($punch_out);

																$total_seconds = $punch_out_time - $punch_in_time;
																$total_hours = floor($total_seconds / 3600);
																$total_minutes = floor(($total_seconds % 3600) / 60);
																$total_time = sprintf("%d hrs %d min", $total_hours, $total_minutes);

																$break_seconds = 0;
																$break_data = json_decode($row['break_times'] ?? '[]', true);
																if (is_array($break_data)) {
																	foreach ($break_data as $break) {
																		$start_time = strtotime($break['start']);
																		$end_time = strtotime($break['end']);
																		$break_seconds += ($end_time - $start_time);
																	}
																}
																$break_hours = floor($break_seconds / 3600);
																$break_minutes = floor(($break_seconds % 3600) / 60);
																$break_time = sprintf("%d hrs %d min", $break_hours, $break_minutes);

																$production_seconds = $total_seconds - $break_seconds;
																$production_hours = floor($production_seconds / 3600);
																$production_minutes = floor(($production_seconds % 3600) / 60);
																$production_time = sprintf("%d hrs %d min", $production_hours, $production_minutes);

																$overtime_seconds = max(0, $total_seconds - (8 * 3600));
																$overtime_hours = floor($overtime_seconds / 3600);
																$overtime_minutes = floor(($overtime_seconds % 3600) / 60);
																$overtime_time = sprintf("%d hrs %d min", $overtime_hours, $overtime_minutes);
															} else {
																$status = "<span style='color: red;'>Absent</span>";
																$total_time = $break_time = $production_time = $overtime_time = "-";
															}
														?>
														<tr>
															<td><?= $current_date; ?></td>
															<td><?= $status; ?></td>
															<td><?= !empty($punch_in) ? date('H:i A', strtotime($punch_in)) : "-"; ?></td>
															<td><?= !empty($punch_out) ? date('H:i A', strtotime($punch_out)) : "-"; ?></td>
															<td><?= $break_time; ?></td>
															<td><?= $overtime_time; ?></td>
															<td><?= $production_time; ?></td>
															<td><?= $total_time; ?></td>
														</tr>
														<?php } ?>
													</tbody>

												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
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
	<!-- Data-Tables -->
	<script src='assets/plugins/data-tables/jquery.datatables.min.js'></script>
	<script src='assets/plugins/data-tables/datatables.bootstrap5.min.js'></script>
	<script src='assets/plugins/data-tables/datatables.responsive.min.js'></script>

	<script>
        function updateTime() {
            let now = new Date();
            let options = { timeZone: "Asia/Kolkata", hour12: false };
            let timeString = now.toLocaleTimeString("en-GB", options);
            let dateString = now.toLocaleDateString("en-GB", options);
            document.getElementById("time").innerHTML = "<b>"+ dateString + "</b> " + timeString;
        }

        setInterval(updateTime, 1000); 
    </script>

	<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
	<script>
	$(document).ready(function () {
		$("#punch_in_btn").click(function () {

			
			$.ajax({
				url: "ajax/attendance.php",
				type: "POST",
				data: { action: "punch_in" },
				dataType: "json",
				success: function (response) {
					if (response.status === "success") {
						$("#punch_in_time").text("Punch In At: " + response.punch_in_time);
						$("#break_btn").show();
						$("#punch_out_btn").show();
						$("#punch_in_btn").hide();
					} else {
						alert("You have already punched in today.");
					}
				}
			});
		});

		$("#break_btn").click(function () {
			$.ajax({
				url: "ajax/attendance.php",
				type: "POST",
				data: { action: "break" },
				dataType: "json",
				success: function (response) {
					if (response.status === "success") {
						$("#punch_in_time").text("Break started at: " + response.break_time);
						alert("Break started at: " + response.break_time);
						$("#break_btn").hide();
						$("#resume_btn").show();
					}
				}
			});
		});

		$("#resume_btn").click(function () {
			$.ajax({
				url: "ajax/attendance.php",
				type: "POST",
				data: { action: "resume" },
				dataType: "json",
				success: function (response) {
					if (response.status === "success") {
						$("#punch_in_time").text("Resumed work at: " + response.break_end_time);
						alert("Resumed work at: " + response.break_end_time);
						$("#resume_btn").hide();
						$("#break_btn").show();
					}
				}
			});
		});

		$("#punch_out_btn").click(function () {
			$.ajax({
				url: "ajax/attendance.php",
				type: "POST",
				data: { action: "punch_out" },
				dataType: "json",
				success: function (response) {
					if (response.status === "success") {
						$("#punch_in_time").text("Punched out at: " + response.punch_out_time);
						alert("Punched out at: " + response.punch_out_time);
						$("#break_btn, #punch_out_btn").hide();
						$("#punch_in_btn").show();
					}
				}
			});
		});
	});
	</script>
</body>

</html>
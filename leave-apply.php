<?php

session_start();
ini_set('display_errors','off');
include("include/connection.php");
$attendance = 'active';
$atten_boolean = 'true';
$attendance_show = 'show';
$leave_apply = 'active';

$today = date('Y-m-d');

$emp_id = $_SESSION['id'];

$leaveid = $_GET['leaveid'];

$sql = "SELECT * FROM employee_leave WHERE id = '$leaveid'";
$result = $conn->query($sql);
$fetchrow = $result->fetch_assoc();
	
if (isset($_POST["request"])) {
    $type = $_POST['type'];
    $range = $_POST['range'];
    $fdate = $_POST['fDate'];
    $tdate = $_POST['tDate'];
    $reason = $_POST['reason'];
    $fn_an_status = $_POST['fn_an_status'];

    if ($tdate == null) {
        $tdate = $_POST['fDate'];
    }
    if ($fn_an_status == NULL) {
        $fn_an_status = 0;
    }

    if ($range == 1) {
        $leave_value = 1; 
    } elseif ($range == 2) {
        $leave_value = 0.5; 
    } elseif ($range == 4) {
        $start_date = new DateTime($fdate);
        $end_date = new DateTime($tdate);
        $diff = $start_date->diff($end_date)->days + 1;
        $leave_value = $diff;
    }

    if (!empty($leaveid)) {
        $query = "UPDATE employee_leave SET type = '$type', count = '$range', from_date = '$fdate', to_date = '$tdate', reason = '$reason', fn_an_status = '$fn_an_status', leave_value = '$leave_value' WHERE id = $leaveid";
        if ($conn->query($query) === TRUE) {
            header("location: leave-apply.php?msg=Leave Requested Updated!&type=warning");
        }
    } else {
        $leave_sql = "INSERT INTO employee_leave(emp_id, type, count, from_date, to_date, reason, applied_date, fn_an_status, tl_status, leave_value) VALUES ('$emp_id', '$type', '$range', '$fdate', '$tdate', '$reason', '$today', '$fn_an_status', 0, '$leave_value')";
        $leave_result = $conn->query($leave_sql);
        if ($leave_result) {
            header("location: leave-apply.php?msg=Leave Requested!&type=success");
        }
    }
}


$year = date("Y");
$month = date("m");

$query = "SELECT SUM(leave_value) as total_leaves FROM employee_leave WHERE emp_id = '$emp_id' AND tl_status = '1' AND count != '3' AND YEAR(from_date) = '$year' AND MONTH(from_date) = '$month'";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$total_leaves_this_month = $row['total_leaves'] ?? 0;

$allowed_leave = 1;

$loss_of_pay = ($total_leaves_this_month > $allowed_leave) ? ($total_leaves_this_month - $allowed_leave) : 0;

$leave_balance = ($total_leaves_this_month < $allowed_leave) ? ($allowed_leave - $total_leaves_this_month) : 0;

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="ekka - Admin Dashboard HTML Template.">

	<title>DUBU DUBU - Leave Apply</title>

	<!-- GOOGLE FONTS -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

	<link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />

	<!-- Data-Tables -->
	<link href='assets/plugins/data-tables/datatables.bootstrap5.min.css' rel='stylesheet'>
	<link href='assets/plugins/data-tables/responsive.datatables.min.css' rel='stylesheet'>

	<!-- PLUGINS CSS STYLE -->
	<link href="assets/plugins/simplebar/simplebar.css" rel="stylesheet" />

	<!-- ekka CSS -->
	<link id="ekka-css" rel="stylesheet" href="assets/css/ekka.css" />

	<!-- FAVICON -->
	<link href="assets/img/favicon.png" rel="shortcut icon" />

</head>


<body onload="updateImage()" class="ec-header-fixed ec-sidebar-fixed ec-sidebar-dark ec-header-light" id="body">

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
							<h1>Apply Leave</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Leave</p>
						</div>
					</div>

					<?php
						if($_GET['type'] == 'success'){
						?>
						<div class="alert alert-success text-center" role="alert" id="alert_msg">
							<?php echo $_REQUEST['msg']; ?>
						</div>
						<?php
						}elseif($_GET['type'] == 'warning'){
						?>
							<div class="alert alert-warning text-center" role="alert" id="alert_msg">
								<?php echo $_REQUEST['msg']; ?>
							</div>
						<?php
						}elseif($_GET['type'] == 'failed'){
						?>
						<div class="alert alert-danger text-center" role="alert" id="alert_msg">
							<?php echo $_REQUEST['msg']; ?>
						</div>
						<?php
						}
					?>

					<div class="row">
						<div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
							<div class="card card-mini dash-card card-1">
								<div class="card-body new-class">
									<h2 class="mb-1"><?= $total_leaves_this_month; ?></h2>
									<p>This Month Leave </p>
									<span class="mdi mdi-calendar-clock"></span>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
							<div class="card card-mini dash-card card-2">
								<div class="card-body new-class">
									<h2 class="mb-1"><?= $loss_of_pay; ?></h2>
									<p>Loss of Pay</p>
									<span class="mdi mdi-calendar"></span>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
							<div class="card card-mini dash-card card-2">
								<div class="card-body new-class">
									<h2 class="mb-1"><?= $leave_balance; ?></h2>
									<p>Leave Balance </p>
									<span class="mdi mdi-calendar-multiselect"></span>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card card-default">
								<div class="card-body">
									<div class="row ec-vendor-uploads">
										<div class="col-lg-12">
											<div class="ec-vendor-upload-detail">
												<form id="apply_leave" method="post" class="row">
													<div class="col-md-3">
														<label class="form-label">Select Type</label>
														<select name="type" id="type" class="form-select" required>
															<option value="">-- Select Type --</option>
															<option value="Sick Leave" <?php if($fetchrow['type'] == 'Sick Leave'){ echo "selected"; }?>>Sick Leave</option>
															<option value="Casual Leave" <?php if($fetchrow['type'] == 'Casual Leave'){ echo "selected"; }?>>Casual Leave</option>
														</select>
													</div>
													<div class="col-md-3">
														<label class="form-label">Select Range</label>
														<select name="range" id="range" class="form-select" onchange="gets(this.value)" required>
															<option value="">-- Select Range --</option>
															<option value="1" <?php if($fetchrow['count'] == '1'){ echo "selected"; }?>>Full Day</option>
															<option value="2" <?php if($fetchrow['count'] == '2'){ echo "selected"; }?>>Half Day</option>
															<option value="4" <?php if($fetchrow['count'] == '4'){ echo "selected"; }?>>More than a Day</option>
														</select>
													</div>
													<div style="display: block" class="col-md-3">
														<div class="hide">
															<label id="date"></label>
															<input type="date" class="form-control" name="fDate" id="fDate" min="<?php echo $today;?>" value="<?= $fetchrow['from_date']; ?>" required>
														</div>
													</div>
													<div class="col-md-3">
														<div id="toDate"></div>
														<div id="absentStatus"></div>
													</div>
													<div class="col-md-12">
														<label class="form-label">Reason</label>
														<textarea name="reason" id="reason" class="form-control" rows="1" required><?= $fetchrow['reason']; ?></textarea>
													</div>
													<div class="col-md-12 d-flex justify-content-center">
														<button type="submit" name="request" id="request" class="btn btn-primary">Request</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xl-12 col-md-12 p-b-15">
							<div id="user-acquisition" class="card card-default">
								<div class="card-body">
									<div class="row">
										<div class="col">
											<div class="table-responsive">
												<table id="responsive-data-table" class="table">
													<thead>
														<tr>
														<th>S.No</th>
														<th>Type</th>
														<th>Range</th>
														<th>Leave Date</th>
														<th>Applied Date</th>
														<th>Status</th>
														<th>Action</th>
														</tr>
													</thead>
													<tbody>
														<?php
														$sql = "SELECT * FROM employee_leave WHERE emp_id = '$emp_id' AND count != '3'";
														$result = $conn->query($sql);
														$s = 1;
														while($row = mysqli_fetch_array($result)){
															?>
															<tr>
																<td><?= $s++; ?></td>
																<td><?= $row['type'] ?></td>
																<td>
																	<?php
																		if($row['count'] == 1){
																			echo "Full Day";
																		}elseif($row['count'] == 2){
																			echo "Half Day";
																		}elseif($row['count'] == 3){
																			echo "Permission";
																		}elseif($row['count'] == 4){
																			echo "More than 1 Day";
																		}
																	?>
																</td>
																<td>
																	<?php
																		if($row['count'] == 4){
																			echo date("d-m-Y", strtotime($row['from_date'])). " / " .date("d-m-Y", strtotime($row['to_date']));
																		}else{
																			echo date("d-m-Y", strtotime($row['from_date']));
																		}
																	?>
																</td>
																<td><?php echo date("d-m-Y", strtotime($row['applied_date']));?></td>
																<td>
																	<?php
																		$statuses = [
																			1 => ['label' => 'Accepted', 'class' => 'bg-success'],
																			2 => ['label' => 'Rejected', 'class' => 'bg-danger', 'link' => true],
																			0 => ['label' => 'Pending', 'class' => 'bg-primary']
																		];
																		$status = $row['tl_status'] ?? 0;
																		$badge = $statuses[$status];
																		echo '<h6><span class="badge ' . $badge['class'] . '">';
																		if (!empty($badge['link'])) {
																			echo '<a href="#" style="color:#ffffff" data-bs-toggle="modal" data-bs-target="#modal-add-member" onclick="rejectReason(' . $s . ')">';
																		}
																		echo $badge['label'];
																		if (!empty($badge['link'])) {
																			echo '</a>';
																		}
																		echo '</span></h6>';
																	?>
																</td>
																<input type="hidden" id="rejectPopup<?=$s;?>" name="rejectPopup" value="<?php echo $row['tl_reason'];?>">
																<td>
																	<?php
																	if($row['tl_status'] == 0){
																		?>
																		<a href="leave-apply.php?leaveid=<?= $row['id'];?>"><span class="mdi mdi-pencil"></span></a>
																		<?php
																	}else{
																		echo "---";
																	}
																	?>
																</td>
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

					<div class="modal fade" id="modal-add-member" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
							<div class="modal-content">
								<form name="reason_modal" id="reason_modal" method="post">
									<div class="modal-header px-4">
										<h5 class="modal-title" id="exampleModalCenterTitle">Reason</h5>
									</div>
									<div class="modal-body px-4">
										<div class="form-group row mb-6">
											<textarea name="rejectReason" id="rejectReason" class="form-control" rows="2" readonly></textarea>
										</div>
									</div>
									<div class="modal-footer px-4">
										<button type="button" class="btn btn-secondary btn-pill" data-bs-dismiss="modal">OK</button>
									</div>
								</form>
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

	<!-- Data-Tables -->
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

<script>
	function gets(val){
		if(val == 1){
			document.getElementsByClassName('hide')[0].style.display = 'block';
			document.getElementById('date').innerHTML = 'Date';
			$('#fnan_status').remove();
			$('#time-div').remove();
			$('#toDate-div').remove();
		}
		else if(val == 2){
			document.getElementsByClassName('hide')[0].style.display = 'block';
			document.getElementById('date').innerHTML = 'Date';
			$('#absentStatus').append(
				'<div id="fnan_status"><label>Session</label><select id="fn_an_status" id="fn_an_status" class="form-control"><option value="">Select Session</option><option value="1">FN</option><option value="2">AN</option></select></div>');
			$('#time-div').remove();
			$('#toDate-div').remove();
		}	
		else{
			document.getElementsByClassName('hide')[0].style.display = 'block';
			document.getElementById('date').innerHTML = 'From';
			$('#toDate').append('<div id="toDate-div"><label>To</label><input type="date" class="form-control" name="tDate" id="tDate" min="<?php echo $today;?>" required></div>');
			$('#time-div').remove();
			$('#fnan_status').remove();
		}
	}
</script>
<script>
	function rejectReason(val){
		var reason = $('#rejectPopup'+val).val();
		$('#rejectReason').val(reason);
	}
</script>
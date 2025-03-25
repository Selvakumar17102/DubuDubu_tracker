<?php
session_start();
ini_set('display_errors','off');
include("include/connection.php");
$attendance = 'active';
$atten_boolean = 'true';
$attendance_show = 'show';
$permission_apply = 'active';

date_default_timezone_set('Asia/Kolkata'); 

$today = date('Y-m-d');

$permissionId = $_GET['permissionid'];
$sql = "SELECT * FROM employee_leave WHERE id = '$permissionId'";
$result = $conn->query($sql);
$fetchrow = $result->fetch_assoc();

$emp_id = $_SESSION['id'];
	
if(isset($_POST["request"])){
	$fTime = $_POST['fTime'];
	$tTime = $_POST['tTime'];
	$fDate = $_POST['fDate'];
	$reason = $_POST['reason'];

	if($permissionId){
		$permissionSql = "UPDATE employee_leave SET from_time = '$fTime', to_time = '$tTime', from_date = '$fDate', reason = '$reason' WHERE id = '$permissionId'";
		if($conn->query($permissionSql) === TRUE){
			header("location: permission-apply.php?msg=Permission Requested Updated!&type=warning");
		}
	}else{
		$leave_sql = "INSERT INTO employee_leave(emp_id,from_time,to_time,reason,applied_date,tl_status,count,from_date) VALUES ('$emp_id', '$fTime', '$tTime', '$reason', '$today',0,3,'$fDate')";
		$leave_result = $conn->query($leave_sql);
		if($leave_result){
			header("location: permission-apply.php?msg=Permission Requested!&type=success");
		}
	}
	
}


	$year = date("Y");
	$month = date("m");

	$query = "SELECT SUM(TIMESTAMPDIFF(MINUTE, from_time, to_time)) AS total_permission FROM employee_leave 
			WHERE emp_id = '$emp_id' AND tl_status = '1' AND count = '3' AND YEAR(from_date) = '$year' AND MONTH(from_date) = '$month'";

	$result = $conn->query($query);
	$row = $result->fetch_assoc();
	$applied_permission = $row['total_permission'] ?? 0;

	$applied_permission_hours = round($applied_permission / 60, 2);
	
	$total_permission = 2;
	
	$remaining_permission = max($total_permission - $applied_permission_hours, 0);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="ekka - Admin Dashboard HTML Template.">

	<title>DUBU DUBU - Permission Apply</title>

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
							<h1>Apply Permission</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Permission</p>
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
									<h2 class="mb-1"><?= $total_permission; ?> hrs</h2>
									<p>Total Permission </p>
									<span class="mdi mdi-calendar-clock"></span>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
							<div class="card card-mini dash-card card-2">
								<div class="card-body new-class">
									<h2 class="mb-1"><?= $applied_permission_hours; ?> hrs</h2>
									<p>Applied Permission</p>
									<span class="mdi mdi-calendar"></span>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
							<div class="card card-mini dash-card card-2">
								<div class="card-body new-class">
									<h2 class="mb-1"><?= $remaining_permission; ?> hrs</h2>
									<p>Remaining Permission</p>
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
                                                        <label for="fromtime" class="form-label">Date</label>
                                                        <input type="date" class="form-control" name="fDate" id="fDate" value="<?= $fetchrow['from_date'];?>" required>
													</div>
													<div class="col-md-3">
														<label for="fromtime" class="form-label">From Time</label>
														<input type="time" class="form-control" name="fTime" id="fTime" value="<?= $fetchrow['from_time'];?>" required>
													</div>
													<div class="col-md-3">
														<label for="totime" class="form-label">To Time</label>
														<input type="time" class="form-control" name="tTime" id="tTime" value="<?= $fetchrow['to_time'];?>" required>
													</div>
													<div class="col-md-12">
														<label class="form-label">Reason</label>
														<textarea name="reason" id="reason1" class="form-control" rows="1" required><?= $fetchrow['reason'];?></textarea>
													</div>
													<div class="col-md-12 d-flex justify-content-center">
														<button type="submit" name="request" id="request" onclick="return permission()" class="btn btn-primary">Request</button>
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
														<th>Date</th>
														<th>From Time</th>
														<th>To Time</th>
														<th>Applied Date</th>
														<th>Status</th>
														<th>Action</th>
														</tr>
													</thead>
													<tbody>
														<?php
														$sql = "SELECT * FROM employee_leave WHERE emp_id = '$emp_id' AND count = '3'";
														$result = $conn->query($sql);
														$s = 1;
														while($row = mysqli_fetch_array($result)){
															?>
															<tr>
																<td><?= $s++; ?></td>
																<td><?= date("d-m-Y", strtotime($row['from_date'])) ?></td>
																<td><?= date("H:i A", strtotime($row['from_time'])) ?></td>
																<td><?= date("H:i A", strtotime($row['to_time'])) ?></td>
																<td><?= date("d-m-Y", strtotime($row['applied_date']));?></td>
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
																		<a href="permission-apply.php?permissionid=<?= $row['id'];?>"><span class="mdi mdi-pencil"></span></a>
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

	<!-- Option Switcher -->
	<script src="assets/plugins/options-sidebar/optionswitcher.js"></script>

	<!-- Data-Tables -->
	<script src='assets/plugins/data-tables/jquery.datatables.min.js'></script>
	<script src='assets/plugins/data-tables/datatables.bootstrap5.min.js'></script>
	<script src='assets/plugins/data-tables/datatables.responsive.min.js'></script>

	<!-- ekka Custom -->
	<script src="assets/js/ekka.js"></script>
	<script src="assets/js/manual.js"></script>

	<script>
		function rejectReason(val){
			var reason = $('#rejectPopup'+val).val();
			$('#rejectReason').val(reason);
		}
	</script>
</body>

</html>
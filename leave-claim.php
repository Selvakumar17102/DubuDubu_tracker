<?php

session_start();
ini_set('display_errors', 'off');
include("include/connection.php");
$leaveClaim = 'active';
$leaveClaim_boolean = 'true';

$today = date('Y-m-d');
$year = date('Y');
$currentMonth = date('m');

if($currentMonth == 12){
	$validMonth = $currentMonth;
	$claimMonYear = date('Y-m', strtotime($year."-".$currentMonth));
}
else{
	$validMonth = 6;
	$claimMonYear = date('Y-m', strtotime($year."-06"));
}
$year_start_date = date('Y-01-01');
$year_end_date = date('Y-12-31');

if(isset($_POST['search'])){
	$emp_id = $_POST['emp_id'];
	// echo $emp_id;
    $optionDisplay = "style='display:none'";
	// echo $validMonth;
	// exit();

    $eSql = "SELECT * FROM employee WHERE id = '$emp_id'";
    $eResult = $conn->query($eSql);
    $eRow = mysqli_fetch_array($eResult);
	$third_month = date('Y-m-d', strtotime($eRow['doj'].'+3 months'));
	$third_month_date = date('d', strtotime($third_month));
	// echo $third_month_date;
	
    $a = $b= $total_absent = 0;
    for($i=1; $i <= $validMonth; $i++){
		$startDate = date('Y-m-d', strtotime($year."-".$i."-01"));
        $endDate = date('Y-m-t', strtotime($startDate));
		$available_from = date('Y-m-d', strtotime($year."-".$i."-08"));
		
		if($third_month <= $endDate){
			// if the employee joins from 1 to 7th then only the leave is eligible for claim
			// for particular month
			if($third_month <= $available_from){
				// $msg1 = "this";
				$attend_sql = "SELECT * FROM attendance WHERE emp_id = '$emp_id' AND status = 1 AND (date BETWEEN '$startDate' AND '$endDate')";
        		$attend_result = $conn->query($attend_sql);
				if($attend_result->num_rows > 0){
					while($attend_row = mysqli_fetch_array($attend_result)){
						if($attend_row['count'] == "1"){
							$total_absent = $b+1;
						}
						elseif($attend_row['count'] == "2"){
							$total_absent = $b+0.5;
						}
						$b = $total_absent;
					}
					if($total_absent == 0.5){
						$balance = $a+0.5;
					}
					else{
						$balance = $a;
					}
					$b = 0;
					// echo $total_absent;
				}
				else{
					$balance = $a+1;
				}
			}
			else{
				// $msg1 = "that";
				$balance = $a;
			}
		}
		else{
			$balance = $a;
		}
        $a = $balance;
    }
	$claim_sql3 = "SELECT SUM(claim_days) AS claim_days FROM leave_claim WHERE emp_id = '$emp_id' AND claim_year = '$year'";
	$claim_result3 = $conn->query($claim_sql3);
	$claim_row3 = mysqli_fetch_array($claim_result3);
	if($claim_row3['claim_days'] > 0){
		$leave_balance = $balance - $claim_row3['claim_days'];
	}
	else{
		$leave_balance = $balance;
	}
	if($leave_balance == 0 || $leave_balance < 0){
		$msg = "Not Eligible for Leave Claim";
		$divDisplay = "style='display:none'";
	}
	else{
		$msg = "";
		$divDisplay = "style='display:block'";
	}
	// echo $msg;
}
// exit();
else{
    $emp_id = "";
    $divDisplay = "style='display:none'";
}

if(isset($_POST['leave_claim'])){
	$employee_id = $_POST['emp_ids'];
	// echo $employee_id; exit();
	$avilable_leave = $_POST['available_days'];
	$claim_my = $_POST['claim_my'];
	$claim_days = $_POST['claim_days_value'];

	$claim_sql = "SELECT * FROM leave_claim WHERE emp_id = '$employee_id' AND claim_month_year = '$claim_my'";
	$claim_result = $conn->query($claim_sql);
	if($claim_result->num_rows > 0){
		$claim_sql1 = "UPDATE leave_claim SET claim_days = '$claim_days', available_days = '$avilable_leave', updated_date = '$today' WHERE emp_id = '$employee_id' AND claim_month_year = '$claim_my'";
		if($conn->query($claim_sql1)){
			header('location: leave-claim.php?msg=Leave Claim Updated Successfully !&type=warning');
		}
	}
	else{
		$claim_sql1 = "INSERT INTO leave_claim (emp_id,claim_month_year,claim_year,available_days,claim_days,claimed_date,created_date,updated_date) VALUES ('$employee_id','$claim_my','$year','$avilable_leave','$claim_days','$today','$today','$today')";
		if($conn->query($claim_sql1)){
			header('location: leave-claim.php?msg=Leave Claimed Successfully !&type=success');
		}
	}
}

if(isset($_POST['delete_leave_claim'])){
	$leave_claim_id = $_POST['leave_claim_id'];

	$delete_sql = "DELETE FROM leave_claim WHERE leave_claim_id = '$leave_claim_id'";
	if($conn->query($delete_sql)){
		header('location: leave-claim.php?msg=Leave Claim Deleted !&type=failed');
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

	<title>DUBU DUBU - Leave Claim</title>

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
					<div class="breadcrumb-wrapper breadcrumb-contacts">
						<div>
							<h1>Leave Claim</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Leave Claim</p>
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
									<h2>Leave Claim</h2>
								</div>
								<div class="card-body">
									<div class="row ec-vendor-uploads">
										<div class="col-lg-12">
											<div class="ec-vendor-upload-detail">
												<form method="post" class="row g-3">
													<label class="form-label">Employee</label>
													<div class="col-md-6">
                                                        <select class="form-control" name="emp_id" id="emp_id">
                                                            <option value="" <?= $optionDisplay; ?>>Select Employee</option>
                                                            <?php
                                                                $sql = "SELECT * FROM employee WHERE del_status = 0 AND control != 5 AND doj <= '$year_end_date' AND
                                                                id NOT IN (SELECT id FROM employee WHERE emp_status != 'Active' AND resign_date <= '$year_start_date')
                                                                ORDER BY fname ASC";
                                                                $result = $conn->query($sql);
                                                                if($result->num_rows > 0){
                                                                    while($row = mysqli_fetch_array($result)){
                                                            ?>
                                                                        <option value="<?= $row['id']; ?>" <?php if($row['id'] == $emp_id) { echo "selected"; }?>><?= $row['fname']." ".$row['lname']; ?></option>
                                                            <?php
                                                                    }
                                                                }
                                                                else{
                                                            ?>
                                                                    <option value="" disabled>No Employees Found</option>
                                                            <?php
                                                                }
                                                            ?>
                                                        </select>
														<?php
															if($msg != ""){
														?>
															<span style="color: red"><?= $msg; ?></span>
														<?php
															}
														?>
													</div>
													<div class="col-md-6">
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

                    <div class="row m-b30" <?= $divDisplay; ?>>
						<div class="col-12">
							<div class="card card-default">
								<div class="card-header card-header-border-bottom">
									<h2>Leave Claim Details</h2>
								</div>
								<div class="card-body">
									<div class="row ec-vendor-uploads">
										<div class="col-lg-12">
											<div class="ec-vendor-upload-detail">
												<form method="post" class="row g-3" enctype="multipart/form-data">
													<input type="hidden" name="emp_ids" value="<?= $emp_id; ?>">
													<div class="col-md-6">
														<label class="form-label">Employee Id</label>
														<input type="text" class="form-control" name="employee_id" id="employee_id" value="<?= $eRow['emp_id']; ?>" readonly>
													</div>
													<div class="col-md-6">
														<label class="form-label">Employee Name</label>
														<input type="text" class="form-control" name="name" id="name" value="<?= $eRow['fname']." ".$eRow['lname']; ?>" readonly>
													</div>
													<div class="col-md-6">
														<label class="form-label">Designation</label>
														<input type="text" class="form-control" name="designation" id="designation" value="<?= $eRow['designation']?>" readonly>
														<span id="errorMessage" style="color: red"></span>
													</div>
													<div class="col-md-6">
														<label class="form-label">Claim Month And Year</label>
														<input type="month" class="form-control" name="claim_my" id="claim_my" value="<?= $claimMonYear; ?>" readonly>
													</div>
													<div class="col-md-6">
														<label class="form-label">Available Days</label>
														<input type="text" class="form-control" name="available_days" id="available_days" value="<?= $leave_balance; ?>" readonly>
													</div>
													<div class="col-md-6">
														<label class="form-label">Claim Days</label>
														<input type="text" class="form-control" name="claim_days_value" id="claim_days_value" min="1" onkeyup="claimDays(this.value)" >
														<input type="hidden" name="checkClaimDays" id="checkClaimDays">
														<span id="errorClaimDays" style="color: red"></span>
													</div>
													<div class="col-md-6 pt-4">
														<button type="submit" name="leave_claim" id="leave_claim" onclick="return leaveClaim()" class="btn btn-primary">Submit</button>
													</div>
												</form>
												<!-- <form method="post" class="row g-3" enctype="multipart/form-data">
													<input type="hidden" name="emp_id" value="<?= $emp_id; ?>">
													<div class="col-md-6">
														<label class="form-label">Employee Id: 
															<span><?= $eRow['emp_id']; ?></span>
														</label>
													</div>
													<div class="col-md-6">
														<label class="form-label">Employee Name: 
															<span><?= $eRow['fname']." ".$eRow['lname']; ?></span>
														</label>
													</div>
													<div class="col-md-6">
														<label class="form-label">Designation: 
															<span><?= $eRow['designation']?></span>
														</label>
													</div>
													<div class="col-md-6">
														<label class="form-label">Claim Month And Year: 
															<span><?= $claimMonYear; ?></span>
														</label>
													</div>
													<div class="col-md-6">
														<label class="form-label">Available Days: 
															<span><?= $leave_balance; ?></span>
														</label>
													</div>
													<div class="col-md-6"></div>
													<div class="col-md-6">
														<label class="form-label">Claim Days</label>
														<input type="number" class="form-control" name="claim_days" id="claim_days" min="1" required>
													</div>
													<div class="col-md-6 pt-4">
														<button type="submit" name="client_submit" id="client_submit" class="btn btn-primary">Submit</button>
													</div>
												</form> -->
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row m-b30">
						<div class="col-xl col-md-12 p-b-15">
							<div id="user-acquisition" class="card card-default">
								<div class="card-header">
									<h2 style="text-align: center">Leave Claim Details - <?= $year; ?></h2>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col">
											<div class="table-responsive">
												<table id="responsive-data-table" class="table" style="width:100%">
													<thead>
														<tr>
															<th>S.No</th>
															<th>Employee ID</th>
															<th>Employee Name</th>
															<th>Designation</th>
															<th>Month And Year</th>
															<th>Available Days</th>
															<th>Claimed Days</th>
															<th>Claimed Date</th>
															<th style="text-align: center">Action</th>
														</tr>
													</thead>
													<tbody>
														<?php
															$claim_sql2 = "SELECT *,b.emp_id AS employee_id, a.emp_id AS empID FROM leave_claim a
															LEFT OUTER JOIN employee b ON b.id = a.emp_id
															WHERE a.claim_year = '$year'";
															$claim_result2 = $conn->query($claim_sql2);
															$a = 1;
															$b = 0;
															while($claim_row2 = mysqli_fetch_array($claim_result2)){
																$b++;
																$month_value = date('n', strtotime($claim_row2['claim_month_year']));
																$month_name = date('F', mktime(0,0,0,$month_value,10));
																$year_value = date('Y', strtotime($claim_row2['claim_month_year']));
																$after_month = date('Y-m-d', strtotime($claim_row2['claimed_date'].'+1 months'));
																// echo $nnnnnn;
																if($today > $after_month){
																	$delete_button = "disabled";
																}
																else{
																	$delete_button = "";
																}
														?>
															<tr>
																<td><?= $a++; ?></td>
																<td><?= $claim_row2['employee_id']; ?></td>
																<td><?= $claim_row2['fname'];?> <?php echo $claim_row2['lname'];?></td>
																<td><?= $claim_row2['designation'];?></td>
																<td><?= $month_name." ".$year_value;?></td>
																<td><?= $claim_row2['available_days'];?></td>
																<td><?= $claim_row2['claim_days'];?></td>
																<td><?= date('d-m-Y', strtotime($claim_row2['claimed_date']));?></td>
																<td style="text-align: center">
																	<button type="button" data-bs-toggle="modal" data-bs-target="#delete<?php echo $b; ?>" <?= $delete_button; ?>><span class="mdi mdi-delete-empty"></span></button>
																	<div class="modal fade" id="delete<?php echo $b;?>" tabindex="-1" role="dialog"	aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
																		<div class="modal-dialog modal-dialog-centered modal" role="document">
																			<div class="modal-content">
                                                                	            <form method="post">
                                                                	                <div class="modal-header">
                                                                	                    <h5 class="modal-title" id="addAdminTitle">Delete Leave Claim</h5>
                                                                	                    <!-- <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                	                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                                	                    </button> -->
                                                                	                </div>
                                                                	                <div class="modal-body">
                                                                	                    <p class="modal-text">Are you sure to delete <b><?php echo $claim_row2['fname'];?> <?php echo $claim_row2['lname'];?> Leave Claim on <?= $month_name." ".$year_value;?></b> !</p>
                                                                	                    <input type="hidden" name="leave_claim_id" value="<?php echo $claim_row2['leave_claim_id']; ?>">
                                                                	                </div>
                                                                	                <div class="modal-footer">
                                                                	                    <button class="btn btn-secondary" data-dismiss="modal"> No</button>
                                                                	                    <button type="submit" name="delete_leave_claim" class="btn btn-danger">Delete</button>
                                                                	                </div>
                                                                	            </form>
                                                                	        </div>
																		</div>
																	</div>
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
	$(function (){
  	  $('input[name="claim_days_value"]').on('input', function (e){
  	    $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
  	  });
  	});

	function claimDays(a){
		// alert(a);
		document.getElementById('checkClaimDays').value = a;
	}

	function leaveClaim(){
		var b = parseFloat($('#checkClaimDays').val());
		var c = parseFloat($('#available_days').val());
		var days = document.getElementById('claim_days_value');
		// alert(days)
		
		if(b > c){
			// days.style.border='1px solid red';
			days.style.border = '1px solid red';
			document.getElementById('errorClaimDays').innerHTML = "Claim Days should be less than avaiable days !";
			return false;
		}
		else{
			days.style.border = '1px solid #bfc9d4';
		}
	}
</script>
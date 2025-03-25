<?php

session_start();
ini_set('display_errors', 'off');
include("include/connection.php");
$attendance = 'active';
$atten_boolean = 'true';
$attendance_show = 'show';
$temp_attendance = 'active';

$today = date('Y-m-d');

if(isset($_POST['addAttendance'])){
    $date = $_POST['date'];
    $id = $_POST['userid'];
	$status = $_POST['attStatus'];
	$location = $_POST['presentStatus'];
	$informStatus = $_POST['informValue'];
	$type = $_POST['reason'];
	$range = $_POST['range'];
	$absent_status = $_POST['fn_an_status'];

    if($status == 0){
        $type = $informStatus = 0;
        $range = 1;
        $absent_status = 3;
    }
    else{
        $location = 0;
    }

    $attend_sql = "SELECT * FROM temp_attendance WHERE date = '$date' AND emp_id = '$id'";
    $attend_result = $conn->query($attend_sql);
    if($attend_result->num_rows > 0){
        $attend_sql1 = "UPDATE temp_attendance SET status='$status', type='$type', count='$range', inform_status='$informStatus', location='$location', fn_an_status='$absent_status', created_date = '$today', del_status = '0' WHERE emp_id='$id' AND date='$date'";
		if($conn->query($attend_sql1) == TRUE){
			header('location: temp_attendance.php?msg=Attendance Updated !&type=warning');
		}
    }
    else{
        $attend_sql2 = "INSERT INTO temp_attendance (date,emp_id,status,type,count,inform_status,location,fn_an_status,created_date,del_status) VALUES ('$date', '$id', '$status', '$type', '$range', '$informStatus', '$location', '$absent_status', '$today', 0)";
			if($conn->query($attend_sql2) == TRUE){
				header('location: temp_attendance.php?msg=Attendance Added !&type=success');
			}
    }
}

if(isset($_POST['deleteAttendance'])){
	$deleteId = $_POST['reject_temp_id'];

	$temp_sql = "UPDATE temp_attendance SET del_status = 1 WHERE id = '$deleteId'";
	if($conn->query($temp_sql)){
		header('location: temp_attendance.php?msg=Attendance Deleted !&type=failed');
	}
}

if(isset($_POST['acceptAttendance'])){
	$accept_temp_id = $_POST['accept_temp_id'];
	$attend_date = $_POST['attend_date'];
	$employee_id = $_POST['employee_id'];
	
	$attend_sql3 = "SELECT * FROM attendance WHERE date = '$attend_date' AND emp_id = '$employee_id'";
	$attend_result3 = $conn->query($attend_sql3);
	if($attend_result3->num_rows > 0){
		header('location: temp_attendance.php?msg=Attendance is already exists kindly check !&type=failed');
	}
	else{
		
		$temp_sql2 = "UPDATE temp_attendance SET del_status = 2 WHERE id = '$accept_temp_id'";
		$temp_result2 = $conn->query($temp_sql2);
		
		$temp_sql1 = "SELECT * FROM temp_attendance WHERE id = '$accept_temp_id'";
		$temp_result1 = $conn->query($temp_sql1);
		$temp_row1 = mysqli_fetch_array($temp_result1);
		
		$attend_sql4 = "INSERT INTO attendance (date,emp_id,status,type,count,inform_status,location,fn_an_status) VALUES (
			'".$temp_row1["date"]."',
			'".$temp_row1["emp_id"]."',
			'".$temp_row1["status"]."',
			'".$temp_row1["type"]."',
			'".$temp_row1["count"]."',
			'".$temp_row1["inform_status"]."',
			'".$temp_row1["location"]."',
			'".$temp_row1["fn_an_status"]."'
			)";
			// echo $attend_sql4; exit();
		if($conn->query($attend_sql4)){
			header('location: temp_attendance.php?msg=Attendance Added !&type=success');
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

	<title>DUBU DUBU - Temporary Attendance</title>

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
							<h1>Temporary Attendance</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Temporary Attendance</p>
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
									<h2>Temporary Attendance Report</h2>
								</div>
								<div class="card-body">
                                    <div class="row ec-vendor-uploads">
										<div class="ec-vendor-upload-detail">
                                            <form id="tempAttendance" method="post" class="row g-3">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Date</label>
                                                        <input type="date" class="form-control" name="date" id="date" value="" max="<?= $today; ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label class="form-label">Employee Name</label>
                                                    </div>
                                                    <div class="col">
                                                        <label class="form-label">Team</label>
                                                    </div>
                                                    <div class="col">
                                                        <label class="form-label">Status</label>
                                                    </div>
                                                    <div class="col">
                                                        <label class="form-label">Description</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                    							        <select class="form-control" name="userid" id="userid">
                    							            <option value="">Select Date First</option>
                    							        </select>
                                                    </div>
                                                    <div class="col">
                                                        <input type="text" class="form-control" name="team" id="team" value="" readonly>
                                                    </div>
                                                    <div class="col">
														<select name="attStatus" id="attStatus" class="form-select" onchange="persentValue()">
															<option value="0">Present</option>
															<option value="1">Absent</option>
														</select>
													</div>
                                                    <div class="col presentOption" style="display: block">
														<select name="presentStatus" id="presentStatus" class="form-select">
															<option value="1">Office</option>
															<option value="2">Client Meet</option>
															<option value="3">Work from Home</option>
														</select>
													</div>
                                                    <div class="col absentOption" style="display: none">
														<div class="row">
															<div class="col">
																<select name="informValue" id="informValue" class="form-select" onchange="informStatus()">
																		<option value="1">Informed</option>
																		<option value="2">Uninformed</option>
																</select>
															</div>
															<div class="col reason">
																<select name="reason" class="form-select">
																	<option value="1">Casual Leave</option>
																	<option value="2">Sick Leave</option>
																	<option value="3">Loss Of Pay</option>
																</select>
															</div>
															<div class="col">
																<select name="range" id="range" class="form-select" onclick="fnanStatus()">
																	<option value="1">Full Day</option>
																	<option value="2">Half A Day</option>
																</select>
															</div>
															<div class="col absent_status" style="display: none">
																<select name="fn_an_status" id="fn_an_status" class="form-select">
																	<option value="1">FN</option>
																	<option value="2">AN</option>
																</select>
															</div>
														</div>
													</div>
                                                </div>
                                                <div class="row">
                                                    <div>
                                                        <button type="submit" class="btn btn-success" name="addAttendance" id="addAttendance" onclick="return attendanceAdd()">Add</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xl col-md-12 p-b-15">
							<div id="user-acquisition" class="card card-default">
								<div class="card-header">
									<h2 style="text-align: center">Temporary Attendance Details</h2>
								</div>
								<div class="card-body" id="refresh_table">
									<div class="row">
										<div class="col">
											<div class="table-responsive">
												<table id="responsive-data-table" class="table" style="width:100%">
													<thead>
														<tr>
															<th>S.No</th>
															<th>Employee Name</th>
															<th>Designation</th>
															<th>Date</th>
															<th>Status</th>
															<th>Description</th>
															<th style="text-align: center">Action</th>
														</tr>
													</thead>
													<tbody>
														<?php
														$sql = "SELECT *,a.date AS temp_date, a.id AS attend_id, b.id AS empId, a.del_status AS attend_del_status FROM temp_attendance a
														LEFT OUTER JOIN employee b ON b.id = a.emp_id WHERE a.del_status = 0 OR a.del_status = 2 ORDER BY temp_date DESC";
														$result = $conn->query($sql);
														$a = 0;
														while($row = mysqli_fetch_array($result)){
															$attend_id = $row['attend_id'];
															$a++;
														?>
															<tr>
																<td><?php echo $a; ?></td>
																<td><?php echo $row['fname']." ".$row['lname'];?></td>
																<td><?php echo $row['team'];?></td>
																<td><?php echo date('d-m-Y', strtotime($row['temp_date'])); ?></td>
																<td>
																	<?php
																		if($row['status'] == 0){
																			echo "Present";
																		}
																		else{
																			echo "Absent";
																		}
																	?>
																</td>
																<td>																	  
																	<?php
																		if($row['count'] == 1){
																			echo "Full Day";
																		}
																		else{
																			if($row['fn_an_status'] == 1){
																				echo "Half Day (FN)";
																			}
																			elseif($row['fn_an_status'] == 2){
																				echo "Half Day (AN)";
																			}
																		}
																	?>
																</td>
																<td style="text-align: center">
																	<?php
																		if($row['attend_del_status'] == 0){
																	?>
																	<button type="button" data-bs-toggle="modal" data-bs-target="#acceptAttend<?= $a; ?>"><span class="mdi mdi-checkbox-marked-circle"></span></button>
																	<button type="button" data-bs-toggle="modal" data-bs-target="#rejectAttendance<?= $a; ?>"><span class="mdi mdi-close-circle"></span></button>
																	<div class="modal fade" id="rejectAttendance<?= $a; ?>" tabindex="-1" role="dialog"	aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
																		<div class="modal-dialog modal-dialog-centered modal" role="document">
																			<div class="modal-content">
                                									            <form method="post">
                                									                <div class="modal-header">
                                									                    <h5 class="modal-title" id="addAdminTitle">Delete Temporary Attendance</h5>
                                									                    <!-- <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                									                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                									                    </button> -->
                                									                </div>
                                									                <div class="modal-body">
                                									                    <p class="modal-text">Are you sure to delete <b><?php echo $row['fname']." ".$row['lname'];?> </b>attendance on <b><?php echo date('d-m-Y', strtotime($row['temp_date']));?></b> !</p>
                                									                    <input type="hidden" name="reject_temp_id" value="<?php echo $row['attend_id']; ?>">
                                									                </div>
                                									                <div class="modal-footer">
                                									                    <button class="btn btn-secondary" data-dismiss="modal"> No</button>
                                									                    <button type="submit" name="deleteAttendance" class="btn btn-danger">Delete</button>
                                									                </div>
                                									            </form>
                                									        </div>
																		</div>
																	</div>
																	<div class="modal fade" id="acceptAttend<?= $a; ?>" tabindex="-1" role="dialog"	aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
																		<div class="modal-dialog modal-dialog-centered modal" role="document">
																			<div class="modal-content">
                                									            <form method="post">
                                									                <div class="modal-header">
                                									                    <h5 class="modal-title" id="addAdminTitle">Accept Temporary Attendance</h5>
                                									                    <!-- <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                									                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                									                    </button> -->
                                									                </div>
                                									                <div class="modal-body">
                                									                    <p class="modal-text">Are you sure to accept <b><?php echo $row['fname']." ".$row['lname'];?> </b>attendance on <b><?php echo date('d-m-Y', strtotime($row['temp_date']));?></b> !</p>
                                									                    <input type="hidden" name="accept_temp_id" value="<?php echo $row['attend_id']; ?>">
                                									                    <input type="hidden" name="employee_id" value="<?php echo $row['empId']; ?>">
                                									                    <input type="hidden" name="attend_date" value="<?php echo $row['temp_date']; ?>">
                                									                </div>
                                									                <div class="modal-footer">
                                									                    <button class="btn btn-secondary" data-dismiss="modal"> No</button>
                                									                    <button type="submit" name="acceptAttendance" class="btn btn-success">Accept</button>
                                									                </div>
                                									            </form>
                                									        </div>
																		</div>
																	</div>
																	<?php
																		}
																		else{
																	?>
																			<h6><span class="badge bg-success">Accepted</span></h6>
																	<?php
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
	function persentValue(){
		// alert(val);
		var att = $('#attStatus').val();
		// alert(att);
		if(att == 1){
		    $('.presentOption').hide();
		    $('.absentOption').show();
		}else{
			$('.presentOption').show();
			$('.absentOption').hide();
		}
	};
	// Inform and Uninformed control
	function informStatus(){
		var day = $('#informValue').val();
		// alert(day);
		if(day == 2){
			$('.reason').hide();
		}else{
			$('.reason').show();
		}
	};
	function fnanStatus(){
		// alert("kjhj");
		var fnanStatus = $('#range').val();
		// alert(fnanStatus);
		if(fnanStatus == 1){
			$('.absent_status').hide();
		}
		else{
			$('.absent_status').show();
		}
	}

    $('#date').on('change', function(){
        var dateValue = $('#date').val();
        $.ajax({
            url : 'ajax/tempAttendance_check.php',
            type : 'POST',
            data : {
                dateValue : dateValue,
            },
            success : function(data){
                var values = jQuery.parseJSON(data);
                nameArray = [];
                nameArray.push('<option value="">-- Select Employee -- </option>')
                $.each(values, function(i, k){
                    nameArray.push(k.employee_name);
                })
                $('#userid').html(nameArray);
            }
        });
    });

    $('#userid').on('change', function(){
        var nameValue = $('#userid').val();
        $.ajax({
            url : 'ajax/tempAttendance_empName.php',
            type : 'POST',
            data : {
                nameValue : nameValue,
            },
            success : function(data){
                $('#team').val(data);
            }
        });
    });
</script>
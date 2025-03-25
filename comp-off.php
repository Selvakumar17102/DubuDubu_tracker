<?php

session_start();
ini_set('display_errors', 'off');
include("include/connection.php");
$comp = 'active';
$comp_boolean = 'true';

$year_start_date = date('Y-01-01');
$year_end_date = date('Y-12-31');

$today = date('Y-m-d');
// $today1 = date('d/m/Y');
$minDate = date('Y-m-01');

$month = date('n', strtotime($today));
$month_name = date('F', mktime(0, 0, 0, $month, 10));

if(isset($_POST['submit'])){
    $id = $_POST['empId'];
    $date = $_POST['date'];
    $range = $_POST['range'];
    $fn_an_status = $_POST['fn_an_status'];
	

    $comp_sql = "SELECT * FROM attendance WHERE emp_id='$id' AND date='$date'";
    $comp_result = $conn->query($comp_sql);
    if($comp_result->num_rows > 0){
        if($range == 1){
            $fn_an_status = 3;
        }
        $comp_sql1 = "UPDATE attendance SET status=2, count='$range', fn_an_status='$fn_an_status' WHERE emp_id='$id' AND date='$date'";
        // echo $comp_sql1;
        if($conn->query($comp_sql1) == TRUE){
            header('location: comp-off.php?msg=Comp-Off Updated!&type=warning');
        }
    }
    else{
        if($range == 1){
            $fn_an_status = 3;
        }
        $comp_sql2 = "INSERT INTO attendance (status, emp_id, date, count, fn_an_status) VALUES (2, '$id', '$date', '$range', '$fn_an_status')";
        if($conn->query($comp_sql2) == TRUE){
            header('location: comp-off.php?msg=Comp-Off Added!&type=success');
        }
    }
}

if(isset($_POST['delete'])){
	$emp_id = $_POST['emp_id'];
	
	$comp_sql3 = "DELETE FROM attendance WHERE id='$emp_id' AND status=2";
	if($conn->query($comp_sql3)){
		header('location: comp-off.php?msg=Comp Off Deleted !&type=failed');
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

	<title>DUBU DUBU - Comp-Off</title>

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
							<h1>Comp-Off</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Comp-Off</p>
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
									<h2>Comp-off Report</h2>
								</div>
								<div class="card-body">
                                    <div class="table-responsive">
                                        <form id="compOff" method="post">
                                            <table class="table" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Employee Name</th>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
													<td class="col-4"><input type="date" name="date" id="date" class="form-control" max="<?php echo $today;?>" required></td>
                                                    <td class="col-4">
                                                        <div class="col">
															<select name="empId" id="empId" class="form-select" required>
																<option value="">-- Select Date First --</option>
                                                                <?php
                                                                	// $emp_table = "SELECT * FROM employee ORDER BY fname ASC";
                                                                	// // $emp_table = "SELECT * FROM employee WHERE del_status=0 AND emp_status = 'Active' ORDER BY fname ASC";
                                                                	// $emp_result = $conn->query($emp_table);
                                                                	// while($emp_row = mysqli_fetch_array($emp_result)){
                                                                ?>
																    	<!-- <option value="<?php echo $emp_row['id']; ?>"><?php echo $emp_row['fname'];?> <?php echo $emp_row['lname'];?></option> -->
                                                                <?php
                                                                	// }
                                                                ?>
															</select>
														</div>
                                                    </td>
                                                    <td class="col-4">
                                                        <div class="row">
                                                        	<div class="col">
																<select name="range" id="range" class="form-select" onclick="fnanStatus(this.value)">
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
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><button type="submit" class="btn btn-success" id="submit" name="submit">Submit</button></td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </form>
                                    </div>
								</div>
							</div>
						</div>
					</div>

					<div class="row m-b30">
						<div class="col-xl col-md-12 p-b-15">
							<div id="user-acquisition" class="card card-default">
								<div class="card-header">
									<h2 style="text-align: center">Comp Off Details - <?= $month_name; ?></h2>
								</div>
								<div class="card-body">
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
															<th>Description</th>
															<th style="text-align: center">Action</th>
														</tr>
													</thead>
													<tbody>
														<?php
															$emp_sql = "SELECT *,a.id as attend_id FROM attendance a LEFT OUTER JOIN employee b ON a.emp_id = b.id WHERE a.status = 2 AND a.date BETWEEN '$minDate' AND '$today' ORDER BY a.date ASC";
															$emp_result = $conn->query($emp_sql);
															$a = 1;
															$b = 0;
															while($emp_row = mysqli_fetch_array($emp_result)){
																$b++;
														?>
															<tr>
																<td><?php echo $a++; ?></td>
																<td><?php echo $emp_row['fname'];?> <?php echo $emp_row['lname'];?></td>
																<td><?php echo $emp_row['designation'];?></td>
																<td><?php echo $emp_row['date'];?></td>
																<td>																	  
																	<?php
																		if($emp_row['count'] == 1){
																			echo "Full Day";
																		}
																		else{
																			if($emp_row['fn_an_status'] == 1){
																				echo "Half Day (FN)";
																			}
																			elseif($emp_row['fn_an_status'] == 2){
																				echo "Half Day (AN)";
																			}
																		}
																	?>
																</td>
																<td style="text-align: center">
																	<button type="button" data-bs-toggle="modal" data-bs-target="#delete<?php echo $b; ?>"><span class="mdi mdi-delete-empty"></span></button>
																	<div class="modal fade" id="delete<?php echo $b;?>" tabindex="-1" role="dialog"	aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
																		<div class="modal-dialog modal-dialog-centered modal" role="document">
																			<div class="modal-content">
                                                                	            <form method="post">
                                                                	                <div class="modal-header">
                                                                	                    <h5 class="modal-title" id="addAdminTitle">Delete Comp-Off</h5>
                                                                	                    <!-- <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                	                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                                	                    </button> -->
                                                                	                </div>
                                                                	                <div class="modal-body">
                                                                	                    <p class="modal-text">Are you sure to delete <b><?php echo $emp_row['fname'];?> <?php echo $emp_row['lname'];?> Comp-off on <?php echo $emp_row['date'];?></b> !</p>
                                                                	                    <input type="hidden" name="emp_id" value="<?php echo $emp_row['attend_id']; ?>">
                                                                	                </div>
                                                                	                <div class="modal-footer">
                                                                	                    <button class="btn btn-secondary" data-dismiss="modal"> No</button>
                                                                	                    <button type="submit" name="delete" class="btn btn-danger">Delete</button>
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

					<div class="row m-b30">
						<div class="col-xl col-md-12 p-b-15">
							<div id="user-acquisition" class="card card-default">
								<div class="card-header">
									<h2 style="text-align: center">Comp Off Details - <?= date('Y'); ?></h2>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col">
											<div class="table-responsive">
												<table id="responsive-data-table1" class="table" style="width:100%">
													<thead>
														<tr>
															<th>S.No</th>
															<th>Employee Name</th>
															<th>Designation</th>
															<th>Date</th>
															<th>Description</th>
														</tr>
													</thead>
													<tbody>
														<?php
															$emp_sql = "SELECT *,a.id as attend_id FROM attendance a LEFT OUTER JOIN employee b ON a.emp_id = b.id WHERE a.status = 2 AND a.date BETWEEN '$year_start_date' AND '$year_end_date' ORDER BY a.date DESC";
															$emp_result = $conn->query($emp_sql);
															$a = 1;
															$b = 0;
															while($emp_row = mysqli_fetch_array($emp_result)){
																$b++;
														?>
															<tr>
																<td><?php echo $a++; ?></td>
																<td><?php echo $emp_row['fname'];?> <?php echo $emp_row['lname'];?></td>
																<td><?php echo $emp_row['designation'];?></td>
																<td><?php echo date('d-m-Y', strtotime($emp_row['date'])) ;?></td>
																<td>																	  
																	<?php
																		if($emp_row['count'] == 1){
																			echo "Full Day";
																		}
																		else{
																			if($emp_row['fn_an_status'] == 1){
																				echo "Half Day (FN)";
																			}
																			elseif($emp_row['fn_an_status'] == 2){
																				echo "Half Day (AN)";
																			}
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
    // FN AN control
	function fnanStatus(val){
		if(val == 1){
			$('.absent_status').hide();
		}
		else{
			$('.absent_status').show();
		}
	}

	/* Initialization of datatables */ 
    $(document).ready(function () { 
        $('responsive-data-table1.table').DataTable(); 
    });

	$('#date').on('change', function(){
		var value = $('#date').val();
		$.ajax({
			url : 'ajax/compoffCheck.php',
			type : 'POST',
			data : {
				value : value,
			},
			success : function(html){
				// alert(html)
				$('#empId').html(html);
			}
		})
	});
</script>
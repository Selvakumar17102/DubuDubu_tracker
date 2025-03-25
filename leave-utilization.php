<?php

session_start();
ini_set('display_errors', 'off');
include("include/connection.php");
date_default_timezone_set("Asia/Calcutta");

$leaveUti = 'active';
$leaveUti_boolean = 'true';

$prevMonth = strtotime("-1 month");
$previousMonth = date('Y-m',$prevMonth);

$date_time = date('Y-m-d H:i:s');
$today = date('Y-m-d');
$currentMonYear = date('Y-m');
$year = date('Y');
$currentMonth = date('m');

$year_start_date = date('Y-01-01');
$year_end_date = date('Y-12-31');

if(isset($_POST['search'])){
	$filterMonth = $_POST['monthName'];
}
else{
	$filterMonth = $previousMonth;
}

if(isset($_POST['submit'])){
	$emp_count = count($_POST['emp_id']);
	$month_year = $_POST['month_year'];

	$sql = "SELECT * FROM leave_utilization WHERE month_year = '$month_year'";
	$result = $conn->query($sql);
	if($result->num_rows > 0){
		for($i=0; $i<$emp_count; $i++){
			$employee_id = $_POST['emp_id'][$i];
			$absent = $_POST['absent'][$i];
			$cl_utilization = $_POST['cl_uti'][$i];
			$lop = $_POST['lop'][$i];
			$comp_utilization = $_POST['comp_uti'][$i];
			$reason = $_POST['reason'][$i];

			// echo $comp_utilization;
			$sql1 = "UPDATE leave_utilization SET cl_utilization = '$cl_utilization', lop = '$lop', comp_off_utilization = '$comp_utilization', reason = '$reason', updated_date_time = '$date_time' WHERE emp_id = '$employee_id' AND month_year = '$month_year'";
			if($conn->query($sql1)){
				header('location:leave-utilization.php?msg=Updated Successfully !&type=warning');
			}
		}
	}
	else{
		for($i=0; $i<$emp_count; $i++){
			$employee_id = $_POST['emp_id'][$i];
			$absent = $_POST['absent'][$i];
			$cl_utilization = $_POST['cl_uti'][$i];
			$lop = $_POST['lop'][$i];
			$comp_utilization = $_POST['comp_uti'][$i];
			$reason = $_POST['reason'][$i];

			$sql1 = "INSERT INTO leave_utilization (emp_id,absent,cl_utilization,lop,comp_off_utilization,reason,month_year,created_date_time,updated_date_time,status) VALUES ('$employee_id','$absent','$cl_utilization','$lop','$comp_utilization','$reason','$month_year','$date_time','$date_time','1')";
			if($conn->query($sql1)){
				header('location:leave-utilization.php?msg=Added Successfully !&type=success');
			}
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

	<title>Dubu Dubu - Leave Details</title>

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
							<h1>Leave Utilization</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Leave Details</p>
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
									<h2>Leave Details</h2>
								</div>
								<div class="card-body">
									<div class="row ec-vendor-uploads">
										<div class="col-lg-12">
											<div class="ec-vendor-upload-detail">
												<form method="post" class="row g-3">
													<label class="form-label">Month</label>
													<div class="col-md-6">
                                                        <input type="month" class="form-control" name="monthName" id="monthName" value="<?php echo $filterMonth; ?>" max="<?php echo $previousMonth; ?>">
														<input type="hidden" id="getDate" name="getDate" value="<?php echo $filterMonth;?>">
													</div>
													<div class="col-md-6">
														<!-- <input type="submit" name="request" id="request" value="Request" class="btn btn-primary"/> -->
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
								<div class="card-body">
									<div class="table-responsive">
										<form method="post">
										    <table id="responsive-data-table" class="table" style="width:115%">
										    	<thead>
										    		<tr>
										    			<th>ID</th>
										    			<th>Name</th>
										    			<th style="text-align: center">Leave Count</th>
										    			<th style="text-align: center">Available CL</th>
										    			<th style="text-align: center">Available Comp-Off</th>
										    			<th style="text-align: center">CL Utilization</th>
										    			<th style="text-align: center">LOP</th>
														<th style="text-align: center">Comp-Off Utilization</th>
										    			<th style="text-align: center">Reason</th>
										    		</tr>
										    	</thead>
										    	<tbody>
										    		<?php
										    		    $monthValue = date('m', strtotime($filterMonth));
                                                        $yearValue = date('Y', strtotime($filterMonth));
                                                        $firstDay = $yearValue."-".$monthValue."-01";
                                                        $lastDay = date('Y-m-t',strtotime($firstDay));

														$sql2 = "SELECT * FROM leave_utilization WHERE month_year = '$filterMonth'";
														$result2 = $conn->query($sql2);
														if($result2->num_rows > 0){
															$sql = "SELECT *,a.emp_id AS empID FROM leave_utilization a
															LEFT OUTER JOIN employee b ON b.id = a.emp_id
															WHERE a.month_year = '$filterMonth' ORDER BY b.fname ASC";
														}
														else{
                                                        	$sql = "SELECT *,id AS empID FROM employee WHERE del_status = 0 AND control != 5 AND doj <= '$lastDay' AND
                                                        	id NOT IN (SELECT id FROM employee WHERE emp_status != 'Active' AND resign_date <= '$firstDay')
                                                        	ORDER BY fname ASC";
														}
														// echo $sql;

                                                        $result = $conn->query($sql);
                                                        $c = 1;
                                                        $b = $d = 0;
										    		    while($row=mysqli_fetch_array($result)){
															$b++;
										    		    	$emp_id = $row['id'];
										    		    	$doj = $row['doj'];

															if($row['leave_utilization_id'] != NULL){
																$d++;
															}
															else{
																$d;
															}

															// add 15 days from the start date
															$fifteenth_day = date('Y-m-d', strtotime($firstDay.'+15 days'));

															if($row['leave_utilization_id'] != NULL){
																// $msg = "this";
																if($today > $fifteenth_day){
																	$sql4 = "UPDATE leave_utilization SET status = '2' WHERE emp_id = '$emp_id' AND month_year = '$filterMonth'";
																	$conn->query($sql4);
																	$readonly = 'readonly';
																}
																else{
																	$readonly = "";
																}
															}
															else{
																// $msg = "that";
																$readonly = "";
															}
															// echo $msg;

                                                            $attend_sql = "SELECT * FROM attendance WHERE emp_id = '$emp_id' AND status = 1 AND (date BETWEEN '$firstDay' AND '$lastDay')";
                                                            $attend_result = $conn->query($attend_sql);
                                                            $a = $p = $absent = 0;
                                                            while($attend_row = mysqli_fetch_array($attend_result)){
                                                                if($attend_row['count'] == "1"){
                                                                    $absent = $a+1;
                                                                }
                                                                elseif($attend_row['count'] == "2"){
                                                                    $absent = $a+0.5;
                                                                }
                                                                $a = $absent;
                                                            }
                                                            // echo $attend_sql;

                                                            // added three months from date of joining
                                                            $third_month =  date("Y-m-d", strtotime($row['doj'].'+3 months'));
                                                            // $third_month =  date("m", strtotime($row['doj'])) + 3;
                                                            // $after_internship = date('Y-'.$third_month.'-d', strtotime($row['doj']));
                                                            // echo $third_month;

                                                            // $a1 = date('n', strtotime($filterMonth));
															$a1 = $b1 = $d1 = $absent_total = 0;
                                                            for($i=01; $i <= $monthValue; $i++){
                                                                $startDate = date('Y-m-d', strtotime($yearValue."-".$i."-01"));
                                                                // $startDate = "2023-01-01";
                                                                $endDate = date('Y-m-t', strtotime($startDate));
																$month_year = $yearValue."-".$i;
                                                                // echo "$third_month <= $startDate";
                                                                
																// next 7 days
																$seventh_day = date('Y-m-d', strtotime($yearValue."-".$i."-07"));

																if($doj <= $seventh_day){
                                                                	if($third_month <= $seventh_day){
																		$msg = "this";
																		$d1 = $a1 + 1;
																		// if($i < $monthValue){
																			$sql1 = "SELECT * FROM leave_utilization WHERE emp_id = '$emp_id' AND month_year = '$month_year' AND status = '2'";
																			$result1 = $conn->query($sql1);
																			if($result1->num_rows > 0){
																				$row1 = $result1->fetch_assoc();
																				$cl = $d1 - $row1['cl_utilization'];
																			}
																			else{
																				$cl = $d1;
																			}
																		// }
																		// else{
																		// 	$cl = $d1;
																		// }
                                                                	}
																	else{
																		$msg = "that";
																		$cl = 1;
																	}
																}
                                                                else{
                                                                    $msg = "then";
                                                                    $cl = 0;
                                                                }
                                                                $a1 = $d1;
                                                                // echo $msg;
                                                                // exit();
                                                            }

															$attend_sql1 = "SELECT * FROM attendance WHERE emp_id = '$emp_id' AND status = '2'";
															$attend_result1 = $conn->query($attend_sql1);
                                                            $f = $comp_off = $comp_off_balance = 0;
                                                            while($attend_row1 = mysqli_fetch_array($attend_result1)){
																// echo $a;
                                                                if($attend_row1['count'] == "1"){
																	$comp_off = $f+1;
                                                                }
                                                                elseif($attend_row1['count'] == "2"){
																	$comp_off = $f+0.5;
                                                                }
                                                                $f = $comp_off;
                                                            }
															
															// echo $sql3;
															$sql3 = "SELECT SUM(comp_off_utilization) AS comp_off FROM leave_utilization WHERE emp_id = '$emp_id' AND status = '2'";
															$result3 = $conn->query($sql3);
															$row3 = $result3->fetch_assoc();
															$com = $row3['comp_off'];

															$comp_off_balance = $comp_off - $com;
										    		?>
										    		        <tr>
																<input type="hidden" name="month_year" id="month_year<?= $b; ?>" value="<?= $filterMonth; ?>">
										    		        	<td><?= $c++;?></td>
                                                                <td><?= $row['fname']." ".$row['lname']; ?></td>
                                                                <td style="text-align: center"><?= $absent; ?></td>
                                                                <td style="text-align: center"><?= $cl; ?></td>
                                                                <td style="text-align: center"><?= $comp_off_balance; ?></td>
																<input type="hidden" name="emp_id[]" id="emp_id<?= $b; ?>" value="<?= $row['empID']; ?>">
																<input type="hidden" name="absent[]" id="absent<?= $b; ?>" value="<?= $absent; ?>">
																<td style="text-align: center">
																	<div class="col-sm-12">
																		<input type="number" class="form-control" name="cl_uti[]" id="cl_uti<?= $b; ?>" step=".5" min="0" value=<?= $row['cl_utilization']; ?> onkeyup="return clCheck(this.value, <?= $cl; ?>, <?= $b; ?>)" onchange="return clCheck(this.value, <?= $cl; ?>, <?= $b; ?>)" <?= $readonly; ?>>
																	</div>
																	<!-- <div class="col-sm-12"> -->
																		<span id="span_cl<?= $b; ?>" style="color: red"></span>
																	<!-- </div> -->
																</td>
																<td style="text-align: center">
																	<div class="col-sm-12">
																		<input type="number" class="form-control" name="lop[]" id="lop<?= $b; ?>" step=".5" min="0" value=<?= $row['lop']; ?> <?= $readonly; ?>>
																	</div>
																	<span id="span_lop<?= $b; ?>" style="color: red"></span>
																</td>
																<td style="text-align: center">
																	<div class="col-sm-12">
																		<input type="number" class="form-control" name="comp_uti[]" id="comp_uti<?= $b; ?>" step=".5" min="0" value=<?= $row['comp_off_utilization']; ?> onkeyup="return compCheck(this.value, <?= $comp_off_balance; ?>, <?= $b; ?>)" onchange="return compCheck(this.value, <?= $comp_off_balance; ?>, <?= $b; ?>)" <?= $readonly; ?>>
																	</div>
																	<span id="span_comp<?= $b; ?>" style="color: red"></span>
																</td>
																<td style="text-align: center">
																	<div class="col-sm-12">
																		<textarea name="reason[]" id="reason<?= $b; ?>" class="form-control" style="height: 17px" <?= $readonly; ?>><?= $row['reason']; ?></textarea>
																	</div>
																</td>
										    		        </tr>
										    		<?php
										    		    }
										    		?>
													<input type="hidden" name="totalRows" id="totalRows" value="<?= $b; ?>">
													<?php
														if($d != 0){
															$submit_button = 'style= display:none';
														}
														else{
															$submit_button = "";
														}
													?>
										    		<tr <?= $submit_button; ?>>
										    			<td><button class="btn btn-success" id="submit" name="submit" onclick="return checkLeave()">Submit</button></td>
										    		</tr>
										    		</tbody>
										    </table>
										</form>
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
	function clCheck(f, g, h){
		if(f > g){
			$('#cl_uti'+h).addClass('check-border');
			document.getElementById('span_cl'+h).innerHTML = "CL value is incorrect !";
			return false;
		}
		else{
			$('#cl_uti'+h).removeClass('check-border');
			document.getElementById('span_cl'+h).innerHTML = "";
		}
	}

	function compCheck(m, n, o){
		if(m > n){
			$('#comp_uti'+o).addClass('check-border');
			document.getElementById('span_comp'+o).innerHTML = "Comp-Off value is incorrect !";
			return false;
		}
		else{
			$('#comp_uti'+o).removeClass('check-border');
			document.getElementById('span_comp'+o).innerHTML = "";
		}
	}

	function checkLeave(){
		var totalRows = $('#totalRows').val();

		for(j=1; j<=totalRows; j++){
			var absent = $('#absent'+j).val();
			var cl_uti = $('#cl_uti'+j).val();
			// alert(cl_uti)
			if(cl_uti == ""){
				var cl_uti_value = 0;
			}
			else{
				var cl_uti_value = cl_uti;
			}
			var lop = $('#lop'+j).val();
			if(lop == ""){
				var lop_value = 0;
			}
			else{
				var lop_value = lop;
			}
			var comp_uti = $('#comp_uti'+j).val();
			if(comp_uti == ""){
				var comp_uti_value = 0;
			}
			else{
				var comp_uti_value = comp_uti;
			}
			var span_cl = $('#span_cl'+j).val();
			var span_comp = $('#span_comp'+j).val();

			if(absent != parseFloat(cl_uti_value) + parseFloat(lop_value) + parseFloat(comp_uti_value)){
				$('#cl_uti'+j).addClass('check-border');
				$('#lop'+j).addClass('check-border');
				$('#comp_uti'+j).addClass('check-border');
				document.getElementById('span_cl'+j).innerHTML = "Incorrect Values !";
				return false;
			}
			else{
				$('#cl_uti'+j).removeClass('check-border');
				$('#lop'+j).removeClass('check-border');
				$('#comp_uti'+j).removeClass('check-border');
				document.getElementById('span_cl'+j).innerHTML = "";
				if(span_cl != ""){
					$('#cl_uti'+j).addClass('check-border');
					$('#lop'+j).addClass('check-border');
					$('#comp_uti'+j).addClass('check-border');
					return false;
				}
				else{
					$('#cl_uti'+j).removeClass('check-border');
					$('#lop'+j).removeClass('check-border');
					$('#comp_uti'+j).removeClass('check-border');
				}
			}
		}
	}
</script>
<?php

session_start();
ini_set('display_errors', 'off');
include("include/connection.php");
$payslip2 = 'active';
$payslip2_boolean = 'true';

$today = date('Y-m-d');
$currentMonth = date('Y-m');
$prevMonth = strtotime("-1 month");
$previousMonth = date('Y-m',$prevMonth);

if(isset($_POST['search'])){
	$filterMonth = $_POST['monthName'];
}
else{
	$filterMonth = $previousMonth;
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Ekka - Admin Dashboard HTML Template.">

	<title>DUBU DUBU - Payslip</title>

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
							<h1>Payslip</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Payslip <?= $previousMonth; ?>
							</p>
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
									<h2>Payslip</h2>
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
						<div class="col-xl col-md-12 p-b-15">
							<div id="user-acquisition" class="card card-default">
								<div class="card-header">
									<h2 style="text-align: center">Payslip Details</h2>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="responsive-data-table" class="table">
											<thead>
                                                <tr>
											    	<th>ID</th>
											    	<th>Name</th>
											    	<th>Role</th>
											    	<th style="text-align: center">Present</th>
											    	<th style="text-align: center">Absent</th>
											    	<th style="text-align: center">Comp Off</th>
											    	<th style="text-align: center">LOP</th>
											    	<th style="text-align: center">Salary Calculation Days</th>
											    </tr>
											</thead>
											<tbody>
												<?php
                                                    $monthValue = date('m', strtotime($filterMonth));
                                                    $yearValue = date('Y', strtotime($filterMonth));
                                                    $firstDay = date('Y-m-d', strtotime($yearValue."-".$monthValue."-01"));
                                                    $lastDay = date('Y-m-t',strtotime($firstDay));

													$sql3 = "SELECT *,a.emp_id AS empID FROM leave_utilization a
													LEFT OUTER JOIN employee b ON b.id = a.emp_id
													WHERE a.month_year = '$filterMonth'";
													// if($result4->num_rows > 0){}
												    // $sql3 = "SELECT * FROM employee WHERE del_status = 0 AND control != 5 AND doj <= '$lastDay' AND
                                                    // id NOT IN (SELECT id FROM employee WHERE emp_status != 'Active' AND resign_date <= '$firstDay')
                                                    // ORDER BY fname ASC";
												    $result3 = $conn->query($sql3);
												    $count = 1;
												    // $a = 0;
													// echo $sql3;
												    while($row3 = mysqli_fetch_array($result3)){
														$total_absent = $b1 = $present = $comp_off = $a1 = $lop1 = 0;
												    	$emp_id = $row3['empID'];
												    	$lop = $row3['lop'];
														// echo $lop;

														$attend_sql = "SELECT * FROM attendance WHERE emp_id = '$emp_id' AND status = 1 AND (date BETWEEN '$firstDay' AND '$lastDay')";
														$attend_result = $conn->query($attend_sql);
														if($attend_result->num_rows > 0){
															while($attend_row = mysqli_fetch_array($attend_result)){
																if($attend_row['count'] == "1"){
																	$total_absent = $b1+1;
																}
																elseif($attend_row['count'] == "2"){
																	$total_absent = $b1+0.5;
																}
																$b1 = $total_absent;
															}
														}
														else{
															$total_absent = 0;
														}
														// $total_absent = no of days absent in a month

														// $present = no of days present in a month
														$present = 30 - $total_absent;

														$lop1 = $total_absent - $comp_off - 1;
														// $lop = int(3 - 1 - 1);
														if($lop1 < 0){
															$lop = 0;
														}
														else{
															$lop2 = $lop1;
														}
														// echo $lop; exit();

														$attend_sql1 = "SELECT * FROM attendance WHERE emp_id = '$emp_id' AND status = 2 AND (date BETWEEN '$firstDay' AND '$lastDay')";
														// echo $attend_sql1;
														$attend_result1 = $conn->query($attend_sql1);
														if($attend_result1->num_rows > 0){
															while($attend_row1 = mysqli_fetch_array($attend_result1)){
																if($attend_row1['count'] == "1"){
																	$comp_off = $a1+1;
																}
																elseif($attend_row1['count'] == "2"){
																	$comp_off = $a1+0.5;
																}
																$a1 = $comp_off;
															}
														}
														else{
															$comp_off = 0;
														}
														// $comp_off = no of days comp off in a month

														$userid = $emp_id;
    													$date = $firstDay;
    													// $lop = $row3['lop'];
    													// echo $row3['lop'];

    													$rupees ="&#8377";

    													$sql = "SELECT * FROM employee WHERE id=$userid";
    													$result =$conn->query($sql);
    													$row = mysqli_fetch_array($result);

    													// Use mktime() and date() function to
    													// convert number to month name
    													// $month_num =3;
    													$month = date('n', strtotime($date));
    													$year = date('Y', strtotime($date));
    													$month_name = date("F", mktime(0, 0, 0, $month, 10));
    													$sdate = date("01-m-Y",strtotime($date));
    													$edate =  date('t-m-Y', strtotime($date));

    													$num_days_mon = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    													$start_date = date("Y-m-01",strtotime($date));
    													$end_date =  date('Y-m-t', strtotime($date));
    													$doj = $row['doj'];
    													$resign_date = $row['resign_date'];

    													if($doj > $start_date){
    													    $diff = abs(strtotime($doj) - strtotime($start_date));
    													    $years = floor($diff / (365*60*60*24));
    													    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
    													    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
    													    // $days = 7;
														
    													    $actual_salary = $row['basic_salary'];
    													    $calSalary = round(($actual_salary / 30)*$days);
    													    $detuct_salary = $actual_salary - $calSalary;
    													}
    													else{
    													    if($resign_date == ""){
    													        $detuct_salary = $row['basic_salary'];
    													    }
    													    else{
    													        if($resign_date < $end_date){
    													            $diff = abs(strtotime($end_date) - strtotime($resign_date));
    													            $years = floor($diff / (365*60*60*24));
    													            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
    													            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
    													            $salary_days = $num_days_mon - $days;
																
    													            $actual_salary = $row['basic_salary'];
    													            $calSalary = round(($actual_salary / 30)*$salary_days);
    													            $detuct_salary = $actual_salary - $calSalary;
    													            // echo $detuct_salary; die();
    													        }
    													        else{
    													            $detuct_salary = $row['basic_salary'];
    													        }
    													    }
    													}
													
    													$salary = $row['basic_salary'];
    													$lopcalamt=round(($salary / 30)*$lop);
    													$lopamt = $detuct_salary - $lopcalamt;
    													// echo $lopcalamt;
    													// $grosslopamt = $salary - $lop;
    													$basic_salary = (40 / 100) * $salary;
    													$hra = (24 / 100) * $salary;
    													$ta = (13 / 100) * $salary;
    													$cca = (17 / 100) * $salary;
    													$ma = (6 / 100) * $salary;
    													$earned_salary = (40 / 100) * $lopamt;
    													$earned_hra = (24 / 100) * $lopamt;
    													$earned_ta = (13 / 100) * $lopamt;
    													$earned_cca = (17 / 100) * $lopamt;
    													$earned_ma = (6 / 100) * $lopamt;
    													// echo $basic_salary;
    													$actGrosspay = $basic_salary+$hra+$ta+$cca+$ma;
    													$earGrosspay = $earned_salary+$earned_hra+$earned_ta+$earned_cca+$earned_ma;
													
    													$month1 = date('m', strtotime($date));
    													$year_mon = $year."-".$month1;
    													$pre_days = 30 - floatval($lop);
													
    													$pay_sql = "SELECT * FROM payslip WHERE emp_id = '$userid' AND sal_month_year = '$year_mon'";
    													$pay_result = $conn->query($pay_sql);
    													if($pay_result->num_rows > 0){
    													    $pay_sql1 = "UPDATE payslip SET present_days = '$pre_days', lop_days = '$lop', salary_to_pay = '$earGrosspay', updated_date = '$today' WHERE emp_id = '$userid' AND sal_month_year = '$year_mon'";
    													    $pay_result1 = $conn->query($pay_sql1);
    													}
    													else{
    													    $pay_sql1 = "INSERT INTO payslip (emp_id, sal_month_year, days_in_month, sal_cal_days, present_days, lop_days, actual_salary, salary_to_pay, created_date, updated_date) VALUES ('$userid', '$year_mon', '$num_days_mon', 30, '$pre_days', '$lop', '$salary', '$earGrosspay', '$today', '$today')";
    													    $pay_result1 = $conn->query($pay_sql1);
    													}
												?>
												        <tr>
												        	<td><?php echo $count++;?></td>
                                                            <td><a href="preview2.php?emp_id=<?= $emp_id; ?>&form_date=<?= $firstDay; ?>"><?= $row3['fname']." ".$row3['lname']; ?></a></td>
                                                            <td><?= $row3['designation']; ?></td>
                                                            <td style="text-align: center"><?= $present; ?></td>
                                                            <td style="text-align: center"><?= $total_absent; ?></td>
                                                            <td style="text-align: center"><?= $comp_off; ?></td>
                                                            <td style="text-align: center"><?= $row3['lop']; ?></td>
                                                            <td style="text-align: center"><?= "30"; ?></td>
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
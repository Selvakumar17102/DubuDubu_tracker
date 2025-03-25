<?php

session_start();
ini_set('display_errors', 'off');
include("include/connection.php");
$report = 'active';
$report_boolean = 'true';
$report_show = 'show';
$payslip_details = 'active';

// $today = date('Y-m-d');

if(isset($_POST['search'])){
	$monthName = $_POST['monthName'];
}
else{
	$monthName = date('Y-m');
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

	<title>DUBU DUBU - Payslip Report</title>

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

<style>
	table, th, td{
		border-width: 3px;
		white-space: nowrap;
	}
</style>

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
							<h1>Payslip Report</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Payslip Report</p>
						</div>
						<!-- <div>
							<a href="product-list.php" class="btn btn-primary">Attendance Report</a>
						</div> -->
					</div>

                    <div class="row m-b30">
						<div class="col-12">
							<div class="card card-default">
								<div class="card-header card-header-border-bottom">
									<h2>Payslip Report</h2>
								</div>
								<div class="card-body">
									<div class="row ec-vendor-uploads">
										<div class="col-lg-12">
											<div class="ec-vendor-upload-detail">
												<form id="apply_leave" method="post" class="row g-3" enctype="multipart/form-data">
													<div class="col-md-6">
														<label class="form-label">Select Month and Year</label>
														<input type="month" class="form-control" name="monthName" id="monthName" value="<?php echo $monthName; ?>">
													</div>
													<div class="col-md-6 pt-4">
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
									<h2 style="text-align: center">DUBU DUBU Payslip Report</h2>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<div class="new_table">
										<table id="data_table" class="table" style="width:100%">
											<thead style="border-width:5px">
												<tr>
													<th>S.No</th>
													<th>Employee Name</th>
                                                    <th style="text-align: center">No of Days in the month</th>
                                                    <th style="text-align: center">Salary Calculation Days</th>
                                                    <th style="text-align: center">No of Days Present</th>
                                                    <th style="text-align: center">No of Days LOP</th>
                                                    <th style="text-align: center">Salary</th>
                                                    <th style="text-align: center">Salary To Pay</th>
												</tr>
											</thead>

											<tbody>
												<?php
                                                    $pay_sql = "SELECT * FROM payslip a LEFT OUTER JOIN employee b ON a.emp_id = b.id WHERE sal_month_year = '$monthName'";
                                                    $pay_result = $conn->query($pay_sql);
                                                    $count = 1;
                                                    while($pay_row = mysqli_fetch_array($pay_result)){
												?>
												    <tr>
                                                        <td><?php echo $count++; ?></td>
                                                        <td><?php echo $pay_row['fname']; ?> <?php echo $pay_row['lname']; ?></td>
                                                        <td style="text-align: center"><?php echo $pay_row['days_in_month']; ?></td>
                                                        <td style="text-align: center"><?php echo $pay_row['sal_cal_days']; ?></td>
                                                        <td style="text-align: center"><?php echo $pay_row['present_days']; ?></td>
                                                        <td style="text-align: center"><?php echo $pay_row['lop_days']; ?></td>
                                                        <td style="text-align: center"><?php echo $pay_row['actual_salary']; ?></td>
                                                        <td style="text-align: center"><?php echo $pay_row['salary_to_pay']; ?></td>
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

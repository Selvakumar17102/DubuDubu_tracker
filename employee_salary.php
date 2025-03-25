<?php
session_start();
ini_set("display_errors",'off');
include("include/connection.php");

$payroll = 'active';
$pay_boolean = 'true';
$pay_show = 'show';
$emp_salary_page = 'active';

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Ekka - Admin Dashboard HTML Template.">

	<title>DUBU DUBU - Employee Salary</title>

	<!-- GOOGLE FONTS -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

	<link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />

    <link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>


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
							<h1>Employee Salary</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Employee Salary</p>
						</div>
						<div class="col-sm-3" style="text-align:end">

						</div>
						<div class="col-sm-3" style="text-align:end">
							<select name="month" id="month" class="form-control">
								<option value=''>Choose Month</option>
								<?php
								for ($i = 0; $i < 6; $i++) {
									$monthValue = date('Y-m', strtotime("-$i months"));
									$monthName = date('F Y', strtotime("-$i months"));
									echo "<option value='$monthValue'>$monthName</option>";
								}
								?>
							</select>
                    	</div>
					</div>
                    <div class="row">
						<div class="col-xl col-md-12 p-b-15">
							<div id="user-acquisition" class="card card-default">
								<div class="card-body">
									<div class="table-responsive">
										<table id="responsive-data-table" class="table">
											<thead>
												<tr>
													<th>Emp - ID</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Joinning Date</th>
                                                    <th>Status</th>
                                                    <th>Payslip</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$sql = "SELECT * FROM employee";
												$result = $conn->query($sql);
												while($row = mysqli_fetch_array($result)){
													?>
													<tr>
														<td><?= $row['emp_id']; ?></td>
														<td><?= $row['fname']; ?> <?= $row['lname']; ?></td>
														<td><?= $row['oemail']; ?></td>
														<td><?= $row['pphno']; ?></td>
														<td><?= date('d-m-Y', strtotime($row['doj'])); ?></td>
														<td>
															<span class="mb-2 mr-2 badge badge-<?= ($row['emp_status'] == 'Active') ? 'success' : 'danger'; ?>">
																<?= $row['emp_status']; ?>
															</span>
														</td>

														<td><a href="javascript:void(0);" onclick="generatePayslip(<?= $row['id']; ?>)" class="btn btn-primary" style="padding: 5px 1rem !important; border-radius: 5px !important;">Generate Payslip</a></td>
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
                    <div class="form-group">
        				<div class="col-sm-12">
							<span id="alertmeg"></span>
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
	function generatePayslip(empId) {
		let selectedMonth = document.getElementById("month").value;
		if (!selectedMonth) {
			alert("Please select a month first!");
			return false;
		}else{
			window.location.href = "generate_payslip.php?emp_id=" + empId + "&month=" + selectedMonth;
		}
	}
</script>

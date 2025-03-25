<?php
session_start();
ini_set('display_errors', 'off');
include('include/connection.php');

$emppayslip = 'active';
$emppayslip_boolean = 'true';

$emp_id = $_SESSION['id'];
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

	<!-- Data Tables -->
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
							<h1>Payslip</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Payslip</p>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="card card-default">
								<div class="card-header card-header-border-bottom">
									<h2>Generate Payslip</h2>
								</div>
								<div class="card-body">
									<div class="row ec-vendor-uploads">
										<div class="col-lg-12">
											<div class="ec-vendor-upload-detail">
                    							<div class="submitInput d-print-none">
													<div class="row">
                                                        <div class="col-sm-6">
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
                                                        <div class="col-lg-3">
                                                        <a href="javascript:void(0);" onclick="generatePayslip(<?= $_SESSION['id']; ?>)" class="btn btn-primary">Generate Payslip</a>
                                                            <!-- <button type="submit" name="generate" id="generate" class="btn btn-primary">Generate Payslip</button> -->
                                                        </div>
													</div>
                    							</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div> <!-- End Content -->
			</div> 
            <!-- End Content Wrapper -->

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

	<!-- Data Tables -->
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
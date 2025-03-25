<?php

session_start();
ini_set("display_errors",'off');
include('include/connection.php');
$payroll = 'active';
$pay_boolean = 'true';
$pay_show = 'show';
$payroll_item = 'active';

$id = $_GET['id'];
$sql = "SELECT * FROM payroll_details WHERE id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = "";
    $name = "";
    $amount = "";
    $unit = "";

    if (isset($_POST['earningAdd'])) {
        $type = "earning";
        $name = $_POST['earningname'];
        $amount = $_POST['earningamount'];
        $unit = $_POST['earningunit'];

    } elseif (isset($_POST['deductionAdd'])) {
        $type = "deduction";
        $name = $_POST['deductionname'];
        $amount = $_POST['deductionamount'];
        $unit = $_POST['deductionunit'];

    } elseif (isset($_POST['otherAdd'])) {
        $type = "other";
        $name = $_POST['othername'];
        $amount = $_POST['otheramount'];
        $unit = $_POST['otherunit'];
    }

    if (!empty($name)) {
		if($id){
			$sql = "UPDATE payroll_details SET type = '$type', name = '$name', amount = '$amount', unit = '$unit' WHERE id = '$id'";
			if($conn->query($sql) === TRUE){
				header("Location: payrollitem.php");
			} 

		}else{
			$sql = "INSERT INTO payroll_details (type, name, amount, unit) VALUES ('$type', '$name', '$amount', '$unit')";
			if($conn->query($sql) === TRUE){
				header("Location: payrollitem.php");
			} 
		}
    } else {
        echo "<script>alert('All fields are required!');</script>";
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

	<title>DUBU DUBU - Pay Roll Item</title>

	<!-- GOOGLE FONTS -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

	<link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>


	<!-- PLUGINS CSS STYLE -->
	<link href="assets/plugins/simplebar/simplebar.css" rel="stylesheet" />

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
                            <h1>Pay Roll Item</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Pay Roll Item</p>
						</div>
						<div>
							<a href="javascript:history.go(-1)" class="btn btn-primary">Back</a>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="card card-default">
								<div class="card-header card-header-border-bottom">
									<ul class="nav nav-tabs nav-alltabs d-flex justify-content-center w-100" id="myRatingTab" role="tablist">
										<li class="nav-item">
											<a  class="nav-link tab-link active" id="product-detail-tab" data-bs-toggle="tab" data-bs-target="#earningdetail" href="#earningdetail" role="tab" aria-selected="true">
												<i class="mdi mdi-account-circle mr-1"></i>Earnings</a>
										</li>
										<li class="nav-item">
											<a  class="nav-link tab-link" id="product-information-tab" data-bs-toggle="tab" data-bs-target="#deductiondetail" href="#deductiondetail" role="tab" aria-selected="false">
												<i class="mdi mdi-information mr-1"></i>Deductions</a>
										</li>
										<!-- <li class="nav-item">
											<a  class="nav-link tab-link" id="product-reviews-tab" data-bs-toggle="tab" data-bs-target="#otherdetail" href="#otherdetail" role="tab" aria-selected="false">
												<i class="mdi mdi-file-document mr-1"></i> Others </a>
										</li> -->
									</ul>
								</div>
								<div class="card-body">
									<div class="tab-content" id="myTabContent2">
										<div class="tab-pane pt-5 fade show active" id="earningdetail" role="tabpanel">
											<div class="row ec-vendor-uploads">
												<div class="col-lg-12">
													<div class="ec-vendor-upload-detail">
														<form method="post" class="row">
															<div class="col-md-3">
																<label>Earnings Name <span style="color:red;font-weight:bold">*</span></label>
																<input type="text" class="form-control" name="earningname" id="earningname" value="<?= $row['name'] ?>" placeholder="Enter Earnings" required>
															</div>
															<div class="col-md-2">
																<label>Amount <span style="color:red;font-weight:bold">*</span></label>
																<input type="text" class="form-control" name="earningamount" id="earningamount" value="<?= $row['amount'] ?>" placeholder="Enter Amount" required>
															</div>
															<div class="col-md-2">
																<label>Unit <span style="color:red;font-weight:bold">*</span></label>
																<select class="form-control" name="earningunit" id="earningunit">
																	<option value="">Select Unit</option>
																	<option value="%" <?php if($row['unit'] == '%') { echo "selected"; }?>>% Percentage</option>
																	<option value="₹" <?php if($row['unit'] == '₹') { echo "selected"; }?>>₹ Amount</option>
																</select>
															</div>
															<div class="col-md-2">
																<label >Action</label>
																<button type="submit" name="earningAdd" id="earningAdd" class="btn btn-primary">Add</button>
															</div>
														</form>
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
																		<table class="table table-striped o-tbl">
																			<thead>
																				<tr>
																					<th>S.No</th>
																					<th>Earnings Name</th>
																					<th>Unit</th>
																					<th>Value</th>
																					<th>Action</th>
																				</tr>
																			</thead>
																			<tbody>
																				<?php
																				$earningSql = "SELECT * FROM payroll_details WHERE type = 'earning'";
																				$earningRes = $conn->query($earningSql);
																				$e = 1;
																				while($earningRow = mysqli_fetch_array($earningRes)){
																					?>
																					<tr>
																						<td><?= $e++; ?></td>
																						<td><?= $earningRow['name'] ?></td>
																						<td><?= $earningRow['unit'] ?></td>
																						<td><?= $earningRow['amount'] ?></td>
																						<td>
																							<a href="payrollitem.php?id=<?= $earningRow['id'] ?>&tab=earning"><span class="mdi mdi-pencil"></span></a>
																							<a href='payrollitemDelete.php?id=<?= $earningRow['id'] ?>' onclick='return confirm(\"Are you sure?\")'><span class='mdi mdi-delete-empty'></span></a>
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
										</div>

										<div class="tab-pane pt-3 fade" id="deductiondetail" role="tabpanel">
											<div class="row ec-vendor-uploads">
												<div class="col-lg-12">
													<div class="ec-vendor-upload-detail">
														<form method="post" class="row">
															<div class="col-md-3">
																<label>Deductions Name <span style="color:red;font-weight:bold">*</span></label>
																<input type="text" class="form-control" name="deductionname" id="deductionname" value="<?= $row['name'] ?>" placeholder="Enter Deductions Name" required>
															</div>
															<div class="col-md-2">
																<label>Amount <span style="color:red;font-weight:bold">*</span></label>
																<input type="text" class="form-control" name="deductionamount" id="deductionamount" value="<?= $row['amount'] ?>" placeholder="Enter Amount" required>
															</div>
															<div class="col-md-2">
																<label>Unit <span style="color:red;font-weight:bold">*</span></label>
																<select class="form-control" name="deductionunit" id="deductionunit">
																	<option value="">Select Unit</option>
																	<option value="%" <?php if($row['unit'] == '%') { echo "selected"; }?>>% Percentage</option>
																	<option value="₹" <?php if($row['unit'] == '₹') { echo "selected"; }?>>₹ Amount</option>
																</select>
															</div>
															<div class="col-md-2">
																<label >Action</label>
																<button type="submit" name="deductionAdd" id="deductionAdd" class="btn btn-primary">Add</button>
															</div>
														</form>
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
																		<table class="table">
																			<thead>
																				<tr>
																					<th>S.No</th>
																					<th>Deduction Name</th>
																					<th>Unit</th>
																					<th>Value</th>
																					<th>Action</th>
																				</tr>
																			</thead>
																			<tbody>
																				<?php
																				$deductionSql = "SELECT * FROM payroll_details WHERE type = 'deduction'";
																				$deductionRes = $conn->query($deductionSql);
																				$d = 1;
																				while($deductionRow = mysqli_fetch_array($deductionRes)){
																					?>
																					<tr>
																						<td><?= $d++; ?></td>
																						<td><?= $deductionRow['name'] ?></td>
																						<td><?= $deductionRow['unit'] ?></td>
																						<td><?= $deductionRow['amount'] ?></td>
																						<td>
																							<a href="payrollitem.php?id=<?= $deductionRow['id'] ?>&tab=deduction"><span class="mdi mdi-pencil"></span></a>
																							<a href='payrollitemDelete.php?id=<?= $deductionRow['id'] ?>' onclick='return confirm(\"Are you sure?\")'><span class='mdi mdi-delete-empty'></span></a>
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
										</div>

										<!-- <div class="tab-pane pt-3 fade" id="otherdetail" role="tabpanel">
											<div class="row ec-vendor-uploads">
												<div class="col-lg-12">
													<div class="ec-vendor-upload-detail">
														<form method="post" class="row">
															<div class="col-md-3">
																<label>Other Deduction Name <span style="color:red;font-weight:bold">*</span></label>
																<input type="text" class="form-control" name="othername" id="othername" value="<?= $row['name'] ?>" placeholder="Enter Other Deduction Name" required>
															</div>
															<div class="col-md-2">
																<label>Amount <span style="color:red;font-weight:bold">*</span></label>
																<input type="number" class="form-control" name="otheramount" id="otheramount" value="<?= $row['amount'] ?>" placeholder="Enter Amount" required>
															</div>
															<div class="col-md-2">
																<label>Unit <span style="color:red;font-weight:bold">*</span></label>
																<select class="form-control" name="otherunit" id="otherunit">
																	<option value="">Select Unit</option>
																	<option value="%" <?php if($row['unit'] == '%') { echo "selected"; }?>>% Percentage</option>
																	<option value="₹" <?php if($row['unit'] == '₹') { echo "selected"; }?>>₹ Amount</option>
																</select>
															</div>
															<div class="col-md-2">
																<label>Action</label>
																<button type="submit" name="otherAdd" id="otherAdd" class="btn btn-primary">Add</button>
															</div>
														</form>
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
																		<table class="table">
																			<thead>
																				<tr>
																					<th>S.No</th>
																					<th>Other Name</th>
																					<th>Unit</th>
																					<th>Value</th>
																					<th>Action</th>
																				</tr>
																			</thead>
																			<tbody>
																				<?php
																				$otherSql = "SELECT * FROM payroll_details WHERE type = 'other'";
																				$otherRes = $conn->query($otherSql);
																				$o = 1;
																				while($otherRow = mysqli_fetch_array($otherRes)){
																					?>
																					<tr>
																						<td><?= $o++; ?></td>
																						<td><?= $otherRow['name'] ?></td>
																						<td><?= $otherRow['unit'] ?></td>
																						<td><?= $otherRow['amount'] ?></td>
																						<td>
																							<a href="payrollitem.php?id=<?= $otherRow['id'] ?>&tab=other"><span class="mdi mdi-pencil"></span></a>
																							<a href='payrollitemDelete.php?id=<?= $otherRow['id'] ?>' onclick='return confirm(\"Are you sure?\")'><span class='mdi mdi-delete-empty'></span></a>
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
										</div> -->

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

	<!-- Ekka Custom -->
	<script src="assets/js/ekka.js"></script>
	<script src="assets/js/manual.js"></script>


	<script>
		document.addEventListener("DOMContentLoaded", function() {
			const urlParams = new URLSearchParams(window.location.search);
			const activeTab = urlParams.get("tab");

			if (activeTab) {
				document.querySelectorAll(".tab-pane").forEach(tab => tab.classList.remove("show", "active"));
				document.querySelectorAll(".nav-link").forEach(tab => tab.classList.remove("active"));

				document.getElementById(activeTab + "detail")?.classList.add("show", "active");
				document.querySelector(`[data-bs-target="#${activeTab}detail"]`)?.classList.add("active");
			}
		});
	</script>

</body>

</html>
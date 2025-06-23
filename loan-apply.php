<?php

session_start();
ini_set('display_errors','off');
include("include/connection.php");
$leavesLoan = 'active';
$leave_boolean = 'true';
$leaveLoan_show = 'show';
$loan_apply = 'active';

$today = date('Y-m-d');

$employee_id = $_SESSION['id'];

if(isset($_POST['loan_submit'])){

	$id = $_POST['editId'];

    $loan_type = $_POST['loan_type'];
    $loan_amount = $_POST['loan_amount'];
    $repayment_months = $_POST['repayment_months'];
    $repayment_start = $_POST['repayment_start'];
    $reason = $_POST['reason'];
    $reference = $_POST['reference'];
    $created_at = date("Y-m-d H:i:s");

	$checkLoan = $conn->query("SELECT * FROM employee_loans WHERE employee_id = '$employee_id' AND status = 'approved' AND is_fully_paid = 0");
	if ($checkLoan->num_rows > 0) {
		echo "<script>alert('Not eligible. Your previous loan is still under repayment.'); window.history.back();</script>";
		exit;
	}

    $result = $conn->query("SELECT basic_salary,doj,advance_salary FROM employee WHERE id = $employee_id");
    $row = $result->fetch_assoc();
    $salary = $row['basic_salary'];
    $joining_date = $row['doj'];
	$advance_salary = $row['advance_salary'];

    $today = new DateTime();
    $joined = new DateTime($joining_date);
    $interval = $joined->diff($today);

    if ($interval->m + ($interval->y * 12) < 3) {
        echo "<script>alert('Not eligible. You must complete at least 3 months from your joining date to apply for a loan.'); window.history.back();</script>";
        exit;
    }

	if ($advance_salary > 0) {
		echo "<script>alert('Not eligible. You have already taken an advance salary of ₹$advance_salary.'); window.history.back();</script>";
		exit;
	}
    
    // if ($salary < 15000) {
    //     echo "<script>alert('Not eligible. Salary must be ₹15,000 or above.'); window.history.back();</script>";
    //     exit;
    // }
    
    // $max_loan = $salary * 4;
    // if ($loan_amount > $max_loan) {
    //     echo "<script>alert('Loan amount exceeds ₹$max_loan based on your salary.'); window.history.back();</script>";
    //     exit;
    // }

	$allowed_percentage = 60;
    $max_loan = ($salary * $allowed_percentage) / 100;

    if ($loan_amount > $max_loan) {
        echo "<script>alert('Loan amount exceeds ₹$max_loan (max {$allowed_percentage}% of your salary ₹$salary).'); window.history.back();</script>";
        exit;
    }
    
    $monthly_emi = round($loan_amount / $repayment_months, 2);

    if (!empty($_FILES['document']['name'])) {
        $upload_dir = "assets/img/loans/";
        $file_name = time() . "_" . basename($_FILES["document"]["name"]);
        $document_path = $upload_dir . $file_name;
        move_uploaded_file($_FILES["document"]["tmp_name"], $document_path);
    }

	if($id > 0){

		$updateSql = "UPDATE employee_loans SET loan_type='$loan_type', loan_amount='$loan_amount', repayment_months = '$repayment_months', monthly_emi = '$monthly_emi', repayment_start = '$repayment_start',reason = '$reason',reference_name = '$reference',document ='$document_path'  WHERE id='$id'";
		if($conn->query($updateSql) == TRUE){
			header('location: loan-apply.php?msg=Loan request Updated Successfully !&type=warning');
		}
	}else{

		$sql = "INSERT INTO employee_loans (employee_id, loan_type, loan_amount, repayment_months, monthly_emi, repayment_start, reason, reference_name, document, created_at) VALUES ('$employee_id', '$loan_type', '$loan_amount', '$repayment_months', '$monthly_emi', '$repayment_start', '$reason', '$reference', '$document_path', '$created_at')";
		$result = $conn->query($sql);
		if ($result == TRUE) {
			header('location: loan-apply.php?msg=Loan request submitted successfully !&type=success');
		} else {
			header('location: loan-apply.php?msg=Error submitting loan Please try again !&type=failed');
		}
	}
    
}

if(isset($_POST['delete_loan'])){
	$loan_id = $_POST['loan_id'];

	$dept_sql = "DELETE FROM employee_loans WHERE id='$loan_id'";
	if($conn->query($dept_sql)){
		header('location: loan-apply.php?msg=Loan request Successfully deleted!&type=failed');
	}
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="ekka - Admin Dashboard HTML Template.">

	<title>DD - Loan Apply</title>

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


	<!-- Data-Tables -->
	<link href='assets/plugins/data-tables/datatables.bootstrap5.min.css' rel='stylesheet'>
	<link href='assets/plugins/data-tables/responsive.datatables.min.css' rel='stylesheet'>

	<!-- PLUGINS CSS STYLE -->
	<link href="assets/plugins/simplebar/simplebar.css" rel="stylesheet" />

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
							<h1>Apply Loan</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Loan</p>
						</div>
                        <div  class="col-sm-10" style="text-align:end">
                    	    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" onclick="addLoan()">Request Loan</button>
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
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-modal="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="row ">
					            	<div class="col-12">
					            		<div class="card card-default">
					            			<div class="card-header card-header-border-bottom"><h2>Request Loan</h2></div>
					            			<div class="card-body">
					            				<div class="row ec-vendor-uploads">
					            					<div class="col-lg-12">
					            						<div class="ec-vendor-upload-detail">
                                                            <form id="createForm" method="post" enctype="multipart/form-data" class="row g-3 p-3">
                                                                <div class="col-md-6">
                                                                    <label for="loan_type" class="form-label">Loan Type<span class="text-danger">*</span></label>
                                                                    <select class="form-select" id="loan_type" name="loan_type" required>
                                                                        <option selected disabled value="">-- Select Loan Type --</option>
                                                                        <option value="personal">Personal Loan</option>
                                                                        <option value="medical">Medical Loan</option>
                                                                        <option value="festival">Festival Advance</option>
                                                                        <option value="emergency">Emergency Loan</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="loan_amount" class="form-label">Loan Amount (₹)<span class="text-danger">*</span></label>
                                                                    <input type="number" class="form-control" id="loan_amount" name="loan_amount" placeholder="Enter amount" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="repayment_months" class="form-label">Repayment Duration (Months)<span class="text-danger">*</span></label>
                                                                    <input type="number" class="form-control" id="repayment_months" name="repayment_months" placeholder="e.g. 12" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="repayment_start" class="form-label">Repayment Start Date<span class="text-danger">*</span></label>
                                                                    <input type="date" class="form-control" id="repayment_start" name="repayment_start" required>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label for="reason" class="form-label">Reason / Purpose<span class="text-danger">*</span></label>
                                                                    <textarea class="form-control" id="reason" name="reason" rows="3" placeholder="Explain the reason for the loan..." required></textarea>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="reference" class="form-label">Reference / Guarantor Name</label>
                                                                    <input type="text" class="form-control" id="reference" name="reference" placeholder="Optional">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="document" class="form-label">Upload Document (Optional)</label>
                                                                    <input type="file" class="form-control" id="document" name="document" accept=".pdf,.jpg,.jpeg,.png">
                                                                </div>
                                                                <div class="col-12 d-flex justify-content-end pt-3">
                                                                    <button type="reset" class="btn btn-secondary me-2">Clear</button>
                                                                    <button type="submit" name="loan_submit" id="loan_submit" class="btn btn-success">Submit Loan Application</button>
                                                                </div>
                                                            </form>
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

					<div class="row">
						<div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
							<div class="card card-mini dash-card card-1">
								<div class="card-body new-class">
									<h2 class="mb-1">10</h2>
									<p>Total Months</p>
									<span class="mdi mdi-calendar-multiple"></span>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
							<div class="card card-mini dash-card card-2">
								<div class="card-body new-class">
									<h2 class="mb-1">7</h2>
									<p>Completed Months</p>
									<span class="mdi mdi-check-decagram"></span>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
							<div class="card card-mini dash-card card-2">
								<div class="card-body new-class">
									<h2 class="mb-1">3</h2>
									<p>Pending Months</p>
									<span class="mdi mdi-calendar-alert"></span>
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
                                                            <th>Loan Type</th>
                                                            <th>Loan Amount (₹)</th>
                                                            <th>Repayment Duration</th>
                                                            <th>Reason</th>
                                                            <th>Guarantor Name</th>
                                                            <th>Document</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
														</tr>
													</thead>
													<tbody>
														<?php
														$sql = "SELECT * FROM employee_loans WHERE employee_id = '$employee_id' ORDER BY created_at DESC";
                                                        $result = $conn->query($sql);
                                                        $s = 1;
														while($row = mysqli_fetch_array($result)){
															?>
															<tr>
																<td><?= $s++; ?></td>
                                                                <td><?= ucfirst($row['loan_type']) ?></td>
                                                                <td>₹<?= number_format($row['loan_amount'], 2) ?></td>
                                                                <td><?= $row['repayment_months'] ?> months<br><small>₹<?= number_format($row['monthly_emi'], 2) ?>/month</small></td>
                                                                <td><?= nl2br($row['reason']) ?></td>
                                                                <td><?= $row['reference_name'] ?></td>
																<td>
                                                                    <?php if (!empty($row['document'])): ?>
                                                                        <a href="<?= $row['document'] ?>" target="_blank">View</a>
                                                                    <?php else: ?>
                                                                        ---
                                                                    <?php endif; ?>
                                                                </td>
																<td>
																	<?php
																	$statuses = [
																		'approved' => ['label' => 'Approved', 'class' => 'bg-success'],
																		'rejected' => ['label' => 'Rejected', 'class' => 'bg-danger', 'modal' => true],
																		'pending' => ['label' => 'Pending', 'class' => 'bg-primary']
																	];
																	$status = $row['status'] ?? 'pending';
																	$badge = $statuses[$status];

																	echo '<span class="badge ' . $badge['class'] . '">';
																	if (!empty($badge['modal'])) {
																		echo '<a href="#" style="color:#fff;" data-toggle="modal" data-target="#reasonModal' . $row['id'] . '">';
																	}
																	echo $badge['label'];
																	if (!empty($badge['modal'])) {
																		echo '</a>';
																	}
																	echo '</span>';
																	?>
																</td>
																<td>
                                                                    <?php if ($row['status'] == 'pending'): ?>
                                                                        <button type="button" data-toggle="modal" data-target="#edit<?= $row['id'];?>" onclick="loanEdit(<?= $row['id'];?>)"><span class="mdi mdi-pencil"></span></button>
                                                                        <button type="button" data-toggle="modal" data-target="#delete<?= $i; ?>"><span class="mdi mdi-delete-empty"></span></button>
                                                                        <!-- <a href="loan-apply.php?loanid=<?= $row['id']; ?>"><span class="mdi mdi-pencil"></span></a> -->
                                                                    <?php else: ?>
                                                                        ---
                                                                    <?php endif; ?>
                                                                    <!-- edit modal -->
                                                                    <div class="modal fade show" id="edit<?= $row['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-modal="true">
                                                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="row ">
                                                                                    <div class="col-12">
                                                                                        <div class="card card-default">
                                                                                            <div class="card-header card-header-border-bottom"><h2>Edit Request Loan</h2></div>
                                                                                            <div class="card-body">
                                                                                                <div class="row ec-vendor-uploads">
                                                                                                    <div class="col-lg-12">
                                                                                                        <div class="ec-vendor-upload-detail">
                                                                                                            <form method="post" id="edit_form<?= $row['id'];?>" enctype="multipart/form-data" class="row g-3 p-3">
                                                                                                                <div class="col-md-6">
                                                                                                                    <label for="loan_type" class="form-label">Loan Type<span class="text-danger">*</span></label>
                                                                                                                    <select class="form-select" id="loan_type<?= $row['id'];?>" name="loan_type" required>
                                                                                                                        <option selected disabled value="">-- Select Loan Type --</option>
                                                                                                                        <option value="personal" <?php if($row['loan_type'] == 'personal'){ echo "selected"; }?>>Personal Loan</option>
                                                                                                                        <option value="medical" <?php if($row['loan_type'] == 'medical'){ echo "selected"; }?>>Medical Loan</option>
                                                                                                                        <option value="festival" <?php if($row['loan_type'] == 'festival'){ echo "selected"; }?>>Festival Advance</option>
                                                                                                                        <option value="emergency" <?php if($row['loan_type'] == 'emergency'){ echo "selected"; }?>>Emergency Loan</option>
                                                                                                                    </select>
                                                                                                                </div>
                                                                                                                <div class="col-md-6">
                                                                                                                    <label for="loan_amount" class="form-label">Loan Amount (₹)<span class="text-danger">*</span></label>
                                                                                                                    <input type="number" class="form-control" id="loan_amount<?= $row['id'];?>" name="loan_amount" placeholder="Enter amount" value="<?= $row['loan_amount'];?>" required>
                                                                                                                </div>
                                                                                                                <div class="col-md-6">
                                                                                                                    <label for="repayment_months" class="form-label">Repayment Duration (Months)<span class="text-danger">*</span></label>
                                                                                                                    <input type="number" class="form-control" id="repayment_months<?= $row['id'];?>" name="repayment_months" placeholder="e.g. 12" value="<?= $row['repayment_months'];?>" required>
                                                                                                                </div>
                                                                                                                <div class="col-md-6">
                                                                                                                    <label for="repayment_start" class="form-label">Repayment Start Date<span class="text-danger">*</span></label>
                                                                                                                    <input type="date" class="form-control" id="repayment_start<?= $row['id'];?>" name="repayment_start" value="<?= $row['repayment_start'];?>" required>
                                                                                                                </div>
                                                                                                                <div class="col-md-12">
                                                                                                                    <label for="reason" class="form-label">Reason / Purpose<span class="text-danger">*</span></label>
                                                                                                                    <textarea class="form-control" id="reason<?= $row['id'];?>" name="reason" rows="3" placeholder="Explain the reason for the loan..." required><?= $row['reason'];?></textarea>
                                                                                                                </div>
                                                                                                                <div class="col-md-6">
                                                                                                                    <label for="reference" class="form-label">Reference / Guarantor Name</label>
                                                                                                                    <input type="text" class="form-control" id="reference" name="reference" placeholder="Optional" value="<?= $row['reference_name'];?>">
                                                                                                                </div>
                                                                                                                <div class="col-md-6">
                                                                                                                    <label for="document" class="form-label">Upload Document (Optional)</label>
                                                                                                                    <input type="file" class="form-control" id="document" name="document" accept=".pdf,.jpg,.jpeg,.png">
                                                                                                                </div>
                                                                                                                <input type="hidden" name="editId" id="editId" value="<?= $row['id'];?>">
                                                                                                                <div class="modal-footer px-4">
                                                                                                                    <button type="submit" name="loan_submit" id="loan_submit<?= $row['id'];?>" class="btn btn-primary" onclick = "editLoan(<?= $row['id'];?>)">Submit</button>
                                                                                                                </div>
                                                                                                            </form>
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

                                                                    <!-- delete modal -->
                                                                    <div class="modal fade" id="delete<?= $i; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteLoanTitle" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                                            <div class="modal-content">
                                                                                <form method="post">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="deleteLoanTitle">Delete Loan Request</h5>
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <p class="modal-text">
                                                                                            Are you sure you want to delete the <strong><?= ucfirst($row['loan_type']); ?> Loan</strong> request of ₹<strong><?= number_format($row['loan_amount'], 2); ?></strong>?
                                                                                        </p>
                                                                                        <input type="hidden" name="loan_id" value="<?= $row['id']; ?>">
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                                                        <button type="submit" name="delete_loan" class="btn btn-danger">Yes, Delete</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
															</tr>


															<!-- reject reason showing modal -->
															<?php if ($status === 'rejected'): ?>
															<div class="modal fade" id="reasonModal<?= $row['id']; ?>" tabindex="-1" aria-labelledby="reasonModalLabel<?= $row['id']; ?>" aria-hidden="true">
																<div class="modal-dialog modal-dialog-centered">
																	<div class="modal-content">
																		<div class="modal-header">
																			<h5 class="modal-title">Rejection Reason</h5>
																			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
																		</div>
																		<div class="modal-body">
																			<?= !empty($row['reject_reason']) ? nl2br(htmlspecialchars($row['reject_reason'])) : "No reason provided."; ?>
																		</div>
																	</div>
																</div>
															</div>
															<?php endif; ?>
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

	<!-- ekka Custom -->
	<script src="assets/js/ekka.js"></script>
	<script src="assets/js/manual.js"></script>
</body>

</html>

<script>

    function addLoan(){
		$('#createForm')[0].reset();
	}

    $('#loan_submit').click(function(){
		
		var loan_type = document.getElementById('loan_type')
		var loan_amount = document.getElementById('loan_amount')
		var repayment_months = document.getElementById('repayment_months')
		var repayment_start = document.getElementById('repayment_start')
		var reason = document.getElementById('reason')
		
		if(loan_type.value == ""){
			$('#loan_type').addClass('check-border');
		} else{
			$('#loan_type').removeClass('check-border');
		}
		if(loan_amount.value == ""){
			$('#loan_amount').addClass('check-border');
		} else{
			$('#loan_amount').removeClass('check-border');
		}
        if(repayment_months.value == ""){
			$('#repayment_months').addClass('check-border');
		} else{
			$('#repayment_months').removeClass('check-border');
		}
        if(repayment_start.value == ""){
			$('#repayment_start').addClass('check-border');
		} else{
			$('#repayment_start').removeClass('check-border');
		}
        if(reason.value == ""){
			$('#reason').addClass('check-border');
		} else{
			$('#reason').removeClass('check-border');
		}
	});

	function editLoan(val){

        var loan_type = document.getElementById('loan_type'+val)
		var loan_amount = document.getElementById('loan_amount'+val)
		var repayment_months = document.getElementById('repayment_months'+val)
		var repayment_start = document.getElementById('repayment_start'+val)
		var reason = document.getElementById('reason'+val)

        if(loan_type.value == ""){
			$('#loan_type'+val).addClass('check-border');
		} else{
			$('#loan_type'+val).removeClass('check-border');
		}
		if(loan_amount.value == ""){
			$('#loan_amount'+val).addClass('check-border');
		} else{
			$('#loan_amount'+val).removeClass('check-border');
		}
        if(repayment_months.value == ""){
			$('#repayment_months'+val).addClass('check-border');
		} else{
			$('#repayment_months'+val).removeClass('check-border');
		}
        if(repayment_start.value == ""){
			$('#repayment_start'+val).addClass('check-border');
		} else{
			$('#repayment_start'+val).removeClass('check-border');
		}
        if(reason.value == ""){
			$('#reason'+val).addClass('check-border');
		} else{
			$('#reason'+val).removeClass('check-border');
		}
	}

</script>
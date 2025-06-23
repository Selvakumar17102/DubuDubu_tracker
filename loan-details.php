<?php
session_start();
ini_set('display_errors','off');
include("include/connection.php");
$leavesLoan = 'active';
$leave_boolean = 'true';
$leaveLoan_show = 'show';
$loan_details = 'active';

$emp_id = $_SESSION['id'];

if (isset($_POST['accept'])) {
    $loan_id = $_POST['accept'];
    $conn->query("UPDATE employee_loans SET status='approved' WHERE id='$loan_id'");
    header("Location: loan-details.php?msg=Loan Approved&type=success");
    exit;
}

if (isset($_POST['reject_loan'])) {
    $loan_id = $_POST['reject_id'];
    $reason = $_POST['reason'];
    $conn->query("UPDATE employee_loans SET status='rejected', reject_reason='$reason' WHERE id='$loan_id'");
    header("Location: loan-details.php?msg=Loan Rejected&type=danger");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="ekka - Admin Dashboard HTML Template.">

	<title>DD - Loan Details</title>

	<!-- GOOGLE FONTS -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

	<link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />

	<!-- PLUGINS CSS STYLE -->
	<link href="assets/plugins/simplebar/simplebar.css" rel="stylesheet" />

	<!-- No Extra plugin used -->

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
							<h1>Loan Details</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
							<span><i class="mdi mdi-chevron-right"></i></span>Loan Details</p>
						</div>
					</div>
					<div class="row">
                        <div class="col-xl">
                            <div id="user-acquisition" class="card card-default">
                                <div class="card-header">
                                    <h2 style="text-align: center">Loan List</h2>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="responsive-data-table" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Employee Name</th>
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
                                                $loan_sql = "SELECT a.*, b.fname, b.lname FROM employee_loans a 
                                                            LEFT JOIN employee b ON b.id = a.employee_id 
                                                            WHERE a.employee_id != '$emp_id'";
                                                $loan_result = $conn->query($loan_sql);
                                                $s = 1;
                                                while($row = mysqli_fetch_assoc($loan_result)) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $s++; ?></td>
                                                        <td><?= $row['fname'] . ' ' . $row['lname']; ?><br>
                                                        <b>Applied Date :</b><small><?= date("d-m-Y", strtotime($row['created_at'])); ?></small></td>
                                                        <td><?= ucfirst($row['loan_type']); ?></td>
                                                        <td>₹<?= number_format($row['loan_amount'], 2); ?></td>
                                                        <td><?= $row['repayment_months']; ?> months<br><small>₹<?= number_format($row['monthly_emi'], 2); ?>/month</small></td>
                                                        <td><?= nl2br($row['reason']); ?></td>
                                                        <td><?= $row['reference_name']; ?></td>
                                                        <td>
                                                            <?php if (!empty($row['document'])): ?>
                                                                <a href="<?= $row['document']; ?>" target="_blank">View</a>
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
                                                                echo '<a href="#" style="color:#fff;" data-bs-toggle="modal" data-bs-target="#reasonModal' . $row['id'] . '">';
                                                            }
                                                            echo $badge['label'];
                                                            if (!empty($badge['modal'])) {
                                                                echo '</a>';
                                                            }
                                                            echo '</span>';
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($status === 'pending'): ?>
                                                                <form method="post" class="d-inline">
                                                                    <button type="submit" name="accept" value="<?= $row['id']; ?>"><span class="mdi mdi-checkbox-marked-circle"></span></button>
                                                                </form>
                                                                <button type="button" data-bs-toggle="modal" data-bs-target="#rejectModal<?= $row['id']; ?>"><span class="mdi mdi-close-circle"></span></button>
                                                            <?php else: ?>
                                                                ---
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>

                                                    <!-- Modal for rejection reason -->
                                                    <div class="modal fade" id="rejectModal<?= $row['id']; ?>" tabindex="-1" aria-labelledby="rejectModalLabel<?= $row['id']; ?>" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form method="post">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Reject Loan Request</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="reject_id" value="<?= $row['id']; ?>">
                                                                        <label for="reason">Reason:</label>
                                                                        <textarea name="reason" class="form-control" required></textarea>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                        <button type="submit" name="reject_loan" class="btn btn-danger">Reject</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

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
	// function rejectStatus(val){
	// 	$('#leave-id').val(val);
	// }

	// function rejectReason(val){
	// 	var reason = $('#rejectPopup'+val).val();
	// 	$('#rejectReason').val(reason);
	// }
</script>
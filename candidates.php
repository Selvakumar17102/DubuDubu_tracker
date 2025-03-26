<?php
session_start();
ini_set("display_errors",'off');
include("include/connection.php");

$recruitment = 'active';
$recruitment_boolean = 'true';
$recruitment_show = 'show';
$candidate_page = 'active';

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Ekka - Admin Dashboard HTML Template.">

	<title>DUBU DUBU - Candidates</title>

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
<style>
	.image{
		background-color: #f3f3f3;
		border-radius: 2px;
		padding: 5px 0;
	}

    .modal .modal-content {
        border-radius: 0px !important;
    }

    .modal.right .modal-dialog {
        position: fixed;
        margin: auto;
        width: 50%;
        height: 100%;
        right: 0;
        transform: translateX(100%);
        transition: transform 0.4s ease-in-out;
    }

    .modal.right.show .modal-dialog {
        transform: translateX(0);
    }

    .modal-content {
        height: 100%;
        border-radius: 0;
        overflow-y: auto;
    }

	/* .card-default .card-header {
		padding: 10px;
	}
	.card-default .card-body {
		padding: 10px;
	} */

	.bg-orange {
		background-color: #fd7e14 !important; /* Bootstrap's Orange */
		color: white !important;
	}

	

</style>

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
			<div class="ec-content-wrapper ec-vendor-wrapper">
				<div class="content">
					<div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
						<div>
							<h1>Candidates Card</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span><span><i class="mdi mdi-chevron-right"></i></span> Candidates</p>
						</div>
					</div>

					<div class="card card-default p-4 ec-card-space">
						<div class="ec-vendor-card mt-m-24px row">
                            <?php
                            $sql = "SELECT *,a.id as applicant_id FROM job_applications a LEFT JOIN job_posts b ON a.job_id = b.id ORDER BY a.created_at ASC";
                            $result = $conn->query($sql);
							if($result->num_rows){
                            while($row = mysqli_fetch_array($result)){
                            ?>
							<div class="col-lg-6 col-xl-4 col-xxl-3">
								<div class="card card-default mt-24px">
                                    
									<div class="vendor-info card-body text-center p-3">
										<a href="javascript:0" class="row ec-vendor-detail ">
											<div class="image mb-3">
												<a href="javascript:0" data-bs-toggle="modal" data-bs-target="#modal-viewjob-<?= $row['applicant_id']; ?>">
													<h5 class="card-title text-dark"><?= $row['name'];?></h5>
												</a>
												<span class="badge bg-light text-dark fw-semibold">Cand-<?= $row['applicant_id']; ?></span><br>
												<small><?= $row['email'];?></small>
											</div>
											<ul class="list-unstyled text-start">
												<li class="d-flex justify-content-between">
													<small><b>Applied Role</b></small>
													<small><span class="text-dark"><?= $row['job_title']; ?></span></small>
												</li>
												<li class="d-flex justify-content-between">
													<small><b>Applied Date</b></small>
													<small><span class="text-dark"><?= date("d M Y", strtotime($row['created_at'])); ?></span></small>
												</li>
												<li class="d-flex justify-content-between">
													<small><b>Status</b></small>
													<?php
													$statusColors = [
														'New' => 'bg-purple',
														'Scheduled' => 'bg-primary',
														'Stage 1' => 'bg-info',
														'Stage 2' => 'bg-warning',
														'Stage 3' => 'bg-orange',
														'Hired' => 'bg-success',
														'Rejected' => 'bg-danger',
														'Offer Rejected' => 'bg-secondary'
													];

													$statusColor = $statusColors[$row['candidate_status']] ?? 'bg-dark'; // Default to 'bg-dark' if status not found
													?>
													<small><span class="badge <?= $statusColor; ?> text-white"><?= $row['candidate_status']; ?></span></small>

												</li>
											</ul>
										</a>
									</div>
								</div>
							</div>

							<div class="modal fade right" id="modal-viewjob-<?= $row['applicant_id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog modal-dialog-slideout modal-xl" role="document">
									<div class="modal-content">
										<div class="modal-header border-bottom-1">
											<h5>Candidate Details <span class="badge bg-light text-dark fw-semibold">Cand-<?= $row['applicant_id']; ?></span></h5>
										</div>
										<div class="modal-body p-5">
											<div class="card card-default p-3">
												<div class="row">
													<div class="col-md-5">
														<p class="mb-1 text-muted"><strong>Candidate Name</strong></p>
														<p class="mb-3"><?= $row['name'];?></p>
														<p class="mb-1 text-muted"><strong>Email</strong></p>
														<p class="mb-3"><?= $row['email'];?></p>
													</div>
													<div class="col-md-4">
														<p class="mb-1 text-muted"><strong>Applied Role</strong></p>
														<p class="mb-3"><?= $row['job_title'];?></p>
														<p class="mb-1 text-muted"><strong>Recruiter</strong></p>
														<p class="mb-3">---</p>
													</div>
													<div class="col-md-3">
														<p class="mb-1 text-muted"><strong>Applied Date</strong></p>
														<p class="mb-3"><?= date('d-m-Y',strtotime($row['created_at']));?></p>
														<p class="mb-1 text-muted"><strong>Status</strong></p>
														<span class="badge <?= $statusColor; ?>"><?= $row['candidate_status']; ?></span>
													</div>
												</div>
											</div>
											<div class="card-header card-header-border-bottom">
												<ul class="nav nav-tabs" id="myRatingTab" role="tablist">
													<li class="nav-item">
														<a class="nav-link tab-link active" id="product-detail-tab" data-bs-toggle="tab" data-bs-target="#profiledetail<?= $row['applicant_id'];?>" href="#profiledetail<?= $row['applicant_id'];?>" role="tab" aria-selected="true">
															<i class="mdi mdi-account-circle mr-1"></i>Profile</a>
													</li>
													<li class="nav-item">
														<a class="nav-link tab-link" id="product-information-tab" data-bs-toggle="tab" data-bs-target="#pipelinedetail<?= $row['applicant_id'];?>" href="#pipelinedetail<?= $row['applicant_id'];?>" role="tab" aria-selected="false">
															<i class="mdi mdi-information mr-1"></i>Hiring Pipeline</a>
													</li>
												</ul>
											</div>
											<div class="card-body">
												<div class="tab-content" id="myTabContent2">
													<div class="tab-pane fade show active" id="profiledetail<?= $row['applicant_id'];?>" role="tabpanel">
														<div class="p-4 border rounded bg-white">
															<h5 class="mb-3"><strong>Personal Information</strong></h5>
															<div class="row border-top pt-3">
																<div class="col-md-4">
																	<p class="mb-1 text-muted"><strong>Candidate Name</strong></p>
																	<p class="mb-3"><?= $row['name'];?></p>
																</div>
																<div class="col-md-5">
																	<p class="mb-1 text-muted"><strong>Email</strong></p>
																	<p class="mb-3"><?= $row['email'];?></p>
																</div>
																<div class="col-md-3">
																	<p class="mb-1 text-muted"><strong>Phone</strong></p>
																	<p class="mb-3"><?= $row['phone'];?></p>
																</div>
															</div>
														</div>
														<div class="p-4 border rounded bg-white">
															<h5 class="mb-3"><strong>Resume</strong></h5>
															<div class="d-flex align-items-center justify-content-between border-top pt-3">
																<div class="d-flex align-items-center">
																	<div class="p-3 bg-light rounded">
																		<i class="mdi mdi-file mdi-24px text-secondary"></i>
																	</div>
																	<div class="ms-3">
																		<a href="https://hrm.dubudubutechnologies.com/<?= str_replace("hrm/", "", $row['resume']); ?>" class="text-dark fw-bold">Resume</a>
																		<div class="text-muted">120 KB</div>
																	</div>
																</div>
																<a href="https://hrm.dubudubutechnologies.com/<?= str_replace("hrm/", "", $row['resume']); ?>" target="_blank" download class="btn btn-primary d-flex align-items-center"><i class="mdi mdi-download me-2"></i> Download</a>
															</div>
														</div>
													</div>
													<div class="tab-pane pt-3 fade" id="pipelinedetail<?= $row['applicant_id'];?>" role="tabpanel">
														<div class="row ec-vendor-uploads">
															<div class="p-4 border rounded bg-white">
																<h5 class="mb-3"><strong>Candidate Pipeline Stage</strong></h5>
																<?php
																$currentStatus = $row['candidate_status'];

																$statusSteps = [
																	'New' => 'bg-purple text-white',
																	'Scheduled' => 'bg-primary text-white',
																	'Stage 1' => 'bg-info text-white',
																	'Stage 2' => 'bg-warning text-white',
																	'Stage 3' => 'bg-orange text-white',
																	'Hired' => 'bg-success text-white',
																	'Rejected' => 'bg-danger text-white',
																	'Offer Rejected' => 'bg-secondary text-white'
																];
																?>

																<div class="row flex-wrap gx-2">
																	<div class="col-auto px-3 py-2 rounded-start text-center <?= ($currentStatus == 'New') ? $statusSteps['New'] : 'bg-light border' ?>">New</div>
																	<div class="col-auto px-3 py-2 text-center <?= ($currentStatus == 'Scheduled') ? $statusSteps['Scheduled'] : 'bg-light border' ?>">Scheduled</div>
																	<div class="col-auto px-3 py-2 text-center bg-light border">
																		<select class="form-select form-select-sm w-100">
																			<option value="Stage 1" <?= ($currentStatus == 'Stage 1') ? 'selected' : '' ?>>Stage 1</option>
																			<option value="Stage 2" <?= ($currentStatus == 'Stage 2') ? 'selected' : '' ?>>Stage 2</option>
																			<option value="Stage 3" <?= ($currentStatus == 'Stage 3') ? 'selected' : '' ?>>Stage 3</option>
																		</select>
																	</div>
																	<div class="col-auto px-3 py-2 text-center <?= ($currentStatus == 'Hired') ? $statusSteps['Hired'] : 'bg-light border' ?>">Hired</div>
																	<div class="col-auto px-3 py-2 text-center <?= ($currentStatus == 'Rejected') ? $statusSteps['Rejected'] : 'bg-light border' ?>">Rejected</div>
																	<div class="col-auto px-3 py-2 text-center rounded-end <?= ($currentStatus == 'Offer Rejected') ? $statusSteps['Offer Rejected'] : 'bg-light border' ?>">Offer Rejected</div>
																</div>

															</div>

															<div class="modal-footer px-4">
																<button type="button" class="btn btn-secondary btn-pill" data-bs-dismiss="modal">Cancel</button>
																<button type="button" class="btn btn-primary btn-pill move-to-stage-btn" data-candidate-id="<?= $row['applicant_id']; ?>">Move to Next Stage</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
                            <?php
                            }
							}else{
								?>
								<img src="https://i.pinimg.com/736x/49/e5/8d/49e58d5922019b8ec4642a2e2b9291c2.jpg" alt="" 	>
								<?php
							}
                            ?>
						</div>
					</div>
				</div> <!-- End Content -->
			</div><!-- End Content Wrapper -->

			<!-- New Modal for Selecting Status -->
			<div class="modal fade" id="nextStageModal" tabindex="-1" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Select Next Stage</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
						</div>
						<div class="modal-body">
							<label for="candidateStatusSelect">Choose New Status:</label>
							<select id="candidateStatusSelect" class="form-select">
								<option value="">Choose Status</option>
								<option value="New">New</option>
								<option value="Scheduled">Scheduled</option>
								<option value="Stage 1">Stage 1</option>
								<option value="Stage 2">Stage 2</option>
								<option value="Stage 3">Stage 3</option>
								<option value="Hired">Hired</option>
								<option value="Rejected">Rejected</option>
								<option value="Offer Rejected">Offer Rejected</option>
							</select>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
							<button type="button" class="btn btn-primary" id="updateStatusBtn">Submit</button>
						</div>
					</div>
				</div>
			</div>

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

	<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".move-to-stage-btn").forEach(button => {
        button.addEventListener("click", function() {
            let candidateId = this.getAttribute("data-candidate-id");
            document.getElementById("nextStageModal").setAttribute("data-candidate-id", candidateId);
            let modal = new bootstrap.Modal(document.getElementById("nextStageModal"));
            modal.show();
        });
    });

    document.getElementById("updateStatusBtn").addEventListener("click", function() {
        let candidateId = document.getElementById("nextStageModal").getAttribute("data-candidate-id");
        let newStatus = document.getElementById("candidateStatusSelect").value;

        fetch("candidate_update_status.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `candidate_id=${candidateId}&status=${newStatus}`
        }).then(response => response.json()).then(data => {
            if (data.success) {
                alert("Status updated successfully!");
                location.reload();
            } else {
                alert("Failed to update status.");
            }
        });
    });
});
</script>
</body>
</html>
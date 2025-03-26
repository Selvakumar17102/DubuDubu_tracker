<?php
session_start();
ini_set("display_errors",'off');
include("include/connection.php");

$recruitment = 'active';
$recruitment_boolean = 'true';
$recruitment_show = 'show';
$job_page = 'active';

if(isset($_POST['jobsubmit'])){
	$jobid = $_POST['jobid'];

    $job_title = $_POST['job_title'];
    $job_description = $_POST['job_description'];
    $job_category = $_POST['job_category'];
    $job_type = $_POST['job_type'];
    $job_level = $_POST['job_level'];
    $experience = $_POST['experience'];
    $qualification = $_POST['qualification'];
    $gender = $_POST['gender'];
    $min_salary = $_POST['min_salary'];
    $max_salary = $_POST['max_salary'];
    $job_expired_date = $_POST['job_expired_date'];
    $required_skills = $_POST['required_skills'] ?? null;
    $no_of_applicant = $_POST['no_of_applicant'];
    $shift_time = $_POST['shift_time'];

    $address = $_POST['address'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $zip_code = $_POST['zip_code'];
    
	if($jobid){
		$sql = "UPDATE job_posts SET job_title = '$job_title', job_description = '$job_description', job_category = '$job_category', job_type = '$job_type', job_level = '$job_level', experience = '$experience', qualification = '$qualification', gender = '$gender', min_salary = '$min_salary', max_salary = '$max_salary', job_expired_date = '$job_expired_date', required_skills = '$required_skills', no_of_applicant = '$no_of_applicant', shift_time = '$shift_time', address = '$address', country = '$country', state = '$state', city = '$city', zip_code = '$zip_code' WHERE id = '$jobid'";
        if($conn->query($sql) === TRUE){
            header('location:jobs.php?msg=Job Updated!&type=warning');
        }
	}else{
		$sql = "INSERT INTO job_posts (job_title, job_description, job_category, job_type, job_level, experience, qualification, gender, min_salary, max_salary, job_expired_date, required_skills, no_of_applicant, shift_time, address, country, state, city, zip_code) VALUES ('$job_title', '$job_description', '$job_category', '$job_type', '$job_level', '$experience', '$qualification', '$gender', '$min_salary', '$max_salary', '$job_expired_date', '$required_skills', '$no_of_applicant', '$shift_time', '$address', '$country', '$state', '$city', '$zip_code')";
		if($conn->query($sql) === TRUE){
			header('location:jobs.php?msg=Jobs Added!&type=success');
		}
	}
}

if(isset($_POST['delete'])){
	$job_id = $_POST['job_id'];

	$dept_sql = "DELETE FROM job_posts WHERE id='$job_id'";
	if($conn->query($dept_sql)){
		header('location: jobs.php?msg=Jobs Successfully deleted!&type=danger');
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

	<title>DUBU DUBU - Jobs</title>

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
    .ec-vendor-card .card-default .view-detail1 {
        position: absolute;
        top: 6px;
        right: 50px;
        font-size: 20px;
        color: #bbb;
    }
    .ec-vendor-card .card-default .view-detail1:hover {
        color: #326be6;
    }

    .ec-vendor-card .card-default .view-detail2 {
        position: absolute;
        top: 6px;
        right: 80px;
        font-size: 20px;
        color: #bbb;
    }
    .ec-vendor-card .card-default .view-detail2:hover {
        color: #326be6;
    }

	.image{
		background-color: #f3f3f3;
		border-radius: 8px;
		padding: 10px 0;
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
							<h1>Jobs Card</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span><span><i class="mdi mdi-chevron-right"></i></span> Jobs</p>
						</div>
						<div>
							<button type="button" class="btn btn-primary" data-bs-toggle="modal"data-bs-target="#modal-add-member"><i class="mdi mdi-plus me-2"></i>Post Job</button>
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
					}elseif($_GET['type'] == 'danger'){
						?>
						<div class="alert alert-danger text-center" role="alert" id="alert_msg">
							<?php echo $_REQUEST['msg']; ?>
						</div>
					<?php
					}
					?>

					<div class="card card-default p-4 ec-card-space">
						<div class="ec-vendor-card mt-m-24px row">
                            <?php
                            $sql = "SELECT * FROM job_posts ORDER BY created_at DESC";
                            $result = $conn->query($sql);
							if($result->num_rows){
                            while($row = mysqli_fetch_array($result)){
								$jobid = $row['id'];
								$query = "SELECT COUNT(*) AS applicant_count FROM job_applications WHERE job_id = '$jobid'";
								$applicantResult = $conn->query($query);
								$applicantRow = mysqli_fetch_assoc($applicantResult);
								$applicantCount = $applicantRow['applicant_count'];

								$query1 = "SELECT COUNT(*) AS hired_count FROM job_applications WHERE job_id = '$jobid' AND candidate_status = 'Hired'";
								$applicantResult1 = $conn->query($query1);
								$applicantRow1 = mysqli_fetch_assoc($applicantResult1);
								$hiredCount = $applicantRow1['hired_count'];
                            ?>
							<div class="col-lg-6 col-xl-4 col-xxl-3">
								<div class="card card-default mt-24px">
                                    <a href="javascript:0" data-bs-toggle="modal" data-bs-target="#modal-deletejob-<?= $row['id']; ?>" class="view-detail2"><i class="mdi mdi-delete-circle-outline"></i></a>
                                    <a href="javascript:0" data-bs-toggle="modal" data-bs-target="#modal-editjob-<?= $row['id']; ?>" class="view-detail1"><i class="mdi mdi-circle-edit-outline"></i></a>
                                    <a href="javascript:0" data-bs-toggle="modal" data-bs-target="#modal-viewjob-<?= $row['id']; ?>" class="view-detail"><i class="mdi mdi-eye-plus-outline"></i></a>
									<div class="vendor-info card-body text-center p-4">
										<a href="javascript:0" class="row justify-content-center ec-vendor-detail mt-3">
											<div class="image mb-3">
												<h5 class="card-title text-dark"><?= $row['job_title'];?></h5>
												<p><?= $applicantCount; ?> Applicant</p>
											</div>
											<ul class="list-unstyled">
												<li class="d-flex mb-3">
													<i class="mdi mdi-map-marker"></i>&nbsp;
													<span> <?= $row['city'] . ', ' . $row['state'] . ' ' . $row['zip_code']; ?></span>
												</li>
												<li class="d-flex mb-3">
													<i class="mdi mdi-currency-inr"></i>&nbsp;
													<span> <?= $row['min_salary'] . ' - ' . $row['max_salary']; ?> / month</span>
												</li>
												<li class="d-flex mb-3">
													<i class="mdi mdi-briefcase"></i>&nbsp;
													<span> <?= $row['experience']; ?></span>
												</li>
											</ul>
										</a>
										<div class="row justify-content-center ec-vendor-detail mt-3">
											<progress id="progressBar" value="<?= $hiredCount;?>" max="<?= $row['no_of_applicant'];?>"></progress>
											<p><?= $hiredCount;?> of <?= $row['no_of_applicant'];?> filled</p>
										</div>
									</div>
								</div>
							</div>

							<!-- view job -->
							<div class="modal fade" id="modal-viewjob-<?= $row['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
									<div class="modal-content">
										<div class="modal-header justify-content-end border-bottom-0">
											<button type="button" class="btn-close-icon" data-bs-dismiss="modal" aria-label="Close"><i class="mdi mdi-close"></i></button>
										</div>
										<div class="modal-body pt-0">
											<div class="row no-gutters">
												<div class="col-md-6">
													<div class="profile-content-left px-4">
														<div class="text-center widget-profile px-0 border-0">
															<div class="card-body">
																<h4 class="py-2 text-dark"><?= $row['job_title'];?></h4>
																<ul class="list-unstyled">
																	<li class="d-flex mb-3">
																		<span><b>Job Category : </b> <?= $row['job_category']; ?></span>
																	</li>
																	<li class="d-flex mb-3">
																		<span><b>Job Type : </b> <?= $row['job_type']; ?></span>
																	</li>
																	<li class="d-flex mb-3">
																		<span><b>Job Level : </b> <?= $row['job_level']; ?></span>
																	</li>
																	<li class="d-flex mb-3">
																		<span><b>Qualification : </b> <?= $row['qualification']; ?></span>
																	</li>
																	<li class="d-flex mb-3">
																		<span><b>Gender : </b><?= $row['gender']; ?></span>
																	</li>
																	<li class="d-flex mb-3">
																		<span><b>Salary : </b> <?= $row['min_salary'] . ' - ' . $row['max_salary']; ?> / month</span>
																	</li>
																	<li class="d-flex mb-3">
																		<span><b>Experience : </b> <?= $row['experience']; ?></span>
																	</li>
																	<li class="d-flex mb-3">
																		<b>Description : </b><details><?= $row['job_description']; ?></details>
																	</li>
																</ul>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="card-body">
														<ul class="list-unstyled">
															<li class="d-flex mb-3">
																<span><b>Job Expired Date : </b> <?= $row['job_expired_date']; ?></span>
															</li>
															<li class="d-flex mb-3">
																<span><b>No of Opening : </b> <?= $row['no_of_applicant']; ?></span>
															</li>
															<li class="d-flex mb-3">
																<span><b>Shift Timing : </b> <?= $row['shift_time']; ?></span>
															</li>
															<li class="d-flex mb-3">
																<span><b>Required Skills : </b> <?= $row['required_skills']; ?></span>
															</li>
															<li class="d-flex mb-3">
																<span><b>Address : </b><?= $row['address']; ?></span>
															</li>
															<li class="d-flex mb-3">
																<span><b>Country : </b> <?= $row['country']; ?></span>
															</li>
															<li class="d-flex mb-3">
																<span><b>State : </b> <?= $row['state']; ?></span>
															</li>
															<li class="d-flex mb-3">
																<span><b>City : </b> <?= $row['city']; ?></span>
															</li>
															<li class="d-flex mb-3">
																<span><b>Zip code : </b> <?= $row['zip_code']; ?></span>
															</li>
														</ul>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<!-- edit job -->
							<div class="modal fade" id="modal-editjob-<?= $row['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
									<div class="modal-content">
										<form method="POST" enctype="multipart/form-data">
											<div class="modal-header border-bottom-1">
												<h5>Job Post</h5>
											</div>

											<div class="modal-body p-5">
												<div class="col-md-12">
													<h5 class="mb-3">Basic Information</h5>
													<div class="mb-3">
														<label class="form-label">Job Title <span class="text-danger">*</span></label>
														<input type="text" class="form-control" name="job_title" id="job_title" value="<?= $row['job_title']; ?>" placeholder = "Job Title" required>
													</div>
													<div class="mb-3">
														<label class="form-label">Job Description <span class="text-danger">*</span></label>
														<textarea class="form-control" name="job_description" id="job_description" rows="2" placeholder = "Job Description" required><?= $row['job_description']; ?></textarea>
													</div>
													<div class="row">
														<div class="col-md-6">
															<label class="form-label">Job Category <span class="text-danger">*</span></label>
															<select class="form-select" name="job_category" id="job_category" required>
																<option disabled>Select</option>
																<option value="Information Technology (IT)" <?= ($row['job_category'] == 'Information Technology (IT)') ? 'selected' : ''; ?>>Information Technology (IT)</option>
																<option value="Finance & Accounting" <?= ($row['job_category'] == 'Finance & Accounting') ? 'selected' : ''; ?>>Finance & Accounting</option>
																<option value="Customer Service" <?= ($row['job_category'] == 'Customer Service') ? 'selected' : ''; ?>>Customer Service</option>
																<option value="Creative & Design" <?= ($row['job_category'] == 'Creative & Design') ? 'selected' : ''; ?>>Creative & Design</option>
																<option value="Human Resources (HR)" <?= ($row['job_category'] == 'Human Resources (HR)') ? 'selected' : ''; ?>>Human Resources (HR)</option>
																<option value="Data Entry Operator" <?= ($row['job_category'] == 'Data Entry Operator') ? 'selected' : ''; ?>>Data Entry Operator</option>
																<option value="Voice Process" <?= ($row['job_category'] == 'Voice Process') ? 'selected' : ''; ?>>Voice Process</option>
															</select>
														</div>
														<div class="col-md-6">
															<label class="form-label">Job Type <span class="text-danger">*</span></label>
															<select class="form-select" name="job_type" id="job_type" required>
																<option disabled>Select</option>
																<option value="Full-Time" <?= ($row['job_type'] == 'Full-Time') ? 'selected' : ''; ?>>Full-Time</option>
																<option value="Part-Time" <?= ($row['job_type'] == 'Part-Time') ? 'selected' : ''; ?>>Part-Time</option>
																<option value="Contract" <?= ($row['job_type'] == 'Contract') ? 'selected' : ''; ?>>Contract</option>
															</select>

														</div>
														<div class="col-md-6">
															<label class="form-label">Job Level <span class="text-danger">*</span></label>
															<select class="form-select" name="job_level" id="job_level" required>
																<option disabled>Select</option>
																<option value="Entry" <?= ($row['job_level'] == 'Entry') ? 'selected' : ''; ?>>Entry</option>
																<option value="Mid" <?= ($row['job_level'] == 'Mid') ? 'selected' : ''; ?>>Mid</option>
																<option value="Senior" <?= ($row['job_level'] == 'Senior') ? 'selected' : ''; ?>>Senior</option>
															</select>
														</div>
														<div class="col-md-6">
															<label class="form-label">Experience <span class="text-danger">*</span></label>
															<select class="form-select" name="experience" id="experience" required>
																<option disabled>Select</option>
																<option value="0-1 Years" <?= ($row['experience'] == '0-1 Years') ? 'selected' : ''; ?>>0-1 Years</option>
																<option value="2-5 Years" <?= ($row['experience'] == '2-5 Years') ? 'selected' : ''; ?>>2-5 Years</option>
																<option value="5+ Years" <?= ($row['experience'] == '5+ Years') ? 'selected' : ''; ?>>5+ Years</option>
															</select>
														</div>
														<div class="col-md-6">
															<label class="form-label">Qualification <span class="text-danger">*</span></label>
															<select class="form-select" name="qualification" id="qualification" required>
																<option disabled>Select</option>
																<option value="Bachelors" <?= ($row['qualification'] == 'Bachelors') ? 'selected' : ''; ?>>Bachelors</option>
																<option value="Masters" <?= ($row['qualification'] == 'Masters') ? 'selected' : ''; ?>>Masters</option>
																<option value="Diploma" <?= ($row['qualification'] == 'Diploma') ? 'selected' : ''; ?>>Diploma</option>
															</select>

														</div>
														<div class="col-md-6">
															<label class="form-label">Gender <span class="text-danger">*</span></label>
															<select class="form-select" name="gender" id="gender" required>
																<option disabled>Select</option>
																<option value="Male" <?= ($row['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
																<option value="Female" <?= ($row['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
																<option value="Any" <?= ($row['gender'] == 'Any') ? 'selected' : ''; ?>>Any</option>
															</select>

														</div>
														<div class="col-md-6">
															<label class="form-label">Min. Salary <span class="text-danger">*</span></label>
															<input type="number" class="form-control" name="min_salary" id="min_salary" value="<?= $row['min_salary']; ?>" placeholder = "Min. Salary" required>
														</div>
														<div class="col-md-6">
															<label class="form-label">Max. Salary <span class="text-danger">*</span></label>
															<input type="number" class="form-control" name="max_salary" id="max_salary" value="<?= $row['max_salary']; ?>" placeholder = "Max. Salary" required>
														</div>
														<div class="col-md-6">
															<label class="form-label">Job Expired Date <span class="text-danger">*</span></label>
															<input type="date" class="form-control" name="job_expired_date" id="job_expired_date" value="<?= $row['job_expired_date']; ?>" required>
														</div>
														<div class="col-md-6">
															<label class="form-label">No of Opening <span class="text-danger">*</span></label>
															<input type="text" class="form-control" name="no_of_applicant" id="no_of_applicant" value="<?= $row['no_of_applicant']; ?>" placeholder = "No of Opening" required>
														</div>
														<div class="col-md-6 mb-3">
															<label class="form-label">Shift Timing <span class="text-danger">*</span></label>
															<input type="text" class="form-control" name="shift_time" id="shift_time" value="<?= $row['shift_time']; ?>" placeholder = "Shift Timing" required>
														</div>
														<div class="col-md-6 mb-3">
															<label class="form-label">Required Skills</label>
															<input type="text" class="form-control" name="required_skills" id="required_skills" value="<?= $row['required_skills']; ?>" placeholder = "Required Skills">
														</div>

														<hr>
														<h5>Location</h5>
														<div class="col-md-12 mt-3">
															<label class="form-label">Address <span class="text-danger">*</span></label>
															<textarea class="form-control" name="address" id="address" rows="1" required><?= $row['address']; ?></textarea>
														</div>
														<div class="col-md-6">
															<label class="form-label">Country  <span class="text-danger">*</span></label>
															<input type="text" class="form-control" name="country" id="country" value="<?= $row['country']; ?>" required>
														</div>
														<div class="col-md-6">
															<label class="form-label">State  <span class="text-danger">*</span></label>
															<input type="text" class="form-control" name="state" id="state" value="<?= $row['state']; ?>" required>
														</div>
														<div class="col-md-6">
															<label class="form-label">City  <span class="text-danger">*</span></label>
															<input type="text" class="form-control" name="city" id="city" value="<?= $row['city']; ?>" required>
														</div>
														<div class="col-md-6">
															<label class="form-label">Zip Code  <span class="text-danger">*</span></label>
															<input type="text" class="form-control" name="zip_code" id="zip_code" value="<?= $row['zip_code']; ?>" required>
														</div>
													</div>
												</div>
											</div>
											<input type="hidden" name="jobid" value="<?= $row['id']; ?>">

											<div class="modal-footer px-4">
												<button type="button" class="btn btn-secondary btn-pill" data-bs-dismiss="modal">Cancel</button>
												<button type="submit" name="jobsubmit" class="btn btn-primary btn-pill">Submit</button>
											</div>
										</form>
									</div>
								</div>
							</div>

							<!-- delete job -->
							<div class="modal fade" id="modal-deletejob-<?= $row['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered modal" role="document">
									<div class="modal-content">
                                        <form method="post">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addAdminTitle">Delete Job Post </h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="modal-text">Are you sure to delete <b><?= $row['job_title']; ?></b> !</p>
                                                <input type="hidden" name="job_id" value="<?= $row['id']; ?>">
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-dismiss="modal"> No</button>
                                                <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                                            </div>
                                        </form>
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

					<!-- Add Job Button  -->
					<div class="modal fade" id="modal-add-member" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
							<div class="modal-content">
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="modal-header border-bottom-1">
                                        <h5>Job Post</h5>
                                    </div>

                                    <div class="modal-body p-5">
                                        <div class="col-md-12">
                                            <h5 class="mb-3">Basic Information</h5>
					            		    <!-- <div class="form-group mb-3">
					            		    	<label class="form-label">Upload Job Profile Image <span class="text-danger">*</span></label>
					            		    	<input type="file" class="form-control" id="jobimg" name="jobimg" required>
					            		    </div> -->
                                            <div class="mb-3">
                                                <label class="form-label">Job Title <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="job_title" id="job_title" placeholder = "Job Title" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Job Description <span class="text-danger">*</span></label>
                                                <textarea class="form-control" name="job_description" id="job_description" rows="2" placeholder = "Job Description" required></textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Job Category <span class="text-danger">*</span></label>
                                                    <select class="form-select" name="job_category" id="job_category" required>
                                                        <option selected disabled>Select</option>
                                                        <option>Information Technology (IT)</option>
                                                        <option>Finance & Accounting</option>
                                                        <option>Customer Service</option>
                                                        <option>Creative & Design</option>
                                                        <option>Human Resources (HR)</option>
                                                        <option>Data Entry Operator</option>
                                                        <option>Voice Process</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Job Type <span class="text-danger">*</span></label>
                                                    <select class="form-select" name="job_type" id="job_type" required>
                                                        <option selected disabled>Select</option>
                                                        <option>Full-Time</option>
                                                        <option>Part-Time</option>
                                                        <option>Contract</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Job Level <span class="text-danger">*</span></label>
                                                    <select class="form-select" name="job_level" id="job_level" required>
                                                        <option selected disabled>Select</option>
                                                        <option>Entry</option>
                                                        <option>Mid</option>
                                                        <option>Senior</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Experience <span class="text-danger">*</span></label>
                                                    <select class="form-select" name="experience" id="experience" required>
                                                        <option selected disabled>Select</option>
                                                        <option>0-1 Years</option>
                                                        <option>2-5 Years</option>
                                                        <option>5+ Years</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Qualification <span class="text-danger">*</span></label>
                                                    <select class="form-select" name="qualification" id="qualification" required>
                                                        <option selected disabled>Select</option>
                                                        <option>Bachelors</option>
                                                        <option>Masters</option>
                                                        <option>Diploma</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Gender <span class="text-danger">*</span></label>
                                                    <select class="form-select" name="gender" id="gender" required>
                                                        <option selected disabled>Select</option>
                                                        <option>Male</option>
                                                        <option>Female</option>
                                                        <option>Any</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Min. Salary <span class="text-danger">*</span></label>
													<input type="number" class="form-control" name="min_salary" id="min_salary" placeholder = "Min. Salary" required>
                                                    <!-- <select class="form-select" name="min_salary" id="min_salary" required>
                                                        <option selected disabled>Select</option>
                                                        <option>10,000</option>
                                                        <option>20,000</option>
                                                        <option>30,000</option>
                                                    </select> -->
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Max. Salary <span class="text-danger">*</span></label>
													<input type="number" class="form-control" name="max_salary" id="max_salary" placeholder = "Max. Salary" required>
                                                    <!-- <select class="form-select" name="max_salary" id="max_salary" required>
                                                        <option selected disabled>Select</option>
                                                        <option>50,000</option>
                                                        <option>75,000</option>
                                                        <option>1,00,000</option>
                                                    </select> -->
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Job Expired Date <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" name="job_expired_date" id="job_expired_date" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">No of Opening <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="no_of_applicant" id="no_of_applicant" placeholder = "No of Opening" required>
                                                </div>
												<div class="col-md-6 mb-3">
                                                    <label class="form-label">Shift Timing <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="shift_time" id="shift_time" placeholder = "Shift Timing" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Required Skills</label>
                                                    <input type="text" class="form-control" name="required_skills" id="required_skills" placeholder = "Required Skills">
                                                </div>

                                                <hr>
                                                <h5>Location</h5>
                                                <div class="col-md-12 mt-3">
                                                    <label class="form-label">Address <span class="text-danger">*</span></label>
                                                    <textarea class="form-control" name="address" id="address" rows="1" required></textarea>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Country  <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="country" id="country" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">State  <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="state" id="state"required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">City  <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="city" id="city" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Zip Code  <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="zip_code" id="zip_code" required>
                                                </div>
                                            </div>
					            		</div>
                                    </div>

                                    <div class="modal-footer px-4">
                                        <button type="button" class="btn btn-secondary btn-pill" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" name="jobsubmit" class="btn btn-primary btn-pill">Submit</button>
                                    </div>
                                </form>
							</div>
						</div>
					</div>
				</div> <!-- End Content -->
			</div><!-- End Content Wrapper -->

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
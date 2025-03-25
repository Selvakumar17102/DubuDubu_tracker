<?php

session_start();
ini_set("display_errors",'off');
include('include/connection.php');
$employee = 'active';
$emp_boolean = 'true';
$emp_show = 'show';
$emp_apply = 'active';

if(isset($_GET['edit_id'])){
    $user_id = $_GET['edit_id'];
    $sql = "SELECT * FROM employee WHERE id = '$user_id'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result);
}

$alldataSql = "SELECT * FROM employee WHERE control != 1 AND del_status = 0";
$alldataResult = $conn->query($alldataSql);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Ekka - Admin Dashboard HTML Template.">

	<title>DUBU DUBU - Add Employee</title>

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

	<!-- ekka CSS -->
	<link id="ekka-css" rel="stylesheet" href="assets/css/ekka.css" />

	<!-- FAVICON -->
	<link href="assets/img/favicon.png" rel="shortcut icon" />

</head>
<style>
    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
		border: 1px solid #eeeeee !important;
		width: 280px;
		border-radius: 15px;
	}
	.tab-link{
		cursor: not-allowed;
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
			<div class="ec-content-wrapper">
				<div class="content">
					<div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
						<div>
							<h1>Add Employee</h1>
							<!-- <p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Product</p> -->
						</div>
						<div>
							<a href="javascript:history.go(-1)" class="btn btn-primary">Back</a>
						</div>
					</div>
					<div class="row review-rating mt-4">
						<div class="col-12">
							<ul class="nav nav-tabs nav-alltabs" id="myRatingTab" role="tablist">
								<li class="nav-item">
									<a  class="nav-link tab-link active" id="product-detail-tab" data-bs-toggle="tab" data-bs-target="#productdetail" href="#productdetail" role="tab" aria-selected="true">
										<i class="mdi mdi-account-circle mr-1"></i>Personal Details</a>
								</li>

								<li class="nav-item">
									<a  class="nav-link tab-link" id="product-information-tab" data-bs-toggle="tab" data-bs-target="#productinformation" href="#productinformation" role="tab" aria-selected="false">
										<i class="mdi mdi-information mr-1"></i>Official Details</a>
								</li>

								<li class="nav-item">
									<a  class="nav-link tab-link" id="product-reviews-tab" data-bs-toggle="tab" data-bs-target="#document" href="#document" role="tab" aria-selected="false">
										<i class="mdi mdi-file-document mr-1"></i> Documents </a>
								</li>

								<li class="nav-item">
									<a  class="nav-link tab-link" id="product-reviews-tab" data-bs-toggle="tab" data-bs-target="#assets" href="#assets" role="tab" aria-selected="false">
										<i class="mdi mdi-monitor-multiple mr-1"></i> Assets Management </a>
								</li>
								<li class="nav-item">
									<a  class="nav-link tab-link" id="product-reviews-tab" data-bs-toggle="tab" data-bs-target="#bankdetails" href="#bankdetails" role="tab" aria-selected="false">
										<i class="mdi mdi-bank mr-1"></i> Bank Details </a>
								</li>
							</ul>
							<form method="post" id="regForm" action="emp_insert.php" enctype="multipart/form-data">
								<div class="tab-content" id="myTabContent2">
									<div class="tab-pane pt-5 fade show active" id="productdetail" role="tabpanel">
										<div class="row mb-2">
											<div class="col-lg-6">
												<div class="form-group">
													<label for="firstName">First Name<span style="color:red;font-weight:bold">*</span></label>
													<input type="text" class="form-control" id="firstname" name="fname" placeholder="First Name" value="<?php echo $row['fname']?>" required>
												</div>
											</div>

											<div class="col-lg-6">
												<div class="form-group">
													<label for="lastName">Last Name<span style="color:red;font-weight:bold">*</span></label>
													<input type="text" class="form-control" id="lastname" name="lname" placeholder="Last Name" value="<?php echo $row['lname']?>"required>
												</div>
											</div>

											<div class="col-lg-6">
												<div class="form-group mb-4">
													<label for="perphone">Primary Phone Number<span style="color:red;font-weight:bold">*</span></label>
													<input type="text" class="form-control" id="perphone" name="pphone" maxlength="10" minlength="10" placeholder="Primary Phone Number" value="<?php echo $row['pphno']?>" required>
												</div>
											</div>	

											<div class="col-lg-6">
												<div class="form-group">
													<label for="peremail">Personal Email<span style="color:red;font-weight:bold">*</span></label>
													<input type="email" class="form-control" id="peremail" name="pemail" placeholder="Personal Email" value="<?php echo $row['pemail']?>" required>
												</div>
											</div>

											<div class="col-md-6">
											    <div class="form-group mb-4">
											    	<label class="form-label">Gender<span style="color:red;font-weight:bold">*</span></label>
											    	<select name="gender" id="gender" class="form-control" value="male" required>
											    			<option value="" data-display="Team">Select Gender</option>
											    			<option value="Male" <?php if($row['gender']=='Male'){ echo "selected"; }?>>Male</option>
											    			<option value="Female" <?php if($row['gender']=='Female'){ echo "selected"; }?>>Female</option>
															<option value="Transgender" <?php if($row['gender']=='Transgender'){ echo "selected"; }?>>Transgender</option>
											    	</select>
											    </div>
											</div>

											<div class="col-lg-6">
												<div class="form-group mb-4">
													<label for="birthday">DOB<span style="color:red;font-weight:bold">*</span></label>
													<input type="date" class="form-control" id="birthdaydate" name="birthday" placeholder="Birth Date" value="<?php echo $row['dob']?>" required>
												</div>
											</div>

											<div class="col-md-6">
											    <div class="form-group mb-4">
											    	<label class="form-label">Marital Status<span style="color:red;font-weight:bold">*</span></label>
											    	<select name="marital" id="marital" class="form-control" required>
											    			<option value="" data-display="Team">Select Marital Status</option>
															<option value="Single"<?php if($row['marital']=='Single'){ echo "selected"; }?>>Single</option>
											    			<option value="Married" <?php if($row['marital']=='Married'){ echo "selected"; }?>>Married</option>
											    			<option value="Divorced"<?php if($row['marital']=='Divorced'){ echo "selected"; }?>>Divorced</option>
															<option value="Widowed"<?php if($row['marital']=='Widowed'){ echo "selected"; }?>>Widowed</option>
											    	</select>
											    </div>
											</div>

											<div class="col-lg-6">
												<div class="form-group mb-4">
													<label for="event">Blood Group<span style="color:red;font-weight:bold">*</span></label>
													<input type="text" class="form-control" id="bloodgroup" name="blood" placeholder="Blood Group" value="<?php echo $row['blood_group']?>" required>
												</div>
											</div>

											<div class="col-lg-6">
												<div class="form-group mb-4">
													<label for="disability">Disability <span style="color:red;font-weight:bold">*</span></label>
													<select class="form-control" id="disability" name="disability" required onchange="toggleDisabilityId(this)">
														<option value="">Select</option>
														<option value="yes" <?php echo ($row['disability'] == 'yes') ? 'selected' : ''; ?>>Yes</option>
														<option value="no" <?php echo ($row['disability'] == 'no') ? 'selected' : ''; ?>>No</option>
													</select>
												</div>
											</div>

											<div class="col-lg-6" id="disability_id_div" style="display: <?php echo ($row['disability'] == 'yes') ? 'block' : 'none'; ?>;">
												<div class="form-group mb-4">
													<label for="disability_id">Disability ID</label>
													<input type="text" class="form-control" id="disability_id" name="disability_id" placeholder="Enter Disability ID" value="<?php echo isset($row['disability_id']) ? $row['disability_id'] : ''; ?>">
												</div>
											</div>

											<div class="col-lg-6">
												<div class="form-group">
													<label for="aadharcardno">Aadhar Card Number<span style="color:red;font-weight:bold">*</span></label>
													<input type="number" class="form-control" id="aadharcardno" name="aadharcardno" placeholder="Aadhar Card Number" value="<?php echo $row['aadharcardno']?>" oninput="validateAadhar(this)" required>
												</div>
											</div>

											<div class="col-lg-6">
												<div class="form-group">
													<label for="pancardno">PAN Card Number<span style="color:red;font-weight:bold">*</span></label>
													<input type="text" class="form-control" id="pancardno" name="pancardno" placeholder="PAN Card Number" value="<?php echo $row['pan_card_no']?>" oninput="this.value = this.value.toUpperCase()" maxlength="10" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" required>
												</div>
											</div>

											<div class="col-lg-6">
												<div class="form-group mb-4">
													<label for="current_Address">Cummunication Address<span style="color:red;font-weight:bold">*</span></label>
													<textarea type="text" class="form-control" id="curaddress" name="caddress" placeholder="Current Address" required><?php echo $row['caddress']?></textarea>
												</div>
											</div>

											<div class="col-lg-6">
												<div class="form-group mb-4">
													<label for="permanent_Address">Permanent Address<span style="color:red;font-weight:bold">*</span></label>
													<textarea type="text" class="form-control" id="peraddress" name="paddress" placeholder="Permanent Address" required><?php echo $row['paddress']?></textarea>
													<input type="checkbox" class="form-check-input" id="sameAddress">
													<label class="form-check-label" for="sameAddress">Same as Cummunication Address</label>
												</div>
											</div>
											<hr>

											<h4><b>Emergency Contact</b></h4>
											<div class="row mt-5">
												<div class="col-lg-4">
													<div class="form-group mb-4">
														<label for="event">Name<span style="color:red;font-weight:bold">*</span></label>
														<input type="text" class="form-control" id="rname" name="rname" placeholder="Relation Name" value="<?php echo $row['rname']?>" required>
													</div>
												</div>
												<div class="col-lg-4">
													<div class="form-group mb-4">
														<label for="event">Relationship<span style="color:red;font-weight:bold">*</span></label>
														<input type="text" class="form-control" id="relationship" name="relationship" placeholder="Relationship" value="<?php echo $row['relationship']?>" required>
													</div>
												</div>
												<div class="col-lg-4">
													<div class="form-group mb-4">
														<label for="event">Contact Number<span style="color:red;font-weight:bold">*</span></label>
														<input type="text" class="form-control" id="contactnumber" name="contactnumber" placeholder="Contact Number" value="<?php echo $row['contactnumber']?>" required>
													</div>
												</div>
											</div>

											<div class="modal-footer px-4">
												<button type="button" name="persnol_submit" id="persnol_submit" onclick="personalValidate()" class="btn btn-primary btn-pill btnNext">Next</button>
											</div>
										</div>
									</div>


									<div class="tab-pane pt-3 fade" id="productinformation" role="tabpanel">
										<div class="row mb-2">

											<div class="col-md-3">
												<div class="form-group mb-4">
													<label class="form-label">Company<span style="color:red;font-weight:bold">*</span></label>
													<select name="company" id="company" class="form-control" required>
														<option value="">Select Company</option>
														<?php
														$com_sql = "SELECT * FROM companies";
														$com_result = $conn->query($com_sql);
														while ($comRow = mysqli_fetch_array($com_result)) {
														?>
															<option value="<?php echo $comRow['id']; ?>" data-shortname="<?php echo $comRow['short_name']; ?>" <?php if($row['company'] == $comRow['id']){ echo "selected"; }?>>
																<?php echo $comRow['company_name']; ?>
															</option>
														<?php
														}
														?>
													</select>
												</div>
											</div>

											<div class="col-lg-3">
												<div class="form-group">
													<label for="emp_id">Employee ID<span style="color:red;font-weight:bold">*</span></label>
													<input readonly type="text" class="form-control" id="emp_id" name="emp_id_no" placeholder="Employee Id" value="<?php echo $row['emp_id']; ?>" required>
												</div>
											</div>

											<div class="col-lg-3">
												<div class="form-group mb-4">
													<label for="Birthday">Joining Date<span style="color:red;font-weight:bold">*</span></label>
													<input type="date" class="form-control" id="joindaydate" name="joinday" placeholder="Joining Date" value="<?php echo $row['doj']?>" required>
												</div>
											</div>
													
											<div class="col-lg-3">
												<div class="form-group">
													<label for="Office_Email">Office Email<span style="color:red;font-weight:bold">*</span></label>
													<input type="email" class="form-control" id="offemail" name="oemail" placeholder="Office Email" value="<?php echo $row['oemail']?>"required>
												</div>
											</div>
													
											<div class="col-md-3">
												<div class="form-group mb-4">
													<label class="form-label">department<span style="color:red;font-weight:bold">*</span></label>
													<select name="department" id="department" class="form-control" required>
															<option value="" data-display="department">Select department</option>
															<?php
															$sql = "SELECT * FROM department";
															$result = $conn->query($sql);
                                	                        while($rows = mysqli_fetch_array($result)){
                                	                            ?>
                                	                            <option value="<?php echo $rows['id']?>" <?php if($rows['id'] == $row['department']){ echo "selected"; }?>><?php echo $rows['dept_name']?></option>
                                	                            <?php
                                	                        }
                                	                        ?>
													</select>
												</div>
											</div>

											<div class="col-lg-3">
												<div class="form-group mb-4">
													<label for="designation">Designation <span style="color:red;font-weight:bold">*</span></label>
													<select name="designation" id="designation" class="form-control">
														<option value="">Select Designation</option>
														<?php
															$dessql = "SELECT * FROM designation";
															$desresult = $conn->query($dessql);
                                	                        while($desrow = mysqli_fetch_array($desresult)){
                                	                            ?>
																<option value="<?php echo $desrow['desig_id']?>" <?php if($desrow['desig_id'] == $row['designation']){ echo "selected"; }?>><?php echo $desrow['designation_name']?></option>
																<?php
                                	                        }
                                	                        ?>
													</select>
												</div>
											</div>
														
											<div class="col-md-3">
											    <div class="form-group mb-4">
											    	<label class="form-label">Roll<span style="color:red;font-weight:bold">*</span></label>
											    	<select name="roll" id="roll" class="form-control" required>
											    			<option value="" data-display="Team">Select Roll</option>
											    			<option value="Employee" <?php if($row['emp_roll']=='Employee'){ echo "selected"; }?>>Employee</option>
															<option value="Team Leader" <?php if($row['emp_roll']=='Team Leader'){ echo "selected"; }?>>Team Leader</option>
											    			<option value="Project Manager" <?php if($row['emp_roll']=='Project Manager'){ echo "selected"; }?>>Project Manager</option>
															<option value="Human Resources" <?php if($row['emp_roll']=='Human Resources'){ echo "selected"; }?>>Human Resources</option>
															<option value="Super Admin" <?php if($row['emp_roll']=='Super Admin'){ echo "selected"; }?>>Super Admin</option>
											    	</select>
											    </div>
											</div>

											<div class="col-md-3">
											    <div class="form-group mb-4">
											    	<label class="form-label">Reporting To<span style="color:red;font-weight:bold">*</span></label>
													<?php
													$rep = $row['emp_report_to'];
													$arr_rep = (explode(",",$rep));
													?>
											    	<select name="report[]" id="report" class="selectpicker" multiple data-live-search="true" required>
														<?php
														while($alldata = mysqli_fetch_array($alldataResult)){
															?>
															<option value="<?php echo $alldata['id']?>" <?php if(in_array($alldata['id'],$arr_rep)){ echo "selected"; }?>><?php echo $alldata['fname']?> <?php echo $alldata['lname']?></option>
															<?php
														}
														?>
											    	</select>
											    </div>
											</div>

											<div class="col-md-3">
											    <div class="form-group mb-4">
											    	<label class="form-label">Employee Type<span style="color:red;font-weight:bold">*</span></label>
											    	<select name="employeetype" id="employeetype" class="form-control" required>
											    			<option value="" data-display="Team">Select Employee Type</option>
											    			<option value="Full Time" <?php if($row['emp_type']=='Full Time'){ echo "selected"; }?>>Full Time</option>
											    			<option value="Part Time" <?php if($row['emp_type']=='Part Time'){ echo "selected"; }?>>Part Time</option>
											    			<option value="Temporary" <?php if($row['emp_type']=='Temporary'){ echo "selected"; }?>>Temporary</option>
											    			<option value="Internship" <?php if($row['emp_type']=='Internship'){ echo "selected"; }?>>Internship</option>
											    	</select>
											    </div>
											</div>

											<div class="col-lg-6">
												<div class="form-group mb-4">
													<label for="salary">Salary<span style="color:red;font-weight:bold">*</span></label>
													<input type="number" class="form-control" id="salaryamo" name="salary" placeholder="Salary"value="<?php echo $row['basic_salary']?>" required>
												</div>
											</div>

											<div class="modal-footer px-4">
												<button type="button"  class="btn btn-primary btn-pill btnPrevious">Previous</button>
												<button type="button" name="official_submit" id="official_submit" onclick="officialValidate()" class="btn btn-primary btn-pill btnNext">Next</button>
											</div>
										</div>
									</div>


									<div class="tab-pane pt-3 fade" id="document" role="tabpanel">
										<div class="form-group row mb-3">
											<label for="coverImage" class="col-sm-4 col-lg-2 col-form-label">Profile Image</label>
											<div class="col-sm-8 col-lg-10">
												<div class="custom-file">
												<?php
													if($row['emp_photo'] == ""){
														$dis = "none";
													}else{
														$dis = "block";
													}
													$image_path = $row['emp_photo'];
													$img_path = "assets/img/employee_img/";
													$img_file = basename($image_path);
													?>
													<input type="hidden" class="form-control" id="coverImage" name="hidd_image" value="<?php echo $row['emp_photo']?>">
													<input type="file" name="image" class="form-control" id="coverImage">
													<div class="row" id="panId<?php echo 'emp_photo'?>">
														<div class="col-sm-3">
														<a href="<?php echo $row['emp_photo']?>" target="_blank"><label style="color:red;cursor: pointer;display:<?php echo $dis;?>"><?php echo $img_file;?></label></a>
														</div>
														<div class="col-sm-1">
															<button type="button" onclick="fileDelete(<?php echo $row['id']?>,'<?php echo 'emp_photo'?>','<?php echo $img_file;?>','<?php echo $img_path;?>')"><i class="mdi mdi-folder-remove" style="font-size: 1.73em;display:<?php echo $dis;?>"></i></button>
														</div>
													</div>
													<!-- <input type="file" name="image" class="form-control" id="coverImage" value="<?php echo $row['emp_photo']?>"> -->
												</div>
											</div>
										</div>

										<div class="row mb-2">
											<div class="col-lg-4">
												<div class="form-group mb-4">
													<label for="event">Aadhar Card<span style="color:red;font-weight:bold">*</span></label>
													<?php
													if($row['aadhar'] == ""){
														$req = "required";
													}else{
														$req = "";
													}
													if($row['aadhar'] == ""){
														$dis = "none";
													}else{
														$dis = "block";
													}
													$aadhar_path = $row['aadhar'];
													$aadharfile_path = "assets/img/employee_documents/aadhar_card/";
													$aadhar_file = basename($aadhar_path);
													?>
													<input type="hidden" class="form-control" id="aadharcard1" name="hidd_aadhar" value="<?php echo $row['aadhar']?>">
													<input type="file" class="form-control" id="aadharcard" name="aadhar" <?php echo $req;?>>
													<div class="row" id="panId<?php echo 'aadhar'?>">
														<div class="col-sm-10">
															<a href="<?php echo $row['aadhar']?>" target="_blank"><label style="color:red;cursor: pointer;display:<?php echo $dis;?>"><?php echo $aadhar_file;?></label></a>
														</div>
														<div class="col-sm-2">
															<button type="button" onclick="fileDelete(<?php echo $row['id']?>,'<?php echo 'aadhar'?>','<?php echo $aadhar_file;?>','<?php echo $aadharfile_path;?>')"><i class="mdi mdi-folder-remove" style="font-size: 1.73em;display:<?php echo $dis;?>"></i></button>
														</div>
													</div>
												</div>
											</div>

											<div class="col-lg-4">
												<div class="form-group mb-4">
													<label for="event">Pan Card</label>
													<?php
													if($row['pan'] == ""){
														$dis = "none";
													}else{
														$dis = "block";
													}
													$pan_path = $row['pan'];
													$pan_file_path = "assets/img/employee_documents/pan_card/";
													$pan_file = basename($pan_path);
													?>
													<input type="hidden" class="form-control" id="pancard" name="hidd_pan" value="<?php echo $row['pan']?>">
													<input type="file" class="form-control" id="pancard" name="pan">
													<div class="row" id="panId<?php echo 'pan'?>">
														<div class="col-sm-10">
															<a href="<?php echo $row['pan']?>" target="_blank"><label style="color:red;cursor: pointer;display:<?php echo $dis;?>"><?php echo $pan_file;?></label></a>
														</div>
														<div class="col-sm-2">
															<button type="button" onclick="fileDelete(<?php echo $row['id']?>,'<?php echo 'pan'?>','<?php echo $pan_file;?>','<?php echo $pan_file_path;?>')"><i class="mdi mdi-folder-remove" style="font-size: 1.73em;display:<?php echo $dis;?>"></i></button>
														</div>
													</div>
												</div>
											</div>

											<div class="col-lg-4">
												<div class="form-group mb-4">
													<label for="event">Experience</label>
													<?php
													if($row['experience'] == ""){
														$dis = "none";
													}else{
														$dis = "block";
													}
													$experience_path = $row['experience'];
													$exp_file_path ="assets/img/employee_documents/experience/";
													$exp_file = basename($experience_path);
													?>
													<input type="hidden" class="form-control" id="experiencecer" name="hidd_experience" value="<?php echo $row['experience']?>">
													<input type="file" class="form-control" id="experiencecer" name="experience">
													<div class="row" id="panId<?php echo 'experience'?>">
														<div class="col-sm-10">
															<a href="<?php echo $row['experience']?>" target="_blank"><label style="color:red;cursor: pointer;display:<?php echo $dis;?>"><?php echo $exp_file;?></label></a>
														</div>
														<div class="col-sm-2">
															<button type="button" onclick="fileDelete(<?php echo $row['id']?>,'<?php echo 'experience'?>','<?php echo $exp_file;?>','<?php echo $exp_file_path;?>')"><i class="mdi mdi-folder-remove" style="font-size: 1.73em;display:<?php echo $dis;?>"></i></button>
														</div>
													</div>
												</div>
											</div>

											<div class="col-lg-4">
												<div class="form-group mb-4">
													<label for="event">Relieving</label>
													<?php
													if($row['reliving'] == ""){
														$dis = "none";
													}else{
														$dis = "block";
													}
													$reliving_path = $row['reliving'];
													$rel_file_path = "assets/img/employee_documents/relieving/";
													$rel_file = basename($reliving_path);
													?>
													<input type="hidden" class="form-control" id="relievingcer" name="hidd_reliving" value="<?php echo $row['reliving']?>">
													<input type="file" class="form-control" id="relievingcer" name="relieving">
													<div class="row" id="panId<?php echo 'reliving'?>">
														<div class="col-sm-10">
															<a href="<?php echo $row['reliving']?>" target="_blank"><label style="color:red;cursor: pointer;display:<?php echo $dis;?>"><?php echo $rel_file;?></label></a>
														</div>
														<div class="col-sm-2">
															<button type="button" onclick="fileDelete(<?php echo $row['id']?>,'<?php echo 'reliving'?>','<?php echo $rel_file;?>','<?php echo $rel_file_path;?>')"><i class="mdi mdi-folder-remove" style="font-size: 1.73em;display:<?php echo $dis;?>"></i></button>
														</div>
													</div>
												</div>
											</div>

											<div class="col-lg-4">
												<div class="form-group mb-4">
													<label for="event">Pay Slip</label>
													<?php
													if($row['payslip'] == ""){
														$dis = "none";
													}else{
														$dis = "block";
													}
													$payslip_path = $row['payslip'];
													$pay_file_path = "assets/img/employee_documents/payslip/";
													$pay_file = basename($payslip_path);
													?>
													<input type="hidden" class="form-control" id="payslipcer" name="hidd_payslip" value="<?php echo $row['payslip']?>">
													<input type="file" class="form-control" id="payslipcer" name="payslip">
													<div class="row" id="panId<?php echo 'payslip'?>">
														<div class="col-sm-10">
															<a href="<?php echo $row['payslip']?>" target="_blank"><label style="color:red;cursor: pointer;display:<?php echo $dis;?>"><?php echo $pay_file;?></label></a>
														</div>
														<div class="col-sm-2">
															<button type="button" onclick="fileDelete(<?php echo $row['id']?>,'<?php echo 'payslip'?>','<?php echo $pay_file;?>','<?php echo $pay_file_path;?>')"><i class="mdi mdi-folder-remove" style="font-size: 1.73em;display:<?php echo $dis;?>"></i></button>
														</div>
													</div>
												</div>
											</div>

											<div class="col-lg-4">
												<div class="form-group mb-4">
													<label for="event">Resume</label>
													<?php
													if($row['resume'] == ""){
														$dis = "none";
													}else{
														$dis = "block";
													}
													$resume_path = $row['resume'];
													$res_file_path ="assets/img/employee_documents/resume/";
													$res_file = basename($resume_path);
													?>
													<input type="hidden" class="form-control" id="resume" name="hidd_resume" value="<?php echo $row['resume']?>">
													<input type="file" class="form-control" id="resume" name="resume">
													<div class="row" id="panId<?php echo 'resume'?>">
														<div class="col-sm-10">
															<a href="<?php echo $row['resume']?>" target="_blank"><label style="color:red;cursor: pointer;display:<?php echo $dis;?>"><?php echo $res_file;?></label></a>
														</div>
														<div class="col-sm-2">
															<button type="button" onclick="fileDelete(<?php echo $row['id']?>,'<?php echo 'resume'?>','<?php echo $res_file;?>','<?php echo $res_file_path;?>')"><i class="mdi mdi-folder-remove" style="font-size: 1.73em;display:<?php echo $dis;?>"></i></button>
														</div>
													</div>
												</div>
											</div>

											<div class="col-lg-4">
												<div class="form-group mb-4">
													<label for="event">Education Certificate</label>
													<?php
													if($row['degreecertificate'] == ""){
														$dis = "none";
													}else{
														$dis = "block";
													}
													$degree_path = $row['degreecertificate'];
													$degree_file_path = "assets/img/employee_documents/degree/";
													$degree_file = basename($degree_path);
													?>
													<input type="hidden" class="form-control" id="degreecer" name="hidd_degree" value="<?php echo $row['degreecertificate']?>">
													<input type="file" class="form-control" id="degreecer" name="degree">
													<div class="row" id="panId<?php echo 'degreecertificate'?>">
														<div class="col-sm-10">
														<a href="<?php echo $row['degreecertificate']?>" target="_blank"><label style="color:red;cursor: pointer;display:<?php echo $dis;?>"><?php echo $degree_file;?></label></a>
														</div>
														<div class="col-sm-2">
															<button type="button" onclick="fileDelete(<?php echo $row['id']?>,'<?php echo 'degreecertificate'?>','<?php echo $degree_file;?>','<?php echo $degree_file_path;?>')"><i class="mdi mdi-folder-remove" style="font-size: 1.73em;display:<?php echo $dis;?>"></i></button>
														</div>
													</div>
												</div>
											</div>

											<div class="modal-footer px-4">
												<button type="button"  class="btn btn-primary btn-pill btnPrevious">Previous</button>
												<button type="button" name="document_submit" id="document_submit" onclick="documentValidate()" class="btn btn-primary btn-pill btnNext">Next</button>
											</div>
										</div>
									</div>


									<div class="tab-pane pt-3 fade" id="assets" role="tabpanel">
										<div class="row mb-2">
											<div class="col-md-3">
												<div class="form-group mb-4">
													<label class="form-label">System Type</label>
													<select name="systemtype[]" id="systemtype1" class="selectpicker" multiple data-live-search="true">
															<option value="Desktop" <?php if($row['system_type']=='Desktop'){ echo "selected"; }?>>Desktop</option>
															<option value="Laptop" <?php if($row['system_type']=='Laptop'){ echo "selected"; }?>>Laptop</option>
													</select>
												</div>
											</div>

											<div class="col-lg-3">
												<div class="form-group mb-4">
													<label for="event">System Id</label>
													<input type="text" class="form-control" id="systemid" name="systemid" placeholder="System Id" value="<?php echo $row['system_id']?>">
												</div>
											</div>

											<div class="col-md-3">
												<div class="form-group mb-4">
													<label class="form-label">Spare Gadgets</label>
													<?php
													$str = $row['spare'];
													$spare=(explode(" ",$str));
													?>
													<select name="sparegadgets[]" id="sparegadgets" class="selectpicker" multiple data-live-search="true">
														<option value="Headset" <?php if(in_array('Headset',$spare)){ echo "selected"; }?>>Headset</option>
														<option value="Mouse" <?php if(in_array('Mouse',$spare)){ echo "selected"; }?>>Mouse</option>
														<option value="Wifi Adapter" <?php if(in_array('Wifi Adapter',$spare)){ echo "selected"; }?>>Wifi Adapter</option>
														<option value="Keyboard" <?php if(in_array('Keyboard',$spare)){ echo "selected"; }?>>Keyboard</option>
														<option value="Ethernetcable" <?php if(in_array('Ethernetcable',$spare)){ echo "selected"; }?>>Ethernet cable</option>
													</select>
												</div>
											</div>

											<div class="modal-footer px-4">
												<button type="button"  class="btn btn-primary btn-pill btnPrevious">Previous</button>
												<button type="button" name="document_submit" id="document_submit" onclick="assets()" class="btn btn-primary btn-pill btnNext">Next</button>
											</div>
										</div>
									</div>


									<div class="tab-pane pt-3 fade" id="bankdetails" role="tabpanel">
										<div class="row mb-2">

											<div class="col-lg-4">
												<div class="form-group mb-4">
													<label for="bank_name">Bank Name <span style="color:red;font-weight:bold">*</span></label>
													<input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name" required value="<?php echo isset($row['bank_name']) ? $row['bank_name'] : ''; ?>">
												</div>
											</div>

											<div class="col-lg-4">
												<div class="form-group mb-4">
													<label for="account_number">Account Number <span style="color:red;font-weight:bold">*</span> </label>
													<input type="text" class="form-control" id="account_number" name="account_number" placeholder="Account Number" required value="<?php echo isset($row['account_number']) ? $row['account_number'] : ''; ?>">
												</div>
											</div>

											<div class="col-lg-4">
												<div class="form-group mb-4">
													<label for="ifsc_code">IFSC Code <span style="color:red;font-weight:bold">*</span> </label>
													<input type="text" class="form-control" id="ifsc_code" name="ifsc_code" placeholder="IFSC Code" required value="<?php echo isset($row['ifsc_code']) ? $row['ifsc_code'] : ''; ?>">
												</div>
											</div>

											<div class="col-lg-4">
												<div class="form-group mb-4">
													<label for="branch_name">Branch Name</label>
													<input type="text" class="form-control" id="branch_name" name="branch_name" placeholder="Branch Name" value="<?php echo isset($row['branch_name']) ? $row['branch_name'] : ''; ?>">
												</div>
											</div>

											<div class="col-lg-4">
												<div class="form-group mb-4">
													<label for="account_type">Account Type <span style="color:red;font-weight:bold">*</span> </label>
													<select class="form-control" id="account_type" name="account_type" required>
														<option value="">Select Account Type</option>
														<option value="savings" <?php echo (isset($row['account_type']) && $row['account_type'] == 'savings') ? 'selected' : ''; ?>>Savings</option>
														<option value="current" <?php echo (isset($row['account_type']) && $row['account_type'] == 'current') ? 'selected' : ''; ?>>Current</option>
													</select>
												</div>
											</div>

											<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['id']?>">
											<div class="modal-footer px-4">
												<button type="button"  class="btn btn-primary btn-pill btnPrevious">Previous</button>
												<button type="submit" name="submit" id="submit" onclick="bankdetails()" class="btn btn-primary btn-pill btnNext">Save Details</button>
											</div>
										</div>
									</div>
									
								</div>
							</form>
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

	<!-- Option Switcher -->
	<script src="assets/plugins/options-sidebar/optionswitcher.js"></script>

	<!-- Ekka Custom -->
	<script src="assets/js/ekka.js"></script>
	<script src="assets/js/manual.js"></script>

</body>

</html>
<script>
$('.btnPrevious').click(function() {
  const prevTabLinkEl = $('.nav-tabs .active').closest('li').prev('li').find('a')[0];
  const prevTab = new bootstrap.Tab(prevTabLinkEl);
  prevTab.show();
});
</script>


<script>
	function toggleDisabilityId(select) {
		var disabilityIdDiv = document.getElementById('disability_id_div');
		if (select.value === 'yes') {
			disabilityIdDiv.style.display = 'block';
		} else {
			disabilityIdDiv.style.display = 'none';
		}
	}
</script>

<script>
	document.getElementById('sameAddress').addEventListener('change', function() {
		if (this.checked) {
			document.getElementById('peraddress').value = document.getElementById('curaddress').value;
		} else {
			document.getElementById('peraddress').value = '';
		}
	});

	$(document).ready(function () {
		$('#company').change(function () {
			var companyId = $(this).val();
			var shortName = $('option:selected', this).attr('data-shortname');

			if (companyId !== '') {
				$.ajax({
					url: "ajax/get_next_emp_id.php",
					type: "POST",
					data: { company_id: companyId, short_name: shortName },
					success: function (response) {
						$('#emp_id').val(response);
					}
				});
			} else {
				$('#emp_id').val('');
			}
		});
	});

	function validateAadhar(input) {
		let value = input.value.replace(/\D/g, ''); 
		if (value.length > 12) {
			value = value.slice(0, 12); 
		}
		input.value = value;
	}
</script>


<script>
	function personalValidate(){
	 // $('#persnol_submit').click(function(){
		var firstName = document.getElementById('firstname')
		var lastname = document.getElementById('lastname')
		var perphone = document.getElementById('perphone')
		var peremail = document.getElementById('peremail')
		var gender = document.getElementById('gender')
		var birthdaydate = document.getElementById('birthdaydate')
		var marital = document.getElementById('marital')
		var bloodgroup = document.getElementById('bloodgroup')
		var disability = document.getElementById('disability')
		var aadharcardno = document.getElementById('aadharcardno')
		var pancardno = document.getElementById('pancardno')
		var curaddress = document.getElementById('curaddress')
		var peraddress = document.getElementById('peraddress')
		var rname = document.getElementById('rname')
		var relationship = document.getElementById('relationship')
		var contactnumber = document.getElementById('contactnumber')
		
		var errorVal = 0;
		if(firstName.value==""){
			errorVal++;
			firstName.style.border='1px solid red'
		}else{
			firstName.style.border='1px solid green'
		}

		if(lastname.value==""){
			errorVal++;
			lastname.style.border='1px solid red' 
		}else{
			lastname.style.border='1px solid green'
		}

		if(perphone.value==""){
			errorVal++;
			perphone.style.border='1px solid red'
		}else{
			perphone.style.border='1px solid green'
		}

		if(peremail.value==""){
			errorVal++;
			peremail.style.border='1px solid red'
		}else{
			peremail.style.border='1px solid green'
		}

		if(gender.value==""){
			errorVal++;
			gender.style.border='1px solid red'
		}else{
			gender.style.border='1px solid green'
		}

		if(birthdaydate.value==""){
			errorVal++;
			birthdaydate.style.border='1px solid red'
		}else{
			birthdaydate.style.border='1px solid green'
		}

		if(marital.value==""){
			errorVal++;
			marital.style.border='1px solid red'
		}else{
			marital.style.border='1px solid green'
		}

		if(bloodgroup.value==""){
			errorVal++;
			bloodgroup.style.border='1px solid red'
		}else{
			bloodgroup.style.border='1px solid green'
		}

		if(disability.value==""){
			errorVal++;
			disability.style.border='1px solid red'
		}else{
			disability.style.border='1px solid green'
		}

		if(aadharcardno.value==""){
			errorVal++;
			aadharcardno.style.border='1px solid red'
		}else{
			aadharcardno.style.border='1px solid green'
		}

		if(pancardno.value==""){
			errorVal++;
			pancardno.style.border='1px solid red'
		}else{
			pancardno.style.border='1px solid green'
		}

		if(curaddress.value==""){
			errorVal++;
			curaddress.style.border='1px solid red'
		}else{
			curaddress.style.border='1px solid green'
		}

		if(peraddress.value==""){
			errorVal++;
			peraddress.style.border='1px solid red'
		}else{
			peraddress.style.border='1px solid green'
		}

		if(rname.value==""){
			errorVal++;
			rname.style.border='1px solid red'
		}else{
			rname.style.border='1px solid green'
		}

		if(relationship.value==""){
			errorVal++;
			relationship.style.border='1px solid red'
		}else{
			relationship.style.border='1px solid green'
		}

		if(contactnumber.value==""){
			errorVal++;
			contactnumber.style.border='1px solid red'
		}else{
			contactnumber.style.border='1px solid green'
		}
		
		if(errorVal == 0){
			// $('.btnNext').click(function() {
			  const nextTabLinkEl = $('.nav-alltabs .active').closest('li').next('li').find('a')[0];
			//   alert(nextTabLinkEl);
			  const nextTab = new bootstrap.Tab(nextTabLinkEl);
			  nextTab.show();
			// });
		}
	};

	function officialValidate(){
		// $('#official_submit').click(function(){

		var company = document.getElementById('company')
		var emp_id = document.getElementById('emp_id')
		var joindaydate = document.getElementById('joindaydate')
		var offemail = document.getElementById('offemail')
		var department = document.getElementById('department')
		// var designation = document.getElementById('designation')
		var roll = document.getElementById('roll')
		// var report = document.getElementById('report')
		var employeetype = document.getElementById('employeetype')
		var salaryamo = document.getElementById('salaryamo')

		var officialError = 0;
		
		if(company.value ==""){
			officialError++;
			company.style.border='1px solid red'
		}else{
			company.style.border='1px solid green'
		}

		if(emp_id.value==""){
			officialError++;
			emp_id.style.border='1px solid red'
		}else{
			emp_id.style.border='1px solid green'
		}

		if(joindaydate.value==""){
			officialError++;
			joindaydate.style.border='1px solid red'
		}else{
			joindaydate.style.border='1px solid green'
		}

		if(offemail.value==""){
			officialError++;
			offemail.style.border='1px solid red'
		}else{
			offemail.style.border='1px solid green'
		}

		if(department.value==""){
			officialError++;
			department.style.border='1px solid red'
		}else{
			department.style.border='1px solid green'
		}

		// if(designation.value ==""){
		// 	officialError++;
		// 	designation.style.border='1px solid red'
		// }else{
		// 	designation.style.border='1px solid green'
		// }

		if(roll.value ==""){
			officialError++;
			roll.style.border='1px solid red'
		}else{
			roll.style.border='1px solid green'
		}

		// if(report.value==""){
		// 	officialError++;
		// 	report.style.border='1px solid red'
		// }else{
		// 	report.style.border='1px solid green'
		// }

		if(employeetype.value==""){
			officialError++;
			employeetype.style.border='1px solid red'
		}else{
			employeetype.style.border='1px solid green'
		}

		if(salaryamo.value==""){
			officialError++;
			salaryamo.style.border='1px solid red'
		}else{
			salaryamo.style.border='1px solid green'
		}
		
		if(officialError == 0){
			// $('.btnNext').click(function() {
			  const nextTabLinkEl = $('.nav-alltabs .active').closest('li').next('li').find('a')[0];
			  const nextTab = new bootstrap.Tab(nextTabLinkEl);
			  nextTab.show();
			// });
		}
	};

	function documentValidate(){
		// $('#document_submit').click(function(){
		var aadharcard = document.getElementById('aadharcard')
		var aadharcardEdit = document.getElementById('aadharcard1')

		var documentErr = 0;
		if(aadharcard.value=="" && aadharcardEdit.value==""){
			documentErr++;
			aadharcard.style.border='1px solid red'
		}else{
			aadharcard.style.border='1px solid green'
		}
		if(documentErr == 0){
			// $('.btnNext').click(function() {
			  const nextTabLinkEl = $('.nav-alltabs .active').closest('li').next('li').find('a')[0];
			  const nextTab = new bootstrap.Tab(nextTabLinkEl);
			  nextTab.show();
			// });
		}
	};

	function assets(){
		// $('.btnNext').click(function() {
			const nextTabLinkEl = $('.nav-alltabs .active').closest('li').next('li').find('a')[0];
			const nextTab = new bootstrap.Tab(nextTabLinkEl);
			nextTab.show();
		// });
	}

	function bankdetails(){
		var bank_name = document.getElementById('bank_name')
		var account_number = document.getElementById('account_number')
		var ifsc_code = document.getElementById('ifsc_code')
		var account_type = document.getElementById('account_type')

		var bankErr = 0;
		if(bank_name.value==""){
			bankErr++;
			bank_name.style.border='1px solid red'
		}else{
			bank_name.style.border='1px solid green'
		}

		if(account_number.value==""){
			bankErr++;
			account_number.style.border='1px solid red'
		}else{
			account_number.style.border='1px solid green'
		}

		if(ifsc_code.value==""){
			bankErr++;
			ifsc_code.style.border='1px solid red'
		}else{
			ifsc_code.style.border='1px solid green'
		}

		if(account_type.value==""){
			bankErr++;
			account_type.style.border='1px solid red'
		}else{
			account_type.style.border='1px solid green'
		}

		if(bankErr == 0){
			  const nextTabLinkEl = $('.nav-alltabs .active').closest('li').next('li').find('a')[0];
			  const nextTab = new bootstrap.Tab(nextTabLinkEl);
			  nextTab.show();
		}
	};
</script>
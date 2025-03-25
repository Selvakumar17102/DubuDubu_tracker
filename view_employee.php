<?php

session_start();
ini_set("display_errors",'off');
include('include/connection.php');
$employee = 'active';
$emp_boolean = 'true';

if(isset($_GET['edit_id'])){
    $id=$_GET['edit_id'];
    $sql = "SELECT * FROM employee a LEFT JOIN designation b ON a.designation = b.desig_id WHERE a.id='$id'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result);
}

if(isset($_POST['update'])){
	$id = $_POST['user_id'];
	$password = $_POST['UserPassword'];

	$updateSql = "UPDATE employee SET password='$password' WHERE id=$id";
    $updateResult = $conn->query($updateSql);
	if ($updateResult == TRUE) {
		$error='<div class="alert alert-success">Password Updated Successfull !</div>';
	}else {
		$error='<div class="alert alert-danger">OOPS Password </div>';
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

	<title>DUBU DUBU - View Page.</title>

	<!-- GOOGLE FONTS -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

	<link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


	<!-- PLUGINS CSS STYLE -->
	<link href="assets/plugins/simplebar/simplebar.css" rel="stylesheet" />
	<link href='assets/plugins/daterangepicker/daterangepicker.css' rel='stylesheet'>

	<!-- Ekka CSS -->
	<link id="ekka-css" rel="stylesheet" href="assets/css/ekka.css" />

	<!-- FAVICON -->
	<link href="assets/img/favicon.png" rel="shortcut icon" />

</head>
<style>
	th,td{
		font-size:15px;
	}
	.new-class{
		text-align: center;
	}
	.card-mini {
		background: aliceblue;
	}
	.roundcircles{
		border-radius: 50% !important;
		width:230px;
		height: 225px;
		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(1, 2, 0, 1.19);
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
							<h1>Employee Detail</h1>
							<br>
							<div>
							  <a class="btn btn-primary" href="javascript:history.go(-1)">Back</a>
							</div>
						</div>
						<div>
							<a href="add_employee.php?edit_id=<?php echo $row['id']?>" class="btn btn-primary"> Edit</a>
						</div>
					</div>
						<div class="form-group">
        					<div class="col-sm-12 ">
            					<?php echo $error; ?>
        					</div>
    					</div>
					<div class="row">
						<div class="col-12">
							<div class="card card-default">
								<div class="card-header card-header-border-bottom" style="background-color:#bbc2c730">
									<div class="col-3" style="text-align:center">
									<?php
									if($row['emp_photo'] ==""){
										?>
										<img src="https://www.pngkey.com/png/detail/305-3050875_employee-parking-add-employee-icon-png.png" class="img-responsive rounded-circle" alt="Avatar Image" width="200" height="170">
										<?php
									}else{
										?>
										<img src="<?php echo $row['emp_photo']?>" class="img-responsive rounded-circle roundcircles" alt="Avatar Image" width="200" height="170">
										<?php
									}
									?>
									</div>
									<div class="col-7">
										<div class="d-flex pb-2">
											<div>
												<strong class="text-dark" style="font-size:30px"><?php echo $row['fname']?> <?php echo $row['lname']?></strong>
											</div>
											<div style="padding:10px 0 0 15px">
												<span class="badge badge-primary"><?php echo $row['designation_name'];?></span>
											</div>
										</div>
										<!-- <div class="text-dark pb-3"><strong style="font-size:30px"><?php echo $row['fname']?><?php echo $row['lname']?></strong>  <span class="badge badge-primary"><?php echo $row['designation'];?></span></div> -->
										<p class="text-dark pb-2"><strong>Employee Id :</strong><?php echo $row['emp_id']?></p>
										<p class="text-dark pb-3"><strong>Date Of Join :</strong><?php echo $row['doj']?></p>
										<?php
										if($row['emp_status'] == 'Active'){
										?>
										<p><span class="mb-2 mr-2 badge badge-success"><?php echo $row['emp_status'];?></span></p>
										<?php
										}else{
											?>
											<p><span class="mb-2 mr-2 badge badge-danger"><?php echo $row['emp_status'];?></span></p>
											<?php
										}
										?>
									</div>
									<div class="col-2"style="text-align:center">
									<input type="hidden" name="userId" id="userId" value="<?php echo $row['id']?>">
									<!-- <a href="emp_details.php?get_id=<?php echo $row['id']?>" class="btn btn-primary"><i class="mdi mdi-cloud-download"></i> Download</a> -->
									</div>
								</div>
								<div class="card-body product-detail">
									<div class="row">
									<div class="col-sm-3 align-items-start">
  										<div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
  										  <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true" style='font-size: larger;text-align:left'>Personal Details</button>
  										  <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false" style='font-size: larger;text-align:left'>Official Details</button>
  										  <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false" style='font-size: larger;text-align:left'>Documents</button>
  										  <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false" style='font-size: larger;text-align:left'>Assets Management</button>
										  <button class="nav-link" id="v-pills-contect-tab" data-bs-toggle="pill" data-bs-target="#v-pills-contect" type="button" role="tab" aria-controls="v-pills-contect" aria-selected="false" style='font-size: larger;text-align:left'>Emergency Contact Details</button>
										  <button class="nav-link" id="v-pills-bank-tab" data-bs-toggle="pill" data-bs-target="#v-pills-bank" type="button" role="tab" aria-controls="v-pills-bank" aria-selected="false" style='font-size: larger;text-align:left'>Bank Details</button>
  										</div>
									</div>
									<div class="col-sm-9">
  										<div class="tab-content pt-5" id="v-pills-tabContent">
  											<div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
												<table id="responsive-data-table" class="table">
													<tr>
														<th>Office Email</th>
														<td><?php echo $row['oemail'];?></td>
													</tr>
													<tr>
														<th class="col-5">Personal Email</th>
														<td><?php echo $row['pemail'];?></td>
													</tr>
													<tr>
														<th>Aadhar number</th>
														<td><?php echo $row['aadharcardno'];?></td>
													</tr>
													<tr>
														<th>Pan Card Number</th>
														<td><?php echo $row['pan_card_no'];?></td>
													</tr>
													<tr>
														<th>Primary Phone Number</th>
														<td><?php echo $row['pphno'];?></td>
													</tr>
													<tr>
														<th>Gender</th>
														<td><?php echo $row['gender'];?></td>
													</tr>
													<tr>
														<th>Marital Status</th>
														<td><?php echo $row['marital'];?></td>
													</tr>
													<tr>
														<th>Birth Date</th>
														<td>
															<?php $birthdate=$row['dob'];
															$newDate = date("d-m-Y", strtotime($birthdate));
															echo $newDate;
															?>
														</td>
													</tr>
													<tr>
														<th>Joining Date</th>
														<td>
															<?php $joinDate=$row['doj'];
															$Date = date("d-m-Y", strtotime($joinDate));
															echo $Date;
															?>
														</td>
													</tr>
													<?php
													if($row['emp_status'] != 'Active'){
														?>
														<tr>
														<th>Resign Date</th>
														<td>
															<?php
															$resignDate=$row['resign_date'];
															$DateOfResign = date("d-m-Y", strtotime($resignDate));
															echo $DateOfResign;
															?>
														</td>
													</tr>
													<?php
													}
													?>
													<tr>
														<th>Blood Group</th>
														<td><?php echo $row['blood_group'];?></td>
													</tr>
													<tr>
													<th>Disability</th>
														<td>
															<?php 
																if ($row['disability'] == 'yes') {
																	echo "Yes (ID: " . $row['disability_id'] . ")";
																} else {
																	echo "No";
																}
															?>
														</td>
													</tr>
													<tr>
														<th>Permanent Address</th>
														<td><?php echo $row['paddress'];?></td>
													</tr>
													<tr>
														<th>Current Address</th>
														<td><?php echo $row['caddress'];?></td>
													</tr>
												</table>
											</div>
  										  	<div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
												<table id="responsive-data-table" class="table">
														<tr>
															<th>Department</th>
															<td>
																<?php 
																$depsql = "SELECT * FROM department WHERE id = '" . $row['department'] . "'";
																$depresult = $conn->query($depsql);
    															$deprow = mysqli_fetch_array($depresult);
																echo $deprow['dept_name'];
																?>
															</td>
														</tr>
														<tr>
															<th>Designation</th>
															<td>
																<?php
																$desisql = "SELECT * FROM designation WHERE desig_id = '" . $row['designation'] . "'";
																$desiresult = $conn->query($desisql);
    															$desirow = mysqli_fetch_array($desiresult);
																echo $desirow['designation_name'];
																 ?>
															</td>
														</tr>
														<tr>
															<th> Employee Roll</th>
															<td><?php echo $row['emp_roll'];?></td>
														</tr>
														<tr>
															<th>Reporting To</th>
															<?php
															$report = $row['emp_report_to'];
															$rep_sql = "SELECT * FROM employee WHERE id IN ($report)";
															$rep_res = $conn->query($rep_sql);
															// $rep_row = mysqli_fetch_array($rep_res);
															?>
															<td>
																<?php
																while($rep_row = mysqli_fetch_array($rep_res)){
																	echo $rep_row['fname']." ".$rep_row['lname'];
																	echo ",  ";
																}
																?>
															</td>
															<!-- <td><?php echo $rep_row['fname'];?> <?php echo $rep_row['lname'];?></td> -->
														</tr>
														<tr>
															<th>Employee Type</th>
															<td><?php echo $row['emp_type'];?></td>
														</tr>
														<tr>
															<th>Employee Status</th>
															<?php
															if($row['emp_status'] == 'Active'){
															?>
															<td><span class="mb-2 mr-2 badge badge-success"><?php echo $row['emp_status'];?></span></td>
															<?php
															}else{
																?>
																<td><span class="mb-2 mr-2 badge badge-danger"><?php echo $row['emp_status'];?></span></td>
																<?php
															}
															?>
														</tr>
														
														<tr>
															<th>Salary</th>
															<td><?php echo $row['basic_salary'];?></td>
														</tr>
														<tr>
															<th>User Name</th>
															<td><?php echo $row['username'];?></td>
														</tr>
														<tr>
															<th>User Password</th>
															<form method="post">
																<input type="hidden" name="user_id" value="<?php echo $row['id']?>">
																<input type="hidden" name= "UserPassword" value="<?php echo $row['emp_id']?>">
																<td> <input type="password" name="password" disabled value="<?php echo $row['password'];?>" style="border:hidden">  <input type="submit" name="update" value="Reset Password" class="btn btn-primary"></td>
															</form>
														</tr>
												</table>
										  	</div>
  										  	<div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
												<?php
												if($row['aadhar'] != ""){
													$aadharview = "block";
												}else{
													$aadharview = "none";
												}

												if($row['pan'] != ""){
													$panview = "block";
												}else{
													$panview = "none";
												}

												if($row['experience'] != ""){
													$expview = "block";
												}else{
													$expview = "none";
												}

												if($row['resume'] != ""){
													$resview = "block";
												}else{
													$resview = "none";
												}

												if($row['reliving'] != ""){
													$relview = "block";
												}else{
													$relview = "none";
												}

												if($row['payslip'] !=""){
													$payview = "block";
												}else{
													$payview = "none";
												}

												if($row['degreecertificate'] != ""){
													$cerview = "block";
												}else{
													$cerview = "none";
												}

												?>
												<div class="row">
													<div class="col-xl-4 col-sm-6 p-b-15 lbl-card" style="display:<?php echo $aadharview;?>">
														<a href="<?php echo $row['aadhar']?>" target="_blank">
															<div class="card card-mini dash-card card-1">
																<div class="card-body new-class">
																	<i class="fa fa-file-pdf-o" style="font-size:48px;color:red"></i>
																	<h5>Aadhar Card</h5>
																</div>
															</div>
														</a>
													</div>
													<div class="col-xl-4 col-sm-6 p-b-15 lbl-card" style="display:<?php echo $panview;?>">
														<a href="<?php echo $row['pan']?>" target="_blank">
															<div class="card card-mini dash-card card-1">
																<div class="card-body new-class">
																	<i class="fa fa-file-pdf-o" style="font-size:48px;color:red"></i>
																	<h5>Pan Card</h5>
																</div>
															</div>
														</a>
													</div>
													<div class="col-xl-4 col-sm-6 p-b-15 lbl-card" style="display:<?php echo $expview;?>">
														<a href="<?php echo $row['experience']?>" target="_blank">
															<div class="card card-mini dash-card card-1">
																<div class="card-body new-class">
																	<i class="fa fa-file-pdf-o" style="font-size:48px;color:red"></i>
																	<h5>Experience</h5>
																</div>
															</div>
														</a>
													</div>
													<div class="col-xl-4 col-sm-6 p-b-15 lbl-card" style="display:<?php echo $resview;?>">
														<a href="<?php echo $row['resume']?>" target="_blank">
															<div class="card card-mini dash-card card-1">
																<div class="card-body new-class">
																	<i class="fa fa-file-pdf-o" style="font-size:48px;color:red"></i>
																	<h5>Resume</h5>
																</div>
															</div>
														</a>
													</div>
													<div class="col-xl-4 col-sm-6 p-b-15 lbl-card" style="display:<?php echo $cerview;?>">
														<a href="<?php echo $row['degreecertificate']?>" target="_blank">
															<div class="card card-mini dash-card card-1">
																<div class="card-body new-class">
																	<i class="fa fa-file-pdf-o" style="font-size:48px;color:red"></i>
																	<h5>Degree Certificate</h5>
																</div>
															</div>
														</a>
													</div>
													<div class="col-xl-4 col-sm-6 p-b-15 lbl-card" style="display:<?php echo $payview;?>">
														<a href="<?php echo $row['payslip']?>" target="_blank">
															<div class="card card-mini dash-card card-1">
																<div class="card-body new-class">
																	<i class="fa fa-file-pdf-o" style="font-size:48px;color:red"></i>
																	<h5>Pay Slip</h5>
																</div>
															</div>
														</a>
													</div>
													<div class="col-xl-4 col-sm-6 p-b-15 lbl-card" style="display:<?php echo $relview;?>">
														<a href="<?php echo $row['reliving']?>" target="_blank">
															<div class="card card-mini dash-card card-1">
																<div class="card-body new-class">
																	<i class="fa fa-file-pdf-o" style="font-size:48px;color:red"></i>
																	<h5>Relieving</h5>
																</div>
															</div>
														</a>
													</div>
												</div>
										  	</div>
  										  	<div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
												<table id="responsive-data-table" class="table">
													<tr>
														<th class="col-5">System Type</th>
														<td><?php echo $row['system_type'];?></td>
													</tr>
													<tr>
														<th>Spare Gadgets</th>
														<td><?php echo $row['spare'];?></td>
													</tr>
													<tr>
														<th>System Id</th>
														<td><?php echo $row['system_id'];?></td>
													</tr>
												</table>
										  	</div>
										  	<div class="tab-pane fade" id="v-pills-contect" role="tabpanel" aria-labelledby="v-pills-contect-tab">
										  		<table id="responsive-data-table" class="table">
													<tr>
														<th class="col-5">Relation Name</th>
														<td><?php echo $row['rname'];?></td>
													</tr>
													<tr>
														<th>Relationship</th>
														<td><?php echo $row['relationship'];?></td>
													</tr>
													<tr>
														<th>Contact Number</th>
														<td><?php echo $row['contactnumber'];?></td>
													</tr>
												</table>
										  	</div>
											<div class="tab-pane fade" id="v-pills-bank" role="tabpanel" aria-labelledby="v-pills-bank-tab">
										  		<table id="responsive-data-table" class="table">
													<tr>
														<th class="col-5">Bank Name</th>
														<td><?php echo $row['bank_name'];?></td>
													</tr>
													<tr>
														<th class="col-5">Account Number</th>
														<td><?php echo $row['account_number'];?></td>
													</tr>
													<tr>
														<th class="col-5">IFSC Code</th>
														<td><?php echo $row['ifsc_code'];?></td>
													</tr>
													<tr>
														<th>Branch Name</th>
														<td><?php echo $row['branch_name'];?></td>
													</tr>
													<tr>
														<th>Account Type</th>
														<td><?php echo $row['account_type'];?></td>
													</tr>
												</table>
										  	</div>
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
	<script src="assets/plugins/simplebar/simplebar.min.js"></script>
	<script src="assets/plugins/jquery-zoom/jquery.zoom.min.js"></script>
	<script src="assets/plugins/slick/slick.min.js"></script>

	<!-- Date Range Picker -->
	<script src='assets/plugins/daterangepicker/moment.min.js'></script>
	<script src='assets/plugins/daterangepicker/daterangepicker.js'></script>
	<script src='assets/js/date-range.js'></script>

	<!-- Option Switcher -->
	<script src="assets/plugins/options-sidebar/optionswitcher.js"></script>

	<!-- Ekka Custom -->
	<script src="assets/js/ekka.js"></script>
	<script src="assets/js/manual.js"></script>
</body>

</html>
<script>
	// var userId = $('#userId').val();
	// // alert(userId);
    //     $.ajax({
    //         url : 'emp_details.php',
    //         type : 'POST',
    //         data : {
    //             get_id : userId,
    //         },
    //         success : function(data){
    //             $('#team').val(data);
    //         }
    //     });
</script>
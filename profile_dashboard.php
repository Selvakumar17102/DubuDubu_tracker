<?php

session_start();
ini_set("display_errors",'off');

include('include/connection.php');
$profiledashboard = "active";
$profiledashboardBoolean = 'true';

if(isset($_SESSION['id'])){
    $id=$_SESSION['id'];
    $sql = "SELECT * FROM employee WHERE id=$id";
    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result);
}

// if(isset($_POST['update'])){
// 	$id = $_POST['user_id'];
// 	$password = $_POST['UserPassword'];

// 	$updateSql = "UPDATE employee SET password='$password' WHERE id=$id";
//     $updateResult = $conn->query($updateSql);
// 	if ($updateResult == TRUE) {
// 		$error='<div class="alert alert-success">Password Updated Successfull !</div>';
// 	}else {
// 		$error='<div class="alert alert-danger">OOPS Password </div>';
// 	}
// }
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Ekka - Admin Dashboard HTML Template.">

	<title>DUBU DUBU - Profile-Dashboard.</title>

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
						<h1>Personal Information</h1>
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
												<span class="badge badge-primary"><?php echo $row['designation'];?></span>
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
								</div>
								<div class="card-body product-detail">
									<div class="row">
									<div class="col-sm-12">
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
														<th>Skype</th>
														<td><?php echo $row['skype'];?></td>
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
														<th>Secondary Phone Number</th>
														<td><?php echo $row['sphno'];?></td>
													</tr>
													<tr>
														<th>Whatsapp Number</th>
														<td><?php echo $row['wphno'];?></td>
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
														<th>Permanent Address</th>
														<td><?php echo $row['paddress'];?></td>
													</tr>
													<tr>
														<th>Current Address</th>
														<td><?php echo $row['caddress'];?></td>
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
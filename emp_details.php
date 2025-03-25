<?php

session_start();
ini_set("display_errors",'off');
include('include/connection.php');
$employee = 'active';
$emp_boolean = 'true';

if(isset($_GET['get_id'])){
    $id=$_GET['get_id'];
    $sql = "SELECT * FROM employee WHERE id=$id";
    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result);
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
    .nav-link{
        background: #1280e5;
        color: white;
        font-weight: bold;
        -webkit-print-color-adjust: exact;
    }
	@page { size:8.5in 11in; margin: 1cm 1cm 1cm 1cm }
	

</style>

<body class="ec-header-fixed ec-sidebar-fixed ec-sidebar-dark ec-header-light" id="body" onload="window.print()">

	<div class="ec-content-wrapper">
				<div class="content" id="downloadId">
					<div class="row">
                            <div class="logo d-flex justify-content-center">
                                <img src="assets/img/logo/fullname_logo.png" width="400px" alt="">
                            </div>
						<div class="col-12">
							<div class="card card-default">
								<div class="card-header card-header-border-bottom">
									<div class="col-5">
									<?php
									if($row['emp_photo'] ==""){
										?>
										<img src="https://www.pngkey.com/png/detail/305-3050875_employee-parking-add-employee-icon-png.png" class="img-responsive rounded-circle" alt="Avatar Image" width="200" height="170">
										<?php
									}else{
										?>
										<img src="<?php echo $row['emp_photo']?>" class="img-responsive rounded-circle" alt="Avatar Image" width="200" height="170">
										<?php
									}
									?>
									</div>
									<div class="col-7">
										<div class="d-flex pb-2">
											<div>
												<strong class="text-dark" style="font-size:30px"><?php echo $row['fname']?> <?php echo $row['lname']?></strong>
											</div>
											<!-- <div style="padding:10px 0 0 15px">
												<span class="badge badge-primary"><?php echo $row['designation'];?></span>
											</div> -->
										</div>
										<p class="text-dark pb-2"><strong>Employee Id :</strong><?php echo $row['emp_id']?></p>
										<p class="text-dark pb-3"><strong>DOJ :</strong><?php echo $row['doj']?></p>
										<p class="text-dark pb-3"><strong>Designation :</strong><?php echo $row['designation'];?></p>
									</div>
								</div>
								<div class="card-body product-detail">
									<div class="row">
									    <div class="col-sm-12 align-items-start mb-5">
  									    	<div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
  									    	  <button class="nav-link active" style='font-size: larger;text-align:center'>Personal Details</button>
  									    	</div>
									    </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <table id="responsive-data-table" class="table">
													<tr>
														<th>Office Email</th>
														<td><?php echo $row['oemail'];?></td>
													</tr>
													<tr>
														<th>Personal Email</th>
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
												    	<th>Birth Date</th>
												    	<td>
												    		<?php $birthdate=$row['dob'];
												    		$newDate = date("d-m-Y", strtotime($birthdate));
												    		echo $newDate;
												    		?>
												    	</td>
											        </tr>
												<!-- </table> -->
                                            </div>
                                            <div class="col-sm-6">
                                                <!-- <table id="responsive-data-table" class="table"> -->
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
                                            <!-- <div class="col-sm-4">
                                                <table id="responsive-data-table" class="table">
                                                    
													
                                                </table>
                                            </div> -->
                                        </div>
                                        <div class="col-sm-12 align-items-start mb-5">
  									    	<div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
  									    	  <button class="nav-link active" style='font-size: larger;text-align:center'>Official Details</button>
  									    	</div>
									    </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <table id="responsive-data-table" class="table">
													<tr>
														<th>Team</th>
														<td><?php echo $row['team'];?></td>
													</tr>
													<tr>
														<th>Divisions</th>
														<td><?php echo $row['division'];?></td>
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
														?>
														<td>
															<?php
															while($rep_row = mysqli_fetch_array($rep_res)){
																echo $rep_row['fname']." ".$rep_row['lname'];
																echo ",  ";
															}
															?>
														</td>
													</tr>
													<tr>
														<th>Location</th>
														<td><?php echo $row['location'];?></td>
													</tr>
                                                <!-- </table> -->
                                            </div>
                                            <div class="col-sm-6">
                                                <!-- <table id="responsive-data-table" class="table"> -->
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
												    	<th>Designation</th>
												    	<td><?php echo $row['designation'];?></td>
												    </tr>
												    <tr>
												    	<th>Salary</th>
												    	<td><?php echo $row['basic_salary'];?></td>
												    </tr>
                                                    <tr>
														<th>User Name</th>
														<td><?php echo $row['username'];?></td>
													</tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 align-items-start mb-5">
  									    	<div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                              <button class="nav-link active" style='font-size: larger;text-align:center'>Assets Management</button>
  									    	</div>
									    </div>
										<div class="row">
                                            <div class="col-sm-6">
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
														<th>System Configuration</th>
														<td><?php echo $row['configuration'];?></td>
													</tr>
													<tr>
														<th>System Id</th>
														<td><?php echo $row['system_id'];?></td>
													</tr>
											    </table>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 align-items-start mb-5">
  									    	<div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                              <button class="nav-link active" style='font-size: larger;text-align:center'>Emergency Contact Details</button>
  									    	</div>
									    </div>
                                        <div class="row">
                                            <div class="col-sm-6">
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
                                        </div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div> <!-- End Content -->
                <!-- <div class="row mt-3">
                    <div class="col-sm-5"></div>
                    <div class="col-sm-2 align-items-start">
  	                	<div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
  	                	  <button class="btn btn-success" onclick="download()" style='font-size: larger;text-align:center'><i class="mdi mdi-cloud-download"></i> Download</button>
  	                	</div>
	                </div>
                    <div class="col-sm-5"></div>
                </div> -->
	</div> <!-- End Content Wrapper -->
    


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
    
    //     $(window).on("load", function () {
       
    //         var printContents = document.getElementById("downloadId").innerHTML;
	// 		var originalContents = document.body.innerHTML;

	// 		document.body.innerHTML = printContents;

    //         var css = '@page { size: landscape; }',
    //             head = document.head || document.getElementsByTagName('head')[0],
    //             style = document.createElement('style');
                
    //         style.type = 'text/css';
    //         style.media = 'print';
                
    //         if (style.styleSheet){
    //           style.styleSheet.cssText = css;
    //         } else {
    //           style.appendChild(document.createTextNode(css));
    //         }
            
    //         head.appendChild(style);

	// 		// window.print();  

	// 		document.body.innerHTML = originalContents;
    // });
</script>
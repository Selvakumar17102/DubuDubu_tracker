<?php
session_start();
ini_set("display_errors",'off');
include("include/connection.php");
include("timeSheet-function.php");
$project = 'active';
$projectBoolean = 'true';

// if(isset($_POST['project_submit'])){
// 	$id = $_POST['editId'];
//     $client = $_POST['client'];
//     $project = $_POST['project'];

//     $dep = $_POST['department'];
//     $department =implode(",",$dep);
    
//     $startDate = $_POST['startdate'];
//     $deadline =$_POST['deadline'];
//     $manhour =$_POST['manhour'];
// 	$nonbill = $_POST['nonbill'];
//     $status =$_POST['status'];

// 	if($id > 0){
// 		$updateSql = "UPDATE project SET client_id='$client', project_name='$project', department='$department', start_date='$startDate', dead_line_date='$deadline', billing_hours='$manhour', non_billing_hours='$nonbill', project_status='$status' WHERE id='$id'" ;
// 		if($conn->query($updateSql) == TRUE){
// 			header('location: project.php?msg=Project Updated Successfully !&type=warning');
//     	}

// 	}
// 	else{
// 		$pro_sql = "SELECT * FROM project WHERE project_name = '$project' AND project_status != 'Closed'";
// 		$pro_result = $conn->query($pro_sql);
// 		if($pro_result->num_rows > 0){
// 			// $msg = '<div class="alert alert-danger text-center" id="alert_msg">Project name is already exists.</div>';
// 			header('location: project.php?msg=Project name is already exists&type=failed');
// 		}
// 		else{
// 			$insertSql = "INSERT INTO project (client_id,project_name,department,start_date,dead_line_date,billing_hours,non_billing_hours,project_status) VALUES('$client','$project','$department','$startDate','$deadline','$manhour','$nonbill','$status')";
//     		if($conn->query($insertSql) == TRUE){
//     		    header('location: project.php?msg=Project Added !&type=success');
//     		}
// 		}
// 	}
// 	// else{
// 	// 	$pro_sql = "SELECT * FROM project WHERE project_name = '$project'";
// 	// 	// echo $pro_sql;exit();
// 	// 	$pro_result = $conn->query($pro_sql);
// 	// 	if($pro_result->num_rows > 0){
// 	// 		// echo $pro_result->num_rows;
// 	// 		// var_dump(mysqli_fetch_array($pro_result)); exit();
// 	// 		while($pro_row = mysqli_fetch_array($pro_result)){
// 	// 			if($pro_row['project_status'] != 'Yet To Start' && $pro_row['project_status'] != 'On Going' && $pro_row['project_status'] != 'Completed'){
// 	// 				// echo "Demo";
// 	// 				// echo $pro_row['project_status']."<br>";
// 	// 				$insertSql = "INSERT INTO project (client_id,project_name,department,start_date,dead_line_date,billing_hours,non_billing_hours,project_status) VALUES('$client','$project','$department','$startDate','$deadline','$manhour','$nonbill','$status')";
// 	// 				if($conn->query($insertSql) == TRUE){
// 	// 					$msg='<div class="alert alert-success text-center" id="alert_msg">Project Created Successfully !</div>';
// 	// 				}
// 	// 			}
// 	// 			else{
// 	// 				// echo "TEST";
// 	// 				$msg = '<div class="alert alert-danger text-center" id="alert_msg">Project name is already exists.</div>';
// 	// 			}
// 	// 		}
// 	// 		// exit();
// 	// 	} else{
// 	// 		$insertSql = "INSERT INTO project (client_id,project_name,department,start_date,dead_line_date,billing_hours,non_billing_hours,project_status) VALUES('$client','$project','$department','$startDate','$deadline','$manhour','$nonbill','$status')";
//     // 		if($conn->query($insertSql) == TRUE){
//     // 		    $msg='<div class="alert alert-success text-center" id="alert_msg">Project Created Successfully !</div>';
//     // 		}
// 	// 	}
// 	// }
// }

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Ekka - Admin Dashboard HTML Template.">

	<title>Dubu Dubu - Project</title>

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
    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
    border: 1px solid #eeeeee !important;
    width: 480px;
    border-radius: 15px;
}
</style>

<body class="ec-header-fixed ec-sidebar-fixed ec-sidebar-dark ec-header-light" id="body">

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
							<h1>Project</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Project</p>
						</div>
						<div  class="col-sm-10" style="text-align:end">
                    	    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" onclick="addProject()">Add Project</button>
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
					}
					elseif($_GET['type'] == 'failed'){
					?>
						<div class="alert alert-danger text-center" role="alert" id="alert_msg">
							<?php echo $_REQUEST['msg']; ?>
						</div>
					<?php
					}
					?>
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-modal="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                            <div class="modal-content">
                                <div class="row m-b30">
					            	<div class="col-12">
					            		<div class="card card-default">
					            			<div class="card-header card-header-border-bottom">
					            				<h2>Create Project</h2>
					            			</div>
					            			<div class="card-body">
					            				<div class="row ec-vendor-uploads">
					            					<div class="col-lg-12">
														<!-- <?php echo $msg; ?> -->
					            						<div class="ec-vendor-upload-detail">
					            							<form action="project.php" id="createForm" method="post" class="row g-3" enctype="multipart/form-data">
																<div id="error"></div>
					            					            <div class="col-md-6">
					            					                <div class="form-group mb-4">
					            					                	<label class="form-label">Client Name <span style="color:red;font-weight:bold">*</span></label>
					            					                	<select name="client" id="client1" class="form-control" required>
					            					                			<option value="" data-display="Team">Select Client Name</option>
                                                                                <?php
																				$sql = "SELECT * FROM client WHERE client_status=1";
																				$result = $conn->query($sql);
                                                                                while($row = mysqli_fetch_array($result)){
                                                                                    ?>
                                                                                    <option value="<?php echo $row['client_id']?>"><?php echo $row['client_name']?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
					            					                			<!-- <option value="Male" <?php if($row['gender']=='Male'){ echo "selected"; }?>>Male</option>
					            					                			<option value="Female" <?php if($row['gender']=='Female'){ echo "selected"; }?>>Female</option>
					            					            				<option value="Transgender" <?php if($row['gender']=='Transgender'){ echo "selected"; }?>>Transgender</option> -->
					            					                	</select>
					            					                </div>
					            					            </div>
                                                                <div class="col-md-6">
					            									<label class="form-label">Project Name <span style="color:red;font-weight:bold">*</span></label>
					            									<input type="text" class="form-control" name="project" id="project1"  placeholder="Client Name" required>
					            								</div>
                                                                <div class="col-md-6">
					            					                <div class="form-group mb-4">
					            					                	<label class="form-label">Department <span style="color:red;font-weight:bold">*</span></label>
					            					                	<select name="department1[]" id="department1" class="selectpicker" multiple data-live-search="true" required>
																			<?php
																			$depSql1 = "SELECT * FROM department";
																			$depRes1 = $conn->query($depSql1);
																			while($depRow1 = mysqli_fetch_array($depRes1)){
																				?>
																				<option value="<?php echo $depRow1['id'];?>"><?php echo $depRow1['dept_name'];?></option>
																				<?php
																			}
																			?>
					            					                			<!-- <option value="PHP">PHP</option>
					            					                			<option value="Android">Android</option>
					            					            				<option value="IOS">IOS</option>
					            					            				<option value="Node">Node</option>
					            					            				<option value="React">React</option>
                                                                                <option value="Laravel">Laravel</option>
                                                                                <option value="Server">Server</option> -->
					            					                	</select>
					            					                </div>
					            					            </div>
                                                                <div class="col-md-6">
					            									<label class="form-label">Start Date<span style="color:red;font-weight:bold">*</span></label>
					            									<input type="date" class="form-control" name="startdate" id="startdate"  placeholder="Select Date" required>
					            								</div>
                                                                <div class="col-md-6">
					            									<label class="form-label">End Date<span style="color:red;font-weight:bold">*</span></label>
					            									<input type="date" class="form-control" name="deadline" id="deadline"  placeholder="Select Date" required>
					            								</div>
                                                                <div class="col-md-6">
																<label class="form-label">Allocated Man Hours<span style="color:red;font-weight:bold">*</span></label>
																	<div class="row">
																	<div class="col-md-6">
					            										<label class="form-label">Billing Hours<span style="color:red;font-weight:bold">*</span></label>
					            										<input type="number" class="form-control" name="billhrs" id="billhrs"  placeholder="Billing Hours" required>
					            									</div>
																	<div class="col-md-6">
					            										<label class="form-label">Non Billing Hours<span style="color:red;font-weight:bold">*</span></label>
					            										<input type="number" class="form-control" name="nonbillhrs" id="nonbillhrs"  placeholder="Billing Hours" required>
					            									</div>
																	</div>
					            								</div>
                                                                <div class="col-md-6">
					            					                <div class="form-group mb-4">
					            					                	<label class="form-label">Project Status<span style="color:red;font-weight:bold">*</span></label>
					            					                	<select name="status" id="status" class="form-control" required>
					            					                			<option value="" data-display="Team">Select Project Status</option>
					            					                			<option value="Yet To Start">Yet To Start</option>
					            					                			<option value="On Going">On Going</option>
					            					            				<option value="Completed">Completed</option>
                                                                                <option value="Closed">Closed</option>
					            					                	</select>
					            					                </div>
					            					            </div>
					            								<div class="modal-footer px-4">
					            									<button type="button" name="project_submit" id="project_submit" class="btn btn-success">Submit</button>
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
                    <div class="row m-b30">
						<div class="col-xl col-md-12 p-b-15">
							<div id="user-acquisition" class="card card-default">
                                <div class="card-header">
                                    <h2 style="text-align: center">Project List</h2>
						        </div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="responsive-data-table" class="table" style="width: 160%">
											<thead>
												<tr>
													<th>S.No</th>
                                                    <th>Project Name</th>
                                                    <th>Department</th>
                                                    <th style="text-align: center">Start Date</th>
                                                    <th style="text-align: center">End Date</th>
                                                    <th style="text-align: center">Billing Hours</th>
													<th style="text-align: center">Approved Billing Hrs</th>
													<th style="text-align: center">Remaining Billing Hrs</th>
													<th style="text-align: center">Non Billing Hours</th>
													<th style="text-align: center">Approved Non Billing Hrs</th>
													<th style="text-align: center">Remaining Non Billing Hrs</th>
													<th>Status</th>
													<th style="text-align: center">Action</th>
												</tr>
											</thead>
											<tbody>
                                                <?php
												$projectSql = "SELECT * FROM project";
												$projectResult = $conn->query($projectSql);
                                                $i=0;
                                                while($projectRow = mysqli_fetch_array($projectResult)){
													$depart = $projectRow['dept_id'];
													$depShow = (explode(",",$depart));
                                                    $i++;
													$new_class = new sum();
													$rem_app_value = $new_class->add($projectRow['approved_b_hrs'], $projectRow['billing_hours']);
													// echo $rem_app_value;
													$rem_non_app_value = $new_class->add($projectRow['approved_non_b_hrs'], $projectRow['non_billing_hours']);
                                                    ?>
													<tr>
														<td><?php echo $i;?></td>
														<td><?php echo $projectRow['project_name'];?></td>
														<td>
														<?php
															$depart_sql = "SELECT * FROM department";
															$depart_result = $conn->query($depart_sql);
															$comma = "";
															while($depart_row = mysqli_fetch_array($depart_result)){
																if(in_array($depart_row['id'],$depShow)){
																	echo $comma .= $depart_row['dept_name'];
																	$comma = ", ";
																}
															}
														?>
														</td>
                                                        <td style="text-align: center"><?php echo date("d-m-Y", strtotime($projectRow['start_date']));?></td>
                                                        <td style="text-align: center"><?php echo date("d-m-Y", strtotime($projectRow['dead_line_date']));?></td>
                                                        <td style="text-align: center"><?php echo $projectRow['billing_hours'];?></td>
														<?php
														if($projectRow['approved_b_hrs'] != NULL){
															$app_b_hrs = $projectRow['approved_b_hrs'];
														}
														else{
															$app_b_hrs = "-";
														}
														?>
														<td style="text-align: center"><?php echo $app_b_hrs;?></td>
														<td style="text-align: center"><?php echo $rem_app_value;?></td>
														<td style="text-align: center"><?php echo $projectRow['non_billing_hours'];?></td>
														<?php
														if($projectRow['approved_non_b_hrs'] != NULL){
															$app_non_b_hrs = $projectRow['approved_non_b_hrs'];
														}
														else{
															$app_non_b_hrs = "-";
														}
														?>
														<td style="text-align: center"><?php echo $app_non_b_hrs;?></td>
														<td style="text-align: center"><?php echo $rem_non_app_value;?></td>
														<td><?php echo $projectRow['project_status'];?></td>
														<td class="center">
														<button type="button" data-toggle="modal" data-target="#edit<?php echo $projectRow['id'];?>" onclick="projectEdit(<?php echo $projectRow['id'];?>)"><span class="mdi mdi-pencil"></span></button>
														<div class="modal fade show" id="edit<?php echo $projectRow['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-modal="true">
                                        					<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                        					    <div class="modal-content">
                                        					        <div class="row m-b30">
					                    					        	<div class="col-12">
					                    					        		<div class="card card-default">
					                    					        			<div class="card-header card-header-border-bottom">
					                    					        				<h2>Edit Project</h2>
																					<?php
																					$sql = "SELECT * FROM client WHERE client_status=1";
																					$result = $conn->query($sql);
																					?>
					                    					        			</div>
					                    					        			<div class="card-body">
					                    					        				<div class="row ec-vendor-uploads">
					                    					        					<div class="col-lg-12">
					                    					        						<div class="ec-vendor-upload-detail">
					                    					        							<form method="post" id="edit_form<?php echo $projectRow['id'];?>" class="row g-3" enctype="multipart/form-data">
																								<div id="error1<?php echo $projectRow['id'];?>"></div>
					                    					        					            <div class="col-md-6">
					                    					        					                <div class="form-group mb-4">
					                    					        					                	<label class="form-label">Client Name <span style="color:red;font-weight:bold">*</span></label>
					                    					        					                	<select name="client" id="client1<?php echo $projectRow['id'];?>" class="form-control" required>
					                    					        					                		<option value="" data-display="Team">Select Client Name</option>
                                        					                                                    <?php
                                        					                                                    while($row = mysqli_fetch_array($result)){
                                        					                                                        ?>
                                        					                                                        <option value="<?php echo $row['client_id']?>"<?php if($projectRow['client_id']== $row['client_id']){ echo "selected"; }?>><?php echo $row['client_name']?></option>
                                        					                                                        <?php
                                        					                                                    }
                                        					                                                    ?>
					                    					        					                	</select>
					                    					        					                </div>
					                    					        					            </div>
                                        					                                        <div class="col-md-6">
					                    					        									<label class="form-label">Project Name <span style="color:red;font-weight:bold">*</span></label>
					                    					        									<input type="text" class="form-control" name="project" id="project1<?php echo $projectRow['id'];?>"  value="<?php echo $projectRow['project_name'];?>" required>
					                    					        								</div>
                                        					                                        <div class="col-md-6">
					                    					        					                <div class="form-group mb-4">
					                    					        					                	<label class="form-label">Department <span style="color:red;font-weight:bold">*</span></label>
																											<?php
																											$dep1 = $projectRow['dept_id'];
																											$depName1 = (explode(",",$dep1));
																											// var_dump($depName1);
																											$depSql = "SELECT * FROM department";
																											$depRes = $conn->query($depSql);
																											?>
					                    					        					                	<select name="department1[]" id="department1<?php echo $projectRow['id'];?>" class="selectpicker" multiple data-live-search="true" required>
																												<?php
																												while($depRow = mysqli_fetch_array($depRes)){
																													?>
																													<option value="<?php echo $depRow['id'];?>" <?php if(in_array($depRow['id'],$depName1)){ echo "selected"; }?>><?php echo $depRow['dept_name']; ?></option>
																													<?php
																												}
																												?>
					                    					        					                	</select>
					                    					        					                </div>
					                    					        					            </div>
                                        					                                        <div class="col-md-6">
					                    					        									<label class="form-label">Start Date<span style="color:red;font-weight:bold">*</span></label>
					                    					        									<input type="date" class="form-control" name="startdate" id="startdate<?php echo $projectRow['id'];?>"  value="<?php echo $projectRow['start_date'];?>" required>
					                    					        								</div>
                                        					                                        <div class="col-md-6">
					                    					        									<label class="form-label">End Date<span style="color:red;font-weight:bold">*</span></label>
					                    					        									<input type="date" class="form-control" name="deadline" id="deadline<?php echo $projectRow['id'];?>"  value="<?php echo $projectRow['dead_line_date'];?>" required>
					                    					        								</div>
                                        					                                        <div class="col-md-6">
																										<label class="form-label">Allocated Man Hours<span style="color:red;font-weight:bold">*</span></label>
																											<div class="row">
																											<div class="col-md-6">
					                            																<label class="form-label">Billing Hours<span style="color:red;font-weight:bold">*</span></label>
					                            																<input type="text" class="form-control" name="billhrs" id="billhrs<?php echo $projectRow['id'];?>"  value="<?php echo $projectRow['billing_hours'];?>" required>
					                            															</div>
																											<div class="col-md-6">
					                            																<label class="form-label">Non Billing Hours<span style="color:red;font-weight:bold">*</span></label>
					                            																<input type="text" class="form-control" name="nonbillhrs" id="nonbillhrs<?php echo $projectRow['id'];?>"  value="<?php echo $projectRow['non_billing_hours'];?>" required>
					                            															</div>
																											</div>
					                            													</div>
                                        					                                        <div class="col-md-6">
					                    					        					                <div class="form-group mb-4">
					                    					        					                	<label class="form-label">Project Status<span style="color:red;font-weight:bold">*</span></label>
					                    					        					                	<select name="status" id="status<?php echo $projectRow['id'];?>" class="form-control" required>
					                    					        					                			<option value="" data-display="Team">Select Project Status</option>
					                    					        					                			<option value="Yet To Start" <?php if($projectRow['project_status']=='Yet To Start'){ echo "selected"; }?>>Yet To Start</option>
					                    					        					                			<option value="On Going" <?php if($projectRow['project_status']=='On Going'){ echo "selected"; }?>>On Going</option>
					                    					        					            				<option value="Completed" <?php if($projectRow['project_status']=='Completed'){ echo "selected"; }?>>Completed</option>
                                        					                                                        <option value="Closed" <?php if($projectRow['project_status']=='Closed'){ echo "selected"; }?>>Closed</option>
					                    					        					                	</select>
					                    					        					                </div>
					                    					        					            </div>
																									<input type="hidden" name="editId" id="editId" value="<?php echo $projectRow['id'];?>">
					                    					        								<div class="modal-footer px-4">
					                    					        									<button type="button" name="project_edit" id="project_edit<?php echo $projectRow['id'];?>" value="<?php echo $projectRow['id'];?>" class="btn btn-primary" onclick = "editProject(<?php echo $projectRow['id'];?>)">Submit</button>
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
	function addProject(){
		$('#createForm')[0].reset();
	}

	function projectEdit(val1){
		$('#edit_form'+val1)[0].reset();
	}

	$('#project_submit').click(function(){
		var dept = $("#department1")
              .map(function(){
				return $(this).val();
			}).get();
		var client = document.getElementById('client1')
		var project = document.getElementById('project1')
		var stDate = document.getElementById('startdate')
		var endDate = document.getElementById('deadline')
		var bhrs = document.getElementById('billhrs')
		var nonbhrs = document.getElementById('nonbillhrs')
		var status = document.getElementById('status')

		if(client.value == ""){
			$('#client1').addClass('check-border');
		} else{
			$('#client1').removeClass('check-border');
		}
		if(project.value == ""){
			$('#project1').addClass('check-border');
		} else{
			$('#project1').removeClass('check-border');
		}
		if(dept == ""){
			$('.dropdown-toggle').addClass('check-border');
		} else{
			$('.dropdown-toggle').removeClass('check-border');
		}
		if(stDate.value == ""){
			$('#startdate').addClass('check-border');
		} else{
			$('#startdate').removeClass('check-border');
		}
		if(endDate.value == ""){
			$('#deadline').addClass('check-border');
		} else{
			$('#deadline').removeClass('check-border');
		}
		if(bhrs.value == ""){
			$('#billhrs').addClass('check-border');
		} else{
			$('#billhrs').removeClass('check-border');
		}
		if(nonbhrs.value == ""){
			$('#nonbillhrs').addClass('check-border');
		} else{
			$('#nonbillhrs').removeClass('check-border');
		}
		if(status.value == ""){
			$('#status').addClass('check-border');
		} else{
			$('#status').removeClass('check-border');
		}

		if(client.value != "" && project.value != "" && dept != "" && stDate.value != "" && endDate.value != "" && bhrs.value != "" && nonbhrs.value != "" && status.value != ""){
			$.ajax({
				type : 'POST',
				url : 'ajax/projectCheck.php',
				data : {
					client : client.value,
					project : project.value,
					dept : dept,
					stDate : stDate.value,
					endDate : endDate.value,
					bhrs : bhrs.value,
					nonbhrs : nonbhrs.value,
					status : status.value,
				},
				success : function(data){
					// alert(data);
					if(data == 'Already Exists'){
						$('#error').html('<div class="alert alert-danger text-center" role="alert" id="alert_msg_show"><?php echo "Project name is already exists"; ?></div>');
						$('#alert_msg_show').fadeTo(2000, 500).slideUp(500, function() {
    					    $('#alert_msg_show').slideUp(500);
    					});
					}
					else if(data == "Added"){
						location.replace("project.php?msg=Project Added !&type=success");
					}
				}
			});
		}
	});

	function editProject(val){
		var dept = $("#department1"+val)
              .map(function(){
				return $(this).val();
			}).get();
		var client = document.getElementById('client1'+val)
		var project = document.getElementById('project1'+val)
		var stDate = document.getElementById('startdate'+val)
		var endDate = document.getElementById('deadline'+val)
		var bhrs = document.getElementById('billhrs'+val)
		var nonbhrs = document.getElementById('nonbillhrs'+val)
		var status = document.getElementById('status'+val)

		if(client.value == ""){
			$('#client1'+val).addClass('check-border');
		} else{
			$('#client1'+val).removeClass('check-border');
		}
		if(project.value == ""){
			$('#project1'+val).addClass('check-border');
		} else{
			$('#project1'+val).removeClass('check-border');
		}
		if(dept == ""){
			$('.dropdown-toggle').addClass('check-border');
		} else{
			$('.dropdown-toggle').removeClass('check-border');
		}
		if(stDate.value == ""){
			$('#startdate'+val).addClass('check-border');
		} else{
			$('#startdate'+val).removeClass('check-border');
		}
		if(endDate.value == ""){
			$('#deadline'+val).addClass('check-border');
		} else{
			$('#deadline'+val).removeClass('check-border');
		}
		if(bhrs.value == ""){
			$('#billhrs'+val).addClass('check-border');
		} else{
			$('#billhrs'+val).removeClass('check-border');
		}
		if(nonbhrs.value == ""){
			$('#nonbillhrs'+val).addClass('check-border');
		} else{
			$('#nonbillhrs'+val).removeClass('check-border');
		}
		if(status.value == ""){
			$('#status'+val).addClass('check-border');
		} else{
			$('#status'+val).removeClass('check-border');
		}

		if(client.value != "" && project.value != "" && dept != "" && stDate.value != "" && endDate.value != "" && bhrs.value != "" && nonbhrs.value != "" && status.value != ""){
			$.ajax({
				type : 'POST',
				url : 'ajax/projectCheck2.php',
				data : {
					editId : val,
					client : client.value,
					project : project.value,
					dept : dept,
					stDate : stDate.value,
					endDate : endDate.value,
					bhrs : bhrs.value,
					nonbhrs : nonbhrs.value,
					status : status.value,
				},
				success : function(data){
					// alert(data);
					if(data == "Exists"){
						$('#error1'+val).html('<div class="alert alert-danger text-center" role="alert" id="alert_msg_show"><?php echo "Project name is already exists"; ?></div>');
						$('#alert_msg_show').fadeTo(2000, 500).slideUp(500, function() {
    					    $('#alert_msg_show').slideUp(500);
    					});
						$('#edit_form'+val)[0].reset();
					}
					else if(data == "Updated"){
						location.replace("project.php?msg=Project Updated !&type=warning");
					}
				}
			});
		}
	}
</script>
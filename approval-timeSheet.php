<?php
session_start();
ini_set("display_errors",'off');
include("include/connection.php");
$timeSheet = 'active';
$timeBoolean = 'true';
$time_show = 'show';
$time_approval ='Active';

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Ekka - Admin Dashboard HTML Template.">

	<title>DUBU DUBU - Approval Sheet</title>

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
							<h1>Approval Sheet</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Approval Sheet</p>
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
					?>
                    <div class="row m-b30">
						<div class="col-12">
							<div class="card card-default">
								<div class="card-header card-header-border-bottom">
                                        <h2 style="text-align: center">Approval Sheet List</h2>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="responsive-data-table" class="table" style="width:101%">
											<thead style="border-width:5px">
												<tr>
													<th>S.No</th>
                                                    <th>Employee Name</th>
                                                    <th style="text-align: center">Date</th>
                                                    <th>Project Name</th>
													<th>Task Name</th>
													<th>Task Type</th>
                                                    <th>Working Hours</th>
                                                    <th>Approval Hours</th>
													<th style="text-align: center">Action</th>
												</tr>
											</thead>
											<tbody>
                                                <?php
												$projectSql = "SELECT *,a.id AS timeid, c.id AS projectId, d.id AS taskId FROM time_sheet a
												LEFT OUTER JOIN employee b ON a.employee = b.id
												LEFT OUTER JOIN project c ON a.project_id = c.id
												LEFT OUTER JOIN task d ON d.id = a.task_id WHERE time_sheet_status = 1";
												$projectResult = $conn->query($projectSql);
                                                $i=0;
                                                while($projectRow = mysqli_fetch_array($projectResult)){
                                                    $i++;
                                                    ?>
													<tr>
														<td><?php echo $i;?></td>
                                                        <td><?php echo $projectRow['fname'];?> <?php echo $projectRow['lname'];?></td>
														<td style="text-align: center"><?php echo date("d-m-Y", strtotime($projectRow['date']));?></td>
                                                        <td><?php echo $projectRow['project_name'];?></td>
                                                        <td><?php echo $projectRow['task_name'];?></td>
														<?php
														if($projectRow['task_type'] == 1){
															$type_name = "Billing";
														}
														else{
															$type_name = "Non Billing";
														}
														?>
                                                        <td><?php echo $type_name;?></td>
                                                        <td><?php echo $projectRow['working_hrs'];?></td>
                                                        <td>
															<?php
															$emp_id =$_SESSION['id'];
															?>
															<input type="hidden" id="approvedid<?php echo $projectRow['timeid'];?>" value="<?php echo $emp_id;?>">
                                                            <input type="text" name="approvalHrs" id="approvalHrs<?php echo $projectRow['timeid'];?>" class="form-control input-box-align timePicker" value="<?php echo $projectRow['working_hrs'];?>" required>
															<input type="hidden" name="pro_id" id="pro_id<?php echo $projectRow['timeid'];?>" class="form-control" value="<?php echo $projectRow['project_id'];?>">
															<input type="hidden" name="t_id" id="t_id<?php echo $projectRow['timeid'];?>" class="form-control" value="<?php echo $projectRow['task_id'];?>">
															<input type="hidden" name="taskType" id="taskType<?php echo $projectRow['timeid'];?>" class="form-control" value="<?php echo $projectRow['task_type'];?>">
                                                        </td>
														<td>
															<button type="button" data-toggle="modal" data-target="#edit<?php echo $projectRow['timeid'];?>"><span class="mdi mdi-format-float-left"></span></button>&nbsp;
															<button type="button" data-toggle="modal" data-target="#del<?php echo $projectRow['timeid'];?>"><span class="mdi mdi-checkbox-marked-circle"></span></button>
															<div class="modal fade show" id="edit<?php echo $projectRow['timeid'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true">
                                        						<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        						    <div class="modal-content">
                                        						        <div class="row m-b30">
					                    						        	<div class="col-12">
					                    						        		<div class="card card-default">
					                    						        			<div class="card-header card-header-border-bottom">
					                    						        				<h2>View Time Sheet</h2>
					                    						        			</div>
					                    						        			<div class="card-body">
					                    						        				<div class="row ec-vendor-uploads">
					                    						        					<div class="col-lg-12">
					                    						        						<div class="ec-vendor-upload-detail">
					                    						        							<form method="post" class="row g-3" enctype="multipart/form-data">
																										<div class="col-md-6">
					                    						        									<label class="form-label">Date</label>
					                    						        									<input type="date" class="form-control" value="<?php echo $projectRow['date'];?>" readonly>
					                    						        								</div>
                                        						                                        <div class="col-md-6">
					                    						        									<label class="form-label">Project Name</label>
					                    						        									<input type="text" class="form-control" value="<?php echo $projectRow['project_name'];?>" readonly>
					                    						        								</div>
                                        						                                        <div class="col-md-6">
					                    						        					                <label class="form-label">Task</label>
																											<input type="text" class="form-control" value="<?php echo $projectRow['task_name'];?>" readonly>
																										</div>
                                        						                                        <div class="col-md-6">
					                    						        									<label class="form-label">Working Hours</label>
					                    						        									<input type="text" class="form-control" value="<?php echo $projectRow['working_hrs'];?>" readonly>
					                    						        								</div>
                                        						                                        <div class="col-md-12">
					                    						        									<label class="form-label">Description</label>
					                    						        									<textarea  cols="10" rows="5" readonly><?php echo $projectRow['description'];?></textarea>
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
															<div class="modal fade show" id="del<?php echo $projectRow['timeid'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-modal="true">
                                        						<div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                        						    <div class="modal-content">
                                        						        <div class="row m-b30">
					                    						        	<div class="col-12">
					                    						        		<div class="card card-default">
					                    						        			<div class="card-header card-header-border-bottom">
					                    						        				<h2>Accept Time Sheet</h2>
					                    						        			</div>
					                    						        			<div class="card-body">
					                    						        				<div class="row ec-vendor-uploads">
					                    						        					<div class="col-lg-12">
					                    						        						<div class="ec-vendor-upload-detail">
					                    						        							<form method="post" class="row g-3" enctype="multipart/form-data">
					                    						        					            <div class="col-md-12">
					                    						        					                <div class="form-group mb-4">
																												<p>Are you sure to accept <strong><?php echo $projectRow['fname'];?> <?php echo $projectRow['lname'];?></strong> Time Sheet !</p>
					                    						        					                </div>
					                    						        					            </div>
					                    						        								<div class="modal-footer px-4">
																											<button class="btn btn-light" data-dismiss="modal"> Cancel</button>
					                    						        									<button type="button" name="del_submit" id="del_submit" onclick="return time(<?php echo $projectRow['timeid'];?>)" class="btn btn-success">Approved</button>
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

<link rel="stylesheet" href="assets/css/timePicker.css">
<script src="assets/js/jquery-timepicker.js"></script>

<script>
	$(".timePicker").hunterTimePicker();
</script>

<script>
	function time(i){
		var approvedHrs = document.getElementById("approvalHrs"+i).value;
		var approed_by = document.getElementById("approvedid"+i).value;
		var pro_id = document.getElementById('pro_id'+i).value;
		var t_id = document.getElementById('t_id'+i).value;
		var task_type = document.getElementById('taskType'+i).value;
		// alert(task_type);
		$.ajax({
                type: "POST",
                url: "ajax/timeSheet.php",
                data:{
                    id:i,
                    hours: approvedHrs,
					approvBy :approed_by,
					pro_id : pro_id,
					t_id : t_id,
					task_type : task_type,
                },
                success: function(data){
					// alert(data);
                    if(data == 'Bill hrs updated'){
						// alert("bill");
						location.replace('approval-timeSheet.php?msg=Time Sheet Approved &type=success');
					}
					else if(data == 'Non Bill hrs updated'){
						// alert("non bill");
						location.replace('approval-timeSheet.php?msg=Time Sheet Approved &type=success');
					}
                }
            });
	}
</script>
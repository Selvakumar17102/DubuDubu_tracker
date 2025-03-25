<?php
session_start();
ini_set("display_errors",'off');
include("include/connection.php");

$employee = 'active';
$emp_boolean = 'true';
$emp_show = 'show';
$termi_apply = 'active';

if(isset($_POST['termination_submit'])){
	$id = $_POST['editId'];
    $employee_id = $_POST['employee_id'];
    $terminated_type = $_POST['terminated_type'];
    $notice_date = $_POST['notice_date'];
    $resignation_date = $_POST['resignation_date'];
    $reason = $_POST['reason'];
        
	if($id > 0){
	    $updateSql = "UPDATE termination SET employee_id='$employee_id', terminated_type='$terminated_type', notice_date='$notice_date', resignation_date='$resignation_date', reason='$reason' WHERE termination_id='$id'";
	    if($conn->query($updateSql) == TRUE){
	        header('location: termination-list.php?msg=termination Updated Successfully !&type=warning');
	    }
	}else{
		$insertSql = "INSERT INTO termination (employee_id,terminated_type,notice_date,resignation_date,reason) VALUES ('$employee_id', '$terminated_type','$notice_date','$resignation_date','$reason')";
		if($conn->query($insertSql) == TRUE){
			$updateSql1 = "UPDATE employee SET emp_status = 'Terminated' WHERE id = '$employee_id'";
    		$conn->query($updateSql1);
		    header('location: termination-list.php?msg=termination Added !&type=success');
		}
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

	<title>DUBU DUBU - Termination Table</title>

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
							<h1>Termination</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Termination</p>
						</div>
						<div  class="col-sm-10" style="text-align:end">
                    	    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" onclick="addTermination()">Add Termination</button>
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
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="row">
					            	<div class="col-12">
					            		<div class="card card-default">
					            			<div class="card-header card-header-border-bottom">
					            				<h2>Add Termination</h2>
					            			</div>
					            			<div class="card-body">
					            				<div class="row ec-vendor-uploads">
					            					<div class="col-lg-12">
					            						<div class="ec-vendor-upload-detail">
					            							<form id="createForm" method="post" class="row g-3" enctype="multipart/form-data">
																<div id="error"></div>
					            					            <div class="col-md-6">
					            					                <div class="form-group mb-4">
					            					                	<label class="form-label">Terminated Employee <span style="color:red;font-weight:bold">*</span></label>
					            					                	<select name="employee_id" id="employee_id" class="form-control" required>
					            					                			<option value="">Select Employee Name</option>
                                                                                <?php
																				$sql = "SELECT * FROM employee WHERE emp_status = 'Active'";
																				$result = $conn->query($sql);
                                                                                while($row = mysqli_fetch_array($result)){
                                                                                    ?>
                                                                                    <option value="<?php echo $row['id']?>"><?php echo $row['fname']?> <?php echo $row['lname']?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
					            					                	</select>
					            					                </div>
					            					            </div>
																<div class="col-md-6">
					            					                <div class="form-group mb-4">
					            					                	<label class="form-label">Termination Type <span style="color:red;font-weight:bold">*</span></label>
					            					                	<select name="terminated_type" id="terminated_type" class="form-control" required>
					            					                			<option value="">Select</option>
					            					                			<option value="Retirement">Retirement</option>
					            					                			<option value="Insubordination">Insubordination</option>
					            					                			<option value="Lack of Skills">Lack of Skills</option>
					            					                	</select>
					            					                </div>
					            					            </div>

                                                                <div class="col-md-6">
					            									<label class="form-label">Notice Date</label>
					            									<input type="date" class="form-control" name="notice_date" id="notice_date">
					            								</div>
																<div class="col-md-6">
					            									<label class="form-label">Resignation Date <span style="color:red;font-weight:bold">*</span></label>
					            									<input type="date" class="form-control" name="resignation_date" id="resignation_date" required>
					            								</div>
																<div class="col-md-12">
					            									<label class="form-label">Reason</label>
					            									<textarea name="reason" id="reason" class="form-control"></textarea>
					            								</div>
                                                             
					            								<div class="modal-footer px-4">
					            									<button type="submit" name="termination_submit" id="termination_submit" class="btn btn-success">Submit</button>
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
						<div class="col-xl col-md-12 p-b-15">
							<div id="user-acquisition" class="card card-default">
                                <div class="card-header">
                                    <h2 style="text-align: center">Termination List</h2>
						        </div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="responsive-data-table" class="table">
											<thead>
												<tr>
													<th>S.No</th>
                                                    <th>Employee name</th>
                                                    <th>Terminated Type</th>
                                                    <th>Notice Date</th>
                                                    <th>Resignation Date</th>
                                                    <th>Reason</th>
													<th style="text-align: center">Action</th>
												</tr>
											</thead>
											<tbody>
                                                <?php
												$terminateSql = "SELECT * FROM termination a LEFT JOIN employee b ON a.employee_id = b.id";
												$terminateResult = $conn->query($terminateSql);
                                                $i=0;
                                                while($terminateRow = mysqli_fetch_array($terminateResult)){
                                                    $i++;
                                                    ?>
													<tr>
														<td><?php echo $i;?></td>
														<td><?php echo $terminateRow['fname'];?>&nbsp;<?php echo $terminateRow['lname'];?></td>
														<td><?php echo $terminateRow['terminated_type'];?></td>
														<td><?php echo $terminateRow['notice_date'];?></td>
														<td><?php echo $terminateRow['resignation_date'];?></td>
														<td><?php echo $terminateRow['reason'];?></td>
														<td style="text-align: center">
														    <button type="button" data-toggle="modal" data-target="#edit<?php echo $terminateRow['termination_id'];?>" onclick="terminateEdit(<?php echo $terminateRow['termination_id'];?>)"><span class="mdi mdi-pencil"></span></button>
														    <div class="modal fade show" id="edit<?php echo $terminateRow['termination_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-modal="true">
                                        				    	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        				    	    <div class="modal-content">
                                        				    	        <div class="row ">
					                    				    	        	<div class="col-12">
					                    				    	        		<div class="card card-default">
					                    				    	        			<div class="card-header card-header-border-bottom">
					                    				    	        				<h2>Edit Termination</h2>
					                    				    	        			</div>
					                    				    	        			<div class="card-body">
					                    				    	        				<div class="row ec-vendor-uploads">
					                    				    	        					<div class="col-lg-12">
					                    				    	        						<div class="ec-vendor-upload-detail">
					                    				    	        							<form method="post" id="edit_form<?php echo $terminateRow['termination_id'];?>" class="row g-3" enctype="multipart/form-data">
														    										<div id="error1<?php echo $terminateRow['termination_id'];?>"></div>
					                    				    	        					            <div class="col-md-6">
					                    				    	        					                <div class="form-group mb-4">
					                    				    	        					                	<label class="form-label">Terminated Employee <span style="color:red;font-weight:bold">*</span></label>
					                    				    	        					                	<select name="employee_id" id="employee_id<?php echo $terminateRow['termination_id'];?>" class="form-control" required>
					                    				    	        					                		<option value="">Select</option>
                                        				    	                                                    <?php
																													$sql = "SELECT * FROM employee";
																													$result = $conn->query($sql);
                                        				    	                                                    while($row = mysqli_fetch_array($result)){
                                        				    	                                                        ?>
                                        				    	                                                        <option value="<?php echo $row['id']?>"<?php if($row['id'] == $terminateRow['employee_id']){ echo "selected"; }?>><?php echo $row['fname']?> <?php echo $row['lname']?></option>
                                        				    	                                                        <?php
                                        				    	                                                    }
                                        				    	                                                    ?>
					                    				    	        					                	</select>
					                    				    	        					                </div>
					                    				    	        					            </div>
                                        				    	                                        <div class="col-md-6">
																											<div class="form-group mb-4">
																												<label class="form-label">Termination Type <span style="color:red;font-weight:bold">*</span></label>
																												<select name="terminated_type" id="terminated_type" class="form-control" required>
																														<option value="">Select</option>
																														<option value="Retirement" <?php if($terminateRow['terminated_type'] == "Retirement"){ echo "selected"; }?>>Retirement</option>
																														<option value="Insubordination" <?php if($terminateRow['terminated_type'] == "Insubordination"){ echo "selected"; }?>>Insubordination</option>
																														<option value="Lack of Skills" <?php if($terminateRow['terminated_type'] == "Lack of Skills"){ echo "selected"; }?>>Lack of Skills</option>
																												</select>
																											</div>
																										</div>
																										<div class="col-md-6">
																											<label class="form-label">Notice Date</label>
																											<input type="date" class="form-control" name="notice_date" id="notice_date" value="<?php echo $terminateRow['notice_date']?>">
																										</div>
																										<div class="col-md-6">
																											<label class="form-label">Resignation Date <span style="color:red;font-weight:bold">*</span></label>
																											<input type="date" class="form-control" name="resignation_date" id="resignation_date" value="<?php echo $terminateRow['resignation_date']?>" required>
																										</div>
																										<div class="col-md-12">
																											<label class="form-label">Reason</label>
																											<textarea name="reason" id="reason" class="form-control"><?php echo $terminateRow['reason']?></textarea>
																										</div>
														    											<input type="hidden" name="editId" id="editId" value="<?php echo $terminateRow['termination_id'];?>">
					                    				    	        								<div class="modal-footer px-4">
					                    				    	        									<button type="submit" name="termination_submit" id="termination_submit<?php echo $terminateRow['termination_id'];?>" class="btn btn-primary" onclick = "editterminate(<?php echo $terminateRow['termination_id'];?>)">Update</button>
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
                    <div class="form-group">
        				<div class="col-sm-12">
							<span id="alertmeg"></span>
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
	function addTermination(){
		$('#createForm')[0].reset();
	}


	$('#termination_submit').click(function(){
		
		var employee_id = document.getElementById('employee_id')
		var terminated_type = document.getElementById('terminated_type')
		var resignation_date = document.getElementById('resignation_date')
		
		if(employee_id.value == ""){
			$('#employee_id').addClass('check-border');
		} else{
			$('#employee_id').removeClass('check-border');
		}
		if(terminated_type.value == ""){
			$('#terminated_type').addClass('check-border');
		} else{
			$('#terminated_type').removeClass('check-border');
		}
		if(resignation_date.value == ""){
			$('#resignation_date').addClass('check-border');
		} else{
			$('#resignation_date').removeClass('check-border');
		}
	});


	function editterminate(val){
		
		var employee_id = document.getElementById('employee_id'+val)
		var terminated_type = document.getElementById('terminated_type'+val)
		var resignation_date = document.getElementById('resignation_date'+val)

		if(employee_id.value == ""){
			$('#employee_id'+val).addClass('check-border');
		} else{
			$('#employee_id'+val).removeClass('check-border');
		}
		if(terminated_type.value == ""){
			$('#terminated_type'+val).addClass('check-border');
		} else{
			$('#terminated_type'+val).removeClass('check-border');
		}
		if(resignation_date.value == ""){
			$('#resignation_date'+val).addClass('check-border');
		} else{
			$('#resignation_date'+val).removeClass('check-border');
		}
		
	}
</script>
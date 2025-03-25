<?php
session_start();
ini_set("display_errors",'off');
include("include/connection.php");
include("timeSheet-function.php");
$master = 'active';
$mas_boolean = 'true';
$mas_show = 'show';
$desig_apply = 'active';

if(isset($_POST['designation_submit'])){
	$id = $_POST['editId'];
    $department = $_POST['department'];
    $designation = $_POST['designation'];
    
    

    $pro_sql = "SELECT * FROM designation WHERE designation_name = '$designation'";
	$pro_result = $conn->query($pro_sql);
	if($pro_result->num_rows > 0){
		header('location: designation.php?msg=designation name is already exists&type=failed');
	}else{
        
        if($id > 0){
            $updateSql = "UPDATE designation SET department='$department', designation_name='$designation' WHERE desig_id='$id'";
           
            if($conn->query($updateSql) == TRUE){
                header('location: designation.php?msg=designation Updated Successfully !&type=warning');
            }
    
        }else{
			$insertSql = "INSERT INTO designation (department, designation_name) VALUES ('$department', '$designation')";
    		if($conn->query($insertSql) == TRUE){
    		    header('location: designation.php?msg=designation Added !&type=success');
    		}
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

	<title>Dubu Dubu - Designation</title>

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
							<h1>Designation</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Designation</p>
						</div>
						<div  class="col-sm-10" style="text-align:end">
                    	    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" onclick="addDesignation()">Add Designation</button>
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
                        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                            <div class="modal-content">
                                <div class="row ">
					            	<div class="col-12">
					            		<div class="card card-default">
					            			<div class="card-header card-header-border-bottom">
					            				<h2>Create Designation</h2>
					            			</div>
					            			<div class="card-body">
					            				<div class="row ec-vendor-uploads">
					            					<div class="col-lg-12">
					            						<div class="ec-vendor-upload-detail">
					            							<form id="createForm" method="post" class="row g-3" enctype="multipart/form-data">
																<div id="error"></div>
					            					            <div class="col-md-12">
					            					                <div class="form-group mb-4">
					            					                	<label class="form-label">Department Name <span style="color:red;font-weight:bold">*</span></label>
					            					                	<select name="department" id="department" class="form-control" required>
					            					                			<option value="" data-display="Department">Select Department Name</option>
                                                                                <?php
																				$sql = "SELECT * FROM department";
																				$result = $conn->query($sql);
                                                                                while($row = mysqli_fetch_array($result)){
                                                                                    ?>
                                                                                    <option value="<?php echo $row['id']?>"><?php echo $row['dept_name']?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
					            					                	</select>
					            					                </div>
					            					            </div>

                                                                <div class="col-md-12">
					            									<label class="form-label">Designation Name <span style="color:red;font-weight:bold">*</span></label>
					            									<input type="text" class="form-control" name="designation" id="designation"  placeholder="Designation Name" required>
					            								</div>
                                                                
                                                             
					            								<div class="modal-footer px-4">
					            									<button type="submit" name="designation_submit" id="designation_submit" class="btn btn-success">Submit</button>
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
                    <div class="row ">
						<div class="col-xl col-md-12 p-b-15">
							<div id="user-acquisition" class="card card-default">
                                <div class="card-header">
                                    <h2 style="text-align: center">Designation List</h2>
						        </div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="responsive-data-table" class="table">
											<thead>
												<tr>
													<th>S.No</th>
                                                    <th>Department</th>
                                                    <th>Designation Name</th>
													<th style="text-align: center">Status</th>
													<th style="text-align: center">Action</th>
												</tr>
											</thead>
											<tbody>
                                                <?php
												$designationSql = "SELECT * FROM designation a LEFT JOIN department b ON a.department = b.id";
												$designationResult = $conn->query($designationSql);
                                                $i=0;
                                                while($designationRow = mysqli_fetch_array($designationResult)){

                                                    if($designationRow['status'] == 1){
														$status = "checked";
													}else{
														$status = "";
													}
                                                    
                                                    $i++;
                                                    ?>
													<tr>
														<td><?php echo $i;?></td>
														<td><?php echo $designationRow['dept_name'];?></td>
														<td><?php echo $designationRow['designation_name'];?></td>

                                                        <td style="text-align: center">
															<div class="form-switch">
  																<input class="form-check-input" type="checkbox" role="switch" id="flex<?php echo $designationRow['desig_id'];?>" <?php echo $status ?> onclick="return designationStatus(<?php echo $designationRow['desig_id']?>)">
															</div>
														</td>

														<td style="text-align: center">
														    <button type="button" data-toggle="modal" data-target="#edit<?php echo $designationRow['desig_id'];?>" onclick="designationEdit(<?php echo $designationRow['desig_id'];?>)"><span class="mdi mdi-pencil"></span></button>
														    <div class="modal fade show" id="edit<?php echo $designationRow['desig_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-modal="true">
                                        				    	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                        				    	    <div class="modal-content">
                                        				    	        <div class="row ">
					                    				    	        	<div class="col-12">
					                    				    	        		<div class="card card-default">
					                    				    	        			<div class="card-header card-header-border-bottom">
					                    				    	        				<h2>Edit designation</h2>
														    							<?php
														    							$sql = "SELECT * FROM department";
                                                                                        $result = $conn->query($sql);
														    							?>
					                    				    	        			</div>
					                    				    	        			<div class="card-body">
					                    				    	        				<div class="row ec-vendor-uploads">
					                    				    	        					<div class="col-lg-12">
					                    				    	        						<div class="ec-vendor-upload-detail">
					                    				    	        							<form method="post" id="edit_form<?php echo $designationRow['desig_id'];?>" class="row g-3" enctype="multipart/form-data">
														    										<div id="error1<?php echo $designationRow['desig_id'];?>"></div>
					                    				    	        					            <div class="col-md-12">
					                    				    	        					                <div class="form-group mb-4">
					                    				    	        					                	<label class="form-label">Client Name <span style="color:red;font-weight:bold">*</span></label>
					                    				    	        					                	<select name="department" id="department<?php echo $designationRow['desig_id'];?>" class="form-control" required>
					                    				    	        					                		<option value="" data-display="Team">Select department Name</option>
                                        				    	                                                    <?php
                                        				    	                                                    while($row = mysqli_fetch_array($result)){
                                        				    	                                                        ?>
                                        				    	                                                        <option value="<?php echo $row['id']?>"<?php if($designationRow['department']== $row['id']){ echo "selected"; }?>><?php echo $row['dept_name']?></option>
                                        				    	                                                        <?php
                                        				    	                                                    }
                                        				    	                                                    ?>
					                    				    	        					                	</select>
					                    				    	        					                </div>
					                    				    	        					            </div>
                                        				    	                                        <div class="col-md-12">
					                    				    	        									<label class="form-label">designation Name <span style="color:red;font-weight:bold">*</span></label>
					                    				    	        									<input type="text" class="form-control" name="designation" id="designation<?php echo $designationRow['desig_id'];?>"  value="<?php echo $designationRow['designation_name'];?>" required>
					                    				    	        								</div>
														    											<input type="hidden" name="editId" id="editId" value="<?php echo $designationRow['desig_id'];?>">
					                    				    	        								<div class="modal-footer px-4">
					                    				    	        									<button type="submit" name="designation_submit" id="designation_submit<?php echo $designationRow['desig_id'];?>" class="btn btn-primary" onclick = "editDesignation(<?php echo $designationRow['desig_id'];?>)">Submit</button>
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
	function addDesignation(){
		$('#createForm')[0].reset();
	}


	$('#designation_submit').click(function(){
		
		var department = document.getElementById('department')
		var designation = document.getElementById('designation')
		
		if(department.value == ""){
			$('#department').addClass('check-border');
		} else{
			$('#department').removeClass('check-border');
		}
		if(designation.value == ""){
			$('#designation').addClass('check-border');
		} else{
			$('#designation').removeClass('check-border');
		}
	});


	function editDesignation(val){
		
		var department = document.getElementById('department'+val)
		var designation = document.getElementById('designation'+val)

		if(department.value == ""){
			$('#department'+val).addClass('check-border');
		} else{
			$('#department'+val).removeClass('check-border');
		}
		if(designation.value == ""){
			$('#designation'+val).addClass('check-border');
		} else{
			$('#designation'+val).removeClass('check-border');
		}
		
	}
</script>
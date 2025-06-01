<?php
session_start();
ini_set("display_errors",'off');
include("include/connection.php");

$employee = 'active';
$emp_boolean = 'true';
$emp_show = 'show';
$promo_apply = 'active';

if(isset($_POST['promotion_submit'])){
	$id = $_POST['editId'];
    $promotion_for = $_POST['promotion_for'];
    $promotion_from = $_POST['promotion_from'];
    $promotion_to = $_POST['promotion_to'];
    $promotion_date = $_POST['promotion_date'];
        
	if($id > 0){
        
	    $updateSql = "UPDATE promotions SET promotion_for='$promotion_for', promotion_from='$promotion_from', promotion_to='$promotion_to', promotion_date='$promotion_date' WHERE id='$id'";
	    if($conn->query($updateSql) == TRUE){
			$updateSql1 = "UPDATE employee SET designation = '$promotion_to' WHERE id = '$promotion_for'";
    		$conn->query($updateSql1);
	        header('location: promotion-list.php?msg=promotions Updated Successfully !&type=warning');
	    }
	}else{
		$insertSql = "INSERT INTO promotions (promotion_for,promotion_from,promotion_to,promotion_date) VALUES ('$promotion_for','$promotion_from','$promotion_to','$promotion_date')";
		if($conn->query($insertSql) == TRUE){
			$updateSql1 = "UPDATE employee SET designation = '$promotion_to' WHERE id = '$promotion_for'";
    		$conn->query($updateSql1);
		    header('location: promotion-list.php?msg=promotions Added !&type=success');
		}
	}
}

if(isset($_POST['delete'])){
    $promo_id = $_POST['promo_id'];

    if($promo_id > 0){
        $getPromotionSql = "SELECT promotion_for, promotion_from FROM promotions WHERE id='$promo_id'";
        $result = $conn->query($getPromotionSql);

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $promotion_for = $row['promotion_for'];
            $promotion_from = $row['promotion_from'];

            $deleteSql = "DELETE FROM promotions WHERE id='$promo_id'";
            if($conn->query($deleteSql) === TRUE){

                $updateEmployeeSql = "UPDATE employee SET designation = '$promotion_from' WHERE id = '$promotion_for'";
                $conn->query($updateEmployeeSql);

                header('location: promotion-list.php?msg=Promotion Deleted and Employee Designation Reverted!&type=danger');
            } else {
                header('location: promotion-list.php?msg=Error Deleting Promotion!&type=error');
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

	<title>DUBU DUBU - Promotion Table</title>

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
							<h1>Promotion</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Promotion</p>
						</div>
						<div  class="col-sm-10" style="text-align:end">
                    	    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" onclick="addPromotion()">Add Promotion</button>
                    	</div>
					</div>
					<?php
					if($_GET['type'] == 'success'){
					?>
						<div class="alert alert-success text-center" role="alert" id="alert_msg">
							<?= $_REQUEST['msg']; ?>
						</div>
					<?php
					}
					elseif($_GET['type'] == 'warning'){
					?>
						<div class="alert alert-warning text-center" role="alert" id="alert_msg">
							<?= $_REQUEST['msg']; ?>
						</div>
					<?php
					}
					elseif($_GET['type'] == 'failed'){
					?>
						<div class="alert alert-danger text-center" role="alert" id="alert_msg">
							<?= $_REQUEST['msg']; ?>
						</div>
					<?php
					}
					?>
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-modal="true">
                        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                            <div class="modal-content">
                                <div class="row">
					            	<div class="col-12">
					            		<div class="card card-default">
					            			<div class="card-header card-header-border-bottom">
					            				<h2 class="modal-title">Add Promotion</h2>
					            			</div>
					            			<div class="card-body">
					            				<div class="row ec-vendor-uploads">
					            					<div class="col-lg-12">
					            						<div class="ec-vendor-upload-detail">
					            							<form id="createForm" method="post" class="row">
                                                                <div class="col-md-12">
                                                                    <label class="form-label">Promotion For</label>
                                                                    <select class="form-select" name="promotion_for" id="promotion_for" required>
                                                                        <option value="">Select</option>
                                                                        <?php
                                                                        $empSql = "SELECT id, fname, lname FROM employee WHERE emp_status = 'Active'";
                                                                        $result = $conn->query($empSql);
                                                                        while ($row = $result->fetch_assoc()) {
                                                                            ?>
                                                                            <option value="<?= $row['id']; ?>"><?= $row['fname'].' '.$row['lname']; ?></option>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label class="form-label">Promotion From</label>
                                                                    <select class="form-select" name="promotion_from" id="promotion_from" required>
                                                                        <option value="">Select</option>
                                                                        <?php
                                                                        $fromSql = "SELECT * FROM designation";
                                                                        $fromresult = $conn->query($fromSql);
                                                                        while ($fromrow = $fromresult->fetch_assoc()) {
                                                                            ?>
                                                                            <option value="<?= $fromrow['desig_id']; ?>"><?= $fromrow['designation_name']; ?></option>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label class="form-label">Promotion To</label>
                                                                    <select class="form-select" name="promotion_to" id="promotion_to" required>
                                                                        <option value="">Select</option>
                                                                        <?php
                                                                        $toSql = "SELECT * FROM designation";
                                                                        $toResult = $conn->query($toSql);
                                                                        while ($toRow = $toResult->fetch_assoc()) {
                                                                            ?>
                                                                            <option value="<?= $toRow['desig_id']; ?>"><?= $toRow['designation_name']; ?></option>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label class="form-label">Promotion Date</label>
                                                                    <input type="date" class="form-control" name="promotion_date" id="promotion_date" required>
                                                                </div>
					            								<div class="modal-footer px-4">
                                                                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
					            									<button type="submit" name="promotion_submit" id="promotion_submit" class="btn btn-success">Submit</button>
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
                                    <h2 style="text-align: center">Promotion List</h2>
						        </div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="responsive-data-table" class="table">
											<thead>
												<tr>
													<th>S.No</th>
                                                    <th>Promoted Employee</th>
                                                    <th>Department</th>
                                                    <th>Designation From</th>
                                                    <th>Designation From</th>
                                                    <th>Promotion Date</th>
													<th style="text-align: center">Action</th>
												</tr>
											</thead>
											<tbody>
                                                <?php
												$promotionSql = "SELECT 
                                                            p.id AS promotion_id, 
                                                            p.promotion_for, 
                                                            p.promotion_from, 
                                                            p.promotion_to, 
                                                            p.promotion_date, 
                                                            e.fname, 
                                                            e.lname, 
                                                            dpt.dept_name, 
                                                            d1.designation_name AS from_designation, 
                                                            d2.designation_name AS to_designation
                                                        FROM promotions p
                                                        LEFT JOIN employee e ON p.promotion_for = e.id
                                                        LEFT JOIN department dpt ON e.department = dpt.id
                                                        LEFT JOIN designation d1 ON p.promotion_from = d1.desig_id
                                                        LEFT JOIN designation d2 ON p.promotion_to = d2.desig_id";
												$promotionResult = $conn->query($promotionSql);
                                                $i=0;
                                                while($promotionRow = mysqli_fetch_array($promotionResult)){
                                                    $i++;
                                                    ?>
													<tr>
														<td><?= $i;?></td>
														<td><?= $promotionRow['fname'].' '.$promotionRow['lname'];?></td>
														<td><?= $promotionRow['dept_name'];?></td>
														<td><?= $promotionRow['from_designation'];?></td>
														<td><?= $promotionRow['to_designation'];?></td>
														<td><?= $promotionRow['promotion_date'];?></td>
														<td style="text-align: center">
                                                            
														    <button type="button" data-toggle="modal" data-target="#edit<?= $i;?>" onclick="promotionEdit(<?= $i;?>)"><span class="mdi mdi-pencil"></span></button>
														    <div class="modal fade show" id="edit<?= $i;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-modal="true">
                                        				    	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                        				    	    <div class="modal-content">
                                        				    	        <div class="row ">
					                    				    	        	<div class="col-12">
					                    				    	        		<div class="card card-default">
					                    				    	        			<div class="card-header card-header-border-bottom">
					                    				    	        				<h2>Edit Promotion</h2>
					                    				    	        			</div>
					                    				    	        			<div class="card-body">
					                    				    	        				<div class="row ec-vendor-uploads">
					                    				    	        					<div class="col-lg-12">
					                    				    	        						<div class="ec-vendor-upload-detail">
					                    				    	        							<form method="post" id="edit_form<?= $promotionRow['promotion_id'];?>" class="row">
														    											<div id="error1<?= $promotionRow['promotion_id'];?>"></div>
					                    				    	        					            <div class="col-md-12">
																											<label class="form-label">Promotion For</label>
																											<select class="form-select" name="promotion_for" id="promotion_for" required>
																												<option value="">Select</option>
																												<?php
																												$empSql = "SELECT id, fname, lname FROM employee WHERE emp_status = 'Active'";
																												$result = $conn->query($empSql);
																												while ($row = $result->fetch_assoc()) {
																													?>
																													<option value="<?= $row['id']; ?>" <?php if($row['id'] == $promotionRow['promotion_for']){ echo "selected";} ?>><?= $row['fname'].' '.$row['lname']; ?></option>
																													<?php
																												}
																												?>
																											</select>
					                    				    	        					            </div>
																										<div class="col-md-12">
																											<label class="form-label">Promotion From</label>
																											<select class="form-select" name="promotion_from" id="promotion_from" required>
																												<option value="">Select</option>
																												<?php
																												$fromSql = "SELECT * FROM designation";
																												$fromresult = $conn->query($fromSql);
																												while ($fromrow = $fromresult->fetch_assoc()) {
																													?>
																													<option value="<?= $fromrow['desig_id']; ?>" <?php if($fromrow['desig_id'] == $promotionRow['promotion_from']){ echo "selected";} ?>><?= $fromrow['designation_name']; ?></option>
																													<?php
																												}
																												?>
																											</select>
																										</div>
																										<div class="col-md-12">
																											<label class="form-label">Promotion To</label>
																											<select class="form-select" name="promotion_to" id="promotion_to" required>
																												<option value="">Select</option>
																												<?php
																												$toSql = "SELECT * FROM designation";
																												$toResult = $conn->query($toSql);
																												while ($toRow = $toResult->fetch_assoc()) {
																													?>
																													<option value="<?= $toRow['desig_id']; ?>" <?php if($toRow['desig_id'] == $promotionRow['promotion_to']){ echo "selected";} ?>><?= $toRow['designation_name']; ?></option>
																													<?php
																												}
																												?>
																											</select>
																										</div>
																										<div class="col-md-12">
																											<label class="form-label">Promotion Date</label>
																											<input type="date" class="form-control" name="promotion_date" id="promotion_date" value="<?= $promotionRow['promotion_date']; ?>" required>
																										</div>
														    											<input type="hidden" name="editId" id="editId" value="<?= $promotionRow['promotion_id'];?>">
					                    				    	        								<div class="modal-footer px-4">
					                    				    	        									<button type="submit" name="promotion_submit" id="promotion_submit<?= $promotionRow['promotion_id'];?>" class="btn btn-primary" onclick = "editpromotion(<?= $promotionRow['promotion_id'];?>)">Update</button>
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

                                                            <button type="button" data-bs-toggle="modal" data-bs-target="#delete<?= $i; ?>"><span class="mdi mdi-delete-empty"></span></button>
															<div class="modal fade" id="delete<?= $i;?>" tabindex="-1" role="dialog"	aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
																<div class="modal-dialog modal-dialog-centered modal" role="document">
																	<div class="modal-content">
                                                                        <form method="post">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="addAdminTitle">Delete Promotion</h5>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <p class="modal-text">Are you sure to delete promotion data !</p>
                                                                                <input type="hidden" name="promo_id" value="<?= $promotionRow['promotion_id'];?>">
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button class="btn btn-secondary" data-dismiss="modal"> No</button>
                                                                                <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                                                                            </div>
                                                                        </form>
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
	function addPromotion(){
		$('#createForm')[0].reset();
	}


	$('#promotion_submit').click(function(){
		
		var promotion_for = document.getElementById('promotion_for')
		var promotion_from = document.getElementById('promotion_from')
		var promotion_to = document.getElementById('promotion_to')
		var promotion_date = document.getElementById('promotion_date')
		
		if(promotion_for.value == ""){
			$('#promotion_for').addClass('check-border');
		} else{
			$('#promotion_for').removeClass('check-border');
		}
		if(promotion_from.value == ""){
			$('#promotion_from').addClass('check-border');
		} else{
			$('#promotion_from').removeClass('check-border');
		}
		if(promotion_to.value == ""){
			$('#promotion_to').addClass('check-border');
		} else{
			$('#promotion_to').removeClass('check-border');
		}
        if(promotion_date.value == ""){
			$('#promotion_date').addClass('check-border');
		} else{
			$('#promotion_date').removeClass('check-border');
		}
	});


	
</script>
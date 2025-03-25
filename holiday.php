<?php
session_start();
ini_set("display_errors",'off');
include("include/connection.php");
include("timeSheet-function.php");
$holiday = 'active';
$holiday_boolean = 'true';

if(isset($_POST['holiday_submit'])){
	$id = $_POST['editId'];
    $title = $_POST['title'];
    $date = $_POST['date'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    
    

    // $pro_sql = "SELECT * FROM holidays WHERE holiday_date = '$date'";
	// $pro_result = $conn->query($pro_sql);
	// if($pro_result->num_rows > 0){
	// 	header('location: holiday.php?msg=Holiday already exists for this date&type=failed');
	// }else{
        if($id){
            $updateSql = "UPDATE holidays SET title='$title', holiday_date='$date', description='$description', status='$status' WHERE id='$id'";
           
            if($conn->query($updateSql) == TRUE){
                header('location: holiday.php?msg=Holiday Updated Successfully !&type=warning');
            }
    
        }else{
			$insertSql = "INSERT INTO holidays (title, holiday_date, description, status) VALUES ('$title', '$date', '$description', '$status')";
    		if($conn->query($insertSql) == TRUE){
    		    header('location: holiday.php?msg=Holiday Added !&type=success');
    		}
		}
    // }

	
}

if(isset($_POST['delete'])){
	$holi_id = $_POST['holi_id'];

	$dept_sql = "DELETE FROM holidays WHERE id='$holi_id'";
	if($conn->query($dept_sql)){
		header('location: holiday.php?msg=Holiday name Successfully deleted!&type=failed');
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

	<title>Dubu Dubu - Holidays</title>

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
							<h1>Holidays</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Holidays</p>
						</div>
						<div  class="col-sm-10" style="text-align:end">
                    	    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" onclick="addHoliday()">Add Holiday</button>
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
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="row ">
					            	<div class="col-12">
					            		<div class="card card-default">
					            			<div class="card-header card-header-border-bottom">
					            				<h2>Add Holiday</h2>
					            			</div>
					            			<div class="card-body">
					            				<div class="row ec-vendor-uploads">
					            					<div class="col-lg-12">
					            						<div class="ec-vendor-upload-detail">
					            							<form id="createForm" method="post" class="row">
                                                                <div class="col-md-6">
                                                                    <label for="title">Title</label>
                                                                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter holiday title" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="date">Date</label>
                                                                    <input type="date" class="form-control" id="date" name="date" required>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label for="description">Description</label>
                                                                    <textarea class="form-control" id="description" name="description" placeholder="Enter description"></textarea>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label for="status">Status</label>
                                                                    <select class="form-control" id="status" name="status">
                                                                        <option selected disabled>Select</option>
                                                                        <option value="active">Active</option>
                                                                        <option value="inactive">Inactive</option>
                                                                    </select>
                                                                </div>
					            								<div class="modal-footer px-4">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					            									<button type="submit" name="holiday_submit" id="holiday_submit" class="btn btn-success">Submit</button>
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
                                    <h2 style="text-align: center">Holiday List</h2>
						        </div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="responsive-data-table" class="table">
											<thead>
												<tr>
													<th>S.No</th>
                                                    <th>Title</th>
                                                    <th>Date</th>
                                                    <th>Description</th>
                                                    <?php
                                                        if($control != 1 && $control != 2){
                                                        ?>
													<th style="text-align: center">Status</th>
													<th style="text-align: center">Action</th>
                                                    <?php
                                                        }
                                                        ?>
												</tr>
											</thead>
											<tbody>
                                                <?php
												$sql = "SELECT * FROM holidays ORDER BY holiday_date DESC";
												$result = $conn->query($sql);
                                                $i=0;
                                                while($row = mysqli_fetch_array($result)){

                                                    if($row['status'] == 'active'){
														$status = "checked";
													}else{
														$status = "";
													}
                                                    
                                                    $i++;
                                                    ?>
													<tr>
														<td><?= $i;?></td>
														<td><?= $row['title'];?></td>
														<td><?= $row['holiday_date'];?></td>
														<td><?= $row['description'];?></td>

                                                        <?php
                                                        if($control != 1 && $control != 2){
                                                        ?>
                                                        <td style="text-align: center">
															<div class="form-switch">
  																<input class="form-check-input" type="checkbox" role="switch" id="flex<?= $row['id'];?>" <?= $status ?> onclick="return holidayStatus(<?= $row['id']?>)">
															</div>
														</td>
														<td style="text-align: center">
														    <button type="button" data-toggle="modal" data-target="#edit<?= $row['id'];?>" onclick="holidayEdit(<?= $row['id'];?>)"><span class="mdi mdi-pencil"></span></button>
														    <div class="modal fade show" id="edit<?= $row['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-modal="true">
                                        				    	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        				    	    <div class="modal-content">
                                        				    	        <div class="row ">
					                    				    	        	<div class="col-12">
					                    				    	        		<div class="card card-default">
					                    				    	        			<div class="card-header card-header-border-bottom">
					                    				    	        				<h2>Edit Holiday</h2>
					                    				    	        			</div>
					                    				    	        			<div class="card-body">
					                    				    	        				<div class="row ec-vendor-uploads">
					                    				    	        					<div class="col-lg-12">
					                    				    	        						<div class="ec-vendor-upload-detail">
					                    				    	        							<form method="post" id="edit_form<?= $row['id'];?>" class="row">
                                                                                                        <div class="col-md-6">
                                                                                                            <label for="title">Title</label>
                                                                                                            <input type="text" class="form-control" id="title" name="title" value="<?= $row['title']; ?>" placeholder="Enter holiday title" required>
                                                                                                        </div>
                                                                                                        <div class="col-md-6">
                                                                                                            <label for="date">Date</label>
                                                                                                            <input type="date" class="form-control" id="date" name="date" value="<?= $row['holiday_date']; ?>" required>
                                                                                                        </div>
                                                                                                        <div class="col-md-12">
                                                                                                            <label for="description">Description</label>
                                                                                                            <textarea class="form-control" id="description" name="description" placeholder="Enter description"><?= $row['description']; ?></textarea>
                                                                                                        </div>
                                                                                                        <div class="col-md-12">
                                                                                                            <label for="status">Status</label>
                                                                                                            <select class="form-control" id="status" name="status">
                                                                                                                <option value="active" <?php if($row['status'] == 'active'){ echo "selected"; } ?>>Active</option>
                                                                                                                <option value="inactive" <?php if($row['status'] == 'inactive'){ echo "selected"; } ?>>Inactive</option>
                                                                                                            </select>
                                                                                                        </div>
														    											<input type="hidden" name="editId" id="editId" value="<?= $row['id'];?>">
					                    				    	        								<div class="modal-footer px-4">
					                    				    	        									<button type="submit" name="holiday_submit" id="holiday_submit<?= $row['id'];?>" class="btn btn-primary" onclick = "editHoliday(<?= $row['id'];?>)">Submit</button>
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
                                                            <button type="button" data-toggle="modal" data-target="#delete<?= $i; ?>"><span class="mdi mdi-delete-empty"></span></button>
															<div class="modal fade" id="delete<?= $i;?>" tabindex="-1" role="dialog"	aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
																<div class="modal-dialog modal-dialog-centered modal" role="document">
																	<div class="modal-content">
                                                                        <form method="post">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="addAdminTitle">Delete Category</h5>
                                                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <p class="modal-text">Are you sure to delete <b><?= $row['title']; ?></b> ! Holiday</p>
                                                                                <input type="hidden" name="holi_id" value="<?= $row['id']; ?>">
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
                                                        <?php
                                                        }
                                                        ?>
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
	function addHoliday(){
		$('#createForm')[0].reset();
	}


	$('#holiday_submit').click(function(){
		
		var title = document.getElementById('title')
		var date = document.getElementById('date')
		var description = document.getElementById('description')
		var status = document.getElementById('status')
		
		if(title.value == ""){
			$('#title').addClass('check-border');
		} else{
			$('#title').removeClass('check-border');
		}
		if(date.value == ""){
			$('#date').addClass('check-border');
		} else{
			$('#date').removeClass('check-border');
		}
        if(description.value == ""){
			$('#description').addClass('check-border');
		} else{
			$('#description').removeClass('check-border');
		}
        if(status.value == ""){
			$('#status').addClass('check-border');
		} else{
			$('#status').removeClass('check-border');
		}
	});


	function editHoliday(val){
		
		var title = document.getElementById('title'+val)
		var date = document.getElementById('date'+val)
		var description = document.getElementById('description'+val)
		var status = document.getElementById('status'+val)

		if(title.value == ""){
			$('#title'+val).addClass('check-border');
		} else{
			$('#title'+val).removeClass('check-border');
		}
        if(date.value == ""){
			$('#date'+val).addClass('check-border');
		} else{
			$('#date'+val).removeClass('check-border');
		}
        if(description.value == ""){
			$('#description'+val).addClass('check-border');
		} else{
			$('#description'+val).removeClass('check-border');
		}
		if(status.value == ""){
			$('#status'+val).addClass('check-border');
		} else{
			$('#status'+val).removeClass('check-border');
		}
		
	}
</script>
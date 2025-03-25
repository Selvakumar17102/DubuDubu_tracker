<?php

session_start();
ini_set('display_errors', 'off');
include("include/connection.php");
$master = 'active';
$mas_boolean = 'true';
$mas_show = 'show';
$com_apply = 'active';


$com_id = $_GET['companyid'];
$sql = "SELECT * FROM companies WHERE id = '$com_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if(isset($_POST['add'])){
	$name = $_POST['name'];
	$shortname = $_POST['shortname'];

	$dep_sql = "SELECT * FROM companies WHERE company_name='$name'";
	$dep_result = $conn->query($dep_sql);
	if($dep_result->num_rows > 0){
		header('location: company.php?msg=company Name already exists!&type=failed');
	}
	else{
		if($com_id){
			$upd_sql = "UPDATE companies SET company_name = '$name', short_name = '$shortname' WHERE id = '$com_id'";
			if($conn->query($upd_sql) == TRUE){
				header('location: company.php?msg=Company Updated!&type=warning');
			}
		}else{
			$dep_sql = "INSERT INTO companies (company_name, short_name) VALUES ('$name','$shortname')";
			if($conn->query($dep_sql) == TRUE){
				header('location: company.php?msg=Company Added!&type=success');
			}
		}
	}
}

if(isset($_POST['delete'])){
	$com_id = $_POST['com_id'];

	$dept_sql = "DELETE FROM companies WHERE id='$com_id'";
	if($conn->query($dept_sql)){
		header('location: company.php?msg=Company name Successfully deleted!&type=failed');
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

	<title>DUBU DUBU - Companies</title>

	<!-- GOOGLE FONTS -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

	<link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />

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
							<h1>Companies</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Companies</p>
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

					<div class="row m-b30">
						<div class="col-12">
							<div class="card card-default">
								<div class="card-header card-header-border-bottom">
									<h2>Companies</h2>
								</div>
								<div class="card-body">
									<div class="row ec-vendor-uploads">
										<div class="col-lg-12">
											<div class="ec-vendor-upload-detail">
												<form method="post" class="row g-3">
                                                    
                                                    <div class="col-md-4">
                                                        <label class="form-label">Company Name</label>
														<input type="text" class="form-control" name="name" id="name" value="<?= $row['company_name'];?>" placeholder="Enter Company Name" required>
													</div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Short Name</label>
                                                        <input type="text" class="form-control" name="shortname" id="shortname" value="<?= $row['short_name'];?>" placeholder=" Short Name" required oninput="this.value = this.value.toUpperCase()">
                                                    </div>

													<div class="col-md-6">
                                                        <label >Action</label>
														<button type="submit" name="add" id="add" class="btn btn-success">Add</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xl-12 col-md-12 p-b-15">
							<div id="user-acquisition" class="card card-default">
								<div class="card-header">
									<h2 style="text-align: center">Companies Details</h2>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col">
											<div class="table-responsive">
												<table id="responsive-data-table" class="table">
													<thead>
														<tr>
															<th>S.No</th>
															<th>Company Name</th>
															<th>Short Name</th>
															<th style="text-align: center">Action</th>
														</tr>
													</thead>
													<tbody>
														<?php
														$com_sql = "SELECT * FROM companies ORDER BY company_name ASC";
														$com_result = $conn->query($com_sql);
														$a = 1;
														$b = 0;
														while($com_row = mysqli_fetch_array($com_result)){
															$b++;
														?>
															<tr>
																<td><?= $a++; ?></td>
																<td><?= $com_row['company_name'];?></td>
																<td><?= $com_row['short_name'];?></td>
																<td style="text-align: center">
																<a href="company.php?companyid=<?= $com_row['id'];?>"><span class="mdi mdi-pencil"></span></a>
																	<button type="button" data-bs-toggle="modal" data-bs-target="#delete<?php echo $b; ?>"><span class="mdi mdi-delete-empty"></span></button>
																	<div class="modal fade" id="delete<?php echo $b;?>" tabindex="-1" role="dialog"	aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
																		<div class="modal-dialog modal-dialog-centered modal" role="document">
																			<div class="modal-content">
                                                                	            <form method="post">
                                                                	                <div class="modal-header">
                                                                	                    <h5 class="modal-title" id="addAdminTitle">Delete Company</h5>
                                                                	                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                	                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                                	                    </button>
                                                                	                </div>
                                                                	                <div class="modal-body">
                                                                	                    <p class="modal-text">Are you sure to delete <b><?php echo $com_row['company_name']; ?></b> !</p>
                                                                	                    <input type="hidden" name="com_id" value="<?php echo $com_row['id']; ?>">
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

	<!-- Data-Tables -->
	<script src='assets/plugins/data-tables/jquery.datatables.min.js'></script>
	<script src='assets/plugins/data-tables/datatables.bootstrap5.min.js'></script>
	<script src='assets/plugins/data-tables/datatables.responsive.min.js'></script>

	<!-- Option Switcher -->
	<script src="assets/plugins/options-sidebar/optionswitcher.js"></script>

	<!-- Ekka Custom -->
	<script src="assets/js/ekka.js"></script>
	<script src="assets/js/manual.js"></script>
</body>

</html>
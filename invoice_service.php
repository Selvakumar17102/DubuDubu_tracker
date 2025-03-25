<?php
session_start();
ini_set("display_errors",'off');
include("include/connection.php");
$invoice_service = 'active';
$invoiceServiceBoolean = 'true';

if(isset($_POST['service_submit'])){
	$id = $_POST['hidden_id'];
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$short_name = mysqli_real_escape_string($conn, $_POST['short_name']);

	if($id > 0){
		$clientUpdate = "UPDATE invoice_service SET name='$name',short_name='$short_name' WHERE id = $id";
		if($conn->query($clientUpdate) == TRUE){
			$msg='<div class="alert alert-warning" id="alert_msg">Service Updated Successfully !</div>';
		}
	}else{

		$clientSql = "INSERT INTO invoice_service (name,short_name) VALUES('$name','$short_name')";
		if($conn->query($clientSql) == TRUE){
			$msg='<div class="alert alert-success" id="alert_msg">Service Added Successfully !</div>';
		}
	}
}

$editId = 0;

if(isset($_GET['edit_id'])){
	$editId = $_GET['edit_id'];
	$edit_sql = "SELECT * FROM invoice_service WHERE id = $editId";
	$editresult = $conn->query($edit_sql);
	$editrow = mysqli_fetch_array($editresult);
}

// if(isset($_GET['del_id'])){
// 	$del = $_GET['del_id'];
// 	$delSql = "DELETE FROM client WHERE client_id = $del";
// 	if($conn->query($delSql) == TRUE){
// 		$msg='<div class="alert alert-danger">Client Delete Successfully !</div>';
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

	<title>Dubu Dubu - Service</title>

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
<style>
	th,td{
		text-align:center;
	}
	input:invalid {
  		background-color: #ffdddd;
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
							<h1>Service</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Service</p>
						</div>
					</div>
						<div class="form-group">
        					<div class="col-sm-12 ">
            					<?php echo $msg; ?>
        					</div>
    					</div>
                    <div class="row m-b30">
						<div class="col-12">
							<div class="card card-default">
								<div class="card-header card-header-border-bottom">
									<h2>Create Service</h2>
								</div>
								<div class="card-body">
									<div class="row ec-vendor-uploads">
										<div class="col-lg-12">
											<div class="ec-vendor-upload-detail">
												<form method="post" class="row g-3" enctype="multipart/form-data">
													<input type="hidden" name="hidden_id" value="<?php echo $editrow['id']?>">
													<div class="col-md-6">
														<label class="form-label">Service Name</label>
														<input type="text" class="form-control" name="name" id="name" value="<?php echo $editrow['name']?>" placeholder="Service Name" required autocomplete="off">
													</div>
													<div class="col-md-6">
														<label class="form-label">Service Short Name</label>
														<input type="text" class="form-control" name="short_name" id="short_name" value="<?php echo $editrow['short_name']?>" placeholder="Service Short Name" required autocomplete="off">
														<span id="errorMessage" style="color: red"></span>
													</div>
													<div class="col-md-6 pt-4">
														<button type="submit" name="service_submit" id="service_submit" class="btn btn-primary">Submit</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row m-b30">
						<div class="col-12">
							<div class="card card-default">
								<div class="card-header card-header-border-bottom">
									<h2 style="text-align: center">Service List</h2>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="responsive-data-table" class="table" style="width:100%">
											<thead style="border-width:5px">
												<tr>
													<th>S.No</th>
													<th>Service Name</th>
													<th>Service Short Name</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$i = 0;
												$sql = "SELECT * FROM invoice_service";
												$result = $conn->query($sql);
												while( $row = mysqli_fetch_array($result)){
													$i++;

													if($row['client_status']==1){
														$status = "checked";
													}else{
														$status = "";
													}
													?>
													<tr>
														<td><?php echo $i;?></td>
														<td><?php echo $row['name']?></td>
														<td><?php echo $row['short_name']?></td>
														<td>
															<a href="invoice_service.php?edit_id=<?php echo $row['id'];?>"><span class="mdi mdi-pencil-box-outline" style="font-size:30px"></span></a>
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
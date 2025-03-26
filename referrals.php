<?php
session_start();
ini_set("display_errors",'off');
include("include/connection.php");
$recruitment = 'active';
$recruitment_boolean = 'true';
$recruitment_show = 'show';
$referrals_page = 'active';

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Ekka - Admin Dashboard HTML Template.">

	<title>Dubu Dubu - Refferals</title>

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
							<h1>Refferals</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Refferals</p>
						</div>
					</div>
                    <div class="row ">
						<div class="col-xl col-md-12 p-b-15">
							<div id="user-acquisition" class="card card-default">
                                <div class="card-header">
                                    <h2 style="text-align: center">Refferals List</h2>
						        </div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="responsive-data-table" class="table">
											<thead>
                                                <tr>
                                                    <th><input type="checkbox"></th>
                                                    <th>Referrals ID</th>
                                                    <th>Referrer Name</th>
                                                    <th>Job Referred</th>
                                                    <th>Referee Name</th>
                                                    <th>Referrals Bonus</th>
                                                    <th>Actions</th>
                                                </tr>
											</thead>
											<tbody>
                                                <tr>
                                                    <td><input type="checkbox"></td>
                                                    <td>Reff-010</td>
                                                    <td>
                                                        <strong>Lori Broaddus</strong><br>
                                                        <small>Finance</small>
                                                    </td>
                                                    <td>🎨 Senior Graphic Designer</td>
                                                    <td>
                                                        <strong>Joyce Golston</strong><br>
                                                        <small>joyce@example.com</small>
                                                    </td>
                                                    <td>$250</td>
                                                    <td>
                                                        <a href="#" class="text-primary"><i class="mdi mdi-pencil"></i></a>
                                                        <a href="#" class="text-danger"><i class="mdi mdi-delete"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox"></td>
                                                    <td>Reff-009</td>
                                                    <td>
                                                        <strong>Connie Waters</strong><br>
                                                        <small>Developer</small>
                                                    </td>
                                                    <td>🖌️ Junior UI/UX Designer</td>
                                                    <td>
                                                        <strong>Jeffrey Thaler</strong><br>
                                                        <small>jeffrey@example.com</small>
                                                    </td>
                                                    <td>$180</td>
                                                    <td>
                                                        <a href="#" class="text-primary"><i class="mdi mdi-pencil"></i></a>
                                                        <a href="#" class="text-danger"><i class="mdi mdi-delete"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox"></td>
                                                    <td>Reff-008</td>
                                                    <td>
                                                        <strong>Rebecca Smith</strong><br>
                                                        <small>Executive</small>
                                                    </td>
                                                    <td>💻 Senior HTML Developer</td>
                                                    <td>
                                                        <strong>Margaret Soto</strong><br>
                                                        <small>margaret@example.com</small>
                                                    </td>
                                                    <td>$220</td>
                                                    <td>
                                                        <a href="#" class="text-primary"><i class="mdi mdi-pencil"></i></a>
                                                        <a href="#" class="text-danger"><i class="mdi mdi-delete"></i></a>
                                                    </td>
                                                </tr>
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
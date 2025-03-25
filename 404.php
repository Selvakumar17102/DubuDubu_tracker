<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="ekka - Admin Dashboard HTML Template.">

	<title>ekka - Admin Dashboard HTML Template.</title>

	<!-- FAVICON -->
	<link href="assets/img/favicon.png" rel="shortcut icon" />

	<!-- GOOGLE FONTS -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

	<link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />

	<!-- PLUGINS CSS STYLE -->
	<link href="assets/plugins/simplebar/simplebar.css" rel="stylesheet" />

	<link href='assets/plugins/flag-icons/css/flag-icon.min.css' rel='stylesheet'>

	<!-- ekka CSS -->
	<link id="ekka-css" href="assets/css/ekka.css" rel="stylesheet" />

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
					<div class="error-wrapper border bg-white px-5">
						<div class="row justify-content-center align-items-center text-center">
							<div class="col-xl-4">
								<h1 class="text-primary bold error-title">404</h1>
								<p class="pt-4 pb-5 error-subtitle">Looks like something went wrong.</p>
								<a href="index.php" class="btn btn-primary btn-pill">Back to Home</a>
							</div>

							<div class="col-xl-6 pt-5 pt-xl-0 text-center">
								<img src="assets/img/lightenning.png" class="img-fluid" alt="Error Page Image">
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

	<!-- Option Switcher -->
	<script src="assets/plugins/options-sidebar/optionswitcher.js"></script>

	<!-- ekka Custom -->
	<script src="assets/js/ekka.js"></script>
</body>

</html>
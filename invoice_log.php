<?php
    session_start();
    ini_set("display_errors",'off');
    include("include/connection.php");

    $invoice = 'active';
    $invoiceBoolean = 'true';

    if(!empty($_REQUEST['invId'])){
        $invId = $_REQUEST['invId'];
    } else{
        header("Location: invoice.php");
    }

    $sql = "SELECT * FROM invoice WHERE inv_id='$invId'";
    $result = $conn->query($sql);
    $invoiceTable = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Ekka - Admin Dashboard HTML Template.">

	<title>Dubu Dubu - Invoice History</title>

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
							<h1>Invoice History - Inv Ref No: <span style="color: #326be6"><?php echo $invoiceTable['inv_ref_no'] ?></span></h1>
							<p class="breadcrumbs">
                                <span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span><a href="invoice.php">Invoice</a>
								<span><i class="mdi mdi-chevron-right"></i></span>Invoice History
                            </p>
						</div>
					</div>
					<div class="row m-b30">
						<div class="col-12">
							<div class="card card-default">
								<div class="card-body">
									<div class="table-responsive">
										<table id="responsive-data-table" class="table" style="width:100%">
											<thead style="border-width:5px">
												<tr>
													<th>S.No</th>
													<th>Amount</th>
													<th>Date</th>
													<th>Time</th>
												</tr>
											</thead>
											<tbody>
												<?php
                                                    $i = 1;
                                                    $sql = "SELECT * FROM invoice_log WHERE inv_id='$invId'";
                                                    $result = $conn->query($sql);
                                                    while($row = mysqli_fetch_array($result)){
                                                ?>
                                                        <tr>
                                                            <td><?php echo $i++;?></td>
                                                            <td><?php echo $row['received_amount'] ?></td>
                                                            <td><?php echo date('d-m-Y', strtotime($row['date'])) ?></td>
                                                            <td><?php echo date('h:i A', strtotime($row['time'])) ?></td>
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
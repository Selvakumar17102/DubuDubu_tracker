<?php
    session_start();
    ini_set("display_errors",'off');
    date_default_timezone_set("Asia/Calcutta");

    include("include/connection.php");
    $invoice = 'active';
    $invoiceBoolean = 'true';

    $date = date('y-m-d');
    $time = date('H:i:s');

    $msg = "";
    if(!empty($_REQUEST['msg'])){
        $msg = $_REQUEST['msg'];
    }

    $clientId = 0;
    $clientName = "";
    if(!empty($_REQUEST['client_id'])){
        $clientId = $_REQUEST['client_id'];

        $sql = "SELECT * FROM client WHERE client_id='$clientId'";
        $result = $conn->query($sql);
        $clientTable = $result->fetch_assoc();

        $clientName = $clientTable['client_name'];
    }

    $start = $end = '';
    if($_REQUEST['fd'] != ''){
        $start = $_REQUEST['fd'];
        $end = $_REQUEST['ld'];
    } else{
        $end = date('Y-m-d');
        $start = date('Y-m-d');
        // $start = date('Y-m-d', strtotime($end.' - 6days'));
    }

    if(isset($_POST['invoice_submit'])){
        $inv_id = $_POST['editId'];
        $ref_no = $_POST['ref_no'];
        $client_id = $_POST['client_id'];
        $client_address = mysqli_real_escape_string($conn, $_POST['client_address']);
        $date = $_POST['date'];
        $team_name = mysqli_real_escape_string($conn, $_POST['team_name']);

        $totalAmount = 0;

        $sql = "SELECT * FROM client WHERE client_id='$client_id'";
        $result = $conn->query($sql);
        $clientTable = $result->fetch_assoc();

        $sql = "SELECT * FROM invoice_service WHERE name='$team_name'";
        $result = $conn->query($sql);
        $invoiceServiceTable = $result->fetch_assoc();

        $invoiceServiceShortName = $invoiceServiceTable['short_name'];

        if($inv_id > 0){
            $sql = "DELETE FROM invoice_amount WHERE inv_id='$inv_id'";
            $conn->query($sql);

            for($i=0;$i < count($_POST['description']);$i++){
                $description = mysqli_real_escape_string($conn, $_POST['description'][$i]);
                $qty = $_POST['qty'][$i];
                $unit_price = $_POST['unit_price'][$i];
                $amount = $_POST['amount'][$i];

                $sql1 = "INSERT INTO invoice_amount (inv_id,description,qty,unit_price,amount) VALUES ('$inv_id','$description','$qty','$unit_price','$amount')";
                $conn->query($sql1);

                $totalAmount+=$amount;
            }

            if($_POST['is_gst'] == '') {
                $is_gst = 0;
            } else{
                $is_gst = 1;
            }

            if($is_gst){
                $invRef = 'INVG/GTS/';
                $sgst_percent = 9;
                $sgst_amount = ($totalAmount * $sgst_percent)/100;
                $cgst_percent = 9;
                $cgst_amount = ($totalAmount * $cgst_percent)/100;
            } else{
                $invRef = 'INV/GTS/';
                $sgst_percent = 0;
                $sgst_amount = 0;
                $cgst_percent = 0;
                $cgst_amount = 0;
            }

            $inv_ref_no = $invRef."$invoiceServiceShortName/".$clientTable['client_short_name'].date('/Y/m/').$ref_no;

            $overall_total_amount = $totalAmount + $sgst_amount + $cgst_amount;

            $updateSql = "UPDATE invoice SET inv_ref_no='$inv_ref_no',ref_no='$ref_no',client_id='$client_id',date='$date',team_name='$team_name',is_gst='$is_gst',sgst_percent='$sgst_percent',sgst_amount='$sgst_amount',cgst_percent='$cgst_percent',cgst_amount='$cgst_amount',total_amount='$totalAmount',overall_total_amount='$overall_total_amount' WHERE inv_id='$inv_id'" ;
            if($conn->query($updateSql) == TRUE){
                $sql1 = "UPDATE client SET client_address='$client_address' WHERE client_id='$client_id'";
                $conn->query($sql1);

                header("Location: generateInvoicePdf.php?id=$inv_id");
            }

        }else{
            $insertSql = "INSERT INTO invoice (client_id,date,team_name) VALUES('$client_id','$date','$team_name')";
            if($conn->query($insertSql) == TRUE){
                $insertedId = $conn->insert_id;

                for($i=0;$i < count($_POST['description']);$i++){
                    $description = mysqli_real_escape_string($conn, $_POST['description'][$i]);
                    $qty = $_POST['qty'][$i];
                    $unit_price = $_POST['unit_price'][$i];
                    $amount = $_POST['amount'][$i];

                    $sql1 = "INSERT INTO invoice_amount (inv_id,description,qty,unit_price,amount) VALUES ('$insertedId','$description','$qty','$unit_price','$amount')";
                    $conn->query($sql1);

                    $totalAmount+=$amount;
                }

                if($_POST['is_gst'] == '') {
                    $is_gst = 0;
                } else{
                    $is_gst = 1;
                }

                if($is_gst){
                    $invRef = 'INVG/GTS/';
                    $sgst_percent = 9;
                    $sgst_amount = ($totalAmount * $sgst_percent)/100;
                    $cgst_percent = 9;
                    $cgst_amount = ($totalAmount * $cgst_percent)/100;
                } else{
                    $invRef = 'INV/GTS/';
                    $sgst_percent = 0;
                    $sgst_amount = 0;
                    $cgst_percent = 0;
                    $cgst_amount = 0;
                }

                $inv_ref_no = $invRef."$invoiceServiceShortName/".$clientTable['client_short_name'].date('/Y/m/').$ref_no;

                $overall_total_amount = $totalAmount + $sgst_amount + $cgst_amount;

                $updateSql = "UPDATE invoice SET inv_ref_no='$inv_ref_no',ref_no='$ref_no',is_gst='$is_gst',sgst_percent='$sgst_percent',sgst_amount='$sgst_amount',cgst_percent='$cgst_percent',cgst_amount='$cgst_amount',total_amount='$totalAmount',overall_total_amount='$overall_total_amount' WHERE inv_id='$insertedId'";
                $conn->query($updateSql);

                $sql1 = "UPDATE client SET client_address='$client_address' WHERE client_id='$client_id'";
                $conn->query($sql1);

                header("Location: generateInvoicePdf.php?id=$insertedId");
            }
        }
    }

    if(isset($_POST['search'])){
        $fd = $_POST['fd'];
        $ld = $_POST['ld'];
        $client_id = $_POST['clientId'];

        header("Location: invoice.php?client_id=$client_id&fd=$fd&ld=$ld");
    }

    if(isset($_POST['updateReceivedAmount'])){
        $invId = $_POST['invId'];
        $received_amount = $_POST['received_amount'];

        $sql = "SELECT overall_total_amount,received_amount FROM invoice WHERE inv_id='$invId'";
        $result = $conn->query($sql);
        if($result->num_rows){
            $invoiceTable = $result->fetch_assoc();

            if($received_amount >= 0 && ($invoiceTable['received_amount'] + $received_amount) <= $invoiceTable['overall_total_amount']){
                $sql = "UPDATE invoice SET received_amount=received_amount+$received_amount WHERE inv_id='$invId'";
                if($conn->query($sql) === TRUE){
                    $sql = "INSERT INTO invoice_log (inv_id,received_amount,date,time) VALUES ('$invId','$received_amount','$date','$time')";
                    $conn->query($sql);

                    if(($invoiceTable['received_amount'] + $received_amount) == $invoiceTable['overall_total_amount']){
                        $sql = "UPDATE invoice SET status='Completed' WHERE inv_id='$invId'";
                        $conn->query($sql);
                    }

                    header("Location: invoice.php?client_id=$clientId&fd=$start&ld=$end&msg=Amount updated Successfully");
                }
            } else{
                header("Location: invoice.php?client_id=$clientId&fd=$start&ld=$end&msg=Received amount must be less than pending amount");
            }
        } else{
            header("Location: invoice.php?client_id=$clientId&fd=$start&ld=$end&msg=Invoice not found");
        }
    }

    $totalInvoiceCount = $completedInvoice = $pendingInvoice =  0;

    if(!$clientId){
        $sql = "SELECT invoice.*, client.client_name,client.client_short_name,client.client_address,client.client_gst_no,client.date AS client_date  FROM invoice JOIN client ON invoice.client_id = client.client_id WHERE invoice.date BETWEEN '$start' AND '$end' ORDER BY invoice.inv_id DESC";
    } else{
        $sql = "SELECT invoice.*, client.client_name,client.client_short_name,client.client_address,client.client_gst_no,client.date AS client_date  FROM invoice JOIN client ON invoice.client_id = client.client_id WHERE invoice.client_id = '$clientId' AND invoice.date BETWEEN '$start' AND '$end' ORDER BY invoice.inv_id DESC";
    }
    $result = $conn->query($sql);
    if($result->num_rows){
        $totalInvoiceCount = $result->num_rows;
        while($invTable = mysqli_fetch_array($result)){
            if($invTable['status'] == 'Completed'){
                $completedInvoice ++;
            }
            if($invTable['status'] == 'Pending'){
                $pendingInvoice ++;
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

	<title>Dubu Dubu - Invoice</title>

	<!-- GOOGLE FONTS -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

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
							<h1>Invoice</h1>
							<p class="breadcrumbs"><span><a href="index.php">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Invoice</p>
						</div>
					</div>
                    <div class="form-group">
                        <div class="col-sm-12 ">
                            <?php
                                if($msg){
                                    if($msg == "Amount updated Successfully"){
                                        $alert = 'alert-success';
                                    } else{
                                        $alert = 'alert-danger';
                                    }
                            ?>
                                    <div class="alert <?php echo $alert ?>" id="alert_msg"><?php echo $msg ?></div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                    <div class="row m-b30">
						<div class="col-12">
							<div class="card card-default">
								<div class="card-body">
									<div class="row ec-vendor-uploads">
										<div class="col-lg-12">
											<div class="ec-vendor-upload-detail">
												<form id="apply_leave" method="post" class="row g-3" enctype="multipart/form-data">
													<div class="col-md-5">
														<label class="form-label">From</label>
														<input type="date" class="form-control" name="fd" id="fd" value="<?php echo $start; ?>">
													</div>
													<div class="col-md-5">
														<label class="form-label">To</label>
														<input type="date" class="form-control" name="ld" id="ld" value="<?php echo $end; ?>">
													</div>
                                                    <input type="hidden" name="clientId" id="clientId" value="<?php echo $clientId ?>">
													<div class="col-md-2 mt-4">
														<button type="submit" class="btn btn-success" name="search">Search</button>
														<!-- <button type="submit" class="btn btn-success" onclick="filterReport('invoice.php')">Search</button> -->
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
                        <div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
							<div class="card card-mini dash-card card-1">
								<div class="card-body new-class">
									<h2 class="mb-1"><?php echo $totalInvoiceCount ?></h2>
									<p>Total Invoice</p>
									<span class="mdi mdi-note-text"></span>
								</div>
							</div>
						</div>
                        <div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
							<div class="card card-mini dash-card card-1">
								<div class="card-body new-class">
									<h2 class="mb-1"><?php echo $completedInvoice ?></h2>
									<p>Completed Invoice</p>
									<span class="mdi mdi-note-text"></span>
								</div>
							</div>
						</div>
                        <div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
							<div class="card card-mini dash-card card-1">
								<div class="card-body new-class">
									<h2 class="mb-1"><?php echo $pendingInvoice ?></h2>
									<p>Pending Invoice</p>
									<span class="mdi mdi-note-text"></span>
								</div>
							</div>
						</div>
                    </div>
                    <div class="row m-b30">
						<div class="col-12">
							<div class="card card-default">
								<div class="card-header card-header-border-bottom">
                                    <div class="col-sm-10">
                                        <h2><?php echo $clientName ?> Invoice List</h2>
						            </div>
                                    <?php
                                        if(!$clientId){
                                    ?>
                                            <div  class="col-sm-2" style="text-align:end">
                                                <button type="button" class="btn btn-outline-secondary float-right" data-toggle="modal" data-target="#exampleModal">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                                    Add New
                                                </button>
                                            </div>
                                            <div class="modal fade show" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true">
                                                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                                    <div class="modal-content">
                                                        <div class="row m-b30">
                                                            <div class="col-12">
                                                                <div class="card card-default">
                                                                    <div class="card-header card-header-border-bottom">
                                                                        <h2>New Invoice</h2>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="row ec-vendor-uploads">
                                                                            <div class="col-lg-12">
                                                                                <div class="ec-vendor-upload-detail">
                                                                                    <form method="post" enctype="multipart/form-data">		
                                                                                        <div class="row">
                                                                                            <div class="col-md-4">
                                                                                                <label class="form-label">Ref No <span style="color:red;font-weight:bold">*</span></label>
                                                                                                <input type="number" class="form-control" name="ref_no" id="ref_no" placeholder="Ref No" required>
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <label class="form-label">Project Name <span style="color:red;font-weight:bold">*</span></label>
                                                                                                <select name="client_id" id="client_id" class="form-control" required onchange="getClientAddress(this.value)">
                                                                                                    <option selected disabled>Select Project Name</option>
                                                                                                    <?php
                                                                                                        $sql = "SELECT * FROM client WHERE client_status=1";
                                                                                                        $result = $conn->query($sql);
                                                                                                        while($row = mysqli_fetch_array($result)){
                                                                                                    ?>
                                                                                                        <option value="<?php echo $row['client_id']?>"><?php echo $row['client_name']?></option>
                                                                                                    <?php
                                                                                                        }
                                                                                                    ?>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <label class="form-label">Date <span style="color:red;font-weight:bold">*</span></label>
                                                                                                <input type="date" class="form-control" name="date" id="date" placeholder="Select Date" required>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-sm-12">
                                                                                                <label class="form-label">Client Address <span style="color:red;font-weight:bold">*</span></label>
                                                                                                <textarea name="client_address" id="client_address" cols="20" rows="3" required></textarea>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-6">
                                                                                                <label class="form-label">Services <span style="color:red;font-weight:bold">*</span></label>
                                                                                                <select name="team_name" id="team_name" class="form-control" required>
                                                                                                    <option selected disabled>Select Service</option>
                                                                                                    <?php
                                                                                                        $sql = "SELECT * FROM invoice_service";
                                                                                                        $result = $conn->query($sql);
                                                                                                        while($row = mysqli_fetch_array($result)){
                                                                                                    ?>
                                                                                                        <option value="<?php echo $row['name']?>"><?php echo $row['name']?></option>
                                                                                                    <?php
                                                                                                        }
                                                                                                    ?>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-1" style="display: flex; align-items: center;">
                                                                                                <input type="checkbox" name="is_gst" id="is_gst" style="margin-top: 20px">
                                                                                                <label for="is_gst">GST</label>
                                                                                            </div>
                                                                                            <div class="col-md-5"></div>
                                                                                        </div>
                                                                                        <div class="form-group" id="duplicate">
                                                                                            <div class="row">
                                                                                                <div class="col-md-4">
                                                                                                    <label class="form-label">Description<span style="color:red;font-weight:bold">*</span></label>
                                                                                                    <input type="text" class="form-control" name="description[]" id="description"  placeholder="Description" required>
                                                                                                </div>
                                                                                                <div class="col-md-3">
                                                                                                    <label class="form-label">Quantity<span style="color:red;font-weight:bold">*</span></label>
                                                                                                    <input type="text" class="form-control" name="qty[]" id="qty"  placeholder="Quantity" required>
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <label class="form-label">Unit Price<span style="color:red;font-weight:bold">*</span></label>
                                                                                                    <input type="number" class="form-control" name="unit_price[]" id="unit_price"  placeholder="Unit Price" required>
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <label class="form-label">Amount<span style="color:red;font-weight:bold">*</span></label>
                                                                                                    <input type="number" class="form-control" name="amount[]" id="amount"  placeholder="Amount" required>
                                                                                                </div>
                                                                                                <div class="col-sm-1">
                                                                                                    <button type="button" style="margin-top: 35px;" name="add" id="add" class="btn btn-success w-100">+</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="modal-footer px-4">
                                                                                            <button type="submit" name="invoice_submit" id="invoice_submit" class="btn btn-primary">Submit</button>
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
                                    <?php
                                        }
                                    ?>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="responsive-data-table" class="table" style="width:100%">
											<thead style="border-width:5px">
												<tr>
													<th>S.No</th>
                                                    <th>Inv Ref No</th>
                                                    <th>Date</th>
                                                    <th>Project Name</th>
                                                    <th>Service</th>
													<th>Total Amount</th>
													<th>Pending Amount</th>
													<th>Received Amount</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
                                                <?php
                                                    $i=1;
                                                    if(!$clientId){
                                                        $invoiceSql = "SELECT invoice.*, client.client_name,client.client_short_name,client.client_address,client.client_gst_no,client.date AS client_date  FROM invoice JOIN client ON invoice.client_id = client.client_id WHERE invoice.date BETWEEN '$start' AND '$end' ORDER BY invoice.inv_id DESC";
                                                    } else{
                                                        $invoiceSql = "SELECT invoice.*, client.client_name,client.client_short_name,client.client_address,client.client_gst_no,client.date AS client_date  FROM invoice JOIN client ON invoice.client_id = client.client_id WHERE invoice.client_id = '$clientId' AND invoice.date BETWEEN '$start' AND '$end' ORDER BY invoice.inv_id DESC";
                                                    }
                                                    $invoiceResult = $conn->query($invoiceSql);
                                                    while($invoiceRow = mysqli_fetch_array($invoiceResult)){
                                                        $gstChecked = '';
                                                        if($invoiceRow['is_gst'] == 1){
                                                            $gstChecked = "checked";
                                                        }

                                                        $pendingAmount = $invoiceRow['overall_total_amount'] - $invoiceRow['received_amount'];
                                                ?>
													<tr>
														<td><?php echo $i++;?></td>
														<td><a href="invoice_log.php?invId=<?php echo $invoiceRow['inv_id'] ?>"><?php echo $invoiceRow['inv_ref_no'] ?></a></td>
														<td><?php echo date('d-m-Y', strtotime($invoiceRow['date']));?></td>
														<td><?php echo $invoiceRow['client_name'];?></td>
                                                        <td><?php echo $invoiceRow['team_name'];?></td>
														<td><?php echo $invoiceRow['overall_total_amount'];?></td>
                                                        <td>
                                                            <?php
                                                                if($invoiceRow['status'] == 'Pending'){
                                                            ?>
                                                                    <input class="form-control" type="number" name="pending_amount" value="<?php echo $pendingAmount ?>" readOnly>
                                                            <?php
                                                                } else{
                                                            ?>
                                                                    <span>N/A</span>
                                                            <?php
                                                                }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                                if($pendingAmount){
                                                            ?>
                                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#receivedAmt<?php echo $invoiceRow['inv_id'];?>">Received Amount</button>
                                                                    <div class="modal fade show" id="receivedAmt<?php echo $invoiceRow['inv_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-modal="true">
                                                                        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="row m-b30">
                                                                                    <div class="col-12">
                                                                                        <div class="card card-default">
                                                                                            <div class="card-header card-header-border-bottom">
                                                                                                <h2>Enter Received Amount</h2>
                                                                                            </div>
                                                                                            <div class="card-body">
                                                                                                <div class="row ec-vendor-uploads">
                                                                                                    <div class="col-lg-12">
                                                                                                        <div class="ec-vendor-upload-detail">
                                                                                                            <form method="post" enctype="multipart/form-data">
                                                                                                                <div class="row">
                                                                                                                    <div class="col-md-8">
                                                                                                                        <label class="form-label">Received Amount <span style="color:red;font-weight:bold">*</span></label>
                                                                                                                        <input class="form-control" type="number" name="received_amount" placeholder="Enter Received Amount">
                                                                                                                        <input type="hidden" name="invId" value="<?php echo $invoiceRow['inv_id'];?>">
                                                                                                                    </div>
                                                                                                                    <div class="col-md-4 mt-4">
                                                                                                                    <button type="submit" name="updateReceivedAmount" id="updateReceivedAmount" class="btn btn-primary">Update</button>
                                                                                                                    </div>
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
                                                            <?php
                                                                } else{
                                                            ?>
                                                                    <button class="btn btn-success" id="completedBtn<?php echo $invoiceRow['inv_id'] ?>" disabled>Completed</button>
                                                            <?php
                                                                }
                                                            ?>
                                                        </td>
														<td>
                                                            <?php
                                                                if(!$clientId){
                                                                    if($pendingAmount){
                                                            ?>
                                                                        <a href="edit_invoice.php?invId=<?php echo $invoiceRow['inv_id']?>"><span class="mdi mdi-pencil-box-outline" style="font-size:30px;color:blue"></span></a>
                                                            <?php
                                                                    }
                                                                }
                                                            ?>
                                                            <a href="generateInvoicePdf.php?id=<?php echo $invoiceRow['inv_id'] ?>" target="_blank" class="mdi mdi-cloud-print-outline" style="font-size:30px;color:blue"></a>
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
    <script>
        function filterReport(url){
            let fd = document.getElementById('fd')
            let ld = document.getElementById('ld')
            let clientId = document.getElementById('clientId')

            if(fd.value == ''){
                fd.style.border = '1px solid red'
                return false
            } else{
                fd.style.border = '1px solid #bfc9d4'
                if(ld.value == ''){
                    ld.style.border = '1px solid red'
                    return false
                } else{
                    ld.style.border = '1px solid #bfc9d4'
                    location.replace(url+'?client_id='+clientId.value+'&fd='+fd.value+'&ld='+ld.value)
                }
            }
        }

        var i = 0;
        $('#add').click(function(){
            i++;
            $('#duplicate').append(
                '<div class="row" id="duplicate'+ i+'"><div class="col-sm-4"><input type="text" name="description[]" id="description'+ i+'" class="form-control" placeholder="Description" autocomplete="off"></div><div class="col-sm-3"><input type="text" name="qty[]" id="qty'+ i+'" class="form-control" placeholder="Qty" autocomplete="off"></div><div class="col-sm-2"><input type="number" name="unit_price[]" id="unit_price'+ i+'" class="form-control" placeholder="Unit Price" autocomplete="off"></div><div class="col-sm-2"><input type="number" name="amount[]" id="amount'+ i+'" class="form-control" placeholder="Amount" autocomplete="off"></div><div class="col-sm-1"><button type="button" name="remove" class="btn btn-danger btn_remove w-100" id="'+i+'">X</button></div></div>'
            );
        });
        $(document).on('click', '.btn_remove', function(){  
            var button_id = $(this).attr("id");   
            $('#duplicate'+button_id+'').remove();  
        });
    </script>
</body>
</html>
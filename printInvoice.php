<?php
    session_start();
    ini_set("display_errors",'off');
    include("include/connection.php");

    $invId = $_REQUEST['id'];

    $invoiceSql = "SELECT invoice.*, client.client_name,client.client_short_name,client.client_address,client.client_gst_no,client.date AS client_date FROM invoice JOIN client ON invoice.client_id = client.client_id WHERE inv_id='$invId'";
    $invoiceResult = $conn->query($invoiceSql);
    $invoiceRow = mysqli_fetch_array($invoiceResult);

    function getIndianCurrency(float $number) {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'one', 2 => 'two',
            3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
            7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
        $digits = array('', 'hundred','thousand','lakh', 'crore');
        while( $i < $digits_length ) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ucfirst($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>

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
    <style>
        p{
            color: #000;
        }
        table thead th{
            color: #000;
        }
        table tbody tr{
            color: #000;
        }

        @media (max-width: 480px) {
            .gtechBankDetails {
                margin-top: 20px;
            }
            .regards {
                margin-top: 20px;
            }
            .noprint {
                visibility: hidden;
            }
        }
        @media print {
            .noprint {
                visibility: hidden;
            }
        }
    </style>
</head>
<body class="ec-header-fixed ec-sidebar-fixed ec-sidebar-dark ec-header-light" id="body">
    <!-- WRAPPER -->
    <div class="wrapper">
        <div class="content">
            <div class="row">
                <div class="col-sm-6 col-md-6">
                    <img src="assets/img/logo/fullLogo.png" alt="">
                    <p>1278, Kamban Nagar, Rajagopalapuram, Pudukkottai 622003.</p>
                </div>
                <div class="col-sm-3 col-md-3 noprint">
                    <!-- <a class="btn btn-primary" href="invoice.php">Back</a> -->
                </div>
                <div class="col-sm-3 col-md-3">
                    <p style="font-weight: bolder; font-size: 30px; color: #ff8b00; float: right">INVOICE</p>
                </div>
            </div>
            <div class="row mt-3" style="border-style: solid; border-color: #4472c470; padding: 10px">
                <div class="col-sm-6 col-md-6" style="">
                    <span>INV REF NO </span> <p style="margin-left: 10px"><?php echo $invoiceRow['inv_ref_no'] ?></p>
                </div>
                <div class="col-sm-4 col-md-4"></div>
                <div class="col-sm-2 col-md-2" style="">
                    <span>Date </span> <p style="margin-left: 10px"><?php echo $invoiceRow['date'] ?></p>
                </div>
            </div>
            <div class="row mt-3">
                <span style="font-weight: bold; font-size: 20px; color: #4472c4;">CLIENT GST No: <?php echo $invoiceRow['client_gst_no'] ?></span>
            </div>
            <div class="row mt-3">
                <span style="font-weight: 400; font-size: 16px; color: #4472c4;">To</span>
                <p><?php echo $invoiceRow['client_name'] ?></p>
                <p><?php echo $invoiceRow['client_address'] ?></p>
            </div>
            <div class="row mt-2">
                <table id="responsive-data-table" class="table" style="width:100%; border-style: solid; border-color: #4472c470;">
                    <thead>
                        <tr>
                            <th>DESCRIPTION</th>
                            <th>QTY</th>
                            <th>UNIT PRICE</th>
                            <th>AMOUNT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $invoiceRow['description'] ?></td>
                            <td><?php echo $invoiceRow['qty'] ?></td>
                            <td>₹ <?php echo $invoiceRow['unit_price'] ?></td>
                            <td>₹ <?php echo $invoiceRow['amount'] ?></td>
                        </tr>
                        <?php
                            if($invoiceRow['is_gst']){
                        ?>
                                <tr>
                                    <td></td>
                                    <td>SGST <?php echo $invoiceRow['sgst_percent'] ?>%</td>
                                    <td></td>
                                    <td>₹ <?php echo $invoiceRow['sgst_amount'] ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>CGST <?php echo $invoiceRow['cgst_percent'] ?>%</td>
                                    <td></td>
                                    <td>₹ <?php echo $invoiceRow['cgst_amount'] ?></td>
                                </tr>
                        <?php
                            }
                        ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="font-weight: bold;">GRAND TOTAL</td>
                            <td style="font-weight: 600;">₹ <?php echo $invoiceRow['total_amount'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row mt-3">
                <div class="col-sm-9" style="">
                    <span style="color: #000">Amount (in words): <?php echo getIndianCurrency($invoiceRow['total_amount']) ?></span>
                </div>
                <div class="col-sm-3 gtechBankDetails">
                    <p style="color: #000; font-weight: 500">GST: 33AAUFG5988K1ZH</p>
                    <p style="color: #000; font-weight: 100">Account Name: G Tech Solutions</p>
                    <p style="color: #000; font-weight: 100">Bank Name: Axis Bank Ltd</p>
                    <p style="color: #000; font-weight: 100">Account Number: 919020087864680</p>
                    <p style="color: #000; font-weight: 100">IFSC Code: UTIB0000602</p>
                </div>
            </div>
            <div class="row regards">
                <p class="mb-3" style="color: #4472c4">Thanks & regards</p>
                <p>Narein Muruganandam</p>
                <p>P: 9842301477</p>
            </div>
            <div class="row regards">
                <p style="text-align: center; color: #ff8b00;">Thank you for your busines</p>
            </div>
        </div> 
    </div> 
    <!-- End Wrapper -->

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
</body>
<script>
    window.print();
</script>
</html>
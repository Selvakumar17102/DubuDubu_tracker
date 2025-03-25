<?php

session_start();
ini_set('display_errors', 'off');
include('include/connection.php');
$payslip = 'active';
$payslip_boolean = 'true';

$today = date('Y-m-d');

    if(isset($_POST['save'])){
        $date = $_POST['formdate'];
        $userid = $_POST['userid'];
        $lop = $_POST['lop'];

        $rupees ="&#8377";

        $sql = "SELECT * FROM employee WHERE id = $userid";
        $result =$conn->query($sql);
        $row = mysqli_fetch_array($result);

        // Use mktime() and date() function to
        // convert number to month name
        // $month_num =3;
        $month = date('n', strtotime($date));
        $year = date('Y', strtotime($date));
        $month_name = date("F", mktime(0, 0, 0, $month, 10));
        $sdate = date("01-m-Y",strtotime($date));
        $edate =  date('t-m-Y', strtotime($date));

        $num_days_mon = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $start_date = date("Y-m-01",strtotime($date));
        $end_date =  date('Y-m-t', strtotime($date));
        $doj = $row['doj'];
        $resign_date = $row['resign_date'];

        if($doj > $start_date){
            $diff = abs(strtotime($doj) - strtotime($start_date));
            $years = floor($diff / (365*60*60*24));
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
            // $days = 7;
            
            $actual_salary = $row['basic_salary'];
            $calSalary = round(($actual_salary / 30)*$days);
            $detuct_salary = $actual_salary - $calSalary;
        }
        else{
            if($resign_date == ""){
                $detuct_salary = $row['basic_salary'];
            }
            else{
                if($resign_date < $end_date){
                    $diff = abs(strtotime($end_date) - strtotime($resign_date));
                    $years = floor($diff / (365*60*60*24));
                    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                    $salary_days = $num_days_mon - $days;
                    
                    $actual_salary = $row['basic_salary'];
                    $calSalary = round(($actual_salary / 30)*$salary_days);
                    $detuct_salary = $actual_salary - $calSalary;
                    // echo $detuct_salary; die();
                }
                else{
                    $detuct_salary = $row['basic_salary'];
                }
            }
        }

        $lopcalamt=round(($salary / 30)*$lop);
        $lopamt = $detuct_salary - $lopcalamt;
        
        $grosslopamt = $salary - $lop;

        $basic_salary = (40 / 100) * $salary;
        $hra = (24 / 100) * $salary;
        $ta = (13 / 100) * $salary;
        $cca = (17 / 100) * $salary;
        $ma = (6 / 100) * $salary;

        $earned_salary = (40 / 100) * $lopamt;
        $earned_hra = (24 / 100) * $lopamt;
        $earned_ta = (13 / 100) * $lopamt;
        $earned_cca = (17 / 100) * $lopamt;
        $earned_ma = (6 / 100) * $lopamt;
        
        // echo $basic_salary;
        $actGrosspay = $basic_salary+$hra+$ta+$cca+$ma;
        $earGrosspay = $earned_salary+$earned_hra+$earned_ta+$earned_cca+$earned_ma;

        $month1 = date('m', strtotime($date));
        $year_mon = $year."-".$month1;
        $pre_days = 30 - floatval($lop);

        // $pay_sql = "SELECT * FROM payslip WHERE emp_id = '$userid' AND sal_month_year = '$year_mon'";
        // $pay_result = $conn->query($pay_sql);
        // if($pay_result->num_rows > 0){
        //     $pay_sql1 = "UPDATE payslip SET present_days = '$pre_days', lop_days = '$lop', salary_to_pay = '$earGrosspay', updated_date = '$today' WHERE emp_id = '$userid' AND sal_month_year = '$year_mon'";
        //     if($conn->query($pay_sql1)){
        //         header('location:payslip.php?msg=Payslip Updated !&type=warning');
        //     }
        // }
        // else{
        //     $pay_sql1 = "INSERT INTO payslip (emp_id, sal_month_year, days_in_month, sal_cal_days, present_days, lop_days, actual_salary, salary_to_pay, created_date, updated_date) VALUES ('$userid', '$year_mon', '$num_days_mon', 30, '$pre_days', '$lop', '$salary', '$earGrosspay', '$today', '$today')";
        //     if($conn->query($pay_sql1)){
        //         header('location:payslip.php?msg=Payslip Added !&type=success');
        //     }
        // }
    }

    if(isset($_POST['generate'])){
        $date = $_POST['formdate'];
        $userid = $_POST['userid'];
        $lop = $_POST['lop'];
        
        $rupees ="&#8377";
        
        $sql = "SELECT * FROM employee WHERE id=$userid";
        $result =$conn->query($sql);
        $row = mysqli_fetch_array($result);
        
        // Use mktime() and date() function to
        // convert number to month name
        // $month_num =3;
        $month = date('n', strtotime($date));
        $year = date('Y', strtotime($date));
        $month_name = date("F", mktime(0, 0, 0, $month, 10));
        $sdate = date("01-m-Y",strtotime($date));
        $edate =  date('t-m-Y', strtotime($date));

        $num_days_mon = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $start_date = date("Y-m-01",strtotime($date));
        $end_date =  date('Y-m-t', strtotime($date));
        $doj = $row['doj'];
        $resign_date = $row['resign_date'];

        if($doj > $start_date){
            $diff = abs(strtotime($doj) - strtotime($start_date));
            $years = floor($diff / (365*60*60*24));
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
            // $days = 7;
            
            $actual_salary = $row['basic_salary'];
            $calSalary = round(($actual_salary / 30)*$days);
            $detuct_salary = $actual_salary - $calSalary;
        }
        else{
            if($resign_date == ""){
                $detuct_salary = $row['basic_salary'];
            }
            else{
                if($resign_date < $end_date){
                    $diff = abs(strtotime($end_date) - strtotime($resign_date));
                    $years = floor($diff / (365*60*60*24));
                    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                    $salary_days = $num_days_mon - $days;
                    
                    $actual_salary = $row['basic_salary'];
                    $calSalary = round(($actual_salary / 30)*$salary_days);
                    $detuct_salary = $actual_salary - $calSalary;
                    // echo $detuct_salary; die();
                }
                else{
                    $detuct_salary = $row['basic_salary'];
                }
            }
        }
        
        $salary = $row['basic_salary'];
        $lopcalamt=round(($salary / 30)*$lop);
        $lopamt = $detuct_salary - $lopcalamt;
        // echo $lopcalamt;
        $grosslopamt = $salary - $lop;

        $basic_salary = (40 / 100) * $salary;
        $hra = (24 / 100) * $salary;
        $ta = (13 / 100) * $salary;
        $cca = (17 / 100) * $salary;
        $ma = (6 / 100) * $salary;

        $earned_salary = (40 / 100) * $lopamt;
        $earned_hra = (24 / 100) * $lopamt;
        $earned_ta = (13 / 100) * $lopamt;
        $earned_cca = (17 / 100) * $lopamt;
        $earned_ma = (6 / 100) * $lopamt;
        // echo $basic_salary;
        $actGrosspay = $basic_salary+$hra+$ta+$cca+$ma;
        $earGrosspay = $earned_salary+$earned_hra+$earned_ta+$earned_cca+$earned_ma;

        $month1 = date('m', strtotime($date));
        $year_mon = $year."-".$month1;
        $pre_days = 30 - floatval($lop);

        // $pay_sql = "SELECT * FROM payslip WHERE emp_id = '$userid' AND sal_month_year = '$year_mon'";
        // $pay_result = $conn->query($pay_sql);
        // if($pay_result->num_rows > 0){
        //     $pay_sql1 = "UPDATE payslip SET present_days = '$pre_days', lop_days = '$lop', salary_to_pay = '$earGrosspay', updated_date = '$today' WHERE emp_id = '$userid' AND sal_month_year = '$year_mon'";
        //     $pay_result1 = $conn->query($pay_sql1);
        // }
        // else{
        //     $pay_sql1 = "INSERT INTO payslip (emp_id, sal_month_year, days_in_month, sal_cal_days, present_days, lop_days, actual_salary, salary_to_pay, created_date, updated_date) VALUES ('$userid', '$year_mon', '$num_days_mon', 30, '$pre_days', '$lop', '$salary', '$earGrosspay', '$today', '$today')";
        //     $pay_result1 = $conn->query($pay_sql1);
        // }
    }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Ekka - Admin Dashboard HTML Template.">

	<title>DUBU DUBU - Payslip</title>
    <style>
        @media print {
            body {
              visibility: hidden;
            }
            #printView {
              visibility: visible;
              position: absolute;
              left: 0;
              top: 0;
              page-break-after: auto;
            }
            /* #printView:last-child {
            } */
        }
    </style>

	<!-- GOOGLE FONTS -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

	<link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />

	<!-- PLUGINS CSS STYLE -->
	<link href="assets/plugins/simplebar/simplebar.css" rel="stylesheet" />

	<!-- Data Tables -->
	<link href='assets/plugins/data-tables/datatables.bootstrap5.min.css' rel='stylesheet'>
	<link href='assets/plugins/data-tables/responsive.datatables.min.css' rel='stylesheet' >

	<!-- ekka CSS -->
	<link id="ekka-css" rel="stylesheet" href="assets/css/ekka.css" />

	<!-- FAVICON -->
	<link href="assets/img/favicon.png" rel="shortcut icon" />
    <style>
        body{
            color:black;
        }
        thead.customtable th {
            color: white;
        }
        tbody td,th {
            color: black;
        }
        .customtable {
            background: #1280e5;
            color: white;
            font-weight: bold;
        }
        @media print {
            html, body {
          height:100%; 
          margin: 0 !important; 
          padding: 0 !important;
          overflow: hidden;
        }
            /* html, body {
                border: 1px solid white;
                height: 99%;
                page-break-after: avoid;
                page-break-before: avoid;
            }
            .print-display-none,
            .print-display-none * {
                display: none !important;
            }
            .print-visibility-hide,
            .print-visibility-hide * {
                visibility: hidden !important;
            }
            .printme,
            .printme * {
                visibility: visible !important;
            }
            .printme {
                position: absolute;
                left: 0;
                top: 0;
            } */
            thead.customtable {
                background: #1280e5;
                color: white;
                font-weight: bold;
                -webkit-print-color-adjust: exact;
            }
        }
        
        /* @page :footer {
            display: none
        }
    
        @page :header {
            display: none
        } */
        @page { size: A4;  margin: auto; }
        /* table { page-break-inside:auto }
        tr    { page-break-inside:avoid; page-break-after:auto }
        thead { display:table-header-group }
        tfoot { display:table-footer-group } */
    </style>
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
                <div class="printView" id="printView">
                    <div class="container mt-5 mb-5">
                        <div class="row">
                            <div class="logo d-flex justify-content-center p-3">
                                <!-- <div class="leftlogo"><img src="gtech_logo.png" width="150px" alt=""></div> -->
                                <!-- <div class="rightlogo"> -->
                                    <img src="assets/img/logo/fullname_logo.png" width="400px" alt="">
                                <!-- </div> -->
                            </div>
                            <div class="col-md-12">
                                <div class="text-center lh-1 mb-2">
                                    <h6 class="fw-bold p-1">Payslip for the month of <?= $month_name." ".$year; ?></h6> <span class="fw-normal"><span class="fw-normal">Pay Period <?= $sdate." to ".$edate; ?></span>
                                </div>
                                <!-- <div class="d-flex justify-content-end"> <span>Working Branch:ROHINI</span> </div> -->
                                <div class="row">
                                    <table class="mt-4 table table-bordered table-responsive text-nowrap">
                                        <thead class="customtable">
                                            <tr>
                                                <td colspan="4" class="text-center">Employee Details</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Employee Name</td>
                                                <td><?= $row['fname']." ".$row['lname'];?></td>
                                                <td>Date of joining</td>
                                                <td><?= date("d-m-Y", strtotime($row['doj']));?></td>
                                            </tr>
                                            <tr>
                                                <td>Employee Code</td>
                                                <td><?= $row['emp_id'];?></td>
                                                <td>Location</td>
                                                <td><?= $row['location'];?></td>
                                            </tr>
                                            <tr>
                                                <td>Designation</td>
                                                <td><?= $row['designation']; ?></td>
                                                <td>Pan No</td>
                                                <?php
                                                    if($row['pan_card_no'] != ""){
                                                        $panNo = $row['pan_card_no'];
                                                    }
                                                    else{
                                                        $panNo = "NA";
                                                    }
                                                ?>
                                                <td><?php echo $panNo; ?></td>
                                            </tr>
                                            <tr>
                                                <td>No of Working Days</td>
                                                <td>30</td>
                                                <td>Lop</td>
                                                <td><?= $lop; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                </div class="row">
                                    <table class="mt-4 table table-bordered text-nowrap">
                                        <thead class="customtable">
                                            <tr>
                                                <th scope="col">Salary Structure</th>
                                                <th scope="col">Actual (<?= $rupees; ?>)</th>
                                                <th scope="col">Earned (<?= $rupees; ?>)</th>
                                                <th scope="col">Deductions</th>
                                                <th scope="col">Amount (<?= $rupees; ?>)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td scope="row">Basic Salary</td>
                                                <td><?php echo number_format($basic_salary); ?></td>
                                                <td><?php echo number_format($earned_salary,2); ?></td>
                                                <td>LOP</td>
                                                <td><?php echo number_format($lopcalamt,2); ?></td>
                                            </tr>
                                            <tr>
                                                <td scope="row">House Rent Allowance</td>
                                                <td><?php echo number_format($hra,2); ?></td>
                                                <td><?php echo number_format($earned_hra,2); ?></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td scope="row">Travel Allowance</td>
                                                <td><?php echo number_format($ta,2); ?></td>
                                                <td><?php echo number_format($earned_ta,2); ?></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td scope="row">City Compensatory Allowance</td>
                                                <td><?php echo number_format($cca,2); ?></td>
                                                <td><?php echo number_format($earned_cca,2); ?></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td scope="row">Medical Allowance</td>
                                                <td><?php echo number_format($ma,2); ?></td>
                                                <td><?php echo number_format($earned_ma,2); ?></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Gross Pay</th>
                                                <th><?php echo $rupees." ".number_format($actGrosspay,2); ?></th>
                                                <th><?php echo $rupees." ".number_format($earGrosspay,2); ?></th>
                                                <th>Gross Deduction</th>
                                                <th><?php echo $rupees." ".number_format($lopcalamt,2); ?></th>
                                            </tr>
                                            <tr>
                                                <th colspan="4">Net Pay</th>
                                                <th><?php echo $rupees." ".number_format($earGrosspay,2); ?></th>
                                            </tr>
                                            <?php
                                            /**
                                             * Converting Currency Numbers to words currency format
                                             */
                                                $number = $earGrosspay;
                                                $no = floor($number);
                                                $point = round($number - $no, 2) * 100;
                                                $hundred = null;
                                                $digits_1 = strlen($no);
                                                $i = 0;
                                                $str = array();
                                                $words = array('0' => '', '1' => 'one', '2' => 'two',
                                                    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
                                                    '7' => 'seven', '8' => 'eight', '9' => 'nine',
                                                    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
                                                    '13' => 'thirteen', '14' => 'fourteen',
                                                    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
                                                    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
                                                    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
                                                    '60' => 'sixty', '70' => 'seventy',
                                                    '80' => 'eighty', '90' => 'ninety');
                                                $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
                                                while ($i < $digits_1) {
                                                    $divider = ($i == 2) ? 10 : 100;
                                                    $number = floor($no % $divider);
                                                    $no = floor($no / $divider);
                                                    $i += ($divider == 10) ? 1 : 2;
                                                    if ($number) {
                                                        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                                                        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                                                        $str [] = ($number < 21) ? $words[$number] .
                                                            " " . $digits[$counter] . $plural . " " . $hundred
                                                            :
                                                            $words[floor($number / 10) * 10]
                                                            . " " . $words[$number % 10] . " "
                                                            . $digits[$counter] . $plural . " " . $hundred;
                                                    } else $str[] = null;
                                                }
                                                $str = array_reverse($str);
                                                $result = implode('', $str);
                                                $points = ($point) ?
                                                    "." . $words[$point / 10] . " " . 
                                                        $words[$point = $point % 10] : '';
                                            //   echo $result . "Rupees  " . $points . " Paise";
                                            ?> 
                                            <tr style="text-align: center;">
                                                <th colspan="5">Amount in words : <?php echo ucwords($result) . "Rupees Only" ?></th>
                                            </tr>
                                            <tr style="text-align: center;">
                                                <td colspan="5" class="notification">
                                                    *** This is computer generated pay slip, doesnt require signature ***
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-md-4"> <br> <span class="fw-bold">Net Pay : 24528.00</span> </div>
                                    <div class="border col-md-8">
                                        <div class="d-flex flex-column"> <span>In Words</span> <span>Twenty Five thousand nine hundred seventy only</span> </div>
                                    </div>
                                </div> -->
                                <div class="d-flex justify-content-end">
                                    <!-- <div class="d-flex flex-column mt-2"> <span class="fw-bolder">For Kalyan Jewellers</span> <span class="mt-4">Authorised Signatory</span> </div> -->
                                    <button type="submit" class="btn btn-primary d-print-none mt-3" onClick="window.print()">Print</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				</div> <!-- End Content -->
			</div> 
            <!-- End Content Wrapper -->

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

	<!-- Data Tables -->
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
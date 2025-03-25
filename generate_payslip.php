<?php
session_start();
ini_set("display_errors",'off');
include("include/connection.php");

$rupees ="&#8377";
if (isset($_GET['emp_id']) && isset($_GET['month'])) {
    $emp_id = $_GET['emp_id'];
    $selectedMonth = $_GET['month'];

            
    $sql = "SELECT * FROM employee e 
            LEFT JOIN designation d ON e.designation = d.desig_id
            WHERE e.id = '$emp_id'";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $gross_salary = $row['basic_salary'];
    $advance_salary = $row['advance_salary'];


    $year = date("Y", strtotime($selectedMonth));
    $month_name  = date("F", strtotime($selectedMonth));
    $month = date("m", strtotime($selectedMonth));

    $start_date = date("Y-m-26", strtotime("-1 month", strtotime($selectedMonth)));
    $end_date = date("Y-m-25", strtotime($selectedMonth));

    $lopquery = "SELECT SUM(leave_value) as total_leaves FROM employee_leave WHERE emp_id = '$emp_id' AND tl_status = '1' AND count != '3' AND from_date BETWEEN '$start_date' AND '$end_date'";
    $lopresult = $conn->query($lopquery);
    $loprow = $lopresult->fetch_assoc();
    $total_leaves_this_month = $loprow['total_leaves'] ?? 0;
    $allowed_leave = 1;
    $loss_of_day = ($total_leaves_this_month > $allowed_leave) ? ($total_leaves_this_month - $allowed_leave) : 0;


    $start = new DateTime($start_date);
    $end = new DateTime($end_date);
    $diff = $start->diff($end);
    $total_days = $diff->days + 1;

    $paidday = $total_days - $loss_of_day;

    $perday_salary = $gross_salary / $total_days;

    $lop_salary = $perday_salary * $loss_of_day;

    $net_salary  = $paidday * $perday_salary;

    $earnsql = "SELECT * FROM payroll_details WHERE type = 'earning'";
    $earnRes = $conn->query($earnsql);
    $earnings = $earnRes->fetch_all(MYSQLI_ASSOC);

    $deducsql = "SELECT * FROM payroll_details WHERE type = 'deduction'";
    $deducRes = $conn->query($deducsql);
    $deductions = $deducRes->fetch_all(MYSQLI_ASSOC);

    $totalEarnings = 0;
    $totalDeductions = 0;

    $result = [
        'earnings' => [],
        'deductions' => []
    ];

    $basicSalary = 0;

    foreach ($earnings as $earning) {
        if ($earning['name'] == 'Basic Salary') {
            if ($earning['unit'] == '%') {
                $basicSalary = round(($gross_salary * $earning['amount']) / 100);
            } else {
                $basicSalary = round($earning['amount']);
            }
            $result['earnings'][$earning['name']] = $basicSalary;
            $totalEarnings += $basicSalary;
            break;
        }
    }

    $allowanceRules = [
        'conveyance' => [
            'low' => 1500,
            'high' => 4000
        ],
        'medical' => [
            'low' => 1250,
            'high' => 2500
        ]
    ];

    foreach ($earnings as $earning) {
        $amount = 0;
        
        if ($earning['name'] != 'Basic Salary') {
            if ($earning['name'] == 'Conveyance Allowance') {
                $amount = round(($gross_salary <= 20000) ? $allowanceRules['conveyance']['low'] : $allowanceRules['conveyance']['high']);
            } elseif ($earning['name'] == 'Medical Allowances') {
                $amount = round(($gross_salary <= 20000) ? $allowanceRules['medical']['low'] : $allowanceRules['medical']['high']);
            } else {
                if ($earning['unit'] == '%') {
                    $amount = round(($basicSalary * $earning['amount']) / 100);
                } else {
                    $amount = round($earning['amount']);
                }
            }
    
            $result['earnings'][$earning['name']] = $amount;
            $totalEarnings += $amount;
        }
    }

    foreach ($deductions as $deduction) {
        if ($deduction['unit'] == '%') {
            $amount = round(($gross_salary * $deduction['amount']) / 100);
        } else {
            $amount = round($deduction['amount']);
        }
        $result['deductions'][$deduction['name']] = $amount;
        $totalDeductions += $amount;
    }

    $special_allowance = $gross_salary - $totalEarnings;

    $result['earnings']["Special Allowance"] = $special_allowance;
    $result['deductions']['LOP'] = $lop_salary;



    // print_r($result);

    // echo "<br> Total : ".$totalEarnings."<br> special Allowance : ".$gross_salary - $totalEarnings."<br> deduction:".$totalDeductions;

} else {
    echo "Invalid request!";
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
                <div class="printView" id="printView">
                    <div class="container mt-5 mb-5">
                        <div class="row">
                            <div class="logo d-flex justify-content-center">
                                <!-- <div class="leftlogo"><img src="gtech_logo.png" width="150px" alt=""></div> -->
                                <!-- <div class="rightlogo"> -->
                                    <img src="assets/img/logo/fullname_logo.png" width="700px" alt="">
                                <!-- </div> -->
                            </div>
                            <div class="col-md-12">
                                <div class="text-center lh-1 mb-2">
                                    <p>Old No 147, New No 16, Rajiv Gandhi Salai, Karapakkam, Chennai, Tamil Nadu 600097</p><br>
                                    <h6 class="fw-bold p-1">Payslip for the month of <?= $month_name." ".$year; ?></h6> <span class="fw-normal"><span class="fw-normal">Pay Period <?= $start_date." to ".$end_date; ?></span>
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
                                                <td>Designation</td>
                                                <td><?= $row['designation_name']; ?></td>
                                            </tr>
                                            
                                            <tr>
                                                <td>No of Working Days</td>
                                                <td><?= $total_days; ?></td>
                                                <td>Pan No</td>
                                                <td><?= !empty($row['pan_card_no']) ? $row['pan_card_no'] : "NA" ?></td>
                                            </tr>
                                            <tr>
                                                <td>Paid Days</td>
                                                <td><?=$paidday; ?></td>
                                                <td>Bank Branch</td>
                                                <td><?= $row['branch_name']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Lop</td>
                                                <td><?= $loss_of_day; ?></td>
                                                <td>Account No</td>
                                                <td><?= $row['account_number']; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                </div class="row">
                                    <table class="mt-4 table table-bordered text-nowrap">
                                        <thead class="customtable">
                                            <tr>
                                                <th scope="col">Salary Structure</th>
                                                <th scope="col">Earned (<?= $rupees; ?>)</th>
                                                <th scope="col">Deductions</th>
                                                <th scope="col">Amount (<?= $rupees; ?>)</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <?php
                                                $earningKeys = array_keys($result['earnings']);
                                                $deductionKeys = array_keys($result['deductions']);
                                                $maxRows = max(count($earningKeys), count($deductionKeys));
                                                for ($i = 0; $i < $maxRows; $i++) {
                                                    echo "<tr>";
                                                    if (isset($earningKeys[$i])) {
                                                        echo "<td scope='row'>{$earningKeys[$i]}</td>";
                                                        echo "<td>{$result['earnings'][$earningKeys[$i]]}</td>";
                                                    } else {
                                                        echo "<td></td><td></td>";
                                                    }
                                                    if (isset($deductionKeys[$i])) {
                                                        echo "<td scope='row'>{$deductionKeys[$i]}</td>";
                                                        echo "<td>{$result['deductions'][$deductionKeys[$i]]}</td>";
                                                    } else {
                                                        echo "<td></td><td></td>";
                                                    }
                                                    echo "</tr>";
                                                }
                                            ?>
                                            <tr>
                                                <th colspan="3">Net Pay</th>
                                                <th><?php echo $rupees." ".number_format($net_salary,2); ?></th>
                                            </tr>
                                            <?php
                                            /**
                                             * Converting Currency Numbers to words currency format
                                             */
                                                $number = $net_salary;
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

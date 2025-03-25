<?php
    include("include/connection.php");
    require_once('TCPDF-main/tcpdf.php');

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
                $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.''.$hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . 'Paise' : '';
        return ucfirst($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
    }

    $invId = $_REQUEST['id'];

    $invoiceSql = "SELECT invoice.*, client.client_name,client.client_short_name,client.client_address,client.client_gst_no,client.date AS client_date FROM invoice JOIN client ON invoice.client_id = client.client_id WHERE inv_id='$invId'";
    $invoiceResult = $conn->query($invoiceSql);
    $invoiceRow = $invoiceResult->fetch_assoc();

    $inv_ref_no = $invoiceRow['inv_ref_no'];
    $inv_date = date('d-m-Y',strtotime($invoiceRow['date']));
    $team_name = $invoiceRow['team_name'];
    $description = $invoiceRow['description'];
    $qty = $invoiceRow['qty'];
    $unit_price = $invoiceRow['unit_price'];
    $amount = $invoiceRow['amount'];
    $is_gst = $invoiceRow['is_gst'];
    $sgst_percent = $invoiceRow['sgst_percent'];
    $sgst_amount = $invoiceRow['sgst_amount'];
    $cgst_percent = $invoiceRow['cgst_percent'];
    $cgst_amount = $invoiceRow['cgst_amount'];
    $total_amount = $invoiceRow['total_amount'];
    $client_id = $invoiceRow['client_id'];
    $client_gst_no = $invoiceRow['client_gst_no'];
    $client_name = $invoiceRow['client_name'];
    $client_short_name = $invoiceRow['client_short_name'];
    $client_address = $invoiceRow['client_address'];
    $client_date = $invoiceRow['client_date'];

    $amountInWords = getIndianCurrency($invoiceRow['total_amount']);

    class PDF extends TCPDF
    {
        public function Header(){
            $imageFile = K_PATH_IMAGES.'fullLogo.jpg';
            $this->Image($imageFile, 14, 10, 65, '', 'jpg', '', '', false, 300, '', false, false, 0, false, false, false);
            $this->Ln(5);
            $this->setFont('helvetica','B',20);
            $this->SetTextColor(255, 139, 0);
            // 189 is total width of A4 page
            $this->cell(180, 8, 'INVOICE', 0, 1, 'R');
            $this->Ln(1);
            $this->setFont('helvetica','',12);
            $this->SetTextColor(0, 0, 0);
            $this->cell(189, 0, '1278, Kamban Nagar, Rajagopalapuram, Pudukkottai 622003.', 0, 1, 'L');
        }
    }

    // create new PDF document
    $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('G Tech Solution');
    $pdf->SetTitle('Invoice');
    $pdf->SetSubject('');
    $pdf->SetKeywords('');

    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
    $pdf->setFooterData(array(0,64,0), array(0,64,128));

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    // ---------------------------------------------------------

    // set default font subsetting mode
    $pdf->setFontSubsetting(true);

    // Set font
    // dejavusans is a UTF-8 Unicode font, if you only need to
    // print standard ASCII chars, you can use core fonts like
    // helvetica or times to reduce file size.
    $pdf->SetFont('dejavusans', '', 14, '', true);

    // Add a page
    // This method has several options, check the source code documentation for more information.
    $pdf->AddPage();

    // define style for border
    $border_style = array('all' => array('width' => 0, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'phase' => 0));

    $pdf->setFont('helvetica','B',12);
    $pdf->SetDrawColor(68, 114, 196);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(68, 114, 196);
    $pdf->Rect(15, 30, 180, 8, 'DF', $border_style);
    $pdf->cell(10, 14, 'INV REF NO:', 0, 0, '');
    $pdf->setFont('helvetica','',12);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->cell(100, 14, "$inv_ref_no", 0, 0, 'C');

    $pdf->setFont('helvetica','B',12);
    $pdf->SetTextColor(68, 114, 196);
    $pdf->cell(46, 14, 'Date:', 0, 0, 'R');
    $pdf->setFont('helvetica','',12);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->cell(2, 14, "$inv_date", 0, 1, '');

    $pdf->setFont('helvetica','B',13);
    $pdf->SetTextColor(68, 114, 196);
    $pdf->cell(0, 14, "CLIENT GST No: $client_gst_no", 0, 1, 'L', 0, '', false);

    $pdf->setFont('helvetica','',12);
    $pdf->SetTextColor(68, 114, 196);
    $pdf->cell(15, 5, "To", 0, 1, '', 0, '', false);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->cell(0, 0, "$client_name", 0, 1, '', 0, '', false);
    $pdf->cell(0, 0, "$client_address", 0, 1, '', 0, '', false);

    $pdf->setFont('helvetica','',13);
    $pdf->ln(5);

if($is_gst){
// Set some content to print
$tbl = <<<EOD
    <table style="border: 1px inset #4472c4;">
        <tr style="background-color:#4472c4; color:white;">
            <td width="30%" style="text-align: center; vertical-align: middle; font-weight: bold; border: 1px inset #000;">Description</td>
            <td width="30%" style="text-align: center; vertical-align: middle; font-weight: bold; border: 1px inset #000;">Qty</td>
            <td width="20%" style="text-align: center; vertical-align: middle; font-weight: bold; border: 1px inset #000;">Unit Price</td>
            <td width="20%" style="text-align: center; vertical-align: middle; font-weight: bold; border: 1px inset #000;">Amount</td>
        </tr>
        <tr>
            <td width="30%" style="text-align: center; vertical-align: middle; border: 1px inset #4472c4;">$description</td>
            <td width="30%" style="text-align: center; vertical-align: middle; border: 1px inset #4472c4;">$qty</td>
            <td width="20%" style="text-align: center; vertical-align: middle; border: 1px inset #4472c4;">Rs.$unit_price</td>
            <td width="20%" style="text-align: center; vertical-align: middle; border: 1px inset #4472c4;">Rs.$amount</td>
        </tr>
        <tr>
            <td width="30%" style="text-align: center; vertical-align: middle; border: 1px inset #4472c4;"></td>
            <td width="30%" style="text-align: center; vertical-align: middle; border: 1px inset #4472c4;">SGST $sgst_percent%</td>
            <td width="20%" style="text-align: center; vertical-align: middle; border: 1px inset #4472c4;"></td>
            <td width="20%" style="text-align: center; vertical-align: middle; border: 1px inset #4472c4;">Rs.$sgst_amount</td>
        </tr>
        <tr>
            <td width="30%" style="text-align: center; vertical-align: middle; border: 1px inset #4472c4;"></td>
            <td width="30%" style="text-align: center; vertical-align: middle; border: 1px inset #4472c4;">CGST $cgst_percent%</td>
            <td width="20%" style="text-align: center; vertical-align: middle; border: 1px inset #4472c4;"></td>
            <td width="20%" style="text-align: center; vertical-align: middle; border: 1px inset #4472c4;">Rs.$cgst_amount</td>
        </tr>
        <tr>
            <td width="30%" style="text-align: center; vertical-align: middle; border: 1px inset #4472c4;"></td>
            <td width="30%" style="text-align: center; vertical-align: middle; border: 1px inset #4472c4;"></td>
            <td width="20%" style="text-align: center; vertical-align: middle; border: 1px inset #4472c4;">GRAND TOTAL</td>
            <td width="20%" style="text-align: center; vertical-align: middle; border: 1px inset #4472c4;">Rs.$total_amount</td>
        </tr>
    </table>
EOD;
} else{
// Set some content to print
$tbl = <<<EOD
    <table style="border: 1px inset #4472c4;">
        <tr style="background-color:#4472c4; color:white;">
            <td width="30%" style="text-align: center; vertical-align: middle; font-weight: bold; border: 1px inset #000;">Description</td>
            <td width="30%" style="text-align: center; vertical-align: middle; font-weight: bold; border: 1px inset #000;">Qty</td>
            <td width="20%" style="text-align: center; vertical-align: middle; font-weight: bold; border: 1px inset #000;">Unit Price</td>
            <td width="20%" style="text-align: center; vertical-align: middle; font-weight: bold; border: 1px inset #000;">Amount</td>
        </tr>
        <tr>
            <td width="30%" style="text-align: center; vertical-align: middle; border: 1px inset #4472c4;">$description</td>
            <td width="30%" style="text-align: center; vertical-align: middle; border: 1px inset #4472c4;">$qty</td>
            <td width="20%" style="text-align: center; vertical-align: middle; border: 1px inset #4472c4;">Rs.$unit_price</td>
            <td width="20%" style="text-align: center; vertical-align: middle; border: 1px inset #4472c4;">Rs.$amount</td>
        </tr>
        <tr>
            <td width="30%" style="text-align: center; vertical-align: middle; border: 1px inset #4472c4;"></td>
            <td width="30%" style="text-align: center; vertical-align: middle; border: 1px inset #4472c4;"></td>
            <td width="20%" style="text-align: center; vertical-align: middle; border: 1px inset #4472c4;">GRAND TOTAL</td>
            <td width="20%" style="text-align: center; vertical-align: middle; border: 1px inset #4472c4;">Rs.$total_amount</td>
        </tr>
    </table>
EOD;
}

$pdf->writeHTMLCell(0, 0, '', '', $tbl, 0, 1, 0, true, '', true);

$pdf->setFont('helvetica','',12);
$pdf->ln(5);

$tbl1 = <<<EOD
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="55%" style="vertical-align: middle; ">Amount (in words): $amountInWords</td>
            <td width="5%" style="text-align: center; vertical-align: middle; "></td>
            <td width="40%" style=" vertical-align: middle; "><span style="font-weight: bold"> GST: 33AAUFG5988K1ZH </span> <br> Account Name: G Tech Solutions <br> Bank Name: Axis Bank Ltd <br> Account Number: 919020087864680 <br> IFSC Code: UTIB0000602</td>
        </tr>
    </table>
EOD;

$pdf->writeHTMLCell(0, 0, '', '', $tbl1, 0, 1, 0, true, '', true);

    $pdf->ln(5);
    $pdf->setFont('helvetica','',12);
    $pdf->SetTextColor(68, 114, 196);
    $pdf->cell(0, 10, "Thanks & regards", 0, 1, '', 0, '', false);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->cell(0, 5, "Narein Muruganandam", 0, 1, '', 0, '', false);
    $pdf->cell(0, 0, "P: 9842301477", 0, 1, '', 0, '', false);

    $pdf->SetTextColor(255, 139, 0);
    $pdf->cell(0, 20, "Thank you for your business", 0, 1, 'C', 0, '', false);

    $pdf->Output('invoice.pdf', 'I');
?>
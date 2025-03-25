<?php

include('include/connection.php');
session_start();

    $image= $_FILES['image']['name'];
    // $file_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $getimage);
    // $ext = pathinfo($getimage, PATHINFO_EXTENSION);
    // $image = $file_name . time() . "." . $ext;
    if($image != ""){
        $file_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $image);
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $getimage = $file_name . time() . "." . $ext;

        $upload = "assets/img/employee_img/";
        $temp_name = $_FILES['image']['tmp_name'];
        $images = $upload.$getimage;
        move_uploaded_file($temp_name,$images);
    }else{
        $hidd_image = $_POST['hidd_image'];
        $images =$hidd_image;
    }
    
	$aadhar= $_FILES['aadhar']['name'];
    if($aadhar !=""){
        $aadhar_file_name =preg_replace('/\\.[^.\\s]{3,4}$/', '', $aadhar);
        $aadharext = pathinfo($aadhar, PATHINFO_EXTENSION);
        $getaadhar = $aadhar_file_name . time() . "." . $aadharext;

        $upload1 = "assets/img/employee_documents/aadhar_card/";
        $temp_aadhar = $_FILES['aadhar']['tmp_name'];
        $aadhar1 = $upload1.$getaadhar;
        move_uploaded_file($temp_aadhar,$aadhar1);
    }else{
        $hidd_aadhar = $_POST['hidd_aadhar'];
        $aadhar1= $hidd_aadhar;
    }
    
    $pan= $_FILES['pan']['name'];
    if($pan !=""){
        $pan_file_name =preg_replace('/\\.[^.\\s]{3,4}$/', '', $pan);
        $panext = pathinfo($pan, PATHINFO_EXTENSION);
        $getpan = $pan_file_name . time() . "." . $panext;

        $upload2 = "assets/img/employee_documents/pan_card/";
        $temp_pan = $_FILES['pan']['tmp_name'];
        $pan1 = $upload2.$getpan;
        move_uploaded_file($temp_pan,$pan1);
    }else{
        $hidd_pan =$_POST['hidd_pan'];
        $pan1=$hidd_pan;
    }
    

    $experience= $_FILES['experience']['name'];
    if($experience !=""){
        $experience_file_name =preg_replace('/\\.[^.\\s]{3,4}$/', '', $experience);
        $experienceext = pathinfo($experience, PATHINFO_EXTENSION);
        $getexperience = $experience_file_name . time() . "." . $experienceext;

        $upload3 = "assets/img/employee_documents/experience/";
        $temp_experience = $_FILES['experience']['tmp_name'];
        $experience1 = $upload3.$getexperience;
        move_uploaded_file($temp_experience,$experience1);
    }else{
        $hidd_exp =$_POST['hidd_experience'];
        $experience1=$hidd_exp;
    }
    

    $relieving= $_FILES['relieving']['name'];
    if($relieving !=""){
        $relieving_file_name =preg_replace('/\\.[^.\\s]{3,4}$/', '', $relieving);
        $relievingext = pathinfo($relieving, PATHINFO_EXTENSION);
        $getrelieving = $relieving_file_name . time() . "." . $relievingext;

        $upload4 = "assets/img/employee_documents/relieving/";
        $temp_relieving = $_FILES['relieving']['tmp_name'];
        $relieving1 = $upload4.$getrelieving;
        move_uploaded_file($temp_relieving,$relieving1);
    }else{
        $hidd_rel=$_POST['hidd_reliving'];
        $relieving1=$hidd_rel;
    }

    
    $payslip= $_FILES['payslip']['name'];
    if($payslip !=""){
        $payslip_file_name =preg_replace('/\\.[^.\\s]{3,4}$/', '', $payslip);
        $payslipext = pathinfo($payslip, PATHINFO_EXTENSION);
        $getpayslip = $payslip_file_name . time() . "." . $payslipext;

        $upload5 = "assets/img/employee_documents/payslip/";
        $temp_payslip = $_FILES['payslip']['tmp_name'];
        $payslip1 = $upload5.$getpayslip;
        move_uploaded_file($temp_payslip,$payslip1);
    }else{
        $hidd_pay =$_POST['hidd_payslip'];
        $payslip1=$hidd_pay;
    }
    

    $degree= $_FILES['degree']['name'];
    if($degree !=""){
        $degree_file_name =preg_replace('/\\.[^.\\s]{3,4}$/', '', $degree);
        $degreeext = pathinfo($degree, PATHINFO_EXTENSION);
        $getdegree = $degree_file_name . time() . "." . $degreeext;

        $upload6 = "assets/img/employee_documents/degree/";
        $temp_degree = $_FILES['degree']['tmp_name'];
        $degree1 = $upload6.$getdegree;
        move_uploaded_file($temp_degree,$degree1);
    }else{
        $hidd_degree =$_POST['hidd_degree'];
        $degree1=$hidd_degree;
    }

    $resume= $_FILES['resume']['name'];
    if($resume !=""){
        $resume_file_name =preg_replace('/\\.[^.\\s]{3,4}$/', '', $resume);
        $resumeext = pathinfo($resume, PATHINFO_EXTENSION);
        $getresume = $resume_file_name . time() . "." . $resumeext;

        $upload9 = "assets/img/employee_documents/resume/";
        $temp_resume = $_FILES['resume']['tmp_name'];
        $resume1 = $upload9.$getresume;
        move_uploaded_file($temp_resume,$resume1);
    }else{
        $hidd_res= $_POST['hidd_resume'];
        $resume1=$hidd_res;
    }
    

if(isset($_POST['submit'])){
    // personal details
    $id = $_POST['id'];
	$fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $pphone=$_POST['pphone'];
    $pemail=$_POST['pemail'];
    $gender=$_POST['gender'];
    $birthday=$_POST['birthday'];
    $marital=$_POST['marital'];
	$blood=$_POST['blood'];
	$disability=$_POST['disability'];
	$disability_id=$_POST['disability_id'];
    $aadharcardno=$_POST['aadharcardno'];
    $pancard=$_POST['pancardno'];
	$caddress=$_POST['caddress'];
	$paddress=$_POST['paddress'];
    // emergency
    $rname=$_POST['rname'];
	$relationship=$_POST['relationship'];
    $contactnumber=$_POST['contactnumber'];

    // official detail
    $company=$_POST['company'];
    $employee_id=$_POST['emp_id_no'];
    $joinday=$_POST['joinday'];
    $oemail=$_POST['oemail'];
	$department=$_POST['department'];
	$designation=$_POST['designation'];
    $roll=$_POST['roll'];
    if($roll == "Employee"){
        $emp_control = 1;
    }elseif($roll == "Team Leader"){
        $emp_control = 2;
    }elseif($roll == "Project Manager"){
        $emp_control = 3;
    }elseif($roll == "Human Resources"){
        $emp_control = 4;
    }else{
        $emp_control = 5;
    }
    $report1=$_POST['report'];
    $report = implode(",",$report1);
    $employeetype=$_POST['employeetype'];
    $salary=$_POST['salary'];


    // assets details

    $systemtype=$_POST['systemtype'] ?? '';
	$sparegadgets1=$_POST['sparegadgets'] ?? '';
    if($sparegadgets1){
        $sparegadgets = implode(" ",$sparegadgets1);
    }else{
        $sparegadgets = '';
    }
    $systemid=$_POST['systemid'];

    // bankdetails
    $bank_name = $_POST['bank_name'];
    $account_number = $_POST['account_number'];
    $ifsc_code = $_POST['ifsc_code'];
    $branch_name = $_POST['branch_name'];
    $account_type = $_POST['account_type'];


    $sql = "SELECT * FROM employee WHERE oemail = '$oemail'";
    $result=$conn->query($sql);
    
    if($id > 0 ){
        $updatesql = "UPDATE employee SET emp_id='$employee_id', fname='$fname', lname='$lname', pemail='$pemail', oemail='$oemail', pphno='$pphone', paddress='$paddress', caddress='$caddress', dob='$birthday', doj='$joinday', blood_group='$blood', aadharcardno='$aadharcardno', designation='$designation', department='$department', basic_salary='$salary', emp_photo='$images', aadhar='$aadhar1', pan='$pan1', experience='$experience1', reliving='$relieving1', payslip='$payslip1', degreecertificate='$degree1', gender='$gender', marital='$marital', emp_roll='$roll', emp_report_to='$report', emp_type='$employeetype', system_type='$systemtype', spare='$sparegadgets', system_id='$systemid', rname='$rname', relationship='$relationship', contactnumber='$contactnumber', company='$company', control='$emp_control', username='$oemail',password='$employee_id', resume='$resume1', pan_card_no='$pancard', disability='$disability', disability_id='$disability_id',bank_name='$bank_name', account_number='$account_number', ifsc_code='$ifsc_code', branch_name='$branch_name', account_type='$account_type' WHERE id=$id";
        $updateresult=$conn->query($updatesql);
        if($updateresult == TRUE){
            header('location:user-list.php?msg=Employee Updated!&type=warning');
        }
    }else{
        if($result->num_rows < 0){
		    $sql = "INSERT INTO employee (emp_id, fname, lname, pphno, pemail, gender, dob, marital, blood_group, aadharcardno, pan_card_no, caddress, paddress, rname, relationship, contactnumber, company, doj, oemail, department, designation, emp_roll, emp_report_to, emp_type, basic_salary, emp_photo, aadhar, pan, experience, reliving, payslip, resume, degreecertificate, system_type, spare, system_id, username, password, control, emp_status, disability, disability_id, bank_name, account_number,ifsc_code, branch_name, account_type)VALUES('$employee_id','$fname','$lname','$pphone','$pemail','$gender','$birthday','$marital','$blood','$aadharcardno','$pancard','$caddress','$paddress','$rname','$relationship','$contactnumber','$company','$joinday','$oemail','$department','$designation','$roll','$report','$employeetype','$salary','$images','$aadhar1','$pan1','$experience1','$relieving1','$payslip1','$resume1','$degree1','$systemtype','$sparegadgets','$systemid','$oemail','$employee_id','$emp_control','Active','$disability','$disability_id','$bank_name','$account_number','$ifsc_code','$branch_name','$account_type')";
            // echo $sql;exit();
		    $result=$conn->query($sql);
            if($result == TRUE){
                header('location:user-list.php?msg=Employee Added!&type=success');
            }
        }else{
            header('location:user-list.php?msg=Office Email already exists!&type=danger');
        }
    }
}
?>
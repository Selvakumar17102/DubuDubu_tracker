<?php
    session_start();

    include('include/connection.php');
    $id = $_SESSION['id'];

    if(isset($_POST['updatepassword'])){
        $oldpass = $_POST['oldpassword'];
        $newpass = $_POST['newpass'];
        $conpass = $_POST['conpass'];

        if($newpass == $conpass){
            $oldpasscheckSql = "SELECT * FROM employee WHERE id = '$id' AND password = '$oldpass'";
            if($conn->query($oldpasscheckSql) == TRUE){
                $updateSql = "UPDATE employee SET password = '$newpass' WHERE id = '$id'";
                if($conn->query($updateSql) == TRUE){
                    echo "<script type ='text/JavaScript'>";
                    echo "alert('Successfully Changed')";
                    echo "</script>";
                    header('location: dashboard.php');
                }
            }else{
                echo "<script type ='text/JavaScript'>";
                echo "alert('Old Password !')";
                echo "</script>";
            }
        }else{
            echo "<script type ='text/JavaScript'>";
            echo "alert('New Password And Conform Password Mismatch !')";
            echo "</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="ekka - Admin Dashboard HTML Template.">

		<title>DUBU DUBU - Password Change page</title>
		
		<!-- GOOGLE FONTS -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

		<link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />
		
		<!-- ekka CSS -->
		<link id="ekka-css" rel="stylesheet" href="assets/css/ekka.css" />
		
		<!-- FAVICON -->
		<link href="assets/img/favicon.png" rel="shortcut icon" />
	</head>
	<style>
		.sign-inup .ec-brand a img {
    		width: 225px;
    		max-width: 1000px;
		}
	</style>
	
	<body class="sign-inup" id="body">
		<div class="container d-flex align-items-center justify-content-center form-height-login pt-24px pb-24px">
			<div class="row justify-content-center">
				<div class="col-lg-6 col-md-10">
					<div class="card">
						<div class="card-header" style="background-image: radial-gradient(white, white, blue);">
							<div class="ec-brand">
								<a href="index.php" title="Dubu Dubu">
									<img class="ec-brand-icon" src="assets/img/logo/signin.png" alt="" />
								</a>
							</div>
						</div>
						<div class="card-body p-5">
						<h2 class="text-dark mb-5" style="font-family: math;text-shadow: 2px 2px 4px #000000;">Change Password</h2>

							<div class="validform mb-3"></div>

							<div>
								<form method="post">
									<div class="row">
										<div class="form-group col-md-12 mb-4">
											<input type="password" class="form-control" name="oldpassword" id="oldpassword" placeholder="Old Password">
										</div>
									
										<div class="form-group col-md-12 ">
											<input type="password" class="form-control" name="newpass" id="newpass" placeholder="New Password">
											<i class="far fa-eye" id="togglePassword" style="margin-left: -30px; cursor: pointer;"></i>
										</div>

                                        <div class="form-group col-md-12 ">
											<input type="password" class="form-control" name="conpass" id="conpass" placeholder="Conform Password">
											<i class="far fa-eye" id="togglePassword" style="margin-left: -30px; cursor: pointer;"></i>
										</div>
									
										<div class="col-md-12">
											<div class="d-flex my-2 justify-content-between">
												<div class="d-inline-block mr-3">
													<!-- <div class="control control-checkbox">Remember me
														<input type="checkbox" />
														<div class="control-indicator"></div>
													</div> -->
												</div>
											
											<!-- <p><a class="text-blue" href="#">Forgot Password?</a></p> -->
											</div>
										
											<button type="submit" name="updatepassword" id="updatepassword" class="btn btn-primary btn-block mb-4">Submit</button>
										
										<p class="sign-upp">Don't have Change password ?
											<a class="text-blue" href="dashboard.php">Home Page</a>
										</p>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	
		<!-- Javascript -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

		<script src="assets/plugins/jquery/jquery-3.5.1.min.js"></script>
		<script src="assets/js/bootstrap.bundle.min.js"></script>
		<script src="assets/plugins/jquery-zoom/jquery.zoom.min.js"></script>
		<script src="assets/plugins/slick/slick.min.js"></script>
	
		<!-- ekka Custom -->	
		<script src="assets/js/ekka.js"></script>
		<script src="assets/js/manual.js"></script>

	</body>
</html>
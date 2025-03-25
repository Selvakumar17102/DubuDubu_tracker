<?php
    session_start();

    if(isset($_SESSION['id'])){
        header('Location: profile_dashboard.php');
        // header('Location: dashboard.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="ekka - Admin Dashboard HTML Template.">

		<title>DUBU DUBU - Sign-in page</title>
		
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
    		width: 400px;
    		max-width: 1200px;
		}
	</style>
	
	<body class="sign-inup" id="body">
		<div class="container d-flex align-items-center justify-content-center form-height-login pt-24px pb-24px">
			<div class="row justify-content-center">
				<div class="col-lg-9 col-md-10">
					<div class="card">
						<div class="card-header">
							<div class="ec-brand">
								<a href="index.php" title="Dubu Dubu">
									<img class="ec-brand-icon" src="assets/img/logo/signin.png" alt="" />
								</a>
							</div>
						</div>
						<div class="card-body p-5">
							<!-- <h3 class="text-dark mb-5" style="font-family: math;">EMPLOYEE PORTAL</h3> -->
							<h2 class="text-dark mb-5" style="font-family: math;">LOG IN</h2>

							<div class="validform mb-3"></div>

							<div>
								<form method="post">
									<div class="row">
										<div class="form-group col-md-12 mb-4">
											<input type="name" class="form-control" name="name" id="name" placeholder="Username">
										</div>
									
										<div class="form-group col-md-12 ">
											<input type="password" class="form-control" name="pass" id="pass" placeholder="Password">
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
										
											<button type="button" name="signin" id="signin" class="btn btn-primary btn-block mb-4">Sign In</button>
										
										<!-- <p class="sign-upp">Don't have an account yet ?
											<a class="text-blue" href="sign-up.php">Sign Up</a>
										</p> -->
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
<!-- <script>
	$('#signin').click(function(){
    	alert("jhj");
    	var name = document.getElementById('name');
    	var pass = document.getElementById('pass');

    	if(name.value == ''){
    	    name.style.border = '1px solid red';
    	}
    	else{
    	    name.style.border = '1px solid #bfc9d4';
    	    if(pass.value == ''){
    	        pass.style.border = '1px solid red';
    	        return false;
    	    }
    	}

    	if(pass.value != ''){
    	    pass.style.border = '1px solid #bfc9d4';
		
    	    $.ajax({
    	        type : 'POST',
    	        url : 'user-sign-in.php',
    	        data : {
    	            name : name.value,
    	            pass : pass.value,
    	        },
    	        success : function(data){
    	            alert(data);
    	            if(data == 'Invalid username or Password'){
    	                $('.validform').html('<span style="color:red; text-align:center">Invalid Username or Password <span>');
    	                name.value = '';
    	                pass.value = '';
    	            }
    	            else{
    	                var employee = JSON.parse(data);
    	                var emp_id = employee.emp_id;
    	                var emp_token = employee.emp_token;
    	                alert(emp_id);
    	                alert(emp_token);
    	                $.ajax({
    	                    type: "POST",
    	                    url: "ajax/sessionSet.php",
    	                    data:{
    	                        login : emp_id,
    	                        token : emp_token
    	                    },
    	                    success: function(data){
    	                        // alert(data);
    	                        if(data == 'true'){
    	                            localStorage.setItem('id', emp_id)
    	                            localStorage.setItem('token', emp_token)
    	                            localStorage.removeItem('msg');
    	                            location.replace('dashboard.php');
    	                        }
    	                        else{
    	                            location.replace('./');
    	                        }
    	                    }
    	                });
    	            }
    	        }
    	    });
    	}
	});
</script> -->
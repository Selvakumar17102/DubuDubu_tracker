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

		<title>DD - Sign-in page</title>
		
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
	
	    body {
          background: #f8f9fa;
        }
        
        .card {
          border: none;
          border-radius: 12px;
        }
        
        input.form-control {
          border-radius: 10px;
          padding: 10px 15px;
        }
        
        .btn-primary {
          border-radius: 10px;
          font-weight: bold;
          background-color: #007bff;
          border-color: #007bff;
        }

		.sign-inup .ec-brand a img {
    		width: 400px;
    		max-width: 1200px;
		}
		.bg-warning {
			background-color: #fede00 !important; /* Override the default */
		}
	</style>
	
	<body class="sign-inup" id="body">
		<div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
          <div class="row w-100 shadow rounded overflow-hidden" style="max-width: 1000px;">
            
            <!-- LEFT SIDE - LOGO -->
            <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center bg-warning">
              <img src="assets/img/logo/DDLOGO.png" alt="Office Logo" class="img-fluid p-4" style="max-height: 300px;">
            </div>
        
            <!-- RIGHT SIDE - LOGIN FORM -->
            <div class="col-md-6 bg-white p-5">
              <div class="text-center">
                <img src="assets/img/logo/DDTechnologiesLogo.png" alt="Signin Logo" width="300" height="100">
                <h2 class="text-dark" style="font-family: math;">LOG IN</h2>
              </div>
              
              <div class="validform mb-3"></div>
              <form method="post">
                <div class="form-group mb-3">
                  <input type="name" class="form-control" name="name" id="name" placeholder="Username">
                </div>
                <div class="form-group mb-4 position-relative">
                  <input type="password" class="form-control" name="pass" id="pass" placeholder="Password">
                  <i class="far fa-eye position-absolute" id="togglePassword" style="top: 12px; right: 10px; cursor: pointer;"></i>
                </div>
        
                <button type="button" name="signin" id="signin" class="btn bg-warning w-100 mb-3">Sign In</button>
              </form>
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
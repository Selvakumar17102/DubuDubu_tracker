<?php

include("include/connection.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="ekka - Admin Dashboard HTML Template.">

  <title>ekka - Admin Dashboard HTML Template.</title>

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

<body class="sign-inup" id="body">
  <div class="container d-flex align-items-center justify-content-center form-height pt-24px pb-24px">
    <div class="row justify-content-center">
      <div class="col-lg-4 col-md-10">
        <div class="card">
          <div class="card-header bg-primary">
            <div class="ec-brand">
              <a href="index.php" title="ekka">
                <img class="ec-brand-icon" src="assets/img/logo/logo-login.png" alt="" />
              </a>
            </div>
          </div>
          <div class="card-body p-5">
            <h4 class="text-dark mb-5">Sign Up</h4>

            <form method="post">
              <div class="row">
                <div class="form-group col-md-12 mb-4">
                  <input type="text" class="form-control" id="username" name="username" placeholder="Name">
                </div>

                <div class="form-group col-md-12 mb-4">
                  <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                </div>

                <div class="form-group col-md-12 ">
                  <input type="password" class="form-control" id="pass" name="pass" placeholder="Password">
                </div>

                <div class="form-group col-md-12 ">
                  <input type="password" class="form-control" id="cpass" name="cpass" placeholder="Confirm Password">
                </div>

                <div class="col-md-12">
                  <div class="d-inline-block mr-3">
                    <div class="control control-checkbox">
                      <input type="checkbox" />
                      <div class="control-indicator"></div>
                      I Agree the terms and conditions
                    </div>
                  </div>

                  <button type="button" id="signup" name="signup" class="btn btn-primary btn-block mb-4">Sign Up</button>

                  <p class="sign-upp">Already have an account?
                    <a class="text-blue" href="sign-in.php">Sign in</a>
                  </p>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Javascript -->
  <script src="assets/plugins/jquery/jquery-3.5.1.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/plugins/jquery-zoom/jquery.zoom.min.js"></script>
	<script src="assets/plugins/slick/slick.min.js"></script>

  <!-- ekka Custom -->
  <script src="assets/js/ekka.js"></script>
</body>

</html>

<script>
  $('#signup').click(function(){
    // alert("hkjhk");
    var name = document.getElementById('username');
    var email = document.getElementById('email').value;
    var pass = document.getElementById('pass').value;
    var cpass = document.getElementById('cpass').value;
    // alert(cpass);

    if(name.value == ''){
      name.style.border = '1px solid red'
      return false
    }
    // if(email == ''){
    //   email.style.border = '1px solid red';
    //   return false;
    // }
    // if(pass == ''){
    //   pass.style.border = '1px solid red';
    //   return false;
    // }
    // if(pass == ''){
    //   name.style.border = '1px solid red';
    //   return false;
    // }
    // $.ajax({
    //   type: "POST";
    //   url : "user-sign-up.php",
    //   data : {
    //     name : name,
    //     email : email,
    //     pass : pass,
    //     cpass : cpass,
    //   },
    //   success : function(data){
    //     alert(data);
    //   }
    // });
  });
</script>
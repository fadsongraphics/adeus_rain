<!DOCTYPE html>
<html>
<head>
	<title>ADEUS</title>
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/style.css">
	<link rel="stylesheet" type="text/css" href="assets/login.css">
	
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>

<div class="login-nav">
	<a href="dashboard.php"><div class="login-logo temp-img">LOGO</div></a>
	
</div>


<div class="login-width">
	
	<div class="row">
		<div class="col-lg-6">
			
		    <form class="form-signin fade-class">
			  <h3>Register</h3>
			  <div class="dontb">Already have an account? <a href="login.php" style="color: #162d65;font-weight: bolder;font-family: sans-serif;">Login</a></div>

			  <div class="error"></div>


			  <div class="form-floating">
			      <input type="text"  id="name" class="form-control" placeholder="name@example.com" required autofocus>
			      <label for="floatingInput">Name</label>
			    </div>

			    <div class="form-floating" style="margin-top: 15px;">
			      <input type="email"  id="email" class="form-control" placeholder="name@example.com" required autofocus>
			      <label for="floatingInput">Email address</label>
			    </div>

			    <div class="form-floating" style="margin-top: 15px;">
			      <input type="password" class="form-control" id="password" placeholder="Password" required>
			      <label for="floatingPassword">Password</label>
			    </div>


			  <button class="btn btn-sm btn-light" type="submit"><i class="mdi mdi-lock"></i> Log in</button>
			  
			  <br>
			  <br>
			  
			  <div class="dontb" style="text-align: center;font-size: 12px !important;font-family: sans-serif;">Forgot Your Password? <a href="forgot-password" style="color: #162d65;font-weight: bolder;font-family: sans-serif;font-size: 12px !important;">Reset</a></div>

			  <br>
			  <a href="#">
			  <div class="google-sign">
			  	<img src="assets/images/google-logo.png" width="20px" style="margin-right: 10px">
			  	Sign In with Google
			  </div>
				</a>

			<br>
			<br>

			</form>

			<div class="clearfix"></div>



		</div>
		<div class="col-lg-6">
			<div class="login-image temp-img">
				LOGIN IMAGE
			</div>
		</div>
	</div>
</div>
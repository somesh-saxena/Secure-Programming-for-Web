<?php session_start();
#header("Content-Security-Policy-Report-Only: policy : default-src 'self'");

require_once('dbconnection.php');
include "csrf.php";

//Code for Registration
if(isset($_POST['signup']))
{
	if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  {
        echo "<script>alert('Incorrect verification code');</script>" ;
    }
		else {
	$fname=$_POST['fname'];
	if (!preg_match("/^([a-zA-Z]+([_ -]?[a-zA-Z])*){3,40}$/", $fname))
	{
	   echo "<script>alert('First Name is not in required format');</script>";
	 } else
	  {
	$lname=$_POST['lname'];
	if (!preg_match("/^([a-zA-Z]+([_ -]?[a-zA-Z])*){3,40}$/", $lname)){
	   echo "<script>alert('Last Name is not in required format');</script>";
	 }
	 else{

	$email=$_POST['email'];
	if (!preg_match("/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/", $email)){
   echo "<script>alert('Email is not in required format');</script>";
 } else{

	$password=$_POST['password'];
	if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $password)){
   echo "<script>alert('Password is not in required format');</script>";
 } else {

	$contact=$_POST['contact'];
	if (!preg_match("/^[0-9]{8,20}$/", $contact)){
   echo "<script>alert('Contact is not in required format');</script>";
 } else {

$hashed_password=password_hash($password,PASSWORD_BCRYPT);
$stmt = $conn->prepare("INSERT INTO users(fname,lname,email,password,contactno)VALUES (:fname,:lname,:email,:hashed_password,:contact)");
			$stmt->bindParam(':fname', $fname);
		  $stmt->bindParam(':lname', $lname);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':hashed_password', $hashed_password);
			$stmt->bindParam(':contact', $contact);
			$stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
#	$msg=mysqli_query($con,"insert into users(fname,lname,email,password,contactno) values('$fname','$lname','$email','$hashed_password','$contact')");
if($stmt)
{
	echo "<script>alert('Register successfully');</script>";
}
}
}
}
}
}
}
}

// Code for login
if(isset($_POST['login']))
{
	if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  {
        echo "<script>alert('Incorrect verification code');</script>" ;
    }
		else {
$password=$_POST['password'];
if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $password)){
 echo "<script>alert('Password is not in required format');</script>";
} else {

$useremail=$_POST['uemail'];
if (!preg_match("/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/", $useremail)){
 echo "<script>alert('Email is not in required format');</script>";
} else{

	$stmt = $conn->prepare("SELECT * FROM users WHERE email=:email");
				$stmt->bindParam(':email', $useremail);
				$stmt->execute();
	      $row = $stmt->fetch(PDO::FETCH_ASSOC);
if(password_verify($password,$row['password'])){
$extra="welcome.php";
$_SESSION['login']=$_POST['uemail'];
$_SESSION['id']=$row['id'];
$_SESSION['name']=$row['fname'];
$host=$_SERVER['HTTP_HOST'];
$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}
else
{
echo "<script>alert('Invalid username or password');</script>";
$extra="index.php";
$host  = $_SERVER['HTTP_HOST'];
$uri  = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
//header("location:http://$host$uri/$extra");
exit();
}
}
}
}
}

//Code for Forgot Password

if(isset($_POST['send']))
{
	if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  {
        echo "<script>alert('Incorrect verification code');</script>" ;
    }
		else {
$femail=$_POST['femail'];
if (!preg_match("/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/", $femail)){
 echo "<script>alert('Email is not in required format');</script>";
} else{
	$stmt = $conn->prepare("SELECT * FROM users WHERE email=:email");
				$stmt->bindParam(':email', $femail);
				$stmt->execute();
				$row = $stmt->fetch(PDO::FETCH_ASSOC);

if($row>0)
{
$email = $row['email'];
$subject = "Information about your password";
$password=$row['password'];
$message = "Your password is ".$password;
mail($email, $subject, $message, "From: $email");
echo  "<script>alert('Your Password has been sent Successfully');</script>";
}
else
{
echo "<script>alert('Email not register with us');</script>";
}
}
}
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Login System</title>
<link href="css/style.css" rel='stylesheet' type='text/css' />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Elegent Tab Forms,Login Forms,Sign up Forms,Registration Forms,News latter Forms,Elements"./>
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
</script>
<script src="js/jquery.min.js"></script>
<script src="js/easyResponsiveTabs.js" type="text/javascript"></script>
				<script type="text/javascript">
					$(document).ready(function () {
						$('#horizontalTab').easyResponsiveTabs({
							type: 'default',
							width: 'auto',
							fit: true
						});
					});
				   </script>
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,400,600,700,200italic,300italic,400italic,600italic|Lora:400,700,400italic,700italic|Raleway:400,500,300,600,700,200,100' rel='stylesheet' type='text/css'>
</head>
<body>
<div class="main">
		<h1>GoSurvey</h1>
	 <div class="sap_tabs">
			<div id="horizontalTab" style="display: block; width: 100%; margin: 0px;">
			  <ul class="resp-tabs-list">
			  	  <li class="resp-tab-item" aria-controls="tab_item-0" role="tab"><div class="top-img"><img src="images/top-note.png" alt=""/></div><span>Register</span>

				</li>
				  <li class="resp-tab-item" aria-controls="tab_item-1" role="tab"><div class="top-img"><img src="images/top-lock.png" alt=""/></div><span>Login</span></li>
				  <li class="resp-tab-item lost" aria-controls="tab_item-2" role="tab"><div class="top-img"><img src="images/top-key.png" alt=""/></div><span>Forgot Password</span></li>
				  <div class="clear"></div>
			  </ul>

			<div class="resp-tabs-container">
					<div class="tab-1 resp-tab-content" aria-labelledby="tab_item-0">
					<div class="facts">

						<div class="register">
							<form name="registration" method="post" action="" enctype="multipart/form-data">
								<p>First Name </p>
								<input type="text" class="text" value=""  name="fname" required >
								<p>Last Name </p>
								<input type="text" class="text" value="" name="lname"  required >
								<p>Email Address </p>
								<input type="text" class="text" value="" name="email"  >
								<p>Password </p>
								<input type="password" value="" name="password" required>
										<p>Contact No. </p>
								<input type="text" value="" name="contact"  required>
								<div class="form-group">
									<label>Verification code : </label>
									<input type="text"  name="vercode" maxlength="5" autocomplete="off" required style="width: 150px; height: 25px;" />&nbsp;<img src="captcha.php">
									</div>
								<div class="sign-up">
									<input type="reset" value="Reset">
									<input type="submit" name="signup"  value="Sign Up" >
									<div class="clear"> </div>
								</div>
							</form>

						</div>
					</div>
				</div>
			 <div class="tab-2 resp-tab-content" aria-labelledby="tab_item-1">
					 	<div class="facts">
							 <div class="login">
							<div class="buttons">


							</div>
							<form name="login" action="" method="post">
								<input type="text" class="text" name="uemail" value="" placeholder="Enter your registered email"  ><a href="#" class=" icon email"></a>

								<input type="password" value="" name="password" placeholder="Enter valid password"><a href="#" class=" icon lock"></a>

								<div class="form-group">
									<label>Verification code : </label>
									<input type="text"  name="vercode" maxlength="5" autocomplete="off" required style="width: 150px; height: 25px;" />&nbsp;<img src="captcha.php">
								</div>
								<div class="p-container">

									<div class="submit two">
									<input type="submit" name="login" value="LOG IN" >
									</div>
									<div class="clear"> </div>
								</div>
								<p><a  href="admin.php" class="btn btn-primary btn-large"> Admin Login </a></p>

							</form>
					</div>
				</div>
			</div>
				 <div class="tab-2 resp-tab-content" aria-labelledby="tab_item-1">
					 	<div class="facts">
							 <div class="login">
							<div class="buttons">


							</div>
							<form name="login" action="" method="post">
								<input type="text" class="text" name="femail" value="" placeholder="Enter your registered email" required  ><a href="#" class=" icon email"></a>

								<div class="form-group">
									<label>Verification code : </label>
									<input type="text"  name="vercode" maxlength="5" autocomplete="off" required style="width: 150px; height: 25px;" />&nbsp;<img src="captcha.php">
									</div>
										<div class="submit three">
											<input type="submit" name="send" onClick="myFunction()" value="Send Email" >
										</div>
									</form>
									</div>
				         	</div>
				        </div>
				     </div>
		        </div>
	        </div>
	     </div>
</body>
</html>

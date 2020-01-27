<?php
session_start();
include("dbconnection.php");
if(isset($_POST['login']))
{
  if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  {
        echo "<script>alert('Incorrect verification code');</script>" ;
    }
		else {
  $adminusername=$_POST['username'];
  if (!preg_match("/^([a-zA-Z]+([_ -]?[a-zA-Z])*){3,40}$/", $adminusername))
	{
	   echo "<script>alert('Admin Name is not in required format');</script>";
	 } else
	  {
  $pass=md5($_POST['password']);

   $stmt = $conn->prepare("SELECT * FROM admin WHERE username =:i and password =:o");
   			$stmt->bindParam(':i', $adminusername);
   		  $stmt->bindParam(':o', $pass);
   			$stmt->execute();
         $row = $stmt->fetch(PDO::FETCH_ASSOC);

if($row)
{
$extra="manage-users.php";
$_SESSION['login']=$_POST['username'];
$_SESSION['id']=$row['id'];
echo "<script>window.location.href='".htmlspecialchars($extra)."'</script>";
exit();
}
else
{
$_SESSION['action1']="*Invalid username or password";
$extra="index.php";
echo "<script>window.location.href='".htmlspecialchars($extra)."'</script>";
exit();
}
}
}
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Admin | Login</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
  </head>

  <body>
	  <div id="login-page">
	  	<div class="container">


		      <form class="form-login" action="" method="post">
		        <h2 class="form-login-heading">sign in now</h2>
                  <p style="color:#F00; padding-top:20px;" align="center">
                    <?php echo htmlspecialchars($_SESSION['action1']);?><?php echo htmlspecialchars($_SESSION['action1']="");?></p>
		        <div class="login-wrap">
		            <input type="text" name="username" class="form-control" placeholder="User ID" autofocus>
		            <br>
		            <input type="password" name="password" class="form-control" placeholder="Password"><br >
                <div class="form-group">
                  <label>Verification code : </label>
                  <input type="text"  name="vercode" maxlength="5" autocomplete="off" required style="width: 150px; height: 25px;" />&nbsp;<img src="captcha.php">
                </div>
		            <input  name="login" class="btn btn-theme btn-block" type="submit">

		        </div>
		      </form>

	  	</div>
	  </div>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("assets/img/login-bg.jpg", {speed: 500});
    </script>


  </body>
</html>

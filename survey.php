<?PHP session_start();
require 'configure.php';
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{

	if (isset($_GET['h1'])) {
		$qID = $_GET['h1'];
	} else {
		$qID = 1;
	}

	$question = 'Question not set';
	$answerA = 'unchecked';
	$answerB = 'unchecked';
	$answerC = 'unchecked';

	$A = "";
	$B = "";
	$C = "";

	$database = "survey";

	$conn = new PDO("mysql:host=localhost;dbname=$database", $username, $password);

	if ($conn) {

    $stmt = $conn->prepare("SELECT ID, Question, OptionA, OptionB, OptionC FROM tblsurvey WHERE ID =:i");




		if ($stmt) {
			$stmt->bindparam(':i', $qID);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			if ($row) {
				$qID = $row['ID'];
				$question = $row['Question'];
				$A = $row['OptionA'];
				$B = $row['OptionB'];
				$C = $row['OptionC'];

			}
			else {
				print "Error - No rows";
			}
		}
		else {
			print "Error - DB ERROR";
		}

	}
	else {
		print "Error getting Survey";
	}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<title>Survey</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>Welcome </title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/heroic-features.css" rel="stylesheet">

</head>


<body>

	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container">
					<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
							</button>
							<a class="navbar-brand" href="#">Welcome !</a>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav">
									<li>
											<a href="#"><?php echo htmlspecialchars($_SESSION['name']);?></a>
									</li>
									<li>
											<a href="logout.php">Logout</a>
									</li>

							</ul>
					</div>
			</div>
	</nav>

<FORM NAME ="form1" METHOD ="GET" ACTION ="process.php">

<P>
<?PHP print $question; ?>
<P>
<INPUT TYPE = 'Radio' Name ='q'  value= 'A' <?PHP print $answerA; ?>><?PHP print $A; ?>
<P>
<INPUT TYPE = 'Radio' Name ='q'  value= 'B' <?PHP print $answerB; ?>><?PHP print $B; ?>
<P>
<INPUT TYPE = 'Radio' Name ='q'  value= 'C' <?PHP print $answerC; ?>><?PHP print $C; ?>
<P>

<INPUT TYPE = "Submit" Name = "Submit1"  VALUE = "Click here to vote">
<INPUT TYPE = "Hidden" Name = "h1"  VALUE = <?PHP print $qID; ?>>
</FORM>


<FORM NAME ="form2" METHOD ="GET" ACTION ="viewResults.php">

<INPUT TYPE = "Submit" Name = "Submit2"  VALUE = "View results">
<INPUT TYPE = "Hidden" Name = "h1"  VALUE = <?PHP print $qID; ?>>
</FORM>
<p><a  href="setSurvey.php" class="btn btn-primary btn-large"> Change Question </a></p>
</body>
</html>

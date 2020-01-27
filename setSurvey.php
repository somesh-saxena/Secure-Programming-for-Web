<?PHP session_start();
require 'configure.php';
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{
	$qID = '';
	$dropdown = '';
	$startSelect = "<SELECT NAME=drop1>";
	$endSelect = "</SELECT>";
	$wholeHTML = "";
	$getDropdownID = "";
	$hidTag = "";

	if (isset($_GET['Submit1'])) {

		$getDropdownID = $_GET['drop1'];

		header ("Location: survey.php?h1=" . $getDropdownID);
	}

	$database = "survey";
  $user_name = "root";
	$password = "";

	$conn = new PDO("mysql:host=localhost;dbname=$database", $user_name, $password);

	if ($conn) {

		$stmt = $conn->prepare("SELECT ID, Question FROM tblsurvey");

		if ($stmt) {

			$stmt->execute();
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if ($row) {

			foreach($row as $row1){

					$qID = $row1['ID'];
					$question = $row1['Question'];
					$dropdown = $dropdown . "<OPTION VALUE='" . $qID . "'>" . $question . "</OPTION>" . "<BR>";


				}

				$wholeHTML = $startSelect . $dropdown . $endSelect;
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
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Welcome </title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/heroic-features.css" rel="stylesheet">

<title>Set a Survey Question</title>
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

<FORM NAME ="form1" METHOD ="GET" ACTION ="setSurvey.php">
<?PHP print $wholeHTML; ?>
<P><INPUT TYPE = "Submit" Name = "Submit1"  VALUE = "Set a Question"></P>

</FORM>
</body>
</html>

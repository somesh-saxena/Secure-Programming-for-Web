<?PHP session_start();
require 'configure.php';
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{

$question = '';
$answerA = '';
$answerB = '';
$answerC = '';

$imgTagA = '';
$imgWidthA = '0';

$imgTagB = '';
$imgWidthB = '0';

$imgTagC = '';
$imgWidthC = '0';

$imgHeight = '10';
$totalP = '';
$percentA = '0';
$percentB = '0';
$percentC = '0';

$qA = '';
$qB = '';
$qC = '';

if (isset($_GET['Submit2']) && isset($_GET['h1'])) {

	$qNum = $_GET['h1'];

	$user_name = "root";
	$password = "";
	$database = "survey";
	$server = "127.0.0.1";

	$conn = new PDO("mysql:host=localhost;dbname=$database", $user_name, $password);

	if ($conn) {

		$stmt = $conn->prepare('SELECT * FROM tblsurvey WHERE ID = :i');
		if ($stmt) {
      $stmt->bindparam(':i', $qNum);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			if ($row) {

				$question = $row['Question'];
				$answerA = $row['OptionA'];
				$answerB = $row['OptionB'];
				$answerC = $row['OptionC'];

				$qA = $row['VotedA'];
				$qB = $row['VotedB'];
				$qC = $row['VotedC'];

				$totalP = $qA + $qB + $qC;

				$percentA = (($qA * 100) / $totalP);
				$percentA = floor($percentA);

				$percentB = (($qB * 100) / $totalP);
				$percentB = floor($percentB);

				$percentC = (($qC * 100) / $totalP);
				$percentC = floor($percentC);

				$imgWidthA = $percentA * 2;
				$imgWidthB = $percentB * 2;
				$imgWidthC = $percentC * 2;

				$imgTagA = "<IMG SRC = 'red.jpg' Height = " . $imgHeight . " WIDTH = " . $imgWidthA. ">";
				$imgTagB = "<IMG SRC = 'red.jpg' Height = " . $imgHeight . " WIDTH = " . $imgWidthB . ">";
				$imgTagC = "<IMG SRC = 'red.jpg' Height = " . $imgHeight . " WIDTH = " . $imgWidthC . ">";
			}
			else {
				print "ROW ERROR";
			}
		}
	}
	else {
		print "database error";
	}


}
else {
	print "no results to display";
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Welcome </title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/heroic-features.css" rel="stylesheet">

<title>Survey Results</title>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 5px;
  text-align: left;
}
</style>
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

	<table style="width:100%">
	<tr>
			<h2><?php print $question . "<BR>";?> </h2>
	    <th>Options</th>
	    <th>Percentage</th>
			<th>Number of votes</th>
	  </tr>
	  <tr>
	    <td><?php print $answerA ?></td>
	    <td><?php print $percentA ." %"?></td>
			<td><?php print $qA ?></td>
	  </tr>
		<tr>
	    <td><?php print $answerB ?></td>
	    <td><?php print $percentB ." %"?></td>
			<td><?php print $qB ?></td>
	  </tr>
		<tr>
	    <td><?php print $answerC ?></td>
	    <td><?php print $percentC ." %"?></td>
			<td><?php print $qC ?></td>
	  </tr>
			</table>

      <p><a  href="survey.php" class="btn btn-primary btn-large"> Back </a>
      </p>

</body>
</html>

<?PHP
require 'configure.php';
$voteMessage = "";
session_start();
if ((isset($_SESSION['hasVoted']))) {
	if ($_SESSION['hasVoted'] = '1') {
		$voteMessage = "You've already voted";
	}
}
else {
	if (isset($_GET['Submit1']) && isset($_GET['q'])) {

		$selected_radio = $_GET['q'];
		$idNumber = $_GET['h1'];

		$database = "survey";
		$username="root";
	  $password="";

		$conn = new PDO("mysql:host=localhost;dbname=$database", $username, $password);

		if ($conn) {

			if($selected_radio == "A") {
				$stmt = "UPDATE tblsurvey SET VotedA = VotedA + 1 WHERE ID = :i";

				$voteMessage = insert_vote($conn, $stmt, $idNumber);
			}
			else if($selected_radio == "B"){
				$stmt ="UPDATE tblsurvey SET VotedB = VotedB + 1 WHERE ID = :i";

				$voteMessage = insert_vote($conn, $stmt, $idNumber);
			}
			else if($selected_radio == "C"){
				$stmt = "UPDATE tblsurvey SET VotedC = VotedC + 1 WHERE ID = :i";

				$voteMessage = insert_vote($conn, $stmt, $idNumber);
			}
			else {
				print "Error - could not record vote";
			}
		}
	}
	else {
		print "You didn't select a voting option!";
	}
}

function insert_vote($db, $sql, $id) {
	$st = $db->prepare($sql);
  $st->bindparam(':i', $id);
  $st->execute();

	//$_SESSION['hasVoted'] = '1';
	return "Thanks for voting!";
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

<title>Process Survey</title>
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

<?PHP print $voteMessage . "<BR>"; ?>
	<p><a  href="survey.php" class="btn btn-primary btn-large"> Back </a>
	</p>
</body>
</html>

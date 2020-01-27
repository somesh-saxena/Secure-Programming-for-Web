<?PHP session_start();
require 'configure.php';
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{

if (isset($_GET['Sub1'])) {

	$question = $_GET['question'];
	$answerA = $_GET['AnswerA'];
	$answerB = $_GET['AnswerB'];
	$answerC = $_GET['AnswerC'];

	$user_name = "root";
	$password = "";
	$database = "survey";
	$server = "127.0.0.1";

	$conn = new PDO("mysql:host=localhost;dbname=$database", $user_name, $password);

	if ($conn) {

		$stmt = $conn->prepare("INSERT INTO tblsurvey (Question, OptionA, OptionB, OptionC) VALUES (:q,:w,:e,:r)");

    $stmt->bindparam(':q', $question);
    $stmt->bindparam(':w', $answerA);
    $stmt->bindparam(':e', $answerB);
    $stmt->bindparam(':r', $answerC);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

			print "The question has been added to the database";
		}
     else {
			print "Database - error";
		}
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

<title>Survey Admin Page</title>
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
											<a href="logout.php">Logout</a>
									</li>

							</ul>
					</div>
			</div>
	</nav>

<FORM NAME ="form1" METHOD ="GET" ACTION ="setQuestion.php">

Enter a question: <INPUT TYPE = 'TEXT' Name ='question'  value="What is the Question?" maxlength="40">
<p>
Answer A: <INPUT TYPE = 'TEXT' Name ='AnswerA'  value="Option A" maxlength="20">
Answer B: <INPUT TYPE = 'TEXT' Name ='AnswerB'  value="Option B" maxlength="20">
Answer C: <INPUT TYPE = 'TEXT' Name ='AnswerC'  value="Option C" maxlength="20">

<P align = center>
<INPUT TYPE = "Submit" Name = "Sub1"  VALUE = "Set this Question">
</P>
<p><a  href="survey.php" class="btn btn-primary btn-large"> Back </a>
</p>

</FORM>

</body>
</html>

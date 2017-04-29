<?php
//database initialization.
$db_name = "id1296369_software1";
$db_host = "localhost";
$db_user = "id1296369_rspurl1";
$db_pw = "cosc455";

//Create connection
$conn = new mysqli($db_host, $db_user, $db_pw, $db_name);

//Check connection
if ($conn->connect_errno) 
{
	echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
	
} else 
{
	echo "Database connection successful" . "<br>";
	
	//ensuring button actually sent data to php. 
	$vCode = $conn->escape_string ($_POST['verification']);
	
	//compares vCode in database vs vCode being entered
	$verify = $conn->query ("SELECT vCode FROM Users WHERE vCode = 'vCode' LIMIT 1");
	$username = $conn->query ("SELECT Username FROM Users WHERE vCode = 'vCode' LIMIT 1");
	
	if ($vCode == $verify)
	{
		$conn->query ("UPDATE Users SET Verfied = 1 WHERE Username = '$username' LIMIT 1");
		echo "Thank you for registering."
		header('Location: login.html');
		exit;
	}
	
}












mysqli_close($conn);
//Written by Andrew Welsh
?>
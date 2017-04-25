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
	$name = $conn->escape_string ($_POST['name']);
	$username = $conn->escape_string ($_POST['username']);
	$email = $conn->escape_string ($_POST['email']);
	$phone = $conn->escape_string ($_POST['phone']); 
	$password = $conn->escape_string($_POST['password']);
	
	//check to see if registering user is unique. 
	$check = $conn->query ("SELECT Email FROM Users WHERE Email = '$email'") or die ($conn->error());
	if ($check->num_rows > 0)
	{
		echo "You already have an account!";
		header('Location: index.html');
		exit;
	} else 
	{
		$insert = $conn->query ("INSERT INTO Users (FullName, Username, Email, Password, Mobile) Values ('$name', '$username', '$email', '$phone', '$password')");
		echo "Successful Registration";
	}
	
	
	
} //main else statement






//close connection 
mysqli_close($conn);

?>

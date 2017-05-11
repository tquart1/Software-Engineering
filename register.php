<?php
require 'database-connection.php'

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
	
	//encrypt password
	$cost = 10; 
	$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
	$salt = sprintf("$2a$%02d$", $cost) . $salt;
	$hash = crypt($password, $salt);

	//create verification code
	$verify = md5($email);
	
	//email initialization
	$to = $email;
	$subject = "Verfication Code";
	$message = "Your E-Mail Verification Code is: " .$verify. " please copy and paste into link below: " . "https://afterschoolhours.000webhostapp.com/verification.html";
	$header = "From: no-reply@afterschoolhours.xyz";
	
	//mailing function
	$retval = mail ($to, $subject, $message, $header);
	
	//check to see if registering user is unique. 
	$check = $conn->query ("SELECT Email FROM Users WHERE Email = '$email'");
	$unique = $conn->query ("SELECT Username FROM Users WHERE Username = '$username'");
	
	if ($check->num_rows > 0) //checks to see if email is unique, since it's a primary key.
	{
		echo "<script>console.log('You already have an account!')</script>";
		header('Location: login.html');
		exit;
	} else if ($unique->num_rows > 0) //checks to see if username is unique allows us to manipulate data easier
	{
		echo "<script>console.log('Username is taken please user another')</script>";
		header ('Location: signup.html');
		exit;
	} else 
	{
		
		$insert = $conn->query ("INSERT INTO Users (FullName, Username, Email, Password, vCode, Mobile, Verification) Values ('$name', '$username', '$email', '$hash', '$verify' ,'$phone', 0)");
		
		if ($retval == true)
		{
			echo "Check your email for verification code!";
		} else 
		{
			echo "Failure";
		}//check if mail was sent, mainly if server side issue.
		
	} // registration else statement
	
} //main else statement





//close connection 
mysqli_close($conn);
//Written by Andrew Welsh 

?>
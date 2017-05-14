<?php
	require 'database-connection.php';
	
	$message = '';
	$pw = '';
	$email = '';
	//start of overall if statement
	if (isset($_POST['register'])) 
	{
		//start if statement 1
		if ($_POST['password'] != $_POST['confirm_password'])
		{
			//tells user if passwords do not match.
			$message = 'Passwords do not match';
			exit(0);
		} else if ($_POST['email'] != $_POST['confirm_email'])
		{
			//tells user if emails do not match. 
			$message = 'Emails do not match';
			exit(0);
		} else 
		{
			$email = $_POST['email'];
			//email initialization
			$to = $email;
			$subject = "Verfication Code";
			$body = "Your E-Mail Verification Code is: " .$verify. " please copy and paste into link below: " . "https://afterschoolhours.xyz/verification.php";
			$header = "From: no-reply@afterschoolhours.xyz";

			//password encrypt phase
			$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
			$salt = sprintf("$2a$%02d$", $cost) . $salt;
			$hash = crypt($_POST['password'], $salt);
			$pw = $hash; 

			//create verification code phase
			$verify = md5($_POST['email']);

			//sql insertion phase
			$sql = "INSERT INTO Users (FullName, Username, Email, Password, vCode, Mobile, Verification, Permissions) VALUES (:name, :username, :email, :password, :vCode, :phone, :verification, :permission)";
			$stmt = $conn->prepare($sql);

			//sql prep phase
			$stmt->bindParam(':name', $_POST['name']);
			$stmt->bindParam(':username', $_POST['username']);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':password', $pw); //encrypt that
			$stmt->bindParam(':vCode', $verify);
			$stmt->bindParam(':phone', $_POST['phone']);
			$stmt->bindParam(':verification', 0);
			$stmt->bindParam(':permission', 0);


			if($stmt->execute())
			{
				$retval = mail ($to, $subject, $body, $header);
				$message = 'Success, please check your email for a verification code.';
			} else
			{
				$message = 'Sorry there seems to be a problem, please try again!';
				exit(0);
			}

		//end of if statement 1
		}
		//end of overall if statement
	}

?>

<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Register Form</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link href="public_html/css/buttonstyle.css" type="text/css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>

</head>
<body>
  <h1 class="siteLogo">
    <a href="https://afterschoolhours.xyz/login.html"><img src="images/logo.png" title="AfterSchool Hours" alt="Homepage" /></a>
    </h1>
	
	
	<?php if(!empty($message)): ?>
		<p><?= $message ?></p>
	<?php endif; ?>

	
<div class="register">
  <fieldset id="registrationForm">
    <legend id="registrationLeg">Register</legend>
    <form action="rtest.php" method="POST" accept-charset="UTF-8">
        <input type="text" name="name" maxlength="50" placeholder="Full Name" required="required" />
        <input type="text" name="username" maxlength="50" placeholder="Desired Username" required="required" />
        <input type="password" name="password" maxlength="50" placeholder="Password" required="required" />
				<input type="password" name="confirm_password" maxlength="50" placeholder="Confirm Password" required="required" />
        <input type="text" name="email" maxlength="50" placeholder="E-mail" required="required" />
				<input type="text" name="confirm_email" maxlength="50" placeholder="Confirm E-mail" required="required" />
        <input type="text" name="phone" maxlength="10" placeholder="Phone" required="required" />
        <button name = "register" type="submit" class="btn btn-primary btn-block btn-large">Submit</button>
    </form>

    <form method="get" action="/login.html">
      <p style="color:white">Already have an account?</p>
      <button type="submit" class = "btn btn-primary btn-block btn-large">Login</button>
    </form>
  </fieldset>
</div>

    <script src="js/index.js"></script>

</body>
</html>
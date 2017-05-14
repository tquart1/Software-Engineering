<?php
	require 'database-connection.php';
	
	$message = '';
	$success = '';
	$pw = '';
	$email = ' ';
	
	//start of overall if statement
	if (isset($_POST['register'])) 
	{
			$email = $_POST['email'];
			$username = $_POST['username'];
			$check_email = $conn->prepare('SELECT Email FROM Users WHERE Email = ?');
			$check_username = $conn->prepare('SELECT Username FROM Users WHERE Username = ?');
			$check_email->execute([$email]);
			$check_username->execute([$username]);

			$chk_e = $check_email->fetch(PDO::FETCH_LAZY);
			$chk_u = $check_username->fetch(PDO::FETCH_LAZY);
			
		//start if statement 1
		if ($_POST['password'] != $_POST['confirm_password'])
		{
			//tells user if passwords do not match.
			$message = 'Passwords do not match';
		} else if ($_POST['email'] != $_POST['confirm_email'])
		{
			//tells user if emails do not match. 
			$message = 'Emails do not match';
		} else
		{
			$email = $_POST['email'];
			$username = $_POST['username'];
			$check_email = $conn->prepare('SELECT Email FROM Users WHERE Email = ?');
			$check_username = $conn->prepare('SELECT Username FROM Users WHERE Username = ?');
			$check_email->execute([$email]);
			$check_username->execute([$username]);

			$chk_e = $check_email->fetch(PDO::FETCH_LAZY);
			$chk_u = $check_username->fetch(PDO::FETCH_LAZY);

			if (!empty($chk_e))
			{
				$message = 'The email has been taken, please use another!';
			} else if (!empty($chk_u))
			{
				$message = 'The username has been taken, please use another!';

			} else
			{
				//password encrypt phase
				$cost = 10; 
				$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
				$salt = sprintf("$2a$%02d$", $cost) . $salt;
				$hash = crypt($_POST['password'], $salt);
				$pw = $hash; 

				//create verification code phase
				$verify = md5($_POST['email']);

				//sql insertion phase
				$sql = "INSERT INTO Users (Name, Username, Email, Password, vCode, Mobile) VALUES (:name, :username , :email, :password, :vCode, :mobile)";
				$stmt = $conn->prepare($sql);

				//email initialization
				$to = $email;
				$subject = "Verfication Code";
				$body = "Your E-Mail Verification Code is: " . $verify. " please copy and paste into link below: " . "https://afterschoolhours.xyz/verification.php";
				$header = "From: no-reply@afterschoolhours.xyz";

				//sql prep phase
				$stmt->bindParam(':name', $_POST['name']);
				$stmt->bindParam(':username', $_POST['username']);
				$stmt->bindParam(':email', $_POST['email']);
				$stmt->bindParam(':password', $pw);
				$stmt->bindParam(':vCode', $verify);
				$stmt->bindParam(':mobile', $_POST['phone']);
				
				if( $stmt->execute() )
				{
					mail ($to, $subject, $body, $header);
					$success = 'Success, please check your email for a verification code.';
				} else
				{
					$message = 'Sorry there seems to be a problem, please try again!';
				}
			//end of check username email and user name if	
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
  <link href="assets/css/buttonstyle.css" type="text/css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>

</head>
<body>
  <h1 class="siteLogo">
    <a href="https://afterschoolhours.xyz/login.html"><img src="images/logo.png" title="AfterSchool Hours" alt="Homepage" /></a>
    </h1>
	
	
	<?php if(!empty($message)): ?>
	<center><p stlyle="color:red;"><?= $message ?></p> </center>
	<?php endif; ?>
	<?php if(!empty($success)):?>
	<center><p stlyle="color:green;"><?= $success ?></p> </center>
	<?php endif; ?>

	
<div class="register">
  <fieldset id="registrationForm">
    <legend id="registrationLeg">Register</legend>
    <form id="registration" action="rtest.php" method="POST" accept-charset="UTF-8">
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

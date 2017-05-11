//Close session with full reminder that one cannot recover
<?php
/* Log out process, unsets and destroys session variables */

/* Begins the logout process by unsetting the session varaibles and destroying the session.
   Displays a log out message to the screen
*/

session_start();
session_unset();
session_destroy(); 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Error</title>
  <?php include 'css/css.html'; ?>
</head>

<body>
	<!-- Successful Log Out -->
    <div class="form">
          <h1>Thanks for stopping by</h1>
              
          <p><?= 'You have been logged out!'; ?></p>
          
          <a href="index.php"><button class="button button-block"/>Home</button></a>

    </div>
</body>
</html>

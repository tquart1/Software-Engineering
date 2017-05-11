<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Insert School</title>
	</head>

	<body>
		<h1>Administration</h1>
		<p>You may insert, delete, or modify data</p>
		<div id="controlBox">
			<div id="insert">
        <form action="school_List.php" method="post">
			<fieldset>
				<legend>INSERT</legend>
				<p><label class="title" for="schoolid">School ID:</label>
					<input type="text" name="schoolid" required="required"><br />
					<label class="title" for="name">Name:</label>
					<input type="text" name="name" required="required"><br />
					<label class="title" for="phone">Phone:</label>
					<input type="text" name="phone" required="required"><br />
          <label class="title" for="address">Address:</label>
					<input type="text" name="address" required="required"><br />
					<label class="title" for="city" required="required">City:</label>
					<input type="text" name="city" required="required"><br />
          <label class="title" for="state" required="required">State:</label>
          <input type="text" name="state" required="required"><br />
          <label class="title" for="zip" required="required">Zip:</label>
          <input type="text" name="zip" required="required"><br />
					<input type="submit" name="add" value="INSERT" />
        </form>
				</div>

					<div id="update">
            <form action="school_List.php" method="post">
					<fieldset>
						<legend>UPDATE</legend>
            <p><label class="title" for="schoolid">School ID:</label>
    					<input type="text" name="schoolid" required="required"><br />
    					<label class="title" for="name">Name:</label>
    					<input type="text" name="name" required="required"><br />
    					<label class="title" for="phone">Phone:</label>
    					<input type="text" name="phone" required="required"><br />
              <label class="title" for="address">Address:</label>
    					<input type="text" name="address" required="required"><br />
    					<label class="title" for="city" required="required">City:</label>
    					<input type="text" name="city" required="required"><br />
              <label class="title" for="state" required="required">State:</label>
              <input type="text" name="state" required="required"><br />
              <label class="title" for="zip" required="required">Zip:</label>
              <input type="text" name="zip" required="required"><br />
							<input type="submit" name="edit" value="UPDATE" />
            </form>
						</div>

						<div id="delete">
              <form action="school_List.php" method="post">
						<fieldset>
							<!-- Delete based on primary key -->
							<legend>Delete</legend>
							<p><label class="title" for="schoolid">School ID:</label>
								<input type="text" name="schoolid" required="required"><br />
								<input type="submit" name = "delete" value="DELETE" />
              </form>
							</div>
		</div>

    <div id="main">
     <table border=1>
       <tr>
       <th>School ID</th>
       <th>Name</th>
       <th>Phone</th>
       <th>Address</th>
       <th>City</th>
       <th>State</th>
       <th>Zip</th>
       </tr>
<?php
require_once 'db_connect.php';

if (isset($_POST["add"]))
{
  $School_Id = get_post($conn,"schoolid");
  $Name = get_post($conn,"name");
  $Phone = get_post($conn,"phone");
  $Address = get_post($conn,"address");
  $City = get_post($conn,"city");
  $State = get_post($conn,"state");
  $Zip_Code = get_post($conn,"zip");

  $query = "INSERT INTO Schools VALUES" .
    "('$School_Id', '$Name', '$Phone', '$Address', '$City', '$State', '$Zip_Code')";
  $result = $conn->query($query);
  if (!$result) echo "INSERT FAILED: $query<br />" . $conn->error;
}

else if (isset($_POST["edit"])) {

  $School_Id = $_POST["schoolid"];
  $Name = $_POST["name"];
  $Phone = $_POST["phone"];
  $Address = $_POST["address"];
  $City = $_POST["city"];
  $State = $_POST["state"];
  $Zip_Code = $_POST["zip"];

$query = "UPDATE Schools SET Name='$Name', Phone_Number='$Phone',
Street_Address='$Address', City='$City', State='$State', Zip_Code='$Zip_Code' WHERE School_Id='$School_Id'";
$result = $conn->query($query);

}
else if (isset($_POST["delete"]))
{
  $School_Id = $_POST["schoolid"];
  $query = "DELETE FROM Schools WHERE School_Id=$School_Id";
  $result = $conn->query($query);

}
$query = "SELECT * FROM Schools";
$result= $conn->query($query);
$rows = $result->num_rows;
// Execute SQL statement
for ($j = 0; $j < $rows; ++$j)
{
  $result->data_seek($j);
  $row = $result->fetch_array(MYSQLI_NUM);
  echo "<tr>
  <td>{$row[0]}</td>
  <td>{$row[1]}</td>
  <td>{$row[2]}</td>
  <td>{$row[3]}</td>
  <td>{$row[4]}</td>
  <td>{$row[5]}</td>
  <td>{$row[6]}</td>
  </tr>";
}

function get_post($conn,$var) {
  return $conn->real_escape_string($_POST[$var]);
}
  ?>
</table>
</div>
</body>
</html>

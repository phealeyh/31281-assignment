<?php
session_start();
//codes allocated for each user type
$_SESSION['AdminCode'] = 103;
$_SESSION['EMCode'] = 102;
$_SESSION['SproutCode'] = 101;
$_SESSION['VolunteerCode'] = 100;

if ($_SESSION['LoggedIn'] != $_SESSION['AdminCode'] && $_SESSION['LoggedIn'] !=$_SESSION['EMCode']) {
    header("Location: index.php");
}

//set the context sensitive help index
$HC = 6;
$_SESSION['HC'] = $HC;
?>

<!-- File: viewVolunteersSA.php
 * ------------------------
 * This html file contains the list of volunteers within the system.
 * It is also responsible for establishing the connection between the database and requesting
 * queries about the list of volunteers. It displays the volunteers names in a drop down box.
 -->
<html>
<head>

<link rel="stylesheet" type="text/css" href="buttons.css">
</head>
<body>

<div id="header">
<?php $currentUser = $_SESSION['Name']; ?>
Logged in as: <b><?php echo $currentUser; ?></b>            <a href="logout.php"> Log Out </a>
</div>


<div id="banner">
UTS Event Management System
</div>
<div class="navAlign" id="container">
<?php echo $_SESSION['Navigation']; ?>
</div>

<div class="contentBoxLong2">

<h2 id="positionTopH2">All Users</h2>
<pre id="instructions">
	General Instructions
</pre>
<pre id="preAlign2">
	Select a User from the table and click "Update" to update the user.
	To add a new user, select the user type from the drop down menu and 
	click the '+' symbol.
	</pre>

<form action="addUserTypeProcess.php" method="post" id="bottomButton1"> <!-- Specifies where to send the form data -->
<p id="addNew">
Add New:
</p>
<select id="dropDownList" name="usertype_list" style="width: 400px, height: 50px;">
<option value="2">Manager</option>
<option value="1">Volunteer</option>
</select>

<input type="submit" value="+" id="plusSign"> <!--creates the add user button-->
</form>



<form action="updateUserTypeProcess.php" method="post"> 
<input type="submit" class="button" value="Update" id="bottomButton3"> 
<?php
//Defines the constants along with its values
define('DB_NAME', 's1053775_database'); //name of database
define('DB_USER', 's1053775_root'); //name of database user
define('DB_PW', 'W3arethebest'); //password
define('DB_HOST', 'localhost'); //where the database is running

//a variable created based on the connection to the sql database
$dbLink = mysql_connect(DB_HOST,DB_USER, DB_PW);
mysql_select_db(DB_NAME,$dbLink); 

if ($_SESSION['LoggedIn'] == $_SESSION['AdminCode']) { // if admin
	$volunteersList = mysql_query("SELECT * FROM `User Details` ORDER BY Given_Names");
} else {
	$volunteersList = mysql_query("SELECT * FROM `User Details` INNER JOIN Account ON UTS_ID = User_ID WHERE Privilege < 3 ORDER BY Given_Names");    	
}
?>

<?php
$i=0;




echo "<div style=\"overflow-y: scroll; overflow-x: hidden;\" class=\"contentSmall\" id=\"scrollBox2\"><table border='1' class=\"table1\" id='container' >
<tr>
<th>Select</th>
<th>User ID</th>
<th>Given Name</th>
<th>Surname</th>
<th>Type</th>
</tr>";





while($row = mysql_fetch_array($volunteersList)) { //loops until the end of the volunteers list, which should return a false
  
  $uID = $row['User_ID'];
  $uSQL = "SELECT * FROM Account
  WHERE UTS_ID = $uID";
  $rowU = mysql_fetch_array(mysql_query($uSQL));
  
  echo "<tr>";
  if ($i == 0) {
      echo "<td><input type=\"radio\" checked=\"checked\" name=\"volunteer_list\" value=".$row['User_ID']."></td>";
  } else {
      echo "<td><input type=\"radio\" name=\"volunteer_list\" value=".$row['User_ID']."></td>";
  }
  echo "<td>" . $row['User_ID'] . "</td>";
  echo "<td>" . $row['Given_Names'] . "</td>";
  echo "<td>" . $row['Surname'] . "</td>";
  if ($rowU['Privilege'] >= 3) {
      echo "<td>Admin</td>";
  } else if ($rowU['Privilege'] == 2) {
      echo "<td>Event Manager</td>";
  } else if ($rowU['Privilege'] == 1) {
      echo "<td>Sprout</td>";
  } else if ($rowU['Privilege'] == 0) {
      echo "<td>Volunteer</td>";
  }
  echo "</tr>";



?>
<?php
$i++;
}


?>

<?php
mysql_close($dbLink); //closes the connection to the database
?>
</div>

</form>


</div>

</body>
</html>
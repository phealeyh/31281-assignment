<?php

session_start();
$_SESSION['AdminCode'] = 103;
$_SESSION['EMCode'] = 102;
$_SESSION['SproutCode'] = 101;
$_SESSION['VolunteerCode'] = 100;
if ($_SESSION['LoggedIn'] != $_SESSION['AdminCode'] && $_SESSION['LoggedIn'] !=$_SESSION['EMCode']) {
    header("Location: index.php");
}

if ($_GET['u_ID'] == "") {
    header("Location: viewUsers.php");
}
?>

<html>

<head>
<link rel="stylesheet" type="text/css" href="buttons.css">
<link rel="stylesheet" type="text/css" href="form.css">
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

<?php
$uID = $_GET['u_ID'];

?>


<div class="contentBox">
<h2 id="positionTopH2">Volunteer Reporting - <a href="updateUserV.php?u_ID=<?php echo $uID; ?>"><?php echo $uID; ?></a></h2>



<!-- REGISTERED EVENTS BOX -->
<div class="contentRectangleActivity" id="rectangleContainer">
<pre id="preAlignH3">
	<h3>Registered Events</h3>
	</pre>
<?php

//Defines the constants along with its values
define('DB_NAME', 's1053775_database'); //name of database
define('DB_USER', 's1053775_root'); //name of database user
define('DB_PW', 'W3arethebest'); //password
define('DB_HOST', 'localhost'); //where the database is running

//a variable created based on the connection to the sql database
$dbLink = mysql_connect(DB_HOST,DB_USER, DB_PW);
mysql_select_db(DB_NAME,$dbLink); 

//insert the user record into the database


//insert the user record into the database
$activitiesList = mysql_query("SELECT * FROM `Allocated` 
 WHERE Volunteer_ID = $uID"); 
 $i=0;
?>	
	
<?php
echo "<div style=\"overflow-y: scroll; overflow-x: hidden;\" class=\"activitySmall\" id=\"positionActivitySmall5\"><table border='1' class=\"table1\" id='container' >
<tr>
<th>Activity Name</th>
<th>Start Date</th>
<th>End Date</th>
<th>Hours</th>
<th>Status</th>
</tr>";
while($row = mysql_fetch_array($activitiesList)) { //loops until the end of the volunteers list, which should return a false

$aaID = $row['Activity_ID'];
$activityQuery = "SELECT * FROM `Activities` WHERE Activity_ID ='$aaID'";
$rowA = mysql_fetch_array(mysql_query($activityQuery));
  
  echo "<tr>";
  echo "<td>" . $rowA['Name'] . "</td>";
  echo "<td>" . $rowA['Start_Date'] . "</td>";
  echo "<td>" . $rowA['End_Date'] . "</td>";
  echo "<td>" . $rowA['Duration'] . "</td>";
  if ($row['Allocated'] == 1)
  {
      echo "<td> Allocated </td>";
  } else {
      echo "<td> Registered </td>";
  }
  echo "</tr>";



$i++;

}
?>
</table>
</div>
	
	
	

	
	
	
	
	
	
	
	
<div class="contentRectangleActivity" id="rectangleContainer3">
<pre id="preAlignH3">
	<h3>Volunteer History</h3>
	</pre>

<?php
//insert the user record into the database
$activitiesList = mysql_query("SELECT * FROM `Allocated` 
 WHERE Volunteer_ID = $uID
  AND Allocated = 2"); 



echo "<div style=\"overflow-y: scroll; overflow-x: hidden;\" class=\"activitySmall\" id=\"positionActivitySmall5\"><table border='1' class=\"table1\" id='container' >
<tr>
<th>Activity Name</th>
<th>Start Date</th>
<th>End Date</th>
<th>Hours</th>
</tr>";
while($row = mysql_fetch_array($activitiesList)) { //loops until the end of the volunteers list, which should return a false

$aaID = $row['Activity_ID'];
$activityQuery = "SELECT * FROM `Activities` WHERE Activity_ID ='$aaID'";
$rowA = mysql_fetch_array(mysql_query($activityQuery));
  
  echo "<tr>";
  echo "<td>" . $rowA['Name'] . "</td>";
  echo "<td>" . $rowA['Start_Date'] . "</td>";
  echo "<td>" . $rowA['End_Date'] . "</td>";
  echo "<td>" . $rowA['Duration'] . "</td>";
  echo "</tr>";



$i++;

}






mysql_close($dbLink); //closes the connection to the database

?>

</div>





</body>
</html>
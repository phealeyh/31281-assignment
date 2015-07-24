<!-- File: updateManagedUserProcess.php
 * ------------------------
 * This html file contains the list of events within the system.
 * It is also responsible for establishing the connection between the database and requesting
 * queries about the list of events. It displays the events in a drop down box.
 -->
<html>
<head>

<link rel="stylesheet" type="text/css" href="buttons.css">
</head>
<body>

<div id="header">
</div>

<div class="navAlign" id="container">
<ul class="navButton">

<li><a href="dashboard.php">Dashboard</a></li>
<li id="current"><a href="viewEvents.php">Events</a></li>
<li><a href = "viewVolunteers.php">Volunteers</a></li>
<li><a href = "viewActivities.php">Activities</a></li>
<li><a href = "viewRoles.php">Roles</a></li>
</ul>
</div>

<?php 
$uID = $_GET['u_ID']; 
$rID = $_GET['r_ID'];
//Defines the constants along with its values
define('DB_NAME', 's1053775_database'); //name of database
define('DB_USER', 's1053775_root'); //name of database user
define('DB_PW', 'W3arethebest'); //password
define('DB_HOST', 'localhost'); //where the database is running

//a variable created based on the connection to the sql database
$dbLink = mysql_connect(DB_HOST,DB_USER, DB_PW);
$selectedDB = mysql_select_db(DB_NAME,$dbLink); 

//insert the user record into the database


 
//insert the user record into the database
$regID = $uID + $rID;
$update_SQL = "INSERT INTO `Allocated` 
 Values ($uID, $rID, $regID)";
 
if (!mysql_query($update_SQL)) { //checks if there is a valid record selected; if not, execute statement
  die('Error: ' . mysql_error());
} 

$update_SQL ="DELETE FROM `Registered` 
 WHERE Role_ID = $rID 
 AND Volunteer_ID = $uID";
 
if (!mysql_query($update_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}
 
mysql_close($dbLink); //closes the connection to the database

?>




</body>
</html>
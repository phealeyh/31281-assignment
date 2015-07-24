<?php
session_start();
if (!$_SESSION['LoggedIn'] == 101) {
    header("Location: index.php");
} 
?>
<!-- File: viewVolunteerRoles.php
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
<?php $currentUser = $_SESSION['Name']; ?>
Logged in as: <b><?php echo $currentUser; ?></b>            <a href="logout.php"> Log Out </a>
</div>
<div id="banner">
UTS Event Management System
</div>
<div class="navAlign" id="container">
<ul class="navButton">

<li><a href="dashboard.php">Dashboard</a></li>
<li id="current"><a href="viewEvents.php">Events</a></li>
<li><a href = "viewVolunteers.php">Volunteers</a></li>
<li><a href = "viewActivities.php">Activities</a></li>
<li><a href = "viewRoles.php">Roles</a></li>
</ul>

<?php 
$aID = $_POST['activity_list']; 
//Defines the constants along with its values
define('DB_NAME', 's1053775_database'); //name of database
define('DB_USER', 's1053775_root'); //name of database user
define('DB_PW', 'W3arethebest'); //password
define('DB_HOST', 'localhost'); //where the database is running
echo "test";
?>


</div>

<div class="contentBox">

<h2> Roles: </h2>

<!-- Allows a specific event to be editted -->
<form action="viewVolunteerRoleDetail.php" method="post" id="dropdown"> 
<?php

//a variable created based on the connection to the sql database
$dbLink = mysql_connect(DB_HOST,DB_USER, DB_PW);
mysql_select_db(DB_NAME,$dbLink); 
$rolesList = mysql_query("SELECT * FROM `Role`
WHERE Positions_Filled < Positions_Required
ORDER BY Role_Name");
?>
<select id="role_list" name="role_list" style="width: 400px;">
<?php
$i=0;

while($row = mysql_fetch_array($rolesList)) { //loops until the end of the volunteers list, which should return a false
?>
<!--Displays the list of  options within the html page-->
<option value=<?=$row["Role_ID"];?>><?=$row["Role_Name"] ;?></option>
<?php
$i++;
}

?>
</select>
<?php
mysql_close($dbLink); //closes the connection to the database
?>

<input type="submit" value="Details"> 
</form>





</div>


</body>
</html>
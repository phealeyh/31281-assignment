<?php
session_start();
if (!$_SESSION['LoggedIn'] == 101) {
    header("Location: index.php");
} 
?>
<!-- File: manageRole.php
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
$rID = $_POST['role_list']; 
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
$get_SQL = mysql_query("SELECT * FROM `Role` 
 WHERE Role_ID = $rID"); 

//if (!mysql_query($get_SQL)) { //checks if there is a valid record selected; if not, execute statement
//    die('Error: ' . mysql_error());
//}

$i=0;

$row = mysql_fetch_array($get_SQL);


$gN = $row['Role_Name'];
$gD = $row['Description'];
$gSD = $row['Start_Date'];
$gED = $row['End_Date'];
$gTSD = $row['Start_Time'];
$gTED = $row['End_Time'];
$eID = $row['Event_ID'];
$aID = $row['Activity_ID'];
$rPosReq = $row['Positions_Required'];

$get_SQL = mysql_query("SELECT COUNT(*) as Con FROM `Allocated` 
 WHERE Role_ID = $rID"); 
 
$row = mysql_fetch_array($get_SQL);
$rPosAll = $row['Con'];
 
mysql_close($dbLink); //closes the connection to the database
?>

</div>




<div class="contentBoxLong">


<h2 id="positionTopH2">Managing Role: <?php echo $gN?> (<?php echo $rID ?>)</h2>

	<div class="contentRectangleEvent" id="rectangleContainer">

	<pre id="preAlignH3">
	<h3>Role Details</h3>
	</pre>
	
	<pre id="preAlign">
	Role Name: <em><?php echo $gN; ?></em>		
	Start Date: <em><?php echo $gSD; ?></em>
	EndDate: <em><?php echo $gED; ?></em>
	Start Time: <em><?php echo $gTSD; ?></em> 
	End Time: <em><?php echo $gTED; ?></em>
	Positions Filled: <em><?php echo $rPosAll; ?> / <?php echo $rPosReq; ?></em> 
	</pre>
	<p id="column2">Description:</p>
	<div style="overflow-y: scroll;" class="eventDescription" id="eventDescriptionPosition2">
	<p id="pAlign">
	<em><?php echo $gD; ?></em>
	</p>
	</div>
	<form action="updateRoleV.php?r_ID=<?php echo $rID; ?>" method="post"> <!-- Specifies where to send the form data -->
	<input type="submit" value="Update" class="button" id="updateButtonRnE">
	</form>
</div>
































<div class="contentRectangleActivity " id="rectangleContainer3">
	
	<pre id="preAlignH3">
	<h3>Allocated Volunteers</h3>
	</pre>
	<form action="addActivities.php?e_ID=<?php echo $eID; ?>" method="post"> <!-- Specifies where to send the form data -->
<input type="submit" value="Add New Activity" class="greenButton" id="activityButton"> <!--creates the add event button-->
</form>
	
<form action="manageAllocatedRole.php?r_ID=<?php echo $rID; ?>" method="post"> 
<input type="submit" value="Manage Role" class="button" id="manageActivityButton"> 
<?php

//a variable created based on the connection to the sql database
$dbLink = mysql_connect(DB_HOST,DB_USER, DB_PW);
mysql_select_db(DB_NAME,$dbLink); 
$rolesList = mysql_query("SELECT * FROM `Registered` INNER JOIN `User Details` 
ON Registered.Volunteer_ID = `User Details`.User_ID 
WHERE Registered.Role_ID = $rID 
ORDER BY `User Details`.Given_Names");
?>



<?php
$i=0;

?>
<div style="overflow-y: scroll; overflow-x: hidden;" class="activitySmall" id="positionActivitySmall"><table border='1' class="table1" id='container' >
<?php
echo "
<tr>
<th>Select</th>
<th>User ID</th>
<th>Given Name</th>
<th>Surname</th>

</tr>";

while($row = mysql_fetch_array($rolesList)) { //loops until the end of the volunteers list, which should return a false





  echo "<tr>";
  echo "<td><input type=\"radio\" name=\"rolesList\" value=".$row['User_ID']."></td>";
  echo "<td>" . $row['User_ID'] . "</td>";
  echo "<td>" . $row['Given_Names'] . "</td>";
  echo "<td>" . $row['Surname'] . "</td>";

  echo "</tr>";


?>

<?php
$i++;

}

?>
</table>
</div>
<?php
mysql_close($dbLink); //closes the connection to the database

?>



</form>

</div>






<div class="contentRectangleActivity " id="rectangleContainer4">
	
	<pre id="preAlignH3">
	<h3>Registered Volunteers</h3>
	</pre>
	<form action="addActivities.php?e_ID=<?php echo $eID; ?>" method="post"> <!-- Specifies where to send the form data -->
<input type="submit" value="Add New Activity" class="greenButton" id="activityButton"> <!--creates the add event button-->
</form>
	
<form action="manageRegisteredRole.php?r_ID=<?php echo $rID; ?>" method="post"> 
<input type="submit" value="Manage Role" class="button" id="manageActivityButton"> 
<?php

//a variable created based on the connection to the sql database
$dbLink = mysql_connect(DB_HOST,DB_USER, DB_PW);
mysql_select_db(DB_NAME,$dbLink); 
$rolesList = mysql_query("SELECT * FROM `Registered` INNER JOIN `User Details` 
ON Registered.Volunteer_ID = `User Details`.User_ID 
WHERE Registered.Role_ID = $rID 
ORDER BY `User Details`.Given_Names");
?>



<?php
$i=0;

?>
<div style="overflow-y: scroll; overflow-x: hidden;" class="activitySmall" id="positionActivitySmall"><table border='1' class="table1" id='container' >
<?php
echo "
<tr>
<th>Select</th>
<th>User ID</th>
<th>Given Name</th>
<th>Surname</th>

</tr>";

while($row = mysql_fetch_array($rolesList)) { //loops until the end of the volunteers list, which should return a false





  echo "<tr>";
  echo "<td><input type=\"radio\" name=\"rolesList\" value=".$row['User_ID']."></td>";
  echo "<td>" . $row['User_ID'] . "</td>";
  echo "<td>" . $row['Given_Names'] . "</td>";
  echo "<td>" . $row['Surname'] . "</td>";

  echo "</tr>";


?>

<?php
$i++;

}

?>
</div>
<?php
mysql_close($dbLink); //closes the connection to the database

?>



</form>

</div>







</div>
</body>
</html>
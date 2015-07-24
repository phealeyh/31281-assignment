<?php
session_start();
if (!$_SESSION['LoggedIn'] == 101) {
    header("Location: index.php");
} 
?>
<!-- File: updateRoleV.php
 * ------------------------
 * This php file will be concerned with gathering the details of a new volunteer
 * and then submitting that information to the newUserProcess php file. This page will
 * display fields for the volunteer to enter and submit.
 -->
 
<html>
<head>

<link rel="stylesheet" type="text/css" href="buttons.css">
<link rel="stylesheet" type="text/css" href="form.css">
</head>
<body>

<div id="header">
</div>

<div id="banner">
UTS Event Management System
</div>

<div class="navAlign" id="container">
<ul class="navButton">

<li><a href="createVolunteer.html">Dashboard</a></li>
<li><a href="viewEvents.php">Events</a></li>
<li><a href = "viewVolunteers.php">Volunteers</a></li>
<li id="current"><a href = "viewActivities.php">Activities</a></li>
<li><a href = "viewRoles.php">Roles</a></li>

</ul>
</div>

<?php $rID= $_GET['r_ID']; ?>

<div class="contentBoxLong2">
<h2 id="positionTopH2">Update Role Details for <?php echo $rID?></h2>
<pre id="instructions">
	General Instructions
</pre>
<pre id="preAlign2">
	To update an role, change the details in the fields and click on Update.
	To remove an event, click on Delete. 
</pre>

<form action="updateRoleProcess.php" method="post" class="createUser" id="container3">
<!--Send the form for processing to the updateActivityProcess php file-->
<?php

define('DB_NAME', 's1053775_database');//name of database
define('DB_USER', 's1053775_root');//name of database user
define('DB_PW', 'W3arethebest'); //password
define('DB_HOST', 'localhost'); //where the database is running



?>

<?php
//a variable created based on the connection to the sql database
$dbLink = mysql_connect(DB_HOST, DB_USER, DB_PW);

if (!$dbLink) { //checks if there is a valid db connection; if not, execute statement
    die('Connection failed: ' . msql_error());
    
}
//selects the mysql database based on the link and stores it in a variable
$selectedDB = mysql_select_db(DB_NAME, $dbLink);

if (!$selectedDB) { //checks if there is a valid db selected; if not, execute statement
    die('Error: ' . DB_NAME . ': ' . msql_error());
}

//insert the event record into the database
$get_SQL = mysql_query("SELECT * FROM `Role` WHERE Role_ID = $rID"); 

//if (!mysql_query($get_SQL)) { //checks if there is a valid record selected; if not, execute statement
//    die('Error: ' . mysql_error());
//}

$i=0;

while($row = mysql_fetch_array($get_SQL)) { //loops until the end of the events list, which should return a false

//Collect these values from the form and store them into a variable
$aID = $row['Activity_ID'];
$eID = $row['Event_ID'];
$rName = $row['Role_Name'];
$rDescription = $row['Description'];
$rStart = $row['Start_Date'];
$rEnd = $row['End_Date'];
$rTStart = $row['Start_Time'];
$rTEnd = $row['End_Time'];
$rPosReq = $row['Positions_Required'];

?>
<!--Event fields that the user must fill in-->

<h1>Role Update Form</h1>
<label>
<span>Role ID</span>
<input id="Role_ID" type="text" name="Role_ID" maxlength="8" value='<?php echo $rID; ?>' </input>
</label>

<label>
<span>Event ID</span>
<?php echo $eID; ?>
</label>

<label>
<span>Activity ID</span>
<?php echo $aID; ?>
</label>

<label>
<span>Name</span>
<input id="Role_Name" type="text" name="Role_Name" value='<?php echo $rName; ?>' </input>
</label>

<label>
<span>Description</span>
<textarea id="Description" name="Description" rows=5 cols=25><?php echo $rDescription; ?></textarea>
</label>

<label>
<span>Start Date</span>
<input id="Start_Date" type="Date" name="Start_Date" value='<?php echo $rStart; ?>' </input>
</label>

<label>
<span>End Date</span>
<input id="End_Date" type="Date" name="End_Date" value='<?php echo $rEnd; ?>' </input>
</label>

<label>
<span>Start Time</span>
<input id="Start_Time" type="time" name="Start_Time" value='<?php echo $rTStart; ?>' </input>
</label>

<label>
<span>End Time</span>
<input id="End_Time" type="time" name="End_Time"value='<?php echo $rTEnd; ?>' </input>
</label>

<label>
<span>Positions Required</span>
<input id="Positions_Required" type="text" name="Positions_Required"value='<?php echo $rPosReq; ?>' </input>
</label>

<label>
<span> &nbsp</span>
<input type="submit" class="greenButton" value="Update" />
</label>
<?php
$i++;
}
mysql_close($dbLink); //closes the connection to the database

?>




</form>
<form action="deleteRoleProcess.php?dActivity_ID=<?php echo $rID?>" method="post">
<input type="submit" class="redButton" value="Delete" id="deleteButton2">
</form>

<br>
<br>
<form action="manageRole.php" method="post">
<input type="submit" value="Back" class="button" id="backButton">
</form>
</div>

</body>
</html>
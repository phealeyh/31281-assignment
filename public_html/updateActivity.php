<!-- File: updateActivity.php
 * ------------------------
 * This php file will be concerned with gathering the details of a new volunteer
 * and then submitting that information to the newUserProcess php file. This page will
 * display fields for the volunteer to enter and submit.
 -->
 
<html>
<head>

<link rel="stylesheet" type="text/css" href="buttons.css">
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

<?php $aID= $_POST['activity_list']; ?>

<div class="contentBox">


<h2 id="positionTopH2">Update Details for Activity <?php echo $aID?></h2>

<form action="updateActivityProcess.php" method="post">
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
$get_SQL = mysql_query("SELECT Activity_ID, Event_ID, Name, Start, End FROM `Activities` WHERE Activity_ID = $aID"); 

//if (!mysql_query($get_SQL)) { //checks if there is a valid record selected; if not, execute statement
//    die('Error: ' . mysql_error());
//}

$i=0;

while($row = mysql_fetch_array($get_SQL)) { //loops until the end of the events list, which should return a false

//Collect these values from the form and store them into a variable
$aID = $row['Activity_ID'];
$eID = $row['Event_ID'];
$aName = $row['Name'];
$aStart = $row['Start'];
$aEnd = $row['End'];


?>
<!--Event fields that the user must fill in-->

 Activity ID: <input type="text" name="Activity_ID" value='<?php echo $aID; ?>'><br>
 Event ID: <input type="text" name="Event_ID" value='<?php echo $eID; ?>'><br>
 Name: <input type="text" name="Name" value='<?php echo $aName; ?>'><br>
 Start: <input type="text" name="Start" value='<?php echo $aStart; ?>'><br> 
 End: <input type="text" name="End" value='<?php echo $aEnd; ?>'><br>

 <!--The submit button-->  
 <input type="submit" value="Update">
 
<?php
$i++;
}
mysql_close($dbLink); //closes the connection to the database

?>




 </form>
<form action="deleteActivityProcess.php?dActivity_ID=<?php echo $aID?>" method="post">
<input type="submit" value="Delete">
</form>

<br>
<br>
<form action="viewActivities.php" method="post">
<input type="submit" value="Back">
</form>
</div>

</body>
</html>
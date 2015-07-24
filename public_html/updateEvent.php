<!-- File: updateEvent.php
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

<li><a href="dashboard.php">Dashboard</a></li>
<li id="current"><a href="viewEvents.php">Events</a></li>
<li><a href = "viewVolunteers.php">Volunteers</a></li>
<li><a href = "viewActivities.php">Activities</a></li>
<li><a href = "viewRoles.php">Roles</a></li>

</ul>
</div>

<?php $eID= $_POST['event_list']; ?>

<div class="contentBox">
<p>Update Event Details for <?php echo $eID?></p>
<form action="updateEventProcess.php" method="post" class="createUser">
<!--Send the form for processing to the updateEventProcess php file-->
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
$get_SQL = mysql_query("SELECT * FROM `Event` WHERE Event_ID = $eID"); 

//if (!mysql_query($get_SQL)) { //checks if there is a valid record selected; if not, execute statement
//    die('Error: ' . mysql_error());
//}

$i=0;

while($row = mysql_fetch_array($get_SQL)) { //loops until the end of the events list, which should return a false

$eID = $row['Event_ID'];
$eSDateU= $row['Start_Date'];
$eEDate= $row['End_Date'];
$eDescription= $row['Description'];
$eLocation= $row['Location'];
$eName= $row['Name'];


?>
<!--Event fields that the user must fill in-->
<h1>Update Event Detailsss for <?php echo $eID?></h1>


<label>
<span>Event ID</span>
<input id="Event_ID" type="text" name="Event_ID" maxlength="8" value='<?php echo $eID; ?>' />
</label>

<label>
<span>Name</span>
<input id="Name" type="text" name="Name" value='<?php echo $eName; ?>'/>
</label>

<label>
<span>Description</span>
<textarea id="Description" name="Description" rows=5 cols=25><?php echo $eDescription;?></textarea>
</label>

<label>
<span>Something</span>
<input id="Start" type="Date" name="Start" value='<?php echo $eSDate; ?>' />
</label>

<label>
<span>Start Date</span>
<input id="Start_Date" type="Date" name="Start_Date" value='<?php echo $eSDate; ?>' />
</label>

<label>
<span>End Date</span>
<input id="End_Date" type="Date" name="End_Date" value='<?php echo $eEDate; ?>' />
</label>


<label>
<span>Location</span>
<input id="Location" type="text" name="Location" value='<?php echo $eLocation; ?>' />
</label>

<?php

//a variable created based on the connection to the sql database
$dbLink = mysql_connect(DB_HOST,DB_USER, DB_PW);
mysql_select_db(DB_NAME,$dbLink); 

$volunteersList = mysql_query("SELECT * FROM `Account` INNER JOIN `User Details` 
ON Account.UTS_ID = `User Details`.User_ID  
WHERE Account.Privilege IN(2,3)  
ORDER BY `User Details`.Given_Names");

?>
<label>
<span> Manager </span>
<select id="volunteer_list" name="volunteer_list" style="width: 200px;">
<?php
$i=0;

while($row = mysql_fetch_array($volunteersList)) { //loops until the end of the volunteers list, which should return a false
?>
<!--Displays the list of  options within the html page-->
<option value=<?=$row["User_ID"];?>><?=$row["Given_Names"] . " " . $row["Surname"] ;?></option>
<?php
$i++;
}

?>
</select>

</label>

 <!--The submit button-->  
<label>
<span> &nbsp</span>
<input type="submit" class="button" value="Update" />
</label>



 
<?php
$i++;
}
mysql_close($dbLink); //closes the connection to the database

?>




 </form>
<form action="deleteEventProcess.php?dEvent_ID=<?php echo $eID?>" method="post">
<input type="submit" value="Delete">
</form>

<br>
<br>
<form action="viewEvents.php" method="post">
<input type="submit" value="Back">
</form>
</div>

</body>
</html>
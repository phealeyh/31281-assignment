<?php
session_start();
$uID = $_SESSION['UserID'];
$aID = $_GET['a_ID'];

if ($aID == "" || !isset($_GET['a_ID'])) {
    header("Location: viewPositions.php");
    exit;
} 

if ($uID  == "" || !isset($_SESSION['UserID'])) {
    $rURL = "Location: registerNLI.php?a_ID=" . $aID;
    header($rURL);
    
    
} 
// set the context sensitive help index
$HC = 4;
$_SESSION['HC'] = $HC;
//Defines the constants along with its values
define('DB_NAME', 's1053775_database'); //name of database
define('DB_USER', 's1053775_root'); //name of database user
define('DB_PW', 'W3arethebest'); //password
define('DB_HOST', 'localhost'); //where the database is running

//a variable created based on the connection to the sql database
$dbLink = mysql_connect(DB_HOST,DB_USER, DB_PW);
$selectedDB = mysql_select_db(DB_NAME,$dbLink); 

$login_sql="SELECT * FROM Allocated
WHERE Volunteer_ID='$uID' AND Activity_ID='$aID'";

if (!mysql_query($login_sql)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}
$check=mysql_query($login_sql);

// Determine rows returned
$confirmedUser=mysql_num_rows($check);

// If a row has been confirmed
if($confirmedUser > 0){
   $rURL = "Location: alreadyReg.php?a_ID=" . $a_ID;
    header($rURL);
} else {
  
}

?>
<!-- File: registerVolunteerRoleProcess.php
 * ------------------------
 * This html file contains the list of events within the system.
 * It is also responsible for establishing the connection between the database and requesting
 * queries about the list of events. It displays the events in a drop down box.
 -->
 
<html>
<head>

<link rel="stylesheet" type="text/css" href="buttons.css">
<link rel="stylesheet" type="text/css" href="form.css">

<?php // Date Picker Sourced From http://jqueryui.com/datepicker/ 
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script>
$(function() {
  $( "#datepicker" ).datepicker();
});
</script>


</head>
<body>

<div id="header">
<?php $currentUser = $_SESSION['Name']; ?>
<?php
if ($_SESSION['LoggedIn'] == $_SESSION['SproutCode'] || $_SESSION['LoggedIn'] ==$_SESSION['VolunteerCode']) {
    echo "Logged in as: <b>" . $currentUser . "</b>            <a href=\"logout.php\"> Log Out </a>";
} else {
    echo "Viewing as: <b>Guest</b>            <a href=\"index.php\"> Sign In</a>";
}
?>
</div>
<div id="banner">
UTS Event Management System
</div>

<div class="navAlign" id="container">
<?php 
if ($_SESSION['LoggedIn'] == $_SESSION['SproutCode'] || $_SESSION['LoggedIn'] ==$_SESSION['VolunteerCode']) {
    echo $_SESSION['Navigation'];
} else {
    echo "<ul class=\"navButton\">
         <li id=\"current\"><a href=\"viewPositions.php\">Volunteer</a></li>
         </ul>";
}
?>
</div>

<?php 



//insert the user record into the database


 
//insert the user record into the database
date_default_timezone_set('Australia/Melbourne');
$currentDate = date("Y-m-d");
$currentTime = time();
$get_SQL = mysql_query("SELECT * FROM `Activities` WHERE Activity_ID = $aID"); 


$row = mysql_fetch_array($get_SQL); //loops until the end of the events list, which should return a false

//Collect these values from the form and store them into a variable
 $eID = $row['Event_ID'];
 $aName = $row['Name']; 
 $aDescription = $row['Description']; 
 $aDuration = $row['Duration']; 
 $aPayRate = $row['PayRate']; 
 $aSDate = $row['Start_Date']; 
 $aEDate = $row['End_Date']; 
 $aSTime= $row['Start_Time']; 
 $aETime = $row['End_Time']; 
 $aPReq = $row['ActivityPeopleRequired']; 


$get_SQL = mysql_query("SELECT * FROM `Event` WHERE Event_ID = $eID"); 
$roww = mysql_fetch_array($get_SQL);
$eventName = $roww['Name'];
?>

<div class="contentBoxLong4">
<h2 id="positionTopH2">Activity Registration</h2>
<pre id="instructions">
	General Instructions
</pre>
<pre id="preAlign2">
	To register for this activity, list down your availabilities.
	If you need to add additional information, write it in the Notes section.
	Click "Submit" to register for the activity.
	</pre>
<form name=newEvent action="register.php?a_ID=<?php echo $aID; ?>"method="post" class="createUser" onsubmit="return checkForm()" id="formPosition2">
<!--Activity fields that the user must fill in-->

<h1>Activity Registration Form</h1>


<label>
<span>Event</span>
<?php echo "<b><em>" . $eventName . "</b></em>"; ?>
</label>

<label>
<span>Activity</span>
<?php echo "<b><em>" . $aName . "</b></em>"; ?>
</label>


<label>

<span>Description</span>
<?php echo "<b><em>" . $aDescription . "</b></em>"; ?>
</label>

<label>
<span>Start Date</span>
<?php echo "<b><em>" . $aSDate . "</b></em>"; ?>
</label>

<label>
<span>End Date</span>
<?php echo "<b><em>" . $aEDate . "</b></em>"; ?>
</label>

<label>
<span>Start Time</span>
<?php echo "<b><em>" . $aSTime . "</b></em>"; ?>
</label>

<label>
<span>End Time</span>
<?php echo "<b><em>" . $aETime . "</b></em>"; ?>
</label>


<label>
<span>Duration (Hr)</span>
<?php echo "<b><em>" . $aDuration . "</b></em>"; ?>
</label>

<label>
<span>People Required (General)</span>
<?php echo "<b><em>" . $aPReq . "</b></em>"; ?>
</label>

<?php
if ($aPayRate > 0) {
echo "<span>&nbsp</span>";
echo "<label>";
echo "<span>Pay Rate $</span>";
echo "<b><em>" . $aPayRate . "</b></em>";
echo "</label>";
} 
?>


<span>&nbsp</span>
<label>
<span>Availabilities:</span>
<textarea id="Av" name="Av" rows=5 cols=25></textarea>
</label>

<label>
<span>Notes:</span>
<textarea id="Notes" name="Notes" rows=5 cols=25></textarea>
</label>

<label>
<span> &nbsp</span>
<input type="submit" class="button" value="Submit" />
</label>

</form>
<?php

mysql_close($dbLink); //closes the connection to the database

?>
</div>






</body>
</html>
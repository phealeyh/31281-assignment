<?php

session_start();
$_SESSION['AdminCode'] = 103;
$_SESSION['EMCode'] = 102;
$_SESSION['SproutCode'] = 101;
$_SESSION['VolunteerCode'] = 100;
if ($_SESSION['LoggedIn'] != $_SESSION['AdminCode'] && $_SESSION['LoggedIn'] !=$_SESSION['EMCode']) {
    header("Location: index.php");
    exit;
}



$eventDraft = 0;
$eventActive = 1;

//Defines the constants along with its values
define('DB_NAME', 's1053775_database');//name of database
define('DB_USER', 's1053775_root');//name of database user
define('DB_PW', 'W3arethebest'); //password
define('DB_HOST', 'localhost'); //where the database is running

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
//Collect these values from the form and store them into a variable
$eID = $_POST['Event_ID'];
$eID = mysql_real_escape_string($eID);
$eSDate = $_POST['Start_Date'];
$eSDate = date("Y-m-d", strtotime($eSDate));
$eSDate = mysql_real_escape_string($eSDate);
$eEDate = $_POST['End_Date'];
$eEDate = date("Y-m-d", strtotime($eEDate));
$eEDate = mysql_real_escape_string($eEDate);
$eSTime = $_POST['timeH']. ":" . $_POST['timeM'] . ":00";
$eLocation = $_POST['Location'];
$eLocation = mysql_real_escape_string($eLocation);
$ePUA = $_POST['PUA'];
$ePUA = mysql_real_escape_string($ePUA);
$eName = $_POST['Name'];
$eName = mysql_real_escape_string($eName);
$eDescription = $_POST['Description'];
$eDescription = mysql_real_escape_string($eDescription);



//validate dates
date_default_timezone_set('Australia/Melbourne'); 
$currentDate = date("Y-m-d");

//$eSCDate = date("Y-m-d"$eSDate);
if($eSDate > '1998-01-01') {

	if($currentDate > $eSDate) {
           echo '<script type="text/javascript">
	   window.alert("Invalid Start Date Entered!");
           window.location = "addEvents.php";
	   </script>';
	   die('Error: Invalid Dates Entered!');
		
	} 
} else {
   $eSDate = null;  
}

//$eECDate = date($eEDate);
if($eEDate > '1998-01-01') {

   if($currentDate > $eEDate) {
   
   echo '<script type="text/javascript">
   window.alert("Invalid End Date Entered!");
   window.location = "addEvents.php";
   </script>'; 
   die('Error: Invalid Dates Entered!');
	
   } 
   
} else {
   $eEDate = null;  
}

if ((isset($eSDate) && $eSDate != null) && (isset($eEDate) && $eEDate != null)) {
   if($eSDate > $eEDate) {
           echo '<script type="text/javascript">
	   window.alert("Invalid Dates Entered! (End date must not occur before start date!)");
           window.location = "addEvents.php";
	   </script>';
	   die('Error: Invalid Dates Entered!');
		
     } 
}


if(!empty($_POST['aManager'])) {
$eManager = $_POST['volunteer_list'];
} else {
$eManager = -1;
}

//check status
if(!empty($_POST['aPost'])) {
$eStatus = $eventActive;
} else {
$eStatus = $eventDraft;
}


//insert the event into the database
$add_SQL = "INSERT INTO `Event` 
 (Start_Date, End_Date, Location, Name, Description, Manager_ID, Start_Time, PickUp, History)
 VALUES
 ('$eSDate', '$eEDate', '$eLocation', '$eName', '$eDescription', '$eManager', '$eSTime', '$ePUA', '$eStatus')";

if (!mysql_query($add_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
    
    
}

$eID = mysql_insert_id();

//insert the event into the database
$add_SQL = "INSERT INTO `EventPending` 
 (Event_ID, Start_Date, End_Date, Location, Name, Description, Manager_ID, Start_Time, PickUp, History)
 VALUES
 ('$eID','$eSDate', '$eEDate', '$eLocation', '$eName', '$eDescription', '$eManager', '$eSTime', '$ePUA', '$eStatus')";

if (!mysql_query($add_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
    
    
}
 
/* 
//insert the event into history
$add_SQL = "INSERT INTO `Manager History` 
 (HEvent_ID, HManager_ID)
 VALUES
 ('$eID', '$eManager')";

if (!mysql_query($add_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}

//echo $eName. " " . " was successfully added " . " and will take place on " . $eDate . " at " . $eLocation . ".";
*/

mysql_close(); //close the connection to the database

$rURL = "Location: manageEvent.php?e_ID=" . $eID;
header($rURL);
exit;
?>



echo '<script type="text/javascript">
           window.alert("Event successfully added!");
           window.location = "viewEventsEM.php"
      </script>';
      
<html>      
<head>
      
<!-- File: newEventProcess.php
 * ------------------------
 * This php file is concerned with appending the event details and record
 * into the sql database based on the submitted information from the user
 -->

<link rel="stylesheet" type="text/css" href="buttons.css">
</head>
<body>

<div id="header">
<?php $currentUser = $_SESSION['Name']; ?>
Logged in as: <b><?php echo $currentUser; ?></b>            <a href="logout.php"> Log Out </a>
</div>
<div id="menu">
<ul class="navButton">



</ul>
</div>

<div id ="content">

<form action="viewEventsEM.php" method="post">
<input type="submit" value="Back"><!--creates the back button-->
</form>

</div>

</body>
</html>
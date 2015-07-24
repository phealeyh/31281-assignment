<?php
session_start();
$_SESSION['AdminCode'] = 103;
$_SESSION['EMCode'] = 102;
$_SESSION['SproutCode'] = 101;
$_SESSION['VolunteerCode'] = 100;

if ($_SESSION['LoggedIn'] != $_SESSION['AdminCode'] && $_SESSION['LoggedIn'] !=$_SESSION['EMCode']) {
    header("Location: index.php");
} 


$eID= $_GET['e_ID'];

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

$eID = $_GET['e_ID'];
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

//put in pending table
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

//pend the event
$update_SQL = "UPDATE `EventPending` 
 SET Start_Date = '$eSDate', End_Date = '$eEDate', Location = '$eLocation', Name = '$eName', Description = '$eDescription', Manager_ID = '$eManager',
 Start_Time = '$eSTime', PickUP = '$ePUA', History = '$eStatus'
 WHERE Event_ID = '$eID'";

if (!mysql_query($update_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}




$pEID = mysql_insert_id();

//validate dates 
date_default_timezone_set('Australia/Melbourne');
$currentDate = date("Y-m-d");
if($eSDate >'1998-01-01') {

	if($currentDate > $eSDate) {
           $rURL = "Location: updateEventP.php?e_ID=" . $eID . "&m=Start date can not be in the past!";
           header($rURL);
           exit;
		
	} else {
	  //echo "y1";
	}
} else {
 $eSDate = null;
}

if($eEDate > '1998-01-01') {

	if($currentDate > $eEDate) {
           $rURL = "Location: updateEventP.php?e_ID=" . $eID . "&m=End date can not be in the past!";
           header($rURL);
           exit;
		
	} 
} else {

   $eEDate = null;
}

if ((isset($eSDate) && $eSDate != null) && (isset($eEDate) && $eEDate != null)) {
   if($eSDate > $eEDate) {
           $rURL = "Location: updateEventP.php?e_ID=" . $eID . "&m=End date must succeed Start date!";
           header($rURL);
           exit;
		
	} 
}


//insert the user record into the database
$update_SQL = "UPDATE `Event` 
 SET Start_Date = '$eSDate', End_Date = '$eEDate', Location = '$eLocation', Name = '$eName', Description = '$eDescription', Manager_ID = '$eManager',
 Start_Time = '$eSTime', PickUP = '$ePUA', History = '$eStatus'
 WHERE Event_ID = '$eID'";

if (!mysql_query($update_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}






$rURL = "Location: manageEvent.php?e_ID=" . $eID;
header($rURL);


mysql_close(); //close the connection to the database
?>
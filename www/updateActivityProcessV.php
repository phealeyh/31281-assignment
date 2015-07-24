<?php
session_start();
$_SESSION['AdminCode'] = 103;
$_SESSION['EMCode'] = 102;
$_SESSION['SproutCode'] = 101;
$_SESSION['VolunteerCode'] = 100;

if ($_SESSION['LoggedIn'] != $_SESSION['AdminCode'] && $_SESSION['LoggedIn'] !=$_SESSION['EMCode']) {
    header("Location: index.php");
} 


$aID= $_GET['a_ID'];

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

$aName = $_POST['Name']; 
$aSDate = $_POST['Start_Date'];
$aSDate = date("Y-m-d", strtotime($aSDate));
$aSDate = mysql_real_escape_string($aSDate);
$aEDate = $_POST['End_Date'];
$aEDate = date("Y-m-d", strtotime($aEDate));
$aEDate = mysql_real_escape_string($aEDate);
$aSTime = $_POST['timeH']. ":" . $_POST['timeM'] . ":00";
$aETime = $_POST['timeH2']. ":" . $_POST['timeM2'] . ":00";
$eLocation = $_POST['Location'];
$eLocation = mysql_real_escape_string($eLocation);
$ePUA = $_POST['PUA'];
$ePUA = mysql_real_escape_string($ePUA);
$eName = $_POST['Name'];
$eName = mysql_real_escape_string($eName);
$eDescription = $_POST['Description'];
$eDescription = mysql_real_escape_string($eDescription);
$aPReq = $_POST['PRG'];
$aPReq = mysql_real_escape_string($aPReq);
$aDuration = $_POST['Duration'];
$aDuration = mysql_real_escape_string($aDuration);
$aPayRate = $_POST['PayRate']; 
$aPayRate = mysql_real_escape_string($aPayRate);

//put in pending table
if(!empty($_POST['aManager'])) {
$aPayRate = $_POST['PayRate'];
} else {
$aPayRate = 0.00;
}

if(!empty($_POST['aSprout'])) {
$aSprout = 1;
} else {
$aSprout = 0;
}

//pend the event
if  ($aPayRate == null)
{
    $update_SQL = "UPDATE `ActivitiesAddPending` 
     SET Start_Date = '$aSDate', End_Date = '$aEDate', Name = '$aName', Description = '$eDescription', ActivityPeopleRequired = '$aPReq',
     Start_Time = '$aSTime', End_Time = '$aETime', Duration = '$aDuration', SproutOnly = '$aSprout'
     WHERE Activity_ID = '$aID'";
} else {
    $update_SQL = "UPDATE `ActivitiesAddPending` 
     SET Start_Date = '$aSDate', End_Date = '$aEDate', Name = '$aName', Description = '$eDescription', ActivityPeopleRequired = '$aPReq',
     Start_Time = '$aSTime', End_Time = '$aETime', Duration = '$aDuration', SproutOnly = '$aSprout', PayRate='$aPayRate'
     WHERE Activity_ID = '$aID'";
}


if (!mysql_query($update_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}




$pEID = mysql_insert_id();

//validate dates
date_default_timezone_set('Australia/Melbourne'); 
$currentDate = date("Y-m-d");
if($aSDate > '1998-01-01') {

	if($currentDate > $aSDate) {
           $rURL = "Location: updateActivityP.php?a_ID=" . $aID;
           header($rURL);
           exit;
		
	} else {
	  //echo "y1";
	}
} else {
   $aSDate = null;  
}

if($aEDate > '1998-01-01') {

	if($currentDate > $aEDate) {
           $rURL = "Location: updateActivityP.php?a_ID=" . $aID;
           header($rURL);
           exit;
		
	} 
} else {
   $aEDate = null;  
}

if ((isset($aSDate) && $aSDate != null) && (isset($aEDate) && $aEDate != null)) {
   if($aSDate > $aEDate) {
           $rURL = "Location: updateActivityP.php?a_ID=" . $aID;
           header($rURL);
           exit;
		
	} 
}

if ($aSTime != '00:00:00' && $aETime != '00:00:00') {
   if($aSTime > $aETime) {
           $rURL = "Location: updateActivityP.php?a_ID=" . $aID;
           header($rURL);
           exit;
		
	} 
}


//insert the user record into the database
if  ($aPayRate == null)
{
    $update_SQL = "UPDATE `Activities` 
 SET Start_Date = '$aSDate', End_Date = '$aEDate', Name = '$aName', Description = '$eDescription', ActivityPeopleRequired = '$aPReq',
 Start_Time = '$aSTime', End_Time = '$aETime', Duration = '$aDuration', SproutOnly = '$aSprout'
 WHERE Activity_ID = '$aID'";
} else {
    $update_SQL = "UPDATE `Activities` 
 SET Start_Date = '$aSDate', End_Date = '$aEDate', Name = '$aName', Description = '$eDescription', ActivityPeopleRequired = '$aPReq',
 Start_Time = '$aSTime', End_Time = '$aETime', Duration = '$aDuration', SproutOnly = '$aSprout', PayRate='$aPayRate'
 WHERE Activity_ID = '$aID'";
}


if (!mysql_query($update_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}

$rURL = "Location: manageActivity.php?a_ID=" . $aID;
header($rURL);


mysql_close(); //close the connection to the database
?>
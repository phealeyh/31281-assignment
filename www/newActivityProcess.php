<?php

session_start();
$_SESSION['AdminCode'] = 103;
$_SESSION['EMCode'] = 102;
$_SESSION['SproutCode'] = 101;
$_SESSION['VolunteerCode'] = 100;
if ($_SESSION['LoggedIn'] != $_SESSION['AdminCode'] && $_SESSION['LoggedIn'] !=$_SESSION['EMCode']) {
    header("Location: index.php");
}


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
$aName = $_POST['Name'];
$aD = $_POST['Description'];
$aD = mysql_real_escape_string($aD);
$aSDate = $_POST['Start_Date'];
$aSDate = date("Y-m-d", strtotime($aSDate));
$aSDate = mysql_real_escape_string($aSDate);
$aEDate = $_POST['End_Date'];
$aEDate = date("Y-m-d", strtotime($aEDate));
$aEDate = mysql_real_escape_string($aEDate);
$aSTime = $_POST['timeH']. ":" . $_POST['timeM'] . ":00";
$aETime = $_POST['timeH2']. ":" . $_POST['timeM2'] . ":00";
$aDuration = $_POST['Duration'];
$aDuration = mysql_real_escape_string($aDuration);
$aPReq = $_POST['PRG'];
$aPReq = mysql_real_escape_string($aPReq);

$getSQL = "SELECT * FROM Event
WHERE Event_ID = '$eID'";
$row = mysql_fetch_array(mysql_query($getSQL));
$eSDate = $row['Start_Date'];
$eEDate = $row['End_Date'];

if(!empty($_POST['aManager'])) {
$aPayRate = $_POST['PayRate'];
} else {
$aPayRate = 0;
}

if(!empty($_POST['aSprout'])) {
$aSprout = 1;
} else {
$aSprout = 0;
}

//validate dates 
date_default_timezone_set('Australia/Melbourne');
$currentDate = date("Y-m-d");
//echo  "<script type='text/javascript'>
///alert(\"$currentDate\");
//</script>";

if($aSDate > '1998-01-01') {

	if($currentDate > $aSDate) {
           echo "<script type='text/javascript'>
           var rURL = \"$eID\";
           var name = \"&n=$aName\";
           var description = \"&d=$aD\";
           var sd = \"&sd=$aSDate\";
           var ed = \"&ed=$aEDate\";
           var st = \"&st=$aSTime\";
           var et = \"&et=$aETime\";
           var duration = \"&du=$aDuration\";
           var pay = \"&pr=$aPayRate\";
           var pr = \"&rq=$aPReq\";
           var message = '&m=Invalid Start Date Entered!';
           var rURL = \"addActivities.php?e_ID=\" + rURL + name + description + duration + pay + sd + ed + st + et + pr + message;
	   window.alert('Invalid Start Date Entered!');
           window.location = rURL;
	   </script>";
	   die('Error: Invalid Dates Entered!');
		
	} else if ($aSDate < $eSDate || $aSDate > $eEDate) {
	   echo "<script type='text/javascript'>
           var rURL = \"$eID\";
           var name = \"&n=$aName\";
           var description = \"&d=$aD\";
           var sd = \"&sd=$aSDate\";
           var ed = \"&ed=$aEDate\";
           var st = \"&st=$aSTime\";
           var et = \"&et=$aETime\";
           var duration = \"&du=$aDuration\";
           var pay = \"&pr=$aPayRate\";
           var pr = \"&rq=$aPReq\";
           var message = '&m=Dates must fall within Event Dates!';
           var rURL = \"addActivities.php?e_ID=\" + rURL + name + description + duration + pay + sd + ed + st + et + pr + message;
	   window.alert('Dates must fall within Event Dates!');
           window.location = rURL;
	   </script>";
	   die('Error: Invalid Dates Entered!');
	}
} else {
   $aSDate = null;  
}


 if($aEDate > '1998-01-01') {

	if($currentDate > $aEDate) {
           echo "<script type='text/javascript'>
           var rURL = \"$eID\";
           var name = \"&n=$aName\";
           var description = \"&d=$aD\";
           var sd = \"&sd=$aSDate\";
           var ed = \"&ed=$aEDate\";
           var st = \"&st=$aSTime\";
           var et = \"&et=$aETime\";
           var duration = \"&du=$aDuration\";
           var pay = \"&pr=$aPayRate\";
           var pr = \"&rq=$aPReq\";
           var message = '&m=Invalid End Date Entered!';
           var rURL = \"addActivities.php?e_ID=\" + rURL + name + description + duration + pay + sd + ed + st + et + pr + message;
	   window.alert('Invalid End Date Entered!');
           window.location = rURL;
	   </script>";
	   die('Error: Invalid Dates Entered!');
	   
        } else if ($aEDate < $eSDate || $aEDate > $eEDate) {
	   echo "<script type='text/javascript'>
           var rURL = \"$eID\";
           var name = \"&n=$aName\";
           var description = \"&d=$aD\";
           var sd = \"&sd=$aSDate\";
           var ed = \"&ed=$aEDate\";
           var st = \"&st=$aSTime\";
           var et = \"&et=$aETime\";
           var duration = \"&du=$aDuration\";
           var pay = \"&pr=$aPayRate\";
           var pr = \"&rq=$aPReq\";
           var message = '&m=Dates must fall within Event Dates!';
           var rURL = \"addActivities.php?e_ID=\" + rURL + name + description + duration + pay + sd + ed + st + et + pr + message;
	   window.alert('Dates must fall within Event Dates!!');
           window.location = rURL;
	   </script>";
	   die('Error: Invalid Dates Entered!');
	}
	
} else {
   $aEDate = null;  
}

if ((isset($aSDate) && $aSDate != null) && (isset($aEDate) && $aEDate != null)) {
   if($aSDate > $aEDate) {
           echo "<script type='text/javascript'>
           var rURL = \"$eID\";
           var name = \"&n=$aName\";
           var description = \"&d=$aD\";
           var sd = \"&sd=$aSDate\";
           var ed = \"&ed=$aEDate\";
           var st = \"&st=$aSTime\";
           var et = \"&et=$aETime\";
           var duration = \"&du=$aDuration\";
           var pay = \"&pr=$aPayRate\";
           var pr = \"&rq=$aPReq\";
           var message = '&m=End Date must succeed start date!';
           var rURL = \"addActivities.php?e_ID=\" + rURL + name + description + duration + pay + sd + ed + st + et + pr + message;
	   window.alert('End Date must succeed start date!');
           window.location = rURL;
	   </script>";
	   die('Error: Invalid Dates Entered!');
		
	} 
}

if ($aSTime != '00:00:00' && $aETime != '00:00:00') {
   if($aSTime > $aETime) {
           echo "<script type='text/javascript'>
           var rURL = \"$eID\";
           var name = \"&n=$aName\";
           var description = \"&d=$aD\";
           var sd = \"&sd=$aSDate\";
           var ed = \"&ed=$aEDate\";
           var st = \"&st=$aSTime\";
           var et = \"&et=$aETime\";
           var duration = \"&du=$aDuration\";
           var pay = \"&pr=$aPayRate\";
           var pr = \"&rq=$aPReq\";
           var message = '&m=End Time must succeed Start Time!';
           var rURL = \"addActivities.php?e_ID=\" + rURL + name + description + duration + pay + sd + ed + st + et + pr + message;
	   window.alert('End Time must succeed Start Time!');
           window.location = rURL;
	   </script>";
	   die('Error: Invalid Times Entered!');
		
	} 
}



//insert the event into the database
$add_SQL = "INSERT INTO `Activities` 
 (Event_ID, Name, Description,
 Start_Date, End_Date, Start_Time, End_Time, Duration, PayRate, ActivityPeopleRequired, SproutOnly )
 VALUES
 ('$eID', '$aName', '$aD', '$aSDate', 
 '$aEDate', '$aSTime', 
 '$aETime', '$aDuration', '$aPayRate', '$aPReq', '$aSprout')";

if (!mysql_query($add_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}

$aID = mysql_insert_id();

$add_SQL = "INSERT INTO `ActivitiesAddPending` 
 (Activity_ID, Event_ID, Name, Description,
 Start_Date, End_Date, Start_Time, End_Time, Duration, PayRate, ActivityPeopleRequired, SproutOnly )
 VALUES
 ('$aID', '$eID', '$aName', '$aD', '$aSDate', 
 '$aEDate', '$aSTime', 
 '$aETime', '$aDuration', '$aPayRate', '$aPReq', '$aSprout')";


if (!mysql_query($add_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}

//echo $aName. " " . " was successfully added " . " and will start on the " . $aStart . " and end on the " . $eEnd . ".";

mysql_close(); //close the connection to the database


echo "<script type='text/javascript'>
           var rURL = \"$aID\";
           var rURL = \"manageActivity.php?a_ID=\" + rURL;
           window.location = rURL;
	   </script>";
?>
<!-- File: newActivityProcess.php
 * ------------------------
 * This php file is concerned with appending the activity details and records it
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

<li><a href="createVolunteer.html">Dashboard</a></li>
<li><a href="viewEvents.php">Events</a></li>
<li><a href = "viewVolunteers.php">Volunteers</a></li>
<li id="current"><a href = "viewActivities.php">Activities</a></li>
<li><a href = "viewRoles.php">Roles</a></li>

</ul>
</div>

<div id ="content">



<form action="manageActivity.php?a_ID=<?php echo $aID; ?>" method="post">
<input type="submit" value="Back"><!--creates the back button-->
</form>

</div>

</body>
</html>
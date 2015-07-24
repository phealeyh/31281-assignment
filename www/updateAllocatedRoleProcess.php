<?php

session_start();
$_SESSION['AdminCode'] = 103;
$_SESSION['EMCode'] = 102;
$_SESSION['SproutCode'] = 101;
$_SESSION['VolunteerCode'] = 100;
if ($_SESSION['LoggedIn'] != $_SESSION['AdminCode'] && $_SESSION['LoggedIn'] !=$_SESSION['EMCode']) {
    header("Location: index.php");
}


$uID = $_GET['u_ID']; 
$aID = $_GET['a_ID'];
//Defines the constants along with its values
define('DB_NAME', 's1053775_database'); //name of database
define('DB_USER', 's1053775_root'); //name of database user
define('DB_PW', 'W3arethebest'); //password
define('DB_HOST', 'localhost'); //where the database is running

//a variable created based on the connection to the sql database
$dbLink = mysql_connect(DB_HOST,DB_USER, DB_PW);
$selectedDB = mysql_select_db(DB_NAME,$dbLink); 

$get_SQL = mysql_query("SELECT * FROM `Allocated` 
 WHERE Activity_ID = $aID
 AND Allocated = 1"); 
$confirmedUser=mysql_num_rows($get_SQL);

$get_SQL = mysql_query("SELECT * FROM `Activities` 
 WHERE Activity_ID = $aID"); 
$row = mysql_fetch_array($get_SQL);


$aName = $row['Name'];
$aReq =  $row['ActivityPeopleRequired'];

if ($confirmedUser >= $aReq) {
   $rURL = "Location: manageActivity.php?a_ID=" . $aID;
   header($rURL);
}

$update_SQL = "UPDATE `Allocated` 
 SET Allocated = '0'
 WHERE Activity_ID=$aID
 AND Volunteer_ID = $uID";
 
if (!mysql_query($update_SQL)) { //checks if there is a valid record selected; if not, execute statement
  die('Error: ' . mysql_error());
} 


/*
$update_SQL ="DELETE FROM `Registered` 
 WHERE Role_ID = $rID 
 AND Volunteer_ID = $uID";
 
if (!mysql_query($update_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}
*/

$get_SQL = mysql_query("SELECT * FROM `User Details` 
 WHERE User_ID = $uID"); 
$row = mysql_fetch_array($get_SQL);

$emailTo = $row['Primary_Email'];
$greeted = $row['Given_Names'];




$subject = "Registration for " . $aName;
$message = "Hi " . $greeted . ",

This is to inform you that you have been de-allocated for the activity!

Details:

Activity: " . $aName;

$headers = "From: UTS EMS";
mail($emailTo,$subject,$message, $headers);

mysql_close($dbLink); //closes the connection to the database

$rURL = "Location: manageActivity.php?a_ID=" . $aID;
header($rURL);
?>
<!-- File: updateRegisteredUserProcess.php
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

<div class="navAlign" id="container">
<?php echo $_SESSION['Navigation']; ?>
</div>



</body>
</html>
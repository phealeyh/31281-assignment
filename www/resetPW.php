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
//Defines the constants along with its values
define('DB_NAME', 's1053775_database'); //name of database
define('DB_USER', 's1053775_root'); //name of database user
define('DB_PW', 'W3arethebest'); //password
define('DB_HOST', 'localhost'); //where the database is running

//a variable created based on the connection to the sql database
$dbLink = mysql_connect(DB_HOST,DB_USER, DB_PW);
$selectedDB = mysql_select_db(DB_NAME,$dbLink); 


/*
$update_SQL ="DELETE FROM `Registered` 
 WHERE Role_ID = $rID 
 AND Volunteer_ID = $uID";
 
if (!mysql_query($update_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}
*/
// get the user details from the User Details Table
$getSQL = mysql_query("SELECT * FROM `Account` 
 WHERE UTS_ID = $uID"); 

// Store user getSQL quer results as an array
$row = mysql_fetch_array($getSQL);
$privilege = $row['Privilege'];

$getSQL = mysql_query("SELECT * FROM `User Details` 
 WHERE User_ID = $uID"); 

// Store user getSQL quer results as an array
$row = mysql_fetch_array($getSQL);

//collect the primary email and user given names for sending
$emailTo = $row['Primary_Email'];
$greetName = $row['Given_Names'];

if ($emailTo == null || $emailTo == "") {

    if($privilege >=2) {
        $rURL = "Location: updateUserEM.php?u_ID=" . $uID;
        header($rURL);
        exit;    
    } else {
        $rURL = "Location: updateUserV.php?u_ID=" . $uID;
        header($rURL);
        exit; 
    }
}
$newPW = md5(uniqid(rand(), true));

$update_SQL = "UPDATE `Account` 
 SET Password = '$newPW'
 WHERE UTS_ID = '$uID'";
 
if (!mysql_query($update_SQL)) { //checks if there is a valid record selected; if not, execute statement
  die('Error: ' . mysql_error());
} 


$subject = "UTS EMS Password Reset";
$message = "Hi " . $greetName . ",

Your password has been reset to: " . $newPW . "

Please update this to a password of your choice through your preferences.";

$headers = "From: UTS EMS";
mail($emailTo,$subject,$message, $headers);

mysql_close($dbLink); //closes the connection to the database

$rURL = "Location: viewUsers.php";
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
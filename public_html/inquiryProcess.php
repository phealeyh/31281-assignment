<?php

session_start();
$_SESSION['AdminCode'] = 103;
$_SESSION['EMCode'] = 102;
$_SESSION['SproutCode'] = 101;
$_SESSION['VolunteerCode'] = 100;
if ($_POST['volunteer_list'] == null) {
    header("Location: viewVolunteers.php");
}


$uID = $_POST['volunteer_list'];

//Defines the constants along with its values
define('DB_NAME', 's1053775_database'); //name of database
define('DB_USER', 's1053775_root'); //name of database user
define('DB_PW', 'W3arethebest'); //password
define('DB_HOST', 'localhost'); //where the database is running

//a variable created based on the connection to the sql database
$dbLink = mysql_connect(DB_HOST,DB_USER, DB_PW);
$selectedDB = mysql_select_db(DB_NAME,$dbLink); 


$get_SQL = mysql_query("SELECT * FROM `User Details` 
 WHERE User_ID = $uID"); 
$row = mysql_fetch_array($get_SQL);

$emailTo = $row['Primary_Email'];
$greeted = $row['Given_Names'];




$subject = $_POST['Topic'];
$message = $_POST['Av'];
$message = mysql_real_escape_string($message);

$headers = "From: UTS EMS Inquiries " . $_SESSION['UserID'];
mail($emailTo,$subject,$message, $headers);

mysql_close($dbLink); //closes the connection to the database

$rURL = "Location: viewPositions.php";
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
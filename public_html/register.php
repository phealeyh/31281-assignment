<?php
session_start();
$uID = $_SESSION['UserID'];
$aID = $_GET['a_ID'];
if ($aID == "" || !isset($_GET['a_ID'])) {
    header("Location: viewPositions.php");
    exit;
} 

if ($uID  == "" || !isset($_SESSION['UserID'])) {
    $rURL = "Location: registerNLI.php?a_ID=" . $a_ID;
    header($rURL);
    exit;
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

//Defines the constants along with its values
define('DB_NAME', 's1053775_database'); //name of database
define('DB_USER', 's1053775_root'); //name of database user
define('DB_PW', 'W3arethebest'); //password
define('DB_HOST', 'localhost'); //where the database is running

//a variable created based on the connection to the sql database
$dbLink = mysql_connect(DB_HOST,DB_USER, DB_PW);
$selectedDB = mysql_select_db(DB_NAME,$dbLink); 

//insert the user record into the database

 
//insert the user record into the database
date_default_timezone_set('Australia/Melbourne');
$currentDate = date('Y-m-d h:i:s', time());
echo $currentDate ;
$aV = $_POST['Av'];
$aV = mysql_real_escape_string($aV);
$notes = $_POST['Notes'];
$update_SQL = "INSERT INTO `Allocated`
(Volunteer_ID, Activity_ID, TimeStamp, Availabilities, Notes)  
 Values ($uID, $aID, '$currentDate', '$aV', '$notes')";
 
if (!mysql_query($update_SQL)) { //checks if there is a valid record selected; if not, execute statement
  die('Error: ' . mysql_error());
} 

 




$get_SQL = "SELECT * FROM `User Details`
WHERE User_ID = $uID";

 
if (!mysql_query($get_SQL)) { //checks if there is a valid record selected; if not, execute statement
  die('Error: ' . mysql_error());
}

$get_SQL = mysql_query("SELECT * FROM `User Details` 
 WHERE User_ID = $uID"); 
$row = mysql_fetch_array($get_SQL);

$emailTo = $row['Primary_Email'];
$greeted = $row['Given_Names'];

$get_SQL = mysql_query("SELECT * FROM `Activities` 
 WHERE Activity_ID = $aID");
 
$row = mysql_fetch_array($get_SQL);

$aName = $row['Name'];


$subject = "Registration for " . $aName;
$message = "Hi " . $greeted . ", 
This is to confirm that we have received your activity registration! We will review your application and inform you if you are allocated for the role as soon as possible.";

//echo " Registration Successful!!";
$headers = "From: UTS EMS";
mail($emailTo,$subject,$message, $headers);
mysql_close($dbLink); //closes the connection to the database

echo '<script type="text/javascript">
           alert("Thank you for registering!");
           window.location = "viewPositions.php"
      </script>';
?>




</body>
</html>
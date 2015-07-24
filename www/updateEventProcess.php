<?php

session_start();
if ($_SESSION['LoggedIn'] != $_SESSION['AdminCode'] && $_SESSION['LoggedIn'] !=$_SESSION['EMCode']) {
    header("Location: index.php");
}

?>
<!-- File: updateEventProcess.php
 * ------------------------
 * This php file is concerned with updating the event details and records them
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

</div>

<div id ="content">
<?php $eID= $_GET['e_ID']; ?>
<?php
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
$eSDate = mysql_real_escape_string($eSDate);
$eSTime = $_POST['Start_Time'];
$eSTime = mysql_real_escape_string($eSTime);
$eEDate = $_POST['End_Date'];
$eEDate = mysql_real_escape_string($eEDate);
$eLocation = $_POST['Location'];
$eLocation = mysql_real_escape_string($eLocation);
$ePUA = $_POST['PUA'];
$ePUA = mysql_real_escape_string($ePUA);
$eName = $_POST['Name'];
$eName = mysql_real_escape_string($eName);
$eDescription = $_POST['Description'];
$eDescription = mysql_real_escape_string($eDescription);

//validate dates 
$currentDate = date("Y-m-d");
$eSCDate = date($eSDate);
if(isset($eSDate) && $eSDate != null) {

	if($currentDate > $eSCDate) {
           echo '<script type="text/javascript">
	   window.alert("Invalid Start Date Entered!");
           window.location = "updateEventV.php";
	   </script>';
	   die('Error: Invalid Dates Entered!');
		
	} 
}

$eECDate = date($eEDate);
if(isset($eEDate) && $eEDate != null) {

	if($currentDate > $eECDate) {
           echo '<script type="text/javascript">
	   window.alert("Invalid End Date Entered!");
           window.location = "updateEventV.php";
	   </script>';
	   die('Error: Invalid Dates Entered!');
		
	} 
}

if ((isset($eSDate) && $eSDate != null) && (isset($eEDate) && $eEDate != null)) {
   if($eSCDate > $eECDate) {
           echo '<script type="text/javascript">
	   window.alert("Invalid Dates Entered! (End date must not occur before start date!)");
           window.location = "updateEventV.php";
	   </script>';
	   die('Error: Invalid Dates Entered!');
		
	} 
}

//insert the user record into the database
$update_SQL = "UPDATE `Event` 
 SET Start_Date = '$eSDate', End_Date = '$eEDate', Location = '$eLocation', Name = '$eName', Description = '$eDescription', Manager_ID = '$eManager',
 Start_Time = '$eSTime', PickUP = '$ePUA'
 WHERE Event_ID = '$eID'";

if (!mysql_query($update_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}

$update_SQL = "UPDATE `Manager History` 
 SET HEvent_ID = '$eID',  HManager_ID = '$eManager'
 WHERE HEvent_ID = '$eID'";

if (!mysql_query($update_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}

mysql_close(); //close the connection to the database
echo '<script type="text/javascript">
	   window.alert("Event Updated!");
           window.location = "manageEvent.php";
      </script>';

echo "Event " . $eID . " named " . $eName . " successfully updated";

mysql_close(); //close the connection to the database
?>

<form action="viewEvents.php" method="post">
<input type="submit" value="Back"><!--creates the back button-->
</form>

</div>

</body>
</html>
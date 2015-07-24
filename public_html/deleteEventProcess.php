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
$eID = $_GET['dEvent_ID'];




// Begin deletion
$update_SQL = "DELETE FROM `Event` 
 WHERE Event_ID = '$eID'";

if (!mysql_query($update_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}

$update_SQL = "DELETE FROM `EventPending` 
 WHERE Event_ID = '$eID'";

if (!mysql_query($update_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}

$update_SQL = "DELETE FROM `ActivitiesAddPending` 
 WHERE Event_ID = '$eID'";

if (!mysql_query($update_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}
$i=0;
$activitiesSQL = mysql_query("SELECT * from Activities WHERE Event_ID = '$eID'");
while($row = mysql_fetch_array($activitiesSQL)) {
     $aID = $row['Activity_ID'];
     $update_SQL = mysql_query("DELETE FROM `Allocated` 
     WHERE Activity_ID = '$aID'");
     $i++;
 }

$update_SQL = "DELETE FROM `Activities` 
 WHERE Event_ID = '$eID'";

if (!mysql_query($update_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}


$update_SQL = "DELETE FROM `Role` 
 WHERE Event_ID = '$eID'";

if (!mysql_query($update_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}



mysql_close(); //close the connection to the database

$rURL = "Location: viewEventsEM.php";
           header($rURL);
           exit;

echo '<script type="text/javascript">
	   window.alert("Event Deleted!");
           window.location = "viewEventsEM.php"
      </script>';

?>

<!-- File: = * ------------------------
 * This php file is concerned with deleting the chosen event from the database
 -->
<head>
<link rel="stylesheet" type="text/css" href="buttons.css">


</head>
<body>

<div id="header">
<?php $currentUser = $_SESSION['Name']; ?>
Logged in as: <b><?php echo $currentUser; ?></b>            <a href="logout.php"> Log Out </a>
</div>

<div id="menu">
<?php echo $_SESSION['Navigation']; ?>
</div>

<div id ="content">



<form action="viewEvents.php" method="post">
<input type="submit" value="Back"><!--creates the back button-->
</form>

</div>

</body>
</html>
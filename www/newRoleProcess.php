<!-- File: newRoleProcess.php
 * ------------------------
 * This php file is concerned with appending the activity details and records it
 * into the sql database based on the submitted information from the user
 -->

<link rel="stylesheet" type="text/css" href="buttons.css">
</head>
<body>

<div id="header">
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
$rID = $_POST['Role_ID'];
$eID = $_GET['e_ID'];
$aID = $_GET['a_ID'];
$rName = $_POST['Name'];
$rD = $_POST['Description'];
$rStart = $_POST['Start_Date'];
$rEnd = $_POST['End_Date'];
$rTStart = $_POST['Start_Time'];
$rTEnd = $_POST['End_Time'];
$rPosReq = $_POST['Positions_Required'];

//insert the event into the database
$add_SQL = "INSERT INTO `Role` 
 (Activity_ID, Event_ID, Role_ID, Role_Name, Description,
 Start_Date, End_Date, Start_Time, End_Time, Positions_Required)
 VALUES
 ('$aID', '$eID', '$rID', '$rName', '$rD', '$rStart', 
 '$rEnd', '$rTStart', 
 '$rTEnd', '$rPosReq')";

if (!mysql_query($add_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}


echo $aID . " " . " was successfully added " . " and will start on the " . $rStart . " and end on the " . $rEnd . ".";

mysql_close(); //close the connection to the database
?>

<form action="manageActivity.php" method="post">
<input type="submit" value="Back"><!--creates the back button-->
</form>

</div>

</body>
</html>
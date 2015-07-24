<?php
session_start();
if (!$_SESSION['LoggedIn'] == 101) {
    header("Location: index.php");
} 
?>
<!-- File: viewVolunteerRoleDetail.php
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
<div id="banner">
UTS Event Management System
</div>
<div class="navAlign" id="container">
<ul class="navButton">

<li><a href="dashboard.php">Dashboard</a></li>
<li id="current"><a href="viewEvents.php">Events</a></li>
<li><a href = "viewVolunteers.php">Volunteers</a></li>
<li><a href = "viewActivities.php">Activities</a></li>
<li><a href = "viewRoles.php">Roles</a></li>
</ul>

<?php 
$rID = $_POST['role_list']; 
//Defines the constants along with its values
define('DB_NAME', 's1053775_database'); //name of database
define('DB_USER', 's1053775_root'); //name of database user
define('DB_PW', 'W3arethebest'); //password
define('DB_HOST', 'localhost'); //where the database is running

//a variable created based on the connection to the sql database
$dbLink = mysql_connect(DB_HOST,DB_USER, DB_PW);
mysql_select_db(DB_NAME,$dbLink); 

//insert the user record into the database


 

//insert the user record into the database
$get_SQL = mysql_query("SELECT * FROM `Role` 
 WHERE Role_ID = $rID"); 

//if (!mysql_query($get_SQL)) { //checks if there is a valid record selected; if not, execute statement
//    die('Error: ' . mysql_error());
//}

$i=0;

$row = mysql_fetch_array($get_SQL);


$gN = $row['Role_Name'];
$gD = $row['Description'];
$gSD = $row['Start_Date'];
$gED = $row['End_Date'];
$gTSD = $row['Start_Time'];
$gTED = $row['End_Time'];
$eID = $row['Event_ID'];
$aID = $row['Activity_ID'];
$rPosReq = $row['Positions_Required'];

$get_SQL = mysql_query("SELECT COUNT(*) as Con FROM `Allocated` 
 WHERE Role_ID = $rID"); 
 
$row = mysql_fetch_array($get_SQL);
$rPosAll = $row['Con'];
 
mysql_close($dbLink); //closes the connection to the database
?>

</div>

<div class="contentBox">
	<h2> <?php echo $gN . $rID; ?> </h2>
	<h3> Start Date: </h3> <?php echo $gSD; ?> 
	<h3> End Date: </h3> <?php echo $gED; ?> 
	<h3> Start Time: </h3> <?php echo $gTSD; ?> 
	<h3> End Time: </h3> <?php echo $gTED; ?> 
	<p>  <?php echo $gD; ?> </p>
	<h4> Positions Filled: <b><?php echo $rPosAll; ?></b> / <?php echo $rPosReq; ?>
	<form action="registerVolunteerRoleProcess.php?r_ID=<?php echo $rID; ?>" method="post">
        <input type="submit" value="Register">
</form>
	
</div>


</body>
</html>
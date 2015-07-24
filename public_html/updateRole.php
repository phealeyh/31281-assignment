<!-- File: updateRole.php
 * ------------------------
 * This php file will be concerned with gathering the details of a new volunteer
 * and then submitting that information to the newUserProcess php file. This page will
 * display fields for the volunteer to enter and submit.
 -->
 
<html>
<head>

<link rel="stylesheet" type="text/css" href="buttons.css">
</head>
<body>

<div id="header">
</div>

<div id="banner">
UTS Event Management System
</div>


<div class="navAlign" id="container">
<ul class="navButton">

<li><a href="dashboard.php">Dashboard</a></li>
<li><a href="viewEvents.php">Events</a></li>
<li><a href = "viewVolunteers.php">Volunteers</a></li>
<li><a href = "viewActivities.php">Activities</a></li>
<li id="current"><a href = "viewRoles.php">Roles</a></li>

</ul>
</div>

<?php $rID= $_POST['role_list']; ?>

<div class ="contentBox">
<h2 id="positionTopH2">Update Details for Role <?php echo $rID?></h2>
<form action="updateRoleProcess.php" method="post">
<!--Send the form for processing to the updateRoleProcess php file-->




<?php

define('DB_NAME', 's1053775_database');//name of database
define('DB_USER', 's1053775_root');//name of database user
define('DB_PW', 'W3arethebest'); //password
define('DB_HOST', 'localhost'); //where the database is running



?>

<?php
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

//insert the event record into the database
$get_SQL = mysql_query("SELECT Role_ID, Role_Name, Role_Other FROM `Role` WHERE Role_ID = $rID"); 

//if (!mysql_query($get_SQL)) { //checks if there is a valid record selected; if not, execute statement
//    die('Error: ' . mysql_error());
//}

$i=0;

while($row = mysql_fetch_array($get_SQL)) { //loops until the end of the events list, which should return a false

$rID = $row['Role_ID'];
$rName= $row['Role_Name'];
$rOther= $row['Role_Other'];

?>
<!--Event fields that the user must fill in-->

 Role ID: <input type="text" name="Role_ID" value='<?php echo $rID; ?>'><br>
 Role Name: <input type="text" name="Role_Name" value='<?php echo $rName; ?>'><br>
 Role Other: <input type="text" name="Role_Other" value='<?php echo $rOther; ?>'><br>

 <!--The submit button-->  
 <input type="submit" value="Update">
 
<?php
$i++;
}
mysql_close($dbLink); //closes the connection to the database

?>




 </form>
<form action="deleteRoleProcess.php?dRole_ID=<?php echo $rID?>" method="post">
<input type="submit" value="Delete">
</form>

<br>
<br>
<form action="viewEvents.php" method="post">
<input type="submit" value="Back">
</form>
</div>

</body>
</html>
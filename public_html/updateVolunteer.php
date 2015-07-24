<?php

session_start();
if ($_SESSION['LoggedIn'] != $_SESSION['AdminCode'] && $_SESSION['LoggedIn'] !=$_SESSION['EMCode']) {
    header("Location: index.php");
}

?>
<!-- File: updateVolunteer.php
 * ------------------------
 * This php file will be concerned with gathering the details of a new volunteer
 * and then submitting that information to the newUserProcess php file. This page will
 * display fields for the volunteer to enter and submit.
 -->
 
<html>
<head>

<link rel="stylesheet" type="text/css" href="buttons.css">
<link rel="stylesheet" type="text/css" href="form.css">
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

<?php if ($_SESSION['LoggedIn'] != $_SESSION['AdminCode']) { //if they are an event manager make the dashboard link available
 echo "<li><a href='dashboard.php'>Dashboard</a></li>";
} 
?>
<li><a href="viewEventsEM.php">Events</a></li>
<li id="current"><a href = "viewVolunteersEM.php">Volunteers</a></li>
<li><a href = "viewActivities.php">Activities</a></li>
<li><a href = "viewRoles.php">Roles</a></li>


</ul>
</div>

<?php $uID = $_POST['volunteer_list']; ?>

<div class="contentBox">
<p>Update User Details: <?php echo $uID ?></p>
<form action="updateUserProcess.php" method="post">
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

//insert the user record into the database
$get_SQL = mysql_query("SELECT User_ID, Given_Names, Surname, Primary_Email,
 Secondary_Email, Primary_Phone, Secondary_Phone, Age, Male FROM `User Details` 
 WHERE User_ID = $uID"); 

//if (!mysql_query($get_SQL)) { //checks if there is a valid record selected; if not, execute statement
//    die('Error: ' . mysql_error());
//}

$i=0;

while($row = mysql_fetch_array($get_SQL)) { //loops until the end of the volunteers list, which should return a false


$guID = $row['User_ID'];
$guGN = $row['Given_Names'];
$guSN = $row['Surname'];
$guPE = $row['Primary_Email'];
$guSE = $row['Secondary_Email'];
$guPP = $row['Primary_Phone'];
$guSP = $row['Secondary_Phone'];
$guAge = $row['Age'];
$guGender = $row['Male'];
?>
<!--Volunteer fields that the user must fill in-->

 UTS ID: <input type="text" name="User_ID" value='<?php echo $guID; ?>'><br>

 Given Names <input type="text" name="Given_Names" value='<?php echo $guGN; ?>'><br>
 Surname <input type="text" name="Surname" value='<?php echo $guSN; ?>'><br>
 Primary E-mail: <input type="text" name="Primary_Email" value='<?php echo $guPE; ?>'><br> 
 Secondary E-mail: <input type="text" name="Secondary_Email" value='<?php echo $guSE; ?>'><br>
 Primary Phone: <input type="text" name="Primary_Phone" value='<?php echo $guPP; ?>'><br>
 Secondary Phone: <input type="text" name="Secondary_Phone" value='<?php echo $guSP; ?>'><br> 
 Age: <input type="text" name="Age" value='<?php echo $guAge; ?>'><br>
 Gender: <input type="text" name="Male" value='<?php echo $guGender; ?>'><br> 
 <!--The submit button-->  
 <input type="submit" value="Update">
 
<?php
$i++;
}
mysql_close($dbLink); //closes the connection to the database

?>




 </form>
 
<form action="deleteUserProcess.php?duser_ID=<?php echo $guID ?>" method="post">
<input type="submit" value="Delete">
</form>

<br>
<br>
<form action="viewVolunteers.php" method="post">
<input type="submit" value="Back">
</form>
</div>

</body>
</html>
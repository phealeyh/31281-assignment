<?php
session_start();
if ($_SESSION['LoggedIn'] != $_SESSION['AdminCode'] && $_SESSION['LoggedIn'] !=$_SESSION['EMCode']) {
    header("Location: index.php");

}

?>

<!-- File: viewVolunteersSA.php
 * ------------------------
 * This html file contains the list of volunteers within the system.
 * It is also responsible for establishing the connection between the database and requesting
 * queries about the list of volunteers. It displays the volunteers names in a drop down box.
 -->
<html>
<head>
<link rel="stylesheet" type="text/css" href="buttons.css">
</head>
<body>

<div id="header">
<?php $currentUser = $_SESSION['Name']; ?>
Logged in as: <b><?php echo $currentUser; ?> <?php echo $tested; ?></b>            <a href="logout.php"> Log Out </a>
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
<li><a href="viewEvents.php">Events</a></li>
<li id="current"><a href = "viewVolunteers.php">Volunteers</a></li>
</ul>
</div>

<div class="contentBox">

<h2> Volunteers: </h2>

<!-- Allows a specific volunteer to be editted -->
<form action="updateVolunteer.php" method="post"> 
<?php
//Defines the constants along with its values
define('DB_NAME', 's1053775_database'); //name of database
define('DB_USER', 's1053775_root'); //name of database user
define('DB_PW', 'W3arethebest'); //password
define('DB_HOST', 'localhost'); //where the database is running

//a variable created based on the connection to the sql database
$dbLink = mysql_connect(DB_HOST,DB_USER, DB_PW);
mysql_select_db(DB_NAME,$dbLink); 

if ($_SESSION['LoggedIn'] == $_SESSION['AdminCode']) { // if admin
	$volunteersList = mysql_query("SELECT * FROM `User Details` ORDER BY Given_Names");
} else {
	$volunteersList = mysql_query("SELECT * FROM `User Details` INNER JOIN Account ON UTS_ID = User_ID WHERE Privilege < 3 ORDER BY Given_Names");    	
}
?>
<select id="volunteer_list" name="volunteer_list" style="width: 400px;">
<?php
$i=0;

while($row = mysql_fetch_array($volunteersList)) { //loops until the end of the volunteers list, which should return a false
?>
<!--Displays the list of  options within the html page-->
<option value=<?=$row["User_ID"];?>><?=$row["Given_Names"] . " " . $row["Surname"] ;?></option>
<?php
$i++;
}


?>
</table>
<?php
mysql_close($dbLink); //closes the connection to the database
?>

<input type="submit" value="Update"> 
</form>
<p><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></p>
<form action="addUser.php" method="post"> <!-- Specifies where to send the form data -->
<input type="submit" value="Add New User"> <!--creates the add user button-->
</form>

</div>

</body>
</html>
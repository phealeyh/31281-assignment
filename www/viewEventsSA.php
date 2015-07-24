<?php
session_start();
if ($_SESSION['LoggedIn'] != $_SESSION['AdminCode']) {
    header("Location: index.php");
} 
?>
<!-- File: viewEventsSA.php
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

<?php

?>

<div id="header">
<?php $currentUser = $_SESSION['Name']; ?>
Logged in as: <b><?php echo $currentUser; ?></b>            <a href="logout.php"> Log Out </a>
</div>
<div id="banner">
UTS Event Management System
</div>

<div class="navAlign" id="container">
<ul class="navButton">
<li id="current"><a href="viewEventsSA.php">Events</a></li>
<li><a href = "viewVolunteersSA.php">Volunteers</a></li>
</ul>

</div>

<div class="content" id="container">

<h2>All Events</h2>



<!-- Allows a specific event to be editted -->
<form action="manageEventEM.php" method="post" id="dropdown"> 
<?php


//Defines the constants along with its values
define('DB_NAME', 's1053775_database'); //name of database
define('DB_USER', 's1053775_root'); //name of database user
define('DB_PW', 'W3arethebest'); //password
define('DB_HOST', 'localhost'); //where the database is running

//a variable created based on the connection to the sql database
$dbLink = mysql_connect(DB_HOST,DB_USER, DB_PW);
mysql_select_db(DB_NAME,$dbLink); 
$eventsList = mysql_query("SELECT * FROM `Event` ORDER BY Name");
?>
<select id="event_list" name="event_list" style="width: 400px;">
<?php
$i=0;


//loop starts here

while($row = mysql_fetch_array($eventsList)) { //loops until the end of the volunteers list, which should return a false
?>
<!--Displays the list of  options within the html page-->
<option value=<?=$row["Event_ID"];?>><?=$row["Name"] ;?></option>
<?php
$i++;
}
// while($row = mysql_fetch_array($eventsList)) { //loops until the end of the volunteers list, which should return a false
// ?>
// <!--Displays the list of  options within the html page-->
// <option value=<?=$row["Event_ID"];?>><?=$row["Name"] ;?></option>
// <?php
// $i++;
// }



//loop ends here


?>
</select>
<?php
mysql_close($dbLink); //closes the connection to the database
?>

<input type="submit" value="Manage"> 
</form>


<p><br><br><br><br></p>

<form action="addEvents.php" method="post" id="dropdown"> <!-- Specifies where to send the form data -->
<input type="submit" value="Add New Event"> <!--creates the add event button-->
</form>





</div>


</body>
</html>
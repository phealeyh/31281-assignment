<?php
session_start();
if ($_SESSION['LoggedIn'] != $_SESSION['SproutCode'] && $_SESSION['LoggedIn'] !=

$_SESSION['VolunteerCode']) {
    header("Location: index.php");
} 
?>
<!-- File: viewEvents.php
 * ------------------------
 * This html file contains the list of events within the system.
 * It is also responsible for establishing the connection between the database and 

requesting
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
Logged in as: <b><?php echo $currentUser; ?></b>            <a href="logout.php"> Log 

Out </a>
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
<li><a href = "viewVolunteerRoles.php">Roles</a></li>
</ul>

</div>
<div class="contentBox">
<h2 id="positionTopH2">All Events</h2>

<form action="addEvents.php" method="post"> <!-- Specifies where to send the form data -->
<input type="submit" value="Add New Event" class="button" id="bottomButton1"> <!--creates the add event button-->
</form>



<form action="manageEvent.php" method="post"> 

<input type="submit" value="Manage" class="button"  id="bottomButton2"> 

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


<?php

$i=0;
// 
echo "<div style=\"overflow-y: scroll; overflow-x: hidden;\" class=\"contentSmall\" id=\"scrollBox\"><table border='1' class=\"table1\" id='container' >
<tr>
<th>Select</th>
<th>Event ID</th>
<th>Event Name</th>
<th>Start Date</th>
<th>End Date</th>
</tr>";


while($row = mysql_fetch_array($eventsList)) { //loops until the end of the volunteers 


  echo "<tr>";
  echo "<td><input type=\"radio\" name=\"event_list\" value=".$row['Event_ID']."></td>";
  echo "<td>" . $row['Event_ID'] . "</td>";
  echo "<td>" . $row['Name'] . "</td>";
  echo "<td>" . $row['Start_Date'] . "</td>";
  echo "<td>" . $row['End_Date'] . "</td>";
  echo "</tr>";
  
$i++;
}
echo "</table>";

mysql_close($dbLink); //closes the connection to the database
?>
</div>

</form>






</div>


</body>
</html>
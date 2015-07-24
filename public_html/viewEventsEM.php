<?php
session_start();
$_SESSION['AdminCode'] = 103;
$_SESSION['EMCode'] = 102;
$_SESSION['SproutCode'] = 101;
$_SESSION['VolunteerCode'] = 100;

if ($_SESSION['LoggedIn'] != $_SESSION['AdminCode'] && $_SESSION['LoggedIn'] !=$_SESSION['EMCode']) {
    header("Location: index.php");
    exit;
} 

$eventDraft = 0;
$eventActive = 1;

//set the context sensitive help index
$HC = 2;
$_SESSION['HC'] = $HC;


$uID = $_SESSION['UserID'];
//echo $uID;
?>
<!-- File: viewEvents.php
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
<?php echo $_SESSION['Navigation']; ?>

</div>

<!-- Allows a specific event to be editted -->

<div class="contentBoxLong2">
<h2 id="positionTopH3">All Events</h2>
<pre id="instructions">
	General Instructions
</pre>
<pre id="preAlign2">
	Select an event from the table and click "Manage" to manage the event.
	Click on "Add New Event" to create a new event.
	</pre>
<form action="addEvents.php" method="post"> <!-- Specifies where to send the form data -->
<input type="submit" value="Add New Event" class="greenButton " id="bottomButton1"> <!--creates the add event button-->
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
date_default_timezone_set('Australia/Melbourne');
$currentDate = date("Y-m-d");
if ($_SESSION['LoggedIn'] == $_SESSION['AdminCode'])
{
   $eventsList = mysql_query("SELECT * FROM `Event` WHERE History < 2  ORDER BY Name");
} else {
   $eventsList = mysql_query("SELECT * FROM `Event` 
   WHERE Manager_ID = '$uID'
   OR (Manager_ID < 0
   AND End_Date >= '$currentDate')
   ORDER BY Name");
}
?>


<?php

$i=0;
// 
echo "<div style=\"overflow-y: scroll; overflow-x: hidden;\" class=\"contentSmall\" id=\"scrollBox2\"><table border='1' class=\"table1\" id='container' >
<tr>
<th>Select</th>
<th>Event Name</th>
<th>Start Date</th>
<th>End Date</th>
<th>Status</th>
</tr>";


while($row = mysql_fetch_array($eventsList)) { //loops until the end of the volunteers 
  echo "<tr>";
  if ($i == 0) { 
  	echo "<td><input type=\"radio\" name=\"event_list\" checked=\"checked\" value=".$row['Event_ID']."></td>";
  } else {
        echo "<td><input type=\"radio\" name=\"event_list\" value=".$row['Event_ID']."></td>";
  } 
  echo "<td>" . $row['Name'] . "</td>";
  echo "<td>" . $row['Start_Date'] . "</td>";
  echo "<td>" . $row['End_Date'] . "</td>";
  if ($row['History'] == $eventDraft) { 
  	echo "<td>Draft</td>";
  } else if ($row['History'] == $eventActive) {
        echo "<td>Posted</td>";
  }
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
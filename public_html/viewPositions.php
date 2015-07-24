<?php
session_start();
$_SESSION['AdminCode'] = 103;
$_SESSION['EMCode'] = 102;
$_SESSION['SproutCode'] = 101;
$_SESSION['VolunteerCode'] = 100;
$activeEvent = 0;
if ($_SESSION['LoggedIn'] != $_SESSION['SproutCode'] && $_SESSION['LoggedIn'] !=$_SESSION['VolunteerCode']) {
    
} 
$notSproutOnly = 0;

// set the context sensitive help index
$HC = 4;
$_SESSION['HC'] = $HC;
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
<?php
if ($_SESSION['LoggedIn'] == $_SESSION['SproutCode'] || $_SESSION['LoggedIn'] ==$_SESSION['VolunteerCode']) {
    echo "Logged in as: <b>" . $currentUser . "</b>            <a href=\"logout.php\"> Log Out </a>";
} else {
    echo "Viewing as: <b>Guest</b>            <a href=\"index.php\"> Sign In</a>";
}
?>
</div>
<div id="banner">
UTS Event Management System
</div>
<div class="navAlign" id="container">
<?php 
if ($_SESSION['LoggedIn'] == $_SESSION['SproutCode'] || $_SESSION['LoggedIn'] ==$_SESSION['VolunteerCode']) {
    echo $_SESSION['Navigation'];
} else {
   echo "<ul class=\"navButton\">
         <li id=\"current\"><a href=\"viewPositions.php\">Volunteer</a></li>
         <li><a href = \"helpDirect.php\" target=\"_blank\">Help</a></li>
         </ul>";
}
?>

</div>


<!-- Allows a specific event to be editted -->

<div class="contentBox">
<h2 id="positionTopH2">Viewing Available Events and Activities</h2>



<!-- EVENTS LIST -->
<div class="contentRectangleEvent3" id="rectangleContainer">
<form action="inquire.php" method="post"> <!-- Specifies where to send the form data -->
<input type="submit" value="Inquire" class="greenButton" id="inquireEnA2"> <!--creates the add event button-->
</form>

<pre id="alignHeading">
	<h3>Events List</h3>
	</pre>
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

if($_SESSION['LoggedIn'] >= $_SESSION['SproutCode']) {
    $eventsList = mysql_query("SELECT * FROM `Event` 
    WHERE History = 1
    AND End_Date >= '$currentDate'
    ORDER BY Start_Date, Name");
} else {
    $eventsList = mysql_query("SELECT * FROM `Event` 
    WHERE History = 1
    AND End_Date >= '$currentDate'
    ORDER BY Start_Date, Name");
}

if (mysql_num_rows($eventsList) > 0) {
      echo '<form action="viewVolunteerEventDetails.php" method="post">
      <input type="submit" value="View Details" class="button" id="viewDetailsEnA">' ; 
} else {
      echo '<form action="viewVolunteerActivityDetails.php" method="post">
      <input type="submit" value="View Details" class="button" id="viewDetailsEnA" disabled="true">'; 
}
?>
	


<?php

$i=0;
// 
echo "<div style=\"overflow-y: scroll; overflow-x: hidden;\" class=\"eventListSmall\" id=\"positionEventList\"><table border='1' class=\"table1\" id='container' >
<tr>
<th>Select</th>
<th>Event Name</th>
<th>Start Date</th>
<th>End Date</th>
</tr>";


while($row = mysql_fetch_array($eventsList)) { //loops until the end of the volunteers 


  echo "<tr>";
  if ($i == 0) {
      echo "<td><input type=\"radio\" checked=\"checked\" name=\"event_list\" value=".$row['Event_ID']."></td>";
  } else {
      echo "<td><input type=\"radio\" name=\"event_list\" value=".$row['Event_ID']."></td>";
  }
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
</div>





<!-- ACTIVItiES LIst -->


<div class="contentRectangleEvent3" id="rectangleContainerActivities">
<form action="inquire.php" method="post"> <!-- Specifies where to send the form data -->
<input type="submit" value="Inquire" class="greenButton" id="inquireEnA2"> <!--creates the add event button-->
</form>

<pre id="alignHeading">
	<h3>Activities List</h3>
	</pre>
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
if($_SESSION['LoggedIn'] >= $_SESSION['SproutCode']) {
    $eventsList = mysql_query("SELECT * FROM `Activities`
    WHERE History = '$activeEvent'
    AND End_Date >= '$currentDate'
    ORDER BY Start_Date, Event_ID, Name");
} else {
    $eventsList = mysql_query("SELECT * FROM `Activities`
    WHERE History = '$activeEvent'
    AND SproutOnly = '$notSproutOnly'
    AND End_Date >= '$currentDate'
    ORDER BY Start_Date, Event_ID, Name");
}
?>
	
<?php

if (mysql_num_rows($eventsList) > 0) {
      echo '<form action="viewVolunteerActivityDetails.php" method="post">
      <input type="submit" value="View Details" class="button" id="viewDetailsEnA">' ; 
} else {
      echo '<form action="viewVolunteerActivityDetails.php" method="post">
      <input type="submit" value="View Details" class="button" id="viewDetailsEnA" disabled="true">'; 
}
	






$i=0;
// 
echo "<div style=\"overflow-y: scroll; overflow-x: hidden;\" class=\"eventListSmall\" id=\"positionEventList\"><table border='1' class=\"table1\" id='container' >
<tr>
<th>Select</th>
<th>Event Name</th>
<th>Activity Name</th>
<th>Start Date</th>
<th>End Date</th>
</tr>";


while($row = mysql_fetch_array($eventsList)) { //loops until the end of the volunteers 

$lEID = $row['Event_ID'];
$eNameGet = mysql_query("SELECT Name FROM `Event`
WHERE Event_ID = '$lEID'");
$eRow = mysql_fetch_array($eNameGet);
$eName = $eRow['Name'];

  echo "<tr>";
  if ($i == 0) {
      echo "<td><input type=\"radio\" checked=\"checked\" name=\"activitieslist\" value=".$row['Activity_ID']."></td>";
  } else {
      echo "<td><input type=\"radio\" name=\"activitieslist\" value=".$row['Activity_ID']."></td>";
  }
  echo "<td>" . $eRow['Name'] . "</td>";
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
</div>








</div>

</body>
</html>
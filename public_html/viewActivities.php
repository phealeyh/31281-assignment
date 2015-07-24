<!-- File: viewActivites.php
 * ------------------------
 * This html file contains the list of activities within the system.
 * It is also responsible for establishing the connection between the database and requesting
 * queries about the list of events. It displays the activites in a drop down box.
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
<li id="current"><a href = "viewActivities.php">Activities</a></li>
<li><a href = "viewRoles.php">Roles</a></li>


</ul>
</div>

<div class="contentBoxLong2">
<h2 id="positionTopH2">All Activities</h2>
<pre id="instructions">
	General Instructions
</pre>
<pre id="preAlign2">
	Select an activity from the table and click "Update" to update the activity.
	Click on "Add New Activity" to create a new activity.
	</pre>
<form action="addActivities.php" method="post"> <!-- Specifies where to send the form data -->
<input type="submit" value="Add New Activity" class="greenButton" id="bottomButton1"> <!--creates the add activity button-->
</form>




<!-- Allows a specific event to be editted -->
<form action="updateActivity.php" method="post"> 
<input type="submit" value="Update" class="button" id="bottomButton2"> 
<?php
//Defines the constants along with its values
define('DB_NAME', 's1053775_database'); //name of database
define('DB_USER', 's1053775_root'); //name of database user
define('DB_PW', 'W3arethebest'); //password
define('DB_HOST', 'localhost'); //where the database is running

//a variable created based on the connection to the sql database
$dbLink = mysql_connect(DB_HOST,DB_USER, DB_PW);
mysql_select_db(DB_NAME,$dbLink); 
$activitiesList = mysql_query("SELECT * FROM `Activities` ORDER BY Name");
?>

<?php
$i=0;
echo "<div style=\"overflow-y: scroll; overflow-x: hidden;\" class=\"contentSmall\" id=\"scrollBox2\"><table border='1' class=\"table1\" id='container' >
<tr>
<th>Select</th>
<th>Activity ID</th>
<th>Activity Name</th>
<th>Start Date</th>
<th>End Date</th>
</tr>";
while($row = mysql_fetch_array($activitiesList)) { //loops until the end of the volunteers list, which should return a false


  echo "<tr>";
  echo "<td><input type=\"radio\" name=\"activitieslist\" value=".$row['Activity_ID']."></td>";
  echo "<td>" . $row['Activity_ID'] . "</td>";
  echo "<td>" . $row['Name'] . "</td>";
  echo "<td>" . $row['Start_Date'] . "</td>";
  echo "<td>" . $row['End_Date'] . "</td>";
  echo "</tr>";


?>
<?php
$i++;

}

?>

<?php
mysql_close($dbLink); //closes the connection to the database
?>

</form>


</div>

</body>
</html>
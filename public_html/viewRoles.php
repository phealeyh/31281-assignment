<?php
session_start();
if (!$_SESSION['LoggedIn'] == 101) {
    header("Location: index.php");
} 
?>
<!-- File: viewRoles.php
 * ------------------------
 * This html file contains the list of roles within the system.
 * It is also responsible for establishing the connection between the database and requesting
 * queries about the list of events. It displays the roles in a drop down box.
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

<div class="contentBoxLong2">

<h2 id="positionTopH2">All Roles</h2>
<pre id="instructions">
	General Instructions
</pre>
<pre id="preAlign2">
	Select a role from the table and click "Update" to update the role.
	Click on "Add New Role" to create a new role.
	</pre>
<form action="addRoles.php" method="post"> <!-- Specifies where to send the form data -->
<input type="submit" value="Add New Role" class="greenButton" id="bottomButton1"> <!--creates the add activity button-->
</form>

<!-- Allows a specific role to be editted -->
<form action="updateRole.php" method="post"> 

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
$rolesList = mysql_query("SELECT * FROM `Role` ORDER BY Role_Name");
?>



<?php
$i=0;
echo "<div style=\"overflow-y: scroll; overflow-x: hidden;\" class=\"contentSmall\" id=\"scrollBox2\"><table border='1' class=\"table1\" id='container' >
<tr>
<th>Select</th>
<th>Role ID</th>
<th>Role Name</th>
<th>Start Date</th>
<th>End Date</th>
</tr>";
while($row = mysql_fetch_array($rolesList)) { //loops until the end of the volunteers list, which should return a false


  echo "<tr>";
  echo "<td><input type=\"radio\" name=\"roleslist\" value=".$row['Role_ID']."></td>";
  echo "<td>" . $row['Role_ID'] . "</td>";
  echo "<td>" . $row['Role_Name'] . "</td>";
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
<!-- File: viewVolunteers.php
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
Logged in as: <b><?php echo $currentUser; ?></b>            <a href="logout.php"> Log 

Out </a>
</div>
<div id="banner">
UTS Event Management System
</div>
<div class="navAlign" id="container">
<ul class="navButton">
<li><a href="dashboard.php">Dashboard</a></li>
<li><a href="viewEvents.php">Events</a></li>
<li id="current"><a href = "viewVolunteers.php">Volunteers</a></li>
<li><a href = "viewActivities.php">Activities</a></li>
<li><a href = "viewRoles.php">Roles</a></li>
</ul>
</div>

<div class="contentBoxLong2">

<h2 id="positionTopH2">All Volunteers</h2>
<pre id="instructions">
	General Instructions
</pre>
<pre id="preAlign2">
	Select a user from the table and click "Update" to update the user.
	Click on "Add New User" to create a new user.
	</pre>

<form action="addUser.php" method="post"> <!-- Specifies where to send the form data -->
<input type="submit" value="Add New User" id="bottomButton1" class="greenButton"> <!--creates the add user button-->
</form>

<!-- Allows a specific volunteer to be editted -->
<form action="updateVolunteer.php" method="post"> 
<input type="submit" value="Update" id="bottomButton2" class="button"> 
<?php
//Defines the constants along with its values
define('DB_NAME', 's1053775_database'); //name of database
define('DB_USER', 's1053775_root'); //name of database user
define('DB_PW', 'W3arethebest'); //password
define('DB_HOST', 'localhost'); //where the database is running

//a variable created based on the connection to the sql database
$dbLink = mysql_connect(DB_HOST,DB_USER, DB_PW);
mysql_select_db(DB_NAME,$dbLink); 
$volunteersList = mysql_query("SELECT * FROM `User Details` ORDER BY Given_Names");
?>




<?php
$i=0;




echo "<div style=\"overflow-y: scroll; overflow-x: hidden;\" class=\"contentSmall\" id=\"scrollBox2\"><table border='1' class=\"table1\" id='container' >
<tr>
<th>Select</th>
<th>User ID</th>
<th>Given Name</th>
<th>Surname</th>
<th>Email</th>
</tr>";


while($row = mysql_fetch_array($volunteersList)) { //loops until the end of the volunteers list, which should return a false

  echo "<tr>";
  echo "<td><input type=\"radio\" name=\"volunteers_list\" value=".$row['User_ID']."></td>";
  echo "<td>" . $row['User_ID'] . "</td>";
  echo "<td>" . $row['Given_Names'] . "</td>";
  echo "<td>" . $row['Surname'] . "</td>";
  echo "<td>" . $row['Primary_Email'] . "</td>";
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
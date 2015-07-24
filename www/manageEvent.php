<?php
session_start();
$_SESSION['AdminCode'] = 103;
$_SESSION['EMCode'] = 102;
$_SESSION['SproutCode'] = 101;
$_SESSION['VolunteerCode'] = 100;

if ($_SESSION['LoggedIn'] != $_SESSION['AdminCode'] && $_SESSION['LoggedIn'] !=$_SESSION['EMCode']) {
    header("Location: index.php");
} 

$eventDraft = 0;
$eventActive = 1;

//set the context sensitive help index
$HC = 3;
$_SESSION['HC'] = $HC;
?>
<!-- File: manageEvent.php
 * ------------------------
 * This html file contains the list of events within the system.
 * It is also responsible for establishing the connection between the database and requesting
 * queries about the list of events. It displays the events in a drop down box.
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
<?php echo $_SESSION['Navigation']; ?>

<?php 
$eID = $_POST['event_list'];

if ($eID == null)
{
	$eID = $_GET['e_ID'];	
}
//Defines the constants along with its values
define('DB_NAME', 's1053775_database'); //name of database
define('DB_USER', 's1053775_root'); //name of database user
define('DB_PW', 'W3arethebest'); //password
define('DB_HOST', 'localhost'); //where the database is running

//a variable created based on the connection to the sql database
$dbLink = mysql_connect(DB_HOST,DB_USER, DB_PW);
mysql_select_db(DB_NAME,$dbLink); 

//insert the user record into the database
$get_SQL = mysql_query("SELECT * FROM `Event` 
 WHERE Event_ID = $eID"); 

//if (!mysql_query($get_SQL)) { //checks if there is a valid record selected; if not, execute statement
//    die('Error: ' . mysql_error());
//}

$i=0;

$row = mysql_fetch_array($get_SQL);


$gN = $row['Name'];
$gM = $row['Manager_ID'];
$gD = $row['Description'];
$gSD = $row['Start_Date'];
$gED = $row['End_Date'];
$gST = $row['Start_Time'];
$gSL = $row['Location'];
$gPL = $row['PickUp'];

if ($row['History'] == $eventDraft) { 
  	$status = "Draft";
  } else if ($row['History'] == 1){
        $status = "Posted";
  } else if ($row['History'] == 2) {
        $status = "Signed";
  }
//mysql_close($dbLink); //closes the connection to the database

if ($gM != "" && $gM > 0){
$get_SQL = mysql_query("SELECT * FROM `User Details` 
 WHERE User_ID = '$gM'"); 
$row = mysql_fetch_array($get_SQL);
$eManager = $row['Given_Names'] . " " . $row['Surname'];
}
?>

</div>

<div class="contentBox">
<h2 id="positionTopH2">Managing Event: <?php echo $gN; ?> <em>(<?php echo $status; ?>)</em></h2>

<div class="contentRectangleEvent2" id="rectangleContainer">

	<pre id="preAlignH3">
	<h3>Event Details:</h3>
	</pre>
	
	<pre id="preAlign">
	Event Name: <em><?php echo $gN; ?></em>		
	Start Date: <em><?php echo $gSD; ?></em>
	End Date: <em><?php echo $gED; ?></em>
	Start Time: <em><?php echo $gST; ?></em> 
	Location: <em><?php echo $gSL; ?></em>
	Pick Up: <em><?php echo $gPL; ?></em>
	<?php if($eManager != "")
	{
	    echo "Manager: <em>" . $eManager. "</em>";
	} else {
	    echo "Manager: ";
	}
        ?>
	</pre>
	<p id="column">Description:</p>
	<div style="overflow-y: scroll;" class="eventDescription" id="eventDescriptionPosition">
	<p id="pAlign">
	<em><?php echo $gD; ?></em>
	</p>
</div><form action="updateEventV.php?e_ID=<?php echo $eID; ?>" method="post"> <!-- Specifies where to send the form data -->
<input type="submit" value="Update" class="button" id="updateButtonRnE2">
</form>
	</div>

</div>







	

<div class="contentRectangleActivity " id="rectangleContainerActivities">
	
	<pre id="preAlignH3">
	<h3>Activities</h3>
	</pre>
	<form action="addActivities.php?e_ID=<?php echo $eID; ?>" method="post"> <!-- Specifies where to send the form data -->
<input type="submit" value="Add New Activity" class="greenButton" id="activityButton"> <!--creates the add event button-->
</form>



<?php
//a variable created based on the connection to the sql database
$dbLink = mysql_connect(DB_HOST,DB_USER, DB_PW);
mysql_select_db(DB_NAME,$dbLink); 
$activityQuery = "SELECT * FROM `Activities` WHERE Event_ID ='$eID' ORDER BY Name";
$activitiesList = mysql_query($activityQuery);


if (mysql_num_rows(mysql_query($activityQuery)) > 0) {
      echo '<form action="manageActivity.php" method="post"> 
      <input type="submit" value="Manage Activity" class="button" id="manageActivityButton">'; 
} else {
      echo '<form action="manageActivity.php" method="post"> 
      <input type="submit" value="Manage Activity" class="button" id="manageActivityButton" disabled="true">'; 
}


$i=0;
echo "<div style=\"overflow-y: scroll; overflow-x: hidden;\" class=\"activitySmall\" id=\"positionActivitySmall\"><table border='1' class=\"table1\" id='container' >
<tr>
<th>Select</th>
<th>Activity ID</th>
<th>Activity Name</th>
<th>Start Date</th>
<th>End Date</th>
</tr>";
while($row = mysql_fetch_array($activitiesList)) { //loops until the end of the volunteers list, which should return a false


  echo "<tr>";
  if ($i == 0) { 
      echo "<td><input type=\"radio\" checked=\"checked\" name=\"activitieslist\" value=".$row['Activity_ID']."></td>";
  } else {
      echo "<td><input type=\"radio\" name=\"activitieslist\" value=".$row['Activity_ID']."></td>";
  }
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
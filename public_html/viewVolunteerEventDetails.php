<?php
session_start();
$_SESSION['AdminCode'] = 103;
$_SESSION['EMCode'] = 102;
$_SESSION['SproutCode'] = 101;
$_SESSION['VolunteerCode'] = 100;
$activeEvent = 0;

// set the context sensitive help index
$HC = 4;
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
$gD = $row['Description'];
$gSD = $row['Start_Date'];
$gED = $row['End_Date'];
$gST = $row['Start_Time'];
$gM = $row['Manager_ID'];
$gSL = $row['Location'];
$gPL = $row['PickUp'];

if ($gM != "" && $gM > 0){
$get_SQL = mysql_query("SELECT * FROM `User Details` 
 WHERE User_ID = '$gM'"); 
$row = mysql_fetch_array($get_SQL);
$eManager = $row['Given_Names'] . " " . $row['Surname'];
}
//mysql_close($dbLink); //closes the connection to the database
?>



<div class="contentBox">
<h2 id="positionTopH2"><?php echo $gN; ?></h2>

<div class="contentRectangleEvent2" id="rectangleContainer">

	<pre id="preAlignH3">
	<h3>Event Details</h3>
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
</div><form action="inquire.php" method="post"> <!-- Specifies where to send the form data -->
<input type="submit" value="Inquire" class="greenButton" id="updateButtonRnE8">
</form>
	</div>

</div>







	

<div class="contentRectangleActivity " id="rectangleContainer2">
	
	<pre id="preAlignH3">
	<h3>Activities</h3>
	</pre>
	<form action="addActivities.php?e_ID=<?php echo $eID; ?>" method="post"> <!-- Specifies where to send the form data -->
<input type="submit" value="Inquire" class="greenButton" id="activityButton"> <!--creates the add event button-->
</form>
	

<?php

//a variable created based on the connection to the sql database
$dbLink = mysql_connect(DB_HOST,DB_USER, DB_PW);
mysql_select_db(DB_NAME,$dbLink);
date_default_timezone_set('Australia/Melbourne');


$currentDate = date("Y-m-d");
if($_SESSION['LoggedIn'] >= $_SESSION['SproutCode']) {
    $eventsList = mysql_query("SELECT * FROM `Activities`
    WHERE History = '$activeEvent'
    AND Event_ID = '$eID'
    AND End_Date >= '$currentDate'
    ORDER BY Start_Date, Event_ID, Name");
} else {
    $eventsList = mysql_query("SELECT * FROM `Activities`
    WHERE History = '$activeEvent'
    AND SproutOnly = '$notSproutOnly'
    AND Event_ID = '$eID'
    AND End_Date >= '$currentDate'
    ORDER BY Start_Date, Event_ID, Name");
}
?>
	
<?php

if (mysql_num_rows($eventsList) > 0) {
      echo '<form action="viewVolunteerActivityDetails.php" method="post">
      <input type="submit" value="View Details" class="button" id="viewDetailsEnA2">' ; 
} else {
      echo '<form action="viewVolunteerActivityDetails.php" method="post">
      <input type="submit" value="View Details" class="button" id="viewDetailsEnA2" disabled="true">'; 
}



$i=0;
echo "<div style=\"overflow-y: scroll; overflow-x: hidden;\" class=\"activitySmall\" id=\"positionActivitySmall\"><table border='1' class=\"table1\" id='container' >
<tr>
<th>Select</th>
<th>Activity Name</th>
<th>Start Date</th>
<th>End Date</th>
</tr>";
while($row = mysql_fetch_array($eventsList)) { //loops until the end of the volunteers list, which should return a false


  echo "<tr>";
  if ($i == 0)
  {
      echo "<td><input type=\"radio\" checked=\"checked\" name=\"activitieslist\" value=".$row['Activity_ID']."></td>";
  } else {
      echo "<td><input type=\"radio\" name=\"activitieslist\" value=".$row['Activity_ID']."></td>";
  }
  
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
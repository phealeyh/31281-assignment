<?php

session_start();
$_SESSION['AdminCode'] = 103;
$_SESSION['EMCode'] = 102;
$_SESSION['SproutCode'] = 101;
$_SESSION['VolunteerCode'] = 100;
if ($_SESSION['LoggedIn'] != $_SESSION['AdminCode'] && $_SESSION['LoggedIn'] !=$_SESSION['EMCode']) {
    header("Location: index.php");
}


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
</div>


<?php 
$aID = $_POST['activitieslist']; 

if ($aID == null)
{
	$aID = $_GET['a_ID'];	
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


 

//insert the user record into the database
$get_SQL = mysql_query("SELECT * FROM `Activities` 
 WHERE Activity_ID = $aID"); 

//if (!mysql_query($get_SQL)) { //checks if there is a valid record selected; if not, execute statement
//    die('Error: ' . mysql_error());
//}

$i=0;

$row = mysql_fetch_array($get_SQL);

// Store the event details required for activity management
$gN = $row['Name'];
$gD = $row['Description'];
$gSD = $row['Start_Date'];
$gED = $row['End_Date'];
$gTSD = $row['Start_Time'];
$gTED = $row['End_Time'];
$eID = $row['Event_ID'];
$gPR = $row['PayRate'];
$gDU = $row['Duration'];
$gRQ = $row['ActivityPeopleRequired'];
$eID = $row['Event_ID'];
$aSP = $row['SproutOnly'];

if($aSP == 1){
    $sHeader = "(S)";
}
$rolesList = mysql_query("SELECT * FROM `Allocated` 
 WHERE Activity_ID = $aID AND Allocated = 1"); 
 
$gAL=mysql_num_rows($rolesList);

$get_SQL = mysql_query("SELECT * FROM `Event` 
 WHERE Event_ID = '$eID'"); 
$row = mysql_fetch_array($get_SQL);
$eName = $row['Name'];

?>


<div class="contentBoxLong3">



<h2 id="positionTopH2">Managing Activity: <?php echo $gN; ?> <?php echo $sHeader; ?></h2>




<!-- ACTIVITY DETAILS HERE -->
<!-- ********************* -->
<div class="contentRectangleEvent3" id="rectangleContainer">

	<pre id="preAlignH3">
	<h3>Activity Details:</h3>
	</pre>
	<pre id="preAlign">
	Activity Name: <?php echo $gN ?>

	Start Date: <?php echo $gSD; ?> 
	End Date: <?php echo $gED; ?> 
	Start Time: <?php echo $gTSD; ?> 
	End Time: <?php echo $gTED; ?> 
	Pay Rate: $<?php echo $gPR; ?> 
	Duration: <?php echo $gDU; ?> 
	Positions Filled: <?php echo $gAL; ?>/<?php echo $gRQ; ?>
	</pre>
	<p id="column22">Event: <a href="manageEvent.php?e_ID=<?php echo $eID; ?>"><?php echo $eName; ?></a></p>
	<p id="column">Description:</p>
	<div style="overflow-y: scroll;" class="eventDescription" id="eventDescriptionPosition">
	<p id="pAlign">
	<em><?php echo $gD; ?></em>
	</p>	
	</div>
	<form action="updateActivityV.php?a_ID=<?php echo $aID; ?>" method="post">
        <input type="submit" value="Update" class="button" id="updateButtonRnE3">
        </form>

</div>


<!-- ALLOCATED VOLUNTEERS  -->
<!-- ********************* -->


<div class="contentRectangleActivity" id="rectangleContainer">

<pre id="preAlignH3">
	<h3>Allocated Volunteers</h3>
	</pre>

	
<!-- Allows a specific event to be editted -->
<form action="manageAllocatedRole.php?a_ID=<?php echo $aID; ?>" method="post" id="dropdown"> 
<?php
$activityQuery = "SELECT * FROM `Allocated` WHERE Activity_ID ='$aID' AND Allocated = 1";
$activitiesList = mysql_query($activityQuery);


if (mysql_num_rows(mysql_query($activityQuery)) > 0) {
      echo '<input type="submit" value="Manage" class="button" id="updateRoleButton2">'; 
} else {
      echo '<input type="submit" value="Manage" class="button" id="updateRoleButton2" disabled="true">';
}






?>

<?php
$i=0;


//insert the user record into the database
$activitiesList = mysql_query("SELECT * FROM `Allocated` 
 WHERE Activity_ID = $aID AND Allocated = 1"); 
 
$confirmedUser=mysql_num_rows($get_SQL);
$i=0;
?>

<?php
$i=0;

echo "<div style=\"overflow-y: scroll; overflow-x: hidden;\" class=\"activitySmall\" id=\"positionActivitySmall3\"><table border='1' class=\"table1\" id='container' >
<tr>
<th>Select</th>
<th>User ID</th>
<th>Given Names</th>
<th>Surname</th>

</tr>";



while($row = mysql_fetch_array($activitiesList)) { //loops until the end of the volunteers list, which should return a false
  
  // for each 
  $ruID = $row['Volunteer_ID'];
  $getSQL = mysql_query("SELECT * FROM `User Details` 
  WHERE User_ID = $ruID");
  $rowU = mysql_fetch_array($getSQL);
  
  echo "<tr>";
  if ($i == 0) {
      echo "<td><input type=\"radio\" checked=\"checked\" name=\"regList\" value=".$rowU['User_ID']."></td>";
  } else {
      echo "<td><input type=\"radio\" name=\"regList\" value=".$rowU['User_ID']."></td>";
  }
  echo "<td>" . $ruID . "</td>";
  echo "<td>" . $rowU['Given_Names'] . "</td>";
  echo "<td>" . $rowU['Surname'] . "</td>";
  echo "</tr>";



$i++;
}

?>
</table>




</form>
</div>
</div>




<!-- REGISTERED VOLUNTEERS  -->
<!-- ********************* -->

<div class="contentRectangleActivity" id="rectangleContainer">

<pre id="preAlignH3">
	<h3>Registered Volunteers</h3>
	</pre>



	
<!-- Allows a specific event to be editted -->
<form action="manageRegisteredRole.php?a_ID=<?php echo $aID; ?>" method="post" id="dropdown"> 
<?php
$activityQuery = "SELECT * FROM `Allocated` WHERE Activity_ID ='$aID' AND Allocated = 0";
$activitiesList = mysql_query($activityQuery);


if (mysql_num_rows(mysql_query($activityQuery)) > 0) {
      echo '<input type="submit" value="Manage" class="button" id="updateRoleButton2">'; 
} else {
      echo '<input type="submit" value="Manage" class="button" id="updateRoleButton2" disabled="true">';
}



//a variable created based on the connection to the sql database


//insert the user record into the database
$rolesList = mysql_query("SELECT * FROM `Allocated` 
 WHERE Activity_ID = $aID AND Allocated = 0
 ORDER BY TimeStamp"); 
 
$confirmedUser=mysql_num_rows($get_SQL);
$i=0;
?>

<?php
$i=0;



echo "<div style=\"overflow-y: scroll; overflow-x: hidden;\" class=\"activitySmall\" id=\"positionActivitySmall3\"><table border='1' class=\"table1\" id='container' >
<tr>
<th>Select</th>
<th>User ID</th>
<th>Given Names</th>
<th>Surname</th>
<th>Stamp</th>
</tr>";



while($row = mysql_fetch_array($rolesList)) { //loops until the end of the volunteers list, which should return a false
  
  $ruID = $row['Volunteer_ID'];
  $getSQL = mysql_query("SELECT * FROM `User Details` 
  WHERE User_ID = $ruID");
  $rowU = mysql_fetch_array($getSQL);
  
  echo "<tr>";
  if ($i == 0) {
      echo "<td><input type=\"radio\" checked=\"checked\" name=\"regList\" value=".$rowU['User_ID']."></td>";
  } else {
      echo "<td><input type=\"radio\" name=\"regList\" value=".$rowU['User_ID']."></td>";
  }
  echo "<td>" . $ruID . "</td>";
  echo "<td>" . $rowU['Given_Names'] . "</td>";
  echo "<td>" . $rowU['Surname'] . "</td>";
  echo "<td>" . $row['TimeStamp'] . "</td>";
  echo "</tr>";
  


$i++;
}

?>
</table>

<?php
mysql_close($dbLink); //closes the connection to the database
?>


</form>
</div>
</div>


</div>


</body>
</html>
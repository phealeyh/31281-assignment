<?php

session_start();
$uID = $_SESSION['UserID'];
$_SESSION['AdminCode'] = 103;
$_SESSION['EMCode'] = 102;
$_SESSION['SproutCode'] = 101;
$_SESSION['VolunteerCode'] = 100;
if ($_SESSION['LoggedIn'] != $_SESSION['AdminCode'] && $_SESSION['LoggedIn'] !=$_SESSION['EMCode']) {
    header("Location: index.php");
}

//set the context sensitive help index
$HC = 0;
$_SESSION['HC'] = $HC;

?>

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
</div>


<div class="contentBox">

<h2 id="positionTopH2">User Dashboard</h2>
<!--Send the form for processing to the newEventProcess php file-->
<!-- REGISTERED VOLUNTEERS  -->
<!-- ********************* -->

<div class="contentRectangleActivity" id="rectangleContainer">

<pre id="preAlignH3">
	<h3>My Events</h3>
	</pre>
	<pre id="preAlign">
	Select an event and click "Report" to report and manage the event.
	</pre>
	


	
<!-- Allows a specific event to be editted -->

<?php

//a variable created based on the connection to the sql database
define('DB_NAME', 's1053775_database'); //name of database
define('DB_USER', 's1053775_root'); //name of database user
define('DB_PW', 'W3arethebest'); //password
define('DB_HOST', 'localhost'); //where the database is running

//a variable created based on the connection to the sql database
$dbLink = mysql_connect(DB_HOST,DB_USER, DB_PW);
mysql_select_db(DB_NAME,$dbLink); 


//insert the user record into the database
$rolesList = mysql_query("SELECT * FROM `Event` 
 WHERE Manager_ID = $uID
 ORDER BY Start_Date"); 



?>

<?php
if (mysql_num_rows($rolesList) > 0) {
    echo '<form action="manageEvent.php" method="post" id="dropdown"> 
    <input type="submit" value="Report" class="button" id="updateRoleButton3"> ';
} else {
    echo '<form action="manageEvent.php" method="post" id="dropdown"> 
    <input type="submit" value="Report" class="button" id="updateRoleButton3" disabled="true"> ';
}


$i=0;

echo "<div style=\"overflow-y: scroll; overflow-x: hidden;\" class=\"activitySmall\" id=\"positionActivitySmall2\"><table border='1' class=\"table1\" id='container' >
<tr>
<th>Select</th>
<th>Event</th>
<th>Start Date</th>
<th>End Date</th>
<th>Status</th>


</tr>";

//<th>Required</th>
//<th>Filled</th>

while($row = mysql_fetch_array($rolesList)) { //loops until the end of the volunteers list, which should return a false
  
  /*
  $ruID = $row['Event_ID'];
  $getSQL = mysql_query("SELECT * FROM `Allocated` 
  WHERE User_ID = $ruID");
  $rCount = mysql_num_rows(mysql_fetch_array($getSQL));
  */
  
  echo "<tr>";
  if($i == 0) {
      echo "<td><input type=\"radio\" checked=\"checked\" name=\"event_list\" value=".$row['Event_ID']."></td>";
  } else {
      echo "<td><input type=\"radio\" name=\"event_list\" value=".$row['Event_ID']."></td>";
  }
  echo "<td>" . $row['Name'] . "</td>";
  echo "<td>" . $row['Start_Date'] . "</td>";
  echo "<td>" . $row['End_Date'] . "</td>";
  if ($row['History'] == 0) {
      echo "<td>Draft</td>";
  } else if ($row['History'] == 1) {
      echo "<td>Posted</td>";
  } else if ($row['History'] == 2) {
      echo "<td>Signed Off</td>";
  }
  //echo "<td>" . $rCount . "</td>";
  //echo "<td>" . $row['ActivityPeopleRequired'] . "</td>";
  
  echo "</tr>";


?>

<?php
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
</body>
</html>
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
$HC = 5;
$_SESSION['HC'] = $HC;

?>
<!-- File: manageRegisteredRole.php
 * ------------------------
 * This php file will be concerned with gathering the details of a new volunteer
 * and then submitting that information to the newUserProcess php file. This page will
 * display fields for the volunteer to enter and submit.
 -->
 
<html>
<head>

<link rel="stylesheet" type="text/css" href="buttons.css">
<link rel="stylesheet" type="text/css" href="form.css">

<script>
function inform() {
        alert("There are already enough volunteers allocated to this activity!");
        return false;
}
</script>
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
$uID = $_POST['regList']; 
$aID = $_GET['a_ID'];	



define('DB_NAME', 's1053775_database');//name of database
define('DB_USER', 's1053775_root');//name of database user
define('DB_PW', 'W3arethebest'); //password
define('DB_HOST', 'localhost'); //where the database is running



?>	

<?php
//a variable created based on the connection to the sql database
$dbLink = mysql_connect(DB_HOST, DB_USER, DB_PW);

if (!$dbLink) { //checks if there is a valid db connection; if not, execute statement
    die('Connection failed: ' . msql_error());
    
}
//selects the mysql database based on the link and stores it in a variable
$selectedDB = mysql_select_db(DB_NAME, $dbLink);

if (!$selectedDB) { //checks if there is a valid db selected; if not, execute statement
    die('Error: ' . DB_NAME . ': ' . msql_error());
}
$get_SQL = mysql_fetch_array(mysql_query("SELECT * FROM `Activities` 
 WHERE Activity_ID = $aID")); 

$aName = $get_SQL['Name'];
$aReq = $get_SQL['ActivityPeopleRequired'];

// find allocation numbers
$get_SQL = mysql_query("SELECT * FROM `Allocated` 
 WHERE Activity_ID = $aID AND Allocated = 1"); 

$aCount = mysql_num_rows($get_SQL);


$get_SQL = mysql_fetch_array(mysql_query("SELECT * FROM `Allocated` 
 WHERE Activity_ID = '$aID' AND Volunteer_ID = '$uID'")); 

$aAv = $get_SQL['Availabilities'];
$aNotes = $get_SQL['Notes'];
$stamp = $get_SQL['TimeStamp'];

//insert the user record into the database
$get_SQL = mysql_query("SELECT * FROM `User Details` 
 WHERE User_ID = $uID"); 

//if (!mysql_query($get_SQL)) { //checks if there is a valid record selected; if not, execute statement
//    die('Error: ' . mysql_error());
//}

$i=0;

while($row = mysql_fetch_array($get_SQL)) { //loops until the end of the volunteers list, which should return a false


$guID = $row['User_ID'];
$guGN = $row['Given_Names'];
$guSN = $row['Surname'];
$guPE = $row['Primary_Email'];
$guSE = $row['Secondary_Email'];
$guPP = $row['Primary_Phone'];
$guSP = $row['Secondary_Phone'];
//$guAge = $row['Age'];
$guGender = $row['Male'];


?>
<div class="contentBoxLong">
<h2 id="positionTopH2">Application for <?php echo $aName ?></h2>




<div class="contentRectangleEventLong" id="rectangleContainer">
<pre id="alignHeading3">
<h3>Voluneteer Details</h3>
</pre>


	<pre id="preAlign3">
	UTS ID: <?php echo $guID; ?>
 
   	Given Names: <?php echo $guGN; ?>
 
 	Surname: <?php echo $guSN; ?>
 
 	Primary E-mail: <?php echo $guPE; ?>
 
 	Secondary E-mail: <?php echo $guSE; ?>
 
 	Primary Phone: <?php echo $guPP; ?>
 
 	Secondary Phone: <?php echo $guSP; ?>
 	</pre>
 	<p id="column10">Availabilities:</p>
	<div style="overflow-y: scroll;" class="availability" id="availabilityPosition">
	<p id="pAlign">
	<em><?php echo $aAv; ?></em>
	</div>
	</p>
	
	<p id="column11">Notes:</p>
	<div style="overflow-y: scroll;" class="notes" id="notesPosition">
	<p id="pAlign">
	<em><?php echo $aNotes; ?></em>
	</div>
	</p>
 
 <pre id="column2">
 	Gender: <?php echo $guGender; ?>
 	
 	Registration Time: 
 	<?php echo $stamp; ?>
 	

</pre>

 </div>
 
 
 
 
 
 
<?php
$i++;
}

?>

<?php
mysql_close($dbLink); //closes the connection to the database

?>











<div class="contentRectangleEvent" id="rectangleContainer6">

<pre id="alignHeading4">
	<h3>Volunteer History</h3>
	</pre>
<?php
$dbLink = mysql_connect(DB_HOST,DB_USER, DB_PW);
mysql_select_db(DB_NAME,$dbLink); 
$activityQuery = "SELECT * FROM `Allocated` WHERE Volunteer_ID ='$uID' 
AND Allocated = 2";
$activitiesList = mysql_query($activityQuery);
?>
<?php
$i=0;
echo "<div style=\"overflow-y: scroll; overflow-x: hidden;\" class=\"activitySmall\" id=\"positionActivitySmall5\"><table border='1' class=\"table1\" id='container' >
<tr>
<th>Activity Name</th>
<th>Start Date</th>
<th>End Date</th>
<th>Hours</th>
</tr>";
while($row = mysql_fetch_array($activitiesList)) { //loops until the end of the volunteers list, which should return a false

$aaID = $row['Activity_ID'];
$activityQuery = "SELECT * FROM `Activities` WHERE Activity_ID ='$aaID'";
$rowA = mysql_fetch_array(mysql_query($activityQuery));
  
  echo "<tr>";
  echo "<td>" . $rowA['Name'] . "</td>";
  echo "<td>" . $rowA['Start_Date'] . "</td>";
  echo "<td>" . $rowA['End_Date'] . "</td>";
  echo "<td>" . $rowA['Duration'] . "</td>";
  echo "</tr>";






$i++;

}



mysql_close($dbLink); //closes the connection to the database

?>
</table>
</div>
 
 <?php 
 if ($aCount >= $aReq)
 {
     echo '<form action="updateRegisteredRoleProcess.php?u_ID='.$uID . '&a_ID=' . $aID .'" method="post" onsubmit="return inform()">';
     echo '<input type="submit" value="Allocate" class="greenButton" id="allocateButton9">';
 } else {
     echo '<form action="updateRegisteredRoleProcess.php?u_ID='.$uID . '&a_ID=' . $aID .'" method="post">';
     echo '<input type="submit" value="Allocate" class="greenButton" id="allocateButton9">';
 }
 ?>
 
</form>

<form action="deleteRegisteredRoleProcess.php?u_ID=<?php echo $uID; ?>&a_ID=<?php echo $aID; ?>" method="post">
 <input type="submit" value="Delete" class="redButton" id="deleteButton9">
</form>

</div>







</div>
</body>
</html>
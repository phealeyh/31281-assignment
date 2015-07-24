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

<script>
function confirmReg() {
    if (confirm("Do you want to register for this activity?") == true) {
        return true;
    } else {
        return false;
    }
}


function confirmRegInform() {
        alert("This activity already has enough volunteers, so acceptence of this application can not be guaranteed!");
        return confirmReg();
}


</script>

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
$aID = $_POST['activitieslist'];

if ($aID == null || !isset($_POST['activitieslist'])) {
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
$get_SQL = mysql_query("SELECT * FROM `Activities` 
 WHERE Activity_ID = $aID"); 

//if (!mysql_query($get_SQL)) { //checks if there is a valid record selected; if not, execute statement
//    die('Error: ' . mysql_error());
//}

$i=0;

$row = mysql_fetch_array($get_SQL);


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
$gSP = $row['SproutOnly'];

if($gSP == 1){
    $sHeader = "(S)";
}
$rolesList = mysql_query("SELECT * FROM `Allocated` 
 WHERE Activity_ID = $aID AND Allocated = 1"); 
 
$gAL=mysql_num_rows($rolesList);
//mysql_close($dbLink); //closes the connection to the database
?>




<div class="contentBox">
<h2 id="positionTopH2"><?php echo $gN; ?> <?php echo $sHeader; ?></h2>

<div class="contentRectangleEvent2" id="rectangleContainer">

	<pre id="preAlignH3">
	<h3>Activity Details</h3>
	</pre>
	
	<pre id="preAlign">
	Event Name: <em><?php echo $gN; ?></em>		
	Start Date: <em><?php echo $gSD; ?></em>
	End Date: <em><?php echo $gED; ?></em>
	Start Time: <em><?php echo $gTSD; ?></em> 
        End Time: <em><?php echo $gTED; ?></em> 
	Duration (Hrs): <em><?php echo $gDU; ?></em> 
	Positions Filled:<em><?php echo $gAL; ?>/<?php echo $gRQ; ?></em>
	<?php
	if($gPR > 0)
	{
	echo "Pay Rate: <em>$" . $gPR . "</em>";
	}
	?>
	</pre>
	<p id="column">Description:</p>
	<div style="overflow-y: scroll;" class="eventDescription" id="eventDescriptionPosition">
	<p id="pAlign">
	<em><?php echo $gD; ?></em>
	</p>
<?php 

$rolesList = mysql_query("SELECT * FROM `Allocated` 
 WHERE Activity_ID = $aID"); 
 
$gReg=mysql_num_rows($rolesList);
if ($gReg >= $gRQ) {
    echo '</div><form action="preRegister.php?a_ID=' . $aID . '" method="post" onsubmit="return confirmRegInform()"> 
    <input type="submit" value="Register" class="greenButton" id="registerButton">';
} else {
    echo '</div><form action="preRegister.php?a_ID=' . $aID . '" method="post" onsubmit="return confirmReg()"> 
    <input type="submit" value="Register" class="greenButton" id="registerButton">';
}
?>
</form>
<form action="preRegisterUpdate.php?a_ID=<?php echo $aID; ?>" method="post"> <!-- Specifies where to send the form data -->
<input type="submit" value="Update" class="button" id="updateButtonActivity2">
</form>
	</div>

</div>







	



</body>
</html>
<?php
session_start();
if (!$_SESSION['LoggedIn'] == 101) {
    header("Location: index.php");
} 
//set the context sensitive help index
$HC = 3;
$_SESSION['HC'] = $HC;
?>
<!-- File: updateActivityP.php
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
function checkAM() {
    if (document.getElementById("aManager").checked==1) {
    	enable();
    } else {
    	disable();
    }
}

function disable() {
    document.getElementById("PayRate").disabled=true;
    //alert("True");
}
function enable() {
    document.getElementById("PayRate").disabled=false;
    //alert("False");
}

function checkForm() { //validates the data entered by the user in each field

    //check that a description has been entered
    var check = document.forms["newEvent"]["Description"].value;
    if (check==null || check=="") {
        alert("Please enter a description for the activity!");
        //document.getElementById("nHead").innerHTML = "Please enter a name for the activity!";
        return false;
    }
    
    var check = document.forms["newEvent"]["PayRate"].value;
    if ((check==null || check=="")&&(document.getElementById("aManager").checked==1)) {
        alert("Please enter hourly pay rate!");
        //document.getElementById("nHead").innerHTML = "Please enter hourly pay rate!";
        return false;
    } 
    
     var check = document.forms["newEvent"]["Duration"].value;
    if (!check=="") {
	    var isnum = /^[\d\.]+$/.test(check);
	    if (!isnum) {
	        alert("Please enter a valid duration in hours!");
	        //document.getElementById("nHead").innerHTML = "Please enter a valid Age!";
	        return false;
	    }
     }	
    
    var check = document.forms["newEvent"]["PRG"].value;
    if (!check=="") {
	    var isnum = /^[\d]+$/.test(check);
	    if (!isnum) {
	        alert("Please enter a valid number of volunteers required!");
	        //document.getElementById("nHead").innerHTML = "Please enter a valid Age!";
	        return false;
	    }
     }	
    
    var check = document.forms["newEvent"]["PayRate"].value;
    if (!check=="") {
	    var isnum = /^[\d\.]+$/.test(check);
	    if (!isnum) {
	        alert("Please enter a valid pay rate!");
	        //document.getElementById("nHead").innerHTML = "Please enter a valid Age!";
	        return false;
	    }
     }	
    
    
    
}

function confirmDelete() {
    if (confirm("Are you sure you wish to delete this Event?") == true) {
        return true;
    } else {
        alert("Event was not deleted!");
        return false;
    }
    
}
</script>

<?php // Date Picker Sourced From http://jqueryui.com/datepicker/ 
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script>
$(function() {
  $( "#datepicker" ).datepicker();
});
</script>

<script>
$(function() {
  $( "#datepicker2" ).datepicker();
});
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

<?php $aID= $_GET['a_ID']; ?>


<?php

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

//insert the event record into the database
$get_SQL = "SELECT * FROM `Activities` WHERE Activity_ID = $aID"; 

if (!mysql_query($get_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}
$get_SQL = mysql_query("SELECT * FROM `ActivitiesAddPending` WHERE Activity_ID = $aID"); 
//if (!mysql_query($get_SQL)) { //checks if there is a valid record selected; if not, execute statement
//    die('Error: ' . mysql_error());
//}

$i=0;

while($row = mysql_fetch_array($get_SQL)) { //loops until the end of the events list, which should return a false

//Collect these values from the form and store them into a variable
 $eID = $row['Event_ID'];
 $aName = $row['Name']; 
 $aDescription = $row['Description']; 
 $aDuration = $row['Duration']; 
 $aPayRate = $row['PayRate']; 
 $aSDate = $row['Start_Date']; 
 $aEDate = $row['End_Date']; 
 $aSTime= $row['Start_Time']; 
 $aETime = $row['End_Time']; 
 $aPReq = $row['ActivityPeopleRequired']; 

?>
<div class="contentBoxLong2">
<h2 id="positionTopH3">Update details for activity <?php echo $aName?></h2>

<pre id="instructions">
	General Instructions
</pre>
<pre id="preAlign2">
	Update this activity by changing the details on the form and clicking "Submit".
	To delete this activity, click on the "Delete" button.
	<p id="nHead"></p>
	</pre>

<form name="newEvent" action="updateActivityProcessV.php?a_ID=<?php echo $aID; ?>" method="post" onsubmit="return checkForm()" class="createUser" id="activityUpdateForm">
<!--Send the form for processing to the updateActivityProcess php file-->
<!--Event fields that the user must fill in-->

<h1>Activity Update Form</h1>
<label>
<span>Name</span>
<input id="Name" type="text" name="Name" value="<?php echo $aName; ?>" />
</label>

<label>
<span>*Description</span>
<textarea id="Description" name="Description" rows=5 cols=25><?php echo $aDescription; ?></textarea>
</label>

<label>
<span>Start Date</span>
<input id="datepicker" type="text" name="Start_Date" value="<?php echo $aSDate; ?>"/>
</label>

<label>
<span>End Date</span>
<input id="datepicker2" type="text" name="End_Date" value="<?php echo $aEDate; ?>"/>
</label>

<label>
<span> Start Time </span>
<select type="text" name="timeH" height="4">
<?php
// basic match pattern sourced from - http://stackoverflow.com/questions/6378792/split-time-into-3-variables
preg_match("/([0-9]{1,2}):([0-9]{1,2})/", $aSTime, $match);
$hour = $match[1];
$min = $match[2];

$c = 0;
$v = 0;
$hour = sprintf("%02s", $hour);
$min = sprintf("%02s", $min);
while ($v < 24) {
  $h = sprintf("%02s", $v);
  if ($h == $hour)
  {
  echo "<option  value=".$h." selected>".$h."</option>";
  } else {
  echo "<option value=".$h.">".$h."</option>";
  }
  $c++;
  $v++;
}
?>
</select>
:
<select type="text" name="timeM" height="4">
<?php
$c = 0;
$v = 0;
sprintf("%02s", $num);
while ($v < 60) {
  $h = sprintf("%02s", $v);
  if ($h == $min)
  {
  echo "<option  value=".$h." selected>".$h."</option>";
  } else {
  echo "<option value=".$h.">".$h."</option>";
  }
  $v = $v + 5;
}
?>
</select>
</label>
 
<label>
<span> End Time </span>
<select type="text" name="timeH2" height="4">
<?php
// basic match pattern sourced from - http://stackoverflow.com/questions/6378792/split-time-into-3-variables
preg_match("/([0-9]{1,2}):([0-9]{1,2})/", $aETime, $match);
$hour = $match[1];
$min = $match[2];

$c = 0;
$v = 0;
$hour = sprintf("%02s", $hour);
$min = sprintf("%02s", $min);
while ($v < 24) {
  $h = sprintf("%02s", $v);
  if ($h == $hour)
  {
  echo "<option  value=".$h." selected>".$h."</option>";
  } else {
  echo "<option value=".$h.">".$h."</option>";
  }
  $c++;
  $v++;
}
?>
</select>
:
<select type="text" name="timeM2" height="4">
<?php
$c = 0;
$v = 0;
sprintf("%02s", $num);
while ($v < 60) {
  $h = sprintf("%02s", $v);
  if ($h == $min)
  {
  echo "<option  value=".$h." selected>".$h."</option>";
  } else {
  echo "<option value=".$h.">".$h."</option>";
  }
  $v = $v + 5;
}
?>
</select>
</label>


<label>
<span>Duration (Hr)</span>
<input id="Duration" type="text" name="Duration" value="<?php echo $aDuration; ?>"/>
</label>

<label>
<span>People Required (General)</span>
<input id="PRG" type="text" name="PRG" value="<?php echo $aPReq; ?>"/>
</label>

<label>
<span>Payed Activity?</span>
<?php
if ($aPayRate <= 0)
{
    echo '<input type="checkbox" id="aManager" name="aManager" onchange="checkAM()">';
} else {
    echo '<input type="checkbox" id="aManager" name="aManager" onchange="checkAM()" checked="checked">';
}
?>
</label>

<label>
<span>Pay Rate $</span>
<input id="PayRate" type="text" name="PayRate" disabled="true" value="<?php echo $aPayRate; ?>"/>
</label>

<label>
<span>Sprout Only?</span>
<?php
if ($aSprout == 0)
{
    echo '<input type="checkbox" id="aSprout" name="aSprout">';
} else {
    echo '<input type="checkbox" id="aSprout" name="aSprout" checked="checked">';
}
?>
</label>
 
<label>
<span> &nbsp</span>
<input type="submit" class="greenButton" value="Submit" />
</label>

 
<?php
$i++;
}
mysql_close($dbLink); //closes the connection to the database

?>




</form>
<form action="deleteActivityProcess.php?dActivity_ID=<?php echo $aID?>" onsubmit="return confirmDelete()" method="post">
<input type="submit" class="redButton" value="Delete" id="deleteButton7">
</form>

<br>
<br>
<form action="manageActivity.php?a_ID=<?php echo $aID?>" method="post" id="backButton33">
<input type="submit" value="Back" class="button">
</form>
</div>

</body>
</html>
<?php

session_start();
$_SESSION['AdminCode'] = 103;
$_SESSION['EMCode'] = 102;
$_SESSION['SproutCode'] = 101;
$_SESSION['VolunteerCode'] = 100;
if ($_SESSION['LoggedIn'] != $_SESSION['AdminCode'] && $_SESSION['LoggedIn'] !=$_SESSION['EMCode']) {
    header("Location: index.php");
}

define('DB_NAME', 's1053775_database');//name of database
define('DB_USER', 's1053775_root');//name of database user
define('DB_PW', 'W3arethebest'); //password
define('DB_HOST', 'localhost'); //where the database is running

// set the context sensitive help index
$HC = 2;
$_SESSION['HC'] = $HC;
?>
<!-- File: addActivities.php
 * ------------------------
 * This php file will be concerned with gathering the details of a new activity
 * and then submitting that information to the newActivityProcess php file. This page will
 * display specific fields where the user can specify details about the activity.
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
    
    //check Duration (digits)
    var check = document.forms["newEvent"]["Duration"].value;
    if (!check=="") {
	    var isnum = /^[\d\.]+$/.test(check);
	    if (!isnum) {
	        alert("Please enter a valid phone number!");
	        //document.getElementById("nHead").innerHTML = "Please enter a valid duration!";
	        return false;
	    } 
     }
    
    //check Numbers Required is valid (digits)
    var check = document.forms["newEvent"]["PRG"].value;
    if (!check=="") {
	    var isnum = /^[\d]+$/.test(check);
	    if (!isnum) {
	        alert("Please enter a valid phone number!");
	        //document.getElementById("nHead").innerHTML = "Please enter a valid number of volunteers required!";
	        return false;
	    } 
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

<?php //if redirect has occured ?>
<?php $eID = $_GET['e_ID']; ?>
<?php $aName = $_GET['n']; ?>
<?php $aDescription = $_GET['d']; ?>
<?php $aDuration = $_GET['du']; ?>
<?php $aPayRate = $_GET['pr']; ?>
<?php $aSDate = $_GET['sd']; ?>
<?php $aEDate = $_GET['ed']; ?>
<?php $aSTime= $_GET['st']; ?>
<?php $aETime = $_GET['et']; ?>
<?php $aSDate = $_GET['sd']; ?>
<?php $aPReq = $_GET['rq']; ?>

<div class="contentBoxLong4">
<h2 id="positionTopH2">Create an Activity</h2>
<pre id="instructions">
	General Instructions
</pre>
<pre id="preAlign2">
	Enter names in the fields, then click "Submit" to create a new Activity.
	All fields marked with an asterisk (*) are required.<em id="nHead"></em>
</pre>
<?php //echo $_GET['m'];
 ?>



<!--Send the form for processing to the newActivityProcess php file-->



<form name="newEvent" action="newActivityProcess.php?e_ID=<?php echo $eID; ?>"method="post" class="createUser" onsubmit="return checkForm()">
<!--Activity fields that the user must fill in-->

<h1>Activity Creation Form</h1>


<label>
<span>Event</span>
<?php if($eID == NULL) {
echo "<input id=\"Event_ID\" type=\"text\" name=\"Event_ID\"";
}
else {

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

//get the event name
$get_SQL = mysql_query("SELECT * FROM `Event` WHERE Event_ID = $eID"); 
$row = mysql_fetch_array($get_SQL);
$eventName = $row['Name'];
echo "<b><em>" . $eventName . "</b></em>";

} 

?>
 
 
</label>
<span>&nbsp</span>
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
$c = 0;
$v = 0;
sprintf("%02s", $num);
while ($v < 24) {
  $h = sprintf("%02s", $v);
  echo "<option value=".$h.">".$h."</option>";
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
  echo "<option value=".$h.">".$h."</option>";
  $v = $v + 5;
}
?>
</select>
</label>
 
<label>
<span> End Time </span>
<select type="text" name="timeH2" height="4">
<?php
$c = 0;
$v = 0;
sprintf("%02s", $num);
while ($v < 24) {
  $h = sprintf("%02s", $v);
  echo "<option value=".$h.">".$h."</option>";
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
  echo "<option value=".$h.">".$h."</option>";
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
<input type="checkbox" id="aManager" name="aManager" onchange="checkAM()">
</label>

<label>
<span>Pay Rate $</span>
<input id="PayRate" type="text" name="PayRate" disabled="true" value="<?php echo $aPayRate; ?>"/>
</label>

<label>
<span>Sprout Only?</span>
<input type="checkbox" id="aSprout" name="aSprout">
</label>
 
<label>
<span> &nbsp</span>
<input type="submit" class="button" value="Submit" />
</label>
 </form>
</div>

</body>
</html>
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
$HC = 2;
$_SESSION['HC'] = $HC;
?>

<!-- File: addEvents.php
 * ------------------------
 * This php file will be concerned with gathering the details of a new event
 * and then submitting that information to the newEventProcess php file. This page will
 * display specific fields where the user can specify details about the event.
 -->
 
<html>
<head>

<link rel="stylesheet" type="text/css" href="buttons.css">
<link rel="stylesheet" type="text/css" href="form.css">

<script> //enable/disable elements - base pattern sourced form  http://www.w3schools.com/js/tryit.asp?filename=try_dom_select_disabled
function checkAM() {
    if (document.getElementById("aManager").checked==1) {
    	enable();
    } else {
    	disable();
    }
}

function disable() {
    document.getElementById("volunteer_list").disabled=true;
    //alert("True");
}
function enable() {
    document.getElementById("volunteer_list").disabled=false;
    //alert("False");
}

function checkForm() { //validates the data entered by the user in each field

    //check that a UTS ID has been entered
    var check = document.forms["newEvent"]["Name"].value;
    if (check==null || check=="") {
        alert("Please enter a name for the event!");
        //document.getElementById("nHead").innerHTML = "Please enter a name for the event!";
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


<div class="contentBox " id="container">

<h2 id="positionTopH2">Add a new Event</h2>
<pre id="instructions">
	General Instructions
</pre>
<pre id="preAlign2">
	To create an event, fill out the following form and click submit.
	All fields marked with an asterisk (*) are required. <em id="nHead"></em>
</pre>

<?php //echo $_GET['m']; 
?>

<form name="newEvent" action="newEventProcess.php" method="post" onsubmit="return checkForm()" class="createUser" id="container3">
<!--Volunteer fields that the user must fill in-->

<?php
//Defines the constants along with its values
define('DB_NAME', 's1053775_database'); //name of database
define('DB_USER', 's1053775_root'); //name of database user
define('DB_PW', 'W3arethebest'); //password
define('DB_HOST', 'localhost'); //where the database is running
?>

<h1>Event Creation Form</h1>


<label>
<span>*Name</span>
<input id="Name" type="text" name="Name" />
</label>

<label>
<span>Description</span>
<textarea id="Description" name="Description" rows=5 cols=25></textarea>
</label>

<label>
<span>Start Date</span>
<input id="datepicker" type="text" name="Start_Date" />
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
<span>End Date</span>
<input id="datepicker2" type="text" name="End_Date" />
</label>

<label>
<span>Location</span>
<input id="Location" type="text" name="Location" />
</label>

<label>
<span>Pick Up Address</span>
<input id="PUA" type="text" name="PUA" />
</label>

<label>
<span>Allocate Manager?</span>
<input type="checkbox" id="aManager" name="aManager" onchange="checkAM()">
</label>

<?php

//a variable created based on the connection to the sql database
$dbLink = mysql_connect(DB_HOST,DB_USER, DB_PW);
mysql_select_db(DB_NAME,$dbLink); 

$volunteersList = mysql_query("SELECT * FROM `Account` INNER JOIN `User Details` 
ON Account.UTS_ID = `User Details`.User_ID  
WHERE Account.Privilege IN(2,3) AND `User Details`.Given_Names <> ''   
ORDER BY `User Details`.Given_Names");

?>
<label>
<span> Manager </span>
<select id="volunteer_list" name="volunteer_list" style="width: 200px;" disabled="true">
<?php
$i=0;

while($row = mysql_fetch_array($volunteersList)) { //loops until the end of the volunteers list, which should return a false
?>
<!--Displays the list of  options within the html page-->
<option value=<?=$row["User_ID"];?>><?=$row["Given_Names"] . " " . $row["Surname"] ;?></option>
<?php
$i++;
}

?>
</select>



<?php
mysql_close($dbLink); //closes the connection to the database

?>
</label>

<label>
<span>Post?</span>
<input type="checkbox" id="aPost" name="aPost">
</label>

<label>
<span> &nbsp</span>
<input type="submit" class="button" value="Submit" />
</label>
 
 </form>
</div>

</body>
</html>
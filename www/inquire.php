<?php
session_start();
$_SESSION['AdminCode'] = 103;
$_SESSION['EMCode'] = 102;
$_SESSION['SproutCode'] = 101;
$_SESSION['VolunteerCode'] = 100;
$activeEvent = 0;
if ($_SESSION['LoggedIn'] != $_SESSION['SproutCode'] && $_SESSION['LoggedIn'] !=$_SESSION['VolunteerCode']) {
    
} 
$notSproutOnly = 0;
?>
<!-- File: viewEvents.php
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

<?php

?>

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
         </ul>";
}
?>
</div>

<?php
//Defines the constants along with its values
define('DB_NAME', 's1053775_database'); //name of database
define('DB_USER', 's1053775_root'); //name of database user
define('DB_PW', 'W3arethebest'); //password
define('DB_HOST', 'localhost'); //where the database is running

//a variable created based on the connection to the sql database
$dbLink = mysql_connect(DB_HOST,DB_USER, DB_PW);
$selectedDB = mysql_select_db(DB_NAME,$dbLink); 

?>

 
<html>
<body>




<div class="contentBoxLong4">
<h2 id="positionTopH2">Inquiries</h2>
<pre id="instructions">
	General Instructions
</pre>
<pre id="preAlign2">
	To make an inquiry, please select the manager you wish to contact and leave a brief message. (Please leave contact details)
	</pre>
<form name=newEvent action="inquiryProcess.php" method="post" class="createUser" onsubmit="return checkForm()" id="formPosition2">
<!--Activity fields that the user must fill in-->

<h1>Activity Registration Form</h1>


<label>
<span> Manager </span>
<select id='volunteer_list' name='volunteer_list' style='width: 200px;' >
<?php
$volunteersList = mysql_query("SELECT * FROM `Account` INNER JOIN `User Details` 
ON Account.UTS_ID = `User Details`.User_ID  
WHERE Account.Privilege IN(2,3) AND `User Details`.Given_Names <> ''   
ORDER BY `User Details`.Given_Names");
$i=0;

while($row = mysql_fetch_array($volunteersList)) { //loops until the end of the volunteers list, which should return a false

//Displays the list of  options within the html page
	if($row['User_ID'] == $eManager) {
	    echo "<option value=" . $row['User_ID'] . " selected>" . $row["Given_Names"] . " " . $row["Surname"] . "</option>";
	} else {
	    echo "<option value=" . $row['User_ID'] . ">" . $row["Given_Names"] . " " . $row["Surname"] . "</option>";
	}

        $i++;
}

?>
</select>

</label>

<label>
<span>Topic/Question</span>
<input type="text" name="Topic" />
</label>

<span>&nbsp</span>
<label>
<span>Inquiry:</span>
<textarea id="Av" name="Av" rows=5 cols=25></textarea>
</label>


<label>
<span> &nbsp</span>
<input type="submit" class="button" value="Submit" />
</label>

</form>
<?php

mysql_close($dbLink); //closes the connection to the database

?>
</div>






</body>
</html>
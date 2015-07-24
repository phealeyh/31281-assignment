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
<!-- File: updateEvent.php
 * ------------------------
 * This php file will be concerned with gathering the details of a new volunteer
 * and then submitting that information to the newUserProcess php file. This page will
 * display fields for the volunteer to enter and submit.
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

function confirmDelete() {
    if (confirm("Are you sure you wish to delete this Event?") == true) {
        return true;
    } else {
        alert("Event was not deleted!");
        return false;
    }
    
}

function confirmDeleteDate() {
    if (confirm("Are you sure you wish to delete this Event?") == true) {
        return true;
    } else {
        alert("Event was not deleted!");
        return false;
    }
    
}


</script>

<?php
$message = $_GET['m'];
if($message != "" || $message != null) {
	echo "<script type='text/javascript'>alert('$message');</script>";
}

 // Date Picker Sourced From http://jqueryui.com/datepicker/ 
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

<div class="navAlign" id="container">
<?php echo $_SESSION['Navigation']; ?>
</div>

<?php $eID= $_GET['e_ID']; ?>



<div class="contentBox">
<h2 id="positionTopH2">Update Event</h2>

<pre id="pAlign">
To update an event, change the details in the fields and click on Update.
To remove an event, click on Delete. <p id=nHead></p>
</pre> 

<form name="newEvent" action="updateEventProcessV.php?e_ID=<?php echo $eID ?>" method="post" onsubmit="return checkForm()" class="createUser" id="container3">
<!--Send the form for processing to the updateEventProcess php file-->
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
$get_SQL = mysql_query("SELECT * FROM `EventPending` WHERE Event_ID = $eID"); 

//if (!mysql_query($get_SQL)) { //checks if there is a valid record selected; if not, execute statement
//    die('Error: ' . mysql_error());
//}

$i=0;

while($row = mysql_fetch_array($get_SQL)) { //loops until the end of the events list, which should return a false

$eID = $row['Event_ID'];
$eSDate= $row['Start_Date'];
$eEDate= $row['End_Date'];
$eDescription= $row['Description'];
$eLocation= $row['Location'];
$eName= $row['Name'];
$eSTime = $row['Start_Time'];
$ePUA = $row['PickUp'];
$eDescription = $eDescription;
$eManager = $row['Manager_ID'];
$ePost = $row['History'];

?>
<!--Event fields that the user must fill in-->
<h1>Update Event Details for <?php echo $eName; ?></h1>



<label>
<span>Name</span>
<input id="Name" type="text" name="Name" value='<?php echo $eName; ?>'/>
</label>

<label>
<span>Description</span>
<textarea id="Description" name="Description" rows=5 cols=25><?php echo $eDescription;?></textarea>
</label>

<label>
<span>Start Date</span>
<input id="datepicker" type="text" name="Start_Date" value='<?php echo $eSDate; ?>' />
</label>

<label>
<span> Start Time </span>
<select type="text" name="timeH" height="4">
<?php
preg_match("/([0-9]{1,2}):([0-9]{1,2})/", $eSTime, $match);
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
<span>End Date</span>
<input id="datepicker2" type="text" name="End_Date" value='<?php echo $eEDate; ?>' />
</label>


<label>
<span>Location</span>
<input id="Location" type="text" name="Location" value='<?php echo $eLocation; ?>' />
</label>

<label>
<span>Pick Up Address</span>
<input id="PUA" type="text" name="PUA" value='<?php echo $ePUA; ?>'/>
</label>

<label>
<span>Allocate Manager?</span>
<?php if ($eManager >= 0)
{
    echo "<input type=\"checkbox\" id=\"aManager\" name=\"aManager\" onchange=\"checkAM()\" checked=\"checked\">";
} else {
    echo "<input type=\"checkbox\" id=\"aManager\" name=\"aManager\" onchange=\"checkAM()\">";
}
?>
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
<?php if ($eManager >= 0) {
    echo "<select id='volunteer_list' name='volunteer_list' style='width: 200px;' >";
} else {
    echo "<select id='volunteer_list' name='volunteer_list' style='width: 200px;' disabled='true'>";
}
?>
<?php
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
<span>Post?</span>
<?php if($ePost == 1) {
    echo "<input type=\"checkbox\" id=\"aPost\" name=\"aPost\" checked=\"checked\">";
} else {
    echo "<input type=\"checkbox\" id=\"aPost\" name=\"aPost\">";
} ?>
</label>


 <!--The submit button-->  
<label>
<span> &nbsp</span>
<input type="submit" class="greenButton" value="Update" />

</label>


 
<?php
$i++;
}
mysql_close($dbLink); //closes the connection to the database

?>




 </form>
 
 
<form action="deleteEventProcess.php?dEvent_ID=<?php echo $eID?>" method="post" onsubmit="return confirmDelete()">
<input type="submit" class="redButton" value="Delete" id="deleteButton" on>
</form>


<form action="manageEvent.php?e_ID=<?php echo $eID; ?>" method="post" id="backButton">
<input type="submit" class="button" value="Back">
</form>


</div>

</body>
</html>
<?php

session_start();

$_SESSION['AdminCode'] = 103;
$_SESSION['EMCode'] = 102;
$_SESSION['SproutCode'] = 101;
$_SESSION['VolunteerCode'] = 100;

if ($_SESSION['LoggedIn'] < $_SESSION['VolunteerCode']) {
    header("Location: index.php");
}
//set the context sensitive help index
$HC = 0;
$_SESSION['HC'] = $HC;
?>
<!-- File: prefs.php
 * ------------------------
 * This php file is concerned with updating the users password.
 -->

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

<h2 id="positionTopH2">Preferences</h2>
<pre id="instructions">
	General Instructions
</pre>
<pre id="preAlign2">
	Enter your new password and then reconfirm it below!
</pre>
<!--"<p>Enter names in the fields, then click 'Submit' to submit the form:</p>"-->
<p id=nHead></p>
<!--Send the form for processing to the newUserProcess php file-->

<script>
function checkForm() { //validates the data entered by the user in each field

 
    
    //check the ID that has been entered is a number
    var checkii = document.forms["newUser"]["Passwordii"].value;
    var checki = document.forms["newUser"]["Passwordi"].value;
    if (checkii == "" || checkii != checki) {
        alert("Please enter a valid pair of passwords!");
        //document.getElementById("nHead").innerHTML = "Please enter a numeric ID!";
        return false;
    }
       
    	    
}


</script>

<form name="newUser" action="newPasswordProcess.php"  onsubmit="return checkForm()" method="post" class="createUser">
<!--Volunteer fields that the user must fill in-->

<h1>Preferences - Password Update</h1>

<label>
<span>New Password</span>
<input id="Password" type="password" name="Passwordii" />
</label>

<label>
<span>Reconfirm New Password</span>
<input id="Password" type="password" name="Passwordi" />
</label>

 <!--The submit button-->  
<label>




<? php
// Validate the fields - base pattern sourced from http://www.w3schools.com/js/
?>
<span> &nbsp</span>
<input type="submit" class="button" value="Submit" />
</label>


 </form>
</div>

</body>
</html>
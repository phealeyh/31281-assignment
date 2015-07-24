<?php

session_start();
if ($_SESSION['LoggedIn'] != $_SESSION['AdminCode'] && $_SESSION['LoggedIn'] !=$_SESSION['EMCode']) {
    header("Location: index.php");
}

?>
<!-- File: addUser.php
 * ------------------------
 * This php file will be concerned with gathering the details of a new volunteer
 * and then submitting that information to the newUserProcess php file. This page will
 * display fields for the volunteer to enter and submit.
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

<div class="contentBoxLong2">
<h2 id="positionTopH2">Create a User</h2>
<pre id="instructions">
	General Instructions
</pre>
<pre id="preAlign2">
	Enter names in the fields, then click "Submit" to create a new User.
	All fields marked with an asterisk (*) are required.
</pre>

<p id="nHead"></p>

<!--"<p>Enter names in the fields, then click 'Submit' to submit the form:</p>"-->

<!--Send the form for processing to the newUserProcess php file-->

<script>
function checkForm() {
    var check = document.forms["newUser"]["User_ID"].value;
    if (check==null || check=="") {
        alert("UTS Staff ID Required to proceed!");
        document.getElementById("nHead").innerHTML = "Please ensure a correct UTS Staff ID has been entered!";
        return false;
    }
}
</script>

<form name="newUser" action="newUserProcess.php"  onsubmit="return checkForm()" method="post" class="createUser">
<!--Volunteer fields that the user must fill in-->

<h1>User Creation Form</h1>
<label>
<span>*UTS ID</span>
<input id="User_ID" type="text" name="User_ID" maxlength="8" />
</label>

<label>
<span>*Password</span>
<input id="Password" type="password" name="Password" />
</label>

<label>
<span>*Reconfirm Password</span>
<input id="Password" type="password" name="Password" />
</label>

<label>
<span>*User Type</span>
<select id="usertype_list" name="usertype_list" style="width: 400px, height: 50px;">
<?php if ($_SESSION['LoggedIn'] == $_SESSION['AdminCode']) { //if they are an admin they can create another admin
 echo "<option value='3'>Admin</option>";
} ?>
<option value="2">Event Manager</option>
<option value="1">Sprout</option>
<option value="0">Volunteer</option>
</select>
</label>


<label>
<span>*Given Names</span>
<input id="Given_Names" type="text" name="Given_Names" />
</label>

<label>
<span>*Surname</span>
<input id="Surname" type="text" name="Surname" />
</label>

<label>
<span>*Primary E-mail</span>
<input id="Primary_Email" type="text" name="Primary_Email" />
</label>

<label>
<span>Secondary E-mail</span>
<input id="Secondary_Email" type="text" name="Secondary_Email" />
</label>

<label>
<span>*Primary Phone</span>
<input id="Primary_Phone" type="text" name="Primary_Phone" />
</label>

<label>
<span>Secondary Phone</span>
<input id="Secondary_Phone" type="text" name="Secondary_Phone" />
</label>

<label>
<span>Age</span>
<input id="Age" type="text" name="Age" />
</label>

<label>
<span>*Gender</span>
<input type="radio" name="gender" value="0">Female</input>
<input type="radio" name="gender" value="1">Male</input>
</label>


 <!--The submit button-->  
<label>


</head>

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
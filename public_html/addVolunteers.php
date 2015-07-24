<?php

session_start();
if ($_SESSION['LoggedIn'] != $_SESSION['AdminCode'] && $_SESSION['LoggedIn'] !=$_SESSION['EMCode']) {
    header("Location: index.php");
}

?>
<!-- File: addVolunteers.php
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
<ul class="navButton">

<li><a href="dashboard.php">Dashboard</a></li>
<li><a href="createEvent.html">Events</a></li>
<li id="current"><a href = "viewVolunteers.php">Volunteers</a></li>

</ul>
</div>

<div class ="contentBox">
<h2 id="positionTopH2">Create a Volunteer</h2>
<pre id="preAlign2">
	Enter names in the fields, then click "Submit" to submit the form:
	</pre>
<!--Send the form for processing to the newUserProcess php file-->

<form action="newUserProcess.php" method="post" class="createUser">
<!--Volunteer fields that the user must fill in-->

<h1>Volunteer Creation Form</h1>
<label>
<span>UTS ID</span>
<input id="User_ID" type="text" name="User_ID" maxlength="8" />
</label>

<label>
<span>Given Names</span>
<input id="Given_Names" type="text" name="Given_Names" />
</label>

<label>
<span>Surname</span>
<input id="Surname" type="text" name="Surname" />
</label>

<label>
<span>Primary E-mail</span>
<input id="Primary_Email" type="text" name="Primary_Email" />
</label>

<label>
<span>Secondary E-mail</span>
<input id="Secondary_Email" type="text" name="Secondary_Email" />
</label>

<label>
<span>Primary Phone</span>
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
<span>Gender</span>
<input id="Gender" type="text" name="Gender" />
</label>


 <!--The submit button-->  
<label>
<span> &nbsp</span>
<input type="submit" class="button" value="Submit" />
</label>


 </form>
</div>

</body>
</html>
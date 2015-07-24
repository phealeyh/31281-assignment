<!-- File: addRoles.php
 * ------------------------
 * This php file will be concerned with gathering the details of a new role
 * and then submitting that information to the newActivityProcess php file. This page will
 * display specific fields where the user can specify details about the activity.
 -->
 
<html>
<head>

<link rel="stylesheet" type="text/css" href="buttons.css">
<link rel="stylesheet" type="text/css" href="form.css">
</head>
<body>

<div id="header">
</div>
<div id="banner">
UTS Event Management System
</div>
<div class="navAlign" id="container">
<ul class="navButton">

<li><a href="dashboard.php">Dashboard</a></li>
<li><a href="viewEvents.php">Events</a></li>
<li><a href = "viewVolunteers.php">Volunteers</a></li>
<li><a href = "viewActivities.php">Activities</a></li>
<li id="current"><a href = "viewRoles.php">Roles</a></li>



</ul>
</div>
<div class="contentBoxLong2">
<h2 id="positionTopH2">Create a new Role</h2>
<pre id="instructions">
	General Instructions
</pre>
<pre id="preAlign2">
	Enter names in the fields, then click "Submit" to create a new Role.
	All fields marked with an asterisk (*) are required.
</pre>


<!--Send the form for processing to the newActivityProcess php file-->

<?php $eID = $_GET['e_ID']; ?>
<?php $aID = $_GET['a_ID']; ?>

<form action="newRoleProcess.php?e_ID=<?php echo $eID; ?>&a_ID=<?php echo $aID?>"method="post" class="createUser" >
<!--Activity fields that the user must fill in-->

<h1>Role Creation Form</h1>
<label>
<span>*Role ID</span>
<input id="Role_ID" type="text" name="Role_ID" maxlength="8" />
</label>

<label>
<span>Event ID</span>
<label>
<?php echo $eID; ?>
</label>
</label>

<label>
<span>Activity ID</span>
<label>
<?php echo $aID; ?>
</label>
</label>

<label>
<span>*Name</span>
<input id="Name" type="text" name="Name" />
</label>

<label>
<span>Description</span>
<textarea id="Description" name="Description" rows=5 cols=25></textarea>
</label>

<label>
<span>*Start Date</span>
<input id="Start_Date" type="Date" name="Start_Date" />
</label>

<label>
<span>*End Date</span>
<input id="End_Date" type="Date" name="End_Date" />
</label>

<label>
<span>*Start Time</span>
<input id="Start_Time" type="time" name="Start_Time" />
</label>

<label>
<span>*End Time</span>
<input id="End_Time" type="time" name="End_Time" />
</label>


<label>
<span>*Volunteers Required</span>
<input id="Positions_Required" type="text" name="Positions_Required" />
</label>

<label>
<span> &nbsp</span>
<input type="submit" class="button" value="Submit" />
</label>
 
 </form>
</div>

</body>
</html>
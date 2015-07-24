<?php

session_start();
//codes allocated for each user type
$_SESSION['AdminCode'] = 103;
$_SESSION['EMCode'] = 102;
$_SESSION['SproutCode'] = 101;
$_SESSION['VolunteerCode'] = 100;

if ($_SESSION['LoggedIn'] != $_SESSION['AdminCode'] && $_SESSION['LoggedIn'] !=$_SESSION['EMCode']) {
    header("Location: index.php");
}

if(!isset($_POST['volunteer_list']) || $_POST['volunteer_list'] == 0) {
   //header("Location: viewUsers.php");
}



?>
<!-- File: updateVolunteer.php
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

<?php $uID = $_POST['volunteer_list']; ?>

<div class="contentBox">
<h2 id="positionTopH2">Update User Details: <?php echo $uID ?></h2>

<pre id="preAlign2">
	To update a user, change the details in the fields and then click on Update.
	To remove a user, click on Delete.
</pre>

<form action="updateUserProcess.php" method="post" class="createUser" id="container3">
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

//insert the user record into the database
$get_SQL = "SELECT * FROM `User Details` 
 WHERE User_ID = $uID"; 
 
if (!mysql_query($get_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}

//if (!mysql_query($get_SQL)) { //checks if there is a valid record selected; if not, execute statement
//    die('Error: ' . mysql_error());
//}



$row = mysql_fetch_array(mysql_query($get_SQL));


$guID = $row['User_ID'];
$guGN = $row['Given_Names'];
$guSN = $row['Surname'];
$guPE = $row['Primary_Email'];
$guSE = $row['Secondary_Email'];
$guPP = $row['Primary_Phone'];
$guSP = $row['Secondary_Phone'];
$guAge = $row['Age'];
$guGender = $row['Male'];
?>
<!--Volunteer fields that the user must fill in-->

<h1>Update Details Form</h1>
<label>
<span>UTS ID</span>
<input type="text" name="User_ID" value='<?php echo $guID; ?>'>
</label>


<label>
<span>Given Names</span>
<input type="text" name="Given_Names" value='<?php echo $guGN; ?>'>
</label>

<label>
<span>Surname</span>
<input type="text" name="Surname" value='<?php echo $guSN; ?>'>
</label>

<label>
<span>Primary E-mail</span>
<input type="text" name="Primary_Email" value='<?php echo $guPE; ?>'>
</label>

<label>
<span>Secondary E-mail</span>
<input type="text" name="Secondary_Email" value='<?php echo $guSE; ?>'>
</label>

<label>
<span>Primary Phone</span>
<input type="text" name="Primary_Phone" value='<?php echo $guPP; ?>'>
</label>

<label>
<span>Secondary Phone</span>
<input type="text" name="Secondary_Phone" value='<?php echo $guSP; ?>'>
</label>

<label>
<span>Age</span>
<input id="Age" type="text" name="Age" value='<?php echo $guAge; ?>' />
</label>

<label>
<span>Gender</span>
<input type="text" name="Male" value='<?php echo $guGender; ?>'>
</label>


<label>
<span>&nbsp</span>
 <input type="submit" class="button" value="Update" />

 </label>
<?php

mysql_close($dbLink); //closes the connection to the database

?>

 </form>
 
<form action="deleteUserProcess.php?duser_ID=<?php echo $guID ?>" method="post">
<input type="submit" value="Delete" id="deleteButton" class="button">
</form>


<form action="viewVolunteers.php" method="post" id="backButton">
<input type="submit" value="Back" class="button" >
</form>
</div>

</body>
</html>
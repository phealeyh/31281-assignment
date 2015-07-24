<?php

session_start();

$_SESSION['AdminCode'] = 103;
$_SESSION['EMCode'] = 102;
$_SESSION['SproutCode'] = 101;
$_SESSION['VolunteerCode'] = 100;

if ($_SESSION['LoggedIn'] < $_SESSION['volunteerCode']) {
    header("Location: index.php");
}

if($_POST['Passwordi'] == "")
{
    header("Location: index.php");
}

$nPassword = $_POST['Passwordi'];
?>
<!-- File: updateUserProcess.php
 * ------------------------
 * This php file is concerned with appending the user/volunteer details and record
 * into the sql database based on the submitted information from the user
 -->

<link rel="stylesheet" type="text/css" href="buttons.css">
</head>
<body>

<div id="header">
</div>
<div id="menu">
<ul class="navButton">


</ul>
</div>

<div id ="content">

<?php
//Defines the constants along with its values
define('DB_NAME', 's1053775_database');//name of database
define('DB_USER', 's1053775_root');//name of database user
define('DB_PW', 'W3arethebest'); //password
define('DB_HOST', 'localhost'); //where the database is running

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

$uID = $_SESSION['UserID'];
//insert the user record into the database
$update_SQL = "UPDATE `Account` 
 SET Password = '$nPassword'
 WHERE UTS_ID = '$uID'";
 
if (!mysql_query($update_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}


mysql_close(); //close the connection to the database
echo '<script type="text/javascript">
	   window.alert("Password Updated!");
           window.location = "index.php"
      </script>';
?>

<form action="viewUsers.php" method="post">
<input type="submit" value="Back"><!--creates the back button-->
</form>

</div>

</body>
</html>
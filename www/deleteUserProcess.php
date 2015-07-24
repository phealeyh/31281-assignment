<?php

session_start();

$_SESSION['AdminCode'] = 103;
$_SESSION['EMCode'] = 102;
$_SESSION['SproutCode'] = 101;
$_SESSION['VolunteerCode'] = 100;

if ($_SESSION['LoggedIn'] != $_SESSION['AdminCode'] && $_SESSION['LoggedIn'] !=$_SESSION['EMCode']) {
    header("Location: index.php");
}

?>
<!-- File: newUserProcess
 * ------------------------
 * This php file is concerned with appending the user/volunteer details and record
 * into the sql database based on the submitted information from the user
 -->

<link rel="stylesheet" type="text/css" href="buttons.css">
</head>
<body>

<div id="header">
<?php $currentUser = $_SESSION['Name']; ?>
Logged in as: <b><?php echo $currentUser; ?></b>            <a href="logout.php"> Log Out </a>
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
//Collect these values from the form and store them into a variable
$uID = $_GET['duser_ID'];

/*
//check for active events 
//insert the account details
$check_SQL = "SELECT * FROM `Manager History`
WHERE HManager_ID = $uID AND History = 0";

if (!mysql_query($check_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}

$confirmedUser=mysql_num_rows(mysql_query($check_SQL));

if($confirmedUser>0){ //checks if there is a valid record selected; if not, execute statement
    echo '<script type="text/javascript">
	   window.alert("Please ensure the manager has no active events remaining!");
           window.history.back();
      </script>';
      die('Error: Please ensure the manager has no active events remaining!');
}
*/
//insert the user record into the database
$update_SQL = "DELETE FROM `User Details` 
 WHERE User_ID = '$uID'";

if (!mysql_query($update_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}


$update_SQL = "DELETE FROM `Account` 
 WHERE UTS_ID = '$uID'";

if (!mysql_query($update_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}
echo '<script type="text/javascript">
	   window.alert("User Deleted!");
           window.location = "viewUsers.php"
      </script>';
echo "$uID was removed!";

mysql_close(); //close the connection to the database
?>

<form action="viewUsers.php" method="post">
<input type="submit" value="Back"><!--creates the back button-->
</form>

</div>

</body>
</html>
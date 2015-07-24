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
$uID = $_POST['User_ID'];
$uID = mysql_real_escape_string($uID);
$uPW = $_POST['Password'];
$uTP = $_POST['usertype_list'];
$uGN = $_POST['Given_Names'];
$uGN = mysql_real_escape_string($uGN);
$uSN = $_POST['Surname'];
$uSN = mysql_real_escape_string($uSN);
$uPE = $_POST['Primary_Email'];
$uPE = mysql_real_escape_string($uPE);
$uSE = $_POST['Secondary_Email'];
$uSE = mysql_real_escape_string($uSE);
$uPP = $_POST['Primary_Phone'];
$uPP = mysql_real_escape_string($uPP);
$uSP = $_POST['Secondary_Phone'];
$uSP = mysql_real_escape_string($uSP);
$uAge = $_POST['Age'];
$uAge = mysql_real_escape_string($uAge);
$uGender = $_POST['Gender'];
$uSK = $_POST['Skills'];
$uSK = mysql_real_escape_string($uSK);
$uTR = $_POST['Training'];
$uTR = mysql_real_escape_string($uTR);
$aID = $uID . $uTP;
$oID = $_GET['o_ID'];

//insert the account details
$check_SQL = "SELECT * FROM `User Details`
WHERE User_ID = $uID";

if (!mysql_query($check_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}

$confirmedUser=mysql_num_rows(mysql_query($check_SQL));

if($confirmedUser==1 && $oID != $uID){ //checks if there is a valid record selected; if not, execute statement
    echo '<script type="text/javascript">
	   window.alert("User already exists!");
           window.history.back();
      </script>';
      die('Error: User already exists!');
}

//insert the account details
$check_SQL = "SELECT * FROM `User Details`
WHERE User_ID = $oID";

//insert the user record into the database
$update_SQL = "UPDATE `User Details` 
 SET User_ID = '$uID', Given_Names = '$uGN', Surname = '$uSN', Primary_Email = '$uPE',
 Secondary_Email ='$uSE', Primary_Phone ='$uPP', Secondary_Phone ='$uSP', Age ='$uAge', Male ='$uGender', Skills = '$uSK', Training = '$uTR'
 WHERE User_ID = '$oID'";

if (!mysql_query($update_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}


//insert the user record into the database
$update_SQL = "UPDATE `Allocated` 
 SET Volunteer_ID = '$uID'
 WHERE Volunteer_ID = '$oID'";

mysql_query($update_SQL);

//insert the user record into the database
$update_SQL = "UPDATE `Event` 
 SET Manager_ID = '$uID'
 WHERE Manager_ID = '$oID'";

mysql_query($update_SQL);

//insert the user record into the database
$update_SQL = "UPDATE `Allocated` 
 SET Volunteer_ID = '$uID'
 WHERE Volunteer_ID = '$oID'";
 
mysql_query($update_SQL);

//insert the user record into the database
$update_SQL = "UPDATE `Allocated` 
 SET User_ID = '$uID'
 WHERE Volunteer_ID = '$oID'";
 
mysql_query($update_SQL);

//insert the user record into the database
$update_SQL = "UPDATE `Account` 
 SET UTS_ID = '$uID',
 Privilege = '$uTP'
 WHERE UTS_ID = '$oID'";
 
if (!mysql_query($update_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}

//insert the user record into the database
$update_SQL = "UPDATE `EventPending` 
 SET Manager_ID = '$uID'
 WHERE Manager_ID = '$oID'";
 
mysql_query($update_SQL);

mysql_close(); //close the connection to the database
echo '<script type="text/javascript">
	   window.alert("User Updated!");
           window.location = "viewUsers.php"
      </script>';
?>

<form action="viewUsers.php" method="post">
<input type="submit" value="Back"><!--creates the back button-->
</form>

</div>

</body>
</html>
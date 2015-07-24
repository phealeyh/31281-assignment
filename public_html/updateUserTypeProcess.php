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

$typeRequest = $_POST['volunteer_list'];


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


$check = "SELECT * FROM `Account` WHERE UTS_ID = '$typeRequest' ";
$row = mysql_fetch_array(mysql_query($check));
$type = $row['Privilege'];

if ($type > 1)
{
   $header = "Location: updateUserEM.php?u_ID=" . $typeRequest;
   header($header);
} else {
   $header = "Location: updateUserV.php?u_ID=" . $typeRequest;
   header($header);
}

/*
if ($typeRequest == 2) {
	echo '<script type="text/javascript">
              window.location = "addUserEM.php"
              </script>';
} else {
        echo '<script type="text/javascript">
              window.location = "addUserV.php"
              </script>';
} 
*/
?>
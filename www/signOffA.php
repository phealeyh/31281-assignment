<?php
session_start();
$_SESSION['AdminCode'] = 103;
$_SESSION['EMCode'] = 102;
$_SESSION['SproutCode'] = 101;
$_SESSION['VolunteerCode'] = 100;

if ($_SESSION['LoggedIn'] != $_SESSION['AdminCode'] && $_SESSION['LoggedIn'] !=$_SESSION['EMCode']) {
    header("Location: index.php");
} 


$eID= $_GET['e_ID'];

$eventDraft = 0;
$eventActive = 1;
$eStatus = 2;

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

$aID = $_GET['a_ID'];



if (!mysql_query($update_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}

$i=0;
$activitiesSQL = mysql_query("SELECT * from Activities WHERE Activity_ID = '$aID'");
while($row = mysql_fetch_array($activitiesSQL)) {
     $update_SQL = "UPDATE `Activities` 
     SET  History = '$eStatus'
     WHERE Activity_ID = '$aID'";
     $aID = $row['Activity_ID'];
     $update_SQL = mysql_query("UPDATE `Allocated` 
     SET  Allocated = '$eStatus'
     WHERE Activity_ID = '$aID'
     AND Allocated = 1");
     $i++;
 }




$rURL = "Location: manageEvent.php?e_ID=" . $eID;
header($rURL);


mysql_close(); //close the connection to the database
?>
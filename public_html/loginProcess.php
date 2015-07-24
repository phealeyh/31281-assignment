<?php
session_start();
// This page is for checking for the valididty of the login credentials entered into the system. The general login source code has been sourced form
// - http://www.phpeasystep.com/phptu/6.html -

//Defines the constants along with its values
define('DB_NAME', 's1053775_database'); //name of database
define('DB_USER', 's1053775_root'); //name of database user
define('DB_PW', 'W3arethebest'); //password
define('DB_HOST', 'localhost'); //where the database is running

//a variable created based on the connection to the sql database
$dbLink = mysql_connect(DB_HOST,DB_USER, DB_PW) or die(mysql_error());
$selectedDB = mysql_select_db(DB_NAME,$dbLink) or die(mysql_error());


// the username and password being tested 
$userID=$_POST['username']; 
$password=$_POST['password']; 

// SQL Injection counter measures 
$userID = stripslashes($userID);
$password = stripslashes($password);
$userID = mysql_real_escape_string($userID);
$password = mysql_real_escape_string($password);
$login_sql="SELECT * FROM Account
WHERE UTS_ID='$userID' AND Password='$password'";
$check=mysql_query($login_sql);


// Determine rows returned
$confirmedUser=mysql_num_rows($check);

// If a row has been confirmed
if($confirmedUser==1){

//get the privelage code for the user and 100 to avoid website access with 0
$row = mysql_fetch_array($check);
$accessLevel = $row['Privilege'] + 100;

// Create new session and go to the main page

$_SESSION['UserID'] = $userID;
$_SESSION['LoggedIn'] = $accessLevel;
echo '<script type="text/javascript">
           window.location = "userAuthenticated.php"
      </script>';
} else {
echo '<script type="text/javascript">
           alert("The Username or Password entered is not correct!");
           window.location = "index.php"
      </script>';
      echo "The Username or Password entered is not correct!";
}
?>
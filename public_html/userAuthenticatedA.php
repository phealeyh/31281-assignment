<?php
session_start();
//codes allocated for each user type
$_SESSION['AdminCode'] = 103;
$_SESSION['EMCode'] = 102;
$_SESSION['SproutCode'] = 101;
$_SESSION['VolunteerCode'] = 100;

// Redirect if not login unsuccessful pattern sourced from 
// - http://www.phpeasystep.com/phptu/6.html
// scheck if session is active by examining if accesscode has been officially determined
if ( $_SESSION['LoggedIn'] >= $_SESSION['VolunteerCode'] ){
//Defines the constants along with its values
define('DB_NAME', 's1053775_database'); //name of database
define('DB_USER', 's1053775_root'); //name of database user
define('DB_PW', 'W3arethebest'); //password
define('DB_HOST', 'localhost'); //where the database is running

//a variable created based on the connection to the sql database
$dbLink = mysql_connect(DB_HOST,DB_USER, DB_PW);
$selectedDB = mysql_select_db(DB_NAME,$dbLink); 

$currentUser = $_SESSION['UserID'];
$get_SQL=mysql_query("SELECT * FROM `User Details`
WHERE User_ID = $currentUser");

$row = mysql_fetch_array($get_SQL);
$Given_Names = $row['Given_Names'];
$Surname = $row['Surname'];

$loggedInAs = $Given_Names . " " . $Surname;

$_SESSION['Name'] = $loggedInAs;

$_SESSION['Navigation'] ="<ul class=\"navButton\">
	<li><a href=\"dashboardU.php\">Dashboard</a></li>
	<li><a href=\"viewPositions.php\">Voluteer</a></li>
	<li><a href = \"prefs.php\">Preferences</a></li>
	<li><a href = \"helpDirect.php\" target=\"_blank\">Help</a></li>
	</ul>";

   $aID = $_GET['a_ID'];
   $rURL = "Location: preRegister.php?a_ID=" . $aID;
   header($rURL);
   exit;


if ($_SESSION['LoggedIn'] == $_SESSION['AdminCode'] ){
 $_SESSION['Navigation'] = "<ul class=\"navButton\">
 <li><a href=\"dashboardEM.php\">Dashboard</a></li>
	<li id=\"current\"><a href=\"viewEventsEM.php\">Events</a></li>
	<li><a href = \"viewUsers.php\">Users</a></li>
	<li><a href = \"prefs.php\">Preferences</a></li>
	<li><a href = \"helpDirect.php\" target=\"_blank\">Help</a></li>
	</ul>";
echo '<script type="text/javascript">
           window.location = "viewEventsEM.php"
      </script>';
} else if ($_SESSION['LoggedIn'] == $_SESSION['EMCode']) {
 $_SESSION['Navigation'] ="<ul class=\"navButton\">
	<li><a href=\"dashboardEM.php\">Dashboard</a></li>
	<li id=\"current\"><a href=\"viewEventsEM.php\">Events</a></li>
	<li><a href = \"viewUsers.php\">Users</a></li>
	<li><a href = \"prefs.php\">Preferences</a></li>
	<li><a href = \"helpDirect.php\" target=\"_blank\">Help</a></li>
	</ul>";
echo '<script type="text/javascript">
           window.location = "viewEventsEM.php"
      </script>';
} else {
   $_SESSION['Navigation'] ="<ul class=\"navButton\">
	<li><a href=\"dashboardU.php\">Dashboard</a></li>
	<li><a href=\"viewPositions.php\">Voluteer</a></li>
	<li><a href = \"prefs.php\">Preferences</a></li>
	<li><a href = \"helpDirect.php\" target=\"_blank\">Help</a></li>
	</ul>";

   $aID = $_GET['a_ID'];
   $rURL = "Location: preRegister.php?a_ID=" . $aID;
   header($rURL);
   exit;
}

      
echo '<body>
 Login Successful!!!
 </body>';
      
} else {

echo "<body>
 isset failed.
</body>";

}
?>
<html>
</html>
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

$typeRequest = $_POST['usertype_list'];



if ($typeRequest == 2) {
	echo '<script type="text/javascript">
              window.location = "addUserEM.php"
              </script>';
} else {
        echo '<script type="text/javascript">
              window.location = "addUserV.php"
              </script>';
} 
?>

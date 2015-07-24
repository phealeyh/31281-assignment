<?php
session_start();




?>
<!-- File: registerVolunteerRoleProcess.php
 * ------------------------
 * This html file contains the list of events within the system.
 * It is also responsible for establishing the connection between the database and requesting
 * queries about the list of events. It displays the events in a drop down box.
 -->
 
<html>
<head>

<link rel="stylesheet" type="text/css" href="buttons.css">
<link rel="stylesheet" type="text/css" href="form.css">

</head>
<body>

<div id="header">
<?php $currentUser = $_SESSION['Name']; ?>
<?php
if ($_SESSION['LoggedIn'] == $_SESSION['SproutCode'] || $_SESSION['LoggedIn'] ==$_SESSION['VolunteerCode']) {
    echo "Logged in as: <b>" . $currentUser . "</b>            <a href=\"logout.php\"> Log Out </a>";
} else {
    echo "Viewing as: <b>Guest</b>            <a href=\"index.php\"> Sign In</a>";
}
?>
</div>

<div class="navAlign" id="container">
<?php 
if ($_SESSION['LoggedIn'] == $_SESSION['SproutCode'] || $_SESSION['LoggedIn'] ==$_SESSION['VolunteerCode']) {
    echo $_SESSION['Navigation'];
} else {
    echo "<ul class=\"navButton\">
         <li id=\"current\"><a href=\"viewPositions.php\">Volunteer</a></li>
         </ul>";
}


echo '<script type="text/javascript">
           alert("You are already registered for this activity!");
           window.location = "viewPositions.php"
      </script>';

?>
</div>



<div class="contentBoxLong4">
<h2 id="positionTopH2">Activity Registration</h2>
<form name=newEvent action="register.php?a_ID=<?php echo $aID; ?>"method="post" class="createUser" onsubmit="return checkForm()">
<!--Activity fields that the user must fill in-->

<h1>You are already Registered for this Activity!</h1>


</div>






</body>
</html>
<?php

session_start();
$_SESSION['AdminCode'] = 103;
$_SESSION['EMCode'] = 102;
$_SESSION['SproutCode'] = 101;
$_SESSION['VolunteerCode'] = 100;
if ($_SESSION['LoggedIn'] > 99 ){
    header("Location: viewPositions.php");
}



?>
<!-- File: manageEvent.php
 * ------------------------
 * This html file contains the list of events within the system.
 * It is also responsible for establishing the connection between the database and requesting
 * queries about the list of events. It displays the events in a drop down box.
 -->
<html>
<head>
<link rel="stylesheet" type="text/css" href="loginform.css">
<link rel="stylesheet" type="text/css" href="buttons.css">

<link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>

<div id="header">
<?php $currentUser = $_SESSION['Name']; ?>

</div>
<div id="banner">
UTS Event Management System
</div>

<div class="navAlign" id="container">
<?php echo $_SESSION['Navigation']; ?>
</div>


<?php 
 
$aID = $_GET['a_ID'];	
?>






<form action="loginProcessA.php?a_ID=<?php echo $aID; ?>" method="post" class="login">
<h1>UTS EMS<span>Login with your username and password. If you do not have an account, sign up to register for the activity!</span></h1>

<label>
<span>Username</span>
<input id="username" type="text" name="username" placeholder="Username" />
</label>

<label>
<span>Password</span> 
<input id="password" type="password" name="password" placeholder="Password" 
</label>


<label>
<span></span>
<input type="submit" class="button" value="Login" />
</label>



</form>


 

 <form action="addUserA.php?a_ID=<?php echo $aID; ?>" method="post">
 <label>
 <span>&nbsp</span>
 <input type="submit" class="greenButton" value="Sign Up" />
 </label>
</form>





</body>
</html>
<?php

session_start();
if ($_SESSION['LoggedIn'] != $_SESSION['AdminCode'] && $_SESSION['LoggedIn'] !=$_SESSION['EMCode']) {
    header("Location: index.php");
}

?>
<!-- File: newSkillProcess
 * ------------------------
 * This php file is concerned with adding a new skill into the database
 -->

<link rel="stylesheet" type="text/css" href="buttons.css">
</head>
<body>

<div id="header">
<?php $currentUser = $_SESSION['Name']; ?>
Logged in as: <b><?php echo $currentUser; ?></b>            <a href="logout.php"> Log Out </a>
</div>
<div id="menu">

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

$sName = $_POST['Skill_Name'];
$sDescription = $_POST['Description'];


//insert the account details
$add_SQL = "INSERT INTO `Skills` 
 (Skill_Name, Skill_Description)
 VALUES
 ('$sName','$sDescription')";

if (!mysql_query($add_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}

//insert the user details
$add_SQL = "INSERT INTO `User Details` 
 (User_ID, Given_Names, Surname, Primary_Email,
 Secondary_Email, Primary_Phone, Secondary_Phone, Age, Male)
 VALUES
 ('$uID', '$uGN', '$uSN', '$uPE', 
 '$uSE', '$uPP', '$uSP', '$uAge', '$uGender')";

if (!mysql_query($add_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}






mysql_close(); //close the connection to the database
echo '<script type="text/javascript">
	   window.alert("New User Added!");
           window.location = "manageSkills.php"
      </script>';
      
echo $sName . " added!";
?>


<form action="manageSkills.php" method="post">
<input type="submit" value="Back"><!--creates the back button-->
</form>

</div>

</body>
</html>
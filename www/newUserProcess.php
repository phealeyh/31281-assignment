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


if ($uID == null || $uID == 0 ) {
    $uID = rand(100000000,999999999); 
}


//insert the account details
$check_SQL = "SELECT * FROM `User Details`
WHERE User_ID = $uID";

if (!mysql_query($check_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error2: ' . mysql_error());
}

$confirmedUser=mysql_num_rows(mysql_query($check_SQL));

if($confirmedUser==1 && isset($_POST['User_ID'])){ //checks if there is a valid record selected; if not, execute statement
    echo '<script type="text/javascript">
	   window.alert("User already exists!");
           window.history.back();
      </script>';
      die('Error: User already exists!');
}

//insert the account details
if (!isset($_POST['User_ID']) && $confirmedUser==1) {
    while ($confirmedUser==1) {
        $uID = rand(100000000,999999999);
        
        $check_SQL = "SELECT * FROM `User Details`
        WHERE User_ID = $uID";  

        if (!mysql_query($check_SQL)) { //checks if there is a valid record selected; if not, execute statement
            die('Error3: ' . mysql_error());
        }

        $confirmedUser=mysql_num_rows(mysql_query($check_SQL));


        
        }
}

$aID = $uID;

//insert the account details
$add_SQL = "INSERT INTO `Account` 
 (ID, UTS_ID, Privilege, Password)
 VALUES
 ('$aID','$uID', '$uTP', '$uPW')";

if (!mysql_query($add_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error4: ' . mysql_error());
    
}

//insert the user details
$add_SQL = "INSERT INTO `User Details` 
 (User_ID, Given_Names, Surname, Primary_Email,
 Secondary_Email, Primary_Phone, Secondary_Phone, Age, Male, Skills, Training)
 VALUES
 ('$uID', '$uGN', '$uSN', '$uPE', 
 '$uSE', '$uPP', '$uSP', '$uAge', '$uGender', '$uSK', '$uTR')";

if (!mysql_query($add_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error2: ' . mysql_error());
}



//echo $uGN . " " . $uSN . " was successfully added!";

if (!$uPE == null && !$uPE == "") {

$subject = "UTS EMS New Account";
$message = "Hi " . $uGN . ",

A new UTS EMS account has just been created for you!

Your User ID is: " . $uID . "
Your password is: " . $uPW . "
(Please update this to a password of your choice through your preferences.)

Welcome to the team!";

$headers = "From: UTS EMS";
mail($uPE,$subject,$message, $headers);
}






mysql_close(); //close the connection to the database
echo '<script type="text/javascript">
	   window.alert("New User Added!");
           window.location = "viewUsers.php"
      </script>';
?>


<form action="viewUsers.php" method="post">
<input type="submit" value="Back"><!--creates the back button-->
</form>

</div>

</body>
</html>
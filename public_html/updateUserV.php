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
//set the context sensitive help index
$HC = 6;
$_SESSION['HC'] = $HC;
?>
<!-- File: addUser.php
 * ------------------------
 * This php file will be concerned with gathering the details of a new volunteer
 * and then submitting that information to the newUserProcess php file. This page will
 * display fields for the volunteer to enter and submit.
 -->
 
<html>
<head>

<link rel="stylesheet" type="text/css" href="buttons.css">
<link rel="stylesheet" type="text/css" href="form.css">

</head>
<body>

<div id="header">
<?php $currentUser = $_SESSION['Name']; ?>
Logged in as: <b><?php echo $currentUser; ?></b>            <a href="logout.php"> Log Out </a>
</div>

<div id="banner">
UTS Event Management System
</div>
<div class="navAlign" id="container">
<?php echo $_SESSION['Navigation']; ?>
</div>

<div class="contentBoxLong">
<h2 id="positionTopH2">Update User</h2>

<pre id="instructions">
	General Instructions
</pre>
<pre id="preAlign2">
	To update a User, change the details in the fields and click on Update.
	To remove a User, click on Delete. <em id=nHead></em>
	
</pre>



<!--"<p>Enter names in the fields, then click 'Submit' to submit the form:</p>"-->
<p id=nHead></p>
<!--Send the form for processing to the newUserProcess php file-->

<script>
function checkForm() { //validates the data entered by the user in each field

    //check that a UTS ID has been entered
    var check = document.forms["newUser"]["User_ID"].value;
    if (check==null || check=="") {
        alert("Please ensure a correct UTS ID has been entered!");
        //document.getElementById("nHead").innerHTML = "Please ensure a correct UTS ID has been entered!";
        return false;
    }
    
    //check the ID that has been entered is a number
    var isnum = /^\d+$/.test(check);
    if (!isnum) {
        alert("Please enter a numeric ID!");
        //document.getElementById("nHead").innerHTML = "Please enter a numeric ID!";
        return false;
    }
    
    
    //check the first name is valid (only contains letters, "'" and "-")
    var check = document.forms["newUser"]["Given_Names"].value;
    var isName = /^[a-z\s"'"-]+$/i.test(check);
    if (!check=="") {
	    if (!isName) {
	        alert("Please use only letters, apostrophies and hyphons for names!");
	        //document.getElementById("nHead").innerHTML = "Please use only letters, apostrophies and hyphons for names!";
	        return false;
	    }
     } 	   
     
    var check = document.forms["newUser"]["Surname"].value;
    var isName = /^[a-z\s"'"-]+$/i.test(check);
    if (!check=="") {
	    if (!isName) {
	        alert("Please use only letters, apostrophies and hyphons for names!");
	        //document.getElementById("nHead").innerHTML = "Please use only letters, apostrophies and hyphons for names!";
	        return false;
	    }
     }
    
    //check for valid e-mail entry - base pattern sourced from http://www.w3schools.com/js/js_form_validation.asp
    var check = document.forms["newUser"]["Primary_Email"].value;
    if (!check=="") {
	    var atCheck = check.indexOf("@");
	    var periodCheck = check.lastIndexOf(".");
	    if (atCheck< 1 || periodCheck<atCheck+2 || periodCheck+2>=check.length) {
	        alert("Please enter a valid email address!");
	        //document.getElementById("nHead").innerHTML = "Please enter a valid primary email address!";
	        return false;
	    }
   } 
   
   //check for valid secondary e-mail entry - base pattern sourced from http://www.w3schools.com/js/js_form_validation.asp
    var check = document.forms["newUser"]["Secondary_Email"].value;
    if (!check=="") {
	    var atCheck = check.indexOf("@");
	    var periodCheck = check.lastIndexOf(".");
	    if (atCheck< 1 || periodCheck<atCheck+2 || periodCheck+2>=check.length) {
	        alert("Please enter a valid email address!");
	        //document.getElementById("nHead").innerHTML = "Please enter a valid secondary email address!";
	        return false;
	    }
   } 
   
   //check Primary Phone is valid (digits, “(”, “)”, “+”, “ “)
    var check = document.forms["newUser"]["Primary_Phone"].value;
    if (!check=="") {
	    var isnum = /^[\d\(\)\+\s]+$/.test(check);
	    var plusCheck = check.indexOf("+");
	    var openBracketCheck = check.lastIndexOf("(");
	    var closedBracketCheck = check.lastIndexOf(")");
	    if (!isnum || plusCheck > 0 || openBracketCheck > closedBracketCheck) {
	        alert("Please enter a valid phone number!");
	        //document.getElementById("nHead").innerHTML = "Please enter a valid primary phone number!";
	        return false;
	    } 
     }	
     
     //check Secondary Phone is valid (digits, “(”, “)”, “+”, “ “)
    var check = document.forms["newUser"]["Secondary_Phone"].value;
    if (!check=="") {
	    var isnum = /^[\d\(\)\+\s]+$/.test(check);
	    var plusCheck = check.indexOf("+");
	    var openBracketCheck = check.lastIndexOf("(");
	    var closedBracketCheck = check.lastIndexOf(")");
	    if (!isnum || plusCheck > 0 || openBracketCheck > closedBracketCheck) {
	        alert("Please enter a valid phone number!");
	        //document.getElementById("nHead").innerHTML = "Please enter a valid secondary phone number!";
	        return false;
	    }
     }	    
     
     
}


</script>

<script>
function inform() {
    var check = document.forms["newUser"]["Primary_Email"].value;
    if (!check=="") {
	    var atCheck = check.indexOf("@");
	    var periodCheck = check.lastIndexOf(".");
	    if (atCheck< 1 || periodCheck<atCheck+2 || periodCheck+2>=check.length) {
	        alert("Please enter a valid email address!");
	        //document.getElementById("nHead").innerHTML = "Please enter a valid primary email address!";
	        return false;
	    } else {
	        return true;
	    }
   } else { 
        alert("Please enter a valid email address!");
        return false;
   }
}
</script>

<script>
function confirmDelete() {
    if (confirm("Are you sure you wish to delete this User?") == true) {
        return true;
    } else {
        alert("User was not deleted!");
        return false;
    }
    
}
</script>

<script>
function cantDelete() {
        alert("Cannot Delete: User is currently listed in an active Event!");
        return false;
    
    
}
</script>

<?php $uID = $_GET['u_ID']; ?>
<?php $oID = $_GET['u_ID']; ?>

<form action="reportUser.php?u_ID=<?php echo $uID; ?>" method="post" id="deleteButton2">
        <input type="submit" value="Reporting"  class="Button" >
</form>

<form name="newUser" action="updateUserProcess.php?o_ID=<?php echo $oID; ?>"  onsubmit="return checkForm()" method="post" class="createUser">
<!--Volunteer fields that the user must fill in-->



<?php

define('DB_NAME', 's1053775_database');//name of database
define('DB_USER', 's1053775_root');//name of database user
define('DB_PW', 'W3arethebest'); //password
define('DB_HOST', 'localhost'); //where the database is running



?>	

<?php
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

//insert the user record into the database
$get_SQL = "SELECT * FROM `User Details` 
 WHERE User_ID = $uID"; 
 
if (!mysql_query($get_SQL)) { //checks if there is a valid record selected; if not, execute statement
    die('Error: ' . mysql_error());
}

//if (!mysql_query($get_SQL)) { //checks if there is a valid record selected; if not, execute statement
//    die('Error: ' . mysql_error());
//}



$row = mysql_fetch_array(mysql_query($get_SQL));


$guID = $row['User_ID'];
$guGN = $row['Given_Names'];
$guSN = $row['Surname'];
$guPE = $row['Primary_Email'];
$guSE = $row['Secondary_Email'];
$guPP = $row['Primary_Phone'];
$guSP = $row['Secondary_Phone'];
$guAge =  $row['Age'];
$guGender =  $row['Male'];
$guSK = $row['Skills'];
$guTR = $row['Training'];

$get_SQL = "SELECT * FROM `Account` 
WHERE UTS_ID = $uID"; 
$row = mysql_fetch_array(mysql_query($get_SQL));
$guTP = $row['Privilege'];

?>




<h1>User Update Form</h1>
<label>
<span>ID</span>
<input id="User_ID" type="text" name="User_ID" value='<?php echo $guID; ?>'/>
</label>

<label>
<span>Password</span>
<a href="resetPW.php?u_ID=<?php echo $guID; ?>" onclick='return inform()'>Reset</a>
</label>

<label>
<span>User Type</span>
<select id="usertype_list" name="usertype_list" style="width: 400px, height: 50px;">
<?php
if($guTP == 0) {
    echo '<option value="0" selected>Volunteer</option>';
    echo '<option value="1">Sprout</option>';
} else {
    echo '<option value="0">Volunteer</option>';
    echo '<option value="1" selected>Sprout</option>';
}
?>
</select>
</label>

<label>
<span>Given Names</span>
<input id="Given_Names" type="text" name="Given_Names" value='<?php echo $guGN; ?>' />
</label>

<label>
<span>Surname</span>
<input id="Surname" type="text" name="Surname" value='<?php echo $guSN; ?>'/>
</label>

<label>
<span>Primary E-mail</span>
<input id="Primary_Email" type="text" name="Primary_Email" value='<?php echo $guPE; ?>'/>
</label>

<label>
<span>Secondary E-mail</span>
<input id="Secondary_Email" type="text" name="Secondary_Email" value='<?php echo $guSE; ?>'/>
</label>

<label>
<span>Primary Phone</span>
<input id="Primary_Phone" type="text" name="Primary_Phone" value='<?php echo $guPP; ?>'/>
</label>

<label>
<span>Secondary Phone</span>
<input id="Secondary_Phone" type="text" name="Secondary_Phone" value='<?php echo $guSP; ?>'/>
</label>


<label>
<span>Gender</span>
<?php if($guGender == 1) {
echo "<input type=\"radio\" name=\"Gender\" value=\"2\">Female</input>
<input type=\"radio\" checked=\"checked\" name=\"Gender\" value=\"1\">Male</input>";
} else if($guGender == 2) {
echo "<input type=\"radio\" name=\"Gender\" checked=\"checked\" value=\"2\">Female</input>
<input type=\"radio\" name=\"Gender\" value=\"1\">Male</input>";
} else {
    echo "<input type=\"radio\" name=\"Gender\" value=\"2\">Female</input>
    <input type=\"radio\" name=\"Gender\" value=\"1\">Male</input>";
}
?>
</label>

<label>
<span>Skills</span>
<textarea id="Skills" name="Skills" rows=5 cols=25><?php echo $guSK; ?></textarea>
</label>

<label>
<span>Training</span>
<textarea id="Training" name="Training" rows=5 cols=25><?php echo $guTR; ?></textarea>
</label>

 <!--The submit button-->  
<label>
<span> &nbsp</span>
<input type="submit" class="greenButton" value="Submit" />
</label>


</form>
 
<?php
$check_SQL = "SELECT * FROM `Allocated` 
WHERE Volunteer_ID = $uID
AND Allocated = 1"; 
$row = mysql_fetch_array(mysql_query($check_SQL));
$confirmedUser=mysql_num_rows(mysql_query($check_SQL));

if($confirmedUser >= 1)
{
    echo '<form action="deleteUserProcess.php?duser_ID=' . $guID . '" onsubmit="return cantDelete()" method="post">';
} else {
    echo '<form action="deleteUserProcess.php?duser_ID=' . $guID . '" onsubmit="return confirmDelete()" method="post">';
} 

?>
<input type="submit" value="Delete" id="deleteButton2" class="redButton">
</form>


<form action="viewUsers.php" method="post" id="backButton2">
<input type="submit" value="Back" class="button" >
</form>


 
</div>
<?php

mysql_close($dbLink); //closes the connection to the database

?>


</body>
</html>
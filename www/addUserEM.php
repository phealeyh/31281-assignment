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
$HC = 1;
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

<div class="contentBox">
<h2 id="positionTopH2">Create new Admin or Event Manager</h2>
<pre id="instructions">
	General Instructions
</pre>
<pre id="preAlign2">
	To create an Admin or Event Manager, fill out the following form and click submit.
	All fields marked with an asterisk (*) are required.
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
    var isnum = /^[\d]+$/.test(check);
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

<form name="newUser" action="newUserProcess.php"  onsubmit="return checkForm()" method="post" class="createUser">
<!--Volunteer fields that the user must fill in-->

<h1>User Creation Form</h1>
<label>
<span>*UTS ID</span>
<input id="User_ID" type="text" name="User_ID" />
</label>

<label>
<span>Password</span>
<input id="Password" type="password" name="Password" value="password" />
</label>


<label>
<span>User Type</span>
<select id="usertype_list" name="usertype_list" style="width: 400px, height: 50px;">
<?php if ($_SESSION['LoggedIn'] == $_SESSION['AdminCode']) { //if they are an admin they can create another admin
 echo "<option value='3'>Admin</option>";
} ?>
<option value="2">Event Manager</option>
</select>
</label>


<label>
<span>Given Names</span>
<input id="Given_Names" type="text" name="Given_Names" />
</label>

<label>
<span>Surname</span>
<input id="Surname" type="text" name="Surname" />
</label>

<label>
<span>Primary E-mail</span>
<input id="Primary_Email" type="text" name="Primary_Email" />
</label>

<label>
<span>Secondary E-mail</span>
<input id="Secondary_Email" type="text" name="Secondary_Email" />
</label>

<label>
<span>Primary Phone</span>
<input id="Primary_Phone" type="text" name="Primary_Phone" />
</label>

<label>
<span>Secondary Phone</span>
<input id="Secondary_Phone" type="text" name="Secondary_Phone" />
</label>


 <!--The submit button-->  
<label>




<? php
// Validate the fields - base pattern sourced from http://www.w3schools.com/js/
?>
<span> &nbsp</span>
<input type="submit" class="button" value="Submit" />
</label>


 </form>
</div>

</body>
</html>
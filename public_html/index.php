<!doctype html>
<html>
<head>
  <title> UTS Event Management System </title>	
  <link rel="stylesheet" type="text/css" href="index.css">
  <link rel="stylesheet" type="text/css" href="loginform.css">

  <meta name="author" content="Adrian Marando">
  <meta name="description" content="SDP Draft System">
</head>



<body>
<div class="container">



    <form action="loginProcess.php" method="post" class="login">
    <h1>UTS EMS<span>Login with your username and password.</span></h1>
<label>
<span>Username</span>
<input id="username" type="text" name="username" placeholder="Username" />
</label>

<label>
<span>Password</span> 
<input id="password" type="password" name="password" placeholder="Password" 
</label>


<label>
<span>&nbsp</span>


 
<input type="submit" class="button" value="Login" />
</label>



</form>
<form action="addUserA.php">
<label>
<span>&nbsp</span>


 
<input type="submit" class="greenButton" value="Sign Up" />
</label>
</form>

</div><!--container-->

<div id="footer">
	<p> SDP Group 14 2014 </p>
	<p><a href="http://utsems.wikia.com/wiki/Login"><span>Help: Wiki</span></a></p>
    </div><!--footer--> 
</body>
</html>
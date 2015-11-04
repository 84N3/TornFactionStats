<?php
// Start the session
session_start();
//Debugging
//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);

?>
<html>
	<head>
		<title>TFS - Login</title>
		<link rel="stylesheet" type="text/css" href="css/01frame.css">
		<link rel="stylesheet" type="text/css" href="css/02content.css">
		<?php //includes
		include "functions/connectToDatabase.php"; 
		?>
	</head>
	<body>
		<div class="header">
			<ul class="nav">
				<li><a href="home.php" class="title">TORN<br> Faction Stats</a></li>
				<li><a href="help.php" class="navItem">HELP</a></li>
			</ul>
		</div>
		
		<div class="content">
			<form action="functions/loginViaSession.php" method="post" class="login">
				<label>LOGIN (ID):</label> <input type="text" name="loginID" id="loginID"><br><br>
				<label>KEY:</label> <input type="password" name="loginKey" id="loginKey"><br><br>
				<input type="submit" value="LOGIN" id="loginButton"><br><br>
			</form>
		</div>
	</body>
</html>
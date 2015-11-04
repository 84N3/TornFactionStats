<?php
session_start();

//Debugging
error_reporting(E_ALL ^ E_DEPRECATED);
ini_set('display_errors', TRUE);

if ($_SESSION["valid"] == 0) {
	//If unlogged tries to access page redirect to login page.
	header('location: index.php');
}

?>
<html>
	<head>
		<title>TFS - Home</title>
		<link rel="stylesheet" type="text/css" href="css/01frame.css">
		<link rel="stylesheet" type="text/css" href="css/02content.css">
		<?php //includes
			include "connectToDatabase.php"; 
		?>
	</head>
	<body>
		<div class="header">
			<ul class="nav">
				<li><a href="home.php" class="title">TORN<br> Faction Stats</a></li>
				<li><a href="functions/logoutViaSession.php" class="navItem">LOGOUT</a></li>
				<li><a href="help.php" class="navItem">HELP</a></li>
				<li><a href="config.php" class="navItem">CONFIG</a></li>
				
			</ul>
		</div>
			
		<div class="content">
			<ul class="navList">
				<li><a href="overview.php">OVERVIEW</a></li>
				<li><a href="singlePlayerView.php">SINGLE PLAYER STATS</a></li>
			</ul> 
		</div>
	</body>
</html>
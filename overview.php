<?php
	// Start the session
	session_start();

	//Debugging
	error_reporting(E_ALL ^ E_DEPRECATED);
	ini_set('display_errors', TRUE);
	
	//includes
	include "functions/connectToDatabase.php";
	
	connect(null);
	setDB(null);
	$ids = execQuery("SELECT id,name FROM player WHERE lastupdate=CURDATE() ORDER BY total DESC;",1);
	
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
				<li><a href="home.php" class="navItem">HOME</a></li>
			</ul>
		</div>
		
		<div class="content">
			<table class="statsTable">
				<tr><th>PLAYER</th><th>STRENGTH</th><th>SPEED</th><th>DEXTERITY</th><th>DEFENSE</th><th>TOTAL</th><tr>
				<?php
				for($i=1;$i<=80;$i++) {
					$row = mysqli_fetch_array($ids, MYSQLI_ASSOC);
					if($row['id']!=NULL) {
						$stats = execQuery("SELECT * FROM player WHERE id=".$row['id']." AND lastupdate=CURDATE() ORDER BY total ASC;",0);
						$rowStats = mysqli_fetch_array($stats, MYSQLI_ASSOC);
						
						if($_SESSION["loginID"]!=$rowStats['id']) {
							echo "<tr align='right'><td align='left'><a href='http://www.torn.com/profiles.php?XID=".$rowStats['id']."' target='_blank'>".$rowStats['name']."</a></td><td>".number_format($rowStats['str'],4)."</td><td>".number_format($rowStats['spd'],4)."</td><td>".number_format($rowStats['dex'],4)."</td><td>".number_format($rowStats['def'],4)."</td><td>".number_format($rowStats['total'],4)."</tr>";
						} else {
							echo "<tr align='right'><td align='left' style='background-color:#DDD;'><a href='http://www.torn.com/profiles.php?XID=".$rowStats['id']."' target='_blank'>".$rowStats['name']."</a></td><td style='background-color:#DDD;'>".number_format($rowStats['str'],4)."</td><td style='background-color:#DDD;'>".number_format($rowStats['spd'],4)."</td><td style='background-color:#DDD;'>".number_format($rowStats['dex'],4)."</td><td style='background-color:#DDD;'>".number_format($rowStats['def'],4)."</td><td style='background-color:#DDD;'>".number_format($rowStats['total'],4)."</tr>";
						}
					}
				}
				?>
			</table>
		</div>
	</body>
</html>
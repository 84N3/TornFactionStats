<?php
// Start the session
session_start();
//Debugging
//error_reporting(E_ALL ^ E_DEPRECATED);
//ini_set('display_errors', TRUE);

if ($_SESSION["valid"] == 0) {
	//If unlogged/not leader tries to access page redirect to login page.
	header('location: index.php');
} elseif($_SESSION["leader"] == 0) {
	header('location: home.php');
}

?>
<html>
	<head>
		<title>TFS - Config</title>
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
				<li><a href="functions/logoutViaSession.php" class="navItem">LOGOUT</a></li>
				<li><a href="help.php" class="navItem">HELP</a></li>
				<li><a href="home.php" class="navItem">HOME</a></li>
			</ul>
		</div>
		
		<div class="content">
		<form action ="functions/saveToDatabase.php" method="post">
			<div class="inputFields">
				<table cellpadding="40">
			<?php
				connect(null);
				setDB(null);
				$data = execQuery("SELECT id,name,apikey FROM player GROUP BY name ORDER BY lastupdate DESC;",1);

				$zaehler=1;
				for ($x = 1; $x <= 16; $x++) {
					echo "<tr>";
					for($i=1;$i<=5;$i++) {
						$row = mysql_fetch_array($data, MYSQL_ASSOC);
						echo "
							<td>
							<b>$row[name]</b><br>  
							ID: <input class='id' type='text' name='id".$zaehler."' value='".$row['id']."'> <br> 
							API Key: <input type='text' name='key".$zaehler."' value='".$row['apikey']."'> <br><br>
							</td>
						"; //id='id".$zaehler."'  id='key".$zaehler."'
						$zaehler++;
					}
					echo "</tr>";
				}
			?>
				</table>
			</div>
			<div class="speichern">
				<input type='Submit' value='SAVE CHANGES'>
			</div>
		</form>
		</div>
	</body>
</html>
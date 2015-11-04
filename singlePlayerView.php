<?php
	// Start the session
	session_start();

	//Debugging
	error_reporting(E_ALL ^ E_DEPRECATED);
	ini_set('display_errors', TRUE);
	
	//includes
	require "functions/connectToDatabase.php";
	require "functions/displaySingleStats.php";
	require "functions/GoogChart.class.php";
	
	// Create chart
	$chart = new GoogChart();
	
	//Set colors
	$color = array(
		'#0066FF', //Str
		'#FF9933', //Spd
		'#33CC33', //Dex
		'#CC0000', //Def
	);
	
	$pieColor = array(
		'#222222',
		'#666666',
		'#AAAAAA',
		'#EEEEEE',
	);
	
	connect(null);
	setDB(null);
	$ids = execQuery("SELECT id,name FROM player WHERE lastupdate=CURDATE();",1);
	$singleID = execQuery("SELECT name FROM player WHERE id=".$_SESSION["loginID"].";",1);
	
?>
<html>
	<head>
		<title>TFS - Home</title>
		<link rel="stylesheet" type="text/css" href="css/01frame.css">
		<link rel="stylesheet" type="text/css" href="css/02content.css">
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
		
		<form action="singlePlayerView.php" method="post">
				<div class="selector">
					<select class="selection" name="selectionSingle" id="selectionSingle">
						<?php
						if($_SESSION["leader"]==1) {
							for($x=1;$x<80;$x++) {
								$row = mysql_fetch_array($ids, MYSQL_ASSOC);
								if($row['id']!=NULL && $row['id']!="") {
									echo "<option value=".$row['id'].">".$row['name']."</option>";
								}
							}
						} else {
							$row = mysql_fetch_array($singleID, MYSQL_ASSOC);
							if($row['name']!=NULL && $row['name']!="") {
								echo "<option value=".$_SESSION["loginID"].">".$row['name']."</option>";
							}
						}
						?>
					</select> 
					<input type="submit" value="SELECT" class="GoButton">
						<div class="singleStats">
						<?php
							if($_SERVER['REQUEST_METHOD'] == 'POST') {

									$data = execQuery("SELECT * FROM player WHERE id=".$_POST['selectionSingle'].";",1);
									
									//echo "SELECT * FROM player WHERE id=".$_POST['selectionSingle'].";"."<br><br>";
									//echo var_dump($data)."<br><br>";
									
									$str = array();
									$def = array();
									$spd = array();
									$dex = array();
									
									for($i=1;$i<=30;$i++) {
										$asd = mysql_fetch_array($data, MYSQL_ASSOC);
										if(isset($asd['id'])) {
											//echo var_dump($asd)."<br><br>";
											
											switch($asd['total']) {
												case $asd['total']<1000000:
													$div=10000;
													$divPrint="10k";
													break;
												case (($asd['total']>1000000)&&($asd['total']<10000000)):
													$div = 10000;
													$divPrint="10k";
													break;
												case (($asd['total']>10000000)&&($asd['total']<100000000)):
													$div = 100000;
													$divPrint="100k";
													break;
												case (($asd['total']>100000000)&&($asd['total']<1000000000)):
													$div = 10000000;
													$divPrint="10m";
													break;
												case (($asd['total']>1000000000)&&($asd['total']<10000000000)):
													$div = 100000000;
													$divPrint="100m";
													break;
												default:
													$div=0;
													break;
												default:
													$div=1;
													break;
											}
											
											$str[$asd['lastupdate']] = ($asd['str']/$div);
											$def[$asd['lastupdate']] = ($asd['def']/$div);
											$spd[$asd['lastupdate']] = ($asd['spd']/$div);
											$dex[$asd['lastupdate']] = ($asd['dex']/$div);
										}
									}
									
									//echo var_dump($str)."<br><br>";

									$dataTimeline = array();
									$dataTimeline["Strength"] = $str;
									$dataTimeline["Defense"] = $def;
									$dataTimeline["Speed"] = $spd;
									$dataTimeline["Dexterity"] = $dex;
									
									//echo var_dump($dataTimeline);
									
		/* ---------- Actuall echos ---------------------------*/
		
									$clutter = execQuery("SELECT * FROM player WHERE id=".$_POST['selectionSingle']." AND lastupdate=CURDATE();",1);
									$clutterRow = mysql_fetch_array($clutter, MYSQL_ASSOC);
		
									echo "<h1>Battlestats ".$clutterRow['name']."[".$_POST['selectionSingle']."]"."</h1>";
									
									echo "<h2>Distribution</h2>";
									/* # Chart 1 # */

									$piestats = array();
									
									$prozent = $clutterRow['total']/100;
									
									$piestats['Strength'] = ($clutterRow['str']/$prozent);
									$piestats['Speed'] = ($clutterRow['spd']/$prozent);
									$piestats['Dexterity'] = ($clutterRow['dex']/$prozent);
									$piestats['Defense'] = ($clutterRow['def']/$prozent);
									
									$chart->setChartAttrs( array(
										'type' => 'pie',
										'data' => $piestats,
										'size' => array( 400, 300 ),
										'color' => $color
										));
									// Print chart
									echo $chart;
									echo "<br><br><br>";
									/* # Chart 3 # */
									echo '<h2>Timeline</h2>';
									$chart->setChartAttrs( array(
										'type' => 'line',
										'title' => 'Battlestats in '.$divPrint,
										'data' => $dataTimeline,
										'size' => array( 900 , 300 ),
										'color' => $color,
										'labelsXY' => true,
										
									));
									// Print chart
									echo $chart;
							}
						?>
						<br><br><br><br><br>
						</div>
				</div>
				
				
				
			</form>
		
		
	</body>
</html>

<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);

include "connectToDatabase.php";

connect(null);
setDB(null);
$player = execQuery("SELECT id,name,apikey FROM player;",1);

for($i=1;$i<=80;$i++) {
	$rowPlayer = mysql_fetch_array($player, MYSQL_ASSOC);
	//$stats = execQuery("SELECT * FROM stats WHERE idstats=".$rowPlayer['id'].";");
	//$rowStats = mysql_fetch_array($stats, MYSQL_ASSOC);
	
	if($rowPlayer['id']!="" && $rowPlayer['apikey']!="" && $rowPlayer['id']!=NULL && $rowPlayer['apikey']!=NULL) {
		//JSON Verarbeitung
		$url = "http://api.torn.com/user/".$rowPlayer['id']."?selections=profile,battlestats&key=".$rowPlayer['apikey'];
		$response = file_get_contents($url);
		$data = json_decode($response, true);
		
		$id = $rowPlayer['id'];
		$key = "'".$rowPlayer['apikey']."'";
		$name = "'".$data['name']."'";
		$str = $data['strength'];
		$spd = $data['speed'];
		$dex = $data['dexterity'];
		$def = $data['defense'];
		$mod_str = $data['strength_modifier'];
		$mod_spd = $data['speed_modifier'];
		$mod_dex = $data['dexterity_modifier'];
		$mod_def = $data['defense_modifier'];
		$total = $str+$spd+$dex+$def;
		
		$update ="UPDATE player SET
		name=".$name.",
		apikey=".$key.",
		str=".$str.",
		spd=".$spd.",
		dex=".$dex.",
		def=".$def.",
		mod_str=".$mod_str.",
		mod_def=".$mod_def.",
		mod_spd=".$mod_spd.",
		mod_dex=".$mod_dex.",
		total=".$total."
		WHERE
		id=".$id." AND
		lastupdate = CURDATE();";
		
		//Query ausfuehren
		execQuery($update,0);
	}
}

header('location: ../home.php');
?>
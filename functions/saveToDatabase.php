<?php
// Start the session
session_start();
//Debugging
error_reporting(E_ALL); //^ E_DEPRECATED
ini_set('display_errors', TRUE);

include "connectToDatabase.php";

connect(null);
setDB(null);

for($x=1;$x<=80;$x++) {

	$id = $_POST['id'.$x];
	$key = $_POST['key'.$x];
	if ($key!=NULL && $key!="") {
		
		$id = mysql_real_escape_string($id);
		$key = mysql_real_escape_string($key);
		
		//JSON Verarbeitung
		$url = "http://api.torn.com/user/".$id."?selections=profile,battlestats&key=".$key;
		$response = file_get_contents($url);
		$data = json_decode($response, true);
		
		if(($data['strength']!=NULL) && ($data['strength']!="") {
			$key = "'".$key."'";
			$name = "'".$data['name']."'";
			$str = $data['strength'];
			$spd = $data['speed'];
			$dex = $data['dexterity'];
			$def = $data['defense'];
			$mod_str = $data['strength_modifier'];
			$mod_spd = $data['speed_modifier'];
			$mod_dex = $data['dexterity_modifier'];
			$mod_def = $data['defense_modifier'];
			$total = $str + $spd + $dex + $def;
			
			//Query
			$insertPlayer ="INSERT INTO player VALUES(".$id.",".$name.",".$key.",".$str.",".$spd.",".$dex.",".$def.",".$mod_str.",".$mod_def.",".$mod_spd.",".$mod_dex.",".$total.",CURDATE());";
		
			//echo $insertPlayer;
			execQuery($insertPlayer,0);
		}
	}
}

header('location: ../home.php');
?>
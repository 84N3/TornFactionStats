<?php
// Start the session
session_start();

//Debugging
error_reporting(E_ALL ^ E_DEPRECATED);
ini_set('display_errors', TRUE);

// Save login infor
$_SESSION["loginID"] = $_POST['loginID'];
$_SESSION["loginKey"] = $_POST['loginKey'];

//JSON Test auf Gueltigkeit
$url = "http://api.torn.com/user/".$_SESSION["loginID"]."?selections=bars,profile&key=".$_SESSION["loginKey"];
$response = file_get_contents($url);
$data = json_decode($response, true);
$faction = $data['faction'];



if(($data['server_time']>0) && ($faction['faction_id']==7115)) { //If data checks out -> Valid = true 
	$_SESSION["valid"] = 1;
	if(($_SESSION["loginID"] == 28128) || ($_SESSION["loginID"] == 286232) || ($_SESSION["loginID"] == 1781401)) {
		//If data valid and ID is from a leader
		$_SESSION["leader"]=1;
	} else {
		$_SESSION["leader"]=0;
	}
	//Redirect to homepage if successful
	header('location: ../home.php');
} else {
	header('location: ../home.php');
	$_SESSION["valid"] = 0;
	$_SESSION["leader"] = 0;
}

?>
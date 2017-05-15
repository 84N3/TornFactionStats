<?php
error_reporting(E_ALL ^ E_DEPRECATED);
ini_set('display_errors', TRUE);
	
	$GLOBALS['ip'] = NULL;
	$GLOBALS['con'] = NULL;
	$GLOBALS['name'] = NULL;

	function connect($ip) {
		if(!isset($ip)) {
			$GLOBALS['ip'] = "";
		} else {
			$GLOBALS['ip'] = $ip;
		}
		
		//Verbindung aufbauen
		$GLOBALS['con'] = mysqli_connect("", "", "", "");
		
		//$GLOBALS['con'] = mysql_connect($GLOBALS['ip'],"","");
		if (!$GLOBALS['con']) {
			die('Could not connect: ' . mysql_error());
		}
	}
	
	function setDB($name) {
		if(!isset($name)) {
			$GLOBALS['name'] = "";
		} else {
			$GLOBALS['name'] = $name;
		}
		
		//Datenbank auswaehlen
		//if (!mysql_select_db($GLOBALS['name'], $GLOBALS['con'])) { 
		//if (!mysql_select_db("", $GLOBALS['con'])) {
		//	die('Could not connect: ' . mysql_error());
		//}
		
	}
	
	function execQuery($query, $feedback) {
		//mysql_select_db($GLOBALS['name'], $GLOBALS['con']);
		//Query ausfuehren
		$retval = mysqli_query($GLOBALS['con'], $query);//$GLOBALS['con']->query($query);
		if((!$retval) && ($feedback==1)) {
			die('Could not execute Query: '.$query.' Error: '. mysql_error());
		} else {
			return $retval;
		}
	}
?>
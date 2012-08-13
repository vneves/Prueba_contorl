<?php
session_start();
require_once("config/config.php");
require_once("smith_class/login.php");
require_once("smith_lib/functions.php");

// close session
if(isset($response) && $response != "") {
	session_destroy();
	$varsToSend = "response=DONE";
	header("Location: index.php?$varsToSend");
} else {
// open session
	$userData = array();
	$login = initRequestVar("userName");
	$password = initRequestVar("userPassword");
	
	$loginToValidate = new Login($login, $password);
	
	foreach ($loginToValidate as $key => $value) {
		if(is_array($value)) {
			foreach ($value as $key2 => $value2) {
				$userData[$key][$key2] = $value2;
			}
		} else {
			$userData["$key"] = $value;
		}
	}	
	$varsToSend = "response=ERROR";
	if($userData["ERROR"] == TRUE) {
		session_destroy();
		$varsToSend = "response=ERROR";
		header("Location: index.php?$varsToSend");
	} else {
		if (empty($_REQUEST["userLanguage"])) {
			$userData["language"] = "es";
		} else {
			$userData["language"] = !array_key_exists($_REQUEST["userLanguage"], $APP['admin_languages']) ? "es" : $_REQUEST["userLanguage"];
		}
		$_SESSION = $userData;
		$varsToSend = "response=DONE";
		header("Location: ./main.php?$varsToSend");
	}
}
?>
<?php
function stripslashes_recursive($arr) {
	$arr_ret = array();
	foreach ($arr as $index=>$value) {
		if (is_array($value)) {
			$arr_ret[stripslashes($index)] = stripslashes_recursive($value);
		} else {
			$arr_ret[stripslashes($index)] = stripslashes($value);
		}
	}
	return($arr_ret);
}
if (get_magic_quotes_gpc()) {
	$_GET = stripslashes_recursive($_GET);
	$_POST = stripslashes_recursive($_POST);
	$_COOKIE = stripslashes_recursive($_COOKIE);
	$_REQUEST = stripslashes_recursive($_REQUEST);
}
?>
<?php

/* ---------------------------------------
* Class: user_acct_access
* Date: 2006-03-24 17:01
* ---
* Table information
*   [file] => /home/www/webdesign/ovando.com/usados/class/skel/user_acct_access.php
* ----------------------------------------
*/

require_once($smithPath.'smith_class/base_camaleon.php');

class UserAcctAccess extends Base {

	function UserAcctAccess($login= "", $idAccess = "") {
		global $APP;
		require $APP['base_admin_path'].'pages/skel/user_acct_access.php';

		if($login != "") {
			
			$query = "SELECT access AS id_param FROM user_acct_access WHERE login = \"$login\"";

			$dbConn = ADONewConnection(APP_DSN);

			if (!$dbConn) {
				die("Connection failed");
			}
			$dbConn->SetFetchMode(ADODB_FETCH_ASSOC);

			$rs = $dbConn->Execute($query);

			if (!$rs) {
				die($dbConn->ErrorMsg());
			}

			$fieldsTotal = array();

			$beginArray = true;
			$lastCategoryId = -1;

			while (!$rs->EOF) {	
				$fieldsTotal[$rs->fields["id_param"]] = $rs->fields["id_param"];
				$rs->MoveNext();
			}

			if ($this->debug == true) {
				$this->writeLog($query, "File: ".__FILE__.": Line:".__LINE__);
			}

			$this->_data = $fieldsTotal;
		}
	}

	function delData($login) {
		$dbConn = ADONewConnection(APP_DSN);

		if (!$dbConn) {
			die("Connection failed");
		}
		
		$dbConn->SetFetchMode(ADODB_FETCH_ASSOC);
	
	// delete only the categories to update
		$queryDel = " DELETE FROM user_acct_access 
							WHERE login=\"$login\"";

		$dbConn->Execute($queryDel);
	}
	
	function saveData($login, $toDel = "") {

		$this->delData($login);
		/*
		if($this->debug == 1) {
			echo "<pre>";
			print_r($this->_data);
			echo "</pre>";
		}
		*/
		$dbConn = ADONewConnection(APP_DSN);
		if (!$dbConn) {
			die("Connection failed");
		}

		$queryArray = array();

		foreach ($this->_data as $key => $value) {
			// INSERT query construction
			$attquery = "";
		    foreach ($this->_cols as $column => $columnName) {
	    			$attquery .= ', '.$column;
			 }
	       $attquery[0] = '('; $attquery = $attquery.' )';
	       $queryInsert = "INSERT INTO user_acct_access $attquery VALUES (\"$login\", \"$value\")";
		    array_push($queryArray, $queryInsert);
		    $attquery = "";
		}

		foreach ($queryArray as $key => $value) {
			//echo $value;
			$dbConn->Execute ($value);

			if($this->debug == true) {
				$filename = __FILE__.":".__LINE__;
				$this->writeLog($value, $filename);
			}
		}
	}
}
?>
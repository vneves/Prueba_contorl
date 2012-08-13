<?php

/* ---------------------------------------
 * Class: user_acc
 * Date: 2006-03-17 12:13:54
 * ---
 * Table information
 *   [file] => ../../usados/class/skel/user_acc.php
 * ---
 * IF YOU NEED, THIS FILE CAN BE UPDATED MANUALLY
 * ---------------------------------------
 */

require_once($smithPath.'smith_class/base_camaleon.php');

class UserAcct extends Base {
	
	function UserAcct($id = "") {
		global $label;
		global $APP;
		require $APP['base_admin_path'].'pages/skel/user_acct.php';
		//require_once('pages/skel/user_acct.php');
		$this->Base("$id");
	}
	
	function saveData() {
		$login = "login=".$this->_data["login"];

		if($this->_data["id_user_acct"] == "") {
			if(($this->isAvailable("user_acct", "login") > 0) || ($this->isAvailable("user_acct", "login") > 0)) {
				$this->_hasError["login"] = "El login no esta disponible";
				return -1;
			}
		}

		if($this->debug == true) {
			$fileName = "File: ".__FILE__."\n";
			$fileName .= "Line: ".__LINE__."\n";
			$this->writeLog($this->_hasError["passwordC"], $filename);
		}
		return parent::saveData();
	}

	/**
    * review the availability of value for one colum
    *
	 * @param	string	$table		table for the action search
	 * @param	string	$column		column to search
    */
	function isAvailable($table, $column) {

		$columnToSearch = $this->_data[$column];
		$search ="";

		$search = "SELECT $column
					FROM $table
					WHERE $column = \"$columnToSearch\"";		

		$dbConn = ADONewConnection(APP_DSN);

		if (!$dbConn) {
			die("Connection failed");
		}

		$result = $dbConn->Execute($search);
		$result->RecordCount() > 0 ? $success = 1 : $success = 0;

		return $success;
	}
	
	function exists($id_page) {
		global $cn;
		$id_page = intval($id_page);
		$sql = "SELECT COUNT(*) as `conta` FROM `user_acct` WHERE id_user_acct='$id_page' LIMIT 1";
		$row_page = $cn->GetRow($sql);
		if ($row_page['conta']==1) {
			return(true);
		} else {
			return(false);
		}
	}
}
?>
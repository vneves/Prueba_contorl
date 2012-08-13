<?php

/* ---------------------------------------
 * Class: content
 * Date: 2008-01-14 17:31:10
 * ---
 * Table information
 *   [file] => /home/www/webdesign/webcamaleon/_private/from_smith/skel//content.php
 * ---
 * IF YOU NEED, THIS FILE CAN BE UPDATED MANUALLY
 * ---------------------------------------
 */

require_once('smith_class/base_camaleon.php');

class Content extends Base {
	function Content ($id="") {
		global $label;
		global $APP;
		require $APP['base_admin_path'].'pages/skel/content.php';
		//require_once('pages/skel/content.php');
		$this->Base("$id");
	}
	function Product ($id="") {
		global $label;
		global $APP;
		require $APP['base_admin_path'].'pages/skel/product.php';
		//require_once('pages/skel/content.php');
		$this->Base("$id");
	}
	function getLastChanges() {
		global $cn;
		$sql = "
			SELECT
				id_page, lang, title, id_user_last_update, date_last_update
			FROM
				content
			ORDER BY date_last_update DESC LIMIT 15";
		return($cn->GetAll($sql));
	}
	
	function exists($arr_keys) {
		global $cn;
		if (!is_array($arr_keys)) {
			$sql = "SELECT COUNT(*) as `conta` FROM `content` WHERE id_content='".intval($arr_keys)."' LIMIT 1";
		} else {
			switch (count($arr_keys)) {
				case 1:
					$sql = "SELECT COUNT(*) as `conta` FROM `content` WHERE id_content='".intval(array_pop($arr_keys))."' LIMIT 1";
					break;
				case 2:
					$id_page = reset($arr_keys);
					$lang = end($arr_keys);
					$sql = "SELECT COUNT(*) as `conta` FROM `content` WHERE id_page='".intval($id_page)."' AND `lang`='".addslashes($lang)."' LIMIT 1";
					break;
				default:
					return(false);
			}
		}
		$row = $cn->GetRow($sql);
		if ($row['conta']==1) {
			return(true);
		} else {
			return(false);
		}
	}
	
	function getIdContent($id_page, $lang) {
		global $cn;
		$sql = "SELECT id_content FROM `content` WHERE id_page='".intval($id_page)."' AND `lang`='".addslashes($lang)."' LIMIT 1";
		$row = $cn->Execute($sql);
		if (empty($row->fields)) {
			return('');
		} else {
			return($row->fields['id_content']);
		}
	}
	
	function existsPermalink($permalink){
		global $cn;
		$sql = "SELECT COUNT(*) as `conta` FROM `content` WHERE permalink='".addslashes($permalink)."' LIMIT 1";
		$row = $cn->GetRow($sql);
		if ($row['conta']!=1) {
			return(false);
		} else {
			return(true);
		}
	}
	
	function existsPermalink_products($permalink){
		global $cn;
		$sql = "SELECT COUNT(*) as `conta` FROM `products` WHERE permalink='".addslashes($permalink)."' LIMIT 1";
		$row = $cn->GetRow($sql);
		if ($row['conta']!=1) {
			return(false);
		} else {
			return(true);
		}
	}
}
?>
<?php
/* ---------------------------------------
 * Class: page
 * Date: 2008-01-14 16:59:19
 * ---
 * Table information
 *   [file] => /home/www/webdesign/webcamaleon/_private/from_smith/skel//page.php
 * ---
 * IF YOU NEED, THIS FILE CAN BE UPDATED MANUALLY
 * ---------------------------------------
 */
require_once('smith_class/base_camaleon.php');
require_once $APP['base_admin_path'].'pages/class/content.php';

class File extends Base {
	
	var $mode;
	
	function File ($id="") {
		global $label;
		global $APP;
		require($APP['base_admin_path'].'pages/skel/file.php');
		$this->Base("$id");
		
		$this->mode = (!empty($this->_data)) ? "update" : "insert";
	}
	
	function exists($id_file) {
		global $cn;
		$id_file = intval($id_file);
		$sql = "SELECT COUNT(*) as `conta` FROM `file` WHERE id_file='$id_file' LIMIT 1";
		$row_file = $cn->GetRow($sql);
		if ($row_file['conta']==1) {
			return(true);
		} else {
			return(false);
		}
	}
	/*
	function listFiles($id_page, $lang, $type=NULL) {
		global $cn;
		$sql = "SELECT * FROM `file` WHERE id_page='".intval($id_page)."' AND `lang`='".addslashes($lang)."'";
		if (!is_null($type)) {
			$sql .= " AND `type`='".addslashes($type)."'";
		}
		$sql .= " ORDER BY `order`";
		$rows = $cn->GetAll($sql);
		return($rows);
	}
	*/	
	function listFiles($id_content, $type=NULL) {
		global $cn;
		$sql = "SELECT * FROM `file` WHERE `id_content`='".intval($id_content)."'";
		if (!is_null($type)) {
			$sql .= " AND `type`='".addslashes($type)."'";
		}
		$sql .= " ORDER BY `order`";
		$rows = $cn->GetAll($sql);
		return($rows);
	}	
	

	function delete($id_file) {
		global $APP;
		global $cn;
		if (!File::exists($id_file)) {
			return;
		}
		$file = new File($id_file);
		$content = new Content($file->_data['id_content']);
		$page = new Page($content->_data['id_page']);
		
		
		$file_path = $file->_data['is_private']==0 ? $APP['files_resources'] : $APP['private_files_resources'];
		$file_path .= $page->_data['id_page'].'/'.$file->_data['filename'];
		
		$sql = "DELETE FROM `file` WHERE id_file='".intval($id_file)."'";
		$cn->Execute($sql);
		
		$sql = "SELECT COUNT(*) AS `conta` FROM `file` WHERE filename='".$file->_data['filename']."'";
		
		$row = $cn->Execute($sql);
		if ($row->fields['conta']==0) {
			//echo("<pre>");
			//print_r($file);
			//echo("<br/>");
			//print_r($APP['files_resources'].$file->_data['id_page'].'/tngallery_'.$file->_data['filename']);
			//die();
			@unlink($file_path);
			@unlink($APP['files_resources'].$file->_data['id_content'].'/tngallery_'.$file->_data['filename']);
		}
	}
	
	function shareFile () {
		global $APP;
		global $cn;		
		if (count($APP['content_languages'])==1) return;		
		$content = new Content($this->_data['id_content']);		
		$sql = "SELECT `id_content` FROM `content` WHERE id_page='".intval($content->_data['id_page'])."'";
		$rs = $cn->Execute($sql);
		$nFile = new File('');
		while (!$rs->EOF) {
			if ($rs->fields['id_content']!=$this->_data['id_content']) {
				$nFile->_data = $this->_data;
				$nFile->_data['id_file'] = '';
				$nFile->_data['id_content'] = $rs->fields['id_content'];
				$nFile->saveData();
			}
			$rs->MoveNext();
		}
		
	}
}
?>
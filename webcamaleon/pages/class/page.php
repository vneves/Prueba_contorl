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

class Page extends Base {
	
	var $mode;
	
	function Page ($id="") {
		global $label;
		global $APP;
		require $APP['base_admin_path'].'pages/skel/page.php';
		//require('pages/skel/page.php');
		$this->Base("$id");		
		$this->mode = (!empty($this->_data)) ? "update" : "insert";
	}
	
	function listOrder($id_parent, $lang) {
		global $cn;
		global $label;
		$sql = "SELECT id_page FROM page WHERE id_parent='".intval($id_parent)."' ORDER BY `order`";
		$row_pages = $cn->GetAll($sql);
		$arr_options['last'] = $label['at_last'];
		
		if (!empty($row_pages)) {
			$arr_options['first'] = $label['at_first'];
			foreach ($row_pages as $value) {
				$id_page = $value['id_page'];
				$title = $cn->GetOne("SELECT title FROM `content` WHERE id_page='".$id_page."' AND `lang`='".addslashes($lang)."'");
				
				if (!empty($title)) {
					$arr_options[$id_page] = $label['after_of']." ".$title;
				} else {
					$arr_options[$id_page] = $label['after_of']." ".'<'.$label['empty'].'>';
				}
			}
		}
		return($arr_options);
	}
	
	function exists ($id_page) {
		global $cn;
		$id_page = intval($id_page);
		$sql = "SELECT COUNT(*) as `conta` FROM `page` WHERE id_page='$id_page' LIMIT 1";
		$row_page = $cn->GetRow($sql);
		if ($row_page['conta']==1) {
			return(true);
		} else {
			return(false);
		}
	}
	
	function extraPageExists ($id_page) {
		global $cn;
		$sql = "SELECT COUNT(*) FROM `extra_page` WHERE `id_page`=".intval($id_page);
		$count = $cn->GetOne($sql);
		return ($count==0) ? false : true;
	}
	function getImageFront($id_content){
		global $cn;
		$sql = "SELECT * FROM `file` WHERE id_content=".intval($id_content).' AND tag="home" order by file.order ASC';
		$rs = $cn->Execute($sql);
		$arr = array();
		while(!$rs->EOF){
			$arr[] = $rs->fields;
			$rs->MoveNext();
		}
		return($arr);
	}
	function listNoticias($lang,$pagination_num_page=false,$inicio,$registros) {
	
		global $APP;
		global $cn;
		global $label;
		$sql = "SELECT * FROM `page` WHERE id_parent='".$APP['certificaciones']."' and is_published=1 ORDER BY `order` desc LIMIT ".$inicio.", ".$registros;
		//echo($sql);
		$rows = $cn->GetAll($sql);
		
		if (empty($rows)) {
			return($rows);
		}
		foreach ($rows as $key => $row_page) {
			//atributos de `content`
			$sql = "SELECT permalink, id_content, `title`, `introtext`, `meta_description`, `date_last_update`, `id_user_last_update` FROM `content` WHERE `id_page`='".intval($row_page['id_page'])."' AND `lang`='".addslashes($lang)."'";
			$row_content = $cn->GetRow($sql);
			
			if (!empty($row_content)) {
				$rows[$key]['id_content'] =$row_content['id_content'];
				$rows[$key]['title'] =$row_content['title'];
				$rows[$key]['introtext'] =$row_content['introtext'];
				$rows[$key]['meta_description'] =$row_content['meta_description'];
				$rows[$key]['date_last_update'] =$row_content['date_last_update'];
				$rows[$key]['id_user_last_update'] =$row_content['id_user_last_update'];
				$rows[$key]['permalink'] =$row_content['permalink'];
			} else {
				$rows[$key]['id_content'] ='';
				$rows[$key]['title'] = "<".$label['empty'].">";
				$rows[$key]['introtext'] = "<".$label['empty'].">";
				$rows[$key]['meta_description'] = "<".$label['empty'].">";
				$rows[$key]['date_last_update'] = '0000-00-00 00:00:00';
				$rows[$key]['id_user_last_update'] = '';
				$rows[$key]['permalink'] = '';
			}
		}
			return(array('rows'=>$rows));
	}
	function listPages($id_parent, $lang, $pagination_num_page=false) {
		global $APP;
		global $cn;
		global $label;
		//atributos de page
		$sql = "SELECT * FROM `page` WHERE id_parent='".intval($id_parent)."' ORDER BY `order`";
		
		//pagination-->
		if ($pagination_num_page!==false) {
			$page_size = $APP['sections_num_page'];
			$sql_num_items = "SELECT COUNT(*) FROM `page` WHERE `id_parent`='".intval($id_parent)."'";
			$num_items = $cn->GetOne($sql_num_items);
			if ($num_items>0) {
				$num_pages = ceil($num_items/$page_size);
				$page = ($pagination_num_page=='last')? $num_pages : intval($pagination_num_page);
				$page = ($page<1) ? 1 : $page;
				$page = ($page>$num_pages) ? $num_pages : $page;
				
				$sql .= " LIMIT ".(($page-1)*$page_size).", ".$page_size;
			} else {
				$num_pages = 1;
			}
		}
		//<--pagination
		$rows = $cn->GetAll($sql);
		
		if (empty($rows)) {
			return($rows);
		}
		
		foreach ($rows as $key => $row_page) {
			//atributos de `content`
			$sql = "SELECT permalink, id_content, `title`, `meta_description`, `date_last_update`, `id_user_last_update` FROM `content` WHERE `id_page`='".intval($row_page['id_page'])."' AND `lang`='".addslashes($lang)."'";
			$row_content = $cn->GetRow($sql);
			
			if (!empty($row_content)) {
				$rows[$key]['id_content'] =$row_content['id_content'];
				$rows[$key]['title'] =$row_content['title'];
				$rows[$key]['meta_description'] =$row_content['meta_description'];
				$rows[$key]['date_last_update'] =$row_content['date_last_update'];
				$rows[$key]['id_user_last_update'] =$row_content['id_user_last_update'];
				$rows[$key]['permalink'] =$row_content['permalink'];
			} else {
				$rows[$key]['id_content'] ='';
				$rows[$key]['title'] = "<".$label['empty'].">";
				$rows[$key]['meta_description'] = "<".$label['empty'].">";
				$rows[$key]['date_last_update'] = '0000-00-00 00:00:00';
				$rows[$key]['id_user_last_update'] = '';
				$rows[$key]['permalink'] = '';
			}
		}
		
		if ($pagination_num_page!==false) {
			return(array('num_pages'=>$num_pages, 'current_page'=>$page, 'rows'=>$rows));
		} else {
			return($rows);
		}
	}
	
	function getPath($id_page, $lang) {
		global $cn;
		$sql_format = "SELECT id_parent FROM `page` WHERE id_page='%s'";
		
		$sql = sprintf($sql_format, intval($id_page));
		$row = $cn->GetRow($sql);
		
		if ($row==false) {
			return(array());
		}
		
		$arr_path = array(intval($id_page));
		while ($row["id_parent"]!=0) {
			$arr_path[] = $row["id_parent"];
			$sql = sprintf($sql_format, $row["id_parent"]);
			$row = $cn->GetRow($sql);
		}
		
		$arr_ret = array();
		array_reverse($arr_path);
		foreach ($arr_path as $id_page) {
			$sql = "SELECT `title` FROM content WHERE `id_page`='$id_page' AND `lang`='".addslashes($lang)."'";
			$title = $cn->GetOne($sql);
			$arr_ret[$id_page] = $title;
		}
		
		return(array_reverse($arr_ret, true));
	}
	
	function delete ($id_page) {
		global $cn;
		global $APP;
		if (!Page::exists($id_page)) {
			return;
		}
		
		$rows_children = $cn->GetAll("SELECT `id_page` FROM page WHERE id_parent='".intval($id_page)."'");
		
		if (!empty($rows_children)) {
			foreach ($rows_children as $row_children) {
				Page::delete($row_children['id_page']);
			}
		}
		
		$page = new Page($id_page);
		Page::_deleteDir($APP['files_resources']."/".$page->_data['id_page']);
		$sql = "DELETE FROM `page`  WHERE id_page='".$page->_data['id_page']."'";
		$cn->Execute($sql);
		$sql = "DELETE FROM `content` WHERE id_page='".$page->_data['id_page']."'";
		$cn->Execute($sql);
		$sql = "DELETE FROM `file` WHERE id_page='".$page->_data['id_page']."'";
		$cn->Execute($sql);
	}
	
	function _deleteDir($dirpath) {
		if (!is_dir($dirpath)) { return; }
		$dir = opendir($dirpath);
		while ($input=readdir($dir)) {
			if ($input=="." || $input=="..") {
				continue;
			}
			$newpath = $dirpath."/".$input;
			if (is_dir($newpath)) {
				Page::_deleteDir($newpath);
			} else {
				@unlink($newpath);
			}
		}
		closedir($dir);
		if(!rmdir($dirpath)){
			die($dirpath);
		}
	}
	
	function extra() {
		global $cn;
		$sql = "SELECT * FROM `extra_page` WHERE id_page='".$this->_data['id_page']."'";
		return($cn->GetRow($sql));
	}
	
	function getNumImagesGallery ($id_content) {	
		global $cn;		
		$sql = "SELECT COUNT(*) FROM `file` WHERE id_content=".intval($id_content)." and tag='gallery' ";		
		$count = $cn->GetOne($sql);
		return($count);
	}
	
	function getImagesGallery($id_page) {
		global $cn;
		$sql = "SELECT * FROM `file` WHERE id_content=".intval($id_page).' AND tag="gallery" ORDER BY `order`, `title`, `description`, `filename`';
		$rs = $cn->Execute($sql);
		$arr = array();
		while(!$rs->EOF){
			$arr[] = $rs->fields;
			$rs->MoveNext();
		}
		return($arr);
	}
	/*function getImageFront($id_content){
		global $cn;
		$sql = "SELECT * FROM `file` WHERE id_content=".intval($id_content).' AND tag="front" ';
		$rs = $cn->Execute($sql);
		$arr = array();
		while(!$rs->EOF){
			$arr[] = $rs->fields;
			$rs->MoveNext();
		}
		return($arr);
	}*/
	
	function updateOrder ($id_ref) {
		global $cn;
		switch ($id_ref) {
			case 'first':
				$sql = "UPDATE `".$this->_tableName."` SET `order`=`order`+1 WHERE id_parent=".$this->_data['id_parent'];
				$cn->Execute($sql);
				$sql = "UPDATE `".$this->_tableName."` SET `order`='1' WHERE `".$this->_keyField."`=".$this->_data[$this->_keyField];
				break;
			case 'last':
				$sql = "SELECT max(`order`) FROM `".$this->_tableName."` WHERE id_parent=".$this->_data['id_parent'];
				$max_order = $cn->GetOne($sql);
				$max_order++;
				$sql = "UPDATE `".$this->_tableName."` SET `order`='$max_order' WHERE `".$this->_keyField."`=".$this->_data[$this->_keyField];
				$cn->Execute($sql);
				$this->_data['order'] = $max_order;
				break;
			default:
				if ($id_ref != $this->_data[$this->_keyField]) {
					$sql = "SELECT `order` FROM `".$this->_tableName."` WHERE `".$this->_keyField."`=".intval($id_ref);
					$after_order = $cn->GetOne($sql);
					$after_order++;
					$sql = "UPDATE `".$this->_tableName."` SET `order`=`order`+1 WHERE `order`>=".intval($after_order);
					$cn->Execute($sql);
					$sql = "UPDATE `".$this->_tableName."` SET `order`=$after_order WHERE `".$this->_keyField."`=".$this->_data[$this->_keyField];
					$cn->Execute($sql);
				}
				break;
		}

//		die();
	}
	
	
	function listPagesLanguage ($id_page) {
		global $cn;
		$sql = "SELECT id_content,lang FROM `content` WHERE id_page=".intval($id_page);
		$rs = $cn->GetAll($sql);
		return($rs);
	}
	
	function getPermalinkContent($id_page,$lang) {
		global $cn;
		$sql = "SELECT permalink FROM `content` WHERE id_page=".intval($id_page)." and lang='".trim($lang)."'";
		$permalinkr="";
		$row_content = $cn->GetRow($sql);
		if (!empty($row_content)) {		
				$permalinkr=$row_content['permalink'];
		}		
		return($permalinkr);
	}
	
	
	
}
?>
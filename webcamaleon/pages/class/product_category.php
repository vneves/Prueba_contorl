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
require_once "./config/config.php";

class Product_category extends Base {
	
	var $mode;
	var $_tableName;
	function listProduct_category() {
		global $cn;
		$sql = "SELECT * FROM `product_category` ORDER BY `order` ";
		$rs = $cn->Execute($sql);
		$arr = array();
		while(!$rs->EOF){
			$arr[] = $rs->fields;
			$rs->MoveNext();
		}
		return($arr);
	}
	
	function Product_category ($id="") {
		global $label;
		global $APP;
		require $APP['base_admin_path'].'pages/skel/product_category.php';
		$this->Base("$id");
		$this->mode = (!empty($this->_data)) ? "update" : "insert";
	}
	
	function getPath($id) {
		global $cn;
		$sql_format = "SELECT `id_parent` FROM `product_category` WHERE `id_product_category`='%s'";
		
		$sql = sprintf($sql_format, intval($id));
		$row = $cn->GetRow($sql);
		
		if ($row==false) {
			return(array());
		}
		
		$arr_path = array(intval($id));
		while ($row["id_parent"]!=0) {
			$arr_path[] = $row["id_parent"];
			$sql = sprintf($sql_format, $row["id_parent"]);
			$row = $cn->GetRow($sql);
		}
		
		$arr_ret = array();
		array_reverse($arr_path);
		foreach ($arr_path as $id_page) {
			$sql = "SELECT `title` FROM `product_category` WHERE `id_product_category`='$id_page'";
			$title = $cn->GetOne($sql);
			$arr_ret[$id_page] = $title;
		}
		
		return(array_reverse($arr_ret, true));
	}
	
	function listOrder($id_parent) {
		global $cn;
		global $label;
		
		$sql = "SELECT id_product_category, `title` FROM product_category WHERE id_parent='".intval($id_parent)."' ORDER BY `order`";
		
		
		$row_pages = $cn->GetAll($sql);
		$arr_options['last'] = $label['at_last'];
		
		if (!empty($row_pages)) {
			$arr_options['first'] = $label['at_first'];
			foreach ($row_pages as $value) {
				$id_product_category = $value['id_product_category'];
				$arr_options[$id_product_category] = $label['after_of']." ".$value['title'];
			}
		}
		return($arr_options);
	}
	
	function updateOrder($id_ref) {
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
		
		/*echo "<pre>";
		print_r($this);
		echo "</pre>";
		
		echo $sql;
		die();*/
	}
	
	function exists ($id) {
		
		global $cn;
		$id = intval($id);
		$sql = "SELECT COUNT(*) as `conta` FROM `product_category` WHERE id_product_category='$id' LIMIT 1";
		$row_page = $cn->GetRow($sql);
		if ($row_page['conta']==1) {
			return(true);
		} else {
			return(false);
		}
	}
	
	function update_image($index_image) {
		global $APP;
		global $cn;
		global $label;
		
		if (empty($_FILES[$index_image]) || $_FILES[$index_image]['size']==0) {
			$this->_hasError['image'] = $label['required_field'];
			return(false);
		}
		
		if ($_FILES[$index_image]['error']!=0) {
			$error = $_FILES[$index_image]['error'];
			$this->_hasError['image'] = $label['upload_error_'.$error];
			return(false);
		}
		
		$arr_filename = explode('.', $_FILES[$index_image]['name']);
		$file_extension = array_pop($arr_filename);
		$file_basename = implode('.', $arr_filename);
		
		$file_basename = generate_permalink($file_basename);
		
		$dirname = $APP['products_files'];
		
		$filepath = $dirname.$file_basename.'.'.$file_extension;
		
		while (file_exists($filepath)) {
			$file_basename .= random_string();
			$filepath = $dirname.$file_basename.'.'.$file_extension;
		}
		
		if (!move_uploaded_file($_FILES[$index_image]['tmp_name'], $filepath)) {
			$this->_hasError['image'] = $label['upload_error_7'];
			return(false);
		} else {
			if ($this->mode=='update') {
				$old_filename = $APP['products_files'].$this->_data['image'];
				@unlink($old_filename);
			}
			chmod ($filepath, 0755);
			$this->_data['image'] = $file_basename.'.'.$file_extension;
			return(true);
		}
	}
	
	function delete ($id) {
		global $cn;
		global $APP;
		
		$id = intval($id);
		
		if (!Product_category::exists($id)) {
			return("La categor&iacute;a no existe.");
		}
		
		$rs = $cn->Execute("SELECT * FROM `product_category` WHERE id_product_category='$id'");
		//Control de subcategorias-->
		$sql = "SELECT COUNT(*) as `conta` FROM `product_category` WHERE `id_parent`='$id'";
		$num_child = $cn->GetOne($sql);
		$ret_str = "La categor&iacute;a <strong>".$rs->fields['title']."</strong> ";
		if ($num_child!=0) {
			switch ($num_child) {
				case 1:
					$ret_str .= "tiene asociada una subcategor&iacute;a.";
					break;
				default:
					$ret_str .= "tiene asociada $num_child subcategor&iacute;as.";
			}
			return ($ret_str);
		}
		//<--Control de subcategorias
		//Control de products-->
		$sql = "SELECT COUNT(*) as `conta` FROM product WHERE `id_product_category`='$id'";
		$num_product = $cn->GetOne($sql);
		$ret_str = "La categor&iacute;a <strong>".$rs->fields['title']."</strong> ";
		if ($num_product!=0) {
			switch ($num_product) {
				case 1:
					$ret_str .= "tiene asociada un producto.";
					break;
				default:
					$ret_str .= "tiene asociada $num_product productos.";
			}
			return ($ret_str);
		}
		//<--Control de products
		@unlink($APP['products_files'].$rs->fields['image']);
		$sql = "DELETE FROM `product_category` WHERE `id_product_category`='$id'";
		$cn->Execute($sql);
		return("");
	}
	
	
	function getPathPage($id) {
		global $cn;
		$sql = "SELECT * FROM `page` WHERE `id_parent`='$id'";		
		//$sql = sprintf($sql_format, intval($id));
		//echo($sql);
		$arr_path = $cn->getall($sql);
		reset($arr_path);		
		$cont=0;	
		foreach ($arr_path as $value) {		
			$sql = "SELECT * FROM `content` WHERE `id_page`='".$value['id_page']."'";
			//echo($sql);
			$arr_ret[$cont] = $cn->getall($sql);			
			$cont++;						
		}
			
		return($arr_ret);
	}
	function listCategoriesPage($id_parent, $num_page, $page_size) {
		global $cn;
		
		$arr_ret['num_pages'] = 1;
		$arr_ret['page'] = 1;
		$arr_ret['rows'] = array();
		
		$id_parent = intval($id_parent);
		$sql = "SELECT COUNT(*) as conta FROM `page` WHERE `id_parent`='$id_parent'";
		
		$num_items = $cn->GetOne($sql);
		
		if($num_items==0) return($arr_ret);
		
		$num_pages = ceil($num_items/$page_size);
		$num_page = ($num_page=='last') ? $num_pages : intval($num_page);
		$num_page = ($num_page<1) ? 1 : $num_page;
		$num_page = ($num_page>$num_pages) ? $num_pages : $num_page;
		
		$sql = "SELECT * FROM content WHERE id_page='$id_parent' ORDER BY `order` LIMIT ".(($num_page-1)*$page_size).",$page_size";
		
		$arr_ret['num_pages'] = $num_pages;
		$arr_ret['page'] = $num_page;
		$arr_ret['rows'] = $cn->Execute($sql);
		
		return($arr_ret);
	}
	
	
	function listCategories($id_parent, $num_page, $page_size) {
		global $cn;
		
		$arr_ret['num_pages'] = 1;
		$arr_ret['page'] = 1;
		$arr_ret['rows'] = array();
		
		$id_parent = intval($id_parent);
		$sql = "SELECT COUNT(*) as conta FROM `product_category` WHERE `id_parent`='$id_parent'";
		
		$num_items = $cn->GetOne($sql);
		
		if($num_items==0) return($arr_ret);
		
		$num_pages = ceil($num_items/$page_size);
		$num_page = ($num_page=='last') ? $num_pages : intval($num_page);
		$num_page = ($num_page<1) ? 1 : $num_page;
		$num_page = ($num_page>$num_pages) ? $num_pages : $num_page;
		
		$sql = "SELECT * FROM product_category WHERE `lang`='".$_SESSION['language']."' AND id_parent='$id_parent' ORDER BY `order` LIMIT ".(($num_page-1)*$page_size).",$page_size";
		//print_r($sql);
		$arr_ret['num_pages'] = $num_pages;
		$arr_ret['page'] = $num_page;
		$arr_ret['rows'] = $cn->Execute($sql);
		
		return($arr_ret);
	}
	
	
	
	function pagination($num_page, $page_size, $search_string="", $search_by="") {
		global $cn;
		
		$arr_ret['num_pages'] = 1;
		$arr_ret['page'] = 1;
		$arr_ret['rows'] = array();
		
		if (empty($cn)) { return($arr_ret); }
		$select = "SELECT COUNT(*) FROM `product_category` ";
		$where = "";
		if ($search_string!="" && $search_by!="") {
			switch ($search_by) {
				case "description":
				case "title":
					$where = " WHERE `$search_by` LIKE '%".addslashes($search_string)."%' ";
					break;
			}
		}
		$where ="";
		$where = " WHERE `lang`='".$_SESSION['language']."'";
		
		$sql = $select.$where;
		$num_items = $cn->GetOne($sql);
		
		if ($num_items==0) { return ($arr_ret); }
		
		$num_pages = ceil($num_items/$page_size);
		$num_page = ($num_page=='last') ? $num_pages : intval($num_page);
		$num_page = ($num_page<1) ? 1 : $num_page;
		$num_page = ($num_page>$num_pages) ? $num_pages : $num_page;
		
		$sql = "SELECT * FROM `product_category`".$where." ORDER BY `order` LIMIT ".(($num_page-1)*$page_size).",$page_size";
		
		$rows = $cn->Execute($sql);
		$arr_ret['num_pages'] = $num_pages;
		$arr_ret['page'] = $num_page;
		$arr_ret['rows'] = $rows;
		
		return($arr_ret);
	}
	
	function printPagePath($id_parent) {
		global $label;
		global $page_request;
		global $section_request;
		$arr_path = Product_category::getPath($id_parent);
		if (!empty($arr_path)) {
			$left = 12;
			echo '<div id="div_path">';
			echo '<div><a href="main.php?page='.$page_request.'&section='.$section_request.'">'.$label['categories'].'</a></div>';
			foreach ($arr_path as $key => $value) {
				echo '<div>';
				if ($left>0) {
					echo '<div style="padding-left:'.($left-12).'px; float:left"><img src="images/rowpath.gif" width="12" height="12" alt="" /></div>';
				}
				echo '<div><a href="main.php?page='.$page_request.'&section='.$section_request.'&id_parent='.$key.'">'.$value.'</a></div>';
				echo '</div>';
				$left+=12;
			}
			echo '</div>';
		}
	}
	//Return an array of nested categories
	function listNestedCategories($id_parent) {
		global $cn;
		$sql_base = "SELECT `id_product_category`, `title` FROM `product_category` WHERE `id_parent`='%s' ORDER BY `order`";
		$sql = sprintf($sql_base, $id_parent);
		
		$rs = $cn->Execute($sql);
		
		$arr_ret = array();
		
		while (!$rs->EOF) {
			$id = $rs->fields['id_product_category'];
			$arr_ret[$id] = array(
				"title" => $rs->fields['title'],
				"sub" => Product_category::listNestedCategories($id)
			);
			$rs->MoveNext();
		}
		
		return($arr_ret);
	}
	//Return an select html element
	function printRecursiveCategory ($category_arr, $level, $id_selected = '') {
		$prefix = str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $level);
		$level++;
		$str_ret = '';
		foreach ($category_arr as $id=>$value) {
			$selected = $id_selected == $id ? ' selected="selected"' : '';
			$str_ret .= '<option value="'.$id.'" '.$selected.'>'.$prefix.$value['title'].'</option>';
			if (!empty($value['sub'])) {
				$str_ret .= Product_category::printRecursiveCategory ($value['sub'], $level, $id_selected);
			}
		}
		return($str_ret);
	}
	//Return the num of categories
	function getNumCategories ($id_parent) {
		global $cn;
		$sql = 'SELECT COUNT(*) as `conta` FROM `product_category` WHERE `id_parent`='.intval($id_parent);
		return ($cn->GetOne($sql));
	}
}
?>
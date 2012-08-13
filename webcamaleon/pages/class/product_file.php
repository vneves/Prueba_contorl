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

require_once $APP['base_admin_path'].'pages/class/product.php';
require_once ('smith_class/base_camaleon.php');

class Product_file extends Base {
	
	var $mode;
	var $dirpath;
	function Product_file ($id="") {
		global $label;
		global $APP;
		require($APP['base_admin_path'].'pages/skel/product_file.php');
		$this->Base("$id");
		
		$this->mode = (!empty($this->_data)) ? "update" : "insert";
		$this->dirpath = $APP['private_products_files'];
	}
	
	function exists($id) {
		global $cn;
		$id = intval($id);
		$sql = "SELECT COUNT(*) as `conta` FROM `product_file` WHERE id_product_file='$id' LIMIT 1";
		$row_file = $cn->GetRow($sql);
		if ($row_file['conta']==1) {
			return(true);
		} else {
			return(false);
		}
	}
	
	function listFiles($id_page, $type=NULL) {
		global $cn;
		$sql = "SELECT * FROM `product_file` WHERE id_product='".intval($id_page)."'";
		if (!is_null($type)) {
			$sql .= " AND `type`='".addslashes($type)."'";
		}
		$sql .= " ORDER BY `order`";
		//print_r($sql);
		//die();
		$rows = $cn->GetAll($sql);
		return($rows);
	}
	
	function pagination ($num_page, $page_size, $id_product) {
		global $cn;
		
		$arr_ret['num_pages'] = 1;
		$arr_ret['page'] = 1;
		$arr_ret['rows'] = array();
		
		if (empty($cn)) { return($arr_ret); }
		$select = "SELECT COUNT(*) FROM `product_file` ";
		$where = " WHERE id_product='".intval($id_product)."'";
		
		$sql = $select.$where;
		
		$num_items = $cn->GetOne($sql);
		
		if ($num_items==0) { return ($arr_ret); }
		
		$num_pages = ceil($num_items/$page_size);
		$num_page = ($num_page=='last') ? $num_pages : intval($num_page);
		$num_page = ($num_page<1) ? 1 : $num_page;
		$num_page = ($num_page>$num_pages) ? $num_pages : $num_page;
		
		$sql = "SELECT * FROM `product_file`".$where." ORDER BY `order` LIMIT ".(($num_page-1)*$page_size).",$page_size";
		
		$rows = $cn->Execute($sql);
		$arr_ret['num_pages'] = $num_pages;
		$arr_ret['page'] = $num_page;
		$arr_ret['rows'] = $rows;
		
		return($arr_ret);
	}
	
	function delete($id) {
		global $cn;
		global $APP;
		
		$id = intval($id);
		
		if (!Product_file::exists($id)) {
			return("El archivo no existe.");
		}
		
		$rs = $cn->Execute("SELECT `filename` FROM product_file WHERE id_product_file=$id");
		
		@unlink($APP['private_products_files'].$rs->fields['filename']);
		$sql = "DELETE FROM `product_file` WHERE `id_product_file`='$id'";
		$cn->Execute($sql);
		return("");
	}
	
	function update_image($index_image, $field='filename') {
		global $APP;
		global $cn;
		global $label;
		
		if (empty($_FILES[$index_image]) || $_FILES[$index_image]['size']==0) {
			$this->_hasError[$field] = $label['required_field'];
			return(false);
		}
		
		if ($_FILES[$index_image]['error']!=0) {
			$error = $_FILES[$index_image]['error'];
			$this->_hasError[$field] = $label['upload_error_'.$error];
			return(false);
		}
		
		$arr_filename = explode('.', $_FILES[$index_image]['name']);
		$file_extension = array_pop($arr_filename);
		$file_basename = implode('.', $arr_filename);
		
		$file_basename = generate_permalink($file_basename);
		
		$dirname = $APP['private_products_files'];
		
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
				$old_filename = $APP['private_products_files'].$this->_data[$field];
				@unlink($old_filename);
			}
			chmod ($filepath, 0755);
			$this->_data[$field] = $file_basename.'.'.$file_extension;
			return(true);
		}
	}
	
	function deleteAllForProduct ($id_product) {
		global $APP;
		global $cn;
		
		$id_product = intval($id_product);
		if (!Product::exists($id_product)) {
			return(false);
		}
		
		$sql = "SELECT * FROM product_file WHERE id_product=$id_product";
		$rs = $cn->Execute($sql);
		
		while (!$rs->EOF) {
			@unlink($APP['private_products_files'].$rs->fields['filename']);
			$rs->MoveNext();
		}
		
		$sql = "DELETE FROM product_file WHERE id_product=$id_product";
		$cn->Execute($sql);
		
		return(true);
	}
}
?>
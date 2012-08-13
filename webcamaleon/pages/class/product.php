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

class Product extends Base {
	
	var $mode;
	
	function Product ($id="") {
		global $label;
		global $APP;
		require $APP['base_admin_path'].'pages/skel/product.php';
		//require('pages/skel/page.php');
		$this->Base("$id");
		
		$this->mode = (!empty($this->_data)) ? "update" : "insert";
	}
	
	function listProducts() {
		global $cn;
		$sql = "SELECT * FROM `product` ";
		$rs = $cn->Execute($sql);
		$arr = array();
		while(!$rs->EOF){
			$arr[] = $rs->fields;
			$rs->MoveNext();
		}
		return($arr);
	}
	function listAllCategories() {
		global $cn;
		$sql = "SELECT id_product_category, title FROM product_category ORDER BY title";
		$rs = $cn->Execute($sql);
		$arr = array();
		while (!$rs->EOF) {
			$arr[$rs->fields['id_product_category']] = $rs->fields['title'];
			$rs->MoveNext();
		}
		return($arr);
	}
	
	function exists ($id_product) {
		global $cn;
		//$id_bus = intval($id_bus);
		$sql = "SELECT COUNT(*) as `conta` FROM `product` WHERE id_product='$id_product' LIMIT 1";
		$row_page = $cn->GetRow($sql);
		if ($row_page['conta']==1) {
			return(true);
		} else {
			return(false);
		}
	}
	
	
	function delete ($id_product) {
		global $cn;
		global $APP;
		
		if (!Product::exists($id_product)) {
			return;
		}
		
		$sql = "DELETE FROM `product`  WHERE id_product=".$id_product;
		$cn->Execute($sql);
	}
	
	/**
	* Static function
	*/
	function paginationFilter ($num_page, $page_size, $filter) {
		global $cn;
		global $APP;
		$sql = "SELECT DISTINCT banner.* ";
		
		$from = array('banner'=>'banner');
		
		$where = array();
		
		//informacion del concursante-->
		if (!empty($filter['name'])) {
			$where[] = "`name` LIKE '%".addslashes($filter['name'])."%'";
		}
		if (!empty($filter['url'])) {
			$where[] = "`url` LIKE '%".addslashes($filter['url'])."%'";
		}
		if (isset($filter['is_published']) && $filter['is_published']!='') {
			$where[] = '`is_published`='.intval($filter['is_published']);
		}
		//<--informacion del concursante
				
		$from_str = ' FROM '.implode(',', $from);
		$where_str = empty($where) ? '' : ' WHERE '.implode(' AND ', $where);
		
		$arr_ret['num_pages'] = 1;
		$arr_ret['page'] = 1;
		$arr_ret['rows'] = array();		
		
		$sql_count = 'SELECT COUNT(*) as conta '.$from_str.$where_str;
		$num_items = $cn->GetOne($sql_count);
		
		if ($num_items==0) { return ($arr_ret); }
		
		$num_pages = ceil($num_items/$page_size);
		$num_page = ($num_page=='last') ? $num_pages : intval($num_page);
		$num_page = ($num_page<1) ? 1 : $num_page;
		$num_page = ($num_page>$num_pages) ? $num_pages : $num_page;
		
		$sql .= $from_str.$where_str;
		$sql .= ' LIMIT '.(($num_page-1)*$page_size).','.$page_size;
		
		$rows = $cn->Execute($sql);
		$arr_ret['num_pages'] = $num_pages;
		$arr_ret['page'] = $num_page;
		$arr_ret['rows'] = $rows;
		return($arr_ret);
	}
	/**
	* Static function
	*/
	function getFilterInfo($prefix) {
		$arrKeys = array('name','url', 'is_published'); //Informacion de concursante
		$arr_filter_info = array();
		
		$arrValues = isset($_SESSION[$prefix]) ? $_SESSION[$prefix] : array();
		
		foreach ($arrKeys as $key) {
			$arr_filter_info[$key] = isset($arrValues[$key]) ? $arrValues[$key] : '';
		}
		return($arr_filter_info);
	}
	function update_image($index_image, $field) {
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
		
		$file_prefix = 'product_';
		$file_prefix .= $field=='thumb_image' ? 'thumb_' : 'big_';
		
		//$file_basename = $file_prefix.generate_permalink($file_basename);
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
				$old_filename = $APP['products_files'].$this->_data[$field];
				@unlink($old_filename);
			}
			chmod ($filepath, 0755);
			$this->_data[$field] = $file_basename.'.'.$file_extension;
			return(true);
		}
	}
	function pagination($num_page, $page_size, $search_string="", $search_by="", $category='all') {
		global $cn;
		
		$private_flag = '';
		if (!defined("FROM_MAIN")) {
			if (!isset($_SESSION['id_franchisee'])) {
				$private_flag = ' AND is_private=0';
			}
		}
		
		$arr_ret['num_pages'] = 1;
		$arr_ret['page'] = 1;
		$arr_ret['rows'] = array();
		
		if (empty($cn)) { return($arr_ret); }
		$select = "SELECT COUNT(*) FROM `product` ";
		$where = "";
		if ($search_string!="" && $search_by!="") {
			switch ($search_by) {
				case "description":
				case "title":
				case "code":
					$where = " WHERE `$search_by` LIKE '%".addslashes($search_string)."%' ";
					break;
			}
		}
		
		if ($category!='all') {
			$where = (empty($where)) ?  ' WHERE `lang`="'.$_SESSION['language'].'" AND `id_product_category`='.$category : $where.' AND `id_product_category`='.$category;
		}else{
			$where ="";
			$where = " WHERE `lang`='".$_SESSION['language']."'";
										
		}
		
		$where .= $private_flag;
		
		$sql = $select.$where;
		//print_r($sql);
		$num_items = $cn->GetOne($sql);
		
		if ($num_items==0) { return ($arr_ret); }
		
		$num_pages = ceil($num_items/$page_size);
		$num_page = ($num_page=='last') ? $num_pages : intval($num_page);
		$num_page = ($num_page<1) ? 1 : $num_page;
		$num_page = ($num_page>$num_pages) ? $num_pages : $num_page;
		
		$sql = "SELECT * FROM `product`".$where." ORDER BY `order` LIMIT ".(($num_page-1)*$page_size).",$page_size";
		//print_r($sql);
		$rows = $cn->Execute($sql);
		$arr_ret['num_pages'] = $num_pages;
		$arr_ret['page'] = $num_page;
		$arr_ret['rows'] = $rows;
		
		return($arr_ret);
	}
	function listOrder($id_parent) {
		global $cn;
		global $label;
		
		$sql = "SELECT id_product, `title` FROM `product` WHERE `id_product_category`='".intval($id_parent)."' ORDER BY `order`";
		
		$row_pages = $cn->GetAll($sql);
		$arr_options['last'] = $label['at_last'];
		
		if (!empty($row_pages)) {
			$arr_options['first'] = $label['at_first'];
			foreach ($row_pages as $value) {
				$id_product = $value['id_product'];
				$arr_options[$id_product] = $label['after_of']." ".$value['title'];
			}
		}
		return($arr_options);
	}
	
	function updateOrder($id_ref) {
		global $cn;
		switch ($id_ref) {
			case 'first':
				$sql = "UPDATE `".$this->_tableName."` SET `order`=`order`+1 WHERE id_product_category=".$this->_data['id_product_category'];
				$cn->Execute($sql);
				$sql = "UPDATE `".$this->_tableName."` SET `order`='1' WHERE `".$this->_keyField."`=".$this->_data[$this->_keyField];
				break;
			case 'last':
				$sql = "SELECT max(`order`) FROM `".$this->_tableName."` WHERE id_product_category=".$this->_data['id_product_category'];
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
	}

	function listSponsor() {
		global $cn;
		$private_flag = '';
		if (!isset($_SESSION['id_franchisee'])) {
			$private_flag = ' AND is_private=0';
		}
		$sql = "SELECT * FROM product WHERE is_sponsor=1 $private_flag ORDER BY `order`, `title`";
		$rs = $cn->Execute($sql);
		return($rs);
	}
	
	function getNumProducts($id_product_category) {
		global $cn;
		$sql = 'SELECT COUNT(*) as `conta` FROM `product` WHERE `id_product_category`='.intval($id_product_category);
		//echo($sql);
		return ($cn->GetOne($sql));
	}
	function listCategory_flyer($lang,$pagination_num_page=false,$inicio,$registros,$id_product_category) {
	
		global $APP;
		global $cn;
		global $label;
		$sql = "SELECT * FROM `product_category` WHERE id_product_category='".$id_product_category."'";
		
		$rows = $cn->GetAll($sql);
		
		if (empty($rows)) {
			return($rows);
		}
		foreach ($rows as $key => $row_page) {
			//atributos de `content`
			$sql = "SELECT id_product,title,description,unitary_price,thumb_image,big_image FROM `product` WHERE `id_product_category`='".intval($row_page['id_product_category'])."'ORDER BY `order` desc LIMIT ".$inicio.", ".$registros;
		
			//echo($sql);
			$row_content = $cn->GetAll($sql);
			return($row_content);
			
		}
			return(array('rows'=>$rows));
	}	
	function getProducts($id_product_category) {
		global $cn;
		$sql = 'SELECT * FROM `product` WHERE `id_product_category`='.intval($id_product_category);			
		$row_product = $cn->GetAll($sql);
		if (empty($row_product)) {
			return(array());
		}
		return($row_product);
		
	}
	function getProducts_category($id_product_category) {
		global $cn;
		$sql = 'SELECT * FROM `product_category` WHERE `id_product_category`='.intval($id_product_category);								
		return ($cn->GetAll($sql));	
		
	}
	function getProduct($id_product) {
		global $cn;
		$sql = 'SELECT * FROM `product` WHERE `id_product`='.intval($id_product);
		//echo($sql);							
		return ($cn->GetAll($sql));	
	}
	function getFilesProducts($id_product) {
		global $cn;
		$sql = "SELECT * FROM `product_file` WHERE `id_product`='".$id_product."' ORDER BY `order`";
		//echo($sql);
		return ($cn->GetAll($sql));	
	}
	function getFiles() {
		global $cn;
		$sql = "SELECT * FROM `product_file` WHERE `id_product`='".$this->_data['id_product']."' ORDER BY `order`";
		return($cn->Execute($sql));
	}
	
	function listCategory($lang,$pagination_num_page=false,$inicio,$registros,$id_product_category) {
	
		global $APP;
		global $cn;
		global $label;
		$sql = "SELECT * FROM `product_category` WHERE id_product_category='".$id_product_category."'";
		
		$rows = $cn->GetAll($sql);
		
		if (empty($rows)) {
			return($rows);
		}
		foreach ($rows as $key => $row_page) {
			//atributos de `content`
			$sql = "SELECT id_product,title,description,unitary_price,thumb_image,big_image FROM `product` WHERE `id_product_category`='".intval($row_page['id_product_category'])."'ORDER BY `order` desc LIMIT ".$inicio.", ".$registros;
		
			//echo($sql);
			$row_content = $cn->GetAll($sql);
			return($row_content);
			/*if (!empty($row_content)) {
				$rows[$key]['id_product'] =$row_content['id_product'];
				$rows[$key]['title'] =$row_content['title'];
				$rows[$key]['description'] =$row_content['description'];
				$rows[$key]['unitary_price'] =$row_content['unitary_price'];
				$rows[$key]['thumb_image'] =$row_content['thumb_image'];
				$rows[$key]['big_image'] =$row_content['big_image'];				
			} else {
				$rows[$key]['id_product'] ='';
				$rows[$key]['title'] = "<".$label['empty'].">";
				$rows[$key]['description'] = "<".$label['empty'].">";
				$rows[$key]['unitary_price'] = "<".$label['empty'].">";
				$rows[$key]['thumb_image'] = '';
				$rows[$key]['big_image'] = '';				
			}*/
		}
			return(array('rows'=>$rows));
	}	
	
	
	
	
	
	
	
	
	
	
	
}

?>
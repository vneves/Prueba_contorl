<?php
require_once $APP['base_admin_path']."include/connection.php";
require_once $APP['base_admin_path']."/pages/class/content.php";
require_once $APP['base_admin_path']."/pages/class/page.php";

function printPage ($id) {
	global $cn;
	if (is_numeric($id)) {
		$sql = "SELECT * FROM `content` WHERE id_content='".intval($id)."' LIMIT 1";
	} else {
		$sql = "SELECT * FROM `content` WHERE `permalink`='".addslashes($id)."' LIMIT 1";
	}
	$row_content = $cn->GetRow($sql);
	if (empty($row_content)) {
		return(array());
	}
	$sql = "SELECT * FROM `page` WHERE id_page='$row_content[id_page]' AND is_published='1' LIMIT 1";
	$row_page = $cn->GetRow($sql);
	if (empty($row_page)) {
		return(array());
	}
	foreach ($row_page as $key=>$value) {
		$row_content[$key] = $value;
	}
	
	$sql = "SELECT * FROM `file` WHERE id_content='".$row_content['id_content']."' AND `type`='attach' ORDER BY `order`";
	$row_content['attached_files'] = $cn->GetAll($sql);
	$sql = "SELECT * FROM `file` WHERE id_content='".$row_content['id_content']."' AND `type`='template_image' ORDER BY `order`";
	$row_content['template_images'] = $cn->GetAll($sql);
	
	$sql = "SELECT id_page FROM `page` WHERE `id_parent`='$row_content[id_page]' AND `is_published`='1' ORDER BY `order`";
	
	$rows_children = $cn->GetAll($sql);
	$child = array();
	foreach ($rows_children as $key => $value) {
		$child[] = $value['id_page'];
	}
	$row_content['children'] = implode(",", $child);
//        echo "<pre>";
//        print_r($row_content); 
//         echo "</pre>";
	return($row_content);
}

function printPagebyPage ($id,$lang) {
	global $cn;
	if (is_numeric($id)) {
		$sql = "SELECT * FROM `content` WHERE id_page='".intval($id)."' and  `lang`='$lang' LIMIT 1";
	} else {
		$sql = "SELECT * FROM `content` WHERE `permalink`='".addslashes($id)."' LIMIT 1";
	}
	$row_content = $cn->GetRow($sql);
	if (empty($row_content)) {
		return(array());
	}
//        if($row_content['id_page'] == 129){
//        echo "<pre>";
//        print_r($row_content['id_content']); 
//         echo "</pre>";}
         $arr=array();
         $arr=printPage($row_content['id_content']);
	return($arr);
	/*
	$sql = "SELECT * FROM `page` WHERE id_page='$row_content[id_page]' AND is_published='1' LIMIT 1";
	$row_page = $cn->GetRow($sql);
	if (empty($row_page)) {
		return(array());
	}
	foreach ($row_page as $key=>$value) {
		$row_content[$key] = $value;
	}
	$sql = "SELECT * FROM `file` WHERE id_page='$row_content[id_page]' AND `lang`='$row_content[lang]' AND `type`='attach' ORDER BY `order`";
	$row_content['attached_files'] = $cn->GetAll($sql);
	$sql = "SELECT * FROM `file` WHERE id_page='$row_content[id_page]' AND `lang`='$row_content[lang]' AND `type`='template_image' ORDER BY `order`";
	$row_content['template_images'] = $cn->GetAll($sql);
	
	$sql = "SELECT id_page FROM `page` WHERE `id_parent`='$row_content[id_page]' AND `is_published`='1' ORDER BY `order`";
	
	$rows_children = $cn->GetAll($sql);
	$child = array();
	foreach ($rows_children as $key => $value) {
		$child[] = $value['id_page'];
	}
	$row_content['children'] = implode(",", $child);
	return($row_content);
	*/
}
function printPagebyPage_product_category ($id,$lang) {
	global $cn;
	if (is_numeric($id)) {
		$sql = "SELECT * FROM `product_category` WHERE id_product_category='".intval($id)."' and  `lang`='$lang' LIMIT 1";
	} else {
		$sql = "SELECT * FROM `product_category` WHERE `permalink`='".addslashes($id)."' LIMIT 1";
	}
	$row_content = $cn->GetRow($sql);
	
	if (empty($row_content)) {
		return(array());
	}
	return(printPage($row_content['id_product_category']));
}
function printPagebyPage_product_category_all ($id,$lang) {
	global $cn;
	if (is_numeric($id)) {
		$sql = "SELECT * FROM `product_category` WHERE id_parent='".intval($id)."' and  `lang`='$lang' LIMIT 30";
	} else {
		$sql = "SELECT * FROM `product_category` WHERE `permalink`='".addslashes($id)."' LIMIT 30";
	}
	//print_r($sql);
	$row_content = $cn->GetAll($sql);
	if (empty($row_content)) {
		return(array());
	}
	return($row_content);
}
function printPagebyPage_product ($id,$lang) {
	global $cn;
	if (is_numeric($id)) {
		$sql = "SELECT * FROM `product` WHERE id_product='".intval($id)."' and  `lang`='$lang' LIMIT 1";
	} else {
		$sql = "SELECT * FROM `product` WHERE `permalink`='".addslashes($id)."' LIMIT 1";
	}
	$row_content = $cn->GetRow($sql);
	//print_r($sql);
	if (empty($row_content)) {
		return(array());
	}
	return(printPage($row_content['id_product']));
}
function printPagebyPage_product_all ($id,$lang) {
	global $cn;
	if (is_numeric($id)) {
		$sql = "SELECT * FROM `product` WHERE id_product_category='".intval($id)."' and  `lang`='$lang' LIMIT 30";
	} else {
		$sql = "SELECT * FROM `product` WHERE `permalink`='".addslashes($id)."' LIMIT 30";
	}
	//print_r($sql);
	$row_content = $cn->GetAll($sql);
	if (empty($row_content)) {
		return(array());
	}
	return($row_content);
}



?>
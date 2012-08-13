<?php
if (!defined("FROM_MAIN")) die("");
require_once($APP['base_path'].'/config/config.php');
require_once($APP['base_admin_path'].'/pages/class/page.php');
require_once($APP['base_admin_path'].'/pages/class/content.php');
require_once($APP['base_path'].'/config/category_ids.php');
require_once($APP['base_path'].'/config/category_arrays.php');

if (!isset($_REQUEST['id_page']) || !Page::exists($_REQUEST['id_page']) || !isset($_REQUEST['is_published'])) {
	header("Location: main.php?page=sections");
	exit();
}

$is_published = intval($_REQUEST['is_published']);
$is_published = ($is_published!=0) ? 1 : 0;

$page = new Page($_REQUEST['id_page']);
//print_r($page->_data);
$sql = "UPDATE page SET is_published='$is_published' WHERE id_page=".intval($_REQUEST['id_page']);
$cn->Execute($sql);
//print_r($sql);
//die();
header("Location: main.php?page=sections&id_parent=".$page->_data['id_parent']);
$cn->Close();
exit();
?>
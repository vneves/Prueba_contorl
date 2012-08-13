<?php
if (!defined("FROM_MAIN")) die("");
require_once($APP['base_path'].'/config/config.php');
require_once($APP['base_admin_path'].'/pages/class/page.php');
require_once($APP['base_admin_path'].'/pages/class/content.php');
require_once($APP['base_path'].'/config/category_ids.php');
require_once($APP['base_path'].'/config/category_arrays.php');

if (!isset($_REQUEST['id_page']) || !Page::exists($_REQUEST['id_page'])) {
	header("Location: main.php?page=sections");
	exit();
}

$page = new Page($_REQUEST['id_page']);
Page::delete($_REQUEST['id_page']);
header("Location: main.php?page=sections&id_parent=".$page->_data['id_parent']);
$cn->Close();
exit();
?>
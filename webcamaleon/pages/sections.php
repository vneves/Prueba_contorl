<?php
if (!defined("FROM_MAIN")) die("");
require_once $APP['base_admin_path']."include/submenu.php";

$arr_section = array(
	'list' => array(
		'title' => $label['manage_pages'],
		'section_file' => 'sections_list.php'
	),
	'edit' => array(
		'title' => $label['general_data'],
		'section_file' => 'sections_edit.php'
	),
	'update' => array(
		'title' => $label['general_data'],
		'section_file' => 'sections_edit.php'
	),
	'publish' => array(
		'section_file' => 'sections_publish.php'
	),
	'delete' => array(
		'section_file' => 'sections_delete.php'
	),
	'filemanager' => array(
		'title' => $label['manage_attached_files'],
		'section_file' => 'sections_filemanager.php'
	)
);
//-->Validacion de seccion
$section = initRequestVar('section', 'str', 'list');
$section = array_key_exists($section, $arr_section) ? $section : 'list';
//<--Validacion de seccion

require_once './pages/'.$arr_section[$section]['section_file'];
?>
<?php
if (!defined("FROM_MAIN")) die("");
require_once $APP['base_admin_path']."include/submenu.php";
require_once $APP['base_admin_path'].'pages/class/product_category.php';
/*
EJEMPLO DE SUBMENU
$arr_option = array (
	'manage_account' => array(
		"title" => $label["personal_data"],
		"href" => './main.php?page=options',
		"children" => array(
			0 => array(
				"title" => 'HH',
				"href" => './main.php?page=options'
			)
		),
		"section_file" => "options_personal_data.php"
	),
	
	'password' => array (
		"title" => $label["password"],
		"href" => './main.php?page=options',
		"section_file" => "options_password.php"
	),
	
	'language' => array(
		"title" => $label["language"],
		"href" => './main.php?page=options',
		"section_file" => "options_language.php"
	)
);
*/

//---> Configuracion del submenu
$arr_option = array (
	'products' => array(
		'title' => $label['products'],
		'href' => './main.php?page='.$page_request,
		'section_file' => 'products.php'
	),
	'productscategories' => array (
		"title" => $label['categories'],
		"href" => './main.php?page='.$page_request,
		"section_file" => 'productscategories.php'
	)
);

unset($arr_option['language']);
reset($arr_option);
$section_request = initRequestVar('section', 'str', key($arr_option));
$section_request = (array_key_exists($section_request, $arr_option)) ? $section_request : key($arr_option);

if ($section_request=='products') {
	$categories = Product_category::listCategories(0, 1, 30);
	if (empty($categories['rows'])) {
		$section_request = 'productscategories';
	}
}

foreach ($arr_option as $key=>$value) {
	if ($section_request==$key) {
		$arr_option[$key]["selected"] = true;
	}
	$arr_option[$key]["href"] = './main.php?page='.$page_request.'&section='.$key;
}

$arr_submenu = submenu($arr_option);
//Configuracion del submenu <---
?>
<div class="div_content">
	<div class="space_up"></div>
	<div><img src="images/spacer.gif" width="" height="14" alt="" /></div>
	<!--Submenu-->
	<?php
	echo $arr_submenu["menu"];
	echo $arr_submenu["javascript"];
	?>
	<!--End Submenu-->
	<?php
	require_once 'pages/'.$arr_option[$section_request]['section_file'];
	?>
	<div class="space_down"></div>
</div>
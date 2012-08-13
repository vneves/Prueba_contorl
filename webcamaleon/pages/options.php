<?php
if (!defined("FROM_MAIN")) die("");
require_once $APP['base_admin_path']."include/submenu.php";
/*
EJEMPLO DE SUBMENÃ
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
	'manage_account' => array(
		"title" => $label["personal_data"],
		"href" => './main.php?page='.$page_request,
		"section_file" => "options_personal_data.php"
	),
	'password' => array (
		"title" => $label["password"],
		"href" => './main.php?page='.$page_request,
		"section_file" => "options_password.php"
	),
	//parche, ips permitidas-->
	'allowedips' => array(
		"title" => $label["ip"],
		"href" => './main.php?page='.$page_request,
		"section_file" => "options_ips.php"
	),
	//<--parche, ips permitidas
	'language' => array(
		"title" => $label["language"],
		"href" => './main.php?page=',$page_request,
		"section_file" => "options_language.php"
	)
);

unset($arr_option['language']);
unset($arr_option['allowedips']);

$section = initRequestVar('section', 'str', 'manage_account');
$section = (array_key_exists($section, $arr_option)) ? $section : 'manage_account';

foreach ($arr_option as $key=>$value) {
	if ($section==$key) {
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
	require_once 'pages/'.$arr_option[$section]['section_file'];
	?>
	<div class="space_down"></div>
</div>
<?php
if (!defined("FROM_MAIN")) die("");
require_once $APP['base_path']."/config/arr_menu_options.php";

if ($_SESSION['idTypeUserAcct']==1) {//Administrador backoffice
	unset($menu['users']);
}

?>
<div id="div_menu" style="position:absolute; top:113px; left:0px; width:100%; height:22px; visibility:hidden" align="center" ><!--div menu-->
	<table cellpadding="0" cellspacing="0" border="0" class="menu_table">
	<tr>
	<?php
	$arr_menu = array();
	foreach ($menu as $key=>$value) {
		$class = ($page_request==$key) ? "_selected" : "";
		$arr_menu[] = '<td class="menu_td'.$class.'"><a href="./main.php?page='.$key.'" class="menulink_option'.$class.'">'.$label[$value].'</a></td>';
	}
	$str_menu = implode('<td class="menu_td_separator"><img src="images/spacer.gif" alt="" /></td>', $arr_menu);
	echo $str_menu;
	?>
	</tr>
	</table>
</div><!--end div menu-->
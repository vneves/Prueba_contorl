<?php
if (!defined("FROM_MAIN")) die("");
require_once 'include/sections.php';
require_once($APP['base_admin_path'].'/pages/class/product_category.php');
require_once('smith_class/form_generator_camaleon.php');

if (!isset($_REQUEST['id_product_category']) ||  !Product_category::exists($_REQUEST['id_product_category'])) {
	echo '<script type="text/javascript">window.location.href="main.php?page='.$page_request.'&section='.$section_request.'"</script>';
	return;
}

$product_category = new Product_category($_REQUEST['id_product_category']);
$ret_str = Product_category::delete($_REQUEST['id_product_category']);
?>
<!--TITULO-->
<table cellpadding="0" cellspacing="0" border="0">
<tr>
	<td><img src="images/green_title_left.gif" width="5" height="28" alt="" /></td>
	<td width="786" class="green_title">Borrar categor&iacute;a</td>
	<td><img src="images/green_title_right.gif" width="5" height="28" alt="" /></td>
</tr>
<tr>
	<td style="background-color:#EDEDED"></td>
	<td>
		<!--FORMULARIO-->
		<div class="form_body" style="padding:8px;">
		<?php
			if (!empty($ret_str)) {
				echo $ret_str;
				echo '<div class="error_message">No puede ser eliminada</div>';
				$onclick = 'onclick="window.location.href=\'main.php?page='.$page_request.'&section='.$section_request.'&id_parent='.$product_category->_data['id_parent'].'\'"';
				echo '<div align="center"><input type="button" class="form_submit" value="Volver" '.$onclick.' /></div>';
			} else {
				echo '<script type="text/javascript">window.location.href="main.php?page='.$page_request.'&section='.$section_request.'&id_parent='.$product_category->_data['id_parent'].'"</script>';
			}
			//require_once dirname(__FILE__)."/forms/product_category.php";
		?>
		</div>
		<!--FORMULARIO END-->
	</td>
	<td style="background-color:#EDEDED"></td>
</tr>
</table>
<!--TITULO END-->

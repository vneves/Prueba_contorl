<?php
if (!defined("FROM_MAIN")) die("");
require_once 'include/sections.php';
require_once($APP['base_admin_path'].'/pages/class/product.php');
require_once('smith_class/form_generator_camaleon.php');

if (!isset($_REQUEST['id_product']) ||  !Product::exists($_REQUEST['id_product'])) {
	echo '<script type="text/javascript">window.location.href="main.php?page='.$page_request.'&section='.$section_request.'"</script>';
	return;
}

$product = new Product($_REQUEST['id_product']);
$ret_str = Product::delete($_REQUEST['id_product']);
?>
<!--TITULO-->
<table cellpadding="0" cellspacing="0" border="0">
<tr>
	<td><img src="images/green_title_left.gif" width="5" height="28" alt="" /></td>
	<td width="786" class="green_title">Borrar Producto</td>
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
				$onclick = 'onclick="window.location.href=\'main.php?page='.$page_request.'&section='.$section_request.'\'"';
				echo '<div align="center"><input type="button" class="form_submit" value="Volver" '.$onclick.' /></div>';
			} else {
				echo '<script type="text/javascript">window.location.href="main.php?page='.$page_request.'&section='.$section_request.'"</script>';
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

<?php
if (!defined("FROM_MAIN")) die("");
require_once 'include/sections.php';
require_once($APP['base_admin_path'].'/pages/class/product_file.php');
require_once('smith_class/form_generator_camaleon.php');

if (!isset($_REQUEST['id_product_file']) ||  !Product_file::exists($_REQUEST['id_product_file'])) {
	echo '<script type="text/javascript">window.location.href="main.php?page='.$page_request.'&section='.$section_request.'"</script>';
	return;
}

$product_file = new Product_file($_REQUEST['id_product_file']);
$product = new Product($product_file->_data['id_product']);


$ret_str = Product_file::delete($_REQUEST['id_product_file']);
?>
<!--TITULO-->
<table cellpadding="0" cellspacing="0" border="0">
<tr>
	<td><img src="images/green_title_left.gif" width="5" height="28" alt="" /></td>
	<td width="786" class="green_title">Borrar archivo</td>
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
				$onclick = 'onclick="window.location.href=\'main.php?page='.$page_request.'&section='.$section_request.'&subsection=filemanager&id_product='.$product->_data['id_product'].'\'"';
				echo '<div align="center"><input type="button" class="form_submit" value="Volver" '.$onclick.' /></div>';
			} else {
				echo '<script type="text/javascript">window.location.href="main.php?page='.$page_request.'&section='.$section_request.'&subsection=filemanager&id_product='.$product->_data['id_product'].'"</script>';
			}
		?>
		</div>
		<!--FORMULARIO END-->
	</td>
	<td style="background-color:#EDEDED"></td>
</tr>
</table>
<!--TITULO END-->

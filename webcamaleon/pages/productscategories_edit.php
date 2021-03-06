<?php
if (!defined("FROM_MAIN")) die("");
require_once 'include/sections.php';
require_once($APP['base_admin_path'].'/pages/class/product_category.php');
require_once($APP['base_path'].'/config/category_ids.php');
require_once($APP['base_path'].'/config/category_arrays.php');
require_once('smith_class/form_generator_camaleon.php');

switch ($_REQUEST['action']) {
	case 'insert':
		$product_category = new Product_category('');
		
		$product_category->_data['id_product_category'] = '';
		$product_category->_data['title'] = '';
		$product_category->_data['description'] = '';
		$product_category->_data['order'] = '';
		
		//Validacion de id_parent-->
		if (intval($_REQUEST['id_parent'])!=0) {
			if (!Product_category::exists($_REQUEST['id_parent'])) {
				echo '<script type="text/javascript">window.location="main.php?page='.$page_request.'&section=productscategories";</script>';
				return;
			}
		}
		$product_category->_data['id_parent'] = intval($_REQUEST['id_parent']);
		//<--Validacion de id_parent
		$action_title = $label['add_category'];
		$action = 'insert';
		break;
	case 'edit':
		//Validacion de id_product_category-->
		if (!isset($_REQUEST['id_product_category']) || !Product_category::exists($_REQUEST['id_product_category'])) {
			echo '<script type="text/javascript">window.location="main.php?page='.$page_request.'"&section='.$section_request.';</script>';
			return;
		}
		//<--Validacion de id_product_category
		$arr_path = Product_category::getPath(intval($_REQUEST['id_product_category']));
		$product_category = new Product_category(intval($_REQUEST['id_product_category']));
		
		$action_title = $label['edit_page'];
		$action = 'edit';
		break;
	default:
		//$alert = html_entity_decode($label['unespecified_action']);
		/*echo '<script type="text/javascript">alert(unescape("'.rawurlencode($alert).'")); window.location="main.php?page=sections";</script>';*/
		echo '<script type="text/javascript">window.location="main.php?page=sections";</script>';
		return;
		break;
}
Product_category::printPagePath($product_category->_data['id_parent']);
?>
<!--TITULO-->
<table cellpadding="0" cellspacing="0" border="0">
<tr>
	<td><img src="images/green_title_left.gif" width="5" height="28" alt="" /></td>
	<td width="786" class="green_title"><?php echo $action_title; ?></td>
	<td><img src="images/green_title_right.gif" width="5" height="28" alt="" /></td>
</tr>
<tr>
	<td style="background-color:#EDEDED"></td>
	<td>
		<!--FORMULARIO-->
		<div class="form_body" style="padding:8px;">
		<?php
			
			require_once dirname(__FILE__)."/forms/product_category.php";
		?>
		</div>
		<!--FORMULARIO END-->
	</td>
	<td style="background-color:#EDEDED"></td>
</tr>
</table>
<!--TITULO END-->

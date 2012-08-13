<?php
/* ---------------------------------------
 * Form: page
 * Date: 2008-01-14 16:59:19
 * ---
 * Table information
 *   [file] => /home/www/webdesign/webcamaleon/_private/from_smith/skel//page.php
 * ---
 * IF YOU NEED, THIS FILE CAN BE UPDATED MANUALLY
 * ---------------------------------------
 */
//echo("<pre>");
//print_r($_REQUEST);
//die();

$actionForm = $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];

if ($_SERVER['REQUEST_METHOD']=='POST') {
	$arr_nocheck = array("image", "order");
	
	foreach ($product_category->_cols as $key=>$value) {
		if (in_array($key, $arr_nocheck)) { continue; }		
		$product_category->_data[$key] = $_REQUEST[$key];
		if (($product_category->_isRequired[$key]) == 1) {
			if (trim($product_category->_data[$key]) == '' && $key != $product_category->_keyField) {
				$product_category->_hasError[$key] = 1;
			} else {
				$product_category->_hasError[$key] = 0;
			}
		}
	}
	//validacion de image-->
	if ($_REQUEST['action']=='insert') {
		if (!empty($_FILES['image_file']['tmp_name'])) {
			$image_updated = $product_category->update_image('image_file');
			if (!$image_updated) {
				$validation_fail = true;
			}
		} else {
			$product_category->_data['image'] = '';
		}
	} else {
		if (!empty($_FILES['image_file']['tmp_name'])) {
			$image_updated = $product_category->update_image('image_file');
			if (!$image_updated) {
				$validation_fail = true;
			}
		}
	}
	//<--validacion de image
	if (!isset($validation_fail)) {
		if (!in_array(1, $product_category->_hasError)) {
			$product_category->_data['order'] = '0';
			/*if ($_REQUEST['order']=='first' || $_REQUEST['order']=='last') {
				$product_category->_data['order'] = '0';
			}*/
			$product_category->debug = false;			
			if ($_REQUEST['action']=='insert') {
					saveEmptyProducts_category ($product_category);
					$savingData=1;
			} else {
				$savingData = $product_category->saveData();
				$product_category->_data['permalink'] = "category_".$product_category->_data['id_product_category'].".html";
				$sql = "UPDATE `product_category` SET `permalink`='".$product_category->_data['permalink']."' WHERE id_product_category='".$product_category->_data['id_product_category']."'";
				$cn->Execute($sql);
			}
						
			
//			echo("Hasta aqui - BIEN");
			if ($savingData === 1) {
				$product_category->_tableName = "product_category";
				$product_category->updateOrder($_REQUEST['order']);
				$pagination = isset($_REQUEST['pagination']) ? intval($_REQUEST['pagination']) : '1';
				$url = 'main.php?page='.$page_request.'&section='.$section_request.'&pagination='.$pagination.'&id_parent='.$_REQUEST['id_parent'];
				echo '<script type="text/javascript" language="javascript">window.location.href="'.$url.'";</script>';
			} else {
				//echo("<pre/>");
				//print_r($product_category);
				//print_r($_REQUEST);
				echo 'failed saving category';
			}
		} else {
			@unlink($APP['products_files'].$product_category->_data['image']);
		}
	}
}

$form = new formGeneratorCamaleon('page', $actionForm);

$product_category->_action = $action;

$form->htmlStyleTable = "tableForm";
$form->htmlStyleLabelCell = "labelCell";
$form->htmlStyleLabelErrorCell = "labelCellError";
$form->htmlStyleField = "field";
$form->htmlStyleFieldCell = "fieldCell";
$form->htmlStyleFieldCellError = "fieldCellError";

$form->htmlStyleTextFieldError = "fieldTextError";

$form->openTable('border="0" cellpadding="4" cellspacing="0"');
$form->output .= '<tr><td colspan="2">'.$label['fields_signed_required'].'</td></tr>';

$current_page = isset($_REQUEST['pagination']) ? $_REQUEST['pagination'] : 1;

$form->output .= '<input type="hidden" name="pagination" value="'.$current_page.'" />';
$form->printObjectHiddenField('action', $_REQUEST['action']);
$form->printObjectHiddenField('id_product_category', $product_category->_data['id_product_category']);
$form->printObjectHiddenField('id_parent', $product_category->_data["id_parent"]);

$arr_options = Product_category::listOrder($product_category->_data['id_parent']);
$form->printSelectOrder($arr_options, $product_category->_data['id_product_category']);
$form->printObjectTextField($product_category, 'title', '', 92, 255);
$form->output .= "<tr><td></td><td>".$label['copy_text_warning']."</td></tr>";
$product_category->_data['description']=utf8_encode($product_category->_data['description']);
$form->printObjectHiddenField('lang',$_SESSION['language'] );
$form->printObjectHiddenField('permalink',0 );
$form->printObjectTextAreaField($product_category, 'description','', 91,15,1);
//image field-->
$str_vacio = (!empty($product_category->_data['image'])) ? '<img src="'.$APP['products_files_url'].$product_category->_data['image'].'?rand='.rand(0,5000).'" alt="" />' : '';
$str_img = ($_REQUEST['action']=='edit') ? '<div>'.$str_vacio.'</div>' : '';
$str_error = (!empty($product_category->_hasError['image'])) ? '<div class="error_message">'.$product_category->_hasError['image'].'</div>' : '';
$form->output .= '<tr><td valign="top">Imagen :</td><td>'.$str_img.'<input type="file" name="image_file" />'.$str_error.'</td></tr>';
//<--image field

$current_page = (isset($_REQUEST['pagination'])) ? '&pagination='.$_REQUEST['pagination'] : '';
$url = 'window.location.href=\'main.php?page='.$page_request.'&section='.$section_request.'&id_parent='.$product_category->_data['id_parent'].$current_page.'\'';
$form->output .= '<tr><td></td><td><input class="form_submit" type="submit" value="'.$label['save'].'" />&nbsp;&nbsp;<input class="form_submit" type="button" value="'.$label['cancel'].'" onclick="'.$url.'" /></td></tr>';

$form->closeTable();
$form->closeForm();

echo $form->getFormHTML();

?>
<!--<script language="javascript" type="text/javascript" src="../../../smith/jscripts/tiny_mce3/tiny_mce.js"></script>-->
<script language="javascript" type="text/javascript" src="<?php echo $APP['smith_url']; ?>jscripts/tiny_mce3/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	language : "<?php echo $lang; ?>",
	mode : "exact",
	elements : "description",
	theme : "advanced",
	plugins : "safari,pagebreak,style,layer,table,save,advimage,advlink,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,formatselect,styleselect,separator,code,cleanup",
	theme_advanced_buttons2 : ",fontselect,fontsizeselect,forecolor,backcolor,separator,bullist,numlist,separator,link,unlink",
	theme_advanced_buttons3 : "outdent,indent,separator,undo,redo,separator,hr,removeformat,table,separator,sub,sup,separator,charmap",
	theme_advanced_buttons3 : "tablecontrols",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_resizing : false,

	/*content_css : "css/content.css",*/
	entity_encoding : "numeric",
	encoding : "xml",
	template_external_list_url : "lists/template_list.js",
	external_link_list_url : "lists/link_list.js",
	external_image_list_url : "lists/image_list.js",
	media_external_list_url : "lists/media_list.js"
});
</script>
<?php
//print_r($_SESSION);
//print_r($content);
?>

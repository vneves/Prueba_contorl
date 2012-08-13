<?php
require_once $APP['base_admin_path'].'include/func_createImageThumbail.php';
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

//print_r($_SERVER);
/*function format_number($nro) {
list($entero,$decimal)=explode(".",$nro);
$entero=number_format($entero, 0, '', ',');
$nro=$entero.".".$decimal;
return($nro);
}*/
//echo("<pre>");
//print_r($_SESSION['language']);
$actionForm = $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];

if ($_SERVER['REQUEST_METHOD']=='POST') {
	
	$arr_nocheck = array("thumb_image", "big_image", "available", "is_sponsor", "is_private", "order");
	
	foreach ($product->_cols as $key=>$value) {
		if (in_array($key, $arr_nocheck)) { continue; }
		
		if("unitary_price"==$key)
		$_REQUEST[$key]=eregi_replace(',', '', $_REQUEST[$key]);
//		product->_data['unitary_price'] = str_replace(',', '.', $product->_data['unitary_price']);
		$product->_data[$key] =trim($_REQUEST[$key]);
		if (($product->_isRequired[$key]) == 1) {
			if (trim($product->_data[$key]) == '' && $key != $product->_keyField) {
				$product->_hasError[$key] = 1;
			} else {
				$product->_hasError[$key] = 0;
			}
		}
	}
	//validacion de destacado-->
	if (isset($_REQUEST['is_sponsor']) &&  $_REQUEST['is_sponsor']=='on') {
		$product->_data['is_sponsor'] = 1;
	} else {
		$product->_data['is_sponsor'] = 0;
	}
	//<--validacion de destacado
	//validacion de privado-->
	if (isset($_REQUEST['is_private']) &&  $_REQUEST['is_private']=='on') {
		$product->_data['is_private'] = 1;
	} else {
		$product->_data['is_private'] = 0;
	}
	//<--validacion de privado
	$product->_data['available'] = 1;
	//validacion del precio unitario-->
	/*if ($product->_hasError['unitary_price']==0) {
		//$product->_data['unitary_price'] = str_replace(',', '.', $product->_data['unitary_price']);
		if (validate_price($product->_data['unitary_price'])) {
			$product->_data['unitary_price'] = sprintf("%01.2f", trim($product->_data['unitary_price']));
		} else {
			$validation_fail = true;
			$product->_hasError['unitary_price'] = 'El formato del precio debe ser un n&uacute;mero con un m&aacute;ximo de dos decimales.';
		}
	}*/
	
	
	//<--validacion del precio unitario
	
	
	//validacion de thumb_image y big_image-->

	if ($_REQUEST['action']=='insert') {
		//print_r($_FILES);
		if (!empty($_FILES['thumb_image_file']['tmp_name'])) {
			$parts_t = pathinfo($_FILES['thumb_image_file']['name']);
			$parts_thum= $parts_t['extension']; // imprime 'doc' 
			//echo($parts_thum);
			
		}
		if (!empty($_FILES['big_image_file']['tmp_name'])) {
			$parts_b = pathinfo($_FILES['big_image_file']['name']);
			print_r($parts_b);
			$parts_big= $parts_b['extension']; // imprime 'doc' 
			//echo($parts_big);
		}
		
		/*$product->_data['unitary_price']=$product->_data['unitary_price']." ".$_REQUEST['tipo'];*/
		$thumb_image_updated = true;
		$big_image_updated = true;
		
		if (!empty($_FILES['thumb_image_file']['tmp_name'])) {
			if($parts_thum =='jpg' || $parts_thum=='gif' || $parts_thum =='JPG' || $parts_thum=='GIF' ){
				$thumb_image_updated = $product->update_image('thumb_image_file', 'thumb_image');
			}
		}
		
		if (!empty($_FILES['big_image_file']['tmp_name'])) {
			if($parts_big =='jpg' || $parts_big =='gif' || $parts_thum =='JPG' || $parts_thum=='GIF'){
				$big_image_updated = $product->update_image('big_image_file', 'big_image');
			}
		}
		if (!$thumb_image_updated || !$big_image_updated) {
			$validation_fail = true;
		}
		
	} else {
		if (!empty($_FILES['thumb_image_file']['tmp_name'])) {
			$parts_t = pathinfo($_FILES['thumb_image_file']['name']);
			$parts_thum= $parts_t['extension']; // imprime 'doc' 
			//echo($parts_thum);
			
		}
		if (!empty($_FILES['big_image_file']['tmp_name'])) {
			$parts_b = pathinfo($_FILES['big_image_file']['name']);
			//print_r($parts_b);
			$parts_big= $parts_b['extension']; // imprime 'doc' 
			//echo($parts_big);
		}	
		/*$product->_data['unitary_price']=$product->_data['unitary_price']." ".$_REQUEST['tipo'];*/
		$thumb_image_updated = true;
		$big_image_updated = true;
		
		if (!empty($_FILES['thumb_image_file']['tmp_name'])) {
			if($parts_thum =='jpg' || $parts_thum=='gif' || $parts_thum =='JPG' || $parts_thum=='GIF'){
				$thumb_image_updated = $product->update_image('thumb_image_file', 'thumb_image');
			}
		}
		
		if (!empty($_FILES['big_image_file']['tmp_name'])) {
			if($parts_big =='jpg' || $parts_big =='gif'){
				$big_image_updated = $product->update_image('big_image_file', 'big_image');
			}
		}
		if (!$thumb_image_updated || !$big_image_updated) {
			$validation_fail = true;
			
		}		
	}
	//<--validacion de thumb_image y big_image
	if (!isset($validation_fail)) {
		//echo("entro");		
		if (!in_array(1, $product->_hasError)) {
			$product->_data['order'] = '0';
			/*if ($_REQUEST['order']=='first' || $_REQUEST['order']=='last') {
				$product->_data['order'] = '0';
			}*/
	//		echo("<pre>");
//			print_r($product->_data['description']);
			//die();
			//echo("<pre>");
			
			$product->_data['id_product_category']=$_POST['id_product_category'];
			//print_r($product->_data['id_product_category']);
			//print_r($_POST['id_product_category']);
			$product->debug = false;
			if ($_REQUEST['action']=='insert') {
					saveEmptyProducts ($product);
					$savingData=1;
			} else {
				$savingData = $product->saveData();
				$product->_data['permalink'] = "product_".$product->_data['id_product'].".html";
				$sql = "UPDATE `product` SET `permalink`='".$product->_data['permalink']."' WHERE id_product='".$product->_data['id_product']."'";
				$cn->Execute($sql);
			}
			//echo("<pre>");
			//print_r($product);
			//die();			
			
			//die();
			//print_r($product->_data['description']);
			//die();
			if (!empty($product->_data['thumb_image'])){			
				$pathSource=$APP['products_files'].$product->_data['thumb_image'];
				$pathDest=$APP['products_files']."tn_".$product->_data['thumb_image'];			
				createImageThumbail($pathSource,$pathDest,109,99,$overwrite=TRUE,$calidadJPG=100);
			}
			if ($savingData === 1) {
				$product->updateOrder($_REQUEST['order']);
				$pagination = isset($_REQUEST['pagination']) ? intval($_REQUEST['pagination']) : '1';
				$url = 'main.php?page='.$page_request.'&section='.$section_request.'&pagination='.$pagination;
				echo '<script type="text/javascript" language="javascript">window.location.href="'.$url.'";</script>';
			} else {
				echo 'failed saving product';
				$savingData = 0;
			}
		} else {
			$savingData = 0;
		}
	} else {			
		$savingData = 0;
	}
	
	if (empty($savingData) && $_REQUEST['action']=='insert') {
		@unlink($APP['products_files'].$product->_data['thumb_image']);
		@unlink($APP['products_files'].$product->_data['big_image']);
	}
}

$form = new formGeneratorCamaleon('product_form', $actionForm);

$product->_action = $action;

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
$form->printObjectHiddenField('id_product', $product->_data['id_product']);

//$form->output .= '<tr><td>Categor&iacute;a</td><td>'.$product_category->_data['title'].'<input type="hidden" name="id_product_category" value="'.$product_category->_data['id_product_category'].'" /></td></tr>';
$form->output .= '<tr><td>Categor&iacute;a</td><td><select name="id_product_category">';
?>
						<?php
						if (!isset($_REQUEST['id_product_category'])) {
							$_REQUEST['id_product_category'] = '';
						}
						
						$category_arr = Product_category::listNestedCategories(0);
						$str_combo = Product_category::printRecursiveCategory ($category_arr, 0, $product_category->_data['id_product_category']);						
						
						?>
					<?php
$form->output .= $str_combo.'</select></td></tr>';


$arr_options = Product::listOrder($product_category->_data['id_product_category']);
$form->printSelectOrder($arr_options, $product->_data['id_product']);

$form->printObjectTextField($product, 'title', '', 92, 255);
//$product->_data['unitary_price'] = sprintf('%1.2f', $product->_data['unitary_price']);
//$form->printObjectTextField($product, 'unitary_price', '', 62, 12);

$sus_selected="";
$s_selected="";
if($product->_data['unitary_price']!=""){
if (eregi('\$us', $product->_data['unitary_price'])){
	$sus_selected='selected="true"';
	$s_selected="";
}else if(eregi('\$', $product->_data['unitary_price'])){
	$sus_selected='';
	$s_selected='selected="true"';
}
//print_r($product->_data['unitary_price']);
/*$product->_data['unitary_price'] = eregi_replace('\$us', '', $product->_data['unitary_price']);
$product->_data['unitary_price'] = eregi_replace('\$', '', $product->_data['unitary_price']);
$product->_data['unitary_price']= format_number($product->_data['unitary_price']);*/
//print_r($product->_data['unitary_price']);
}






/*$form->output .='
				 <tr>
				 	<td><div style="width:140px;">Precio unitario (*):</div></td>
					<td><input type="text" name="unitary_price" id="unitary_price" class="fieldText" size="30" value="'.$product->_data['unitary_price'].'" maxlength="50" />
					<select name="tipo" id="tipo">
					
					<option value="$us" '.$sus_selected.' >$us</option>
					<option value="$" '.$s_selected.' >$</option>
				
					
					
					</select></td>'; */

$arr_products_options = array();
$checked = $product->_data['is_sponsor']==1 ? 'checked="checked"' : '';
//$arr_products_options['destacado'] = '<input id="chk_sponsor" type="checkbox" name="is_sponsor" '.$checked.' /><label for="chk_sponsor">Producto destacado</label>';
$checked = $product->_data['is_private']==1 ? 'checked="checked"' : '';
//$arr_products_options['private'] = '<input id="chk_private" type="checkbox" name="is_private" '.$checked.' /><label for="chk_private">Visible s&oacute;lo para los franquiciatarios</label>';

//$form->output .= '<tr><td>Opciones</td><td>'.implode('<br />', $arr_products_options).'</td></tr>';
$form->output .= '<input id="chk_private" type="hidden" name="is_private" value="on" />';

$form->output .= "<tr><td></td><td>".$label['copy_text_warning']."</td></tr>";
//$descrip = utf8_encode($id_child['description']);

$product->_data['description']=utf8_encode($product->_data['description']);
//print_r($product->_data['description']);
$form->printObjectHiddenField('unitary_price',0);
$form->printObjectTextAreaField($product, 'description','', 91,15,1);
$form->printObjectHiddenField('lang',$_SESSION['language'] );
$form->printObjectHiddenField('permalink',0 );
$form->printObjectTextAreaField($product, 't_nutricional','', 91,5,1);
$form->printObjectTextAreaField($product, 'envase','', 91,5,1);
$form->printObjectTextAreaField($product, 'c_envase','', 91,5,1);
$form->printObjectTextAreaField($product, 'preparacion','', 91,5,1);
$form->printObjectTextAreaField($product, 'ingredientes','', 91,5,1);
//thumb_image field-->
$str_vacio = (!empty($product->_data['thumb_image'])) ? '<img src="'.$APP['products_files_url'].$product->_data['thumb_image'].'?rand='.rand(0,5000).'" alt="" />' : '';
$str_img = ($_REQUEST['action']=='edit') ? '<div>'.$str_vacio.'</div>' : '';
$str_error = (!empty($product->_hasError['thumb_image'])) ? '<div class="error_message">'.$product->_hasError['thumb_image'].'</div>' : '';
$str_error = "";
$form->output .= '<tr><td valign="top">Imagen :</td><td>'.$str_img.'<input type="file" name="thumb_image_file" />'.$str_error.'</td></tr>';
//<--thumb_image field

//big_image field-->
//$str_vacio_big = (!empty($product->_data['big_image'])) ? '<img src="'.$APP['products_files_url'].$product->_data['big_image'].'?rand='.rand(0,5000).'" alt="" />' : '';
//$str_img = ($_REQUEST['action']=='edit') ? '<div>'.$str_vacio_big.'</div>' : '';
//$str_error = (!empty($product->_hasError['big_image'])) ? '<div class="error_message">'.$product->_hasError['big_image'].'</div>' : '';
//$str_error = "";
//$form->output .= '<tr><td valign="top">Imagen grande :</td><td>'.$str_img.'<input type="file" name="big_image_file" />'.$str_error.'</td></tr>';
//<--big_image field

//image field-->
/*
$str_img = ($_REQUEST['action']=='edit') ? '<div><img src="'.$APP['products_files_url'].$product->_data['image'].'?rand='.rand(0,5000).'" alt="" /></div>' : '';
$str_error = (!empty($product->_hasError['image'])) ? '<div class="error_message">'.$product->_hasError['image'].'</div>' : '';
$form->output .= '<tr><td valign="top">Imagen (*):</td><td>'.$str_img.'<input type="file" name="image_file" />'.$str_error.'</td></tr>';
*/
//<--image field

$current_page = (isset($_REQUEST['pagination'])) ? '&pagination='.$_REQUEST['pagination'] : '';
$url = 'window.location.href=\'main.php?page='.$page_request.'&section='.$section_request.$current_page.'\'';
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
	elements : "description,t_nutricional,envase,c_envase,preparacion,ingredientes",
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
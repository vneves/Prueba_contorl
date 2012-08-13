<?php
require_once $APP['base_admin_path'].'include/func_createImageThumbail.php';
if (!defined("FROM_MAIN")) die("");

switch ($_REQUEST['action']) {
	case 'insert':
		$product_file = new Product_file('');
		foreach ($product_file->_cols as $field=>$type) {
			$product_file->_data[$field] = '';
		}
		$action_title = $label['add_file'];
		break;
	case 'edit':
		//validation of id_product_file-->
		if (!isset($_REQUEST['id_product_file']) || !Product_file::exists($_REQUEST['id_product_file'])) {
			echo '<script language="javascript" type="text/javascript">
			window.location.href = "main.php?page='.$page_request.'&section='.$section_request.'&subsection=filemanager&id_product='.$product->_data['id_product'].'";
			</script>';
		}
		//<--validation of id_product_file
		$product_file = new Product_file($_REQUEST['id_product_file']);
		$title = $label['edit_file'];
		$hide_input_tile = true;
		$action_title = $label['edit_file'];
		/*
		if (!file_exists($APP['page_files'].'/'.$values['id_page'].'/'.$values['filename'])) {
			unset($hide_input_tile);
		}
		*/
		break;
}

if ($_SERVER['REQUEST_METHOD']=='POST') {
	//$_POST['type'] = $_REQUEST['type'];
	$_POST['type'] = 'attach';
	$_POST['id_product'] = $_REQUEST['id_product'];
	$_POST['is_private'] = $_REQUEST['is_private'] = 1;
	
	$arr_nocheck = array('filename', 'is_private');
	
	foreach ($product_file->_cols as $key=>$value) {
		if (in_array($key, $arr_nocheck)) { continue; }
		$product_file->_data[$key] = $_REQUEST[$key];
		if (($product_file->_isRequired[$key]) == 1) {
			if (trim($product_file->_data[$key]) == '' && $key != $product_file->_keyField) {
				$product_file->_hasError[$key] = 1;
			} else {
				$product_file->_hasError[$key] = 0;
			}
		}
	}
	
	$product_file->_data['is_private'] = 1;
	
	//validacion de thumb_image y big_image-->
	if ($_REQUEST['action']=='insert') {
		$image_updated = $product_file->update_image('file','filename');
		if (!$image_updated) {
			$validation_fail = true;
		}
	} else {
		$image_updated = true;
		if (!empty($_FILES['file']['tmp_name'])) {
			$image_updated = $product_file->update_image('file', 'filename');
		}
		if (!$image_updated) {
			$validation_fail = true;
		}
	}
	//<--validacion de thumb_image y big_image

	if (!isset($validation_fail)) {
		if (!in_array(1, $product_file->_hasError)) {
			$product_file->debug = false;
			$savingData = $product_file->saveData();
			$pathSource=$APP['private_products_files'].$product_file->_data['filename'];
			$pathDest=$APP['private_products_files']."tn_".$product_file->_data['filename'];			
			
			createImageThumbail($pathSource,$pathDest,109,99,$overwrite=TRUE,$calidadJPG=100);
			//die();
			//die();
			if ($savingData === 1) {
				//$product_file->updateOrder($_REQUEST['order']);
				$pagination = isset($_REQUEST['pagination']) ? intval($_REQUEST['pagination']) : '1';
				$url = 'main.php?page='.$page_request.'&section='.$section_request.'&subsection=filemanager&id_product='.$product_file->_data['id_product'].'&pagination='.$pagination;
				//echo $url;
				echo '<script type="text/javascript" language="javascript">window.location.href="'.$url.'";</script>';
			} else {
				echo 'failed saving product file';
				$savingData = 0;
			}
		} else {
			$savingData = 0;
		}
	} else {
		$savingData = 0;
	}
	if (empty($savingData) && $_REQUEST['action']=='insert') {
		@unlink($APP['private_products_files'].$product_file->_data['filename']);
	}
}

?>
		<div id="div_file_types"><?php echo "Producto : ".$product->_data['title']; ?></div>
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td valign="top">
				<!--Tabla formulario-->
				<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width="5"><img src="images/green_title_left.gif" width="5" height="28" alt="" /></td>
					<td class="green_title"><?php echo $action_title; ?></td>
					<td width="5"><img src="images/green_title_right.gif" width="5" height="28" alt="" /></td>
				</tr>
				<tr>
					<td class="form_body"></td>
					<td valign="top" class="form_body">
						<form method="post" enctype="multipart/form-data">
						<input type="hidden" name="action" value="<?php echo $_REQUEST['action']; ?>" />
						<input type="hidden" name="id_product_file" value="<?php echo $product_file->_data['id_product_file']; ?>" />
						<input type="hidden" name="id_product" value="<?php echo $_REQUEST['id_product'] ?>" />
						<input type="hidden" name="type" value="attach" />
						<table border="0" cellpadding="4" cellspacing="0" id="form_file">
						<tr>
							<td colspan="2">
								<?php echo $label['fields_signed_required']; ?>
							</td>
						</tr>
						<tr>
							<td valign="top"><?php echo $label['title']; ?> (*): </td>
							<td><input class="fieldText" type="text" name="title" size="30" value="<?php echo htmlentities($product_file->_data['title']); ?>" /><?php if(!empty($product_file->_hasError['title'])) echo '<div class="error_message">'.$label['required_field'].'</div>'; ?></td>
						</tr>
						<!--
						<tr>
							<td valign="top"><?php echo $label['description']; ?>: </td>
							<td><textarea id="input_description" class="fieldTextArea" name="description" cols="27" rows="3" style="width:192px"><?php echo ""; ?></textarea></td>
						</tr>
						-->
						<tr>
							<td valign="top">Tag: </td>
							<td><input class="fieldText" type="text" name="tag" size="30" value="<?php echo $product_file->_data['tag']; ?>" /></td>
						</tr>
						<tr>
							<td valign="top"><?php echo $label['order']; ?> (*): </td>
							<td>
								<input class="fieldText" type="text" name="order" value="<?php echo @$product_file->_data['order']; ?>" /><?php if(@$product_file->_hasError['order']==1) echo '<div class="error_message">'.$label['required_field'].'</div>'; ?>
							</td>
						</tr>
						<tr>
							<td valign="top"><?php echo $label['file']; ?> (*): </td>
							<td>
							<?php
							if ($_REQUEST['action']=='edit') {
								$src = $APP['base_url'].'readfile.php?filetype=product_file&id='.$product_file->_data['id_product_file'];
								echo '<div><a href="'.$src.'" target="_blank" title="'.$label['preview'].'">'.$product_file->_data['filename'].'</a></div>';
							}
							?>
							<input type="file" name="file" value="" /><?php if(!empty($product_file->_hasError['filename'])) echo '<div class="error_message">'.$product_file->_hasError['filename'].'</div>'; ?>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<?php
								$url = "main.php?page=$page_request&section=$section_request&subsection=filemanager&id_product=".$product->_data['id_product'];
								?>
								<input class="form_submit" type="submit" value="<?php echo $label['save']; ?>" />&nbsp;
								<input class="form_submit" type="button" value="<?php echo $label['cancel']; ?>" onClick="window.location.href='<?php echo $url; ?>'" />
							</td>
						</tr>
						</table>
						</form>
					</td>
					<td class="form_body"></td>
				</tr>
				</table>
				<!--Tabla formulario END-->
			</td>
		</tr>
		</table>
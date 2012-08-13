<?php
require_once $APP['base_admin_path'].'include/func_createImageThumbail.php';

if (!defined("FROM_MAIN")) die("");
switch ($_REQUEST['action']) {
	case 'insert':
		$title = $label['add_file'];
		$values = array(
			'title' => '',
			'order' => '',
			'description' => ''
		);
		$action_title = $label['add_file'];
		break;
	case 'edit':
		$title = $label['edit_file'];
		$values = $file->_data;
		$hide_input_tile = true;
		$action_title = $label['edit_file'];
		break;
}

if ($_SERVER['REQUEST_METHOD']=='POST') {
	$_POST['type'] = $_REQUEST['type'];
	$_POST['id_content'] = $_REQUEST['id_content'];
	$_POST['is_private'] = (isset($_REQUEST['is_private']) && strtolower($_REQUEST['is_private'])=='on') ? 1 : 0;
	
	$dir_files = ($_POST['is_private']==0) ? $APP['files_resources'].$page->_data['id_page'] : $APP['private_files_resources'].$page->_data['id_page'];
	
	if (!is_dir($dir_files)) {
		$created_dir = mkdir($dir_files, 0777);
		chmod($dir_files, 0777);
	}
	//echo("<pre>");
	//print_r($_POST);
	//echo("<br/>");
	//print_r($_FILES);
	//die();
	//Validaciones-->	
	$arr_error = array();
	if (empty($_POST['title'])) {
		$arr_error['title'] = $label['required_field'];
	}
	if (empty($_POST['order'])) {
		$arr_error['order'] = $label['required_field'];
	}
	$num=count($format_arc);
	print_r($num);
	$cont=0;
	for($i=1;$i<=$num;$i++) {
		//print_r($_FILES);
		
		if($_FILES['file']['type']==$format_arc[$cont]){
			$_FILES['file']['error']=0;
			break;		
		}else{
			if (!eregi($_FILES['file']['name'], ".swf")) {
				$_FILES['file']['error']=0;
				break;
			}else{
				$_FILES['file']['error']=8;
			}
		}		
		$cont++;
	}
	/*echo("<pre>");
	print_r($_FILES);
	echo("<br/>");
	print_r($format_arc);
	die();*/
	if ($_REQUEST['action']=='insert') {
		if (isset($_FILES['file'])) {
			if ($_FILES['file']['error']==0) {			
				if ($_FILES['file']['size']>0) {
					$file_dir = ($_POST['is_private']==0) ? $APP['files_resources'] : $APP['private_files_resources'];
					$file_dir .= $page->_data['id_page'].'/';
					$arr_filename = explode(".", $_FILES['file']['name']);
					$file_extension = array_pop($arr_filename);
					$file_basename = implode(".", $arr_filename);
					
					$file_basename = generate_permalink($file_basename);//Generate a valid filename
					
					$file_path = $file_dir.$file_basename.".".$file_extension;
					while (file_exists($file_path)) {
						$file_basename .= random_string();
						$file_path = $file_dir.$file_basename.".".$file_extension;
					}
					
					if (!move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {
						$arr_error['file'] = $label['upload_error_7'];
					} else {
						$_POST['filename'] = $file_basename.".".$file_extension;
						chmod($file_path, 0777);
					}
				} else {
					$arr_error['file'] = $label['empty_file'];
				}
			} else {
				if ($_FILES['file']['error']>=9) {
					$arr_error['file'] = $label['upload_error_9'];
				} else {
					$arr_error['file'] = $label['upload_error_'.$_FILES['file']['error']];
				}
			}
		}
	} else {
		$_POST['filename'] = $file->_data['filename'];
		
		if ($_POST['is_private'] != $file->_data['is_private']) {
			$source_path = ($file->_data['is_private']==0) ? $APP['files_resources'].'/' : $APP['private_files_resources'].'/';
			$source_path .= $page->_data['id_page'].'/'.$file->_data['filename'];
			
			$file_dir = ($_POST['is_private']==0) ? $APP['files_resources'] : $APP['private_files_resources'];
			$file_dir .= $page->_data['id_page'].'/';
			
			$arr_filename = explode(".", $file->_data['filename']);
			$file_extension = array_pop($arr_filename);
			$file_basename = implode(".", $arr_filename);
			
			$file_basename = generate_permalink($file_basename);//Generate a valid filename
			
			$file_path = $file_dir.$file_basename.'.'.$file_extension;
			while (file_exists($file_path)) {
				$file_basename .= random_string();
				$file_path = $file_dir.$file_basename.".".$file_extension;
			}
			//die($source_path."<br>".$file_path);
			
			if (!rename($source_path, $file_path)) {
				$arr_error['file'] = $label['upload_error_7'];
			} else {
				$_POST['filename'] = $file_basename.'.'.$file_extension;
			}
		}
	}
	//<--Validaciones
	$values = $_POST;
	if (empty($arr_error)) {
		foreach ($file->_cols as $key=>$value) {
			$file->_data[$key] = @$_POST[$key];
			if (($file->_isRequired[$key]) == 1) {
				if ($file->_data[$key] == '' && $key != $file->_keyField) {
					$file->_hasError[$key] = 1;
				} else {
					$file->_hasError[$key] = 0;
				}
			}
		}
		$file->debug = false;
		$savingData = $file->saveData();
		if ($savingData) {
			if ($_REQUEST['action']=='insert') {
				//parche para crear thumb para la galeria cuando se inserta-->
				$pathSource = $file_path;
				$pathDest = $file_dir . '/tngallery_' . $file_basename.'.'.$file_extension;
				$maxWidth = 59;//128
				$maxHeight = 59;//92//imagenes_tamano
				$thumb_created = createImageThumbail($pathSource,$pathDest,$maxWidth,$maxHeight,$overwrite=TRUE,$calidadJPG=100);
				
				if ($thumb_created && $file->_data['tag']=='gallery') {
					$filesize = getimagesize($pathSource);
					if ($filesize[0]>421 or $filesize[1]>217 ) {
						$pathDest = $file_dir.$file_basename.'.'.$file_extension;
						createImageThumbail($pathSource,$pathDest,421,217,$overwrite=TRUE,$calidadJPG=100);
					}
				}
				//<--parche para crear thumb para la galeria cuando se inserta
			} else {
				//parche para crear thumb para la galeria cuando se edita-->
				if ($file->_data['type']=='template_image' && $file->_data['tag']=='gallery') {
					$file_path = $APP['files_resources'].$file->_data['id_page'].'/'.$file->_data['filename'];
					$filesize = getimagesize ($file_path);
					
					if ($filesize!=false) {
						$pathSource = $file_path;
						$pathDest = dirname($file_path).'/tngallery_'. basename($file_path);
						$maxWidth = 128;
						$maxHeight = 92;
						$thumb_created = createImageThumbail($pathSource,$pathDest,$maxWidth,$maxHeight,$overwrite=TRUE,$calidadJPG=100);
						if ($filesize[0]>525) {
							$tmp = rand(0,9999);
							copy($pathSource, $pathSource.$tmp);
							createImageThumbail($pathSource.$tmp,$pathSource,525,$filesize[1],$overwrite=TRUE,$calidadJPG=100);
							unlink($pathSource.$tmp);
						}
					}
				}
				//<--parche para crear thumb para la galeria cuando se edita
			}
			
			//Para utilizar el archivo en mas de un idioma-->
			if ($_REQUEST['action']=='insert' && isset($_POST['shared_file'])) {
				$file->shareFile();
			}
			//<--Para utilizar el archivo en mas de un idioma
			echo '<script language="javascript">window.location.href="main.php?page=sections&section=filemanager&id_content='.$_REQUEST['id_content'].'&type='.$_REQUEST['type'].'";</script>';
		} else {


		}
	} else {
	 	if ($_REQUEST['action']=='insert') {
			@unlink($file_path);
		}
	}
}

?>
<div class="div_content">
	<div class="space_up"></div>
	<div><img src="images/spacer.gif" width="" height="14" alt="" /></div>
	<!--Submenu-->
	<div style="float:left; width:10px;"><img src="images/spacer.gif" width="10" height="1" alt="" /></div>
	<div style="float:left; padding-left:12px" id="div_form">
		<div style="width:796px;">
			<table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tr>
				<td class="page_title" style="padding-top:13px; padding-bottom:13px; border-bottom:1px solid #AFCD5B;"><?php echo $label['manage_files']; ?></td>
			</tr>
			</table>
		</div>
		<div><img src="images/spacer.gif" width="1" height="17" alt="" /></div>
		<?php
		printPagePath($page->_data['id_parent'], $lang);
		$href_self = $_SERVER['PHP_SELF']."?page=sections&section=filemanager&id_content=$_REQUEST[id_content]&type=";
		$arr_links = array();
		foreach ($APP['file_type'] as $file_type=>$caption) {
			if ($file_type==$_REQUEST['type']) {
				$class = 'class="selected"';
				$href = "#";
			} else {
				$class = '';
				$href = $href_self.$file_type;
			}
			$arr_links[] = '<a '.$class.' href="'.$href.'">'.$label[$caption].'</a>';
		}
		?>
		<div id="div_file_types"><?php echo $label['page']." ".$content->_data['title']; ?><br />[ <?php echo implode(" - ", $arr_links);?> ]</div>
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
						<!--<form method="post" enctype="multipart/form-data" action="<?php echo "main.php?page=sections&section=filemanager&action=$_REQUEST[action]&id_content=".$_REQUEST['id_content']; ?>">-->
						<form method="post" enctype="multipart/form-data" action="">
						<?php
						if ($_REQUEST['action']=='edit') {
							echo '<input type="hidden" name="id_file" value="'.$_REQUEST['id_file'].'" />';
						}
						?>
						<input type="hidden" name="type" value="<?php echo $_REQUEST['type']; ?>" />
						<table border="0" cellpadding="4" cellspacing="0" id="form_file">
						<tr>
							<td colspan="2">
								<?php echo $label['fields_signed_required']; ?>
							</td>
						</tr>
						<tr>
							<td valign="top"><?php echo $label['title']; ?> (*): </td>
							<td><input class="fieldText" type="text" name="title" size="30" value="<?php echo $values['title']; ?>" /><?php if(isset($arr_error['title'])) echo '<div class="error_message">'.$arr_error['title'].'</div>'; ?></td>
						</tr>
						<tr>
							<td valign="top"><?php echo $label['description']; ?>: </td>
							<td><textarea id="input_description" class="fieldTextArea" name="description" cols="27" rows="3" style="width:192px"><?php echo htmlentities($values['description']); ?></textarea></td>
						</tr>
						<tr>
							<td valign="top">Tag: </td>
							<td><input class="fieldText" type="text" name="tag" size="30" value="<?php echo @$values['tag']; ?>" /></td>
						</tr>
						<tr>
							<td valign="top"><?php echo $label['order']; ?> (*): </td>
							<td><input class="fieldText" type="text" name="order" value="<?php echo @$values['order']; ?>" /><?php if(isset($arr_error['order'])) echo '<div class="error_message">'.$arr_error['order'].'</div>'; ?></td>
						</tr>
						<?php
						?>
						<tr>
							<td valign="top"><?php echo $label['file']; ?> (*): </td>
							<td>
							<?php
							if (!isset($hide_input_tile)) {
								echo '<input class="fieldText" type="file" name="file" />';
								if(isset($arr_error['file'])) echo '<div class="error_message">'.$arr_error['file'].'</div>';
							} else {
								echo '<a href="'.$APP['files_resources_url'].$page->_data['id_page']."/".$file->_data['filename'].'" target="_blank" title="'.$label['preview'].'">'.$file->_data['filename'].'</a>';
							}
							?>
							</td>
						</tr>
						<?php
						if ($_REQUEST['action']=='insert' && count($APP['content_languages'])>1) {
						?>
							<!--<tr>
								<td><label for="chk_shared">Compartir: </label></td>
								<td><input type="checkbox" name="shared_file" id="chk_shared"/><br /><label for="chk_shared">(Utilizar este archivo para todos los idiomas)</label></td>
							</tr>-->
						<?php
						}
						?>
						<tr>
							<td></td>
							<td>
								<?php
								$url = "main.php?page=sections&section=filemanager&id_content=$_REQUEST[id_content]&type=$_REQUEST[type]";
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
			<td valign="top"><img src="images/spacer.gif" width="10" height="1" alt="" /></td>
			<?php
				if ($_REQUEST['type']=='template_image') {
			?>
				<td valign="top">
					Si el tag de la imagen es:
					<table cellpadding="0" cellspacing="0" border="0">
					<!--<tr>
						<td valign="top">&bull;&nbsp;</td>
						<td><strong>home</strong> - Se mostrar&aacute; como imagen adjunta del contenido mostrado en la p&aacute;gina de inicio.<br />
							 Su tama&ntilde;o debe ser de 127px de ancho por 92 px de alto.
						</td>
					</tr>-->
					<!--<tr>
						<td valign="top">&bull;&nbsp;</td>
						<td><strong>gallery</strong> - Se usar&aacute; para formar la galer&iacute;a de im&aacute;genes de la p&aacute;gina seleccionada.<br />
							 El ancho m&aacute;ximo de la imagen debe ser de 550px.
						</td>
					</tr>-->
                    <tr>
						<td valign="top">&bull;&nbsp;</td>
						<td><strong>imagenes</strong> - Se usar&aacute; para formar la galer&iacute;a de im&aacute;genes de incio. Medidas: ancho 350px alto 200px.<br />							 
						</td>
					</tr>
                    <tr>
						<td valign="top">&bull;&nbsp;</td>
						<td><strong>producto</strong> - Se usar&aacute; para formar la galer&iacute;a de Cat&aacute;logo de Productos. Medidas: ancho 330px alto 400px.<br />							 
						</td>
					</tr>
                    <!--<tr>
						<td valign="top">&bull;&nbsp;</td>
						<td><strong>fondo</strong> - Se usar&aacute; para el fondo de pagina.<br />
						</td>
					</tr>-->
                    <tr>
						<td valign="top">&bull;&nbsp;</td>
						<td><strong>content_text</strong> - Se usar&aacute; como imagen que acompa&ntilde;ara al texto de la p&aacute;gina.<br />
						</td>
					</tr>
					</table>
				</td>
			<?php	
				}
			?>
		</tr>
		</table>
	</div>
	<!--End Submenu-->
	<div class="space_down"></div>
</div>
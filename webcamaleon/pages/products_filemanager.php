<?php
if (!defined("FROM_MAIN")) die("");
require_once $APP['base_admin_path'].'include/sections.php';
require_once $APP['base_admin_path'].'pages/class/product_file.php';

//Validacion de id_device_category-->
if (!isset($_REQUEST['id_product']) || !Product::exists($_REQUEST['id_product'])) {
	echo '<script language="javascript" type="text/javascript">window.location.href="main.php?page='.$page_request.'&section='.$section_request.'";</script>';
	return;
}
//<--Validacion de id_device_category

$product = new Product($_REQUEST['id_product']);

if ($subsection_request=='filemanager_edit') {
	require_once $APP['base_admin_path'].'pages/products_filemanager_edit.php';
	return;
}

$page_size = $APP['skins_num_page'];
$num_page = 1;

if (isset($_REQUEST['pagination'])) {
	$num_page = intval($_REQUEST['pagination']);
	$num_page = $num_page<0 ? 1 : $num_page;
}

$arr_data = Product_file::pagination($num_page, $page_size, $_REQUEST['id_product']);

$num_items = empty($arr_data['rows']) ? 0 : 1;
$rs = $arr_data['rows'];

?>
		<div>
		<table cellpadding="2" cellspacing="0" border="0">
		</table>
		<script language="javascript" type="text/javascript">
		<?php
		$alert_msg = rawurlencode(html_entity_decode($label['confirm_delete_file']));
		?>
		function confirm_delete(pageTitle, id) {
			resp = confirm(unescape("%BF<?php echo $alert_msg; ?>" + " " + pageTitle + "?"));
			if (resp) {
				window.location.href = "main.php?page=<?php echo $page_request; ?>&section=<?php echo $section_request; ?>&subsection=filemanager_delete&id_product_file=" + id;
			}
		}
		</script>
		<!--Formulario de búsqueda y paginación-->
		<div id="div_file_types">Producto : <?php echo $product->_data['title']; ?></div>
		<form method="post">
		<table cellpadding="2" cellspacing="0" border="0">
		<?php
		//pagination-->
		if ($arr_data['num_pages']>1) {
		
			echo '<tr><td width="235" colspan="6">';
			echo '<table cellpadding="0" cellspacing="0" border="0"><tr>';
			echo '<td>Paginaci&oacute;n :</td>';
			
			echo '<td>&nbsp;';
			if ($arr_data['page']>1) {
				echo '<a href="main.php?page='.$page_request.'&section='.$section_request.'&pagination='.($arr_data['page']-1).'"><img src="images/left_arrow.gif" alt="" width="9" height="20" /></a>';
			} else {
				echo '<img src="images/spacer.gif" alt="" width="9" height="20" />';
			}
			echo '&nbsp;</td>';
			
			echo '<td><select onchange="window.location.href=\'main.php?page='.$page_request.'&section='.$section_request.'&pagination=\' + this.value">';
			for ($i=1; $i<=$arr_data['num_pages']; $i++) {
				$selected = ($i==$arr_data['page']) ? ' selected="selected" ' : '';
				echo '<option value="'.$i.'" '.$selected.'>'.($i).'</option>';
			}
			echo '</select></td>';
			
			echo '<td>&nbsp;';
			if ($arr_data['page']<$arr_data['num_pages']) {
				echo '<a href="main.php?page='.$page_request.'&section='.$section_request.'&pagination='.($arr_data['page']+1).'"><img src="images/right_arrow.gif" alt="" width="9" height="20" /></a>';
			} else {
				echo '<img src="images/spacer.gif" alt="" width="9" height="20" />';
			}
			echo '</td>';
			
			echo '</tr></table>';
			echo '</td></tr>';
		}
		//<--pagination
		?>
		</table>
		</form>
		<!--Formulario de búsqueda y paginación END-->
		</div>
		<?php
		
		
		if ($num_items>0) {
		?>
			<table cellpadding="0" cellspacing="0" border="0" class="table_list">
			<tr>
				<td width="5"><img src="images/green_title_left.gif" width="5" height="28" alt="" /></td>
				<td width="222" class="green_title"><?php echo $label['title']; ?></td>
				<td width="287" class="green_title"><?php echo $label['filename']; ?></td>
				<td class="green_title"></td>
				<td width="5"><img src="images/green_title_right.gif" width="5" height="28" alt="" /></td>
			</tr>
			<?php
			$conta = 1;
			
			while (!$rs->EOF) {
				$class = ($conta%2==0) ? "odd_row" : "even_row";
				echo '<tr class="'.$class.'">';
				echo '<td></td>';
				echo '<td>'.$rs->fields['title'].'</td>';
				
				//$filename_href = $APP['private_products_files'].$rs->fields['filename'];
				$filename_href = $APP['base_url'].'readfile.php?filetype=product_file&id='.$rs->fields['id_product_file'];
				$filename_a = '<a href="'.$filename_href.'" target="_blank" title="'.$label['preview'].'">'.$rs->fields['filename'].'</a>';
				echo '<td>'.$filename_a.'</td>';
				//Configuracion del toolbar de opciones-->
				$str_toolbar_separator = '<img src="images/spacer.gif" width="5" height="1" alt="" />';
				$arr_toolbar = array();
				
				$arr_toolbar['edit_product_file'] = '<a href="main.php?page='.$page_request.'&section='.$section_request.'&subsection=filemanager_edit&action=edit&id_product='.$product->_data['id_product'].'&id_product_file='.$rs->fields['id_product_file'].'&pagination='.$num_page.'" title="'.$label['edit_file'].'"><img src="images/icon_edit.gif" width="17" height="19" alt="'.$label['edit_file'].'" /></a>';
				$arr_toolbar['delete'] = '<a href="javascript:confirm_delete(\''.addslashes($rs->fields['title']).'\', '.$rs->fields['id_product_file'].')" title="'.$label['delete_category'].'"><img src="images/icon_delete.gif" width="14" height="19" alt="'.$label['delete_file'].'" /></a>';
				$str_toolbar = '<div>'.implode($str_toolbar_separator, $arr_toolbar).'</div>';
				//<--Configuracion del toolbar de opciones
				echo '<td>'.$str_toolbar.'</td>';
				echo '<td></td>';
				echo '</tr>';
				$rs->MoveNext();
				$conta++;
			}
			?>
			</table>
		<?php
		} else {
			echo '<div style="width:800px;"><strong>'.$label['no_registers'].'</strong></div>';
		}
		?>
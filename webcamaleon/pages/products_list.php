<?php
if (!defined("FROM_MAIN")) die("");

require_once $APP['base_admin_path']."pages/class/product.php";
require_once $APP['base_admin_path']."pages/class/page.php";
require_once $APP['base_admin_path']."pages/class/product_category.php";
$var_visible=1;
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(isset($_GET['content_language'])){

	$_SESSION['language']=$_GET['content_language'];
}else{
	$_SESSION['language']="es";
}
if ($subsection_request=='products_list') {
	if ($_SERVER['REQUEST_METHOD']=='POST') {
		$id_product_category = $_POST['id_product_category'];		
	}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*function format_number($nro) {
list($entero,$decimal)=explode(".",$nro);
$entero=number_format($entero, 0, '', ',');
$nro=$entero.".".$decimal;
return($nro);
}*/
$search_string = "";
$search_by = "";
$page_size = $APP['skinscategories_num_page'];
$num_page = 1;

if (isset($_REQUEST['pagination'])) {
	$num_page = intval($_REQUEST['pagination']);
	$num_page = $num_page<0 ? 1 : $num_page;
}

if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['search_action'])) {
	if ($_POST['search_action']=='Buscar') {
		$_SESSION[$section_request.'_search_string'] = $search_string = $_POST['search_string'];
		$_SESSION[$section_request.'_search_by'] = $search_by = $_POST['search_by'];
	} else {
		$_SESSION[$section_request.'_search_string'] = $search_string = "";
		$_SESSION[$section_request.'_search_by'] = $search_by = "";
	}
} else {
	$search_string = isset($_SESSION[$section_request.'_search_string']) ? $_SESSION[$section_request.'_search_string'] : '';
	$search_by = isset($_SESSION[$section_request.'_search_by']) ? $_SESSION[$section_request.'_search_by'] : '';
}

$arr_data = Product::pagination($num_page, $page_size, $search_string, $search_by, $id_product_category);
$search_list = true;

$num_items = empty($arr_data['rows']) ? 0 : 1;
$rs = $arr_data['rows'];
		$parent = initRequestVar('id_parent', 'int', 0);
		$parent = Page::exists($parent) ? $parent : 0;
		$name = 'language" onchange="window.location.href=\'main.php?page=catalogo&content_language=\' + this.value;"';		
		//print_r($_GET['content_language']);
		if(isset($_GET['content_language'])){

			$lang=$_GET['content_language'];
		}else{
			$lang="es";
		}

		if(count($APP['content_languages'])>1)
		{
			$_SESSION['language']=$lang;
			//$_SESSION['language']=$_GET['content_language'];		
		?>
			<div>Mostrar listado de p&aacute;ginas en el idioma: <?php echo printLanguageCombo($name, $lang); ?> </div>
		<?php
		}
		?>
		<div>
		<!--Formulario de búsqueda y paginación-->
		<script language="javascript" type="text/javascript">
		<?php
		$alert_msg = rawurlencode(html_entity_decode($label['confirm_delete_category']));
		?>
		function confirm_delete(pageTitle, id) {
			resp = confirm(unescape("%BF<?php echo $alert_msg; ?>" + " " + pageTitle + "?"));
			if (resp) {
				window.location.href = "main.php?page=<?php echo $page_request; ?>&section=<?php echo $section_request; ?>&subsection=products_delete&id_product=" + id;
			}
		}
		</script>
		<form id="formu"  method="post" action="<?php // echo($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);?>" >
		<div>
		<fieldset style="width: 585x; padding-left: 5px; padding-bottom: 5px;">
		<legend>Busqueda</legend>
			<table cellpadding="2" cellspacing="0" border="0">
			<tr>
				
				<td>Buscar Producto : </td>
				<td><input type="text" name="search_string" value="<?php echo htmlentities($search_string); ?>" class="form_field" /></td>
				<td>por</td>
				<td>
					<?php
					$arr_fields = array(
						'title' => $label['title'],
						'description' => $label['description']
					);
					echo '<select name="search_by">';
					foreach ($arr_fields as $index=>$value) {
						$selected = ($index==$search_by) ? ' selected="selected" ' : '';
						echo '<option value="'.$index.'" '.$selected.'>'.$value.'</option>';
					}
					echo '</select>';
					?>
				</td>
				<td ><input type="submit" name="search_action" value="Buscar" class="form_submit" /></td>
				<td><input type="submit" name="search_action" value="Mostrar todos" class="form_submit" /></td>
			
			<?php
			if ($subsection_request=='products_list') {
				if ($_SERVER['REQUEST_METHOD']=='POST') {
					$id_product_category = $_POST['id_product_category'];
					if ($id_product_category!='all' && !Product_category::exists($id_product_category)) {
						$id_product_category = isset($_SESSION[$section_request.'_id_product_category']) ? $_SESSION[$section_request.'_id_product_category'] : '';
					} else {
						$_SESSION[$section_request.'_id_product_category'] = $id_product_category = $_POST['id_product_category'];
					}
				} else {
					$id_product_category = isset($_SESSION[$section_request.'_id_product_category']) ? $_SESSION[$section_request.'_id_product_category'] : 'all';
				}
				/*if (!empty($id_product_category) && $id_product_category!='all') {					
					$href = $_SERVER['PHP_SELF']."?page=$page_request&section=$section_request&subsection=products_edit&action=insert&id_product_category=$id_product_category";
					echo '<td width="100%" height="100%" style="height:5px;">';
					echo '<a style="height:15px;" href="'.$href.'" class="form_submit">Agregar Producto</a>';
					echo '</td>';
				}else{
					$var=product_category::listProduct_category();
					if (!empty($var)){
						$id_product_cat=$var[0]['id_product_category'];
						$id_product_category="all";
						$href = $_SERVER['PHP_SELF']."?page=$page_request&section=$section_request&subsection=products_edit&action=insert&id_product_category=$id_product_category&id_product_cat=$id_product_cat";
						echo '<td width="100%" height="100%" style="height:5px;">';
						echo '<a style="height:15px;" href="'.$href.'" class="form_submit">Agregar Producto</a>';
						echo '</td>';
					}					
				}*/
			} else if ($subsection_request=='filemanager') {
				$id_product = isset($_REQUEST['id_product']) ? $_REQUEST['id_product'] : 0;
				
				$href = $_SERVER['PHP_SELF']."?page=$page_request&section=$section_request";
				echo '<td  width="100%" height="100%"  style="height:5px;" >';
				echo '<a  style="height:15px;" href="'.$href.'" class="form_submit">Volver a la lista de productos</a>&nbsp;';
				echo '</td>';
				
				$href = $_SERVER['PHP_SELF']."?page=$page_request&section=$section_request&subsection=filemanager_edit&action=insert&id_product=$id_product";
				echo '<td  width="100%" height="100%" style="height:5px;" >';
				echo '<a style="height:15px;" href="'.$href.'" class="form_submit">Agregar archivo</a>';
				echo '</td>';
			}
			?>	
				
				
				<?php
				if ($arr_data['num_pages']>1) {
					echo '<td width="235" align="right">';
					echo '<table cellpadding="0" cellspacing="0" border="0"><tr>';
					echo '<td>Paginaci&oacute;n :</td>';
					
					echo '<td>&nbsp;';
					if ($arr_data['page']>1) {
						echo '<a href="main.php?page='.$page_request.'&pagination='.($arr_data['page']-1).'"><img src="images/left_arrow.gif" alt="" width="9" height="20" /></a>';
					} else {
						echo '<img src="images/spacer.gif" alt="" width="9" height="20" />';
					}
					echo '&nbsp;</td>';
					
					echo '<td><select onchange="window.location.href=\'main.php?page='.$page_request.'&pagination=\' + this.value">';
					for ($i=1; $i<=$arr_data['num_pages']; $i++) {
						$selected = ($i==$arr_data['page']) ? ' selected="selected" ' : '';
						echo '<option value="'.$i.'" '.$selected.'>'.($i).'</option>';
					}
					echo '</select></td>';
					
					echo '<td>&nbsp;';
					if ($arr_data['page']<$arr_data['num_pages']) {
						echo '<a href="main.php?page='.$page_request.'&pagination='.($arr_data['page']+1).'"><img src="images/right_arrow.gif" alt="" width="9" height="20" /></a>';
					} else {
						echo '<img src="images/spacer.gif" alt="" width="9" height="20" />';
					}
					echo '</td>';
					
					echo '</tr></table>';
					echo '</td>';
				}
				?>
			</tr>
			</table>
			</fieldset>
		</div>
		<div>
			<fieldset style="width: 587px; padding-left: 5px; padding-bottom: 5px;">
			<legend>Mostrar</legend>
			<table cellpadding="2" cellspacing="0" border="0">
			<tr>
				<td>Mostrar productos de la categor&iacute;a</td>
				<td>
					<select name="id_product_category" onchange="this.form.submit()">
					<option value="all">Todas</option>
						<?php
						if (!isset($_REQUEST['id_product_category'])) {
							$_REQUEST['id_product_category'] = '';
						}
						
						$category_arr = Product_category::listNestedCategories(0);
						$str_combo = Product_category::printRecursiveCategory ($category_arr, 0, $id_product_category);
						echo $str_combo;
						?>
					</select>
				</td>
			</tr>			
			</table>
			</fieldset>
		</div>
		</form>
		<!--Formulario de búsqueda y paginación END-->
		</div>
		<?php
		if ($num_items>0) {
		?>
			<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="5"><img src="images/green_title_left.gif" width="5" height="28" alt="" /></td>
				<td width="270" class="green_title"><?php echo $label['title']; ?></td>
				<td width="270" class="green_title">Precio unitario</td>
				<td class="green_title"></td>
				<td width="5"><img src="images/green_title_right.gif" width="5" height="28" alt="" /></td>
			</tr>
			<?php
			$conta = 1;
			while (!$rs->EOF) {
				$class = ($conta%2==0) ? "odd_row" : "even_row";				
				/*$costo = format_number($rs->fields['unitary_price']);*/
				echo '<tr class="'.$class.'">';
				echo '<td></td>';
				echo '<td>'.$rs->fields['title'].'</td>';
				echo '<td></td>';				
				//Configuracion del toolbar de opciones-->
				if (in_array($_SESSION['idTypeUserAcct'], array(3,5)) || $rs->fields['id_user_acct']==$_SESSION['idUser']) {
					$str_toolbar_separator = '<img src="images/spacer.gif" width="5" height="1" alt="" />';
					$arr_toolbar = array();
					$arr_toolbar['edit_product'] = '<a href="main.php?page='.$page_request.'&section='.$section_request.'&subsection=products_edit&action=edit&id_product='.$rs->fields['id_product'].'&pagination='.$num_page.'" title="'.$label['edit_product'].'"><img src="images/icon_edit.gif" width="17" height="19" alt="'.$label['edit_product'].'" /></a>';
					$arr_toolbar['attached_files'] = '<a href="main.php?page='.$page_request.'&section='.$section_request.'&subsection=filemanager&id_product='.$rs->fields['id_product'].'" title="'.$label['manage_files'].'"><img src="images/icon_attach.gif" width="14" height="19" alt="'.$label['manage_files'].'" /></a>';
					$arr_toolbar['delete'] = '<a href="javascript:confirm_delete(\''.addslashes($rs->fields['title']).'\', '.$rs->fields['id_product'].')" title="'.$label['delete_product'].'"><img src="images/icon_delete.gif" width="14" height="19" alt="'.$label['delete_product'].'" /></a>';
					$str_toolbar = '<div>'.implode($str_toolbar_separator, $arr_toolbar).'</div>';
				} else {
					$str_toolbar = '';
				}
				//<--Configuracion del toolbar de opciones
				echo '<td nowrap="nowrap">'.$str_toolbar.'</td>';
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
		$var_visible=1;
		?>
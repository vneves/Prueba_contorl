<?php
if (!defined("FROM_MAIN")) die("");
require_once $APP['base_admin_path']."pages/class/product_category.php";
require_once $APP['base_admin_path']."pages/class/page.php";



if(isset($_GET['content_language'])){

	$_SESSION['language']=$_GET['content_language'];
}else{
	$_SESSION['language']="es";
}
$search_string = "";
$search_by = "";
$page_size = $APP['skinscategories_num_page'];
$num_page = 1;

if (isset($_REQUEST['pagination'])) {
	$num_page = intval($_REQUEST['pagination']);
	$num_page = $num_page<0 ? 1 : $num_page;
}

if ($_SERVER['REQUEST_METHOD']=='POST') {
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

if ($search_string!='' && $search_by!='') {
	$arr_data = Product_category::pagination($num_page, $page_size, $search_string, $search_by);
	$search_list = true;
} else {
	$arr_data = Product_category::listCategories($id_parent, $num_page, $page_size);
}
$num_items = empty($arr_data['rows']) ? 0 : 1;
$rs = $arr_data['rows'];		
		
		$parent = initRequestVar('id_parent', 'int', 0);
		$parent = Page::exists($parent) ? $parent : 0;
		$name = 'language" onchange="window.location.href=\'main.php?page=catalogo&section=productscategories&content_language=\' + this.value;"';		
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
		<?php
		if (!isset($search_list)) {
			Product_category::printPagePath($id_parent);
		}
		?>
		<script language="javascript" type="text/javascript">
		<?php
		$alert_msg = rawurlencode(html_entity_decode($label['confirm_delete_category']));
		?>
		function confirm_delete(pageTitle, id) {
			resp = confirm(unescape("%BF<?php echo $alert_msg; ?>" + " " + pageTitle + "?"));
			if (resp) {
				window.location.href = "main.php?page=<?php echo $page_request; ?>&section=<?php echo $section_request; ?>&subsection=productscategories_delete&id_product_category=" + id;
			}
		}
		</script>
		<!--Formulario de búsqueda y paginación-->
		<form method="post">
		<table cellpadding="2" cellspacing="0" border="0">
		<tr>
			<td>Buscar categor&iacute;a : </td>
			<td><input type="text" name="search_string" value="<?php echo htmlentities($search_string); ?>" class="form_field" /></td>
			<td>por</td>
			<td>
				<?php
				$arr_fields = array(
					'title' => 'T&iacute;tulo',
					'description' => 'Descripci&oacute;n'
				);
				echo '<select name="search_by">';
				foreach ($arr_fields as $index=>$value) {
					$selected = ($index==$search_by) ? ' selected="selected" ' : '';
					echo '<option value="'.$index.'" '.$selected.'>'.$value.'</option>';
				}
				echo '</select>';
				?>
			</td>
			<td><input type="submit" name="search_action" value="Buscar" class="form_submit" /></td>
			<td><input type="submit" name="search_action" value="Mostrar todos" class="form_submit" /></td>
		</tr>
			<?php
			//paginacion-->
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
			//<--paginacion
			?>
		</table>
		</form>
		<!--Formulario de búsqueda y paginación END-->
		</div>
		<?php
		if ($num_items>0) {
		?>
			<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="5"><img src="images/green_title_left.gif" width="5" height="28" alt="" /></td>
				<td width="222" class="green_title"><?php echo $label['title']; ?></td>
				<td width="300" class="green_title"><?php echo $label['description']; ?></td>
				<td class="green_title"></td>
				<td width="5"><img src="images/green_title_right.gif" width="5" height="28" alt="" /></td>
			</tr>
			<?php
			$conta = 1;
			if (!isset($_REQUEST['id_parent'])) {
				$arr_path = array();
			} else {
				$arr_path = Product_category::getPath($_REQUEST['id_parent']);
			}
			
			while (!$rs->EOF) {
				$class = ($conta%2==0) ? "odd_row" : "even_row";
				echo '<tr class="'.$class.'">';
				echo '<td></td>';
				echo '<td>'.$rs->fields['title'].'</td>';
				echo '<td>'.$rs->fields['description'].'</td>';
				//Configuracion del toolbar de opciones-->
				if (in_array($_SESSION['idTypeUserAcct'], array(3,5)) || $rs->fields['id_user_acct']==$_SESSION['idUser']) {
					$str_toolbar_separator = '<img src="images/spacer.gif" width="5" height="1" alt="" />';
					$arr_toolbar = array();
					
					if (!isset($search_list)) {
						if(count($arr_path)<3) {//maximo nivel de anidacion de categorias de products
							//$arr_toolbar['open_category'] = '<a href="main.php?page='.$page_request.'&section='.$section_request.'&id_parent='.$rs->fields['id_product_category'].'" title="'.$label['open'].'"><img src="images/icon_open.gif" width="21" height="19" alt="'.$label['open'].'" /></a>';
						}
					}
					
					$arr_toolbar['edit_category'] = '<a href="main.php?page='.$page_request.'&section='.$section_request.'&subsection=productscategories_edit&action=edit&id_product_category='.$rs->fields['id_product_category'].'&pagination='.$num_page.'" title="'.$label['edit_category'].'"><img src="images/icon_edit.gif" width="17" height="19" alt="'.$label['edit_category'].'" /></a>';
					$arr_toolbar['delete'] = '<a href="javascript:confirm_delete(\''.addslashes($rs->fields['title']).'\', '.$rs->fields['id_product_category'].')" title="'.$label['delete_category'].'"><img src="images/icon_delete.gif" width="14" height="19" alt="'.$label['delete_category'].'" /></a>';
					$str_toolbar = '<div>'.implode($str_toolbar_separator, $arr_toolbar).'</div>';
				} else {
					$str_toolbar = '';
				}
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
<?php
	if (!defined("FROM_MAIN")) die("");
		require_once $APP['base_admin_path'].'include/sections.php';
		require_once $APP['base_admin_path'].'pages/class/page.php';

//Validacion de idioma del contenido-->
if (sizeof($APP['content_languages'])>1) {
	$lang = !empty($_REQUEST['content_language']) ? $_REQUEST['content_language'] : '';
	$lang = array_key_exists($lang, $APP['content_languages']) ? $lang : $APP['default_content_language'];
	} else {
		$lang = key($APP['content_languages']);
	}
//<--Validacion de idioma del contenido

//Validacion del id_parent-->
$parent = initRequestVar('id_parent', 'int', 0);
$parent = Page::exists($parent) ? $parent : 0;
//<--Validacion del id_parent

if (!isset($_REQUEST['pagination'])) {
	$_REQUEST['pagination'] = 1;
}

$list_pages = Page::listPages($parent, $lang, $_REQUEST['pagination']);
$rows = array();

if (!empty($list_pages)) {
	$num_pages = $list_pages['num_pages'];
	$current_page = $list_pages['current_page'];
	$rows = $list_pages['rows'];
} else {
	$num_pages = 1;
	$current_page = 1;
}
//$rows = Page::listPages($parent, $lang, $_REQUEST['pagination']);
?>
<div class="div_content">
	<div class="space_up"></div>
	<div><img src="images/spacer.gif" width="" height="14" alt="" /></div>
	<div style="float:left; width:10px;"><img src="images/spacer.gif" width="10" height="1" alt="" /></div>
	<div style="float:left; padding-left:12px;" id="div_form">
		<div style="width:916px;">
			<table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tr>
				<td class="page_title" nowrap="nowrap" style="padding-top:13px; padding-bottom:13px; border-bottom:1px solid #AFCD5B;"><?php echo $label['manage_pages']; ?></td>
				<?php
					$href = $_SERVER['PHP_SELF']."?page=sections&section=edit&id_parent=$parent&action=insert&content_language=$lang&pagination=$current_page";
				?>
				<?php
				if ($_SESSION['idUser']!=1 && $parent==0) {
				} else {
				?>
				<td align="right" valign="bottom" width="100%"><a href="<?php echo $href; ?>" class="form_submit"><?php echo $label['add_page']; ?></a></td>
				<?php
				}
				?>
			</tr>
			</table>
		</div>
		<div><img src="images/spacer.gif" width="1" height="17" alt="" /></div>
		<?php
		//hack language combo-->
		$name = 'language" onchange="window.location.href=\'main.php?page=sections&id_parent='.$parent.'&content_language=\' + this.value;"';
		//<--hack language combo
		if(count($APP['content_languages'])>1)
		{
		//print_r($lang);
		$_SESSION['language']=$lang;
		?>
			<div>Mostrar listado de p&aacute;ginas en el idioma: <?php echo printLanguageCombo($name, $lang); ?> </div>
		<?php
		}
		?>

		<div><img src="images/spacer.gif" width="1" height="5" alt="" /></div>
		<?php
		printPagePath($parent, $lang);
		//pagination-->
		if ($num_pages>1) {
			echo '<script type="text/javascript" language="javascript">';
			echo 'function goto(pagination) {';
				echo 'window.location.href="main.php?page=sections&id_parent='.$parent.'&content_language='.$lang.'&pagination=" + pagination;';
			echo '}';
			echo '</script>';
			
			$str_combo = '<select onchange="goto(this.value)">';
			for ($i=1; $i<=$num_pages; $i++) {
				$selected = ($i==$current_page) ? ' selected="selected" ' : '';
				$str_combo .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
			}
			$str_combo .= '</select>';
			
			echo '<div id="div_pagination">';
				echo '<table cellpadding="0" cellspacing="1" border="0">';
				echo '<tr>';
					echo '<td>'.$label['pagination'].'&nbsp;</td>';
					if ($current_page>1) {
						echo '<td><a href="#" onclick="goto('.($current_page-1).')"><img src="images/left_arrow.gif" width="9" height="20" alt="" /></a></td>';
					} else {
						echo '<td><img src="images/spacer.gif" width="9" height="20" alt="" /></td>';
					}
					echo '<td>'.$str_combo.'</td>';
					if ($current_page<$num_pages) {
						echo '<td><a href="#" onclick="goto('.($current_page+1).')"><img src="images/right_arrow.gif" width="9" height="20" alt="" /></a></td>';
					} else {
						echo '<td><img src="images/spacer.gif" width="9" height="20" alt="" /></td>';
					}
				echo '</tr>';
				echo '</table>';
				

			echo '</div>';
		}
		//<--pagination
		?>
		<?php
		if (sizeof($rows)>0) {
		?>
		<script language="javascript" type="text/javascript">
		<?php
		$alert_msg = rawurlencode(html_entity_decode($label['confirm_delete_page']));
		?>
		function confirm_delete(pageTitle,id_page) {
			resp = confirm(unescape("%BF<?php echo $alert_msg; ?>" + " " + pageTitle + "?"));
			if (resp) {
				window.location.href = "main.php?page=sections&section=delete&id_page=" + id_page;
			}
		}
		</script>
		<table cellpadding="0" cellspacing="0" border="0"  >
		<tr>
			<td width="5"><img src="images/green_title_left.gif" width="5" height="28" alt="" /></td>
			<td class="green_title" width="21">N&deg;</td>
			<td class="green_title" width="303"><?php echo $label['title']; ?></td>
			<td class="green_title" width="303"><?php echo $label['description']; ?></td>
			<td class="green_title" width="87"><?php echo $label['author']; ?></td>
			<td class="green_title" width="88"><?php echo $label['modification']; ?></td>
			<td class="green_title" width="104"></td>
			<td width="5"><img src="images/green_title_right.gif" width="5" height="28" alt="" /></td>
		</tr>
		<?php
			$conta = 1;
			foreach ($rows as $value) {
				$class = ($conta%2==0) ? "odd_row" : "even_row";
				$sql = 'SELECT `name`,`lastname` FROM user_acct WHERE id_user_acct='.$value['id_user_creator'];
				$row_author = $cn->GetRow($sql);
				$author = $row_author['lastname'].' '.$row_author['name'];
				
				$last_update_timestamp = strtotime($value['date_last_update']);
				$date_last_update = date('Y/m/d', $last_update_timestamp);
				echo '<tr class="'.$class.'">';
					echo '<td><img src="images/spacer.gif" width="1" height="28" alt="" /></td>';
					echo '<td>'.$conta.'</td>';
					echo '<td width="303">'.$value['title'].'</td>';
					//echo '<td>'.htmlentities($value['meta_description'], ENT_QUOTES, 'utf-8').'&nbsp;</td>';
					echo '<td width="303">'.$value['meta_description'].'&nbsp;</td>';
					echo '<td width="87">'.$author.'</td>';
					echo '<td width="88">'.$date_last_update.'</td>';
					//Configuracion del toolbar de opciones-->
					$str_toolbar_separator = '<img src="images/spacer.gif" width="5" height="1" alt="" />';
					
					$arr_options = explode(":", $value['options']);
					
					$arr_toolbar = array();
					if (in_array('add_page', $arr_options)) {
						$arr_toolbar['open_page'] = '<a href="main.php?page=sections&id_parent='.$value['id_page'].'&content_language='.$lang.'" title="'.$label['open'].'"><img src="images/icon_open.gif" width="21" height="19" alt="'.$label['open'].'" /></a>';
					} else {
						$arr_toolbar['open_page'] = '<img src="images/spacer.gif" width="21" height="19" alt="" />';
					}
					
					$arr_toolbar['edit_page'] = '<a href="main.php?page=sections&section=edit&action=edit&id_content='.$value['id_content'].'&pagination='.$current_page.'" title="'.$label['edit_page'].'"><img src="images/icon_edit.gif" width="17" height="19" alt="'.$label['edit_page'].'" /></a>';
					$arr_toolbar['attached_files'] = '<a href="main.php?page=sections&section=filemanager&id_content='.$value['id_content'].'" title="'.$label['manage_files'].'"><img src="images/icon_attach.gif" width="14" height="19" alt="'.$label['manage_files'].'" /></a>';
					if ($value['is_published']==1) {
						$arr_toolbar['page_published'] = '<a href="main.php?page=sections&section=publish&id_page='.$value['id_page'].'&is_published=0" title="'.$label['page_published'].'"><img src="images/icon_published.gif" width="16" height="19" alt="'.$label['page_published'].'" /></a>';
					} else {
						$arr_toolbar['page_unpublished'] = '<a href="main.php?page=sections&section=publish&id_page='.$value['id_page'].'&is_published=1" title="'.$label['page_unpublished'].'"><img src="images/icon_unpublished.gif" width="16" height="19" alt="'.$label['page_unpublished'].'" /></a>';
					}
					$arr_toolbar['page_delete'] = '<a href="javascript:confirm_delete(\''.rawurlencode($value['title']).'\', '.$value['id_page'].')" title="'.$label['delete_page'].'"><img src="images/icon_delete.gif" width="14" height="19" alt="'.$label['delete_page'].'" /></a>';
					$str_toolbar = '<div>'.implode($str_toolbar_separator, $arr_toolbar).'</div>';
					//<--Configuracion del toolbar de opciones
					echo '<td>'.$str_toolbar.'</td>';
					echo '<td></td>';
				echo '</tr>';
				$conta++;
			}
			echo '</table><div style="height:10px"></div>';
		} else {
		?>
			<div style="width:800px;"><strong><?php echo $label['no_registers']; ?></strong></div>
		<?php
		}
		?>
	</div>
	<div class="space_down"></div>
</div>
<?php
if (!defined("FROM_MAIN")) die("");
require_once $APP['base_admin_path'].'include/sections.php';
require_once $APP['base_admin_path'].'pages/class/page.php';
require_once $APP['base_admin_path'].'pages/class/file.php';
require_once $APP['base_admin_path'].'pages/class/content.php';

//Validacion de idioma del contenido-->
if (sizeof($APP['content_languages'])>1) {
	$lang = !empty($_REQUEST['content_language']) ? $_REQUEST['content_language'] : '';
	$lang = array_key_exists($lang, $APP['content_languages']) ? $lang : $APP['default_content_language'];
} else {
	$lang = key($APP['content_languages']);
}
//<--Validacion de idioma del contenido

//Validacion de id_content-->
if (!isset($_REQUEST['id_content']) || !Content::exists($_REQUEST['id_content'])) {
	echo '<script language="javascript" type="text/javascript">window.location.href="main.php?page=sections";</script>';
	return;
}
//<--Validacion de id_content
$content = new Content($_REQUEST['id_content']);
$page = new Page($content->_data['id_page']);


$arr_path = Page::getPath($page->_data['id_page'], $content->_data['lang']);

if (isset($_REQUEST['action'])) {
	switch ($_REQUEST['action']) {
		case "insert":
			$file = new File('');
			if (!isset($_REQUEST['type']) || !array_key_exists($_REQUEST['type'], $APP['file_type'])) {
				break;
			}
			require_once dirname(__FILE__)."/sections_filemanager_edit.php";
			return;
			break;
		case "edit":
			if (!isset($_REQUEST['id_file']) || !File::exists($_REQUEST['id_file'])) {
				break;
			}
			$file = new File($_REQUEST['id_file']);
			$_REQUEST['type'] = $file->_data['type'];
			require_once dirname(__FILE__)."/sections_filemanager_edit.php";
			return;
			break;
		case "delete":
			if (!isset($_REQUEST['id_file']) || !File::exists($_REQUEST['id_file'])) {
				break;
			}
			$file = new File($_REQUEST['id_file']);
			File::delete($_REQUEST['id_file']);
			$url_bak = $_SERVER['PHP_SELF']."?page=sections&section=filemanager&id_content=".$file->_data['id_content']."&type=".$file->_data['type'];
			echo '<script language="javascript" type="text/javascript">window.location.href="'.$url_bak.'"</script>';
			return;
			break;
	}
}

//Validacion de type-->
if (!isset($_REQUEST['type'])) {
	$_REQUEST['type'] = 'attach';
} else {
	if (!array_key_exists($_REQUEST['type'], $APP['file_type'])) {
		$_REQUEST['type'] = 'attach';
	}
}
//<--Validacion de type

$rows = File::listFiles($_REQUEST['id_content'], $_REQUEST['type']);

?>
<div class="div_content">
	<div class="space_up"></div>
	<div><img src="images/spacer.gif" width="" height="14" alt="" /></div>
	<div style="float:left; width:10px;"><img src="images/spacer.gif" width="10" height="1" alt="" /></div>
	<div style="float:left; padding-left:12px" id="div_form">
		<div style="width:741px;">
			<table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tr>
				<td class="page_title" nowrap="nowrap" style="padding-top:13px; padding-bottom:13px; border-bottom:1px solid #AFCD5B;"><?php echo $label['manage_files']; ?></td>
				<?php
					$href_add = $_SERVER['PHP_SELF']."?page=sections&section=filemanager&id_content=$_REQUEST[id_content]&action=insert&type=$_REQUEST[type]";
					$href_back = $_SERVER['PHP_SELF']."?page=sections&id_parent=".$page->_data['id_parent'].'&content_language='.$content->_data['lang'];
				?>
				<td align="right" valign="bottom" width="100%">
					<a href="<?php echo $href_back; ?>" class="form_submit"><?php echo $label['back_to_page_list']; ?></a>
					<a href="<?php echo $href_add; ?>" class="form_submit"><?php echo $label['add_file']; ?></a>
				</td>
			</tr>
			</table>
		</div>
		<div><img src="images/spacer.gif" width="1" height="17" alt="" border="0" /></div>
		<?php
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
		printPagePath($page->_data['id_parent'], $lang);
		?>
		<div id="div_file_types"><?php echo $label['page']." ".$content->_data['title']; ?><br />[ <?php echo implode(" - ", $arr_links);?> ]</div>
		<?php
		if (sizeof($rows)>0) {
		?>
		<script language="javascript" type="text/javascript">
		<?php
		$alert_msg = rawurlencode(html_entity_decode($label['confirm_delete_file']));
		?>
		function confirm_delete(filename,id_file) {
			resp = confirm(unescape("%BF<?php echo $alert_msg; ?>" + " " + filename + "?"));
			if (resp) {
				window.location.href = "main.php?page=sections&section=filemanager&action=delete&id_content=<?php echo $_REQUEST['id_content']; ?>&id_file=" + id_file;
			}
		}
		</script>
		<table cellpadding="0" cellspacing="0" border="0" id="form_file">
		<tr>
			<td><img src="images/green_title_left.gif" width="5" height="28" alt="" /></td>
			<td class="green_title" width="21">N&deg;</td>
			<td class="green_title" width="150"><?php echo $label['file']; ?></td>
			<td class="green_title" width="250"><?php echo $label['title']; ?></td>
			<td class="green_title" width="250"><?php echo $label['description']; ?></td>
			<td class="green_title" width="100">Tag</td>
			<td class="green_title" width="60"></td>
			<td><img src="images/green_title_right.gif" width="5" height="28" alt="" /></td>
		</tr>
		<?php
			$conta = 1;
			foreach ($rows as $value) {
				$class = ($conta%2==0) ? "odd_row" : "even_row";
				
				echo '<tr class="'.$class.'">';
					echo '<td></td>';
					echo '<td>'.$conta.'</td>';
					echo '<td>'.$value['filename'].'</td>';
					echo '<td>'.$value['title'].'</td>';
					echo '<td>'.$value['description'].'&nbsp;</td>';
					echo '<td>'.$value['tag'].'&nbsp;</td>';
					//Configuracion del toolbar de opciones-->
					$str_toolbar_separator = '<img src="images/spacer.gif" width="5" height="1" alt="" />';
					
					$arr_toolbar = array();
					$arr_toolbar['edit_file'] = '<a href="main.php?page=sections&section=filemanager&action=edit&id_content='.$value['id_content'].'&id_file='.$value['id_file'].'" title="'.$label['edit_file'].'"><img src="images/icon_edit.gif" width="17" height="19" alt="'.$label['edit_file'].'" /></a>';
					if ($value['is_private']==0) {
						$file_url = $APP['files_resources_url'].$page->_data['id_page'].'/'.$value['filename'];
						$file_path = $APP['files_resources'].$page->_data['id_page'].'/'.$value['filename'];
					} else {
						$file_url = $APP['base_url'].'readfile.php?filetype=file&id='.$value['id_file'];
						$file_path = $APP['private_files_resources'].$value['id_page'].'/'.$value['filename'];
					}
					
					if (file_exists($file_path)) {
						$arr_toolbar['preview_file'] = '<a href="'.$file_url.'" title="'.$label['preview'].'" target="_blank"><img src="images/icon_preview.gif" width="17" height="19" alt="'.$label['preview'].'" /></a>';
					} else {
						$arr_toolbar['preview_file'] = '<img src="images/spacer.gif" width="17" height="19" alt="" />';
					}
					$arr_toolbar['file_delete'] = '<a href="javascript:confirm_delete(\''.rawurlencode($value['filename']).'\', '.$value['id_file'].')" title="'.$label['delete_file'].'"><img src="images/icon_delete.gif" width="14" height="19" alt="'.$label['delete_file'].'" /></a>';
					$str_toolbar = '<div>'.implode($str_toolbar_separator, $arr_toolbar).'</div>';
					//<--Configuracion del toolbar de opciones
					echo '<td>'.$str_toolbar.'</td>';
					echo '<td></td>';
				echo '</tr>';
				$conta++;
			}
			echo '</table>';
		} else {
		?>
			<div style="width:800px;"><strong><?php echo $label['no_registers']; ?></strong></div>
		<?php
		}
		?>
	</div>
	<div class="space_down"></div>
</div>
<?php
if (!defined("FROM_MAIN")) die("");
require_once './include/sections.php';
require_once($APP['base_admin_path'].'/pages/class/page.php');
require_once($APP['base_admin_path'].'/pages/class/page.php');
require_once($APP['base_admin_path'].'/pages/class/content.php');
require_once($APP['base_path'].'/config/category_ids.php');
require_once($APP['base_path'].'/config/category_arrays.php');
require_once('smith_class/form_generator_camaleon.php');

switch ($_REQUEST['action']) {
	case 'insert':
		//Validacion de content_language-->
		if (count($APP['content_languages'])>1) {
			$request_content_language = initRequestVar('content_language', 'str', '');
			if (!array_key_exists($request_content_language, $APP['content_languages'])) {
				$href = $_SERVER['PHP_SELF']."?page=sections";
				echo '<script type="text/javascript">window.location.href="'.$href.'";</script>';
				return;
			}
		} else {
			$request_content_language = key($APP['content_languages']);
		}
		//<--Validacion de content_language
		$page = new Page('');
		$page->_data['date_creation'] = date('Y-m-d H:i:s');
		$page->_data['id_user_creator'] = $_SESSION['idUser'];
		$page->_data['id_page'] = '';
		$page->_data['extra'] = '';
		$page->_data['options'] = '';		
		$content = new Content('');
		$content->_data['lang'] = $request_content_language;
		$content->_data['id_content']='';
		$content->_data['id_page']='';
		$content->_data['title']='';
		$content->_data['meta_description']='';
		$content->_data['meta_keywords']='';
		$content->_data['maintext']='';
		$content->_data['introtext']='';
		//Validacion de id_parent-->
		if (intval($_REQUEST['id_parent'])!=0) 
		{
			if (!Page::exists($_REQUEST['id_parent'])) {
				echo '<script type="text/javascript">window.location="main.php?page=sections";</script>';
				return;
			}			
		}
		$arr_path = Page::getPath(intval($_REQUEST['id_parent']), $request_content_language);
		$page->_data["id_parent"] = intval($_REQUEST['id_parent']);
		//<--Validacion de id_parent
		$action_title = $label['add_page'];
		$action = 'insert';
		break;
	case 'edit':
		//Validacion de id_content-->
		if (!isset($_REQUEST['id_content']) || !Content::exists(array($_REQUEST['id_content'])) ) {
			echo '<script type="text/javascript">window.location="main.php?page=sections";</script>';
			return;
		}
		//<--Validacion de id_content
		$content = new Content($_REQUEST['id_content']);
		$request_content_language = $content->_data['lang'];
		$_REQUEST['id_page'] = $content->_data['id_page'];
		$arr_path = Page::getPath(intval($_REQUEST['id_page']), $content->_data['lang']);
		$page = new Page(intval($_REQUEST['id_page']));
		$old_page = new Page(intval($_REQUEST['id_page']));
		//$id_content = Content::getIdContent($_REQUEST['id_page'], $request_content_language);
		//$content = new Content($id_content);
		$action_title = $label['edit_page'];
		//featured_info-->
		$arr_extra = $page->extra();
		if (!isset($arr_extra['featured_info']) || $arr_extra['featured_info']==0) {
			$page->_data['featured_info'] = 0;
		} else {
			$page->_data['featured_info'] = 1;
		}
		//<--featured_info
		$action = 'edit';
		break;
	default:
		//$alert = html_entity_decode($label['unespecified_action']);
		/*echo '<script type="text/javascript">alert(unescape("'.rawurlencode($alert).'")); window.location="main.php?page=sections";</script>';*/
		echo '<script type="text/javascript">window.location="main.php?page=sections";</script>';
		return;
		break;
}
?>
<div class="div_content">
	<div class="space_up"></div>
	<div><img src="images/spacer.gif" width="1" height="14" alt="" /></div>
	<div style="float:left; width:10px;"><img src="images/spacer.gif" width="10" height="1" alt="" /></div>
	<div style="float:left; padding-left:12px" id="div_form">
		<div style="width:796px;">
			<table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tr>
				<td class="page_title" style="padding-top:13px; padding-bottom:13px; border-bottom:1px solid #AFCD5B;"><?php echo $label['manage_pages']; ?></td>
			</tr>
			</table>
		</div>
		<div><img src="images/spacer.gif" width="1" height="17" alt="" /></div>
		<?php
			printPagePath($page->_data['id_parent'], $lang);
		?>
		<!--TITULO-->
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td><img src="images/green_title_left.gif" width="5" height="28" alt="" /></td>
			<td width="786" class="green_title"><?php echo $action_title; ?></td>
			<td><img src="images/green_title_right.gif" width="5" height="28" alt="" /></td>
		</tr>
		</table>
		<!--TITULO END-->
		<!--FORMULARIO-->
		<div class="form_body" style="width:780px; padding:8px;">
		<?php
			$old_page = $page;
			require_once dirname(__FILE__)."/forms/page.php";
			$page = $old_page;
		?>
		</div>
		<!--FORMULARIO END-->
		<div><img src="images/spacer.gif" width="1" height="14" alt="" /></div>
	</div>
	<div class="space_down"></div>
</div>
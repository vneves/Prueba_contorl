
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

//print_r($arr_path);
//á
$actionForm = $_SERVER['REQUEST_URI'];

$page->_data['date_last_update'] = date('Y-m-d H:i:s');
$content->_data['date_last_update'] = date('Y-m-d H:i:s');
$content->_data['id_user_last_update'] = $_SESSION['idUser'];

//Validacion de is_published-->
if($_REQUEST['action']=='insert') {
	$page->_data['is_published'] = 1;
}
//<--Validacion de is_published

//Validacion de title-->
if ($_SERVER['REQUEST_METHOD']=='POST') {
	if (trim($_REQUEST['title'])==="") {
		$alert = html_entity_decode($label['title_required']);
		$_url['section'] = 'list';
		$validation_fail = true;
	}
	$content->_data['title'] = trim($_REQUEST['title']);
}
//<--Validacion de title
if ($_SERVER['REQUEST_METHOD']=='POST') {
	//options fields-->
	$options = array();
	if (isset($_REQUEST['add_page'])) {
		if ($_REQUEST['add_page']==1 || $_REQUEST['add_page']=='on') {
			$options[] = 'add_page';
		}
	}
	$page->_data['options'] = implode(':', $options);
	//<--options fields
	//contenido fields-->
	$contenido = array();
	if (isset($_REQUEST['contenido'])) {
		if ($_REQUEST['contenido']==1 || $_REQUEST['contenido']=='on') {
			$contenido[] = 'contenido';
		}
	}
	$page->_data['contenido'] = implode(':', $contenido);
	//<--contenido fields
	//links fields-->
	$links = array();
	if (isset($_REQUEST['links'])) {
		if ($_REQUEST['links']==1 || $_REQUEST['links']=='on') {
			$links[] = 'links';
		}
	}
	$page->_data['links'] = implode(':', $links);
	//<--links fields
	//Datos que se actualizan automaticamente--> no es necesario validarlos, se generan en script
	$arr_infoauto = array(
		'date_last_update',
		'id_user_last_update',
		'is_published',
		'date_creation',
		'id_user_creator',
		'order',
		'contenido',
		'links',
		'options'
	);
	//<--Datos que se actualizan automaticamente
	
	foreach ($page->_cols as $key=>$value) {
		if (in_array($key, $arr_infoauto)) {
			$page->_hasError[$key] = 0;
			continue;
		}
		$page->_data[$key] = $_REQUEST[$key];
		if (($page->_isRequired[$key]) == 1) {
			if (trim($page->_data[$key]) == '' && $key != $page->_keyField) {
				$page->_hasError[$key] = 1;
			} else {
				$page->_hasError[$key] = 0;
			}
		}
	}
	
	//$page->_data['featured_info'] = isset($_POST['featured_info']) ? 1 : 0;
	
	//Datos que se actualizan automaticamente--> no es necesario validarlos, se generan en script
	$arr_infauto = array (
		'id_page',
		'permalink'
	);
	//<--Datos que se actualizan automaticamente
	
	foreach ($content->_cols as $key=>$value) {
		if (in_array($key, $arr_infoauto)) {
			$content->_hasError[$key] = 0;
			continue;
		}
		@$content->_data[$key] = $_REQUEST[$key];
		if (($content->_isRequired[$key]) == 1) {
			if (trim($content->_data[$key]) == '' && $key != $content->_keyField) {
				$content->_hasError[$key] = 1;
			} else {
				$content->_hasError[$key] = 0;
			}
		}
	}
	
	if (!isset($validation_fail)) {
		if (!in_array(1, $page->_hasError) && !in_array(1, $content->_hasError)) {
				if ($_REQUEST['order']=='first' || $_REQUEST['order']=='last') {
				$page->_data['order'] = '0';
					}
			
			$page->debug = false;
			
			$savingData = $page->saveData();
			//die();
			if ($savingData === 1) {
			
			
//			echo "<br/>El order es:".$_REQUEST['order']."<br/>";
			//die();
			
				
				$page->updateOrder($_REQUEST['order']);
				if ($_REQUEST['action']=='insert') {
					$content->_data['id_page'] = $page->_data['id_page'];
				}
				$content->_data['permalink'] = random_string(20);
				while (Content::existsPermalink($content->_data['permalink'])) {
					$content->_data['permalink'] = random_string(20);
				}
				
				$content->debug = false;
				if ($_REQUEST['action']=='insert') {					
					saveEmptyContent ($content);
				} else {
					$savingData = $content->saveData();
					$content->_data['permalink'] = generate_permalink($content->_data['title'])."_".$content->_data['id_content'].".html";
					$sql = "UPDATE `content` SET `permalink`='".$content->_data['permalink']."' WHERE id_content='".$content->_data['id_content']."'";
					$cn->Execute($sql);
				}
				
				$current_page = isset($_REQUEST['pagination']) ? $_REQUEST['pagination'] : 1;
				echo '<script type="text/javascript">window.location="main.php?page=sections&id_parent='.$page->_data['id_parent'].'&pagination='.$current_page.'&content_language='.$content->_data['lang'].'";</script>';
				return;
			} else {
				echo 'failed saving page';
			}
		}
	}
}

$form = new formGeneratorCamaleon('page', $actionForm);

$page->_action = $action;

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
$form->printObjectHiddenField('id_page', $page->_data["id_page"]);
$form->printObjectHiddenField('id_parent', $page->_data["id_parent"]);
$form->printObjectHiddenField('id_content', $content->_data["id_content"]);
$form->printObjectHiddenField('lang', $content->_data["lang"]);
$form->printObjectHiddenField('extra', $page->_data["extra"]);
//$form->printObjectHiddenField('options', $page->_data["options"]);

$arr_options = explode(':', $page->_data['options']);
$value = (in_array('add_page', $arr_options)) ? 1 : 0;
$arr_contenido = explode(':', $page->_data['contenido']);
$value1 = (in_array('contenido', $arr_contenido)) ? 1 : 0;

$arr_links = explode(':', $page->_data['links']);
$value2 = (in_array('links', $arr_links)) ? 1 : 0;

if ($_SESSION['idTypeUserAcct']==5) {
	//Agregar paginas como root 
	/*$checked = ($value==1) ? ' checked="checked" ' : '';
	$form->output .= '<td>Agregar p&aacute;ginas:</td><td><input type="checkbox" name="add_page" '.$checked.' /></td></tr>';*/
	
} else {
	//Agregar paginas como admin
	
	if ($action=='insert') {
		$depth = $APP['default_depth'];
		foreach ($arr_path as $id_page=>$title) {
			if (array_key_exists($id_page, $APP['sections_depths'])) {
				$depth = $APP['sections_depths'][$id_page];
			}
		}
		
		/*if (count($arr_path)>=$depth-1) {
			$value = 0;
		} else {
			$value = 1;
		}*/
	}
	
	//$value=1;//Modificar esto!
/*	$form->output .= '<input type="hidden" name="add_page" value="'.$value.'" />';
	$form->output .= '<input type="hidden" name="add_page" value="'.$value1.'" />';*/
}
$checked = ($value==1) ? ' checked="checked" ' : '';
$form->output .= '<td>Agregar p&aacute;ginas:</td><td><input type="checkbox" name="add_page" '.$checked.' /></td></tr>';



$checked1 = ($value1==1) ? ' checked="checked" ' : '';	
$form->output .= '<tr><td>Solo Contenedora:</td><td><input type="checkbox" name="contenido" '.$checked1.' /></td>';
//esto
$checked2 = ($value2==1) ? ' checked="checked" ' : '';
$form->output .= '<tr><td>Mostrar Submenus hijos:</td><td><input type="checkbox" name="links" '.$checked2.' /></td>';
//fin esto
$arr_options = Page::listOrder($page->_data['id_parent'], $request_content_language);
$form->printSelectOrder($arr_options, $page->_data['id_page']);
$form->printObjectTextField($content, 'title', '', 92, 255);
$form->printObjectTextAreaField($content, 'meta_description','', 91,3,1);
$form->printObjectTextAreaField($content, 'meta_keywords','', 91,3,1);



$form->output .= "<tr><td></td><td>".$label['copy_text_warning']."</td></tr>";
$form->printObjectTextAreaField($content, 'introtext','', 91,15,1);

reset($arr_path);

$form->printObjectTextAreaField($content, 'maintext','', 91,25,1);

if ($_REQUEST['action']=='insert') {
	$form->printObjectHiddenField('id_user_creator', $_SESSION['idUser']);
} else {
	$form->printObjectHiddenField('id_user_creator', $page->_data["id_user_creator"]);
}

//include the file that renders conditionally extra fields-->
if (file_exists($APP['base_admin_path'].'pages/forms/page_extras.php')) {
	reset($arr_path);
	require_once $APP['base_admin_path'].'pages/forms/page_extras.php';
}
//<--include the file that renders conditionally extra fields

$current_page = (isset($_REQUEST['pagination'])) ? '&pagination='.$_REQUEST['pagination'] : '';
$url = 'window.location.href=\'main.php?page=sections&id_parent='.$page->_data['id_parent'].$current_page.'&content_language='.$request_content_language.'\'';
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
	elements : "introtext,maintext",
	theme : "advanced",
	plugins : "safari,pagebreak,style,layer,table,save,advimage,advlink,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,formatselect,styleselect,separator,code,cleanup,separator,removeformat,search,selectall,replace,",
	theme_advanced_buttons2 : ",fontselect,fontsizeselect,forecolor,backcolor,separator,bullist,numlist,separator,link,unlink,separator,sub,sup,separator,",
	theme_advanced_buttons3 : "outdent,indent,separator,undo,redo,separator,hr,removeformat,table,separator,sub,sup,separator,charmap",
	theme_advanced_buttons3 : "tablecontrols",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_resizing : false,

/*	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,styleselect,formatselect",
	theme_advanced_buttons2 : "bullist,numlist,separator,outdent,indent,separator,undo,redo,separator,link,unlink,anchor,image,cleanup,help,code",
	theme_advanced_buttons3 : "hr,removeformat,visualaid,separator,sub,sup,separator,charmap,safari,pagebreak,style,layer,table,save,advimage,advlink,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,search,selectall,replace,",	
	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,formatselect,styleselect,separator,code,cleanup,separator,cut,paste,removeformat,separator,hr,removeformat,table,separator,sub,sup,separator",
	theme_advanced_buttons2 : ",fontselect,fontsizeselect,forecolor,backcolor,separator,bullist,numlist,separator,link,unlink",
	theme_advanced_buttons3 : "outdent,indent,separator,undo,redo,separator,hr,removeformat,table,separator,sub,sup,separator,charmap",
	theme_advanced_buttons3 : "tablecontrols",*/
	
	/*content_css : "css/content.css",*/
	entity_encoding : "raw",
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
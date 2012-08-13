<?php

/* ---------------------------------------
 * Form: content
 * Date: 2008-01-14 17:31:09
 * ---
 * Table information
 *   [file] => /home/www/webdesign/webcamaleon/_private/from_smith/skel//content.php
 * ---
 * IF YOU NEED, THIS FILE CAN BE UPDATED MANUALLY
 * ---------------------------------------
 */

require_once($APP['base_path'].'/config/config.php');
require_once($APP['base_path'].'/pages/class/content.php');
require_once($APP['base_path'].'/config/category_ids.php');
require_once($APP['base_path'].'/config/category_arrays.php');
require_once('smith_class/form_generator.php');
/*
require_once('./config/config.php');
require_once('./class/content.php');
require_once($APP['base_path'].'/config/category_ids.php');
require_once($APP['base_path'].'/config/category_arrays.php');
require_once('smith_class/form_generator.php');
*/
$actionForm = $_SERVER['PHP_SELF'];

$id_content = url_show($_REQUEST["kk"]);

if (isset($_REQUEST['action'])) {
	$content = new Content($id_content);
	foreach ($content->_cols as $key => $value) {
		if($content->_cols[$key] == "date") {
			$dateReceive = split("[./-]", $_REQUEST[$key]);
			$content->_data[$key] = $dateReceive[2]."-".$dateReceive[1]."-".$dateReceive[0];
		} else {
			$content->_data[$key] = $_REQUEST[$key];
		}
		if (($content->_isRequired[$key]) == 1) {
			if ($content->_data[$key] == "" && $key != $content->_keyField) {
				$content->_hasError[$key] = 1;
			} else {
				$content->_hasError[$key] = 0;
			}
		}
	}

	if (!in_array(1, $content->_hasError)) {
		if ($content->saveData() == TRUE) {
			echo 'success';
		} else {
			echo 'failed';
		}
	}
} else {
	if ($id_content != "") {
		$id_content = $id_content;
		$content = new Content($id_content);
		$action = "update";
	} else {
		$id_content = '';
		$content = new Content($id_content);
		$action = "insert";
	}
}

$form = new formGenerator('content', $actionForm);

$content->_action = $action;

$form->htmlStyleTable = "tableForm";
$form->htmlStyleLabelCell = "labelCell";
$form->htmlStyleLabelErrorCell = "labelCellError";
$form->htmlStyleField = "field";
$form->htmlStyleFieldCell = "fieldCell";
$form->htmlStyleFieldCellError = "fieldCellError";

$form->htmlStyleTextFieldError = "fieldTextError";

$form->openTable('border="0" cellpadding="4" cellspacing="0"');

$form->printTableHeader('INSERT TITLE');

$form->displayMsg($content->_hasError, $content->_labels);

$form->printObjectHiddenField('id_content', $content->_data["id_content"]);

$form->printObjectHiddenField("action", $action);
$form->printSubmitButton('Guardar');
$form->closeTable();
$form->closeForm();

echo $form->getFormHTML();
?>
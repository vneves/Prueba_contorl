<?php
/* ---------------------------------------
* Form: user_acct
* Date: 2006-03-31 09:37:36
* ---
* Table information
*   [file] => ../../man/class/skel/user_acct.php
* ---
* IF YOU NEED, THIS FILE CAN BE UPDATED MANUALLY
* ---------------------------------------
*/
require_once($APP['base_path']."config/category_arrays.php");
require_once("smith_class/form_generator.php");
require_once("smith_lib/functions.php");
require_once($APP['base_admin_path']."pages/class/user_acct.php");
require_once($APP['base_admin_path']."pages/class/access.php");
require_once('smith_class/form_generator_camaleon.php');

$actionForm = "main.php?page=user_acct";
$actionForm = $_SERVER['REQUEST_URI'];

//if (isset($_REQUEST['action']) && $_SERVER['REQUEST_METHOD']=="POST") {
if (isset($_POST['action'])) {
	$action = $_REQUEST["action"];
	$idUserAcct = initRequestVar("id_user_acct", "int");
	$userAcct = new UserAcct($idUserAcct);
	
	$userAcctAccess = new UserAcctAccess($userAcct->_data["login"]);
	//$search = buildTextSS($_REQUEST["name"]." ".$_REQUEST["lastname"]);
	$search = "";
;
	foreach ($userAcct->_cols as $key => $value) {
		$value == "int" ? $type = "int" : $type = "str";
		$tmp = initRequestVar($key, $type);
		$userAcct->_data[$key] = $tmp;
		//$userAcct->_data[$key] = initRequestVar($key, $type);

		if ($userAcct->_isRequired[$key] == 1) {
			if (($userAcct->_data[$key] == "") && ($key != $userAcct->_keyField)) {
				$userAcct->_hasError[$key] = 1;
			} else {
				if ($key != $userAcct->_keyField) {
					if ($key == "email") {
						if ($userAcct->isValidateData($key, "email") != 1) {
							$userAcct->_hasError[$key] = 1;
						}
					} else {
						if ($userAcct->isValidateData($key, $userAcct->_cols[$key]) != 1) {
							$userAcct->_hasError[$key] = 1;
						}
					}
				}
			}
		}
		
	}
	$userAcct->_data["search"] = $search;
	$userAcct->_hasError["search"] = 0;
	
	if (!empty($userAcct->_data['email'])) {
		if (!is_email($userAcct->_data['email'])) {
			$userAcct->_hasError["email"] = $label['invalid_email'];
			$validation_fail = true;
		}
	}
	
	/* access data */
	$userAcctAccess->_data = array();

	if(isset($_REQUEST["access"])) {
		foreach ($_REQUEST["access"] as $key => $value) {
			$userAcctAccess->_data[$key] = $value;
		}
	}
		
/*	print_r($userAcct->_hasError);
	echo"<pre>";
		print_r($userAcct);
	echo "</pre>";
	print_r($validation_fail);*/

	if (!isset($validation_fail) || !in_array(1, $userAcct->_hasError)) {
		$userAcct->debug = false;
		
		$savingData = $userAcct->saveData();
				
		if ($savingData == 1) {
			$userAcctAccess->saveData($userAcct->_data["login"]);
			// only read
			if($_SESSION["idUser"] == $userAcct->_data["id_user_acct"]) {
				$varsToSend = "page=settings&id=".$userAcct->_data["id_user_acct"];
			} else {
				$varsToSend = "page=list_user_acct&response=OK";
			}
			if (!isset($from_options)) {
				echo '<script language="javascript">window.location.href="main.php?page=users";</script>';
			}
			//header("Location: main.php?$varsToSend");
		} else {
			$varsToSend = "page=list_user_acct&response=ERROR";
			//header("Location: main.php?$varsToSend");
		}
	}
} else {
	if (isset($from_options)) {
		$idUserAcct = $_SESSION['idUser'];
		$userAcct = new UserAcct($idUserAcct);
		$userAcctAccess = new UserAcctAccess($userAcct->_data["login"], "");
		$action = "update";
	} else {
		if (isset($_REQUEST['id_user_acct'])) {
			$idUserAcct = initRequestVar('id_user_acct', "int");
			$userAcct = new UserAcct($idUserAcct);
			$userAcctAccess = new UserAcctAccess($userAcct->_data["login"], "");
			$action = "update";
		} else {
			$idUserAcct = '';
			$userAcct = new UserAcct($idUserAcct);
			$userAcctAccess = new UserAcctAccess($userAcct->_data["login"], "");
			$action = "insert";
		}
	}
}

$form = new formGeneratorCamaleon('user_acct', $actionForm);

$userAcct->_action = $action;

$form->htmlStyleTable = "tableForm";
$form->htmlStyleLabelCell = "labelCell";
$form->htmlStyleLabelErrorCell = "labelCellError";
$form->htmlStyleField = "field";
$form->htmlStyleFieldCell = "fieldCell";
$form->htmlStyleFieldCellError = "fieldCellError";

$form->htmlStyleTextFieldError = "fieldTextError";

$form->openTable('border="0" cellpadding="4" cellspacing="0"');
$form->output .= '<tr><td colspan="2">'.$label['fields_signed_required'].'</td></tr>';
//$form->printTableHeader('Datos usuario');

//$form->displayMsg($userAcct->_hasError, $userAcct->_labels);

$form->printObjectHiddenField('id_user_acct', $userAcct->_data["id_user_acct"]);

if($action == "insert") {
	$form->printObjectTextField($userAcct, 'login', '', 35);
} else {
	$form->printObjectTextField($userAcct, 'login', '', 35, 75, true);
}

if (isset($from_options)) {
	$form->output .= '<input type="hidden" name="password" value="'.$userAcct->_data['password'].'">';
} else {
	$form->printObjectPasswordField($userAcct, 'password', "", 31);
}

$form->printObjectTextField($userAcct, 'name', "", 35);
$form->printObjectTextField($userAcct, 'lastname', "", 35);
//$form->printObjectTextField($userAcct, 'ci', '', 35);

// only for root user, the complet type of user accounts are available
if ($_SESSION['idUser']>2) {
	$form->printObjectHiddenField('id_type_user_acct', $userAcct->_data["id_type_user_acct"]);
	$form->output .= '<tr><td>'.$label['usertype'].'</td><td>'.$ARRAY_USER_TYPE_LIMITED[$_SESSION['idTypeUserAcct']].'</td></tr>';
} else {
	if(isset($personal)) {
		$form->printObjectHiddenField('id_type_user_acct', $userAcct->_data["id_type_user_acct"]);
	} else {
		$arrayUserType = $_SESSION["idTypeUserAcct"] == 5 ? $ARRAY_USER_TYPE : $ARRAY_USER_TYPE_LIMITED;
		$form->printObjectSelectField($userAcct, 'id_type_user_acct', $arrayUserType);
	}
}


$form->printObjectTextField($userAcct, 'email', '', 35, 100);
$form->printObjectHiddenField('search', $userAcct->_data["search"]);
$form->printObjectHiddenField('date_last_login', $userAcct->_data["date_last_login"]);
$form->printObjectHiddenField('date_last_update', date("Y-m-d H:i:s"));

if($action == "insert") {
	$form->printObjectHiddenField('date_creation', date("Y-m-d H:i:s"));
} else {
	$form->printObjectHiddenField('date_creation', $userAcct->_data["date_creation"]);
}

if(isset($personal)) {
	$form->printObjectHiddenField("active", $userAcct->_data["active"]);
	$form->printObjectHiddenField("personal", 1);
} else {
	$form->printObjectSelectField($userAcct, 'active', $ARRAY_ACTIVE);
}

$form->printObjectSelectField($userAcct, 'genre', $ARRAY_GENRE);

/* access */
/*
$queryAccess="SELECT access AS id_param, name AS value, name FROM access ORDER BY name ASC";
$hidden = isset($personal) ? true : false;
$hidden = false;
$form->printObjectCheckboxField2($userAcctAccess, "Privilegios", $queryAccess, 1, false, "", true, true, $hidden);
*/

$form->output .= '<input type="hidden" name="access[page_admin]" value="page_admin" />';
$form->output .= '<input type="hidden" name="access[user_admin]" value="user_admin" />';

/*
<input type='checkbox' name="access[page_admin]" value='page_admin' id="id_page_admin">
<input type='checkbox' name="access[user_admin]" value='user_admin' id="id_user_admin">
*/
/* end access */

$form->printObjectHiddenField("action", $action);

/* form options */
$labels = array(
"1" => "Guardar",
"2" => "Cancelar",
);
$types = array(
"1" => "submit",
"2" => "button",
);
$actions = array(
"1" => "",
"2" => "history.back();",
);
$form->printFormOptions($labels, $types, $actions);
/* end form options */

$form->closeTable();
$form->closeForm();

echo $form->getFormHTML();
?>
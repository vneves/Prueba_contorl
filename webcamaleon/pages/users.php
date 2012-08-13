<?php
if (!defined("FROM_MAIN")) die("");
//require_once("./config/config.php");
require_once($APP['base_path']."/config/category_arrays.php");
require_once("smith_lib/functions.php");

if (isset($_REQUEST['section'])) {
	switch ($_REQUEST['section']) {
		case "edit":
			require_once dirname(__FILE__)."/users_edit.php";
			return;
			break;
		case "enable":
			require_once dirname(__FILE__)."/users_enabled.php";
			return;
			break;
	}
}

/* Init vars */
if($_SESSION["idTypeUserAcct"] == 5) {//Usuarios root
	$queryUserAccount = "SELECT * FROM user_acct ORDER BY id_type_user_acct ASC, lastname ASC
								";
} elseif($_SESSION['idTypeUserAcct'] == 3) {//Usuarios administradores
	$queryUserAccount = "SELECT * FROM user_acct WHERE id_type_user_acct in(1,2,3,7,9) ORDER BY id_type_user_acct ASC, lastname ASC";
} else {
	$queryUserAccount = "SELECT * FROM user_acct WHERE id_type_user_acct!='3' AND id_type_user_acct!='5' ORDER BY id_type_user_acct ASC, lastname ASC";
}
/* Init DB connection */
$rs = $cn->Execute($queryUserAccount);
$addRecord = '';
if ($_SESSION['idTypeUserAcct']==3 || $_SESSION['idTypeUserAcct']==5) {
	$addRecord = "<a href=\"main.php?page=user_acct\" class=\"fieldText\">Agregar usuario</a>";
}
?>
<div class="div_content">
	<div class="space_up"></div>
	<div><img src="images/spacer.gif" width="" height="14" alt="" /></div>
	<div style="float:left; width:10px;"><img src="images/spacer.gif" width="10" height="1" alt="" /></div>
	<div style="float:left; padding-left:12px;" id="div_form">
		<div style="width:700px;">
			<table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tr>
				<td class="page_title" nowrap="nowrap" style="padding-top:13px; padding-bottom:13px; border-bottom:1px solid #AFCD5B;"><?php echo $label['manage_users']; ?></td>
				<?php
					$href = $_SERVER['PHP_SELF']."?page=users&section=edit&action=insert";
				?>
				<td align="right" valign="bottom" width="100%">
					<?php
					if ($_SESSION['idTypeUserAcct']==3 || $_SESSION['idTypeUserAcct']==5) {
						echo '<a href="'.$href.'" class="form_submit">'.$label['add_user'].'</a>';
					}
					?>
					
				</td>
			</tr>
			</table>
		</div>
		<div><img src="images/spacer.gif" width="1" height="17" alt="" /></div>
		<?php
		if ($rs->RecordCount()>0) {
		?>
			<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="5"><img src="images/green_title_left.gif" width="5" height="28" alt="" /></td>
				<td width="200" class="green_title"><?php echo $label['username']; ?></td>
				<td width="300" class="green_title"><?php echo $label['name_and_lastname']; ?></td>
				<td width="150" class="green_title"><?php echo $label['usertype']; ?></td>
				<td width="40" class="green_title"></td>
				<td width="5"><img src="images/green_title_right.gif" width="5" height="28" alt="" /></td>
			</tr>
			<?php
			$conta = 1;
			while (!$rs->EOF) {
				$class = ($conta%2==0) ? "odd_row" : "even_row";
				echo '<tr class="'.$class.'">';
				echo '<td></td>';
				echo '<td>'.$rs->fields['login'].'</td>';
				echo '<td>'.$rs->fields['lastname'].' '.$rs->fields['name'].'</td>';
				echo '<td>'.$ARRAY_USER_TYPE[$rs->fields["id_type_user_acct"]].'</td>';
				//ConfiguraciÃ³n del toolbar de opciones-->
				if (in_array($_SESSION['idTypeUserAcct'], array(3,5)) || $rs->fields['id_user_acct']==$_SESSION['idUser']) {
					$str_toolbar_separator = '<img src="images/spacer.gif" width="5" height="1" alt="" />';
					$arr_toolbar = array();
					$arr_toolbar['edit_user'] = '<a href="main.php?page=users&section=edit&action=update&id_user_acct='.$rs->fields['id_user_acct'].'" title="'.$label['edit_user'].'"><img src="images/icon_edit.gif" width="17" height="19" alt="'.$label['edit_user'].'" /></a>';
					if ($rs->fields['active']==1) {
						$arr_toolbar['active'] = '<a href="main.php?page=users&section=enable&enable=0&id_user='.$rs->fields['id_user_acct'].'" title="'.$label['user_enabled'].'"><img src="images/icon_published.gif" width="16" height="19" alt="'.$label['user_enabled'].'" /></a>';
					} else {
						$arr_toolbar['active'] = '<a href="main.php?page=users&section=enable&enable=1&id_user='.$rs->fields['id_user_acct'].'" title="'.$label['user_disabled'].'"><img src="images/icon_unpublished.gif" width="16" height="19" alt="'.$label['user_disabled'].'" /></a>';
					}
					$str_toolbar = '<div>'.implode($str_toolbar_separator, $arr_toolbar).'</div>';
				} else {
					$str_toolbar = '';
				}
				//<--ConfiguraciÃ³n del toolbar de opciones
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
	</div>
	<div class="space_down"></div>
</div>
<?php
if (!defined("FROM_MAIN")) die("");
if ($_SERVER['REQUEST_METHOD']=='POST') {
	
}
$sql = "SELECT * FROM user_acct WHERE `login`='".addslashes($_SESSION["login"])."'";
$row_user = $cn->GetRow($sql);
?>
<div style="float:left; padding-left:12px" id="div_form">
	<div>
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="page_title" style="padding-top:13px; padding-bottom:13px; border-bottom:1px solid #AFCD5B; "><?php echo $label["manage_account"]; ?></td>
		</tr>
		</table>
		<div><img src="images/spacer.gif" width="1" height="14" alt="" /></div>
	</div>
	<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td><img src="images/green_title_left.gif" width="5" height="28" alt="" /></td>
		<td width="384" class="green_title"><?php echo $label['personal_data']; ?></td>
		<td><img src="images/green_title_right.gif" width="5" height="28" alt="" /></td>
	</tr>
	</table>
	<div class="form_body" style="width:378px; padding:8px">
	<?php
	$from_options=true;
	require_once $APP['base_admin_path']."/pages/forms/user_acct.php";
	?>
	</div>
</div>
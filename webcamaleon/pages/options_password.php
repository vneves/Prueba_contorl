<?php
if (!defined("FROM_MAIN")) die("");
if ($_SERVER['REQUEST_METHOD']=="POST") {
	$old_p = initRequestVar('old_password', 'str', '');
	$new_p = initRequestVar('new_password', 'str', '');
	$conf_p = initRequestVar('confirm_password', 'str', '');
	
	$sql = "SELECT * FROM user_acct WHERE `login`='".addslashes($_SESSION["login"])."'";
	
	$row_user = $cn->GetRow($sql);
	
	if ($old_p==$row_user['password']) {
		if ($new_p == $conf_p) {
			$sql = "UPDATE user_acct SET `password`='".addslashes($conf_p)."' WHERE `login`='".addslashes($_SESSION["login"])."'";
			$cn->Execute($sql);
			echo $label['password_updated'];
		} else {
			echo $label['new_password_no_match'];
		}
	} else {
		echo $label['old_password_no_match'];
	}
}
?>
<div style="float:left; padding-left:12px" id="div_form">
	<div>
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="page_title" style="padding-top:13px; padding-bottom:13px; border-bottom:1px solid #AFCD5B; "><?php echo $label["password"]; ?></td>
		</tr>
		</table>
		<div><img src="images/spacer.gif" width="1" height="14" alt="" /></div>
	</div>
	<form id="frm_manage_account" action="<?php echo $_SERVER['PHP_SELF']."?page=".$_REQUEST["page"]."&section=password"; ?>" method="post" style="padding:0px; margin:0px;">
		<div style="width:360px;" class="form_body">
			<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="5" class="green_title"><img src="images/green_title_left.gif" width="5" height="28" alt="" /></td>
				<td width="100%" class="green_title"><?php echo $label["change_password"]; ?></td>
				<td width="5" class="green_title"><img src="images/green_title_right.gif" width="5" height="28" alt="" /></td>
			</tr>
			<tr>
				<td colspan="2">
					<table align="center" border="0">
					<tr>
						<td width="130"><?php echo $label["old_password"]; ?></td>
						<td><input type="password" name="old_password" value="" class="form_field" style="width:206px" /></td>
					</tr>
					<tr>
						<td><?php echo $label["new_password"]; ?></td>
						<td><input type="password" name="new_password" value="" class="form_field" style="width:206px" /></td>
					</tr>
					<tr>
						<td><?php echo $label["confirm_password"]; ?></td>
						<td><input type="password" name="confirm_password" class="form_field" style="width:206px" /></td>
					</tr>
					<tr>
						<td></td>
						<td align="center" style="padding-top:20px">
							<input type="submit" value="<?php echo $label["save"]; ?>" class="form_submit" />&nbsp;
							<input type="button" value="<?php echo $label["cancel"];  ?>" class="form_submit" onclick="javascript:history.back();" />
						</td>
					</tr>
					</table>
				</td>
			</tr>
			</table>
		</div>
	</form>
</div>
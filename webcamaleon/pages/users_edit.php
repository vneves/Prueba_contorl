<?php
if (!defined("FROM_MAIN")) die("");
require_once $APP['base_admin_path']."/pages/class/user_acct.php";
require_once $APP['base_admin_path']."/pages/class/access.php";

if ($_REQUEST['action']=='insert') {
	$action_title = $label['add_user'];
} else {
	$action_title = $label['edit_user'];
}
?>
<div class="div_content">
	<div class="space_up"></div>
	<div><img src="images/spacer.gif" width="1" height="14" alt="" /></div>
	<div style="float:left; width:10px;"><img src="images/spacer.gif" width="10" height="1" alt="" /></div>
		<div style="float:left; padding-left:12px" id="div_form">
			<div>
				<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="page_title" style="padding-top:13px; padding-bottom:13px; border-bottom:1px solid #AFCD5B; "><?php echo $label["manage_users"]; ?></td>
				</tr>
				</table>
				<div><img src="images/spacer.gif" width="1" height="17" alt="" /></div>
			</div>
			<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td><img src="images/green_title_left.gif" width="5" height="28" alt="" /></td>
				<td width="384" class="green_title"><?php echo $action_title; ?></td>
				<td><img src="images/green_title_right.gif" width="5" height="28" alt="" /></td>
			</tr>
			</table>
			<div class="form_body" style="width:378px; padding:8px">
			<?php
			require_once dirname(__FILE__)."/forms/user_acct.php";
			?>
			</div>
		</div>
	<div class="space_down"></div>
</div>
<?php
?>
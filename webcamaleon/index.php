<?php 
require_once 'include/functions.php';
require_once "config/config.php";
require_once "lang/language.php";
if (sizeof($APP['admin_languages'])>1) {
	$label = $label[$APP['default_admin_language']];
} else {
	$label = $label[key($APP['admin_languages'])];
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $APP['admin_site_title']; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="site.css" rel="stylesheet" type="text/css" />
</head>
<body onload="document.getElementById('userName').focus();">
<?php
//require_once "pages/footer.php";
require_once "pages/header.php";
?>
<table cellpadding="0" cellspacing="0" border="0" class="table_intro">
<tr>
	<td valign="middle">
		<table cellpadding="0" cellspacing="0" border="0" align="center">
		<tr>
			<td class="td_welcome">
				<img src="images/spacer.gif" width="22" height="1" alt="" /><?php echo $label['welcome']; ?>
			</td>
		</tr>
		<tr>
			<td class="td_welcomeform">
				<form method="post" action="./validate.php" style="padding:0px; margin:0px">
				<table cellpadding="0" cellspacing="0" border="0" width="352">
				<tr>
					<?php
					if(!isset($_GET['response'])){
						echo '<td colspan="2"><img src="images/spacer.gif" width="1" height="21" alt="" /></td>';
					} else {
						echo '<td colspan="2" align="center"><div class="error_message" style="height:21px">'.$label['error_message'].'</div></td>';
					}
					?>
				</tr>
				<tr>
					<td class="field_label" width="106"><?php echo $label['user']; ?>:</td>
					<td><input id="userName" type="text" name="userName" class="input" /></td>
				</tr>
				<tr>
					<td colspan="2"><img src="images/spacer.gif" width="1" height="15" alt="" /></td>
				</tr>
				<tr>
					<td class="field_label"><?php echo $label['password']; ?>:</td>
					<td><input type="password" name="userPassword" class="input" /></td>
				</tr>
				<tr>
					<td colspan="2"><img src="images/spacer.gif" width="1" height="15" alt="" /></td>
				</tr>
				<?php
				if (sizeof($APP['admin_languages'])>1) {
				?>
				<tr>
					<td class="field_label"><?php echo $label['language']; ?>:</td>
					<td>
						<select name="userLanguage" class="input">
						<?php
						foreach($APP['admin_languages'] as $key=>$value) {
							$selected = ($key == $APP['default_admin_language']) ? ' selected="selected"' : '';
							echo '<option value="'.$key.'"'.$selected.'>'.$label[$value].'</option>';
						}
						?>
						</select>
					</td>
				</tr>
				<?php
				} else {
				?>
				<input type="hidden" name="userLanguage" value="<?php  ?>" />
				<?php
				}
				?>
				<tr>
					<td colspan="2"><img src="images/spacer.gif" width="1" height="15" alt="" /></td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<table width="322" cellpadding="0" cellspacing="0" border="0" align="center">
						<tr>
							<td width="161"><?php /*echo $label['dont_remember_password'];*/ ?></td>
							<td width="161" align="right"><input type="submit" value="<?php echo $label['enter']; ?>" class="login_submit" style="width:92px" /></td>
						</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2"><img src="images/spacer.gif" width="1" height="15" alt="" /></td>
				</tr>
				</table>
				</form>
			</td>
		</tr>
		<tr>
			<td class="copyright">&nbsp;</td>
		</tr>
		</table>
	</td> 
</tr>
</table>
</body>
</html>
<?php
if (!empty($cn)) {
	$cn->Close();
}
?>
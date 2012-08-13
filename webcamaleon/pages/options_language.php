<?php
if (!defined("FROM_MAIN")) die("");
if ($_SERVER['REQUEST_METHOD']=="POST") {
	$lang = initRequestVar('language', 'str', 'es');
	$lang = array_key_exists($lang, $APP['admin_languages']) ? $lang : 'es';
	$_SESSION['language'] = $lang;
	echo '<script language="javascript" type="text/javascript">window.location="'.$_SERVER['PHP_SELF'].'?page='.$_REQUEST['page'].'&section=language"</script>';
}
?>
<div style="float:left; padding-left:12px" id="div_form">
	<div>
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="page_title" style="padding-top:13px; padding-bottom:13px; border-bottom:1px solid #AFCD5B; "><?php echo $label["language"]; ?></td>
		</tr>
		</table>
		<div><img src="images/spacer.gif" width="1" height="14" alt="" /></div>
	</div>
	<form id="frm_manage_account" action="<?php echo $_SERVER['PHP_SELF']."?page=".$_REQUEST["page"]."&section=language"; ?>" method="post" style="padding:0px; margin:0px;">
		<div style="width:306px;" class="form_body">
			<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td><img src="images/green_title_left.gif" width="5" height="28" alt="" /></td>
				<td width="296" class="green_title"><?php echo $label["choose_language"]; ?></td>
				<td><img src="images/green_title_right.gif" width="5" height="28" alt="" /></td>
			</tr>
			</table>
			<table align="center" border="0">
			<tr>
				<td width="76"><?php echo $label["language"]; ?></td>
				<td>
					<select name="language">
						<option value="es" <?php echo ($_SESSION['language']=='es')? 'selected="selected"' : ''; ?>><?php echo $label["spanish"]; ?></option>
						<option value="en" <?php echo ($_SESSION['language']=='en')? 'selected="selected"' : ''; ?>><?php echo $label["english"]; ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="center" style="padding-top:20px">
					<input type="submit" value="<?php echo $label["change"]; ?>" class="form_submit" />
				</td>
			</tr>
			</table>
		</div>
	</form>
</div>
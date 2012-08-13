<?php
if (!defined("FROM_MAIN")) die("");
if ($_SERVER['REQUEST_METHOD']=="POST") {
	$allowed_ips = initRequestVar('ip_allowed', 'str', '');
	if (!empty($allowed_ips)) {
		$arr_ips = explode("\n", $allowed_ips);
		$sql = "DELETE FROM ip_allowed";
		$cn->Execute($sql);
		$sql_base = "INSERT INTO ip_allowed VALUES(\"%s\")";
		foreach ($arr_ips as $value) {
			$arr_net = explode('/', $value);
			if (count($arr_net)!=2 &&  count($arr_net)!=1) { continue; }
			
			if (count($arr_net)==1) {
				if (ip2long($arr_net[0])===false || ip2long($arr_net[0])===-1) { continue; }
				$dirip = trim($arr_net[0]);
				$sql = sprintf($sql_base, $dirip);
				$cn->Execute($sql);
			} else {
				if (ip2long($arr_net[0])===false || ip2long($arr_net[0])===-1) { continue; }
				if (intval($arr_net[1])>32 || intval($arr_net[1])<8) { continue; }
				$dirip = trim($arr_net[0].'/'.intval($arr_net[1]));
				$sql = sprintf($sql_base, $dirip);
				$cn->Execute($sql);
			}
		}
	}
}
?>
<div style="float:left; padding-left:12px" id="div_form">
	<div>
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="page_title" style="padding-top:13px; padding-bottom:13px; border-bottom:1px solid #AFCD5B; "><?php echo $label["ip"]; ?></td>
		</tr>
		</table>
		<div><img src="images/spacer.gif" width="1" height="14" alt="" /></div>
	</div>
	<form id="frm_manage_account" action="<?php echo $_SERVER['PHP_SELF']."?page=".$_REQUEST["page"]."&section=allowedips"; ?>" method="post" style="padding:0px; margin:0px;">
		<div style="width:360px;" class="form_body">
			<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="5" class="green_title"><img src="images/green_title_left.gif" width="5" height="28" alt="" /></td>
				<td width="100%" class="green_title"><?php echo $label["ip_list"]; ?></td>
				<td width="5" class="green_title"><img src="images/green_title_right.gif" width="5" height="28" alt="" /></td>
			</tr>
			<tr>
				<td colspan="2">
					<table align="center" border="0">
					<tr>
						<td>
							<div style="padding:5px;">
								Debe existir un registro por l&iacute;nea, en cualquiera de los siguientes formatos:
								<ul>
									<li><strong>xxx.xxx.xxx.xxx/xx</strong>, en el cual se indica la direcci&oacute;n de red y la m&aacute;scara de subred.</li>
									<li><strong>xxx.xxx.xxx.xxx</strong>, en el cual se indica una sola direcci&oacute;n IP.</li>
								</ul>
								 
							</div>
						<?php
						$rs = $cn->Execute("SELECT * FROM ip_allowed ORDER BY 'ip_allowed'");
						$str_ip_allowed = '';
						while (!$rs->EOF) {
							$str_ip_allowed .= $rs->fields['network']."\n";
							$rs->MoveNext();
						}
						?>
							<div align="center">
							<textarea name="ip_allowed" cols="35" class="fieldTextAreaFranchisee" rows="20"><?php echo $str_ip_allowed; ?></textarea>
							</div>
						</td>
					</tr>
					<tr>
						<td align="center" style="padding-top:20px">
							<input type="submit" value="<?php echo $label["save"]; ?>" class="form_submit" />&nbsp;
						</td>
					</tr>
					</table>
				</td>
			</tr>
			</table>
		</div>
	</form>
</div>
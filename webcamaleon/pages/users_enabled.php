<?php
if (!defined("FROM_MAIN")) die("");
require_once($APP['base_path'].'/config/config.php');
require_once($APP['base_admin_path'].'/pages/class/user_acct.php');

if (!isset($_REQUEST['id_user']) || !UserAcct::exists($_REQUEST['id_user']) || !isset($_REQUEST['enable'])) {
	header("Location: main.php?page=users");
	exit();
}

$enabled = intval($_REQUEST['enable']);
$enabled = ($enabled!=0) ? 1 : 0;

$sql = "UPDATE user_acct SET active='$enabled' WHERE id_user_acct=".intval($_REQUEST['id_user']);
$cn->Execute($sql);
$cn->Close();
header("Location: main.php?page=users");
exit();
?>
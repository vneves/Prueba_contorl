<?php
define("FROM_MAIN", true);
session_start();
require_once dirname(__FILE__)."/config.php";
require_once 'include/functions.php';
require_once "include/magic_quotes.php";
require_once "smith_lib/functions.php";
require_once "lang/language.php";
require_once "include/connection.php";
require_once "include/query.lib.php";

if (!isset($_SESSION['idUser'])) {
	header("Location: index.php");
}

$page_request = initRequestVar('page', 'str', 'main');

//Validacion de idioma del administrador-->
if (sizeof($APP['admin_languages'])>1) {
	$lang = !empty($_SESSION['language']) ? $_SESSION['language'] : '';
	$lang = array_key_exists($lang, $APP['admin_languages']) ? $lang : $APP['default_admin_language'];
} else {
	$lang = key($APP['admin_languages']);
}
$label = $label[$lang];
//<--Validacion de idioma del administrador
switch ($page_request) {
	case 'list_pages':
		$pageToLoad = "pages/list_pages.php";
		break;
	case 'options':
		$pageToLoad = "pages/options.php";
		break;
	case 'sections':
		if (isset($_REQUEST['section'])) {
			switch ($_REQUEST['section']) {
				case "publish":
				case "delete":
					require_once 'pages/sections.php';
					break;
			}
		}
		$pageToLoad = 'pages/sections.php';
		break;
	case 'logout':
		session_destroy();
		header("Location: index.php");
		exit();
		break;
	case 'users':
		if (isset($_REQUEST['section'])) {
			switch ($_REQUEST['section']) {
				case "enable":
				require_once "pages/users.php";
				break;
			}
		}
		$pageToLoad = "pages/users.php";
		break;		
	case 'catalogo':
		$pageToLoad = 'pages/productsection.php';
		break;
	default:
		$page_request = 'main';
		$pageToLoad =  "pages/last_changes.php";
		break;
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $APP['admin_site_title']; ?></title>
	<link rel="stylesheet" type="text/css" href="site.css" />
	<script language="javascript" type="text/javascript" src="js/functions.js"></script>
	<script language="javascript" type="text/javascript" src="js/ajax.js"></script>
	<script language="javascript" type="text/javascript" src="js/validation.js"></script>
	<script language="javascript" type="text/javascript" src="js/wz_tooltip.js"></script>	
</head>
<body>
<?php
echo '<div id="div_main" style="height:100%; width:100%; visibility:visible">
		<div><img src="images/spacer.gif" width="1" height="148" alt="" /></div>';
	require_once $pageToLoad;
echo '<div><img src="images/spacer.gif" width="1" height="15" alt="" /></div>
		</div>';
require_once "pages/header.php";
require_once "pages/menu.php";
//require_once "pages/footer.php";
?>
<script language="javascript" type="text/javascript">
MM_showHide('div_main','show','div_menu','show');
</script>
<pre>
<?php
//print_r($_SESSION);
?>
</pre>

</body>
</html>

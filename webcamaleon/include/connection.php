<?php
require_once $smithPath."adodb/adodb.inc.php";
$cn = @ADONewConnection(APP_DSN);
if (!$cn) {
	$html = '<html>
	<head>
		<title>Web Camale&oacute;n</title>
		<link rel="stylesheet" type="text/css" href="site.css" />
	</head>
	<body>
		<div align="center" style="padding-top:10px">
			Error de conexi&oacute;n con la base de datos.<br />
			Database connection failure.
		</div>
	</body>
	</html>';
	echo $html;
	exit();
}
$cn->SetFetchMode(ADODB_FETCH_ASSOC);
?>
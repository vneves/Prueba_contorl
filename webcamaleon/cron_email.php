<?php
if(isset($_SERVER['REQUEST_METHOD'])) die("NOT ALLOWED FROM HTTP");

define("FROM_MAIN", true);
define("CRON_WORK", true);

require_once "config.php";
require_once 'include/functions.php';
require_once "include/magic_quotes.php";
require_once "smith_lib/functions.php";
require_once "lang/language.php";
require_once "include/connection.php";
require_once "include/send_mail.php";

$num_mails = 30;

$sql = "SELECT * FROM email_message LIMIT $num_mails";
$rs = $cn->Execute($sql);
$conta_envio = 0;
//ciclo que envia correos-->
while (!$rs->EOF) {

	$senderName = "SKINS";
	$senderMail = "no_reply@skins.com.mx";
	$subject = $rs->fields['title'];
	$html_content = $rs->fields['content'];
	$email = $rs->fields['email'];
	
	$res = send_mail(
			$email,
			$senderName,
			$senderMail,
			$subject,
			$html_content,
			"",
			$_SERVER['HTTP_HOST'],
			""
		);
	
	if ($res==true) {
		echo "mail ".$rs->fields['id_email_message']." sent to ".$email."<br />\n";
	} else {
		echo "mail ".$rs->fields['id_email_message']." not sent to ".$email."<br />\n";
	}
	
	$sql = "DELETE FROM email_message WHERE id_email_message=".$rs->fields['id_email_message'];
	$cn->Execute($sql);
	
	$rs->MoveNext();
	$conta_envio++;
}
//<--ciclo que envia correos

echo "\n\nTotal de emails enviados: ".$conta_envio;

exit();
?>
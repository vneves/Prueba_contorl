<?php
function send_mail(
	$MailTo = "", 
	$SenderName = "Sender", 
	$SenderMail = "no@reply.error",
	$Subject = "", 
	$Mailcontent = "no.file", 
	$Attachment = "no.file", 
	$Servername = "PHPMAILSERVER", 
	$nohtml  = "[ This message should be viewed in HTML. This is a degraded version! ]"){
	
    if (strtoupper(substr(PHP_OS,0,3)=='WIN')) {
      $eol="\r\n";
      $sol="\n";
    } elseif(strtoupper(substr(PHP_OS,0,3)=='MAC')) {
      $eol="\r";
    } else {
      $eol="\n";
    }
    if(!isset($sol)){
        $sol = $eol;
    }
    $Momentn = mktime().".".md5(rand(1000,9999));
    $f_name       = $Attachment;
    $handle       = @fopen($f_name, 'rb');
    $f_contents   = @fread($handle, filesize($f_name));
    $f_contents   = @base64_encode($f_contents);
    if ($handle) {
        $sendfile = true;
        if (ini_get('mime_magic.debug')) {
            $Bestype = @mime_content_type($Attachment);   
        } else {
            $Bestype = 'application/octet-stream';
        }
        if (!$Bestype) {
            $Bestype = 'application/octet-stream';
        }
        $file_realname = explode("/", $Attachment);
        $file_realname = $file_realname[count($file_realname)-1];
        $file_realname = explode("\\", $file_realname);
        $file_realname = $file_realname[count($file_realname)-1];
    }
    @fclose($handle);
    $Mailcontentstri  = explode($sol, $Mailcontent);
    $Mailcontentstrip = strip_tags($Mailcontentstri[0]);
	
	$body = $Mailcontent;
    $Textmsg = eregi_replace("<br(.{0,2})>", $eol, $body);
    $Textmsg = eregi_replace("</p>", $eol, $Textmsg);
    $Textmsg = strip_tags($Textmsg);
    $Textmsg = $nohtml.$eol.$eol;//.$Textmsg;
    //$headers      .= 'To: '.$MailTo.' <'.$MailTo.'>'.$eol;
	//$headers      .= 'To: '.$MailTo.$eol;
	$headers = '';
    $headers      .= 'From: '.$SenderName.' <'.$SenderMail.'>'.$eol;
    $headers      .= "Message-ID: <".$Momentn."@".$Servername.">".$eol;
    $headers      .= 'Date: '.date("r").$eol;
    $headers      .= 'Sender-IP: '.$_SERVER["REMOTE_ADDR"].$eol;
    $headers      .= 'X-Mailser: iPublications Adv.PHP Mailer 1.6'.$eol;
    $headers      .= 'MIME-Version: 1.0'.$eol;
    $bndp          = md5(time()).rand(1000,9999);
    $headers      .= "Content-Type: multipart/mixed; $eol       boundary=\"".$bndp."\"".$eol.$eol;
    $msg           = "This is a multi-part message in MIME format.".$eol.$eol;
    $msg          .= "--".$bndp.$eol;
    $bnd           = md5(time()).rand(1000,9999);
    $msg          .= "Content-Type: multipart/alternative; $eol       boundary=\"".$bnd."\"".$eol.$eol;
    $msg          .= "--".$bnd.$eol;
    $msg          .= "Content-Type: text/plain; charset=iso-8859-1".$eol;
    $msg          .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
    $msg          .= $Textmsg.$eol;
	//$msg          .= $body.$eol;
    $msg          .= "--".$bnd.$eol;
    $msg          .= "Content-Type: text/html; charset=iso-8859-1".$eol;
    $msg          .= "Content-Transfer-Encoding: 8-bit".$eol.$eol;
    $msg          .= $body.$eol;
    $msg          .= "--".$bnd."--".$eol.$eol;
    if(isset($sendfile)){
        $msg          .= "--".$bndp.$eol;
        $msg          .= "Content-Type: $Bestype; name=\"".$file_realname."\"".$eol;
        $msg          .= "Content-Transfer-Encoding: base64".$eol;
        $msg          .= "Content-Disposition: attachment;".$eol;
        $msg          .= "       filename=\"".$file_realname."\"".$eol.$eol;
        $f_contents    = chunk_split($f_contents);
        $msg          .= $f_contents.$eol;
    }
    $msg          .= "--".$bndp."--";
	
    if(!isset($error)){
        if(@mail($MailTo, $Subject, $msg, $headers)){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

?>

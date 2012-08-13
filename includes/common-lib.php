<?php
/* Generic Form Handling 2006/03/07 */


/**
 * Use session to prevent direct POST to form.
 * Makes life of spam bots harder.
 */
	if( !headers_sent() )
		session_start();
	
/**
 * Random numbers will be needed for anti-spam field name and value
 */
	srand( time() );
	$antispam_fields = array( "from:", "bcc:", "cc:", "MIME", "www", "http", "href" );

/**
 * Function for checking if user has used our web form to generate the request.
 * Checks session variables with submitted form fields. Destroys session variables upon success.
 */
function common_check_cookie($antispamName = "", $antispamValue = "") {
	if( $_SESSION['antispam'] == 1 && $antispamName == $_SESSION['antispam_name'] && $antispamValue == $_SESSION['antispam_value'] ) {
		unset( $_SESSION['antispam'] );
		unset( $_SESSION['antispam_name'] );
		unset( $_SESSION['antispam_value'] );
		return false;
	} else
		return true;
}

/**
 * Function for setting session and form field parameters to allow checking
 * if user has used our web form to generate the request.
 *
 * @return  string  String containing form elements that can be directly inserted in HTML
 */
function common_set_cookie() {
	$_SESSION['antispam'] = 1;
	$_SESSION['antispam_name'] = md5( rand( 0, 98765 ).$_SERVER['REMOTE_ADDR'].rand( 0, 98765 ) );
	$_SESSION['antispam_value'] = md5( rand( 0, 56789 ).$_SERVER['REMOTE_ADDR'].rand( 0, 56789 ) );
	
	$antispam_hidden_html = "<input type='hidden' name='antispam_name' value='$_SESSION[antispam_name]' />\n<input type='hidden' name='antispam_value' value='$_SESSION[antispam_value]' />\n";
	return $antispam_hidden_html;
}

/**
 * Function for checking if user has used our web form to generate the request.
 * Checks session variables with submitted form fields. Destroys session variables upon success.
 */
function common_check_cookie2($antispamName = "", $antispamValue = "") {
	if( $_SESSION['antispam2'] == 1 && $antispamName == $_SESSION['antispam_name2'] && $antispamValue == $_SESSION['antispam_value2'] ) {
		unset( $_SESSION['antispam2'] );
		unset( $_SESSION['antispam_name2'] );
		unset( $_SESSION['antispam_value2'] );
		return false;
	} else
		return true;
}

/**
 * Function for setting session and form field parameters to allow checking
 * if user has used our web form to generate the request.
 *
 * @return  string  String containing form elements that can be directly inserted in HTML
 */
function common_set_cookie2() {
	$_SESSION['antispam2'] = 1;
	$_SESSION['antispam_name2'] = md5( rand( 0, 98765 ).$_SERVER['REMOTE_ADDR'].rand( 0, 98765 ) );
	$_SESSION['antispam_value2'] = md5( rand( 0, 56789 ).$_SERVER['REMOTE_ADDR'].rand( 0, 56789 ) );
	
	$antispam_hidden_html = "<input type='hidden' name='antispam_name' value='$_SESSION[antispam_name2]' />\n<input type='hidden' name='antispam_value' value='$_SESSION[antispam_value2]' />\n";
	return $antispam_hidden_html;
}



/**
 * Function for generic validation of form field elements.
 *
 * @param   string  Field data
 * @param   string  Field type
 * @param   boolean Required field
 * @return  string  String containing error message OR false if valid
 */
function common_validate( $data, $field_type, $required = false, $fieldName = "" ) {
	global $antispam_fields;
	
	// email regular expression - matches a limited version of the RFC 2822 addr-spec form.
	$email_regexp = "/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/";
	
	/*
	// phone regular expression - should accept spaces, parenthesis, periods, dashes, and “x�?
	// Examples:
	// 203.215.1234
	// (617) 555-1212
	// (617)555-1212
	// 617-555-1212 x1234
	// 617-555-1212ext1234
	// 508 555-1212
	$phone_regexp = "/^(?:\(\d{3}\)|\d{3})[\s\.\-]?\d{3}[\s\.\-]?\d{4}(?:\s*x\s*\d{1,4}|\s*ext\s*\d{1,4})?$/";
	*/
	
	// Replaced by T. Drpic
	// phone regular expression, accept: spaces  -  .  (  ) x  ext +
	// Examples:
	// +591.4.555.0114
	// ++591.4.555.0114
	// ++591.704.12345
	// 203.215.1234
	// (617) 555-1212
	// (617)555-1212
	// 617-555-1212 x1234
	// 617-555-1212ext1234
	// 617-555-1212ext1234
	$phone_regexp = "/^\+?\+?(?:\(\d{3}\)|\d{3})[\s\.\-]?(\d{1,4}[\s\.\-]?)?\d{3}[\s\.\-]?\d{3,5}(?:\s*x\s*\d{1,5}|\s*ext\s*\d{1,5})?$/";
	
	// check required field
	if( $required && empty( $data ) )
		return common_error_message( $field_type, "empty", $fieldName );
	if( !$required && empty( $data ) )
		return false;
	
	// specific fields check
	switch( $field_type ) {
		case "EMAIL":
			if( !preg_match( $email_regexp, $data ) )
				return common_error_message( $field_type, "invalid", $fieldName );
			break;
		case "PHONE":
			if( !preg_match( $phone_regexp, $data ) )
				return common_error_message( $field_type, "invalid", $fieldName );
			break;
	}
	
	// check for special characters (anti-spam)
	if( $field_type != "COMMENT" && preg_match( "/\r|\n/", $data ) )
		return common_error_message( $field_type, "invalid_chars", $fieldName );
	
	// check for special phrases (anti-spam)
	foreach( $antispam_fields as $field )
		if( stristr( $data, $field ) )
			return common_error_message( $field_type, "spam_phrase", $fieldName );
	
	// field is clear => rejoice!
	return false;
}

/**
 * Function for error messages 
 *
 * @param   string  Type of field that is validated
 * @param   string  Type of error that is validated
 * @return  string  String containing the error message
 */
function common_error_message( $field_type, $error_type, $fieldLabel = "" ) {
	global $antispam_fields;
	switch( $error_type ) {
		case "empty":
			switch( $field_type ) {
				case "NAME":
					return "<div class=\"errorLabel\">Name is a required field.</div>";
				case "EMAIL":
					return "<div class=\"errorLabel\">Email is a required field.</div>";
				case "PHONE":
					return "<div class=\"errorLabel\">Phone is a required field.</div>";
				case "EXT":
					return "<div class=\"errorLabel\">Ext is a required field.</div>";
				case "CITY":
					return "<div class=\"errorLabel\">City is a required field.</div>";
				case "STATE":
					return "<div class=\"errorLabel\">State is a required field.</div>";
				case "ZIP":
					return "<div class=\"errorLabel\">Zip is a required field.</div>";
				case "COMMENT":
					return "<div class=\"errorLabel\">Comments is a required field.</div>";
				case "COMPANY":
					return "<div class=\"errorLabel\">Company is a required field.</div>";
				default:
					return "<div class=\"errorLabel\">$fieldLabel is a required field.</div>";
			}
			break;
		case "invalid":
			if( $field_type == "EMAIL" )
				return "<div class=\"errorLabel\">Invalid email address.</div>";
			if( $field_type == "PHONE" )
				return "<div class=\"errorLabel\">Invalid phone number.</div>";
			break;
		case "invalid_chars":
			return "<div class=\"errorLabel\">Invalid characters in field.</div>";
		case "spam_phrase":
			$err_msg = "In our effort to stop unwanted emails, we have implemented anti-spam measures. Please remove the following text from your field and re-submit: ";
			foreach( $antispam_fields as $key => $field ) {
				if( $key != 0 )
					$err_msg .= ", ";
				$err_msg .= "\"$field\"";
			}
			return "<div class=\"errorLabel\">$err_msg</div>";
	}
	return "<div class=\"errorLabel\">Unknown error.</div>";
}

/**
 * Function for sending emails
 *
 * @param   array   Quick send of emails. Format: ( 'to' => email, 'subject' => text, 'body' => text, 'cc' => email_or_empty, 'bcc' => email_or_empty, 'from' => email_or_empty )
 * @return  boolean If message has been sent
 */
function common_mastermail( $mail_arr ) {
	return common_send_email(  $mail_arr['to'],
				  $mail_arr['subject'],
				  $mail_arr['body'],
				  $mail_arr['cc'],
				  $mail_arr['bcc'],
				  $mail_arr['from'],
				  $mail_arr['headers'] );
}

/**
 * Function for sending emails
 *
 * @param   string  To: email address
 * @param   string  Subject of the email
 * @param   string  Body of the email
 * @param   string  Carbon Copy Field
 * @param   string  Blind Carbon Copy
 * @param   string  From: header field
 * @return  boolean If message has been sent
 */
function common_send_email( $to, $subject, $body, $cc, $bcc, $from, $headers ) {
	if( empty( $to ) )
		return false;
	
	if( !empty( $cc ) )
		$headers .= "CC: $cc\r\n";
	if( !empty( $bcc ) )
		$headers .= "BCC: $bcc\r\n";
	if( !empty( $from ) )
		$headers .= "From: $from\r\n";
	
	return mail( $to, $subject, $body, $headers);
}

// use this function to display/insert values coming from Get/Post/Cookie.
// parameter "act" should have a value "display" if it is being used for displaying value. 
// in case of database update/insert the "act" can be left blank.
function setGPC($val = "", $act = "") {
	if(!get_magic_quotes_gpc())
		$val = addslashes(trim($val));
	
	if($act == "display")
		$val = stripslashes($val);
	
	return $val;		
}

// CODING EMAIL ADDRESSES
function codeEmail($str){
	$encodeStr = "";
	for ($i=0; $i<strlen($str); $i++) {
		$char = substr($str, $i, 1);
		$charAscii = ord($char);
		
		$randNumber1 = rand(50,150);
		$randNumber1 *= (rand(0,1)==0) ? -1 : 1;
		$randNumber2 = rand(25,175);
		$randNumber2 *= (rand(0,1)==0) ? -1 : 1;
	 	
		if ($randNumber1 + $randNumber2 > $charAscii) {
			$randNumber3 = ($randNumber1 + $randNumber2 - $charAscii) * (-1);
		} elseif($randNumber1 + $randNumber2 < $charAscii) {
			$randNumber3 = $charAscii - ($randNumber1 + $randNumber2);
		}
		
		$arrNumbers = array($randNumber1, $randNumber2);
		if (isset($randNumber3)) {
			$arrNumbers[] = $randNumber3;
			unset($randNumber3);
		}
		
		$formula = "";
		
		foreach($arrNumbers as $nn => $number){
			$formula .= ($number>0) ? "+" : "-";
			$base = rand(0,2);
			switch ($base) {
				case 0://Decimal
					$formula .= abs($number);
					break;
				case 1://Hexadecimal
					$formula .= "0x".dechex(abs($number));
					break;
				case 2://Octal
					$formula .= "0".decoct(abs($number));
					break;
			}
		}
		
		//$encodeStr .= ord($char);
		$encodeStr .= $formula;
		if ($i<strlen($str)-1) {
			$encodeStr .= ",";
		}
	}
	
	$encodeStr = "<script language=\"javascript\" type=\"text/javascript\">document.write(String.fromCharCode($encodeStr));</script>";
	return($encodeStr);
}

?>

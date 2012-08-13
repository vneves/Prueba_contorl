<?php
//webcamaleon -->
$APP['site_url'] = 'proyectos.ilatina.com';

	$APP['smith_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/smith/';
	$smithPath = "/var/www/vhosts/ilatina.com/subdomains/proyectos/httpdocs/smith/";
	$includePath = '.:/var/www/vhosts/ilatina.com/subdomains/proyectos/httpdocs/smith/';
	$dbUser = 'guaman_usr';
	$dbPassword = 'guaman_pwd';
	$dbHost = 'localhost';
	$dbDatabase = 'guaman_db';
	$dbDriver = 'mysql';
	
	$APP['base_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/guaman/';
	$APP['base_path'] = '/var/www/vhosts/ilatina.com/subdomains/proyectos/httpdocs/guaman/';
	$APP['base_admin_path'] = '/var/www/vhosts/ilatina.com/subdomains/proyectos/httpdocs/guaman/webcamaleon/';

$res = ini_set("include_path", $includePath);
$val_upload="";
$format_arc= array("image/jpg","image/gif","image/png","image/jpeg");
define('APP_DSN', "$dbDriver://$dbUser:$dbPassword@$dbHost/$dbDatabase");
define('MYSQL_DATE_FORMAT', "Y-m-d H:i:s");

$APP['admin_site_title'] = 'Webcamaleon Base - Web Camale&oacute;n';
$APP['site_title'] = 'Guaman';

$APP['files_resources'] = $APP['base_path'].'/files_resources/';
$APP['private_files_resources'] = $APP['base_path'].'/private_files_resources/';
$APP['files_resources_url'] = $APP['base_url'].'files_resources/';

$APP['sections_num_page'] = 30;


$APP['admin_languages'] = array(
	'es' => 'spanish'
);

$APP['content_languages'] = array(
	'es' => 'spanish',
	'en' => 'english',
	'ger' => 'german'
);

$APP['default_content_language'] = 'es';
$APP['default_admin_language'] = 'es';

$APP['file_type'] = array (
	'attach' => 'attached_files',
	'template_image' => 'template_images'
	//'content_image' => 'content_images'
);
//<-- webcamaleon

?>


<?php
//webcamaleon -->
	/*$APP['site_url'] = 'salonsanmiguel.com';
	$APP['smith_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/smith/';
	$smithPath = "E:/xampp/htdocs/smith/";
	$includePath = 'E:/xampp/htdocs/smith/';
	$dbUser = 'root';
	$dbPassword = '';
	$dbHost = 'localhost';
	$dbDatabase = 'sanmiguel_db';
	$dbDriver = 'mysql';
	
	$APP['base_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/sanmiguel/';
	$APP['base_path'] = 'E:/xampp/htdocs/sanmiguel/';
	$APP['base_admin_path'] = 'E:/xampp/htdocs/sanmiguel/webcamaleon/';	*/
	
	/////////////////////////////////////////////////////////////////////////////////////
	$APP['site_url'] = 'salonsanmiguel.com';
	
	$APP['smith_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/smith/';
	$smithPath = "/home/salonsanmiguel/salonsanmiguel.com/smith/";
	$includePath = '.:.:/home/salonsanmiguel/salonsanmiguel.com/smith/';
	$dbUser = 'salonsanmiguel';
	$dbPassword = 'SALONfiestas2010';
	$dbHost = 'mysql.salonsanmiguel.com';
	$dbDatabase = 'sanmiguel_db';
	$dbDriver = 'mysql';
	
	$APP['base_url'] = 'http://'.$_SERVER['HTTP_HOST'];
	$APP['base_path'] = '/home/salonsanmiguel/salonsanmiguel.com/';
	$APP['base_admin_path'] = '/home/salonsanmiguel/salonsanmiguel.com/webcamaleon/';
	
	
	
	

$res = ini_set("include_path", $includePath);
$val_upload="";
$format_arc= array("image/jpg","image/gif","image/png","image/jpeg","image/swf");
define('APP_DSN', "$dbDriver://$dbUser:$dbPassword@$dbHost/$dbDatabase");
define('MYSQL_DATE_FORMAT', "Y-m-d H:i:s");

$APP['admin_site_title'] = 'Webmcamaleon Base - Web Camale&oacute;n';
$APP['site_title'] = 'San Miguel';

$APP['files_resources'] = $APP['base_path'].'/files_resources/';
$APP['private_files_resources'] = $APP['base_path'].'/private_files_resources/';
$APP['files_resources_url'] = $APP['base_url'].'files_resources/';

$APP['sections_num_page'] = 30;


$APP['admin_languages'] = array(
	'es' => 'spanish'
);

$APP['content_languages'] = array(
	'es' => 'spanish'

);

$APP['default_content_language'] = 'es';
$APP['default_admin_language'] = 'es';

$APP['file_type'] = array (
	'attach' => 'attached_files',
	'template_image' => 'template_images'
	//'content_image' => 'content_images'
);
//<-- webcamaleon

/*$emailConfig = array(
	"from" => 'info@todoturismo.org',
	"to" => 'contacto@todoturismo.org',
	"subject" => 'Formulario de contacto',
	"reply" => '',
	"sender" => 'Sitio Web - Contacto',
	'extra_headers' => 'MIME-Version: 1.0' . "\n".
		 'Content-type: text/plain; charset=utf-8' . "\n".
	     'Content-Transfer-Encoding: quoted-printable'."\n"
);*/
$emailConfig = array(
	"from" => 'info@salonsanmiguel.com',
	"to" => 'info@salonsanmiguel.com',
	"subject" => 'Formulario de contacto',
	"reply" => '',
	"sender" => 'Sitio Web - Contacto',
	'extra_headers' => 'MIME-Version: 1.0' . "\n".
	'Content-type: text/plain; charset=utf-8' . "\n".
	'Content-Transfer-Encoding: quoted-printable'."\n"
);
//Inicio Nav bar-->//HAS THE ID-PAGES
$NAVBAR_ARR = array(
	"inicio" => '1',
	"quienes" => '2',
	"servicio" => '10',
	"paquetes" => '18',
	"hoteles" => '33',
	"reservaciones" => '36',
	"soporte" => '37',
	"contacto" => '41'
);
//For spanish-->//
$NAVBAR_IMAGES['es'] = array(
	1 => array('opt_inicio.gif', 'opt_iniciob.gif'),
	2 => array('opt_quienes.gif', 'opt_quienesb.gif'),
	10 => array('opt_servicio.gif', 'opt_serviciob.gif'),
	18 => array('opt_paquetes.gif', 'opt_paquetesb.gif'),
	33 => array('opt_hoteles.gif', 'opt_hotelesb.gif'),
	36 => array('opt_reservaciones.gif', 'opt_reservacionesb.gif'),
	37 => array('opt_soporte.gif', 'opt_soporteb.gif'),
	41 => array('opt_contacto.gif', 'opt_contactob.gif')
);
$FooterMsg['es']='Todos los derechos reservados Grupo Todo Turismo Operator &copy; 2008 :: Desarrollado por <a  target="_blank"  class="enlace_gris" title="Diseño y desarrollo de páginas Web en Bolivia - ilatina"  href="http://www.ilatina.com">ilatina</a>';
$GaleriaBtn['es']='Ver fotografías';
$ReservasBtn['es']='Realizar reserva';
$TarifasBtn['es']='Ver tarifas';

//For englis-->//
$NAVBAR_IMAGES['en'] = array(
	1 => array('opt_inicioen.gif', 'opt_inicioenb.gif'),
	2 => array('opt_quienesen.gif', 'opt_quienesenb.gif'),
	10 => array('opt_servicioen.gif', 'opt_servicioenb.gif'),
	18 => array('opt_paquetesen.gif', 'opt_paquetesenb.gif'),
	33 => array('opt_hotelesen.gif', 'opt_hotelesenb.gif'),
	36 => array('opt_reservacionesen.gif', 'opt_reservacionesenb.gif'),
	37 => array('opt_soporteen.gif', 'opt_soporteenb.gif'),
	41 => array('opt_contactoen.gif', 'opt_contactoenb.gif')
);
$FooterMsg['en'] = 'All rights reserved Grupo Todo Turismo Operator &copy; 2008 :: Developed for <a  target="_blank"  class="enlace_gris" title="Design and development of web pages in Bolivia - ilatina" href="http://www.ilatina.com">ilatina</a>';
$GaleriaBtn['en'] = 'See photographies';
$ReservasBtn['en'] = 'Make reservation';
$TarifasBtn['en'] = 'See rates';


//For German-->//
$NAVBAR_IMAGES['ger'] = array(
	1 => array('opt_inicio.gif', 'opt_iniciob.gif'),
	2 => array('opt_quienes.gif', 'opt_quienesb.gif'),
	10 => array('opt_servicio.gif', 'opt_serviciob.gif'),
	18 => array('opt_paquetes.gif', 'opt_paquetesb.gif'),
	33 => array('opt_hoteles.gif', 'opt_hotelesb.gif'),
	36 => array('opt_reservaciones.gif', 'opt_reservacionesb.gif'),
	37 => array('opt_soporte.gif', 'opt_soporteb.gif'),
	41 => array('opt_contacto.gif', 'opt_contactob.gif')
);
$FooterMsg['ger']='Alle Rechte vorbehalten Grupo Todo Turismo Operator &copy; 2008 :: Entwickelt dafür <a  target="_blank"  class="enlace_gris" alt="Design und Entwicklung von Webseiten in Bolivien - ilatina" title="Design und Entwicklung von Webseiten in Bolivien - ilatina" href="http://www.ilatina.com">ilatina</a>';
$GaleriaBtn['ger']='sieh Fotographie';
$ReservasBtn['ger']='Sie Vorbehalt';
$TarifasBtn['ger']='sieh Tarife';
$Labeldescargas['es']="Descargar Documentos";
$Labeldescargas['en']="Download Documents";

//End Nav bar-->

//Titulos especiales de imagenes-->
$APP['default_depth'] = 4;
$APP['sections_depths'] = array();
//Titulos especiales de imagenes-->
$APP['images_special_titles'] = array();
//<--Titulos especiales de imagenes

//special ID's-->
$APP['home']=1;
$APP['empresa']=2;
$APP['certificaiones']=3;
$APP['materia']=4;
$APP['produccion']=46;
$APP['productos']=47;
$APP['servicio']=48;
$APP['preguntas']=49;
$APP['oficinas']=50;
$APP['contacto']=51;
//<--special ID's




$APP['products_files'] = $APP['base_path'].'products_files/';
$APP['products_files_url'] = $APP['base_url'].'products_files/';
$APP['skinscategories_num_page'] = 30;
$APP['skins_num_page'] = 30;
$APP['private_products_files'] = $APP['base_path'].'private_products_files/';
$APP['private_products_files_url'] = $APP['base_url'].'private_products_files/';



$APP['testimonies_pagesize'] = 20;

$LinksLanges['es']="Español";
$LinksLanges['en']="Spanish";
$LinksLanges['ger']="Spanisch";

$LinksLangen['es']="Inglés";
$LinksLangen['en']="English";
$LinksLangen['ger']="Englisch";


$LinksLangger['es']="Alemán";
$LinksLangger['en']="German";
$LinksLangger['ger']="Deutsche";

?>

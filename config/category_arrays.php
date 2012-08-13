<?php
/* ---------------------------------------
 * Application category arrays
 * ---------------------------------------
 */

// simple selection
$ARRAY_USER_TYPE = array(
	1 => $label['backoffice_admin'],
	3 => $label['administrator'],
	5 => 'Root',
);

$ARRAY_USER_TYPE_LIMITED = array(1=>$label['backoffice_admin'], 3=>$label['administrator']);
$ARRAY_GENRE = array(1=>$label['male'], 3=>$label['female']);
$ARRAY_ACTIVE = array(1=>$label['yes'], 3=>$label['no']);

$LOCATION_ARRAY = array(2=>"La Paz", 3=>"Santa Cruz", 4 => "Cochabamba", 6=>"Tarija");
$CONDITION_ARRAY = array(1=>"Malo", 3=>"Regular", 5=>"Bueno");

// PERMISSONS FOR PAGES
$ARRAY_OPTIONS = array(
	"add_page" => "Agregar p&aacute;ginas",
	"available_extra_field" => "Habilitar campo extra"
);

$PURCHASE_STATE = array(0=>"Nueva", 1=>"Procesando", 2=>"Enviada");
?>
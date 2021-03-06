<?php

/* ---------------------------------------
 * Table structure
 * Table: page
 * Date: 2008-01-14 16:58:58
 * ---
 * Database information
 *   [dataProvider] => mysql
 *   [database] => webcamaleon
 *   [host] => localhost
 *   [user] => webcamaleon
 * ---
 * DO NOT EDIT MANUALLY!!!
 * FILE GENERATED BY SCRIPT!!!
 * ---------------------------------------
 */

$this->_tableName = "product_file";

$this->_keyField = "id_product_file";

$this->_cols = array (
	"id_product_file" => "int",
	"id_product" => "int",
	"title" => "text",
	"order" => "int",
	"filename" => "text",
	"type" => "text",
	"tag" => "text",
	"is_private" => "int"
);

$this->_labels = array (
	"id_product_file" => "ID",
	"id_product" => "Producto",
	"title" => html_entity_decode("T&iacute;tulo"),
	"order" => html_entity_decode("&Oacute;rden"),
	"filename" => "Nombre de archivo",
	"type" => "Tipo",
	"tag" => "Tag",
	"is_private" => "Es privado"
);

$this->_isRequired = array (
	"id_product_file" => "1",
	"id_product" => "1",
	"title" => "1",
	"order" => "1",
	"filename" => "1",
	"type" => "1",
	"tag" => "0",
	"is_private" => "1"
);

$this->_errorMsg = array (
	"id_product_file" => "1",
	"id_product" => "1",
	"title" => "1",
	"order" => "1",
	"filename" => "1",
	"type" => "1",
	"tag" => "1",
	"is_private" => "1"
);
?>

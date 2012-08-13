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
require_once $APP['base_admin_path'].'pages/class/temporal_query.php';

Temporal_query::recycle();
?>
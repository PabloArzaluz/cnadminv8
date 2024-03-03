<?php
ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
define('DB_SERVER', 'localhost');
define('DB_SERVER_USERNAME', 'credinie_portalu');
define('DB_SERVER_PASSWORD', 'sZ;ZcC&XlfAv');
define('DB_DATABASE', 'credinie_portal_sl');

$conexion = mysql_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD);
mysql_select_db(DB_DATABASE, $conexion);
?>
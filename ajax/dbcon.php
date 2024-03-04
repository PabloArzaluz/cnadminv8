<?php
include("../include/configuration.php");
define('DB_SERVER', 'localhost');
define('DB_SERVER_USERNAME', 'credinie_portalu');
define('DB_SERVER_PASSWORD', 'sZ;ZcC&XlfAv');
define('DB_DATABASE', 'credinie_portal_sl');

$conexion = mysqli_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD);
mysqli_select_db(DB_DATABASE, $conexion);
?>
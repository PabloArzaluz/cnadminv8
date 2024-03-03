<?php

	//Conexion A Servidor Remoto
	$dbhost="localhost";
	$dbuser="credinie_portalu";
	$dbpass="sZ;ZcC&XlfAv";
	$dbname="credinie_portal_sl";
/*
	//Conexion A Servidor Local
	$dbhost="localhost";
	$dbuser="root";
	$dbpass="";
	$dbname="sl_credinieto";

*/

	$mysqli   = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	if (mysqli_connect_errno($mysqli)) {
	   echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
?>

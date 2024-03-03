<?php

	//Conexion A Servidor Remoto
	$dbhost="localhost";
	$dbuser="root";
	$dbpass="Qw3rty2024%#";
	$dbname="cn_prtl_sl";
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

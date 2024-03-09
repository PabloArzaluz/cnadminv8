<?php

	//Conexion A Servidor Remoto
	$dbhost="localhost";
	$dbuser="cn_us_db";
	$dbpass="6kGKVNM4pei6ISx";
	$dbname="cn_prtl_sl";
/*
	//Conexion A Servidor Local
	$dbhost="localhost";
	$dbuser="root";
	$dbpass="";
	$dbname="sl_credinieto";

*/
	
	$mysqli   = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	if (mysqli_connect_errno()) {
	   echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
?>

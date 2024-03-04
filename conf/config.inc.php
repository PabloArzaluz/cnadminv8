<?php

	//Conexion A Servidor Remoto
	$dbhost="localhost";
	$dbuser="root";
	$dbpass="";
	$dbname="portal_cn_v8";
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

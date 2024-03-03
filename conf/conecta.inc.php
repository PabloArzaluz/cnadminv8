<?php
function Conecta(){
	require("config.inc.php");
	$Conexion = mysql_connect($dbhost,$dbuser,$dbpass);
	if(!$Conexion){
		die("Error al conectar con la BD, favor de verificar");
		  }
	if(!mysql_select_db($dbname, $Conexion))
		echo 'No se selecciono correctamente la Base de Datos <b>'.$dbname. '</b>';
	return $Conexion;
}
function desconectar_bd(){
	require("config.inc.php");
	$Conexion = mysql_connect($dbhost,$dbuser,$dbpass); 
	mysql_close();
}
	
?>
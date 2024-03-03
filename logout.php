<?php
	session_start();
	include('conf/conecta.inc.php');
	include('conf/config.inc.php');
	ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
	$link=Conecta();
 	date_default_timezone_set('America/Mexico_City');
	/*$user = $_SESSION['id_user'];
	$fecha = date("Y-m-d");
  $hora = date("H:i:s");
  $fechahoracompleta = $fecha." ".$hora;
*/
	session_destroy();
/*	if(isset($_GET['alert'])){
		$alert = $_GET['alert'];
		header("Location: index.php?alert=".$alert);
	}else{
		$conocer_nombre_usuario = "select Nickname from usuario where idUsuario = $user";
		$iny_conocer_nombre_usuario = mysql_query($conocer_nombre_usuario,$link) or die(mysql_error());
		$f_conocer_usuario = mysql_fetch_row($iny_conocer_nombre_usuario);
		$insertar_acceso = "insert into log_acceso(id_usuario,usuario,datetime,resultado) values($user,'$f_conocer_usuario[0]','$fechahoracompleta','Cierre de Sesion Exitoso');";
		$iny_insertar_acceso = mysql_query($insertar_acceso,$link) or die(mysql_error());
		header("Location: index.php?alert=3");
	}*/
	header("Location: index.php?alert=3");
?>

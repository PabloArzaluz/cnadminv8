<?php
	session_start();
	include("include/configuration.php");
	include("include/configuration.php");
	include('conf/conecta.inc.php');
	include('conf/config.inc.php');
	
 	
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
		$iny_conocer_nombre_usuario = mysqli_query($mysqli,$conocer_nombre_usuario) or die(mysqli_error());
		$f_conocer_usuario = mysqli_fetch_row($iny_conocer_nombre_usuario);
		$insertar_acceso = "insert into log_acceso(id_usuario,usuario,datetime,resultado) values($user,'$f_conocer_usuario[0]','$fechahoracompleta','Cierre de Sesion Exitoso');";
		$iny_insertar_acceso = mysqli_query($mysqli,$insertar_acceso) or die(mysqli_error());
		header("Location: index.php?alert=3");
	}*/
	header("Location:index.php?alert=3");
?>

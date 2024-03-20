<?php
	session_start(); // crea una sesion
	error_reporting(E_ALL); ini_set("display_errors", 1);
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/functions.php");
	
	if(validarAccesoModulos('permiso_inversionistas_cambiar_credito') != 1) {
		header("Location: dashboard.php");
	}

	date_default_timezone_set('America/Mexico_City');

	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	$usuario = $_SESSION['id_usuario'];
	$fecha = date("Y-m-d");
  	$hora = date("G:i:s");

	$inversionista_credito = $_POST['inver_credito'];
	$id_inversionista			= $_POST['inversionista'];
    $comentarios 		= $_POST['comentarios'];
	$interes_api	= $_POST['interes-api'];
    $id_credito			= $_POST['credito'];
	$monto_asignado 	= $_POST['monto_asignado'];

	//CONOCER INFORMACION ACTUAL
    $CambInvEfec = "SELECT * FROM inversionistas_creditos where inversionistas_creditos.id_inversionistas_creditos = ".$inversionista_credito.";";
	$iny_CambInvEfec = mysqli_query($mysqli,$CambInvEfec) or die(mysqli_error());
	$f_CambInvEfec = mysqli_fetch_assoc($iny_CambInvEfec);
	
	if($id_inversionista != $f_CambInvEfec['id_inversionista']){
		//Se cambio el Inversionista, hay que agregar al Historial
		
    	$InsHisInv = "INSERT into historial_inversionistas_creditos(id_inversionista,id_credito,id_usuario,fechahora,comentarios) values ('".$f_CambInvEfec['id_inversionista']."','$id_credito','$usuario','$fecha $hora','".$f_CambInvEfec['comentarios']."');";
    	$iny_InsHisInv = mysqli_query($mysqli,$InsHisInv) or die(mysqli_error());
	}
	
	if($interes_api != $f_CambInvEfec['interes']){
		//Hay que agregar al registro el cambio CUANDO SE CAMBIA EL INTERES
		
		$q_INSERTAR_REGISTRO_CAMBIO_INTERES_INVER = "INSERT INTO histor_inter_inver_credit(id_credito,interes,fecha_inicio,id_inversionista) VALUES('$id_credito','$interes_api','$fecha $hora','$id_inversionista');";
		$i_INSERTAR_REGISTRO_CAMBIO_INTERES_INVE = mysqli_query($mysqli,$q_INSERTAR_REGISTRO_CAMBIO_INTERES_INVER) or die(mysqli_error());
	}
	//ACTUALIZA INFORMACION COMPLETA
	$q_ACTUALIZA_INFORMACION_GENERAL = "UPDATE inversionistas_creditos SET id_inversionista = '$id_inversionista', comentarios = '$comentarios', interes = '$interes_api', monto ='$monto_asignado' WHERE id_inversionistas_creditos='$inversionista_credito';";
	$i_ACTUALIZA_INFORMACION_GENERAL = mysqli_query($mysqli,$q_ACTUALIZA_INFORMACION_GENERAL) or die(mysqli_error());

	$ruta = "detalle-credito.php?id=".$id_credito."&info=5";
	header('Location: '.$ruta);
  ?>


<?php
	session_start(); // crea una sesion
	ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	$link = Conecta();
	date_default_timezone_set('America/Mexico_City');

	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	$usuario = $_SESSION['id_usuario'];
	$fecha = date("Y-m-d");
  	$hora = date("G:i:s");

	$id_inversionista			= $_POST['inversionista'];
    $comentarios 		= $_POST['comentarios'];
	$interes_api	= $_POST['interes-api'];
    $id_credito			= $_POST['credito'];

	//CONOCER INFORMACION ACTUAL
    $CambInvEfec = "select id_inversionista as inversionista_actual,interes_inversionista as interes_api_actual, comentarios_inversionista as comentarios_inversionista_anteriores from creditos where id_creditos = $id_credito";
	$iny_CambInvEfec = mysql_query($CambInvEfec,$link) or die(mysql_error());
	$f_CambInvEfec = mysql_fetch_assoc($iny_CambInvEfec);
	
	if($id_inversionista != $f_CambInvEfec['inversionista_actual']){
		//Se cambio el Inversionista, hay que agregar al Historial
    	$InsHisInv = "INSERT into historial_inversionistas_creditos(id_inversionista,id_credito,id_usuario,fechahora,comentarios) values ('".$f_CambInvEfec['inversionista_actual']."','$id_credito','$usuario','$fecha $hora','".$f_CambInvEfec['comentarios_inversionista_anteriores']."');";
    	$iny_InsHisInv = mysql_query($InsHisInv,$link) or die(mysql_error());
	}
	
	if($interes_api != $f_CambInvEfec['interes_api_actual']){
		//Hay que agregar al registro el cambio CUANDO SE CAMBIA EL INTERES
		$q_INSERTAR_REGISTRO_CAMBIO_INTERES_INVER = "INSERT INTO histor_inter_inver_credit(id_credito,interes,fecha_inicio) VALUES('$id_credito','$interes_api','$fecha $hora');";
		$i_INSERTAR_REGISTRO_CAMBIO_INTERES_INVE = mysql_query($q_INSERTAR_REGISTRO_CAMBIO_INTERES_INVER,$link) or die(mysql_error());
	}
	//ACTUALIZA INFORMACION COMPLETA
	$q_ACTUALIZA_INFORMACION_GENERAL = "UPDATE creditos SET id_inversionista = '$id_inversionista', comentarios_inversionista = '$comentarios', interes_inversionista = '$interes_api' WHERE id_creditos='$id_credito';";
	$i_ACTUALIZA_INFORMACION_GENERAL = mysql_query($q_ACTUALIZA_INFORMACION_GENERAL,$link) or die(mysql_error());

	$ruta = "detalle-credito.php?id=".$id_credito."&info=5";
	header('Location: '.$ruta);
  ?>


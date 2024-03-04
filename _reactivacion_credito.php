<?php
	session_start(); // crea una sesion
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	
	date_default_timezone_set('America/Mexico_City');
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	$fecha = date("Y-m-d");
  	$hora = date("G:i:s");

    $id_credito = $_POST['id-credito'];
    
    $query = "UPDATE creditos SET status='1' WHERE id_creditos = '$id_credito';";
	$resultado = mysqli_query($mysqli,$query) or die(mysqli_error());

	//Conocer Ultimo Juridico de este credito
	$CONOCER_ULTIMO_ID_JURIDICO = "SELECT id_juridicos FROM juridicos WHERE id_credito=".$id_credito." ORDER BY id_juridicos desc limit 1";
	$INY_CONOCER_ULTIM_ID_JURID = mysqli_query($mysqli,$CONOCER_ULTIMO_ID_JURIDICO) or die(mysqli_error());
	$FILA_CONOC_ULTM_ID_JURID = mysqli_fetch_array($INY_CONOCER_ULTIM_ID_JURID);

	//Actualizar el Ultimo Juridico
	$actualizar_fecha_ultimo_juridico = "UPDATE juridicos SET fechareactivacion= '$fecha',usuarioreactivacion = '".$_SESSION['id_usuario']."' where id_juridicos = '$FILA_CONOC_ULTM_ID_JURID[0]' ;";
	$iny_actualizar_fecha_ultimo_juridico =  mysqli_query($mysqli,$actualizar_fecha_ultimo_juridico) or die(mysqli_error());
	

    unset($_SESSION['id_cliente']);
    unset($_SESSION['id_credito']);
    $ruta_regreso = "detalle-credito.php?id=".$id_credito;
    header('Location: '.$ruta_regreso);

  ?>

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
	$fecha = date("Y-m-d");
  	$hora = date("G:i:s");

    $id_credito = $_POST['id-credito'];
    
    $query = "UPDATE creditos SET status='1' WHERE id_creditos = '$id_credito';";
	$resultado = mysql_query($query,$link) or die(mysql_error());

	//Conocer Ultimo Juridico de este credito
	$CONOCER_ULTIMO_ID_JURIDICO = "SELECT id_juridicos FROM juridicos WHERE id_credito=".$id_credito." ORDER BY id_juridicos desc limit 1";
	$INY_CONOCER_ULTIM_ID_JURID = mysql_query($CONOCER_ULTIMO_ID_JURIDICO,$link) or die(mysql_error());
	$FILA_CONOC_ULTM_ID_JURID = mysql_fetch_array($INY_CONOCER_ULTIM_ID_JURID);

	//Actualizar el Ultimo Juridico
	$actualizar_fecha_ultimo_juridico = "UPDATE juridicos SET fechareactivacion= '$fecha',usuarioreactivacion = '".$_SESSION['id_usuario']."' where id_juridicos = '$FILA_CONOC_ULTM_ID_JURID[0]' ;";
	$iny_actualizar_fecha_ultimo_juridico =  mysql_query($actualizar_fecha_ultimo_juridico,$link) or die(mysql_error());
	

    unset($_SESSION['id_cliente']);
    unset($_SESSION['id_credito']);
    $ruta_regreso = "detalle-credito.php?id=".$id_credito;
    header('Location: '.$ruta_regreso);

  ?>

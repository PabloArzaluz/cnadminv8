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

	$idcliente = $_GET['id'];

    $nombre			= $_POST['nombre'];
    $comentarios 		= $_POST['comentarios'];
    $tipo_pago 		= $_POST['tipo-pago'];
	
    echo $query= "UPDATE inversionistas SET
   					nombre 	= '$nombre',
					comentarios 	= '$comentarios',
					tipo_pago 	= '$tipo_pago'
                    WHERE id_inversionistas = $idcliente;";
    			$resultado= mysql_query($query,$link) or die(mysql_error());


		header('Location: inversionistas.php?info=2');

  ?>

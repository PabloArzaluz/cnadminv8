<?php
	session_start(); // crea una sesion
	error_reporting(E_ALL); ini_set("display_errors", 1);
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/functions.php");
	
	date_default_timezone_set('America/Mexico_City');
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	//PERMISOS
	if(validarAccesoModulos('permiso_clientes') != 1) {
		header("Location: dashboard.php");
	}
	//FIN PERMISOS
	$fecha = date("Y-m-d");
  	$hora = date("G:i:s");

	$idaval = $_GET['id'];
	$idCredito = $_GET['idCredito'];

   	$query= "DELETE from avales WHERE id_avales = $idaval;";
    $resultado= mysqli_query($mysqli,$query) or die(mysqli_error());

	header('Location: detalle-credito.php?id='.$idCredito);

  ?>

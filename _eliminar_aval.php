<?php
	session_start(); // crea una sesion
	ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/functions.php");
	$link = Conecta();
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
    $resultado= mysql_query($query,$link) or die(mysql_error());

	header('Location: detalle-credito.php?id='.$idCredito);

  ?>
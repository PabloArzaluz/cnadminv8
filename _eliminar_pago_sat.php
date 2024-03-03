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

	$idsat = $_GET['id'];
	$id_credito=$_GET['idcredito'];


   	$query= "DELETE FROM pagos_sat WHERE id_pagossat = $idsat;";
    $resultado= mysql_query($query,$link) or die(mysql_error());

		header('Location: detalle-credito.php?id='.$id_credito.'&info=4');

  ?>

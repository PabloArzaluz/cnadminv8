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

	$idsat = $_GET['id'];
	$id_credito=$_GET['idcredito'];


   	$query= "DELETE FROM pagos_sat WHERE id_pagossat = $idsat;";
    $resultado= mysqli_query($mysqli,$query) or die(mysqli_error());

		header('Location: detalle-credito.php?id='.$id_credito.'&info=4');

  ?>

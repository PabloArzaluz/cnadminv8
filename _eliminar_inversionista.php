<?php
	session_start(); // crea una sesion
	error_reporting(E_ALL); ini_set("display_errors", 1);
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	
	date_default_timezone_set('America/Mexico_City');
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	$fecha = date("Y-m-d");
  	$hora = date("G:i:s");

	$idcliente = $_GET['id'];


   	$query= "UPDATE inversionistas SET status='inactivo' WHERE id_inversionistas = $idcliente;";
    $resultado= mysqli_query($mysqli,$query) or die(mysqli_error());

		header('Location: inversionistas.php?info=3');

  ?>

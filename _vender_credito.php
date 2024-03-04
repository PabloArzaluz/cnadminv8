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

    $comentarios 		= $_POST['comentarios'];
    $id_credito = $_POST['id-credito'];
	$status_actual = $_POST['status'];

    //Variables de Session
    //$id_credito = $_SESSION['id_credito'];
	$query = "INSERT INTO creditos_vendidos(idUsuario,idCredito, fechahora, comentarios,statusanterior) values('".$_SESSION['id_usuario']."','$id_credito','".$fecha." ".$hora."','$comentarios','$status_actual');";
	$resultado= mysqli_query($mysqli,$query) or die(mysqli_error());
	$queryUpdate = "UPDATE creditos SET status = 4 WHERE id_creditos=$id_credito";
	$resultadoUpdate= mysqli_query($mysqli,$queryUpdate) or die(mysqli_error());
				//$id_cliente = mysqli_insert_id();
    
    //unset($_SESSION['id_cliente']);
    //unset($_SESSION['id_credito']);
    //$ruta_regreso = "detalle-credito.php?id=".$id_credito;
	header('Location:detalle-credito.php?id='.$id_credito);
  ?>

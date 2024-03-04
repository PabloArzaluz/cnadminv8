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

	//echo $_POST['password'];
    $motivo			= $_POST['motivo'];
    $comentarios 		= $_POST['comentarios'];
    $id_credito = $_POST['id-credito'];

    //Variables de Session
    //$id_credito = $_SESSION['id_credito'];
    
   $query = "UPDATE creditos SET motivo_finalizacion_credito = '$motivo',comentario_finalizacion_credito = '$comentarios',status='2',fecha_cierre_credito='$fecha' WHERE id_creditos = '$id_credito';";
    $resultado= mysqli_query($mysqli,$query) or die(mysqli_error());

				//$id_cliente = mysqli_insert_id();
    
    //unset($_SESSION['id_cliente']);
    //unset($_SESSION['id_credito']);
    $ruta_regreso = "detalle-credito.php?id=".$id_credito;
    header('Location: '.$ruta_regreso);

  ?>

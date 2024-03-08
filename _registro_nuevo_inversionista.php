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

	$nombre			= $_POST['nombre'];
    $tipo_pago = $_POST['tipo-pago'];
    $comentarios 		= $_POST['comentarios'];

    
   $query = "INSERT INTO 
                    inversionistas(nombre,comentarios,tipo_pago,fecha_registro,status) 
                    VALUES(
                        '$nombre',
                        '$comentarios',
                        '$tipo_pago',
                        '$fecha $hora',
                        'activo'
                    );";
    $resultado= mysqli_query($mysqli,$query) or die(mysqli_error());

				//$id_cliente = mysqli_insert_id($mysqli);
    
    //unset($_SESSION['id_cliente']);
    //unset($_SESSION['id_credito']);
    header('Location: inversionistas.php?info=1');

  ?>

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
    $resultado= mysql_query($query,$link) or die(mysql_error());

				//$id_cliente = mysql_insert_id();
    
    //unset($_SESSION['id_cliente']);
    //unset($_SESSION['id_credito']);
    header('Location: inversionistas.php?info=1');

  ?>

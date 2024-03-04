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

	
    $credito			= $_POST['id-credito'];
    $monto_pago 		= $_POST['monto-pago'];
    $fecha_aplicacion	= $_POST['fecha-aplicacion'];
    $fecha_pago			= $fecha." ".$hora;
	$usuario_captura	= $_SESSION['id_usuario'];

    $query= "INSERT INTO pagos_sat (id_credito,monto,fecha_aplicacion,fecha_captura,id_usuario_captura)
   				VALUES
			('$credito',
			'$monto_pago',
				'$fecha_aplicacion',
				'$fecha_pago',
				'$usuario_captura'
				);";

    			$resultado= mysqli_query$mysqli,$query) or die(mysqli_error());

      header('Location: detalle-credito.php?id='.$credito.'&i=1');

  ?>

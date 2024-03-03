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

	$inversionista			= $_POST['inversionista'];
    $credito			= $_POST['credito'];
    $monto_pago 		= $_POST['monto-pago'];
    $tipo_pago		= $_POST['tipo-pago'];
	$fecha_pago		= $fecha." ".$hora;
	$usuario_captura	= $_SESSION['id_usuario'];

    
    

   $query= "INSERT INTO pinversionistas (id_credito,id_inversionista,monto,tipo_pago,fecha_captura,usuario_captura)
   				VALUES
			('$credito',
			'$inversionista',
				'$monto_pago',
				'$tipo_pago',
				'$fecha_pago',
				'$usuario_captura'
				);";

    			$resultado= mysql_query($query,$link) or die(mysql_error());

      header('Location: pagos-inversionistas.php?info=1');

  ?>

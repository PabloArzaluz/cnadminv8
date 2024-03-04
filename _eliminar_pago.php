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

	$idpago = $_POST['idpago'];

	//Insertar Info en Tabla para recuperacion
	$conocer_pago = "SELECT * FROM pagos WHERE id_pagos = '$idpago';";
	$iny_conocer_pago = mysqli_query($mysqli,$conocer_pago) or die(mysqli_error());
	$fpago = mysqli_fetch_assoc($iny_conocer_pago);
	$stringHTML = 	"{id_pagos:".$fpago['id_pagos']."},
					{id_usuario:".$fpago['id_usuario']."},
					{fecha_captura:".$fpago['fecha_captura']."},
					{id_credito:".$fpago['id_credito']."},
					{fecha_pago:".$fpago['fecha_pago']."},
					{monto:".$fpago['monto']."},
					{tipo_pago:".$fpago['tipo_pago']."},
					{comentarios:".$fpago['comentarios']."},
					{folio_fisico:".$fpago['folio_fisico']."},
					{saldo_capital:".$fpago['saldo_capital']."},
					{interes_cobrado:".$fpago['interes_cobrado']."},
					{saldo_mes_intereses:".$fpago['saldo_mes_intereses']."},
					{modulo_registro:".$fpago['modulo_registro']."},
					{metodo_pago:".$fpago['metodo_pago']."}
					";

	$INSERTAR_EVIDENCIA_ELIMINACION = "INSERT INTO pagos_eliminados(usuario_elimino,fechahoraelimino,string_data) VALUES('".$_SESSION['id_usuario']."','".$fecha." ".$hora."','".$stringHTML."');";
	$INY_INSERTAR_EVIDENCIA_ELIMINACION= mysqli_query($mysqli,$INSERTAR_EVIDENCIA_ELIMINACION) or die(mysqli_error());
	//$id_credito=$_GET['idcredito'];


   	$query= "DELETE FROM pagos WHERE id_pagos = $idpago;";
    $resultado= mysqli_query($mysqli,$query) or die(mysqli_error());

	header('Location: pagos.php?info=4');

  ?>

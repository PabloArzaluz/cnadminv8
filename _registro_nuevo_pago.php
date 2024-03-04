<?php
	session_start(); // crea una sesion
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	
	date_default_timezone_set('America/Mexico_City');
	include("include/functions.php");
	include("include/funciones.php");
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	$fecha = date("Y-m-d");
  	$hora = date("G:i:s");

	$credito			= $_POST['credito'];
    $monto_pago 		= $_POST['monto-pago'];
    $tipo_pago		= $_POST['tipo-pago'];
	$fecha_pago		= $_POST['fecha-pago'];
    $comentarios			= $_POST['comentarios'];
    $fecha_captura	= $fecha." ".$hora;
	$usuario_captura	= $_SESSION['id_usuario'];
	$folio_fisico = $_POST['folio-fisico'];
	$modulo_registro = $_POST['modulo-registro'];
	$metodo_pago = $_POST['metodo-pago'];
    
	//Verificar Folio folio-fisico
	$conocer_folio_existente = "select * from pagos where folio_fisico='$folio_fisico';";
	$iny_conocer_folio_existente = mysqli_query($mysqli,$conocer_folio_existente) or die (mysqli_error());
	if(mysqli_num_rows($iny_conocer_folio_existente) == 0){
		//No existe folio, se procede a la insercion
		if($tipo_pago == 1){
			//Pago Mensual de Intereses
			$pagoHoy = (conocer_monto_deudor($credito) /100) * conocer_interes_hoy($credito);
			if($monto_pago < $pagoHoy){
				//Se capturara un adeudo
				$adeudo = $pagoHoy - $monto_pago;
				$saldo_capital = conocer_monto_deudor($credito);
				$interes_cobrado = conocer_interes_hoy($credito);
				$insertar_pago = "INSERT into pagos(id_usuario,fecha_captura,id_credito,fecha_pago,monto,tipo_pago,comentarios,folio_fisico,saldo_capital,interes_cobrado,saldo_mes_intereses,modulo_registro,metodo_pago) values(
						'$usuario_captura',
						'$fecha_captura',
						'$credito',
						'$fecha_pago',
						'$monto_pago',
						'$tipo_pago',
						'$comentarios',
						'$folio_fisico',
						'$saldo_capital',
						'$interes_cobrado',
						'$adeudo',
						'$modulo_registro',
						'$metodo_pago'
					);";
				$iny_insertar_pago = mysqli_query($mysqli,$insertar_pago) or die(mysqli_error());
				$insertar_adeudo = "INSERT into adeudos(id_credito,monto,tipo,datetimecaptura,folio_fisico,fecha_aplicacion,comentarios,id_usuario) values (
						'$credito',
						'$adeudo',
						'cargo',
						'$fecha_captura',
						'$folio_fisico',
						'$fecha_pago',
						'$comentarios',
						'$usuario_captura'
					);";
				$iny_insertar_adeudo = mysqli_query($mysqli,$insertar_adeudo) or die(mysqli_error());
				header('Location: pagos.php?info=1');
			}else{
				//Pago mayor o igual se capturara de manera regular
				$saldo_capital = conocer_monto_deudor($credito);
				$interes_cobrado = conocer_interes_hoy($credito);
				$insertar_pago = "INSERT into pagos(id_usuario,fecha_captura,id_credito,fecha_pago,monto,tipo_pago,comentarios,folio_fisico,saldo_capital,interes_cobrado,saldo_mes_intereses,modulo_registro,metodo_pago) values(
						'$usuario_captura',
						'$fecha_captura',
						'$credito',
						'$fecha_pago',
						'$monto_pago',
						'$tipo_pago',
						'$comentarios',
						'$folio_fisico',
						'$saldo_capital',
						'$interes_cobrado',
						'0',
						'$modulo_registro',
						'$metodo_pago'
					);";
				$iny_insertar_pago = mysqli_query($mysqli,$insertar_pago) or die(mysqli_error());
				header('Location: pagos.php?info=1');
			}
		}
		if($tipo_pago == 2){
			//Pago de Capital
			$saldo_capital = conocer_monto_deudor($credito);
			$query= "INSERT INTO pagos (id_usuario,fecha_captura,id_credito,fecha_pago,monto,tipo_pago,comentarios,folio_fisico,saldo_capital,modulo_registro,metodo_pago)
	   				VALUES
				('$usuario_captura',
					'$fecha_captura',
					'$credito',
					'$fecha_pago',
					'$monto_pago',
					'$tipo_pago',
					'$comentarios',
	                '$folio_fisico',
	                '$saldo_capital',
					'$modulo_registro',
					'$metodo_pago'
	                );";
		    $resultado= mysqli_query($mysqli,$query) or die(mysqli_error());
			header('Location: pagos.php?info=1');
		}
	}else{
		//Ya hay un folio Registrado
		header('Location: nuevo-pago.php?i=errf');
	}
 ?>

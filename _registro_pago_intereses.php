<?php
	session_start(); // crea una sesion
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	
	date_default_timezone_set('America/Mexico_City');
	include("include/funciones.php");
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	$fecha = date("Y-m-d");
  	$hora = date("G:i:s");

	$credito			= $_POST['id-credito'];
	$monto_pago 		= $_POST['monto-pago'];
	$folio_fisico 		= $_POST['folio-pago'];
	$comentarios		= $_POST['comentarios'];
	$fecha_pago			= $_POST['date'];
	$modulo_registro = $_POST['modulo-registro'];

    $fecha_captura	= $fecha." ".$hora;
	$usuario_captura	= $_SESSION['id_usuario'];
	$separar_fecha = explode("-", $fecha_pago);
	$mes = $separar_fecha[1];
	$ano = $separar_fecha[0];
	$interes_cobrado =  $_POST['interes'];
	$monto_a_pagar =  $_POST['monto-a-pagar'];
	$fecha_aplicar_pago =  $_POST['fecha-aplicar-pago'];
	$separar_fecha_seleccionada = explode("-", $fecha_aplicar_pago);
	$mes_seleccionado = $separar_fecha_seleccionada[1];
	$ano_seleccionado = $separar_fecha_seleccionada[0];

	//Verificar Folio folio-fisico
	$conocer_folio_existente = "select * from pagos where folio_fisico='$folio_fisico';";
	$iny_conocer_folio_existente = mysqli_query($mysqli,$conocer_folio_existente) or die (mysqli_error());
	if(mysqli_num_rows($iny_conocer_folio_existente) == 0){
		//No existe folio, se procede a la insercion
		//Pago Mensual de Intereses
		//Verificar si hay pagos realizado en el mes seleccionado.
		$conocer_pagos_recibidos_mes = "SELECT * FROM pagos WHERE id_credito = '$credito' AND MONTH(fecha_pago)='".$mes_seleccionado."' AND YEAR(fecha_pago) = '".$ano_seleccionado."' and tipo_pago=1;";
		$iny_conocer_pagos_recibidos = mysqli_query($mysqli,$conocer_pagos_recibidos_mes) or die(mysqli_error());
		if(mysqli_num_rows($iny_conocer_pagos_recibidos) > 0 ){
			//Si hay pagosConocer si existen adeudos a la fecha aplicada, si lo hay procedera como pago de adeudo, enc aso conrario como pago normal
			$conocer_adeudos_pagos = "SELECT COALESCE(SUM(saldo_mes_intereses),0) FROM pagos WHERE MONTH(fecha_pago)='".$mes_seleccionado."' AND YEAR(fecha_pago)='".$ano_seleccionado."' AND id_credito='".$credito."';";
			$iny_ConocerAdeudosPagos = mysqli_query($mysqli,$conocer_adeudos_pagos) or die(mysqli_error());
			$f_ConocerAdeudosPagos = mysqli_fetch_row($iny_ConocerAdeudosPagos);
			
			if($f_ConocerAdeudosPagos[0] > 0){
				//Existen Adeudos
				$saldo_capital = conocer_monto_deudor($credito);
				$adeudo = $monto_a_pagar - $monto_pago;
				$insertar_pago = "INSERT into pagos(id_usuario,fecha_captura,id_credito,fecha_pago,monto,tipo_pago,comentarios,folio_fisico,saldo_capital,interes_cobrado,saldo_mes_intereses,modulo_registro) values(
						'$usuario_captura',
						'$fecha_captura',
						'$credito',
						'$fecha_aplicar_pago',
						'$monto_pago',
						'1',
						'$comentarios',
						'$folio_fisico',
						'$saldo_capital',
						'$interes_cobrado',
						'$adeudo',
						'$modulo_registro'
					);";
				$iny_insertar_pago = mysqli_query($mysqli,$insertar_pago) or die(mysqli_error());
				header('Location: pagos.php?info=1');
			}else{
				//no existen adeudos, registrar pago normal
				echo "ERR:NOADREGIST_PAGREG";
			}
		}else{
			//No hay pago recibidos, capturar pago como unico del mes
			$saldo_capital = conocer_monto_deudor($credito);
			$adeudo = $monto_a_pagar - $monto_pago;
			$insertar_pago = "INSERT into pagos(id_usuario,fecha_captura,id_credito,fecha_pago,monto,tipo_pago,comentarios,folio_fisico,saldo_capital,interes_cobrado,saldo_mes_intereses,modulo_registro) values(
					'$usuario_captura',
					'$fecha_captura',
					'$credito',
					'$fecha_aplicar_pago',
					'$monto_pago',
					'1',
					'$comentarios',
					'$folio_fisico',
					'$saldo_capital',
					'$interes_cobrado',
					'$adeudo',
					'$modulo_registro'
				);";
			$iny_insertar_pago = mysqli_query($mysqli,$insertar_pago) or die(mysqli_error());
			header('Location: pagos.php?info=1');
		}
	}else{
		//Ya hay un folio Registrado
		header('Location: estado_cuenta.php?id='.$credito.'&info=errf');
	}
 ?>

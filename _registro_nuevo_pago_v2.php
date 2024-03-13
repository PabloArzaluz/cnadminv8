<?php
	session_start(); // crea una sesion
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	error_reporting(E_ALL); ini_set("display_errors", 1);
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
            //Obtener Informacion de Pago 
            $InformacionCredito = "SELECT
                                    c.id_creditos,
                                    c.monto as monto_credito,
                                    c.monto - COALESCE(SUM(CASE WHEN p.tipo_pago = 2 THEN p.monto ELSE 0 END), 0) AS saldo_credito,
                                    c.interes
                                FROM
                                    creditos c
                                LEFT JOIN
                                    pagos p ON c.id_creditos = p.id_credito where id_creditos=$credito";
            $iny_InformacionCredito = mysqli_query($mysqli,$InformacionCredito) or die(mysqli_error());
            $f_InformacionCredito = mysqli_fetch_assoc($iny_InformacionCredito); 
            $monto_a_pagar_regular = ($f_InformacionCredito["saldo_credito"]/100)*$f_InformacionCredito["interes"];
            $excedente = round($monto_pago - $monto_a_pagar_regular,2);
            
            $monto_registrar_pago = 0;
            if($excedente > 0){
                $monto_registrar_pago =  $monto_a_pagar_regular;
            }else{
                $monto_registrar_pago = $monto_pago;
            }
			//$pagoHoy = (conocer_monto_deudor($credito) /100) * conocer_interes_hoy($credito);
            $saldo_capital = conocer_monto_deudor($credito);
            $interes_cobrado = conocer_interes_hoy($credito);
            $insertar_pago = "INSERT into pagos(id_usuario,fecha_captura,id_credito,fecha_pago,monto,tipo_pago,comentarios,folio_fisico,saldo_capital,interes_cobrado,saldo_mes_intereses,modulo_registro,metodo_pago) values(
                    '$usuario_captura',
                    '$fecha_captura',
                    '$credito',
                    '$fecha_pago',
                    '$monto_registrar_pago',
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
            if($_POST['monto-pago-moratorio'] != ""){
                $monto_pago_moratorio = $_POST['monto-pago-moratorio'];
                //Hay excedente
                $insertar_pago_moratorio = "INSERT into pagos(id_usuario,fecha_captura,id_credito,fecha_pago,monto,tipo_pago,comentarios,folio_fisico,saldo_capital,interes_cobrado,saldo_mes_intereses,modulo_registro,metodo_pago) values(
                    '$usuario_captura',
                    '$fecha_captura',
                    '$credito',
                    '$fecha_pago',
                    '$monto_pago_moratorio',
                    '4',
                    'MORATORIO-$comentarios',
                    'M-$folio_fisico',
                    '$saldo_capital',
                    '$interes_cobrado',
                    '0',
                    '$modulo_registro',
                    '$metodo_pago'
                );";
                $iny_insertar_pago_moratorio = mysqli_query($mysqli,$insertar_pago_moratorio) or die(mysqli_error());
                //Inserta log para monitoreo

                $insertar_log_pago_moratorio = "INSERT into log_pago_moratorio(folio_pago,fecha_captura,monto_original) values(
                    'M-$folio_fisico',
                    '$fecha_captura',
                    '$monto_pago'
                );";
                $iny_insertar_log_pago_moratorio = mysqli_query($mysqli,$insertar_log_pago_moratorio) or die(mysqli_error());
            }
			header('Location: pagos.php?info=1');
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
        if($tipo_pago == 4){
			//Pago de Moratorio
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
        
		header('Location: nuevo-pago_v2.php?i=errf');
	}
 ?>

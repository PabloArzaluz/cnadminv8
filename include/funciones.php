<?php
	ini_set("error_reporting", E_ALL & ~E_DEPRECATED);

	date_default_timezone_set('America/Mexico_City');
	$fecha = date("Y-m-d");
  	$hora = date("G:i:s");


  	//Muestra la cantidad que resta a pagar para un credito
  	function conocer_monto_deudor($credito) {
  		$link = Conecta();
	  $query = "
			SELECT
                creditos.id_creditos,
                clientes.nombres,
                clientes.apaterno,
                clientes.amaterno,
                creditos.fecha_prestamo,
                creditos.status,
                creditos.monto,
                creditos.interes,
                creditos.pago_mensual,
                creditos.folio,
                creditos.interes_moratorio
            FROM
                creditos
            INNER JOIN
                clientes
            ON
                creditos.id_cliente = clientes.id_clientes
                where creditos.id_creditos = '".strtolower($credito)."' and (creditos.status = 1 OR creditos.status =3 OR creditos.status =4 OR creditos.status =2 );
            ";
			$results = mysql_query($query,$link) or die(mysql_error());
			$fCredito = mysql_fetch_row($results);

			$TotalPagosCapital = "SELECT sum(monto) from pagos where id_credito= ".$credito." and tipo_pago= 2;";
			$iny_TotalPagosCapital = mysql_query($TotalPagosCapital, $link) or die(mysql_error());
			$fTotalPagosCapital = mysql_fetch_row($iny_TotalPagosCapital);

			if($fTotalPagosCapital[0] == ""){
				$totalPagos = 0;
				$sumaSaldoTotal = $fCredito[6];
			}else{
				$totalPagos = $fTotalPagosCapital[0];
				$sumaSaldoTotal = $fCredito[6] - $totalPagos;
			}

			return $sumaSaldoTotal;
	}


	function conocer_interes_hoy($credito){
		$link = Conecta();
		$query = "
		SELECT
            creditos.id_creditos,
            clientes.nombres,
            clientes.apaterno,
            clientes.amaterno,
            creditos.fecha_prestamo,
            creditos.status,
            creditos.monto,
            creditos.interes,
            creditos.pago_mensual,
            creditos.folio,
            creditos.interes_moratorio
        FROM
            creditos
        INNER JOIN
            clientes
        ON
            creditos.id_cliente = clientes.id_clientes
            where creditos.id_creditos = '".strtolower($credito)."' and (creditos.status = 1 OR creditos.status =3);
        ";
		$results = mysql_query($query,$link) or die(mysql_error());
		$fCredito = mysql_fetch_row($results);


		if($fCredito[10] == ""){
			$interesMoratorio = $fCredito[7];
		}else{
			$interesMoratorio = $fCredito[10];
		}
		$diaLimitePago = date('d', strtotime($fCredito[4] . ' +3 day'));
		$fechaLimitePago = date("Y").'/'.date("m").'/'.$diaLimitePago;
		$fecha_maxima_pago = strtotime($fechaLimitePago);
		$fecha_actual = strtotime(date("Y/m/d"));

		if($fecha_actual < $fecha_maxima_pago){
			//A tiempo

			return $fCredito[7];
		}else{
			//Considerar Interes Moratorio

			return $interesMoratorio;
		}
	}

	function conocer_informacion_credito($credito){
		$dbhost="localhost";
		$dbuser="credinie_portalu";
		$dbpass="sZ;ZcC&XlfAv";
		$dbname="credinie_portal_sl";
		$mysqli = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
		if (mysqli_connect_errno($mysqli)) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		$consultar_credito = "select * from creditos where id_creditos = '$credito';";
		$iny_consultar_credito = mysqli_query($mysqli,$consultar_credito) or die (mysqli_error());
		$fila_credito = mysqli_fetch_row($iny_consultar_credito);
		return $fila_credito;
	}

	function horafecha(){
		$fecha = date("Y-m-d");
  		$hora = date("G:i:s");
		$fechahora = $fecha." ".$hora;
		return $fechahora;
	}

	function conocer_estatus_credito_cadena($credito){
		$estatusCred = "";
		if($credito == 1){
			$estatusCred = "Activo";
		}
		if($credito == 2){
			$estatusCred = "Finalizado";
		}
		if($credito == 3){
			$estatusCred = "Juridico";
		}
		if($credito==4){
			$estatusCred = "Vendidos";
		} 
		return $estatusCred;
	}

	//conocer_monto_deudor(1);
	//conocer_interes_hoy(5);

?>
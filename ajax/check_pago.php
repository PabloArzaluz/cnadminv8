<?php
	session_start(); // crea una sesion
	ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
	date_default_timezone_set('America/Mexico_City');
	setlocale(LC_ALL, 'es_MX.UTF-8');
	
	include("../conf/conecta.inc.php");
	include("../conf/config.inc.php");
	$link = Conecta();
if($_REQUEST)
{
	$monto 	= $_REQUEST['monto']; //monto
	$tipoPago 	= $_REQUEST['tipo']; //tipo de PAgo
	$credito 	= $_REQUEST['credito']; //tipo de PAgo

	if($monto != ""){
		if($tipoPago != ""){
			if($credito != ""){
				if($tipoPago == 2){
					//Pago de Capital
					echo "<div class='alert alert-success'>
						<strong>Informacion.</strong> Se capturara la cantidad de <b>$".number_format(($monto),2)."</b> como <b>Pago a Capital</b>.
					</div>";
				}
				if($tipoPago == 1){
					//Pago de Intereses
						//Conocer Pago al dia de hoy
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
						if($fCredito[10] == ""){
							$interesMoratorio = $fCredito[7];
						}else{
							$interesMoratorio = $fCredito[10];
						}
						$diaLimitePago = date('d', strtotime($fCredito[4] . ' +3 day'));
						$fechaLimitePago = date("Y").'/'.date("m").'/'.$diaLimitePago;
						$fecha_maxima_pago = strtotime($fechaLimitePago);
						$fecha_actual = strtotime(date("Y/m/d"));
						echo "<table class='table'>";
						if($fecha_actual < $fecha_maxima_pago){
							//A tiempo
							$estado_pago = 1;
							$monto_a_pagar = ($sumaSaldoTotal / 100) * $fCredito[7];
							echo "<tr><td colspan='2'><center><span class='label label-primary'>Pago a Tiempo</span></center></tr>";
							echo "<tr><td>Monto a pagar al dia de HOY</td><td>$".number_format(($monto_a_pagar),2)."</td></tr>";
							echo "<tr><td>Pago recibido por </td><td>$".number_format(($monto),2)."</td></tr>";
							echo "</table>";
							
							if($monto > $monto_a_pagar){
								echo "<div class='alert alert-warning'>
										<strong>Pago Superior.</strong> El pago recibido es mayor al que se requiere este mes, de ser necesario captura un segundo pago como <b>Pago a Capital</b>, o bien si tiene adeudos captura el mismo como <b>Pago de Adeudos</b>.
									</div>";
							}

							if($monto == $monto_a_pagar){
								echo "<div class='alert alert-success'>
										<strong>Pago Correcto.</strong> La cantidad es la requerida.
									</div>";
							}

							if($monto < $monto_a_pagar){
								$monto_a_adeudo = $monto_a_pagar - $monto;	
								echo "<div class='alert alert-danger'>
										<strong>Pago Incompleto.</strong> Se capturara el monto de <b>$".number_format(($monto_a_adeudo),2)."</b> en <b>Adeudos</b>.
									</div>";
							}
						}else{
							//Considerar Cobrar Interes Moratorio
							$estado_pago = 2;
							$monto_a_pagar = ($sumaSaldoTotal /100) * $interesMoratorio;
							echo "<tr><td colspan='2'><center><span class='label label-warning'>Pago Extemporaneo</span></center></td></tr>";
							echo "<tr><td>Monto a Pagar al dia de hoy:</td><td>$".number_format(($monto_a_pagar),2)."</td></tr>";
							$monto_a_pagar_regularmente = ($sumaSaldoTotal / 100) * $fCredito[7];
							echo "<tr><td>Monto a pagar regularmente:</td><td>$".number_format(($monto_a_pagar_regularmente),2)."<td></tr>";
							echo "<tr><td>Pago recibido por: </td><td>$".number_format(($monto),2)."</td></tr>";
							echo "</table>";
							
							if($monto < $monto_a_pagar){
								$monto_a_adeudo = $monto_a_pagar - $monto;
								echo "<div class='alert alert-danger'>
										<strong>Pago Incompleto.</strong> Se capturara el monto de <b>$".number_format(($monto_a_adeudo),2)."</b> en <b>Adeudos</b>.
									</div>";
							}
							if($monto > $monto_a_pagar){
								echo "<div class='alert alert-warning'>
										<strong>Pago Superior.</strong> El pago recibido es mayor al que se requiere este mes, de ser necesario captura un segundo pago como <b>Pago a Capital</b>, o bien si tiene adeudos captura el mismo como <b>Pago de Adeudos</b>.
									</div>";
							}
							if($monto == $monto_a_pagar){
								echo "<div class='alert alert-success'>
										<strong>Pago Correcto.</strong> La cantidad es la requerida.
									</div>";
							}
						}



				
				}
				
			}
		}
	}	
}

?>
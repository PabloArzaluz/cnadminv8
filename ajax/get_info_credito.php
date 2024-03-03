<?php
	session_start(); // crea una sesion
	ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
	date_default_timezone_set('America/Mexico_City');
	setlocale(LC_ALL, 'es_MX.UTF-8');

	sleep(1);

	//include('dbcon.php');
	include("../conf/conecta.inc.php");
	include("../conf/config.inc.php");
	include("../include/funciones.php");
	$link = Conecta();
	$date_actual = date("Y-m-d");
if($_REQUEST)
{
	$username 	= $_REQUEST['username'];
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
                    where creditos.id_creditos = '".strtolower($username)."' and (creditos.status = 1 OR creditos.status =3);
                ";
	$results = mysql_query($query,$link) or die(mysql_error());
	if($username == ""){
		echo '<span class="label label-warning"><input type="hidden" id="folio_validador" value="" required><i class="fa fa-exclamation-triangle fa-fw"></i> Introduce un numero de Credito</span><script type="text/javascript">document.getElementById("folio").value="";</script>';
	return 0;
	}
	if(mysql_num_rows($results) > 0) // not available
	{
		$fila_info = mysql_fetch_row($results);
		$conocer_saldo_restante = "SELECT sum(monto) from pagos where id_credito= ".$fila_info[0]." and tipo_pago= 2;";
		$iny_conocerSaldoRestante = mysql_query($conocer_saldo_restante,$link) or die(mysql_error());
		$fSaldoRestante = mysql_fetch_row($iny_conocerSaldoRestante); 
		
		if($fSaldoRestante[0] == ""){
			$totalPagos = 0;
			$sumaSaldoTotal = $fila_info[6];
		}else{
			$totalPagos = $fSaldoRestante[0];
			$sumaSaldoTotal = $fila_info[6] - $totalPagos;
		}

		echo '
			<table class="table table-striped table-condensed table-bordered">
				<tr><td><strong>Numero de Credito</strong></td><td>'.$fila_info[9].'</td></tr>';

		if($fila_info[5] == 1){
			echo '<tr><td><strong>Estatus</strong></td><td><span class="label label-success">Activo</span></td></tr>';
        }
        if($fila_info[5]== 2){
        	echo '<tr><td><strong>Estatus</strong></td><td><span class="label label-default">Finalizado</span></td></tr>';
        }
        if($fila_info[5] == 3){
        	echo '<tr><td><strong>Estatus</strong></td><td><span class="label label-danger">En Juridico</span></td></tr>';
        }

				
		echo '	<tr><td><strong>Interes</strong></td><td>'.$fila_info[7].'%</td></tr>
				<tr><td><strong>Fecha de Inicio</strong></td><td>'.date("d/m/Y",strtotime($fila_info[4])).'</td></tr>';

		if($fila_info[10] == ""){
			echo '<tr><td><strong>Interes Moratorio</strong></td><td> <i><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No Especificado</i></td></tr>';
			$interesMoratorio = $fila_info[7];
		}else{
			echo '<tr><td><strong>Interes Moratorio</strong></td><td>'.$fila_info[10].'%</td></tr>';
			$interesMoratorio = $fila_info[10];
		}


		echo '	<tr><td><strong>Monto Inicial</strong></td><td>$ '.number_format(($fila_info[6]),2).'</td></tr>
				<tr><td><strong>Saldo Actual</strong></td><td>$ '.number_format(($sumaSaldoTotal),2).'</td></tr>';

		$diaLimitePago = date('d', strtotime($fila_info[4] . ' +3 day'));
		$fechaLimitePago = date("Y").'/'.date("m").'/'.$diaLimitePago;
		$fecha_maxima_pago = strtotime($fechaLimitePago);
		$fecha_actual = strtotime(date("Y/m/d"));

		if($fecha_actual < $fecha_maxima_pago){
			//A tiempo
			$cobro_tipo = '<span class="label label-primary">A tiempo</span>';
			$monto_a_pagar = ($sumaSaldoTotal / 100) * $fila_info[7];
		}else{
			//Considerar Cobrar Interes Moratorio
			$cobro_tipo = '<span class="label label-warning">Pago Extemporaneo</span>';
			$monto_a_pagar = ($sumaSaldoTotal /100) * $interesMoratorio;
		}

		echo '	<tr><td><strong>Fecha Limite de Pago</strong></td><td>'.strftime('%A,  %d de %B del %Y',strtotime($fechaLimitePago)).'</td></tr>';

		echo "<tr><td><strong>Meses con Adeudos</strong></td><td>";
        //Conocer Meses transcurridos
        $date_inicial= new DateTime($fila_info[4]);
        $date_final= new DateTime($date_actual);
        $unMes= new DateInterval("P1M");
        $contadorMeses = 0;
        while($date_inicial<=$date_final)
        {
          	$mes = $date_inicial->format('m');
            $ano = $date_inicial->format('Y');
            $date_completa = $date_inicial->format('d/m/Y');
            $conocer_pago_mes = "select * from pagos where year(fecha_pago)='".$ano."' and month(fecha_pago)='".$mes."' and id_credito='".$fila_info[0]."';";
            $iny_conocer_pago_mes = mysql_query($conocer_pago_mes,$link) or die(mysql_error());

            if(mysql_num_rows($iny_conocer_pago_mes)>0){
                
               while($fila = mysql_fetch_array($iny_conocer_pago_mes)){
                   if($fila[6] != 1){
                         	
                         $date_inicial->format('d/m/Y');
                      	 $contadorMeses ++;
                     }
          		}
            }else{
                $mes_actual = date("m");
                $anio_actual = date("Y");
                $date_inicial->format('d/m/Y');
                $contadorMeses++;
            }
            $date_inicial->add($unMes);
         }
         if($contadorMeses>0){
         	echo "<span class='label label-danger'>".$contadorMeses." Mes(es) con adeudo</span> <a href='#' class='' data-toggle='modal' data-target='#empModalAdeudosMeses'>(Mostrar Meses con Adeudos)</a>";
         }else{
         	echo "<span class='label label-primary'>".$contadorMeses." Mes(es) con adeudo</span>";
         }
         
         //Fin Meses trasncrurridos                                       
        echo "</td></tr>";
		
		//Consultar Adeudos
		$conocer_adeudos_cargos = "select COALESCE(sum(monto),0) as total_cargos from adeudos WHERE tipo='cargo' and id_credito='".$fila_info[0]."';";
		$iny_conocer_adeudos_cargos = mysql_query($conocer_adeudos_cargos,$link) or die(mysql_error());
		$fConocerAdeudosCargos = mysql_fetch_row($iny_conocer_adeudos_cargos);
		$fConocerAdeudosCargos[0];

		$conocer_adeudos_abonos = "select COALESCE(sum(monto),0) as total_abonos from pagos WHERE tipo_pago='3' and id_credito='".$fila_info[0]."';";
		$iny_conocer_adeudos_abonos = mysql_query($conocer_adeudos_abonos,$link) or die(mysql_error());
		$fConocerAdeudosAbonos = mysql_fetch_row($iny_conocer_adeudos_abonos);
		$fConocerAdeudosAbonos[0];
		$totalSaldoAdeudos = $fConocerAdeudosCargos[0] - $fConocerAdeudosAbonos[0]; 

		echo '	<tr><td><strong>Otros Adeudos</strong></td><td>$ '.number_format(($totalSaldoAdeudos),2).' <a href="#"" class="" data-toggle="modal" data-target="#empModalAdeudos">(Mostrar Otros Adeudos)</a></td></tr>';
		
		echo '	<tr><td><strong>Monto a Pagar en este MES</strong></td><td>$ '.number_format(($monto_a_pagar),2).' '.$cobro_tipo.'</td></tr>';
		echo '	</table>
		';
		
		echo "<div class='modal fade' id='empModalAdeudos' role='dialog'>
			    <div class='modal-dialog modal-sm'>
			 
			     <!-- Modal content-->
			     <div class='modal-content'>
			      <div class='modal-header'>
			        <button type='button' class='close' data-dismiss='modal'>&times;</button>
			        <h4 class='modal-title'>Mostrar Adeudos</h4>
			      </div>
			      <div class='modal-body2'>";
		$conocer_adeudos_cargos_mostrar = "select * from adeudos where id_credito='$username';";
		$iny_conocer_adeudos_cargos_mostrar = mysql_query($conocer_adeudos_cargos_mostrar,$link) or die (mysql_error());
		echo "<table class='table'>";
		echo "<thead><th>Fecha</th><th>Comentarios</th><th>Monto</th></thead>";
		$sumaCargos = 0;
		if(mysql_num_rows($iny_conocer_adeudos_cargos_mostrar) > 0){
			
			while($fMostarAdeudosCargos = mysql_fetch_array($iny_conocer_adeudos_cargos_mostrar)){
				echo "<tr class='warning'><td>$fMostarAdeudosCargos[6]</td><td>$fMostarAdeudosCargos[7]</td><td>$".number_format(($fMostarAdeudosCargos[2]),2)."</td></tr>";
				$sumaCargos += $fMostarAdeudosCargos[2];
			}
		}
		$conocer_adeudos_abonos_mostrar = "select * from pagos where id_credito='$username' and tipo_pago='3';";
		$iny_conocer_adeudos_abonos_mostrar = mysql_query($conocer_adeudos_abonos_mostrar,$link) or die (mysql_error());
		$sumaAbonos = 0;
		if(mysql_num_rows($iny_conocer_adeudos_abonos_mostrar) > 0){
			
			while($fMostarAdeudosAbonos = mysql_fetch_array($iny_conocer_adeudos_abonos_mostrar)){
				echo "<tr class='success'><td>$fMostarAdeudosAbonos[4]</td><td>$fMostarAdeudosAbonos[7]</td><td>- $".number_format(($fMostarAdeudosAbonos[5]),2)."</td></tr>";
				$sumaAbonos += $fMostarAdeudosAbonos[5];
			}
		}
		$totalMostrarSaldo = $sumaCargos - $sumaAbonos;
		echo "<thead><th></th><th>Suma</th><th>$".number_format(($totalMostrarSaldo),2)."</th></thead>";
		echo "</table>";		

		echo "	      </div>
			      <div class='modal-footer'>
			       <button type='button' class='btn btn-success' data-dismiss='modal'>OK</button>
			      </div>
			     </div>
			    </div>
			   </div>";

		//Modal de MEses con adeudos
		echo "<div class='modal fade' id='empModalAdeudosMeses' role='dialog'>
			    <div class='modal-dialog modal-sm'>
			 
			     <!-- Modal content-->
			     <div class='modal-content'>
			      <div class='modal-header'>
			        <button type='button' class='close' data-dismiss='modal'>&times;</button>
			        <h4 class='modal-title'>Mostrar Meses con Adeudos</h4>
			      </div>
			      <div class='modal-body2'>";
					//Conocer Meses transcurridos
				        $datemodal_inicial= new DateTime($fila_info[4]);
				        $datemodal_final= new DateTime($date_actual);
				        $unMesModal= new DateInterval("P1M");
				        $contadorMesesModal = 0;
				        echo "<table class='table'>";
				        echo "<thead><th><center>Mes</center></th><th><center>Monto a Pagar en el Mes</center></th></thead>";
				        while($datemodal_inicial<=$datemodal_final)
				        {
				          	$mes = $datemodal_inicial->format('m');
				            $ano = $datemodal_inicial->format('Y');
				            $datemodal_completa = $datemodal_inicial->format('d/m/Y');
				            $conocer_pago_mes = "select * from pagos where year(fecha_pago)='".$ano."' and month(fecha_pago)='".$mes."' and id_credito='".$fila_info[0]."';";
				            $iny_conocer_pago_mes = mysql_query($conocer_pago_mes,$link) or die(mysql_error());

				            if(mysql_num_rows($iny_conocer_pago_mes)>0){
				                
				               while($fila = mysql_fetch_array($iny_conocer_pago_mes)){
				                   if($fila[6] != 1){
				                        $montoAPagar = (conocer_monto_deudor($fila_info[0])/100)* $interesMoratorio;
				                         
				                         echo "<tr><td><center>".$datemodal_inicial->format('d/m/Y')."</center><td><center>$".number_format(($montoAPagar),2)."</center></tr>";
				                      	 $contadorMesesModal ++;
				                     }
				          		}
				            }else{
				                $mes_actual = date("m");
				                $anio_actual = date("Y");
				                $montoAPagar = (conocer_monto_deudor($fila_info[0])/100)* $interesMoratorio;
				                echo "<tr><td><center>".$datemodal_inicial->format('d/m/Y')."</center></td><td><center>$".number_format(($montoAPagar),2)."</center></td></tr>";
				                $contadorMesesModal++;
				            }
				            $datemodal_inicial->add($unMesModal);
				         }
				         echo "</table>";
				         
				         //Fin Meses trasncrurridos     
		echo "	      </div>
			      <div class='modal-footer'>
			       <button type='button' class='btn btn-success' data-dismiss='modal'>OK</button>
			      </div>
			     </div>
			    </div>
			   </div>";
		//Fin Modal MEses con adeudos

		//echo '<span class="label label-danger"><input type="hidden" id="folio_validador" value=""><i class="fa fa-times fa-fw"></i> Numero de Credito ya Registrado</span><script type="text/javascript">document.getElementById("folio").value="";</script>';
	}
	else
	{
		//echo '<span class="label label-success"><input type="hidden" id="folio_validador" value="0"><i class="fa fa-check fa-fw"></i> Numero de Credito Disponible</span>';
	}
	
}
mysql_close($link);
?>
<?php
	session_start(); // crea una sesion
	error_reporting(E_ALL); ini_set("display_errors", 1);
	
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/functions.php");
	
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	$pagina_actual="dashboard";
    date_default_timezone_set('America/Mexico_City');
    setlocale(LC_ALL, 'es_MX.UTF-8');
	$fecha_actual = date("Y-m-d");
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!-->
<html lang="es" class="no-js">
<!--<![endif]-->

<head>
	<title>Dashboard | Credinieto</title>
	<?php
		include("include/head.php");
	?>
	<meta name="robots" content="noindex">
</head>

<body class="sidebar-fixed topnav-fixed dashboard4">
	<!-- WRAPPER -->
	<div id="wrapper" class="wrapper">
		<?php
			include("include/top-bar.php");
			include("include/left-sidebar.php");
		 ?>
		<!-- MAIN CONTENT WRAPPER -->
		<div id="main-content-wrapper" class="content-wrapper ">
			<div class="row">
				<div class="col-lg-4 ">
					<ul class="breadcrumb">
						<li><i class="fa fa-home"></i><a href="dashboard.php">Inicio</a></li>
						<li class="active">Dashboard</li>
					</ul>
				</div>
			</div>
			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>DASHBOARD</h2>
					<em>pagina principal</em>
				</div>
				<div class="main-content">
				


                                <?php
                                    $dia = date("d");
                                    $mes = date("m");
                                    $ano = date("Y");
                                   	$dia4 = date('d', strtotime($fecha_actual . ' +2 day'));
                                   	$diasegundo = date('d', strtotime($fecha_actual . ' +1 day'));
                                    $conocer_monto_a_cobrar_hoy = "select sum(pago_mensual) from creditos where day(fecha_prestamo)='$dia' and status=1;";
                                    $iny_conocer_monto_a_cobrar_hoy = mysqli_query($mysqli,$conocer_monto_a_cobrar_hoy) or die(mysqli_error());
                                    $row_monto_cobrar_hoy = mysqli_fetch_row($iny_conocer_monto_a_cobrar_hoy);

                                    if($row_monto_cobrar_hoy[0] != ""){
                                        $monto_total_hoy = $row_monto_cobrar_hoy[0];
                                    }else{
                                        $monto_total_hoy = 0;
                                    }

                                    //Cobrado Actualmente

                                    $conocer_cobrado_hoy = "select sum(monto) from pagos where day(fecha_captura)='$dia' and month(fecha_captura)='$mes' and year(fecha_captura)='$ano' and tipo_pago='1';";
                                    $iny_conocer_cobrado = mysqli_query($mysqli,$conocer_cobrado_hoy) or die(mysqli_error());
                                    $row_monto_cobrado = mysqli_fetch_row($iny_conocer_cobrado);
                                    if($row_monto_cobrado[0] != ""){
                                        $monto_cobrado = $row_monto_cobrado[0];
                                    }else{
                                        $monto_cobrado = 0;
                                    }

                                    //Cobrado en el Mes de Intereses
                                    $mes = date("m");
                                    $conocer_cobrado_mes_intereses = "select sum(monto) from pagos where month(fecha_captura)='$mes' and year(fecha_captura)='$ano'and tipo_pago='1';";
                                    $iny_conocer_cobrado_mes_intereses = mysqli_query($mysqli,$conocer_cobrado_mes_intereses) or die(mysqli_error());
                                    $row_monto_cobrado_mes_intereses = mysqli_fetch_row($iny_conocer_cobrado_mes_intereses);
                                    if($row_monto_cobrado_mes_intereses[0] != ""){
                                        $monto_cobrado_mes_intereses = $row_monto_cobrado_mes_intereses[0];
                                    }else{
                                        $monto_cobrado_mes_intereses = 0;
                                    }

                                     //Cobrado en el Mes de Capital

                                    $conocer_cobrado_mes_capital = "select sum(monto) from pagos where month(fecha_captura)='$mes' and year(fecha_captura)='$ano'and tipo_pago='2';";
                                    $iny_conocer_cobrado_mes_capital = mysqli_query($mysqli,$conocer_cobrado_mes_capital) or die(mysqli_error());
                                    $row_monto_cobrado_mes_capital = mysqli_fetch_row($iny_conocer_cobrado_mes_capital);
                                    if($row_monto_cobrado_mes_capital[0] != ""){
                                        $monto_cobrado_mes_capital = $row_monto_cobrado_mes_capital[0];
                                    }else{
                                        $monto_cobrado_mes_capital = 0;
                                    }
                                ?>
				<?php
					if(validarAccesoModulos('permiso_dashboard_indicador_creditosmes') == 1) {
				?>
					<div class="row bottom-60px">
						<div class="col-md-3">
							<div class="investment-summary text-right">
								<span class="info-label">Total por Cobrar Hoy</span>
								<span class="inv-green"><strong>$ <?php echo number_format(($monto_total_hoy),2); ?></strong> <i class="fa fa-caret-up"></i></span> <br><span class="percentage">Actual: $ <?php echo number_format(($monto_cobrado),2); ?></span>
							</div>
						</div>

						<div class="col-md-3">
							<?php
									echo '
									<div class="investment-summary text-right">
										<span class="info-label">Cobrado en el Mes Intereses</span>
										<span class="inv-green"><strong>$ '.number_format(($monto_cobrado_mes_intereses),2).'</strong> <i class="fa fa-caret-up"></i></span>
									</div>
									';

							 ?>
						</div>
						<div class="col-md-3">
							<div class="investment-summary text-right">
								<span class="info-label">Cobrado en el Mes Capital</span>
								<span class="inv-green"><strong>$ <?php echo number_format(($monto_cobrado_mes_capital),2); ?></strong> <i class="fa fa-caret-up"></i></span>
							</div>

						</div>
						
							<div class="col-md-3">
							<div class="investment-summary text-right">
							<span class="info-label">Creditos del Mes</span>
								<?php
									$mesActual = date("m");
									$anioActual = date("Y"); 
									
									$dateObj   = DateTime::createFromFormat('!m', $mesActual);
									$monthName = $dateObj->format('F'); // March
									
									$qry_ConocerCreditosColocados = "SELECT sum(MONTO) FROM creditos WHERE MONTH(fecha_captura) = '$mesActual' and year(fecha_captura) = '$anioActual';";
									$iny_conocer_colocados_mes_actual = mysqli_query($mysqli,$qry_ConocerCreditosColocados) or die(mysqli_error());
									$row_conocer_colocados_mes_actual = mysqli_fetch_row($iny_conocer_colocados_mes_actual);
								?>
								<span class="inv-green"><strong>$ <?php echo number_format(($row_conocer_colocados_mes_actual[0]),2); ?></strong> <i class="fa fa-caret-up"></i></span>
								
							</div>

						</div>
						
						
						
					</div>
				<?php } ?>
				<?php include("include/messages.php"); ?>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-4">
                            <h3>Proximos Pagos (proximos 3 dias)</h3>
                        </div>
                    </div>
                    <?php
                        $conocer_proximos_pagos = "SELECT
                            creditos.id_creditos,
                            clientes.nombres,
                            clientes.apaterno,
                            clientes.amaterno,
                            date_format(creditos.fecha_prestamo, '%d-%m-%Y') AS fecha_prestamo,
                            creditos.status,
                            creditos.monto,
                            creditos.interes,
                            creditos.pago_mensual,
                            creditos.folio,
							clientes.categoria
                        FROM
                            creditos
                        INNER JOIN
                            clientes
                        ON
                            creditos.id_cliente = clientes.id_clientes
                        WHERE
                        (DAY(fecha_prestamo) = '$dia') and creditos.status = 1 OR
						(DAY(fecha_prestamo) = '$dia4') and creditos.status = 1 OR
						(DAY(fecha_prestamo) = '$diasegundo') and creditos.status = 1
                        order by fecha_prestamo asc;";
                        $iny_conocer_proximos_pagos = mysqli_query($mysqli,$conocer_proximos_pagos) or die(mysqli_error());

                    ?>
					<div class="row bottom-60px">
						<div class="col-md-10 col-md-offset-1">
							<table class="table table-condensed table-bordered">
								<thead>
									<tr>
										<th># de Credito</th>
										<th>Fecha Inicial de Credito</th>
										<th>Cliente</th>
										<th>Saldo Credito</th>
										<th>Interes</th>
										<th>Pago Interes Actual</th>
									</tr>
								</thead>
								<tbody>
                                <?php
                                    if(mysqli_num_rows($iny_conocer_proximos_pagos) > 0){
							              while($row_proximos_pagos = mysqli_fetch_array($iny_conocer_proximos_pagos)){
                                            echo "<tr>

                                                    <td><a href='detalle-credito.php?id=$row_proximos_pagos[0]'>[#$row_proximos_pagos[9]]</a></td>
                                                    <td>".date("d/m/Y",strtotime($row_proximos_pagos[4]))."</td>
													<td>$row_proximos_pagos[1] $row_proximos_pagos[2] $row_proximos_pagos[3]";
													categoriaClienteHTML($row_proximos_pagos[10]);
													echo"</td>";
                                                    $conocerSaldoRestante = "SELECT sum(monto) from pagos where id_credito= $row_proximos_pagos[0] and tipo_pago= 2;";
		                                            $iny_conocerSaldoRestante = mysqli_query($mysqli,$conocerSaldoRestante) or die(mysqli_error());
						                            $fSaldoRestante = mysqli_fetch_row($iny_conocerSaldoRestante);
						                            $saldoRestante = $row_proximos_pagos[6] - $fSaldoRestante[0];

                                                    echo "<td><span title='Monto Credito: $ ".number_format(($row_proximos_pagos[6]),2)."' class='top' data-toggle='tooltip'>$ ".number_format(($saldoRestante),2)."</span></td>
                                                    <td>$row_proximos_pagos[7]%</td>";
                                                    $pagoActualInteres = ($saldoRestante/100) * $row_proximos_pagos[7];
                                                    echo "<td>$".number_format(($pagoActualInteres),2)."</td>
                                                    </tr>";
                                          }
                                    }else{
                                        echo "<tr><td colspan='6'>No hay proximos creditos</td></tr>";
                                    }
                                ?>
                                <?php
                                	//Aun con adeudo
										$conocer_morosos = "SELECT
                                				creditos.id_creditos,
					                            clientes.nombres,
					                            clientes.apaterno,
					                            clientes.amaterno,
					                            date_format(creditos.fecha_prestamo, '%d-%m-%Y') AS fecha_prestamo,
					                            creditos.status,
					                            creditos.monto,
					                            creditos.interes,
					                            creditos.pago_mensual,
					                            creditos.folio,
												clientes.categoria
					                            FROM creditos
					                            INNER JOIN
						                            clientes
						                        ON
						                            creditos.id_cliente = clientes.id_clientes
                                				WHERE creditos.id_creditos
                                				NOT IN
                                				(SELECT id_credito FROM pagos where month(fecha_pago) = $mes and year(fecha_pago) = $ano and tipo_pago=1)
                                				AND (DAY(fecha_prestamo) >= '01')
                                				AND (DAY(fecha_prestamo) < '$dia')
                                				and creditos.status = 1
                                				order by fecha_prestamo desc;
                                	";
	                               	$iny_conocer_morosos = mysqli_query($mysqli,$conocer_morosos) or die(mysqli_error());

                                	if(mysqli_num_rows($iny_conocer_morosos) > 0){
                                		echo "<tr><td colspan='6'><center><h4>Pagos Rezagados</h4></center></td></tr>";
						          		while($row_morosos = mysqli_fetch_array($iny_conocer_morosos)){
						          			$fechaInicialCredito = date('Y-m', strtotime($row_morosos[4]));
						          			$fechaCorriendoActual = "01-".$mes."-".$ano;
						          			$fechaCorriendo = date('Y-m', strtotime($fechaCorriendoActual));


						          			if($fechaInicialCredito<$fechaCorriendo){
						          				echo "
				                        		<tr class='danger'>
				                        			<td><a href='detalle-credito.php?id=$row_morosos[0]'>[#$row_morosos[9]]</a></td>
				                        			<td>".date("d/m/Y",strtotime($row_morosos[4]))." <span title='Sin Pago Registrado' class='top' data-toggle='tooltip'><i class='fa fa-exclamation-circle' aria-hidden='true'></i></span></td>
													<td>$row_morosos[1] $row_morosos[2] $row_morosos[3]";
													categoriaClienteHTML($row_morosos[10]);
													echo"</td>";
				                        			$conocerSaldoRestanteMorosos = "SELECT sum(monto) from pagos where id_credito= $row_morosos[0] and tipo_pago= 2;";
		                                            $iny_conocerSaldoRestanteMorosos = mysqli_query($mysqli,$conocerSaldoRestanteMorosos) or die(mysqli_error());
						                            $fSaldoRestanteMorosos = mysqli_fetch_row($iny_conocerSaldoRestanteMorosos);
						                            $saldoRestanteMorosos = $row_morosos[6] - $fSaldoRestanteMorosos[0];

                                                    echo "<td><span title='Monto Credito: $ ".number_format(($row_morosos[6]),2)."' class='top' data-toggle='tooltip'>$ ".number_format(($saldoRestanteMorosos),2)."</span></td>
                                                    <td>$row_morosos[7]%</td>";
                                                    $pagoActualInteres = ($saldoRestanteMorosos/100) * $row_morosos[7];
                                                    echo "<td>$".number_format(($pagoActualInteres),2)."</td>
                                                <tr>";
						          			}


						          		}
						          	}

						          	//Meses Anteriores
						          	$fecha_inicial = "2018-01-01";
						          	$fechaactualmenos1 = date('Y-m-d', strtotime($fecha_actual . ' -1 month'));
						          	$determinar_actual = explode("-",$fechaactualmenos1);
						          	$mesIniciaActual = $determinar_actual[0]."-".$determinar_actual[1]."-01";

						          	$fechaArranque= new DateTime($fecha_inicial);
                                    $fechaTermina= new DateTime($mesIniciaActual);
                                    $IntervaloUnMes= new DateInterval("P1M");
						          	//Comparar fechas en caso contrario recorrer hacia atras
						          	 while($fechaArranque<=$fechaTermina){

						          	 	$fechaTermina->format('Y-m-d');
										$mes_morosos_buscar = $fechaTermina->format('m');
										$ano_morosos_buscar = $fechaTermina->format('Y');
						          	 	$conocer_morosos_anteriores = "SELECT
                                				creditos.id_creditos,
					                            clientes.nombres,
					                            clientes.apaterno,
					                            clientes.amaterno,
					                            date_format(creditos.fecha_prestamo, '%d-%m-%Y') AS fecha_prestamo,
					                            creditos.status,
					                            creditos.monto,
					                            creditos.interes,
					                            creditos.pago_mensual,
					                            creditos.folio,
												clientes.categoria
					                            FROM creditos
					                            INNER JOIN
						                            clientes
						                        ON
						                            creditos.id_cliente = clientes.id_clientes
                                				WHERE creditos.id_creditos
                                				NOT IN
                                				(SELECT id_credito FROM pagos where month(fecha_pago) = $mes_morosos_buscar and year(fecha_pago) = $ano_morosos_buscar and tipo_pago=1)
                                				AND (DAY(fecha_prestamo) >= '01')
                                				AND (DAY(fecha_prestamo) <= '31')
                                				and creditos.status = 1
                                				order by fecha_prestamo desc;
                                	";
                                	$iny_conocer_morosos_anteriores = mysqli_query($mysqli,$conocer_morosos_anteriores) or die(mysqli_error());
                                	if(mysqli_num_rows($iny_conocer_morosos_anteriores) > 0){

                                		echo "<tr><td colspan='6'>";

                                		$formateofecha = date_format($fechaTermina, 'Y-m-d');

                                		echo "<center><h4>Pagos Rezagados (".strftime('%B del %Y',strtotime($formateofecha)).")</h4></center></td></tr>";
						          		while($row_morosos_anteriores = mysqli_fetch_array($iny_conocer_morosos_anteriores)){
						          			$fechaInicialCredito = date('Y-m-d', strtotime($row_morosos_anteriores[4]));
						          			$fechaCorriendo = date('Y-m-d', strtotime(date_format($fechaTermina, 'd-m-Y')));

						          			if($fechaInicialCredito<$fechaCorriendo){
						          				echo "
				                        		<tr class='danger'>
				                        			<td><a href='detalle-credito.php?id=$row_morosos_anteriores[0]'>[#$row_morosos_anteriores[9]]</a></td>
				                        			<td>".date("d/m/Y",strtotime($row_morosos_anteriores[4]))." <span title='Sin Pago Registrado' class='top' data-toggle='tooltip'><i class='fa fa-exclamation-circle' aria-hidden='true'></i></span></td>
													<td>$row_morosos_anteriores[1] $row_morosos_anteriores[2] $row_morosos_anteriores[3]";
													categoriaClienteHTML($row_morosos_anteriores[10]);
													echo"</td>";
				                        			$conocerSaldoRestanteMorososAnteriores = "SELECT sum(monto) from pagos where id_credito= $row_morosos_anteriores[0] and tipo_pago= 2;";
		                                            $iny_conocerSaldoRestanteMorososAnteriores = mysqli_query($mysqli,$conocerSaldoRestanteMorososAnteriores) or die(mysqli_error());
						                            $fSaldoRestanteMorososAnteriores = mysqli_fetch_row($iny_conocerSaldoRestanteMorososAnteriores);
						                            $saldoRestanteMorososAnteriores = $row_morosos_anteriores[6] - $fSaldoRestanteMorososAnteriores[0];

                                                    echo "<td><span title='Monto Credito: $ ".number_format(($row_morosos_anteriores[6]),2)."' class='top' data-toggle='tooltip'>$ ".number_format(($saldoRestanteMorososAnteriores),2)."</span></td>
                                                    <td>$row_morosos_anteriores[7]%</td>";
                                                    $pagoActualInteresAnteriores = ($saldoRestanteMorososAnteriores/100) * $row_morosos_anteriores[7];
                                                    echo "<td>$".number_format(($pagoActualInteresAnteriores),2)."</td>
                                                <tr>";
						          			}


						          		}
						          	}
                                	$fechaTermina->sub($IntervaloUnMes);


						          	 }


                                ?>
								</tbody>
							</table>
						</div>

					</div>
				</div>
			</div>
			<!-- /main -->
			<!-- FOOTER -->
			<footer class="footer">
				&copy; 2017 Syscom Leon
			</footer>
			<!-- END FOOTER -->
		</div>
		<!-- END CONTENT WRAPPER -->
	</div>
	<!-- END WRAPPER -->

	<!-- Javascript -->
	<?php
		include("include/footer-js.php")
	 ?>
</body>

</html>

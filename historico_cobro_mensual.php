<?php
	session_start(); // crea una sesion
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/funciones.php");
	include("include/functions.php");
	
	date_default_timezone_set('America/Mexico_City');
	$fecha_actual = date("Y-m-d");
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	$pagina_actual = "historico-cobranza";
	//Validar Permisos
	if(validarAccesoModulos('permiso_reportes_historico_cobranza') != 1) {
		header("Location: dashboard.php");
		exit();
	}
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!-->
<html lang="es" class="no-js">
<!--<![endif]-->

<head>
	<title>Historico Cobro Mensual | Portal Credinieto</title>
	<?php
		include("include/head.php");
	?>
</head>

<body class="sidebar-fixed topnav-fixed ">
	<!-- WRAPPER -->
	<div id="wrapper" class="wrapper">
        <?php
			include("include/top-bar.php");
			include("include/left-sidebar.php");
		 ?>
		<!-- MAIN CONTENT WRAPPER -->
		<div id="main-content-wrapper" class="content-wrapper ">
			<!-- top general alert -->
			
			
			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Historico de Cobro Mensual</h2>
					<em></em>
				</div>
				<div class="main-content">

					<!-- WIDGET CHART ZOOM -->
					<div class="widget">
						<div class="widget-header">
							<h3><i class="fa fa-bar-chart-o"></i> Historico de Cobro Mensual</h3> <em></em>
						</div>
						<div class="widget-content">
							<?php
								//Meses Anteriores
						          	$fecha_inicial = "2018-01-01";
						          	$fechaactualmenos1 = date('Y-m-d', strtotime($fecha_actual));
						          	$determinar_actual = explode("-",$fechaactualmenos1);
						          	$mesIniciaActual = $determinar_actual[0]."-".$determinar_actual[1]."-01";

						          	$fechaArranque= new DateTime($fecha_inicial);
                                    $fechaTermina= new DateTime($mesIniciaActual);
                                    $IntervaloUnMes= new DateInterval("P1M");
						          	//Comparar fechas en caso contrario recorrer hacia atras
						          	echo "<table class='table'>";
						          	echo "<thead><th>Mes</th>
									<th>Cobro Previsto de Intereses</th>
									<th>Interés Cobrado en el Mes</th>
									<th>Capital cobrado en el Mes</th>
									<th>Total Cobrado en el Mes</th>
									<th>Creditos Colocados</th></thead>";
									  
								
									  
						          	 while($fechaArranque<=$fechaTermina){
						          	 	echo "<tr><td>".$fechaTermina->format('m-Y')."</td> ";
						          	 	$fechaTermina->format('Y-m-d');
										
										//Conocer Creditos
										$conocer_montos_intereses_maximos = "SELECT coalesce(max(monto_a_fin_mes),0) from hist_calc_int_payments t1 where t1.monto_a_fin_mes=(SELECT max(t2.monto_a_fin_mes) from hist_calc_int_payments t2 where month(t2.datetime) = '".$fechaTermina->format('m')."' and year(t2.datetime) ='".$fechaTermina->format('Y')."');";
										$iny_conocer_montos_intereses_maximos = mysqli_query($mysqli,$conocer_montos_intereses_maximos) or die(mysqli_error());

										$fConocerMontosInteresesMaximos = mysqli_fetch_row($iny_conocer_montos_intereses_maximos);
										
										if($fConocerMontosInteresesMaximos[0]<=0){
											echo "<td><span class='texto-peque cursiva'>Sin datos suficientes</span></td>";
										}else{
											echo "<td>$".number_format(($fConocerMontosInteresesMaximos[0]),2)."</td>";
										}
							          	
										
							          	$conocer_pagos_actuales_interes = "select  COALESCE(sum(monto),0) from pagos where MONTH(fecha_captura) = '".$fechaTermina->format('m')."' and YEAR(fecha_captura) = '".$fechaTermina->format('Y')."' and tipo_pago = 1 ";
							          	$iny_conocer_pagos_actuales_interes = mysqli_query($mysqli,$conocer_pagos_actuales_interes) or die(mysqli_error());
							          	$fConocerPagosActualesInteres = mysqli_fetch_row($iny_conocer_pagos_actuales_interes);
							          	echo "<td>$".number_format(($fConocerPagosActualesInteres[0]),2)."</td>";
						          	    
						          	    $conocer_pagos_actuales_capital = "select  COALESCE(sum(monto),0) from pagos where MONTH(fecha_captura) = '".$fechaTermina->format('m')."' and YEAR(fecha_captura) = '".$fechaTermina->format('Y')."' and tipo_pago = 2 ";
							          	$iny_conocer_pagos_actuales_capital = mysqli_query($mysqli,$conocer_pagos_actuales_capital) or die(mysqli_error());
							          	$fConocerPagosActualesCapital = mysqli_fetch_row($iny_conocer_pagos_actuales_capital);
							          	echo "<td>$".number_format(($fConocerPagosActualesCapital[0]),2)."</td>";    

							          	
										                      	
                                		

                                		$sumaTotalPagos = $fConocerPagosActualesInteres[0] + $fConocerPagosActualesCapital[0];
                                		echo "<td>$".number_format(($sumaTotalPagos),2)."</td>";


										$conocer_total_creditos_colocados_mes = "SELECT COALESCE(SUM(monto),0) from creditos where MONTH(fecha_captura) = '".$fechaTermina->format('m')."' and YEAR(fecha_captura) = '".$fechaTermina->format('Y')."';";
							          	$iny_conocer_total_creditos_colocados_mes = mysqli_query($mysqli,$conocer_total_creditos_colocados_mes) or die(mysqli_error());
							          	$fConocerTotalCreditosColocados = mysqli_fetch_row($iny_conocer_total_creditos_colocados_mes);
							          	echo "<td>$".number_format(($fConocerTotalCreditosColocados[0]),2)."</td>"; 
										$fechaTermina->sub($IntervaloUnMes);
						          	 }
							?>	
							</table>
						</div>
					</div>
					<!-- END WIDGET CHART ZOOM -->

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
	<script src="assets/js/jquery/jquery-2.1.0.min.js"></script>
	<script src="assets/js/bootstrap/bootstrap.js"></script>
	<script src="assets/js/plugins/modernizr/modernizr.js"></script>
	<script src="assets/js/plugins/bootstrap-tour/bootstrap-tour.custom.js"></script>
	<script src="assets/js/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/js/king-common.js"></script>
	<script src="assets/js/plugins/stat/flot/jquery.flot.min.js"></script>
	<script src="assets/js/plugins/stat/flot/jquery.flot.resize.min.js"></script>
	<script src="assets/js/plugins/stat/flot/jquery.flot.tooltip.min.js"></script>
	<script src="assets/js/plugins/stat/flot/jquery.flot.selection.min.js"></script>
	<script src="assets/js/king-chart-stat.js"></script>
</body>

</html>

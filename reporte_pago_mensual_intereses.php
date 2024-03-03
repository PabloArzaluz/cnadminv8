<?php
	session_start(); // crea una sesion
	ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/functions.php");
	$link = Conecta();
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	$pagina_actual = "reportes-grafica-pagos-mensuales";
	//Validar Permisos
	if(validarAccesoModulos('permiso_reportes_grafica_pagos_mensuales') != 1) {
		header("Location: dashboard.php");
	}
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!-->
<html lang="es" class="no-js">
<!--<![endif]-->

<head>
	<title>Reporte Pago Mensual de Intereses | Portal Credinieto</title>
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
					<h2>Graficas Interactivas</h2>
					<em></em>
				</div>
				<div class="main-content">
                    <?php
                         $ano = date("Y");
  	                     $mes = date("m");
                        $dias = date('t', mktime(0,0,0, $mes, 1, $ano));
                            $cadena_interes = "[";
                            $cadena_capital = "[";
                        for($i = 1; $i<=$dias;$i++){
                            //Interes
                            $conocer_pagos_interes_por_dia = "select sum(monto) from pagos where year(fecha_pago)='$ano' and month(fecha_pago)='$mes' and day(fecha_pago)='$i' and tipo_pago=1;";
                            $iny_conocer_pago_interes_por_dia = mysql_query($conocer_pagos_interes_por_dia,$link) or die(mysql_error());
                            $row_interes = mysql_fetch_row($iny_conocer_pago_interes_por_dia);
                            
                            //Capital
                            $conocer_pagos_capital_por_dia = "select sum(monto) from pagos where year(fecha_pago)='$ano' and month(fecha_pago)='$mes' and day(fecha_pago)='$i' and tipo_pago=2;";
                            $iny_conocer_pago_capital_por_dia = mysql_query($conocer_pagos_capital_por_dia,$link) or die(mysql_error());
                            $row_capital = mysql_fetch_row($iny_conocer_pago_capital_por_dia);
                            
                            if($row_interes[0] != ""){
                                $cantidad_acumulada_interes = $row_interes[0];
                            }else{
                                $cantidad_acumulada_interes = 0;
                            }
                            
                            if($row_capital[0] != ""){
                                $cantidad_acumulada_capital = $row_capital[0];
                            }else{
                                $cantidad_acumulada_capital = 0;
                            }
                            
                            $cadena_interes = $cadena_interes."[$i, $cantidad_acumulada_interes],";
                            $cadena_capital = $cadena_capital."[$i, $cantidad_acumulada_capital],";
                        }
                        $cadena_interes = $cadena_interes."]";
                        $cadena_capital = $cadena_capital."]";
                    ?>
					<script type="text/javascript">
                        	// init flot chart: select and zoom
	function chartSelectZoomSeries(placeholder) {

		var data = [{
			label: "Pagos a Interes",
			data: <?php echo $cadena_interes; ?>
		}, {
			label: "Pagos a Capital", 
			data: <?php echo $cadena_capital; ?>
		}];

		var options = {
			series: {
				lines: {
					show: true,
					lineWidth: 2, 
					fill: false
				},
				points: {
					show: true, 
					lineWidth: 3,
					fill: true,
					fillColor: "#fafafa"
				},
				shadowSize: 0
			},
			grid: {
				hoverable: true, 
				clickable: true,
				borderWidth: 0,
				tickColor: "#E4E4E4",
				
			},
			legend: {
				noColumns: 3,
				labelBoxBorderColor: "transparent",
				backgroundColor: "transparent"
			},
			xaxis: {
				tickDecimals: 0,
				tickColor: "#fafafa"
			},
			yaxis: {
				min: 0
			},
			colors: ["#5399D6", "#d7ea2b",  "#E7A13D"],
			tooltip: true,
			tooltipOpts: {
				content: '%s: %y'
			},
			selection: {
				mode: "x"
			}
		};

		var plot = $.plot(placeholder, data, options);

		placeholder.bind("plotselected", function (event, ranges) {

			plot = $.plot(placeholder, data, $.extend(true, {}, options, {
				xaxis: {
					min: ranges.xaxis.from,
					max: ranges.xaxis.to
				}
			}));
		});

		$('#reset-chart-zoom').click( function() {
			plot.setSelection({
				xaxis: {
					from: 1,
					to: 31
				}
			});
		});
	}
                    </script>
					<!-- WIDGET CHART ZOOM -->
					<div class="widget">
						<div class="widget-header">
							<h3><i class="fa fa-bar-chart-o"></i> Reporte Pago Mensual de Intereses</h3>
							<div class="btn-group widget-header-toolbar">
								<button type="button" id="reset-chart-zoom" class="btn btn-danger btn-sm"><i class="fa fa-refresh"></i> Zoom Original</button>
							</div>
						</div>
						<div class="widget-content">
							<div class="demo-flot-chart" id="demo-select-zoom-chart"></div>
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

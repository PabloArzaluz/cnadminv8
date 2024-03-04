<?php
	session_start(); // crea una sesion
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/functions.php");
	include("include/funciones.php");
	
	date_default_timezone_set('America/Mexico_City');
	setlocale(LC_ALL, 'es_MX.UTF-8');
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
		exit();
	}
	//Validar Permisos
	if(validarAccesoModulos('permiso_reportes_r_i') != 1) {
		header("Location: dashboard.php");
	}
	$pagina_actual = "reporte-apertura-creditos-pagos";
	$fecha = date("Y-m-d");
	$fecha_format = date("Y/m/d");
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!-->
<html lang="es" class="no-js">
<!--<![endif]-->

<head>
	<title>Reporte de Pago de Interes R y I | Credinieto</title>
<?php
		include("include/head.php");
	?>
	<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
	<!-- Mont Year Selector -->
	<script src="js/monthyear/jquery-1.11.2.min.js"></script>
	
    <link rel="stylesheet" href="css/monthyear/jquery-ui.css">
    <script src="js/monthyear/jquery.mtz.monthpicker.js"></script>

	<!-- end month year selector-->

	
	<script type="text/javascript">
		function calcularPagoMensual(){
			interesMensual = document.getElementById('interes-mensual').value;
			montoCredito = document.getElementById('monto-credito').value;
			pagoMensual = document.getElementById('pago-mensual').value;
			if (interesMensual.length != 0 && montoCredito.length != 0) {
				var interes = interesMensual / 100;
				var pagoM = montoCredito * interes;
				document.getElementById('pago-mensual').value = pagoM;
			}
		}
	</script>

	<script type="text/javascript">
		function alertaCreditoJuridico(id){
			document.getElementById("alerta").innerHTML = "";
			document.getElementById("monto-pago").value = "";
			var calo= id;
			
			<?php
				$conocer_en_juridico = mysqli_query($mysqli,"select id_creditos from creditos where status=3;") or die(mysqli_error());
				echo "var myArr = [";
				while ($fila_juridico_conocer = mysqli_fetch_array($conocer_en_juridico)) {
					echo "'$fila_juridico_conocer[0]',";
				}
					echo "];";
			?>
			if ( myArr.includes(calo) ) {
				document.getElementById("alerta").innerHTML = "<div class='alert alert-danger'><h3>El Cliente se encuentra en Juridico. Favor de pedir autorizacion para registrar pagos.</h3></div>";
			}
		}
	</script>
	<script type="text/javascript">
        $(document).ready(function() {  
            $('#credito').on("change", function(){
                
                $('#Info').html('Consultando... <img src="img/loading.gif"  alt="" /> ').fadeOut(1000);

                var username = $(this).val();       
                var dataString = 'username='+username;
                
                $.ajax({
                    type: "POST",
                    url: "ajax/get_info_credito.php",
                    data: dataString,
                    success: function(data) {
                        $('#Info').fadeIn(1000).html(data);
                        //alert(data);
                    }
                });
            });              
        });    
</script>
<script type="text/javascript">
        $(document).ready(function() {  
            $('#monto-pago').blur(function(){
                
                

                var monto = $(this).val();   
                var tipoP = $('#tipo-pago option:selected').attr('value');
                var credito = $('#credito option:selected').attr('value');
				var dataString = 'monto='+monto+'&tipo='+tipoP+'&credito='+credito;
                

                $.ajax({
                    type: "POST",
                    url: "ajax/check_pago.php",
                    data: dataString,
                    success: function(response) {
                     if (!$.trim(response)){   
						    
						}
						else{   
						   // Add response in Modal body
					      $('.modal-body').html(response);

					      // Display Modal
					      $('#empModal').modal('show'); 
						}  

                       
                    }
                });
            });              
        });    
</script>
<script type="text/javascript">
	function limpiarCampos(){
		document.getElementById("monto-pago").value="";
	}
</script>
</head>

<body class="sidebar-fixed topnav-fixed forms-elements">
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
									<li><i class="fa fa-home"></i><a href="#">Inicio</a></li>
									<li><a href="#">Reportes</a></li>
									<li class="active">Pago de Intereses R y I</li>
								</ul>
							</div>

						</div>

			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Reporte de Pago de Intereses R y I</h2>
					<em>reporte de pago de Intereses</em>
				</div>
				<div class="main-content">
					<!-- HORIZONTAL FORM -->
					<div class="widget">
						<div class="widget-header">

							<h3><i class="fa fa-edit"></i> Reporte de pago de Intereses R y I</h3></div>
						<div class="widget-content">
							<?php
								//Operaciones
								if(isset($_GET['i'])){
									if($_GET['i'] == 'errf'){
										echo "<div class='alert alert-danger'>
												<a href='' class='close'>&times;</a>
												<strong>Ya existe Folio Fisico Registrado.</strong> Por favor verifica el folio fisico, existe un registro previo con el mismo numero. Verifica la informacion y vuelve a realizar la captura de pago. La informacion no se registro.
										</div>";
									}
								}
							?>
							<form class="form-horizontal" role="form" method="post" action="reporte-apertura-creditos.php?b=1" autocomplete="off" enctype="multipart/form-data">
							
							<div class="row">
								<div class="col-xs-6">
									<div class="form-group">
										<label for="datepicker" class="col-sm-3 control-label">Fecha Apertura</label>
										<div class="col-sm-9">
										
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												
												<!--<input type="text" id="datepicker" class="form-control" name="fecha-pago" readonly required placeholder="Fecha de Pago (Año/Mes/Dia)">-->
												<input type="text" id="fecha-apertura-selector" required placeholder="Fecha Inicial" name="fecha-apertura" class="form-control mtz-monthpicker-widgetcontainer">
												<!--<input type="text" id="datepicker" class="form-control"  >-->
											</div>
										</div>
									</div>						
								</div>	
								<div class="col-xs-6">
									<div class="form-group">
										<label for="datepicker2" class="col-sm-3 control-label">Fecha Pagos</label>
										<div class="col-sm-9">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												<!--<input type="text" id="datepicker" class="form-control" name="fecha-pago" readonly required placeholder="Fecha de Pago (Año/Mes/Dia)">-->
												<input type="text" id="fecha-final-selector" required placeholder="Fecha Final" name="fecha-pago" class="form-control mtz-monthpicker-widgetcontainer">
												<!--<input type="text" id="datepicker2" class="form-control"  required placeholder="Fecha Final">-->
											</div>
										</div>
									</div>						
								</div>							
							</div>
							
							<div class="row">
								<div class="col-xs-12">
									<div class="form-group">
										<div class="col-sm-3 col-sm-offset-5">
											
										</div>
	                                    <div class="col-sm-4">
										
	                                        <button type="submit" class="btn btn-success btn-block">Realizar Busqueda</button>
	                                    </div>
	                                </div>
                                </div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									
									<!-- Modal -->
								   <div class="modal fade" id="empModal" role="dialog">
								    <div class="modal-dialog modal-sm">
								 
								     <!-- Modal content-->
								     <div class="modal-content">
								      <div class="modal-header">
								        <button type="button" class="close" data-dismiss="modal">&times;</button>
								        <h4 class="modal-title">Informacion</h4>
								      </div>
								      <div class="modal-body">
								 
								      </div>
								      <div class="modal-footer">
								       <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
								      </div>
								     </div>
								    </div>
								   </div>

								</div>
							</div>
							</form>
						</div>
					</div>
					<!-- END HORIZONTAL FORM -->
					<!-- Mostrar reporte a partir de aqui-->
					<?php
						if(!isset($_GET['b'])){
							//echo "no se ha generado ninguna consulta";
							//se resetea variable temporal 
							
							$_SESSION['haycreditoseliminados'] = 0;
							$_SESSION['consultaactual'] = "";
							
						}else{
							//echo "Ya se genero una consulta";
							//Creamos la variable de sesion para guardar el texto 
							$htmlprint = "";
							if(!isset($_GET['eli'])){
								unset($_SESSION['arrayEliminados']);
								$_SESSION['arrayEliminados'] = array();

							}else{
								//si recibo eli
								echo "<strong>Los siguientes creditos no se mostraran:</strong><br>";
								$_POST['eliminar'];
								if( in_array( $_POST['eliminar'] ,$_SESSION['arrayEliminados'] ) )
								{
									//echo "ya esta registrado<br>";
								}else{
									array_push($_SESSION['arrayEliminados'], $_POST['eliminar']);
								}
								foreach($_SESSION['arrayEliminados'] as $value){
									//Consultar cada valor de cada creditos
									$q_conocerDatosdeCreditosElimiandos = "SELECT id_creditos,folio, nombres, apaterno, amaterno FROM creditos INNER JOIN clientes ON clientes.id_clientes = creditos.id_cliente WHERE creditos.id_creditos =  $value";
									$i_conocerDatosdeCreditosElimiandos = mysqli_query($mysqli,$q_conocerDatosdeCreditosElimiandos) or die(mysqli_error());
									$r_conocerDatosdeCreditosElimiandos = mysqli_fetch_assoc($i_conocerDatosdeCreditosElimiandos);
									echo $r_conocerDatosdeCreditosElimiandos['folio']." - ".$r_conocerDatosdeCreditosElimiandos['nombres']." ".$r_conocerDatosdeCreditosElimiandos['apaterno']." ".$r_conocerDatosdeCreditosElimiandos['amaterno']."<br>";
								}
								//echo (count($_SESSION['arrayEliminados']) > 0 ? implode(",", $_SESSION['arrayEliminados']):0);
								
								echo "<br><a href='reporte-apertura-creditos.php'>Reset Reporte</a>";
							}

							if(!isset($_POST['fecha-apertura'])){
								$fechaApertura = $_SESSION['fechaapertura'];
							}else{
								$fechaApertura 	= $_POST['fecha-apertura'];
								$_SESSION['fechaapertura'] = $fechaApertura;
							}
							
							
							$desglosaFechaApertura = explode("/",$fechaApertura);
							$fechaCreadaApertura = DateTime::createFromFormat("Y-m-d", $desglosaFechaApertura[1]."-".$desglosaFechaApertura[0]."-01");
							
							
							if(!isset($_POST['fecha-pago'])){
								$fechaPago = $_SESSION['fechapago'];
							}else{
								$fechaPago 	= $_POST['fecha-pago'];
								$_SESSION['fechapago'] = $fechaPago;
							}
							
							$desglosaFechaPago = explode("/",$fechaPago);
							$fechaCreadaPago = DateTime::createFromFormat("Y-m-d", $desglosaFechaPago[1]."-".$desglosaFechaPago[0]."-01");
							

							$anioFechaApertura = $fechaCreadaApertura->format("Y");
							 $mesFechaApertura = $fechaCreadaApertura->format("m");
							
							 $anioFechaPago = $fechaCreadaPago->format("Y");
							 $mesFechaPago = $fechaCreadaPago->format("m");
							 if(isset($_GET['eli'])){
								//echo "se declaro eliminado y tengo que cambiar la consulta";
								 $consulta = "select 
								id_creditos,
									folio as NUMERO_CREDITO, 
									concat(clientes.nombres,' ',clientes.apaterno,' ',clientes.amaterno) as NOMBRE_COMPLETO_CLIENTE,
									creditos.monto AS MONTO_CREDITO,
									CONCAT(creditos.interes,'%') AS INTERES,
									DATE_FORMAT(DATE_ADD(creditos.fecha_prestamo, INTERVAL 1 MONTH),'%d/%m/%Y'	) AS FECHA_PAGO_INTERES,
									creditos.pago_mensual AS PAGO_MENSUAL,
									CONCAT('$ ', FORMAT((creditos.monto*.015),2)) AS INTERES_INVERSIONISTA,
									CASE
										WHEN creditos.status = 1 THEN 'ACTIVO'
										WHEN creditos.status = 2 THEN  'FINALIZADO'
										ELSE 'OTRO'
										END AS estado,
										creditos.fecha_cierre_credito
								FROM creditos 
									INNER JOIN clientes
									ON creditos.id_cliente = clientes.id_clientes								
									where YEAR(fecha_prestamo) = $anioFechaApertura AND MONTH(fecha_prestamo) = $mesFechaApertura AND id_creditos NOT IN (".(count($_SESSION['arrayEliminados']) > 0 ? implode(",", $_SESSION['arrayEliminados']):0).") ORDER BY NUMERO_CREDITO asc";
							 }else{
								$consulta = "select 
								id_creditos,
									folio as NUMERO_CREDITO, 
									concat(clientes.nombres,' ',clientes.apaterno,' ',clientes.amaterno) as NOMBRE_COMPLETO_CLIENTE,
									creditos.monto AS MONTO_CREDITO,
									CONCAT(creditos.interes,'%') AS INTERES,
									DATE_FORMAT(DATE_ADD(creditos.fecha_prestamo, INTERVAL 1 MONTH),'%d/%m/%Y'	) AS FECHA_PAGO_INTERES,
									creditos.pago_mensual AS PAGO_MENSUAL,
									CONCAT('$ ', FORMAT((creditos.monto*.015),2)) AS INTERES_INVERSIONISTA,
									CASE
										WHEN creditos.status = 1 THEN 'ACTIVO'
										WHEN creditos.status = 2 THEN  'FINALIZADO'
										ELSE 'OTRO'
										END AS estado,
									creditos.fecha_cierre_credito
								FROM creditos 
									INNER JOIN clientes
									ON creditos.id_cliente = clientes.id_clientes								
									where YEAR(fecha_prestamo) = $anioFechaApertura AND MONTH(fecha_prestamo) = $mesFechaApertura ORDER BY NUMERO_CREDITO asc";
							 }
							  
							$_SESSION['consultaactual'] = $consulta;
							$iny_consulta = mysqli_query($mysqli,$consulta) or die (mysqli_error());
							
							if(mysqli_num_rows($iny_consulta) > 0){
								echo '
								<div class="widget widget-table">
								<div class="widget-header">
									<h3><i class="fa fa-table"></i>Resultados</h3> 
								</div>
								<div class="widget-content">';
									
								$htmlprint .= '		<table class="table table-bordered table-condensed" style="font-size:12px;">
											<thead>
											<tr>
												<td colspan="6"><h3>Apertura en: '.ucfirst(strftime("%B",strtotime($anioFechaApertura."-".$mesFechaApertura."-01"))).' del '.$anioFechaApertura.'</h3></td>
												<td colspan="6"><h3>Pagos en: '.ucfirst(strftime("%B",strtotime($anioFechaPago."-".$mesFechaPago."-01"))).' del '.$anioFechaPago.'</h3></td>
											</tr>
												<tr>
													<th>No. Cliente</th>
													<th>Nombre del Cliente</th>
													<th>Saldo del Prestamo</th>
													<th>Interes</th>
													<th>Fecha de Pago Int.</th>
													<th>Importe a Pagar</th>
													<th>F. Realizacion Pago</th>
													<th>Importe Pagado</th>
													<th>Interés Inversionista</th>
													<th>Sobrante</th>
													<th>Entre Dos</th>
													<th><a href="#">Quitar</a></th>
												</tr>
											</thead>
											<tbody>
								';
								$total_monto_prestamo = 0;
								$total_importe_a_pagar = 0;
								$total_importe_pagado = 0;
								$total_interes_inversionista = 0;
								$total_sobrante = 0;
								while($row = mysqli_fetch_row($iny_consulta)){
									$saldo_credito = conocer_monto_deudor($row[0]);
									$total_monto_prestamo += $saldo_credito;
									$total_importe_a_pagar += $row[6];
									
									$htmlprint .= '
									<tr>
									<td>';
									if($row[8] == 'ACTIVO'){
										$htmlprint.= '<span class="label label-success">'.$row[1].'</span> '.$row[8].'</td>';
									}
									if($row[8] == 'FINALIZADO'){
										$htmlprint.= '<span class="label label-warning">'.$row[1].'</span> '.$row[8];
										if(is_null($row[9])){
											$htmlprint.= "Fecha no capturada";
										}else{
											$htmlprint.= '<br>['.date("d/m/Y",strtotime($row[9])).']';
										}
										$htmlprint.= '</td>';
									}
									$saldo_credito = conocer_monto_deudor($row[0]);
									$monto_a_pagar_este_mes = $saldo_credito * ($row[4]/100);
									
									$htmlprint .= '<td>'.$row[2].'</td>
									<td><span title="Monto Original: $ '.number_format(($row[3]),2).'" class="top" data-toggle="tooltip">$ '.number_format($saldo_credito,2).'</span></td>
									<td>'.$row[4].'</td>
									<td>'.$row[5].'</td>';
									$htmlprint .= '<td>$ '.number_format($monto_a_pagar_este_mes, 2, '.', ',').'</td>';
									//Conocer El total del monto de los pagos correspondientes a el mes en curso
									$conocer_total_pagos = "SELECT * FROM pagos WHERE id_credito = '$row[0]' AND MONTH(fecha_pago)='".$mesFechaPago."' AND YEAR(fecha_pago) = '".$anioFechaPago."' and tipo_pago=1;";
									
									$iny_conocer_total_pagos = mysqli_query($mysqli,$conocer_total_pagos) or die (mysqli_error());
									$cantidad_pagos = mysqli_num_rows($iny_conocer_total_pagos);
									$filaPagos = mysqli_fetch_row($iny_conocer_total_pagos);

									
									
									
									if(!empty($filaPagos[4])){
										$htmlprint .= "<td>".date("d/m/Y", strtotime($filaPagos[4]));
										if($cantidad_pagos > 1 ){
											$htmlprint .= " <span class='label label-primary'>$cantidad_pagos</span>";
										}
										$htmlprint .= "</td>";
									}else{
										$htmlprint .= "<td><span class='label label-danger'>Ninguno</span></td>";
									}
									$totalPagos = 0;
									if(!empty($filaPagos[5])){
										
										$conocerTotalSumarPagos = "SELECT SUM(MONTO) FROM pagos where id_credito = '$row[0]' AND MONTH(fecha_pago)='".$mesFechaPago."' AND YEAR(fecha_pago) = '".$anioFechaPago."' and tipo_pago=1;";
										$fSumaPagos = mysqli_query($mysqli,$conocerTotalSumarPagos) or die (mysqli_error());
										$RowPagosSuma = mysqli_fetch_row($fSumaPagos);
										$totalPagos += $RowPagosSuma[0];
											if($cantidad_pagos > 1 ){
												$htmlprint .= "<td>$".number_format($RowPagosSuma[0], 2, '.', ',')."</td>";
												
											}else{
												$htmlprint .= "<td>$".number_format($totalPagos, 2, '.', ',')."</td>";
											}
											$total_importe_pagado += $totalPagos;
									}else{
										$htmlprint .= "<td><span class='label label-danger'>0.00</span></td>";
									}
									$interes_inversionista = $row[3] * 0.015;
									$total_interes_inversionista += $interes_inversionista;
									$htmlprint .= "<td>";
									$htmlprint .= '<br>['.date("d/m/Y",strtotime($row[9])).']';
									$htmlprint .= "$".number_format($interes_inversionista, 2, '.', ',')."</td>";
									$sobrante = $totalPagos - $interes_inversionista;
									$total_sobrante += $sobrante;
									if($sobrante < 0){
										$htmlprint .= "<td><span class='label label-warning'>$".number_format($sobrante, 2, '.', ',')."</span></td>";
									}else{
										$htmlprint .="<td>$".number_format($sobrante, 2, '.', ',')."</td>";
									}
									$entredos = $sobrante / 2;
									if($entredos < 0){
										$htmlprint .= "<td><span class='label label-warning'>$".number_format($entredos, 2, '.', ',')."</span></td>";
									}else{
										$htmlprint .= "<td>$".number_format($entredos, 2, '.', ',')."</td>";
									}
									
									$htmlprint .= "<form action='reporte-apertura-creditos.php?b=1&eli=1' method='POST'>
										<td><input type='checkbox' onChange='this.form.submit()' value='$row[0]' name='eliminar' /> <label>".$row[1]."</label></td></form>";
										$htmlprint .= '</tr>
									';
								}
								$htmlprint .= '<tr>
										<th></th>
										<th>Totales</th>
										<th>$ '.number_format($total_monto_prestamo, 2, '.', ',').'</th>
										<th></th>
										<th></th>
										<th>$ '.number_format($total_importe_a_pagar, 2, '.', ',').'</th>
										<th></th>
										<th>$'.number_format($total_importe_pagado, 2, '.', ',').'</th>
										<th>$'.number_format($total_interes_inversionista, 2, '.', ',').'</th>
										<th>$'.number_format($total_sobrante, 2, '.', ',').'</th>
										<th>$'.number_format($total_sobrante/2, 2, '.', ',').'</th>
									</tr>';
									$htmlprint .= '
										</tbody>
										</table>';
									//Imprimir Texto  guardar en variable de session
									echo $htmlprint;
									$_SESSION['reporte-intereses-ri'] = $htmlprint;
										echo '<a href="crear-excel.php" target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
								</div>
								
							</div>
								';
								
							}else{
								echo '<div class="alert alert-warning alert-dismissable">
								<a href="" class="close">&times;</a>
								<strong>Sin Resultados</strong> No se encontraron resultados con la informacion especificada.
							</div>';
							}
						}
						
					?>
					<!-- Fin del Reporte-->
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
	<script>
		$('#fecha-apertura-selector').monthpicker();
		$('#fecha-final-selector').monthpicker();
	</script>
	<!-- Javascript -->
	<script src="js/jquery-2.1.0.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/modernizr.js"></script>
	<script src="js/bootstrap-tour.custom.js"></script>
	<script src="js/jquery.slimscroll.min.js"></script>
	<script src="js/king-common.js"></script>
	<script src="js/bootstrap-switch.min.js"></script>
	<script src="assets/js/plugins/jquery-maskedinput/jquery.masked-input.min.js"></script>
	<script src="assets/js/plugins/bootstrap-multiselect/bootstrap-multiselect.js"></script>
	<script src="assets/js/jquery-ui/jquery-ui-1.10.4.custom.min.js"></script>
	<script src="assets/js/plugins/jqallrangesliders/jQAllRangeSliders-min.js"></script>
	<script src="assets/js/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.js"></script>
	<script src="assets/js/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.js"></script>
	<script src="assets/js/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>

	<script src="assets/js/plugins/daterangepicker/daterangepicker.js"></script>
	<script src="assets/js/plugins/moment/moment.min.js"></script>
	<script src="assets/js/plugins/bootstrap-slider/bootstrap-slider.js"></script>
	<script src="assets/js/plugins/select2/select2.min.js"></script>
	<script src="js/king-elements.js"></script>
	<script type="text/javascript">
	$(".js-example-placeholder-single").select2({
    placeholder: "Select a state",
    allowClear: true
});

	</script>
	
</body>

</html>

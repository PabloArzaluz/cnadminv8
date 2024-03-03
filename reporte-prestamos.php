<?php
	session_start(); // crea una sesion
	ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/functions.php");
	$link = Conecta();
	date_default_timezone_set('America/Mexico_City');
	setlocale(LC_ALL, 'es_MX.UTF-8');
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	//Validar Permisos
	if(validarAccesoModulos('permiso_reportes_prestamos') != 1) {
		header("Location: dashboard.php");
		exit();
	}
	$pagina_actual = "reporte-prestamos";
	$fecha = date("Y-m-d");
	$fecha_format = date("Y/m/d");
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!-->
<html lang="es" class="no-js">
<!--<![endif]-->

<head>
	<title>Reporte de Prestamos | Credinieto</title>
	<?php
		include("include/head.php");
	?>
	<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
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
				$conocer_en_juridico = mysql_query("select id_creditos from creditos where status=3;",$link) or die(mysql_error());
				echo "var myArr = [";
				while ($fila_juridico_conocer = mysql_fetch_array($conocer_en_juridico)) {
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
									<li><a href="pagos.php">Prestamos</a></li>
									<li class="active">Reporte de Prestamos</li>
								</ul>
							</div>

						</div>

			<!-- main -->
			<?php 
				if(!isset($_GET['b'])){
					$estadoCredito = "";
					$selectInversionista = "";
					$selectFechaInicial = "";
					$selectFechaFinal = "";
					$valorFiltroFechas = "0";
				}else{
					$estadoCredito			= $_POST['metodo'];
					if($_POST['inversionista'] != ""){
						$selectInversionista = $_POST['inversionista'];
					}else{
						$selectInversionista = "";
					}
					$valorFiltroFechas = $_POST['valorFiltroFechas'];
					if($valorFiltroFechas != 0){
						$selectFechaInicial = $_POST['fecha-inicial'];
						$selectFechaFinal = $_POST['fecha-final'];
					}
					
					
				}

			?>
			<div class="content">
				<div class="main-header">
					<h2>Reporte de Prestamos</h2>
					<em>formulario para reporte de prestamos</em>
				</div>
				<div class="main-content">
					<!-- HORIZONTAL FORM -->
					<div class="widget">
						<div class="widget-header">

							<h3><i class="fa fa-edit"></i> Reporte de Prestamos</h3></div>
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
							<form class="form-horizontal" id="reporte_prestamos" role="form" method="post" action="reporte-prestamos.php?b=1" autocomplete="off" enctype="multipart/form-data">
							<div class="row">
							    <div class="col-md-6">
									<div class="form-group">
										<label for="credito" class="col-sm-3 control-label">Credito</label>
										<div class="col-sm-9">
											<!-- SELECT2 -->
											<select disabled name="credito" id="credito" class="select2" required onchange="alertaCreditoJuridico(this.value)">
												<option value="">Todos</option>
													<?php
															$iny_creditos = mysql_query("SELECT 
                                                                creditos.id_creditos,
                                                                clientes.nombres,
                                                                clientes.apaterno,
                                                                clientes.amaterno,
                                                                creditos.fecha_prestamo,
                                                                creditos.status,
                                                                creditos.monto,
                                                                creditos.interes,
                                                                creditos.pago_mensual,
                                                                creditos.folio
                                                            FROM
                                                                creditos
                                                            INNER JOIN
                                                                clientes
                                                            ON
                                                                creditos.id_cliente = clientes.id_clientes
                                                                where creditos.status = 1 OR creditos.status =3 ;",$link) or die (mysql_error());
															if(mysql_num_rows($iny_creditos) > 0){
															  while($row = mysql_fetch_array($iny_creditos)){
																echo "<option value='$row[0]'>[#$row[9]] $row[1] $row[2] $row[3] (FP: ".date("d/m/Y",strtotime($row[4])).") ";
																  
																if($row[5] == 3){
																	echo " ¡¡Credito en Juridico!!";
																}
																echo "</option>";
															  }
															}
															 ?>
											</select>
											<!-- END SELECT2 -->
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="credito" class="col-sm-3 control-label">Cliente</label>
										<div class="col-sm-9">
											<!-- SELECT2 -->
											<select disabled name="cliente" id="cliente" class="select2" required onchange="alertaCreditoJuridico(this.value)">
												<option value="">Todos</option>
													<?php
															$iny_creditos = mysql_query("SELECT 
															clientes.id_clientes,
															clientes.nombres,
															clientes.apaterno,
															clientes.amaterno
														FROM
															clientes where status = 'activo' order by clientes.apaterno asc;",$link) or die (mysql_error());
															if(mysql_num_rows($iny_creditos) > 0){
															  while($row = mysql_fetch_array($iny_creditos)){
																echo "<option value='$row[0]'>$row[1] $row[2] $row[3] ";
																  
																
																echo "</option>";
															  }
															}
															 ?>
											</select>
											<!-- END SELECT2 -->
										</div>
									</div>						
								</div>
							</div>
							
							<div class="row">
								<div class="col-xs-6">
								<div class="form-group">
											<label for="metodo-pago" class="col-sm-3 control-label">Estatus del credito</label>
											<div class="col-sm-9">
											<select class="form-control" required name="metodo" id="metodo-pago">
													<option value="">Seleccione una opcion</option>
													<option <?php if($estadoCredito == "200") echo "selected"?> value="200">Todos</option>
													<option <?php if($estadoCredito == "100") echo "selected"?> value="100">Activos</option>
													<option <?php if($estadoCredito == "300") echo "selected"?> value="300">En Juridico</option>
                                            </select>
												</select>
											</div>
										</div>						
								</div>
								<div class="col-xs-6">
									<div class="form-group">
										<label for="inversionista" class="col-sm-3 control-label">Inversionista</label>
										<div class="col-sm-9">
											<select class="form-control" name="inversionista" id="inversionista">
												<option value="">Todos</option>
												<?php
													$iny_creditos = mysql_query("SELECT * FROM inversionistas where status = 'activo' order by nombre asc;",$link) or die (mysql_error());
													if(mysql_num_rows($iny_creditos) > 0){
														while($row = mysql_fetch_array($iny_creditos)){
															echo "<option ";
															if($selectInversionista == $row[0] ){
																echo "selected";
															}
															echo " value='$row[0]'>$row[1]";
															echo "</option>";
														}
													}
												?>
											</select>
										</div>
									</div>						
								</div>						
							</div>
							<div class="row">
								<div class="col-xs-3 col-xs-offset-5">
									<div class="form-group">
										<label class="control-inline fancy-checkbox custom-bgcolor-green">
											<input type="checkbox" id="filtroporfechas" <?php if($valorFiltroFechas == 1) echo 'checked="checked" '; ?> >
												<span>Aplicar Filtro por Fecha de Apertura de Credito</span>
										</label>
									</div>						
								</div>
							</div>
							<input type="hidden" id="valorFiltroFechas" value="<?php echo $valorFiltroFechas; ?>" name="valorFiltroFechas">
							<div class="row">
								<div class="col-xs-6">
									<div class="form-group">
										<label for="datepicker" class="col-sm-3 control-label">Fecha Inicial</label>
										<div class="col-sm-9">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												<!--<input type="text" id="datepicker" class="form-control" name="fecha-pago" readonly required placeholder="Fecha de Pago (Año/Mes/Dia)">-->
												<input type="text" id="datepicker" class="form-control" name="fecha-inicial" value="<?php if(isset($selectFechaInicial)) echo $selectFechaInicial; ?>" disabled placeholder="Fecha Inicial">
											</div>
										</div>
									</div>						
								</div>	
								<div class="col-xs-6">
									<div class="form-group">
										<label for="datepicker2" class="col-sm-3 control-label">Fecha Final</label>
										<div class="col-sm-9">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												<!--<input type="text" id="datepicker" class="form-control" name="fecha-pago" readonly required placeholder="Fecha de Pago (Año/Mes/Dia)">-->
												<input type="text" id="datepicker2" class="form-control" name="fecha-final" value="<?php if(isset($selectFechaFinal)) echo $selectFechaFinal; ?>" disabled placeholder="Fecha Final">
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
						}else{
							//echo "Ya se genero una consulta";
							//$fechaInicial 	= $_POST['fecha-inicial'];
							//$fechaFinal 	= $_POST['fecha-final'];
							
							$estadoCredito;
							if($_POST['inversionista'] != ""){
								$aplicaInversionista = "AND creditos.id_inversionista = '".$_POST['inversionista']."'";
							}else{
								$aplicaInversionista = "";
							}
							$arreglo_condicionales_estatus  = array();
							//
							if($estadoCredito == "100"){
								//ACTIVOS
								$var = 1;
								array_push($arreglo_condicionales_estatus,$var);
							}
							if($estadoCredito == "200"){
								//TODOS LOS CREDITOS
								$var = 1;	
								array_push($arreglo_condicionales_estatus,$var);
								$var2 = 3;	
								array_push($arreglo_condicionales_estatus,$var2);
							}
							if($estadoCredito == "300"){
								//JURIDICO
								$var = 3;	
								array_push($arreglo_condicionales_estatus,$var);
							}
							if($valorFiltroFechas == 1){
								$fi = $_POST['fecha-inicial'];
								$ff = $_POST['fecha-final'];
								$aplicaFechas = "AND (fechadealta BETWEEN '".$fi."' AND '".$ff."')";
							}else{
								$aplicaFechas = "";
							}
							
							
							
							$consultaPERRONA = "select 
								creditos.id_creditos,
								creditos.id_cliente,
								creditos.folio as id_credito,
								creditos.fecha_prestamo,
								creditos.status,
								clientes.nombres,
								clientes.apaterno,
								clientes.amaterno,
								creditos.monto,
								creditos.interes,
								creditos.interes_moratorio, 
								(SELECT SUM(pagos.monto) FROM pagos WHERE pagos.id_credito = creditos.id_creditos and pagos.tipo_pago = 2) as pagos_capital
							FROM 
								creditos
							INNER JOIN
								clientes
								ON creditos.id_cliente = clientes.id_clientes
							WHERE creditos.status IN (".implode(",",$arreglo_condicionales_estatus).") ".$aplicaInversionista." ".$aplicaFechas.";";
							
							
							$iny_consulta = mysql_query($consultaPERRONA,$link) or die (mysql_error());
							if(mysql_num_rows($iny_consulta) > 0){
								echo '
								<div class="widget widget-table">
								<div class="widget-header">
									<h3><i class="fa fa-table"></i>Resultados</h3>
								</div>
								<div class="widget-content">
									
										<table class="table table-bordered">
											<thead>
												<tr>
													<th>Credito</th>
													<th>Estatus Credito</th>
													<th>Nombres</th>
													<th>Fecha de Pago</th>
													<th>Monto Prestamo</th>
													
													<th>Pagos a Capital </th>
													<th>Saldo a Capital </th>

												</tr>
											</thead>
											<tbody>
								';
								$sumatoria_montos_originales = 0;
								$sumatoria_pagos_capital = 0;
								$sumatoria_saldos_capital = 0;
								while($row = mysql_fetch_assoc($iny_consulta)){
									$saldo_credito = $row['monto'] - $row['pagos_capital'];

									$sumatoria_montos_originales += $row['monto'];
									$sumatoria_pagos_capital += $row['pagos_capital'];
									$sumatoria_saldos_capital += $saldo_credito;
									echo '
									<tr>
									<td>#'.$row['id_credito'].'</td>';
									if($row['status'] == 1){
										echo '<td><span class="label label-success">Activo</span></td>';
									}
									if($row['status'] == 3){
										echo '<td><span class="label label-danger">Juridico</span></td>';
									}
									echo '<td>'.$row['nombres'].' '.$row['apaterno'].' '.$row['amaterno'].'</td>';
									echo '<td>'.date('d/m/Y',strtotime($row['fecha_prestamo'])).'</td>';
									echo '<td>$'.number_format(($row['monto']),2).'</td>';
									if($row['pagos_capital'] == 0){
										echo '<td><span class="label label-danger">$'.number_format(($row['pagos_capital']),2).'</span></td>';	
									}else
									{
										echo '<td>$'.number_format(($row['pagos_capital']),2).'</td>';
									}
									echo '<td>$'.number_format(($saldo_credito),2).'</td>';
								echo '</tr>
									';
								}
								echo "<tr><td></td><td></td><td></td><td></td>
								<td><strong>$".number_format(($sumatoria_montos_originales),2)."</strong></td>
								<td><strong>$".number_format(($sumatoria_pagos_capital),2)."</strong></td>
								<td><strong>$".number_format(($sumatoria_saldos_capital),2)."</strong></td>
								</tr>";
								echo '
										</tbody>
										</table>
									
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
		$(document).ready(function() {
			var fecha1 = document.getElementById("datepicker");
			var fecha2 = document.getElementById("datepicker2");
			var valorFiltro = document.getElementById("valorFiltroFechas");
			var chkFiltroFechas = document.getElementById("filtroporfechas");

			$(chkFiltroFechas).change(function() {
				if(this.checked != true) {
					//No esta checked
					
					$(fecha1).attr("disabled","disabled");
					$(fecha2).attr("disabled","disabled");
					$(fecha1).attr("required", "false");
					$(fecha2).attr("required", "false");
					$(valorFiltro).val("0");
					$(fecha1).val("");
					$(fecha2).val("");
				}else{
					//Esta checked
					
					$(fecha1).removeAttr("disabled");
					$(fecha2).removeAttr("disabled");
					$(fecha1).attr("required", "true");
					$(fecha2).attr("required", "true");
					$(valorFiltro).val("1");
				}
			}); 

			if(chkFiltroFechas.checked != true){
				$(fecha1).attr("disabled","disabled");
				$(fecha2).attr("disabled","disabled");
				$(fecha1).attr("required", "false");
				$(fecha2).attr("required", "false");
				$(valorFiltro).val("0");
			}else{
				$(fecha1).removeAttr("disabled");
				$(fecha2).removeAttr("disabled");
				$(fecha1).attr("required", "true");
				$(fecha2).attr("required", "true");
				$(valorFiltro).val("1");
			}
			  
		});
	</script>
	<script>
		$('#reporte_prestamos').submit(function(e){
			e.preventDefault();
			//Check Dates
			if(document.getElementById("datepicker").value > document.getElementById("datepicker2").value){
				alert("Fechas no validas");
				return 0;
			}else{
				document.getElementById("reporte_prestamos").submit();
			}
		});
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

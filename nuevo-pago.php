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
	if(validarAccesoModulos('permiso_pagos') != 1) {
		header("Location: dashboard.php");
	}
	$pagina_actual = "pagos";
	$fecha = date("Y-m-d");
	$fecha_format = date("Y/m/d");
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!-->
<html lang="es" class="no-js">
<!--<![endif]-->

<head>
	<title>Registro de Nuevo Pago | Credinieto</title>
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
			var caloJur= id;
			var caloVend= id;
			
			<?php
				$conocer_en_juridico = mysql_query("select id_creditos from creditos where status=3 ;",$link) or die(mysql_error());
				echo "var myArrJur = [";
				while ($fila_juridico_conocer = mysql_fetch_array($conocer_en_juridico)) {
					echo "'$fila_juridico_conocer[0]',";
				}
					echo "];";
				//Vendido
				$conocer_vendido = mysql_query("select id_creditos from creditos where status=4 ;",$link) or die(mysql_error());
				echo "var myArrVend= [";
				while ($fila_vendido_conocer = mysql_fetch_array($conocer_vendido)) {
					echo "'$fila_vendido_conocer[0]',";
				}
					echo "];";
			?>
			if ( myArrJur.includes(caloJur) ) {
				document.getElementById("alerta").innerHTML = "<div class='alert alert-danger'><h3>El Cliente se encuentra en JURIDICO. Favor de pedir autorizacion para registrar pagos.</h3></div>";
			}
			if ( myArrVend.includes(caloVend) ) {
				document.getElementById("alerta").innerHTML = "<div class='alert alert-warning'><h3>El credito se encuentra VENDIDO. Favor de validar los pagos realizados.</h3></div>";
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
									<li><a href="pagos.php">Pagos</a></li>
									<li class="active">Registro de Nuevo Pago</li>
								</ul>
							</div>

						</div>

			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Registro de Nuevo Pago</h2>
					<em>formulario para registro de nuevo pago</em>
				</div>
				<div class="main-content">
					<!-- HORIZONTAL FORM -->
					<div class="widget">
						<div class="widget-header">

							<h3><i class="fa fa-edit"></i> Registro de Nuevo Pago</h3></div>
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
							<div class="row">
								
                                <form class="form-horizontal" role="form" method="post" action="_registro_nuevo_pago.php" enctype="multipart/form-data">

								<div class="col-md-7">
									<div id="alerta"></div>
                                        <div class="form-group">
												<label for="folio-fisico" class="col-sm-3 control-label">Folio Fisico</label>
												<div class="col-md-9">
													<div class="input-group">
												        <input type="number" class="form-control" id="folio-fisico" name="folio-fisico" placeholder="Folio Fisico" required>
                                                        <span class="input-group-addon">Folio Fisico</span>
											         </div>
												</div>
										</div>
										<div class="form-group">
											<label for="credito" class="col-sm-3 control-label">Credito</label>
											<div class="col-sm-9">
												<!-- SELECT2 -->
														<select name="credito" id="credito" class="select2" required onchange="alertaCreditoJuridico(this.value)">
															<option value="">Seleccione un Credito</option>
															<?php
															//Permitido Eliminar Solo ID de Usuario 1y 3
															if($_SESSION['id_usuario'] == 1 || $_SESSION['id_usuario'] == 3){
																//Permitidos para Agregar pagos en Vendidos
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
                                                                where creditos.status = 1 OR creditos.status =3 OR creditos.status=4;",$link) or die (mysql_error());
																if(mysql_num_rows($iny_creditos) > 0){
																	while($row = mysql_fetch_array($iny_creditos)){
																		echo "<option value='$row[0]'>[#$row[9]] $row[1] $row[2] $row[3] (FP: ".date("d/m/Y",strtotime($row[4])).") ";
																		
																		if($row[5] == 3){
																			echo " ¡¡Credito en Juridico!!";
																		}
																		if($row[5] == 4){
																			echo " ¡¡Credito VENDIDO!!";
																		}
																		echo "</option>";
																	}
																}
															}else{
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
															}
															 ?>
														</select>
													<!-- END SELECT2 -->
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label" for="tipo-pago">Pago Aplicado a</label>
											<div class="col-md-9">
												<select class="form-control" required name="tipo-pago" id="tipo-pago" onchange="limpiarCampos()">
													<option value="">Seleccione una opcion</option>
													<option value="1">Pago Mensual de Intereses</option>
                                                    <option value="2"> Pago de Capital</option>
                                                    
												</select>
											</div>
										</div>
										<div class="form-group">
												<label for="monto-pago" class="col-sm-3 control-label">Monto del Pago</label>
												<div class="col-md-9">
													<div class="input-group">
												<span class="input-group-addon">$</span>
												<input type="number" step=".01" min="0" class="form-control" id="monto-pago" name="monto-pago" placeholder="Monto Pago" required>
											</div>
												</div>
												<div class="col-md-2">
                                            <div id="InfoMonto"></div>
                                        </div>
										</div>
										
										<div class="form-group">
											<label for="datepicker" class="col-sm-3 control-label">Fecha de Aplicacion de Pago</label>
											<div class="col-sm-9">
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
													<!--<input type="text" id="datepicker" class="form-control" name="fecha-pago" readonly required placeholder="Fecha de Pago (Año/Mes/Dia)">-->
													<input type="text" id="datepicker" class="form-control" name="fecha-pago" required placeholder="Fecha en la que se aplica el pago">
												</div>
											</div>
										</div>
                                        <div class="form-group">
											<label for="comentarios" class="col-sm-3 control-label">Comentarios</label>
											<div class="col-sm-9">
												<textarea class="form-control" placeholder="Comentarios" name="comentarios" rows="3"></textarea>
											</div>
										</div>
										<div class="form-group">
											<label for="metodo-pago" class="col-sm-3 control-label">Metodo de Pago</label>
											<div class="col-sm-9">
											<select class="form-control" required name="metodo-pago" id="metodo-pago">
													<option value="">Seleccione una opcion</option>
													<option value="100">Efectivo</option>
                                                    <?php
															$iny_creditos = mysql_query("SELECT * FROM cuentas_bancarias_pago where status = 1;",$link) or die (mysql_error());
															if(mysql_num_rows($iny_creditos) > 0){
															  while($row = mysql_fetch_array($iny_creditos)){
																echo "<option value='$row[0]'>[Banco: $row[1]] Titular: $row[2] (Cuenta: $row[3]) ";
																echo "</option>";
															  }
															}
															 ?>
														</select>
												</select>
											</div>
										</div>
										<input type="hidden" value="primary" name="modulo-registro">
										
								</div>
								<div class="col-xs-5">
									<div id="Info">
										<table class="table table-striped table-condensed table-bordered">
											<tr><td><strong>Numero de Credito</strong></td><td>-</td></tr>
											<tr><td><strong>Estatus</strong></td><td>-</td></tr>
											<tr><td><strong>Interes</strong></td><td>-</td></tr>
											<tr><td><strong>Fecha de Inicio</strong></td><td>-</td></tr>
											<tr><td><strong>Interes Moratorio</strong></td><td>-</td></tr>
											<tr><td><strong>Monto Inicial</strong></td><td>-</td></tr>
											<tr><td><strong>Saldo Actual</strong></td><td>-</td></tr>
											<tr><td><strong>Fecha Limite de Pago</strong></td><td>-</td></tr>
											<tr><td><strong>Meses con Adeudos</strong></td><td>-</td></tr>
											<tr><td><strong>Otros Adeudos</strong></td><td>-</td></tr>
											<tr><td><strong>Monto a Pagar en este MES</strong></td><td>-</td></tr>
										</table>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<div class="form-group">
										<div class="col-sm-3 col-sm-offset-5">
											<a href="pagos.php" class="btn btn-warning btn-block">Cancelar</a>
										</div>
	                                    <div class="col-sm-4">
	                                        <button type="submit" class="btn btn-success btn-block">Registrar Pago</button>
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

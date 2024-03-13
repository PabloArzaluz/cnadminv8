<?php
	session_start(); // crea una sesion
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/functions.php");
	
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	$pagina_actual = "prestamos";
	//PERMISOS
	if(validarAccesoModulos('permiso_inversionistas_cambiar_credito') != 1) {
		header("Location: dashboard.php");
	}
	//FIN PERMISOS
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!-->
<html lang="es" class="no-js">
<!--<![endif]-->

<head>
	<title>Agregar Inversionista a Credito | Credinieto</title>
	<?php
		include("include/head.php");
	?>
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
	<style>
		.tachado-rojo{
			text-decoration: line-through;
			color: red;
		}
		.verde{
			color:green;
		}
	</style>
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
							<div class="col-lg-5 ">
								<ul class="breadcrumb">
									<li><i class="fa fa-home"></i><a href="#">Inicio</a></li>
									<li><a href="prestamos.php">Prestamos</a></li>
									<li class="active">Agregar Inversionista de Credito</li>
								</ul>
							</div>

						</div>

			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Agregar Inversionista de Credito</h2>
					<em>formulario para agregar el inversionista asociado al credito</em>
				</div>
				<div class="main-content">
					<!-- HORIZONTAL FORM -->
					<?php 
						$id_creditos = $_GET['c'];
						
						 $q_conocer_infoInverCred = "SELECT id_inversionistas_creditos,
						 inversionistas_creditos.id_inversionista,
						 nombre as nombreinversionista,
						 inversionistas_creditos.monto as montoasignadoinver,
						 inversionistas_creditos.interes,
						 inversionistas_creditos.comentarios,
						 inversionistas_creditos.fecha_registro,
						 creditos.monto as montocredito
						 from inversionistas_creditos 
						 INNER JOIN inversionistas on inversionistas.id_inversionistas = inversionistas_creditos.id_inversionista 
						 INNER join creditos on creditos.id_creditos = inversionistas_creditos.id_credito
						 where inversionistas_creditos.id_credito=".$id_creditos." and inversionistas_creditos.estatus_en_credito=1;"; 
                        $iny_conocer_infoInverCred = mysqli_query($mysqli,$q_conocer_infoInverCred) or die (mysqli_error());
                        $sumatoria_montos_asignados = 0;
						$montoCredito = 0;
						$inversionistas = array();
						while($fila_conocer_infoInverCred = mysqli_fetch_array($iny_conocer_infoInverCred)){
							$sumatoria_montos_asignados = $sumatoria_montos_asignados + $fila_conocer_infoInverCred['montoasignadoinver'];
							$montoCredito = $fila_conocer_infoInverCred['montocredito'];
							$inversionistas[] = $fila_conocer_infoInverCred['id_inversionista'];
						}

                        $conocer_creditos = "select * from creditos where id_creditos=$id_creditos;"; 
                        $iny_consultar_creditos = mysqli_query($mysqli,$conocer_creditos) or die (mysqli_error());
                        $fila_creditos = mysqli_fetch_assoc($iny_consultar_creditos);
						$monto_disponible_para_asignar = $montoCredito - $sumatoria_montos_asignados;
						
					?>

					<div class="widget">
						<div class="widget-header">

							<h3><i class="fa fa-edit"></i> Agregar Inversionista a Credito</h3></div>
						<div class="widget-content">
							<div class="row">
								<div class="col-lg-12">
									<blockquote>
										<div class="row">
											<div class="col-lg-3 col-md-6">
													Monto Credito Total: 
											</div>
											<div class="col-lg-2 col-md-6">
													$<?php echo number_format($montoCredito,2); ?>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-3 col-md-6">
											Monto Maximo Disponible para Asignar: 
											</div>
											<div class="col-lg-2 col-md-6">
													<?php 
														if($monto_disponible_para_asignar == 0){
															echo "<span class='tachado-rojo'>$ ".number_format($monto_disponible_para_asignar,2)."</span>"; 
														}
														if($monto_disponible_para_asignar > 0){
															echo "<span class='verde'>$ ".number_format($monto_disponible_para_asignar,2)."</span>"; 
														}
														
													?>
											</div>
										</div>
									</blockquote>
								</div>
							</div>
							<div class="row">
								<form class="form-horizontal" role="form" method="post" action="_registro_inversionista_adicional_credito.php">
								<div class="col-md-6">
										<div class="form-group">
											<label for="select2" class="col-sm-3 control-label">Inversionista</label>
											<div class="col-sm-9">
												<!-- SELECT2 -->
														<select name="inversionista" id="select2" class="select2" required>
															<option value="">Seleccione un Inversionista</option>
															<?php
															$iny_clientes = mysqli_query($mysqli,"select * from inversionistas where status='activo';") or die (mysqli_error());
															if(mysqli_num_rows($iny_clientes) > 0){
															  while($row = mysqli_fetch_array($iny_clientes)){
																$stringdisabled = "";
																$stringalerta = "";
																if(in_array($row[0], $inversionistas)){
																	$stringdisabled = " disabled='disabled' ";
																	$stringalerta = " [**YA ASIGNADO]";
																}
																echo "<option $stringdisabled value='$row[0]'>$row[1] ".$stringalerta."</option>";
															  }
															}
															 ?>
														</select>
													<!-- END SELECT2 -->
											</div>
										</div>
										
										<input type="hidden" name="credito" value="<?php echo $id_creditos; ?>">
										<div class="form-group">
											<label for="interes-api" class="col-sm-3 control-label">Interes a Pagar Inversionista</label>
											<div class="col-sm-9">
												<div class="input-group">
												<input type="number" step=".01" required class="form-control" value="1.8" id="interes-api" name="interes-api" placeholder="Interes a pagar Inversionista" >
												<span class="input-group-addon">% (1.8% por default)</span>
												</div>
												
											</div>
										</div>
										<div class="form-group">
											<label for="monto_asignado" class="col-sm-3 control-label">Monto Asignado</label>
											<div class="col-sm-9">
												<div class="input-group">
												
												<input type="number" <?php if($monto_disponible_para_asignar <= 0) echo " disabled "; ?> step=".01" min="0.0" max="<?php echo $monto_disponible_para_asignar; ?>" required class="form-control" value="" id="monto_asignado" name="monto_asignado" placeholder="Monto Asignado" >
												<span class="input-group-addon">Maximo: $<?php echo number_format($monto_disponible_para_asignar,2); ?></span>
												</div>
												
											</div>
										</div>
										<div class="form-group">
											<label for="comentarios" class="col-sm-3 control-label">Comentarios</label>
											<div class="col-sm-9">
												<textarea class="form-control" rows="5" name="comentarios" placeholder="Comentarios"></textarea>
											</div>
										</div>
                                    
								</div>
                            </div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
									<div class=" col-sm-3">
										<a type="button" href="detalle-credito.php?id=<?php echo $id_creditos; ?>"class="btn btn-warning btn-block">Cancelar</a>
									</div>
									<div class=" col-sm-3">
										<button type="submit" <?php if($monto_disponible_para_asignar <= 0) echo " disabled "; ?> class="btn btn-success btn-block">Guardar Inversionista</button>
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

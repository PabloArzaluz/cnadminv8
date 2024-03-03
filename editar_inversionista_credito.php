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
	$pagina_actual = "prestamos";
	//PERMISOS
	if(validarAccesoModulos('permiso_inversionistas') != 1) {
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
	<title>Editar Inversionista de Credito | Credinieto</title>
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
									<li class="active">Editar Inversionista de Credito</li>
								</ul>
							</div>

						</div>

			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Editar Inversionista de Credito</h2>
					<em>formulario para editar el inversionista asociado al credito</em>
				</div>
				<div class="main-content">
					<!-- HORIZONTAL FORM -->
					<?php 
						$id_creditos = $_GET['id'];
						
						$conocer_inversionista = "select * from inversionistas where id_inversionistas=(select id_inversionista from creditos where id_creditos = $id_creditos);"; 
                        $iny_consultar_inversionista = mysql_query($conocer_inversionista, $link) or die (mysql_error());
                        $fila_inversionista = mysql_fetch_row($iny_consultar_inversionista);

                        $conocer_creditos = "select * from creditos where id_creditos=$id_creditos;"; 
                        $iny_consultar_creditos = mysql_query($conocer_creditos, $link) or die (mysql_error());
                        $fila_creditos = mysql_fetch_row($iny_consultar_creditos);
					?>

					<div class="widget">
						<div class="widget-header">

							<h3><i class="fa fa-edit"></i> Editar Inversionista de Credito</h3></div>
						<div class="widget-content">
							<div class="row">
								<div class="col-lg-12">
									<blockquote>
										Al dar guardar se cambiara la asociacion del credito con el inversionista, los pagos que se hayan generado anteriormente se mantendran con el inversionista original.
									</blockquote>
								</div>
							</div>
							<div class="row">

								<form class="form-horizontal" role="form" method="post" action="_editar_inversionista_credito.php" enctype="multipart/form-data">

								<div class="col-md-6">
										<div class="form-group">
											<label for="select2" class="col-sm-3 control-label">Inversionista</label>
											<div class="col-sm-9">
												<!-- SELECT2 -->
														<select name="inversionista" id="select2" class="select2" required>
															<option value="">Seleccione un Inversionista</option>
															<?php
															$iny_clientes = mysql_query("select * from inversionistas where status='activo';",$link) or die (mysql_error());
															if(mysql_num_rows($iny_clientes) > 0){
															  while($row = mysql_fetch_array($iny_clientes)){
																echo "<option value='$row[0]'";
																if($fila_inversionista[0] == $row[0]){
																	echo " selected ";
																}
																echo ">$row[1]</option>";
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
												<input type="number" step=".1" required class="form-control" value="<?php echo $fila_creditos[29]; ?>" id="interes-api" name="interes-api" placeholder="Interes a pagar Inversionista" >
												<span class="input-group-addon">% (1.8% por default)</span>
												</div>
												
											</div>
										</div>
										<div class="form-group">
											<label for="comentarios" class="col-sm-3 control-label">Comentarios</label>
											<div class="col-sm-9">
												<textarea class="form-control" name="comentarios" placeholder="Comentarios"><?php echo $fila_creditos[11]; ?></textarea>
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
										<button type="submit" class="btn btn-success btn-block">Guardar Inversionista</button>
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

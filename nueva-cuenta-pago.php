<?php
	session_start(); // crea una sesion
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/functions.php");
	
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	$pagina_actual = "cuentas-bancarias";
	//PERMISOS
	if(validarAccesoModulos('permiso_agregar_cuentas_bancarias') != 1) {
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
	<title>Registro de Nueva Cuenta Bancaria | Credinieto</title>
	<?php
		include("include/head.php");
	?>
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
							<div class="col-lg-6 ">
								<ul class="breadcrumb">
									<li><i class="fa fa-home"></i><a href="#">Inicio</a></li>
									<li><a href="cuentas-bancarias.php">Cuentas Bancarias</a></li>
									<li class="active">Registro de Nueva Cuenta Bancaria</li>
								</ul>
							</div>

						</div>

			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Registro de Nueva Cuenta Bancaria</h2>
					<em>formulario para registro de nueva cuenta bancaria</em>
				</div>
				<div class="main-content">
					<div class="row">
						<div class="col-md-12">
							<!-- SUPPOR TICKET FORM -->
							<div class="widget">
								<div class="widget-header">
									<h3><i class="fa fa-edit"></i> Nueva Cuenta Bancaria</h3></div>
								<div class="widget-content">
									<form class="form-horizontal" role="form" name="nueva-cuenta-pago" method="post" action="_registro_nueva_cuenta_pago.php" enctype="multipart/form-data">
										<fieldset>
											<legend>Informacion General</legend>
											<div class="form-group">
												<label for="banco" class="col-sm-3 control-label">Banco</label>
												<div class="col-sm-9">
													<input type="text" class="form-control" id="banco" placeholder="Banco" name="banco" required>
												</div>
											</div>
                                            <div class="form-group">
												<label for="titular" class="col-sm-3 control-label">Titular</label>
												<div class="col-sm-9">
													<input type="text" class="form-control" id="titular" placeholder="Titular" name="titular" required>
												</div>
											</div>
											<div class="form-group">
												<label for="cuenta" class="col-sm-3 control-label">Cuenta</label>
												<div class="col-sm-9">
													<input type="text" class="form-control" id="cuenta" placeholder="Cuenta" name="numerocuenta" required>
												</div>
											</div>
                                            <div class="form-group">
												<label for="clabe" class="col-sm-3 control-label">Clabe Interbancaria</label>
												<div class="col-sm-9">
													<input type="text" class="form-control" id="clabe" placeholder="Clabe Interbancaria" name="clabe">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-offset-3 col-sm-9">
													<button type="submit" class="btn btn-primary btn-block">Guardar</button>
												</div>
											</div>
										</fieldset>
										
									</form>
								</div>
							</div>
							<!-- END SUPPORT TICKET FORM -->

</div>
					</div>
					<!-- /row -->
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
</body>

</html>

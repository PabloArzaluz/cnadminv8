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
	$pagina_actual = "clientes";
	//Validar Permisos
	if(validarAccesoModulos('permiso_clientes') != 1) {
		header("Location: dashboard.php");
	}
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!-->
<html lang="es" class="no-js">
<!--<![endif]-->

<head>
	<title>Registro de Nuevo Cliente | Credinieto</title>
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
							<div class="col-lg-4 ">
								<ul class="breadcrumb">
									<li><i class="fa fa-home"></i><a href="#">Inicio</a></li>
									<li><a href="clientes.php">Clientes</a></li>
									<li class="active">Registro de Nuevos Clientes</li>
								</ul>
							</div>

						</div>

			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Registro de Nuevos Clientes</h2>
					<em>formulario para registro de nuevos clientes</em>
				</div>
				<div class="main-content">
					<div class="row">
						<div class="col-md-12">
							<!-- SUPPOR TICKET FORM -->
							<div class="widget">
								<div class="widget-header">
									<h3><i class="fa fa-edit"></i> Nuevo Cliente</h3></div>
								<div class="widget-content">
									<form class="form-horizontal" role="form" name="nuevo-cliente" method="post" action="_registro_nuevo_cliente.php" enctype="multipart/form-data">
										<fieldset>
											<legend>Informacion General</legend>
											<div class="form-group">
												<label for="ticket-name" class="col-sm-3 control-label">Nombre(s)</label>
												<div class="col-sm-9">
													<input type="text" class="form-control" id="ticket-name" placeholder="Nombre(s)" name="nombre" required>
												</div>
											</div>
											<div class="form-group">
												<label for="ticket-name" class="col-sm-3 control-label">Apellido Paterno</label>
												<div class="col-sm-9">
													<input type="text" class="form-control" id="ticket-name" placeholder="Apellido Paterno" name="apaterno" required>
												</div>
											</div>
											<div class="form-group">
												<label for="ticket-name" class="col-sm-3 control-label">Apellido Materno</label>
												<div class="col-sm-9">
													<input type="text" class="form-control" id="ticket-name" placeholder="Apellido Materno" name="amaterno">
												</div>
											</div>
											<div class="form-group">
												<label for="ticket-name" class="col-sm-3 control-label">Direccion</label>
												<div class="col-sm-9">
													<input type="text" class="form-control" id="ticket-name" placeholder="Direccion" name="direccion" required>
												</div>
											</div>
											<div class="form-group">
												<label for="ticket-email" class="col-sm-3 control-label">Telefono(s)</label>
												<div class="col-sm-9">
													<input type="text" class="form-control" id="telefonos" placeholder="Telefonos(s)" name="telefonos">
												</div>
											</div>
											<div class="form-group">
												<label for="ticket-email" class="col-sm-3 control-label">Email</label>
												<div class="col-sm-9">
													<input type="email" class="form-control" id="ticket-email" placeholder="Email" name="email">
												</div>
											</div>
											<div class="form-group">
												<label for="ticket-priority" class="col-sm-3 control-label">Fecha de Nacimiento</label>
												<div class="col-sm-9">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
														<input type="text" id="datepicker" class="form-control" name="fnacimiento" required placeholder="Fecha Nacimiento (Año/Mes/Dia)">
													</div>
												</div>
											</div>
											<div class="form-group">
												<label for="ticket-email" class="col-sm-3 control-label">Domicilio de Trabajo</label>
												<div class="col-sm-9">
													<input type="text" class="form-control" id="ticket-email" placeholder="Domicilio de Trabajo" name="domiciliotrabajo">
												</div>
											</div>
											<div class="form-group">
												<label for="ticket-email" class="col-sm-3 control-label">Telefono Trabajo</label>
												<div class="col-sm-9">
													<input type="text" class="form-control" id="ticket-email" placeholder="Telefono Trabajo" name="telefonotrabajo">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label" for="categoria">Categoria de Cliente</label>
												<div class="col-md-9">
												<select class="form-control" name="categoria" id="categoria">
														<option value="">Sin Categoria</option>
														<option value="0">Clasico</option>
														<option value="1">Dorado</option>
														<option value="2">Premium</option>
													</select>
												</div>
											</div>
										</fieldset>
										<fieldset>
											<legend>Archivos</legend>
											<div class="form-group">
												<label for="ticket-attachment" class="col-sm-3 control-label">Identificacion Oficial</label>
												<div class="col-md-9">
													<input type="file" id="ticket-attachment" name="identificacion-oficial">
													<p class="help-block"><em>Tipos de Archivos Validos: .jpg, .png, .txt, .pdf. Tamaño maximo de archivo: 1 MB</em></p>
												</div>
											</div>
											<div class="form-group">
												<label for="ticket-attachment" class="col-sm-3 control-label">Comprobante de Domicilio</label>
												<div class="col-md-9">
													<input type="file" id="ticket-attachment" name="comprobante-domicilio">
													<p class="help-block"><em>Tipos de Archivos Validos: .jpg, .png, .txt, .pdf. Tamaño maximo de archivo: 1 MB</em></p>
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
				&copy; 2017 The Develovers
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

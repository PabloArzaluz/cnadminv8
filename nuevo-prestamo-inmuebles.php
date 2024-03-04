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
	if(validarAccesoModulos('permiso_prestamos') != 1) {
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
	<title>Registro de Nuevo Prestamo | Credinieto</title>
	<?php
		include("include/head.php");
	?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
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
	<script>
		function submit1(){
			//Volver a registrar
			document.getElementById("oculto").value = 1;
		   document.formulario.submit()
		}
		function submit2(){
			//Gaurdar y siguiente
			document.getElementById("oculto").value = 2;
		   document.formulario.submit()
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
									<li><a href="prestamos.php">Prestamos</a></li>
									<li class="active">Registro de Inmuebles</li>
								</ul>
							</div>

						</div>

			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Registro de Nuevos Prestamo</h2>
					<em>formulario para registro de nuevos prestamo</em>
				</div>
				<div class="main-content">
					<!-- HORIZONTAL FORM -->
					<div class="row">
							<div class="col-xs-12">
								<div class="progress">
	  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"
	  aria-valuenow="66" aria-valuemin="0" aria-valuemax="100" style="width:66%">
	    Registro de Inmuebles
	  </div>

	</div>
							</div>
					</div>

					<div class="widget">
						<div class="widget-header">

							<h3><i class="fa fa-edit"></i> Registro de Inmuebles</h3></div>
						<div class="widget-content">
							<?php
							if(isset($_GET['info'])){
								if($_GET['info'] == '3'){
									echo "<div class='alert alert-success'>
											<a href='' class='close'>&times;</a>
											<strong>Operacion Correcta.</strong> Se registro correctamente el inmueble
									</div>";
								}
                                if($_GET['info'] == '4'){
									echo "<div class='alert alert-danger'>
											<a href='' class='close'>&times;</a>
											<strong>Sin Datos.</strong> No se encontraron datos para registrar, por favor intenta nuevamente.
									</div>";
								}
							}
							?>
							<div class="row">

								<form class="form-horizontal" name="formulario" role="form" method="post" action="_registro_inmuebles.php" enctype="multipart/form-data">

								<div class="col-md-6">
									<div class="form-group">
										<label for="folio-real" class="col-sm-3 control-label">Folio Real</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="folio-real" name="folio-real" placeholder="Folio Real" required>
										</div>
									</div>
										<div class="form-group">
											<label for="comentarios" class="col-sm-3 control-label">Comentarios</label>
											<div class="col-sm-9">
												<textarea name="comentarios" id="comentarios" class="form-control" rows="3" cols="30" placeholder="Comentarios"></textarea>
											</div>
										</div>


								</div>

								<div class="col-md-12">

										<div class="form-group">
											<label for="file1" class="col-sm-3 control-label">Archivo 1</label>
											<div class="col-sm-9">
												<input type="file" name="file1" id="file1">
											</div>
										</div>
									</div>
								<div class="col-md-12">
									<div class="form-group">
										<label for="file2" class="col-sm-3 control-label">Archivo 2</label>
										<div class="col-sm-9">
											<input type="file" name="file2" id="file2">
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label for="file3" class="col-sm-3 control-label">Archivo 3</label>
										<div class="col-sm-9">
											<input type="file" name="file3" id="file3">
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label for="file4" class="col-sm-3 control-label">Archivo 4</label>
										<div class="col-sm-9">
											<input type="file" name="file4" id="file4">
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label for="file5" class="col-sm-3 control-label">Archivo 5</label>
										<div class="col-sm-9">
											<input type="file" name="file5" id="file5">
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label for="file6" class="col-sm-3 control-label">Archivo 6</label>
										<div class="col-sm-9">
											<input type="file" name="file6" id="file6">
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label for="file7" class="col-sm-3 control-label">Archivo 7</label>
										<div class="col-sm-9">
											<input type="file" name="file7" id="file7">
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label for="file8" class="col-sm-3 control-label">Archivo 8</label>
										<div class="col-sm-9">
											<input type="file" name="file8" id="file8">
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label for="nombre-aval" class="col-sm-3 control-label">Archivo 9</label>
										<div class="col-sm-9">
											<input type="file" name="file9" id="file9">
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label for="file10" class="col-sm-3 control-label">Archivo 10</label>
										<div class="col-sm-9">
											<input type="file" name="file10" id="file10">
										</div>
									</div>
								</div>

							</div>
<br><br>
<input type="hidden" id="oculto" name="info" value="">
<input type="hidden" name="id-prestamo" value="<?php echo $_GET['id']; ?>">
<input type="hidden" name="id-cliente" value="<?php echo $_GET['cl']; ?>">
							<div class="row">
								<div class="col-sm-4 col-sm-4 col-sm-offset-4">
									<a href="#" onclick="submit1()" class="btn btn-primary btn-block">Guardar y Registrar otro Inmueble</a>
								</div>
									<div class="col-sm-4 col-sm-4">
										<a href="#" onclick="submit2()" class="btn btn-success btn-block">Guardar y Siguiente</a>
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

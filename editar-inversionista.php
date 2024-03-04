<?php
	session_start(); // crea una sesion
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/functions.php");
	
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	$pagina_actual = "inversionistas";
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
	<title>Editar Inversionista | Credinieto</title>
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
									<li><a href="inversionistas.php">Inversionistas</a></li>
									<li class="active">Editar Inversionista</li>
								</ul>
							</div>

						</div>
			<?php
				$id = $_GET['id'];
				$iny_info = mysqli_query($mysqli,"select * from inversionistas where id_inversionistas=$id;") or die(mysqli_error());
				$fcliente = mysqli_fetch_row($iny_info);
			?>
			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Editar Informacion de Inversionista</h2>
					<em>pagina para editar informacion basica del inversionista</em>
				</div>
				<div class="main-content">
					<div class="row">
						<div class="col-md-12">
							<!-- SUPPOR TICKET FORM -->
							<div class="widget">
								<div class="widget-header">
									<h3><i class="fa fa-edit"></i> Editar Inversionista</h3></div>
								<div class="widget-content">
									<form class="form-horizontal" role="form" name="nuevo-cliente" method="post" action="_editar_inversionista.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
										<fieldset>
											<legend>Informacion General</legend>
											<div class="form-group">
												<label for="nombre" class="col-sm-3 control-label">Nombre(s)</label>
												<div class="col-sm-9">
													<input type="text" class="form-control" id="nombre" placeholder="Nombre(s)" name="nombre" required value="<?php echo $fcliente[1]; ?>" >
												</div>
											</div>
												<div class="form-group">
											<label class="col-md-3 control-label" for="tipo-pago">Tipo de Pago</label>
											<div class="col-md-9">
												<select class="form-control" required name="tipo-pago" id="tipo-pago">
													<option value="">Seleccione una opcion</option>
													<option<?php if($fcliente[3] == 1){echo ' selected'; } ?> value="1">Pago Fijo Mensual</option>
                                                    <option <?php if($fcliente[3] == 2){echo ' selected'; } ?> value="2">Fecha correspondiente al prestamo</option>
												</select>
											</div>
										</div>
											<div class="form-group">
												<label for="comentarios" class="col-sm-3 control-label">Comentarios</label>
												<div class="col-sm-9">
													<textarea class="form-control" placeholder="Comentarios" name="comentarios" rows="3"><?php echo $fcliente[2]; ?></textarea>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-offset-6 col-sm-3">
													<a href="inversionistas.php" type="submit" class="btn btn-warning btn-block">Cancelar</a>
												</div>
												<div class="col-sm-3">
													<button type="submit" class="btn btn-success btn-block">Guardar</button>
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

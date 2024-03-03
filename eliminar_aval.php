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
	//PERMISOS
	if(validarAccesoModulos('permiso_clientes') != 1) {
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
	<title>Eliminar Aval | Credinieto</title>
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
									<li class="active">Eliminar Aval</li>
								</ul>
							</div>

						</div>
			<?php
				$id_aval = $_GET['id'];
				$iny_cliente_info = mysql_query("select * from avales where id_avales=$id_aval;",$link) or die(mysql_error());
				$fcliente = mysql_fetch_row($iny_cliente_info);
			?>
			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Eliminar Aval</h2>
					<em>pagina para eliminar aval</em>
				</div>
				<div class="main-content">
					<div class="row">
						<div class="col-md-12">
							<!-- SUPPOR TICKET FORM -->
							<div class="widget">
								<div class="widget-header">
									<h3><i class="fa fa-edit"></i> Eliminar Aval</h3></div>
								<div class="widget-content">
									<form class="form-horizontal" role="form" name="nuevo-cliente" method="post" action="_editar_cliente.php?id=<?php echo $id_aval; ?>" enctype="multipart/form-data">
										<fieldset>
											<div class="alert alert-danger alert-dismissable">

										<strong>¿SEGURO QUE QUIERES ELIMINAR EL AVAL DE ESTE CREDITO?</strong> <?php echo $fcliente[2]; ?>
										
									</div>






											<div class="row">
												<div class="col-sm-offset-6 col-sm-3">
													<a href="detalle-credito.php?id=<?php echo $fcliente[1]?>" type="submit" class="btn btn-warning btn-block">Cancelar</a>
												</div>
												<div class="col-sm-3">
													<a href="<?php echo "_eliminar_aval.php?id=$id_aval";?>&idCredito=<?php echo $fcliente[1]?>" type="submit" class="btn btn-success btn-block">SI, ELIMINAR</a>
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

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
	<title>Editar Alerta Credito | Credinieto</title>
	<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
	<?php
		include("include/head.php");
	?>
</head>

<body class="sidebar-fixed topnav-fixed forms-elements" onLoad="limpiarform">
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
									<li class="active">Editar Alerta Credito</li>
								</ul>
							</div>

						</div>

			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Editar Alerta a Credito</h2>
					<em>formulario para agregar alerta a un credito.</em>
				</div>
				<div class="main-content">
					<!-- HORIZONTAL FORM -->
					<?php
								//Conocer Folio
								$id_credito = $_GET['id'];
								$conocer_credito = "SELECT * FROM creditos where id_creditos = '$id_credito';";
								$iny_conocer_credito = mysqli_query($mysqli,$conocer_credito) or die(mysqli_error());
								$fcredito = mysqli_fetch_row($iny_conocer_credito);
							?>
							<?php
								$CONOCER_ALERTA_ACTUAL = 'SELECT * from alerta_credito where idCredito = '.$id_credito.' AND status = 1 ORDER BY idAlertaCredito desc limit 1';
                                $INY_CONOCER_ALERTA_ACTUAL = mysqli_query($mysqli,$CONOCER_ALERTA_ACTUAL) or die(mysqli_error());
                                $alertaActivada = 0;
                                if(mysqli_num_rows($INY_CONOCER_ALERTA_ACTUAL) > 0 ){
                                    $alertaActivada = 1;
                                    $FILA_CONOCER_ALERTA_ACTUAL = mysqli_fetch_array($INY_CONOCER_ALERTA_ACTUAL);
                                }
							?>
					<div class="widget">
						<div class="widget-header">

							<h3><i class="fa fa-edit"></i> Editar Alerta a un Credito</h3></div>
						<div class="widget-content">
						<form class="form-horizontal" role="form" name="formModifCredi" method="post" action="_edit_alerta_credito.php" autocomplete="off" enctype="multipart/form-data">
							<input type="hidden" name="credito" value="<?php echo $id_credito; ?>">
							<input type="hidden" name="alerta" value="<?php echo $FILA_CONOCER_ALERTA_ACTUAL[0]; ?>">
							<div class="row">
								<div class="col-lg-12">
									
								</div>
							</div>
							<input type="hidden" name="idCredito" value="<?php echo $id_credito; ?>">
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label class="col-lg-3 control-label">Folio</label>
										<div class="col-lg-4">
											<input type="number" class="form-control input-sm" name="folio" value="<?php echo $fcredito[21]; ?>" autocomplete="off" disabled />
										</div>
									</div>
                				</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="select2" class="col-sm-3 control-label">Cliente</label>
										<div class="col-sm-9">
											<!-- SELECT2 -->
													<?php
														//Conocer Cliente
														$conocer_cliente = "SELECT * FROM clientes where id_clientes = '$fcredito[1]';";
														$iny_conocer_cliente = mysqli_query($mysqli,$conocer_cliente) or die(mysqli_error());
														$fcliente = mysqli_fetch_row($iny_conocer_cliente);

													?>
													<select name="cliente" class="select2" disabled>
														<option value=""><?php echo $fcliente[1]." ".$fcliente[2]." ".$fcliente[3]; ?></option>

													</select>
												<!-- END SELECT2 -->
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="datepicker" class="col-sm-3 control-label">Fecha</label>
										<div class="col-sm-9">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												<input type="hidden" name="fechaAnterior" value="<?php echo $fcredito[4]; ?>">
												<input type="text" id="datepicker" class="form-control" value="<?php echo $FILA_CONOCER_ALERTA_ACTUAL[2]; ?>" name="fecha-alerta" required placeholder="Fecha Inicial (Año/Mes/Dia)">
											</div>
										</div>

									</div>

								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="datepicker" class="col-sm-3 control-label">Comentarios</label>
										<div class="col-sm-9">
											<div class="input-group">
												<textarea class="form-control textarea-with-counter" placeholder="Comentarios" name="comentarios" required rows="6" cols="100"><?php echo $FILA_CONOCER_ALERTA_ACTUAL[3]; ?></textarea>
											</div>
										</div>

									</div>

								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<div class="col-sm-3" >
											<a type="button" href="_delete_alerta_credito.php?id=<?php echo $FILA_CONOCER_ALERTA_ACTUAL[0]; ?>&cred=<?php echo $id_credito; ?>" class="btn btn-danger btn-block">Eliminar Alerta</a>
										</div>
										<div class="col-sm-3  col-xs-offset-3">
											<a type="button" href="detalle-credito.php?id=<?php echo $id_credito; ?>" class="btn btn-warning btn-block">Cancelar</a>
										</div>
										<div class="col-sm-3">
											<button type="submit" class="btn btn-success btn-block">Guardar</button>
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
				&copy; 2017 Syscom León
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

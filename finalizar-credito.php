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
	$pagina_actual = "creditos";
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
	<title>Finalizar Credito | Credinieto</title>
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
							<div class="col-lg-4 ">
								<ul class="breadcrumb">
									<li><i class="fa fa-home"></i><a href="#">Inicio</a></li>
									<li><a href="creditos.php">Creditos</a></li>
									<li class="active">Finalizar Creditos</li>
								</ul>
							</div>

						</div>

			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Finalizacion de Credito</h2>
					<em>formulario para finalizacion de credito</em>
				</div>
				<div class="main-content">
					<!-- HORIZONTAL FORM -->
					<div class="widget">
						<div class="widget-header">

							<h3><i class="fa fa-edit"></i> Finalizacion de Credito</h3></div>
						<div class="widget-content">
							<div class="row">
                                <form class="form-horizontal" role="form" method="post" action="_finalizar_credito.php" enctype="multipart/form-data">
                                    <?php
                                        $id_credito = $_GET['id'];
                                        $conocer_datos_cliente = "SELECT 
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
                                            where creditos.id_creditos= $id_credito;";
                                        $iny_conocer_datos_cliente = mysql_query($conocer_datos_cliente,$link)or die(mysql_error());
                                        $row_credito = mysql_fetch_row($iny_conocer_datos_cliente);
                                    ?>
								<div class="col-md-12">
                                        <div class="form-group">
											<label class="col-md-3 control-label" for="tipo-pago">Estas a punto de finalizar el credito</label>
											<div class="col-md-9">
												<span><?php echo "<strong>Numero de Credito: </strong>[#".$row_credito[9]."]<br>"."<strong> Nombre Cliente: </strong>".$row_credito[1]." ".$row_credito[2]." ".$row_credito[3]." <br><strong>Fecha de Inicio: </strong>".$row_credito[4]." <br><strong>Monto de Credito:</strong> ".$row_credito[6]; ?></span>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label" for="motivo">Motivo</label>
											<div class="col-md-9">
												<select class="form-control" required name="motivo" id="motivo">
													<option value="">Seleccione una opcion</option>
													<option value="1">Cliente liquidó el prestamo</option>
                                                    <option value="2">Hubo una equivocacion al momento de capturar</option>
													<option value="3">Renovación</option>
													<option value="4">Ampliación</option>
												</select>
											</div>
										</div>
										
                                        <div class="form-group">
												<label for="comentarios" class="col-sm-3 control-label">Comentarios</label>
												<div class="col-sm-9">
													<textarea class="form-control" placeholder="Comentarios" name="comentarios" rows="3" required></textarea>
												</div>
											</div>
										
										<input type="hidden" name="id-credito" value="<?php echo $id_credito; ?>">
								</div>
							</div>
							<div class="row">
								<div class="form-group">
                                    <div class="col-sm-offset-8 col-sm-4">
                                        <a href="detalle-credito.php?id=<?php echo $id_credito; ?>" class="btn btn-default">Cancelar</a> <button type="submit" class="btn btn-success">Finalizar Credito</button>
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

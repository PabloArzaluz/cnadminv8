<?php
	session_start(); // crea una sesion
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
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

	RestringirAccesoModulosNoPermitidos("permiso_credito_editar_informacion_basica");
	//FIN PERMISOS
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!-->
<html lang="es" class="no-js">
<!--<![endif]-->

<head>
	<title>Modificar Informacion Basica | Credinieto</title>
	<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
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
				var pagoMSinRedondear = montoCredito * interes;
				var pagoM = Math.round(pagoMSinRedondear * 100) / 100;
				document.getElementById('pago-mensual').value = pagoM;
			}
		}
	</script>
	<script type="text/javascript">
        $(document).ready(function() {
            $('#folio').blur(function(){

                $('#Info').html('<img src="img/loading.gif"  alt="" />').fadeOut(1000);

                var username = $(this).val();
                var dataString = 'username='+username;

                $.ajax({
                    type: "POST",
                    url: "ajax/check_folio.php",
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
function limpiarform(){
	document.formAltaCredito.reset();
}
</script>
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
									<li class="active">Modificar Informacion basica</li>
								</ul>
							</div>

						</div>

			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Modificar Credito</h2>
					<em>formulario para modificacion de informacion basica de credito</em>
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
					<div class="widget">
						<div class="widget-header">

							<h3><i class="fa fa-edit"></i> Modificar Credito</h3></div>
						<div class="widget-content">
						<form class="form-horizontal" role="form" name="formModifCredi" method="post" action="_editar_basico_credito.php" enctype="multipart/form-data">
							<input type="hidden" name="credito" value="<?php echo $id_credito; ?>">
							<div class="row">
								<div class="col-lg-12">
									<blockquote><B>IMPORTANTE:</B> No es posible modificar el campo de <i>Folio y Cliente</i> en esta seccion, para modificar folio, ir a la seccion correspondiente, para modificar cliente, es necesario registrar un nuevo credito.</blockquote>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Folio</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control input-sm" name="folio" value="<?php echo $fcredito[21]; ?>" autocomplete="off" disabled />
                                        </div>
                                        <div class="col-lg-5">
                                            <div id="Info"></div>
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
									<div class="form-group">
										<label for="monto-credito" class="col-sm-3 control-label">Monto del Credito</label>
										<div class="col-md-9">
											<div class="input-group">
												<span class="input-group-addon">$</span>
												<input type="number" <?php if(validarAccesoModulos("permiso_editar_monto_credito") == 0){ echo 'readonly=""'; }?>  pattern="^\d+(\.|\,)\d{2}$" class="form-control" value="<?php echo $fcredito[5]; ?>" id="monto-credito" name="monto-credito" placeholder="Monto Credito" required onblur="calcularPagoMensual()">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="pago-mensual" class="col-sm-3 control-label">Pago Mensual</label>
										<div class="col-md-9">
											<div class="input-group">
												<span class="input-group-addon">$</span>
												<input type="text" id="pago-mensual" class="form-control" value="<?php echo $fcredito[7]; ?>" name="pago-mensual" placeholder="Pago Mensual" required readonly>
											</div>
										</div>
									</div>
									<div class="form-group">
											<label for="interes-moratorio" class="col-sm-3 control-label">Interes Moratorio</label>
											<div class="col-md-9">
												<div class="input-group">
											<input type="number" class="form-control" id="interes-moratorio" name="interes-moratorio" value="<?php echo $fcredito[22]; ?>" required placeholder="Interes Moratorio" step=".1">
											<span class="input-group-addon">% Mens. despues 3 dias</span>
										</div>
											</div>
									</div>
									<div class="form-group">
											<label for="competencia" class="col-sm-3 control-label">Competencia</label>
											<div class="col-md-9">
												<input type="text" class="form-control" id="competencia" name="competencia" value="<?php echo $fcredito[26]; ?>" placeholder="Competencia (no obligatorio)">
											</div>
									</div>
									<div class="form-group">
											<label for="comentario-credito" class="col-sm-3 control-label">Comentario</label>
											<div class="col-md-9">
												<input type="text" class="form-control" id="comentario-credito" name="comentario-credito" value="<?php echo $fcredito[27]; ?>" placeholder="Comentario del Credito (no obligatorio)">
											</div>
									</div>
									<div class="form-group">
										<label for="infonavit" class="col-sm-3 control-label">Infonavit</label>
										<div class="col-md-9">
											<select name="infonavit" id="infonavit" class="form-control">
												<option <?php if($fcredito[30] == 0) echo "selected ";?> value="0">No</option>
												<option <?php if($fcredito[30] == 1) echo "selected ";?> value="1">Si</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="isseg" class="col-sm-3 control-label">ISSEG</label>
										<div class="col-md-9">
											<select name="isseg" id="isseg" class="form-control">
												<option <?php if($fcredito[31] == 0) echo "selected ";?> value="0">No</option>
												<option <?php if($fcredito[31] == 1) echo "selected ";?> value="1">Si</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="datepicker" class="col-sm-3 control-label">Fecha</label>
										<div class="col-sm-6">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												<input type="text" id="datepicker" class="form-control" name="fecha-inicial" value="<?php echo $fcredito[4]; ?>" required placeholder="Fecha Inicial (Año/Mes/Dia)" disabled>
											</div>
										</div>
										<div class="col-sm-3">
											<?php
												//Conocer permisos para modificar fechas del credito.

												if($_SESSION['level_user'] > 3){
													echo '<a href="modificar_fecha_credito.php?id=',$id_credito,'" type="button" class="btn btn-info btn-sm btn-block">Modificar Fecha <i class="fa fa-lock"></i></a>';
												}else{
													echo '<a href="#" type="button" class="btn btn-info btn-sm btn-block" disabled>Modificar Fecha <i class="fa fa-lock"></i></a>';
												}
											?>

										</div>
									</div>
									<div class="form-group">
											<label for="interes-mensual" class="col-sm-3 control-label">Interes Mensual</label>
											<div class="col-md-9">
												<div class="input-group">

											<input type="number" class="form-control" id="interes-mensual" name="interes-mensual" value="<?php echo $fcredito[6]; ?>" required placeholder="Interes mensual" step=".01" onblur="calcularPagoMensual()">
											<span class="input-group-addon">% Mensual</span>
										</div>
											</div>
									</div>
									<div class="form-group">

										<label for="poder" class="col-sm-3 control-label">Poder</label>
										<div class="col-md-9">
											Archivo Actual:
											<?php
												if($fcredito[9] == "" || $fcredito[8] == ""){
													//No hay poder
													echo "<i>No existe archivo.</i>";
												}else{
													echo "<a target='_blank' href='".$fcredito[9]."'>".$fcredito[8]." <i class='fa fa-external-link' aria-hidden='true'></i></a>";
												}
											?>
											<input type="file" id="poder" name="poder">
											<p class="help-block"><em>Tipos de Archivos Validos: .jpg, .png, .txt, .pdf. Tamaño maximo de archivo: 1 MB</em></p>
										</div>
									</div>
									<div class="form-group">
										<label for="mutuo" class="col-sm-3 control-label">Mutuo</label>
										<div class="col-md-9">
											<input type="file" id="mutuo" name="mutuo">
											<p class="help-block"><em>Tipos de Archivos Validos: .jpg, .png, .txt, .pdf. Tamaño maximo de archivo: 1 MB</em></p>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<div class="col-sm-3  col-xs-offset-6">
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

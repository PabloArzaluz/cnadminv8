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

	//Validar Permisos
	if(validarAccesoModulos('permiso_prestamos') != 1) {
		header("Location: dashboard.php");
	}
	
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!-->
<html lang="es" class="no-js">
<!--<![endif]-->

<head>
	<title>Registro de Nuevo Prestamo | Credinieto</title>
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
									<li class="active">Registro de Nuevo Prestamo</li>
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
									  aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width:25%">
										Registro de inmuebles (1/4)
									  </div>
								</div>
							</div>
					</div>

					<div class="widget">
						<div class="widget-header">

							<h3><i class="fa fa-edit"></i> Registro de Nuevo Prestamo</h3></div>
						<div class="widget-content">
						<form class="form-horizontal" role="form" name="formAltaCredito" method="post" action="_registro_nuevo_credito.php" enctype="multipart/form-data">
							<div class="row">
								<div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Folio</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control input-sm" id="folio" name="folio" autocomplete="off" required/>
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
													<select name="cliente" id="select2" class="select2" required>
														<option value="">Seleccione un Cliente</option>
														<?php
														$iny_clientes = mysql_query("select * from clientes where status='activo';",$link) or die (mysql_error());
														if(mysql_num_rows($iny_clientes) > 0){
														  while($row = mysql_fetch_array($iny_clientes)){
														  	$conocer_creditos = "SELECT  (SELECT COUNT(*)FROM creditos where id_cliente = '".$row[0]."' and status= 3) AS total_juridico;";
                                           					$iny_conocer_creditos = mysql_query($conocer_creditos,$link) or die(mysql_error());
				                            				$fcreditosJuridico = mysql_fetch_row($iny_conocer_creditos);
														  	if($fcreditosJuridico[0] > 0){
																  echo "<option disabled='disabled' value='$row[0]'>$row[1] $row[2] $row[3]";
																if($row[16] == "" || $row[16] == 0){ // Es clasico
																	echo " (Clasico)";
																}
																if($row[16] == 1 ){ // Es Dorado
																	echo " (Dorado)";
																}
																if($row[16] == 2 ){ // Es Premium
																	echo "(Premium)";
																}
																 echo" (Cliente en Jurídico)</option>";
														  	}else{
																  echo "<option value='$row[0]'>$row[1] $row[2] $row[3]";
																  if($row[16] == "" || $row[16] == 0){ // Es clasico
																	echo " (Clasico)";
																}
																if($row[16] == 1 ){ // Es Dorado
																	echo " (Dorado)";
																}
																if($row[16] == 2 ){ // Es Premium
																	echo "(Premium)";
																}
																 echo" </option>";
														  	}

														  }
														}
														 ?>
													</select>
												<!-- END SELECT2 -->
										</div>
									</div>
									<div class="form-group">
										<label for="monto-credito" class="col-sm-3 control-label">Monto del Credito</label>
										<div class="col-md-9">
											<div class="input-group">
												<span class="input-group-addon">$</span>
												<input type="number" pattern="^\d+(\.|\,)\d{2}$" class="form-control" id="monto-credito" name="monto-credito" placeholder="Monto Credito" required onblur="calcularPagoMensual()">
											</div>
										</div>
									</div>
									
									<div class="form-group">
										<label for="monto-credito-anterior-amp" class="col-sm-5 control-label">Monto del Credito Anterior <span class='badge'>AMPLIACIÓN</span></label>
										<div class="col-md-7">
											<div class="input-group">
												<span class="input-group-addon">$</span>
												<input type="number" pattern="^\d+(\.|\,)\d{2}$" class="form-control" id="monto-credito-anterior-amp" name="monto-credito-anterior-amp" placeholder="Monto Credito Anterior" >
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="monto-credito-nuevo-amp" class="col-sm-5 control-label">Monto del Credito Nuevo <span class='badge'>AMPLIACIÓN</span></label>
										<div class="col-md-7">
											<div class="input-group">
												<span class="input-group-addon">$</span>
												<input type="number" pattern="^\d+(\.|\,)\d{2}$" class="form-control" id="monto-credito-nuevo-amp" name="monto-credito-nuevo-amp" placeholder="Monto Credito Nuevo" >
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="pago-mensual" class="col-sm-3 control-label">Pago Mensual</label>
										<div class="col-md-9">
											<div class="input-group">
												<span class="input-group-addon">$</span>
												<input type="text" id="pago-mensual" class="form-control" name="pago-mensual" placeholder="Pago Mensual" required readonly>
											</div>
										</div>
									</div>
									<div class="form-group">
											<label for="interes-moratorio" class="col-sm-3 control-label">Interes Moratorio</label>
											<div class="col-md-9">
												<div class="input-group">

											<input type="number" class="form-control" id="interes-moratorio" name="interes-moratorio" required placeholder="Interes moratorio" step=".1">
											<span class="input-group-addon">% Mens. despues 3 dias</span>
										</div>
											</div>
									</div>
									<div class="form-group">
										<label for="competencia" class="col-sm-3 control-label">Competencia</label>
										<div class="col-md-9">
											<input type="text" class="form-control" id="competencia" name="competencia" placeholder="Competencia (no obligatorio)">
										</div>
									</div>
									<div class="form-group">
										<label for="comentario-credito" class="col-sm-3 control-label">Comentario</label>
										<div class="col-md-9">
											<textarea class="form-control" name="comentario-credito" id="comentario-credito" placeholder="Comentarios del Credito (no obligatorio)" cols="30" rows="3"></textarea>
										</div>
									</div>
									<div class="form-group">
										<label for="infonavit" class="col-sm-3 control-label">Infonavit</label>
										<div class="col-md-9">
											<select name="infonavit" id="infonavit" class="form-control">
												<option value="0">No</option>
												<option value="1">Si</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="isseg" class="col-sm-3 control-label">ISSEG</label>
										<div class="col-md-9">
											<select name="isseg" id="isseg" class="form-control">
												<option value="0">No</option>
												<option value="1">Si</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="datepicker" class="col-sm-3 control-label">Fecha de Alta (FA) </label>
										<div class="col-sm-9">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												<input type="text" id="datepicker" class="form-control" name="fechadealta" required placeholder="Fecha de Alta (FA) (Año/Mes/Dia)">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="datepicker2" class="col-sm-3 control-label">Fecha de Cobro (FC)</label>
										<div class="col-sm-9">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												<input type="text" id="datepicker2" class="form-control" name="fecha-inicial" required placeholder="Fecha de Cobro (FC) (Año/Mes/Dia)">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="interes-mensual" class="col-sm-3 control-label">Interes Mensual</label>
										<div class="col-md-9">
											<div class="input-group">
												<input type="number" class="form-control" id="interes-mensual" name="interes-mensual" required placeholder="Interes mensual" step=".01" onblur="calcularPagoMensual()">
												<span class="input-group-addon">% Mensual</span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="poder" class="col-sm-3 control-label">Poder</label>
										<div class="col-md-9">
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
								<div class="col-md-6">
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<div class="form-group">
										<div class="col-sm-offset-6 col-sm-6">
											<button type="submit" class="btn btn-success btn-block">Guardar y Registrar Avales</button>
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

<?php
	session_start(); // crea una sesion
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/functions.php");
	
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	$pagina_actual = "pagos-inversionistas";
	//Validar Permisos
	if(validarAccesoModulos('permiso_inversionistas') != 1) {
		header("Location: dashboard.php");
	}
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!-->
<html lang="es" class="no-js">
<!--<![endif]-->

<head>
	<title>Registro de Nuevo Pago a Inversionista | Credinieto</title>
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
	<script type="text/javascript">
		function alertaCreditoJuridico(id){
			document.getElementById("alerta").innerHTML = "";
			var calo= id;
			
			<?php
				$conocer_en_juridico = mysqli_query($mysqli,"select id_creditos from creditos where status=3;") or die(mysqli_error());
				echo "var myArr = [";
				while ($fila_juridico_conocer = mysqli_fetch_array($conocer_en_juridico)) {
					echo "'$fila_juridico_conocer[0]',";
				}
					echo "];";
			?>
			if ( myArr.includes(calo) ) {
				document.getElementById("alerta").innerHTML = "<div class='alert alert-danger'><h3>El Cliente se encuentra en Juridico. Favor de pedir autorizacion para registrar pagos.</h3></div>";
			}
		}
	</script>
	<script type="text/javascript">
	function showselect(str){
		var xmlhttp; 
		if (str=="")
		 {
		 document.getElementById("txtHint").innerHTML="";
		return;
		 }
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		 }
		else
		 {// code for IE6, IE5
		 xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("creditos").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","include/consulta-creditos.php?c="+str,true);
	xmlhttp.send();
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
							<div class="col-lg-8 ">
								<ul class="breadcrumb">
									<li><i class="fa fa-home"></i><a href="#">Inicio</a></li>
									<li><a href="pagos-inversionistas.php">Pagos Inversionistas</a></li>
									<li class="active">Registro de Nuevo Pago a Inversionista</li>
								</ul>
							</div>

						</div>

			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Registro de Nuevo Pago a Inversionista</h2>
					<em>formulario para registro de nuevo pago a Inversionista</em>
				</div>
				<div class="main-content">
					<!-- HORIZONTAL FORM -->
					<div class="widget">
						<div class="widget-header">

							<h3><i class="fa fa-edit"></i> Registro de Nuevo Pago a Inversionista</h3></div>
						<div class="widget-content">
							<div class="row">
								
                                <form class="form-horizontal" role="form" method="post" action="_registro_nuevo_pago_inversionista.php" enctype="multipart/form-data">

								<div class="col-md-12">
									<div id="alerta"></div>
                                        <div class="form-group">
											<label for="credito" class="col-sm-3 control-label">Inversionista</label>
											<div class="col-sm-9">
												<!-- SELECT2 -->
														<select name="inversionista" id="inversionista" class="select2" required onchange="showselect(this.value)">
															<option value="">Seleccione un Inversionista</option>
															<?php include("include/consulta-inversionistas.php"); ?>
														</select>
													<!-- END SELECT2 -->
											</div>
										</div>
										<div class="form-group">
											<label for="credito" class="col-sm-3 control-label">Credito</label>
											<div class="col-sm-9">
												<!-- SELECT2 -->
												<div id="creditos">
														<select name="credito" id="credito" class="form-control" disabled>
															<option value="">Seleccione un Credito</option>
															
														</select>
												</div>
													<!-- END SELECT2 -->
											</div>
										</div>
										<div class="form-group">
												<label for="monto-pago" class="col-sm-3 control-label">Monto del Pago</label>
												<div class="col-md-9">
													<div class="input-group">
												<span class="input-group-addon">$</span>
												<input type="number" pattern="^\d+(\.|\,)\d{2}$" class="form-control" id="monto-pago" name="monto-pago" placeholder="Monto Pago" required>
											</div>
												</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label" for="tipo-pago">Pago Aplicado a</label>
											<div class="col-md-9">
												<select class="form-control" required name="tipo-pago" id="tipo-pago">
													<option value="">Seleccione una opcion</option>
													<option value="interes">Pago Mensual de Intereses</option>
                                                    <option value="capital">Capital</option>
												</select>
											</div>
										</div>
										<!--<div class="form-group">
											<label for="datepicker" class="col-sm-3 control-label">Fecha de Pago</label>
											<div class="col-sm-9">
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
													<input type="text" id="datepicker" class="form-control" name="fecha-pago" required placeholder="Fecha de Pago (Año/Mes/Dia)">
												</div>
											</div>
										</div>
                                        <div class="form-group">
												<label for="comentarios" class="col-sm-3 control-label">Comentarios</label>
												<div class="col-sm-9">
													<textarea class="form-control" placeholder="Comentarios" name="comentarios" rows="3"></textarea>
												</div>
											</div>-->
										
										
								</div>
							</div>
							<div class="row">
								<div class="form-group">
                                    <div class="col-sm-offset-6 col-sm-6">
                                        <button type="submit" class="btn btn-success btn-block">Registrar Pago</button>
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

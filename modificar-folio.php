<?php
	session_start(); // crea una sesion
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/functions.php");
	
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}

	if(!isset($_GET['id'])){
		header("Location: prestamos.php");
	}
	$pagina_actual = "prestamos";
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!-->
<html lang="es" class="no-js">
<!--<![endif]-->

<head>
	<title>Modificar Folio | Credinieto</title>
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
				var pagoM = montoCredito * interes;
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
									<li class="active">Modificar Folio de Credito</li>
								</ul>
							</div>

						</div>

			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Modificar Folio de Credito</h2>
					<em>formulario para modificacion de folio de credito</em>
				</div>
				<div class="main-content">
					<!-- HORIZONTAL FORM -->
					<div class="widget">
						<div class="widget-header">

							<h3><i class="fa fa-edit"></i> Modificar Folio de Credito</h3></div>
						<div class="widget-content">
						<form class="form-horizontal" role="form" name="formModificarFolio" method="post" action="_editar_folio.php" enctype="multipart/form-data">
							<div class="row">
								<div class="col-lg-12">
									<blockquote>
										<b>Importante:</b> Al modificar el folio del credito debera ser por alguno que este sin utilizar. Favor de verificar antes que el folio este disponible.
									</blockquote>
								</div>
							</div>
							<?php
								//Conocer Folio
								$folio = $_GET['id'];
								$conocer_folio = "SELECT * FROM creditos where id_creditos = '$folio';";
								$iny_conocer_folio = mysqli_query($mysqli,$conocer_folio) or die(mysqli_error());
								$fcredito = mysqli_fetch_row($iny_conocer_folio);
							?>
							<div class="row">
								<div class="col-lg-12">
									<blockquote>
										<b>Folio Actual:</b> <?php echo $fcredito[21]; ?>
									</blockquote>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Folio Nuevo</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control input-sm" id="folio" name="folio" autocomplete="off" required/>
                                        </div>
                                        <div class="col-lg-5">
                                            <div id="Info"></div>
                                        </div>
                                    </div>
                                </div>
							</div>
							<input type="hidden" type="text" value="<?php echo $fcredito[0]; ?>" name="credito">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
									<div class=" col-sm-3">
										<a type="button" href="detalle-credito.php?id=<?php echo $fcredito[0]; ?>"class="btn btn-warning btn-block">Cancelar</a>
									</div>
									<div class=" col-sm-3">
										<button type="submit" class="btn btn-success btn-block">Guardar Folio</button>
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

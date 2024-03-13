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
	if(validarAccesoModulos('permiso_inversionistas_cambiar_credito') != 1) {
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
	<title>Eliminar Inversionista de Credito | Credinieto</title>
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
	<style>
		.tachado-rojo{
			text-decoration: line-through;
			color: red;
		}
		.verde{
			color:green;
		}
	</style>
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
							<div class="col-lg-5 ">
								<ul class="breadcrumb">
									<li><i class="fa fa-home"></i><a href="#">Inicio</a></li>
									<li><a href="prestamos.php">Prestamos</a></li>
									<li class="active">Eliminar Inversionista de Credito</li>
								</ul>
							</div>

						</div>

			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Eliminar Inversionista de Credito</h2>
					<em>formulario para eliminar el inversionista asociado al credito</em>
				</div>
				<div class="main-content">
					<!-- HORIZONTAL FORM -->
					<?php 
						$id_creditos = $_GET['id'];
						$id_inversionista_credito = $_GET['incr'];
						 $q_conocer_infoInverCred = "select id_inversionistas_creditos,inversionistas_creditos.id_inversionista,id_credito,inversionistas_creditos.monto as montoasignadoinver, inversionistas_creditos.interes as interesasignadoinver, inversionistas_creditos.comentarios, inversionistas.nombre as nombreinver,
                         creditos.folio as folio_credito
                         from inversionistas_creditos 
                         inner join inversionistas on inversionistas_creditos.id_inversionista = inversionistas.id_inversionistas
                         inner join creditos on creditos.id_creditos = inversionistas_creditos.id_credito
                         where id_inversionistas_creditos= $id_inversionista_credito and estatus_en_credito=1;"; 
                        $iny_conocer_infoInverCred = mysqli_query($mysqli,$q_conocer_infoInverCred) or die (mysqli_error());
                        $fila_conocer_infoInverCred = mysqli_fetch_assoc($iny_conocer_infoInverCred);
                        $sumatoria_montos_asignados = 0;
						$montoCredito = 0;
					?>

					<div class="widget">
						<div class="widget-header">
                        <form class="form-horizontal" role="form" method="post" action="_del_inversionista_adicional_credito.php">
                            
							<h3><i class="fa fa-edit"></i> Agregar Inversionista a Credito</h3></div>
						<div class="widget-content">
							<div class="row">
                            <input type="hidden" value="<?php echo $id_inversionista_credito; ?>" name="inver_credito">
								<div class="col-lg-12">
									<blockquote>
										<div class="row">
											<div class="col-lg-3 col-md-6">
													Folio Credito: 
											</div>
											<div class="col-lg-2 col-md-6">
													<?php echo $fila_conocer_infoInverCred['folio_credito']; ?>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-3 col-md-6">
											    Inversionista: 
											</div>
											<div class="col-lg-2 col-md-6">
                                                <?php 
                                                    echo $fila_conocer_infoInverCred['nombreinver'];
                                                ?>
											</div>
										</div>
                                        <div class="row">
											<div class="col-lg-3 col-md-6">
											    Monto Asignado Inver: 
											</div>
											<div class="col-lg-2 col-md-6">
                                                $ <?php 
                                                    echo number_format($fila_conocer_infoInverCred['montoasignadoinver'],2);
                                                ?>
											</div>
										</div>
                                        <div class="row">
											<div class="col-lg-3 col-md-6">
											    Intereses Asignado al Inver: 
											</div>
											<div class="col-lg-2 col-md-6">
                                                <?php 
                                                    echo $fila_conocer_infoInverCred['interesasignadoinver'];
                                                ?> %
											</div>
										</div>
                                        <div class="row">
											<div class="col-lg-3 col-md-6">
											    Comentarios:  
											</div>
											<div class="col-lg-9 col-md-6">
                                                <?php 
                                                    echo $fila_conocer_infoInverCred['comentarios'];
                                                ?> 
											</div>
										</div>
									</blockquote>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
									<div class=" col-sm-3">
										<a type="button" href="detalle-credito.php?id=<?php echo $id_creditos; ?>"class="btn btn-warning btn-block">Cancelar</a>
									</div>
									<div class=" col-sm-3">
										<button type="submit" class="btn btn-danger btn-block">Eliminar Inversionista Asignado</button>
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

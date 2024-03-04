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
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>  
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
	  aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
	    Registro de inversionista
	  </div>

	</div>
							</div>
					</div>

					<div class="widget">
						<div class="widget-header">
							<h3><i class="fa fa-edit"></i> Registro de Nuevo Prestamo</h3></div>
						<div class="widget-content">
						<form class="form-horizontal forminversionista" id="forminversionista" role="form" method="post" action="_registro_inversionista_credito.php" enctype="multipart/form-data">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="monto_total_credito" class="col-sm-5 control-label">Monto Total del Credito</label>
										<div class="col-md-6">
											<input type="text" class="form-control" disabled value="$ <?php echo number_format($_SESSION['ammount_new_loan'],2); ?>">
										</div>
									</div>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-md-3">
									<h4>Inversionista</h4>
								</div>
								<div class="col-md-2">
									<h4>Monto Asignado al Inversionista</h4>
								</div>
								<div class="col-md-1">
									<h4>Interes Inversionista</h4>
								</div>
								<div class="col-md-3">
									<h4>Comentarios</h4>
								</div>
							</div>
							<div id="show_item">
								<div class="row">
									<div class="col-md-3 padding-bottom-xs">
									<select class="herramientas_1 select2"  id="select2" style="width: 100%" name="inversionista[]" required>
									<option value="">Seleccione una opcion...</option>
									<?php 
										$conocer_inversionistas = "SELECT * FROM inversionistas where status='activo' ;";
										if ($i_conocer_inversionistas = $mysqli->query($conocer_inversionistas)) {
											while ($f_conocer_inversionistas = $i_conocer_inversionistas->fetch_assoc()) {
												echo "<option value='".$f_conocer_inversionistas['id_inversionistas']."'>".$f_conocer_inversionistas{'nombre'}."</option>";
											}
										}
									?>
									</select>
										<!--<input type="text" name="product_name[]" class="form-control" placeholder="Codigo Herramienta" required>-->
									</div>
									<div class="col-md-2 mb-3">
										<input type="number" step=".01" name="monto_asignado_inver[]" class="form-control" value="" placeholder="Monto para Inversionista" required>
									</div>
									<div class="col-md-1 mb-3">
										<input type="number" step=".1" name="interes_asignado_inver[]" class="form-control" placeholder="Interes" value="1.8" required>
									</div>
									<div class="col-md-3 mb-3">
										<input type="text" name="comentarios_asignado_inver[]" class="form-control" value="" placeholder="Comentarios" required>
									</div>
									
									<div class="col-md-2 mb-3 d-grid">
										<button type="button" class="btn btn-primary add_item_btn">Agregar Mas</button>
									</div>
								</div>
								
							</div>
							<hr>
							<div class="row">
								<div class="col-md-6" id="sumatoria_resultado" >
									<div class="form-group">
										<label for="monto_total_credito" class="col-sm-2 control-label">Sumatoria</label>
										<div class="col-md-3">
											<input type="text" class="form-control" id="sumatoria" disabled value="$ ">
										</div>
									</div>
								</div>
								<div class="col-md-2" id="innerhtmlsumatoria">

								</div>
							</div>
							
							
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<div class="col-sm-offset-3 col-sm-3">
											<button type="submit" class="btn btn-success btn-block guarda">Guardar</button>
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
	<script>
            $(document).ready(function() {
                let count_select = 1;
                $(".add_item_btn").click(function(e){
					
                    event.preventDefault();
                    count_select = count_select+1;
                    $("#show_item").prepend(`<div class="row">
						<div class="col-md-3 padding-bottom-xs">
							<select class="herramientas_`+count_select+`"  style="width: 100%" name="inversionista[]" required>
								<option value="">Seleccione una opcion...</option>
								<?php 
									$conocer_inversionistas = "SELECT * FROM inversionistas where status='activo' ;";
									if ($i_conocer_inversionistas= $mysqli->query($conocer_inversionistas)) {
										while ($f_conocer_inversionistas = $i_conocer_inversionistas->fetch_assoc()) {
											echo "<option value='".$f_conocer_inversionistas['id_inversionistas']."'>".$f_conocer_inversionistas{'nombre'}."</option>";
										}
									}
								?>
							</select>     
						</div>
						<div class="col-md-2 mb-3">
							<input type="number" step=".01" name="monto_asignado_inver[]" class="form-control" placeholder="Monto para Inversionista" value="" required>
						</div>
						<div class="col-md-1 mb-3">
							<input type="number" step=".1" name="interes_asignado_inver[]" class="form-control" placeholder="Interes" value="1.8" required>
						</div>
						<div class="col-md-3 mb-3">
							<input type="text" name="comentarios_asignado_inver[]" class="form-control" placeholder="Comentarios" value="" required>
						</div>
						
						<div class="col-md-2 mb-3 d-grid">
							<button class="btn btn-danger remove_item_btn">Eliminar</button>
						</div>
					</div>`);
                    $('.herramientas_'+count_select+'').select2({
                        width: 'resolve'
                    });
                });
                
                $(document).on('click','.remove_item_btn', function(e){
                    e.preventDefault();
                    let row_item =  $(this).parent().parent();
                    $(row_item).remove();
                });

				$(document).on('submit','.forminversionista', function(e){
                    e.preventDefault();
					var monto_total_credito = <?php echo $_SESSION['ammount_new_loan']; ?>;
					montos_asignados = document.getElementsByName('monto_asignado_inver[]');
					var sumatoria =0;
					for (i=0; i<montos_asignados.length; i++){
						sumatoria = parseFloat(sumatoria) + parseFloat(montos_asignados[i].value);
					}
					
					document.getElementById("sumatoria").value = "$"+parseFloat(sumatoria);

					if(sumatoria != monto_total_credito){
						document.getElementById("innerhtmlsumatoria").innerHTML = "<span class='label label-danger'>Monto NO Coinciden,favor de corregir</span>";
						//alert("Monto Total del Credito y Suma de Montos de Inversionistas no son iguales, Verifica la informacion");
					}else{
						document.getElementById("innerhtmlsumatoria").innerHTML = "<span class='label label-success'>Monto son iguales...Guardando</span>";
						setTimeout(function () {
							document.getElementById("forminversionista").submit();
						}, 1000);
					}
                });

				
            });
        </script>
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

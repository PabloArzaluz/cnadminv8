<?php
	session_start(); // crea una sesion
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/functions.php");
	
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
	<title>Credito a Juridico | Credinieto</title>
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
									<li class="active">Mandar a Juridico</li>
								</ul>
							</div>

						</div>

			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Credito a Juridico</h2>
					<em>formulario para mandar credito a juridico</em>
				</div>
				<div class="main-content">
					<!-- HORIZONTAL FORM -->
					<div class="widget">
						<div class="widget-header">

							<h3><i class="fa fa-edit"></i> Finalizacion de Credito mandando a juridico</h3></div>
						<div class="widget-content">
							<div class="row">
                                <form class="form-horizontal" role="form" method="post" action="_credito_juridico.php?oper=<?php echo $_GET['oper']?>" enctype="multipart/form-data">
									<?php
										
										$operacion = $_GET['oper'];
										//La operacion es agregar nuevo credito 
										if($operacion == "add"){
											$juzgado 			= "";
											$expediente			= "";
											$etapaprocesal 		= "";
											$convenio_file_name = "";
											$comentarios		= "";
										}
										//La operacion es editar el juridico actual
										if($operacion == "edit"){
											$id_juridico = $_GET['juridico'];
											$query_info_juridico = "SELECT * FROM juridicos WHERE id_juridicos = $id_juridico;";
											$iny_info_juridico = mysqli_query($mysqli,$query_info_juridico) or die (mysqli_error());
											$fila_info_juridico = mysqli_fetch_array($iny_info_juridico);
											
											$juzgado 			= $fila_info_juridico['juzgado'];
											$expediente 		= $fila_info_juridico['expediente'];
											$etapaprocesal 		= $fila_info_juridico['etapaprocesal'];
											$convenio_file_name = $fila_info_juridico['convenios_file_name'];
											$comentarios 		= $fila_info_juridico['comentarios'];
											$fechaoperacion 	= $fila_info_juridico['fecha_registro'];
										}
										
										$operacion;
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
											clientes.categoria
                                        FROM
                                            creditos
                                        INNER JOIN
                                            clientes
                                        ON
                                            creditos.id_cliente = clientes.id_clientes
                                            where creditos.id_creditos= $id_credito;";
                                        $iny_conocer_datos_cliente = mysqli_query($mysqli,$conocer_datos_cliente)or die(mysqli_error());
                                        $row_credito = mysqli_fetch_row($iny_conocer_datos_cliente);
                                    ?>
								<div class="col-md-12">
                                        <div class="form-group">
											<label class="col-md-3 control-label" for="tipo-pago">Estas a punto de mandar a juridico el siguiente credito:</label>
											<div class="col-md-9">
												<span><?php echo "<strong>Numero de Credito: </strong>[#".$row_credito[0]."]<br>"."<strong> Nombre Cliente: </strong>".$row_credito[1]." ".$row_credito[2]." ".$row_credito[3]." <br><strong>Fecha de Inicio: </strong>".$row_credito[4]." <br><strong>Monto de Credito:</strong> ".$row_credito[6]; ?></span>
											</div>
										</div>
										<?php if($operacion == "edit"){ ?>
										<div class="form-group">
											<label class="col-md-3 control-label" for="fecha-operacion">Fecha de Operacion</label>
											<div class="col-md-9">
												<input type="text" disabled id="fecha-operacion" class="form-control" name="fecha-operacion" value="<?php echo $fechaoperacion; ?>" required placeholder="Fecha de Operacion">
											</div>
										</div>
										<?php } ?>
										<div class="form-group">
											<label class="col-md-3 control-label" for="juzgado">Juzgado</label>
											<div class="col-md-9">
												<input type="text" id="juzgado" class="form-control" name="juzgado" value="<?php echo $juzgado; ?>" required placeholder="Juzgado">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label" for="expediente">Expediente</label>
											<div class="col-md-9">
												<input type="text" id="expediente" class="form-control" name="expediente" value="<?php echo $expediente; ?>" required placeholder="Expediente">
											</div>
										</div>
                                        <div class="form-group">
												<label for="etapa-procesal" class="col-sm-3 control-label">Etapa Procesal</label>
												<div class="col-sm-9">
													<textarea class="form-control" id="etapa-procesal" placeholder="Etapa Procesal" name="etapa-procesal" rows="3"><?php echo $etapaprocesal; ?></textarea>
												</div>
											</div>
                                        <div class="form-group">
                                            <label for="convenio" class="col-sm-3 control-label">Convenio</label>
                                            <div class="col-md-9">
												<?php 
												if($convenio =! ""){
													echo "<strong>Archivo Actual: </strong>".$convenio_file_name; 
												} 
												?>
                                                <input type="file" id="convenio" name="convenio">
                                                <p class="help-block"><em>Tipos de Archivos Validos: .jpg, .png, .txt, .pdf. Tamaño maximo de archivo:3 MB</em></p>
                                            </div>
                                        </div>
										<div class="form-group">
												<label for="comentarios" class="col-sm-3 control-label">Comentarios</label>
												<div class="col-sm-9">
													<textarea class="form-control" id="comentarios" placeholder="Comentarios" name="comentarios" rows="3"><?php echo $comentarios; ?></textarea>
												</div>
											</div>									
										<input type="hidden" name="id-credito" value="<?php echo $id_credito; ?>">
										<input type="hidden" name="operacion" value="<?php echo $operacion; ?>">
										
										<?php
											if($operacion == "edit"){
												echo '<input type="hidden" name="id_juridico" value="'.$id_juridico.'">';
											}
										?>
								</div>
							</div>
							<div class="row">
								<div class="form-group">
                                    <div class="col-sm-offset-8 col-sm-4">
                                        <a href="detalle-credito.php?id=<?php echo $id_credito; ?>" class="btn btn-default">Cancelar</a> 
										<button type="submit" class="btn btn-success">
										<?php
											if($operacion == "add"){
												echo "Finalizar Credito";
											}
											if($operacion == "edit"){
												echo "Editar Informacion de Juridico";
											}
										?>
										</button>
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

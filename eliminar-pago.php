<?php
	session_start(); // crea una sesion
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/functions.php");
	
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	if(!isset($_GET['idpago'])){
		header("Location: pagos.php");
	}
	$pagina_actual = "pagos";
	//PERMISOS
	if(validarAccesoModulos('permiso_eliminar_pagos') != 1) {
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
	<title>Eliminar Pago | Credinieto</title>
	<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
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
									<li><a href="prestamos.php">Pagos</a></li>
									<li class="active">Eliminar Pago</li>
								</ul>
							</div>

						</div>

			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Eliminar Pago</h2>
					<em>confirmacion de eliminacion de credito</em>
				</div>
				<div class="main-content">
					<!-- HORIZONTAL FORM -->
					<div class="widget">
						<div class="widget-header">

							<h3><i class="fa fa-edit"></i> Eliminar Pago</h3></div>
						<div class="widget-content">
						<form class="form-horizontal" role="form" name="formModificarFolio" method="post" action="_eliminar_pago.php" enctype="multipart/form-data">
							<div class="row">
								<div class="col-lg-12">
									<div class="alert alert-danger alert-dismissable">
										<strong>IMPORTANTE.</strong> Toda la informacion relacionada a este PAGO se eliminara y no sera posible recuperarla.
									</div>
								</div>
							</div>
							<?php
								//Conocer Folio
								$pago = $_GET['idpago'];
								$conocer_pago = "SELECT * FROM pagos_vista_simple WHERE id_pagos = '$pago';";
								$iny_conocer_pago = mysqli_query($mysqli,$conocer_pago) or die(mysqli_error());
								$fpago = mysqli_fetch_array($iny_conocer_pago);
							?>
							<div class="row">
								<div class="col-lg-12">
									<blockquote>
										<b>Informacion de Pago: </b> <br>
										<table>
											<tr><td>Folio Pago: </td><td><?php echo $fpago['folio_fisico']; ?></td></tr>
											<tr><td>Credito: </td><td>#<?php echo $fpago['folio']; ?></td></tr>
											<tr><td>Cliente: </td><td><?php echo $fpago['nombres']." ".$fpago['apaterno']." ".$fpago['amaterno']; ?></td></tr>
											<tr><td>Monto de Pago: </td><td>$<?php echo $fpago['monto']; ?></td></tr>
											<tr><td>Fecha Pago: </td><td><?php echo $fpago['fecha_pago']; ?></td></tr>
											<tr><td>Fecha Pago: </td><td><?php echo $fpago['fecha_pago']; ?></td></tr>
											<tr><td>Tipo de Pago: </td><td><?php if($fpago['tipo_pago'] == 1){
                                                 echo "<span class='label label-success'>Pago de Intereses</span>";
                                             }
                                            if($fpago['tipo_pago'] == 2){
                                                 echo "<span class='label label-primary'>Pago a Capital</span>";
                                             }
                                             if($fpago['tipo_pago'] == 3){
                                                 echo "<span class='label label-info'>Pago de Adeudos</span>";
                                             } ?></td></tr>
											 <tr><td>Metodo de Pago: </td><td>
											 <?php 
											 	if($fpago['metodo_pago'] == 100){
													echo "<i class='fa fa-money' aria-hidden='true'></i> Efectivo";
												}elseif($fpago['metodo_pago'] == 0){
													echo "<i class='fa fa-question' aria-hidden='true'></i> No Info";
												}else{
													echo "<i class='fa fa-university' aria-hidden='true'></i> ".$fpago['banco']."<br><i class='fa fa-male' aria-hidden='true'></i> ".$fpago['titular'];
												}
											 ?></td></tr>
											<tr><td>Comentarios: </td><td><?php echo $fpago['comentarios']; ?></td></tr>
										</table>
										
										
									</blockquote>
								</div>
							</div>
							<input type="hidden" type="text" value="<?php echo $fpago['id_pagos']; ?>" name="idpago">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
									<div class=" col-sm-3">
										<a type="button" href="pagos.php"class="btn btn-warning btn-block">Cancelar</a>
									</div>
									<div class=" col-sm-3">
										<button type="submit" class="btn btn-danger btn-block">Si, deseo eliminar este pago</button>
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

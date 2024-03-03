<?php
	session_start(); // crea una sesion
    ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
    include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/functions.php");
    $link = Conecta();
	date_default_timezone_set('America/Mexico_City');
	//PERMISOS
		//No require permisos especiales
	//FIN PERMISOS
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!-->
<html lang="es" class="no-js">
<!--<![endif]-->

<head>
	<title>Perfil | Credinieto </title>
	<?php
		include("include/head.php");
	?>
</head>

<body class="sidebar-fixed topnav-fixed dashboard4">
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
						<li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
						<li class="active">Mi Perfil</li>
					</ul>
				</div>
			</div>
			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Mi Perfil</h2>
					<em>pagina de perfil de usuario</em>
				</div>
				<div class="main-content">
					<!-- NAV TABS -->
					<ul class="nav nav-tabs nav-tabs-custom-colored tabs-iconized">
						<li class="active"><a href="#settings-tab" data-toggle="tab"><i class="fa fa-gear"></i> Configuración</a></li>
					</ul>
					<!-- END NAV TABS -->
					<div class="tab-content profile-page">
						<!-- SETTINGS TAB CONTENT -->
						<div class="tab-pane settings active" id="settings-tab">
						 <?php
						 	if(isset($_GET['info'])){
                                if($_GET['info'] == '1'){
                                    echo "<div class='alert alert-danger'>
                                            <a href='' class='close'>&times;</a>
                                            <strong>Datos Incorrectos.</strong> Las contraseñas no son iguales, por favor vuelva a capturar la informacion.
                                    </div>";
                                }
                                if($_GET['info'] == '2'){
                                    echo "<div class='alert alert-danger'>
                                            <a href='' class='close'>&times;</a>
                                            <strong>Datos Incorrectos.</strong> La contraseña actual no es la correcta.
                                    </div>";
                                }
                                if($_GET['info'] == '3'){
                                    echo "<div class='alert alert-success'>
                                            <a href='' class='close'>&times;</a>
                                            <strong>Operacion Correcta.</strong> La contraseña fue cambiada con exito, favor de ingresarla en el proximo inicio de sesion.
                                    </div>";
                                }
                            }
                         ?>
							<form method="post" action="_cambiar_contrasena.php" class="form-horizontal" role="form">
								<fieldset>
									<h3><i class="fa fa-square"></i> Cambiar Contraseña</h3>
									<div class="form-group">
										<label for="old-password" class="col-sm-3 control-label">Contraseña Actual</label>
										<div class="col-sm-4">
											<input type="password" id="old-password" name="old-password" class="form-control" required>
										</div>
									</div>
									<hr />
									<div class="form-group">
										<label for="password1" class="col-sm-3 control-label">Contraseña Nueva</label>
										<div class="col-sm-4">
											<input type="password" id="password1" name="password1" class="form-control" required>
										</div>
									</div>
									<div class="form-group">
										<label for="password2" class="col-sm-3 control-label">Repetir Contraseña Nueva</label>
										<div class="col-sm-4">
											<input type="password" id="password2" name="password2" class="form-control" required>
										</div>
									</div>
								</fieldset>


							
							<p class="text-center"><button type="submit" class="btn btn-custom-primary"><i class="fa fa-floppy-o"></i> Cambiar Contraseña</button></p>
							</form>
						</div>
						<!-- END SETTINGS TAB CONTENT -->
					</div>
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
	<?php
		include("include/footer-js.php")
	 ?>
</body>

</html>

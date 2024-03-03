<?php
	session_start(); // crea una sesion
	error_reporting(E_ALL); ini_set("display_errors", 1);
    //ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
    include("conf/conecta.inc.php");
    include("conf/config.inc.php");
    
    date_default_timezone_set('America/Mexico_City');
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!-->
<html lang="es" class="no-js">
<!--<![endif]-->

<head>
	<title>Acceso | Portal Credinieto</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="description" content="Portal Credinieto">
	<meta name="author" content="Pablo Cortes Arzaluz">
	<!-- CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="css/main.css" rel="stylesheet" type="text/css">
	<!--[if lte IE 9]>
		<link href="css/main-ie.css" rel="stylesheet" type="text/css" />
		<link href="css/main-ie-part2.css" rel="stylesheet" type="text/css" />
	<![endif]-->
	<!-- Fav and touch icons -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-icon-144x144.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-icon-114x114.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-icon-72x72.png">
	<link rel="apple-touch-icon-precomposed" sizes="57x57" href="ico/apple-icon-57x57.png">
	<link rel="shortcut icon" href="ico/favicon.ico">
	<meta name="robots" content="noindex">
</head>

<body>
	<div class="wrapper full-page-wrapper page-auth page-login text-center">
		<div class="inner-page">
			<div class="logo">
				<a href="index.html"><img src="img/logo-credinieto-medium.png" alt="" /></a>
			</div>


			<div class="login-box center-block">
				<?php
					if(isset($_GET['alert'])){
						if($_GET['alert'] == 1){
							echo "<div class='widget-content'>
								<div class='alert alert-danger'>
									<strong>Usuario o Contraseña Incorrecto.</strong>
								</div>
							</div>";
						}
						if($_GET['alert'] == 3){
							echo "<div class='widget-content'>
								<div class='alert alert-success'>
									<strong>¡Cierre de Sesion Exitoso!</strong>
								</div>
							</div>";
						}
					}

				?>
				<form class="form-horizontal" role="form" method="post" action="_validar_acceso.php">
					<p class="title">Ingresa tu Usuario</p>
					<div class="form-group">
						<label for="username" class="control-label sr-only">Usuario</label>
						<div class="col-sm-12">
							<div class="input-group">
								<input type="text" name="user" placeholder="usuario" id="username" class="form-control" autofocus>
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
							</div>
						</div>
					</div>
					<label for="password" class="control-label sr-only">Contraseña</label>
					<div class="form-group">
						<div class="col-sm-12">
							<div class="input-group">
								<input type="password" name="password" placeholder="contraseña" id="password" class="form-control">
								<span class="input-group-addon"><i class="fa fa-lock"></i></span>
							</div>
						</div>
					</div>
					<label class="fancy-checkbox">
						<input type="checkbox">
						<span>Recordarme la proxima vez</span>
					</label>
					<button class="btn btn-custom-primary btn-lg btn-block btn-auth"><i class="fa fa-arrow-circle-o-right"></i> Entrar</button>
				</form>
				<div class="links">
					<p><a href="#">¿Olvidaste tu nombre de usuario o Contraseña?</a></p>

				</div>
			</div>
		</div>
	</div>
	<footer class="footer">&copy; 2017 - Syscom León</footer>
	<!-- Javascript -->
	<script src="js/jquery-2.1.0.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/modernizr.js"></script>
</body>

</html>

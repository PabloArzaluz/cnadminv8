<?php
	session_start(); // crea una sesion
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/functions.php");
    date_default_timezone_set('America/Mexico_City');
	
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	$pagina_actual = "buscar";
	$fecha_actual = date("Y-m-d");
	//PERMISOS
	if(validarAccesoModulos('permiso_buscar') != 1) {
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
	<title>Buscar | Portal Credinieto</title>
	<?php
		include("include/head.php");
	?>
</head>

<body class="sidebar-fixed topnav-fixed ">
	<!-- WRAPPER -->
	<div id="wrapper" class="wrapper">
		<?php
			include("include/top-bar.php");
			include("include/left-sidebar.php");
		 ?>
		<!-- MAIN CONTENT WRAPPER -->
		<?php
			$buscar = $_GET["v"];
			

		?>
		<div id="main-content-wrapper" class="content-wrapper ">
			<div class="row">
				<div class="col-lg-4 ">
					<ul class="breadcrumb">
						<li><i class="fa fa-home"></i><a href="dashboard.php">Dashboard</a></li>
						<li class="active">Buscar</li>
					</ul>
				</div>
			</div>
			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Buscar: "<?php echo $buscar; ?>"</h2>
					<em>Resultados</em>
				</div>
				<div class="main-content">
					<!-- ACTIVITY TAB CONTENT -->
						<div class="tab-pane activity" id="activity-tab">
							<ul class="list-unstyled activity-list">
								<?php
									$conocer_resultados_avales = "SELECT * FROM avales WHERE nombre_completo LIKE '%$buscar%' ";
									$iny_conocer_resultados_avales = mysqli_query($mysqli,$conocer_resultados_avales) or die(mysqli_error());
									$numero_avales = mysqli_num_rows($iny_conocer_resultados_avales);
									echo "<h2>Avales</h2> <i>$numero_avales resultados</i>";
									if(mysqli_num_rows($iny_conocer_resultados_avales) > 0){
                                        echo "<li>";
                                        echo "<table class='table'>";
                                        while($favales = mysqli_fetch_array($iny_conocer_resultados_avales)){
                                        	echo "<tr><td><i class='fa fa-credit-card' aria-hidden='true'></i> &nbsp;</td><td> <b>  $favales[2]</b> </td><td>&nbsp;es aval en el credito</td><td> <a href='detalle-credito.php?id=$favales[1]'>$favales[1]</a> <td><span class='timestamp'></span></td></tr>";
                                        }
                                        echo "</table>";
                                        echo "</li>";
                                    }else{
                                    	echo "<hr>";
                                    }
								?>
								<?php
									$conocer_resultados_clientes = "SELECT * FROM clientes WHERE nombres LIKE '%$buscar%' or  apaterno LIKE '%$buscar%' OR amaterno LIKE '%$buscar%';";
									$iny_conocer_resultados_clientes = mysqli_query($mysqli,$conocer_resultados_clientes) or die(mysqli_error());
									$numero_clientes = mysqli_num_rows($iny_conocer_resultados_clientes);
									echo "<h2>Clientes</h2> <i>$numero_clientes resultados</i>";
									if(mysqli_num_rows($iny_conocer_resultados_clientes) > 0){
                                        echo "<li>";
                                        echo "<table class='table'>";
                                        while($fclientes = mysqli_fetch_array($iny_conocer_resultados_clientes)){
                                        	echo "<tr><td><i class='fa fa-group' aria-hidden='true'></i> &nbsp;</td><td> <a href='cliente-profile.php?id=$fclientes[0]'><b>  $fclientes[1] $fclientes[2] $fclientes[3]</b> </a></td></tr>";
                                        }
                                        echo "</table>";
                                        echo "</li>";
                                    }else{
                                    	echo "<hr>";
                                    }
								?>
								<?php
									$conocer_resultados_inversionistas = "SELECT * FROM inversionistas WHERE status NOT LIKE 'inactivo' and nombre LIKE '%$buscar%';";
									$iny_conocer_resultados_inversionistas = mysqli_query($mysqli,$conocer_resultados_inversionistas) or die(mysqli_error());
									$numero_inversionistas = mysqli_num_rows($iny_conocer_resultados_inversionistas);
									echo "<h2>Inversionistas</h2> <i>$numero_inversionistas resultados</i>";
									if(mysqli_num_rows($iny_conocer_resultados_inversionistas) > 0){
                                        echo "<li>";
                                        echo "<table class='table'>";
                                        while($finversionistas = mysqli_fetch_array($iny_conocer_resultados_inversionistas)){
                                        	echo "<tr><td><i class='fa fa-briefcase' aria-hidden='true'></i> &nbsp;</td><td> <a href='detalle-inversionista.php?id=$finversionistas[0]'><b>  $finversionistas[1]</b> </a></td></tr>";
                                        }
                                        echo "</table>";
                                        echo "</li>";
                                    }else{
                                    	echo "<hr>";
                                    }
								?>
							</ul>
							
						</div>
						<!-- END ACTIVITY TAB CONTENT -->
					
					
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
	<script src="assets/js/jquery/jquery-2.1.0.min.js"></script>
	<script src="assets/js/bootstrap/bootstrap.js"></script>
	<script src="assets/js/plugins/modernizr/modernizr.js"></script>
	<script src="assets/js/plugins/bootstrap-tour/bootstrap-tour.custom.js"></script>
	<script src="assets/js/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/js/king-common.js"></script>
	<script src="assets/js/plugins/bootstrap-switch/bootstrap-switch.min.js"></script>
</body>

</html>

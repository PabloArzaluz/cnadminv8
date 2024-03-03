<?php
	session_start(); // crea una sesion
	ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/functions.php");
	date_default_timezone_set('America/Mexico_City');
	$link = Conecta();
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	//Validar Permisos
	if(validarAccesoModulos('permiso_agregar_cuentas_bancarias') != 1) {
		header("Location: dashboard.php");
	}
	$pagina_actual = "cuentas-bancarias";
	function fecha_meses($val){
		$f = date('Y-m-d');
		$fecha= strtotime($val.' month',strtotime($f));
		$fecha= date('m',$fecha);

		return $fecha;
	}
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!-->
<html lang="es" class="no-js">
<!--<![endif]-->
<head>
	<title>Cuentas Bancarias | Credinieto</title>
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
		<div id="main-content-wrapper" class="content-wrapper ">
			<div class="row">
				<div class="col-lg-4 ">
					<ul class="breadcrumb">
						<li><i class="fa fa-home"></i><a href="#">Inicio</a></li>
						<li><a href="#">Configuraciones</a></li>
						<li class="active">Cuentas Bancarias</li>
					</ul>
				</div>
			</div>
			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Cuentas Bancarias</h2>
					<em>pagina de cuentas bancarias</em>
				</div>
				<div class="main-content">
					<!-- FEATURED DATA TABLE -->
					<div class="widget widget-table">
						<div class="widget-header">
							<h3><i class="fa fa-table"></i> Cuentas Bancarias</h3> <em> -  pagina donde se muestran los inversionistas</em></div>
						<div class="widget-content">
                            	<?php
								//Operaciones
								if(isset($_GET['info'])){
									if($_GET['info'] == '1'){
										echo "<div class='alert alert-success'>
												<a href='' class='close'>&times;</a>
												<strong>Operacion Correcta.</strong> Se agrego correctamente el cliente
										</div>";
									}
                                    if($_GET['info'] == '2'){
										echo "<div class='alert alert-success'>
												<a href='' class='close'>&times;</a>
												<strong>Operacion Correcta.</strong> Se edito correctamente el cliente.
										</div>";
									}
                                    if($_GET['info'] == '3'){
										echo "<div class='alert alert-success'>
												<a href='' class='close'>&times;</a>
												<strong>Operacion Correcta.</strong> Se elimino correctamente el cliente.
										</div>";
									}
									

								}
							 ?>
							<div class="col-lg-12 ">
								<div class="top-content">
									<a href="nueva-cuenta-pago.php" type="button" class="btn btn-success"><i class="fa fa-plus-square"></i> Agregar Nueva Cuenta de Pago</a>
								</div>
							</div>
							<table id="tablita" class="table table-sorting table-hover datatable">
								<thead>
									<tr>
										<th>Banco</th>
										<th>Titular</th>
										<th>Numero Cuenta</th>										
										<th>Clabe</th>
										<th>Fecha Registro</th>
									</tr>
								</thead>
								<tbody>
									<?php
										//Consulta Cientes
										$iny_clientes = mysql_query("select * from cuentas_bancarias_pago where status=1 order by fecha_registro desc;",$link) or die (mysql_error());
										if(mysql_num_rows($iny_clientes) > 0){
							              while($row = mysql_fetch_array($iny_clientes)){
							                echo "<tr>";
											echo "<td>".$row[1]."</td>";
											echo "<td>".$row[2]."</td>";
                                            echo "<td>".$row[3]."</td>";
							                echo "<td>".$row[4]."</td>";
											echo "<td>".$row[6]."</td>";
                                            //echo "<td> <a href='#' onclick='return false;' disabled type='button' class='btn btn-warning btn-xs'>Editar</a> <a href='eliminar_inversionista.php?id=$row[0]' type='button' class='btn btn-danger btn-xs'>Eliminar</a></td></tr>";
							              }
							            }
										?>

								</tbody>
							</table>
						</div>
					</div>
					<!-- END FEATURED DATA TABLE -->
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
	<?php
		include("include/footer-js.php")
	 ?>
	  <script type="text/javascript">$(function(){$('[data-toggle="tooltip"]').tooltip()})</script>
     <script type="text/javascript">$(".top").tooltip({placement:"top"});</script>
	<script type="text/javascript">
	 $(document).ready(function() {
		 $('#tablita').DataTable( {
			  "order": [[ 4, "desc" ]]
			  
			 
		 });
		} );
	 </script>
</body>

</html>

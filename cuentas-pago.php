<?php
	session_start(); // crea una sesion
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/functions.php");
	
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	$pagina_actual = "pagos";
	//Validar Permisos
	if(validarAccesoModulos('permiso_pagos') != 1) {
		header("Location: dashboard.php");
	}
	function acortar($texto,$largo) {
        if(strlen($texto) >= 20){
            return substr($texto,0,$largo).'...';
    	}else{
            return $texto;
        }
    }
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!-->
<html lang="es" class="no-js">
<!--<![endif]-->

<head>
	<title>Cuentas de Pago | Credinieto</title>
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
						<li><a href="pagos.php">Pagos</a></li>
						<li class="active">Cuentas de Pago</li>
					</ul>
				</div>

			</div>
			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Cuentas</h2>
					<em>cuentas bancarias de pago de creditos</em>
				</div>

				<div class="main-content">
					<!-- FEATURED DATA TABLE -->
					<div class="widget widget-table">
						<div class="widget-header">
							<h3><i class="fa fa-table"></i> Cuentas</h3> <em> -  cuentas bancarias de pago</em></div>
						<div class="widget-content">

							<?php
								//Operaciones
								if(isset($_GET['info'])){
									if($_GET['info'] == '2'){
										echo "<div class='alert alert-success'>
												<a href='' class='close'>&times;</a>
												<strong>Operacion Correcta.</strong> Se elimino correctamente el cliente
										</div>";
									}
									if($_GET['info'] == '1'){
										echo "<div class='alert alert-success'>
												<a href='' class='close'>&times;</a>
												<strong>Operacion Correcta.</strong> Se modifico correctamente el cliente
										</div>";
									}
									if($_GET['info'] == '3'){
											echo "<div class='alert alert-success'>
													<a href='' class='close'>&times;</a>
													<strong>Operacion Correcta.</strong> Se agrego correctamente el cliente
											</div>";
										}


								}
							 ?>

							<div class="col-lg-12 ">
								<div class="top-content">
									<!--<a href="nuevo-cliente.php" type="button" class="btn btn-success"><i class="fa fa-plus-square"></i> Agregar Nuevo Cliente </a>-->
								</div>
							</div>
							<table id="featured-datatable" class="table table-sorting table-hover datatable">
								<thead>
									<tr>
										<!--<th># de Cliente</th>-->
										<th>Banco</th>
										<th>Titular</th>
										<th>Cuenta</th>
										<th>Clave</th>
                                        
										<th>Operaciones</th>
									</tr>
								</thead>
								<tbody>

									<?php
										//Consulta Cientes
										$iny_clientes = mysqli_query($mysqli,"select * from cuentas_bancarias_pago where status='1';") or die (mysqli_error());
										if(mysqli_num_rows($iny_clientes) > 0){
							              while($row = mysqli_fetch_array($iny_clientes)){
											echo "<tr>";
							                echo "<td> $row[1]</td>";
											
											echo "<td>$row[2]</td>";
											echo "<td>$row[3]</td>";
											echo "<td>$row[4]</td>";
											echo "<td></td>";
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
	
	 <script src="assets/js/bootstrap/bootstrap.js"></script>
	 <script type="text/javascript">$(function(){$('[data-toggle="tooltip"]').tooltip()})</script>
   <script type="text/javascript">$(".top").tooltip({placement:"top"});</script>

	 <script type="text/javascript">
		 $(document).ready(function() {
		 $('#tablita').DataTable();
		 } );
		 $('#tablita').dataTable( {
     "order": [[ 2, "desc" ]]
} );
	 </script>
<?php
		include("include/footer-js.php")
	 ?>
</body>

</html>

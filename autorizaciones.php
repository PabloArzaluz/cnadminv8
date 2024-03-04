<?php
	session_start(); // crea una sesion
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	$pagina_actual = "autorizaciones";
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!-->
<html lang="es" class="no-js">
<!--<![endif]-->

<head>
	<title>Autorizaciones | Credinieto</title>
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
						<li><a href="#">Autorizaciones</a></li>
						<li class="active">Pendientes</li>
					</ul>
				</div>

			</div>
			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Autorizaciones</h2>
					<em>pagina de visualizacion de operaciones pendientes por autorizar</em>
				</div>

				<div class="main-content">
					<!-- FEATURED DATA TABLE -->
					<div class="widget widget-table">
						<div class="widget-header">
									<h3><i class="fa fa-key"></i> Autorizaciones</h3> <em> - <a href="#">Mostrar Historico de Autorizaciones</a></em>
								</div>

						<div class="widget-content">
							<table id="tablita" class="table table-sorting table-hover datatable">
								<thead>
									<tr>
										<th># de Cliente</th>
										<th>Nombre Completo</th>
										<th>Direccion</th>
										<th>Telefonos</th>
										<th>Correo</th>
										<th>Fecha de Registro</th>
										<th>Creditos / Activos</th>
										<th>Operaciones</th>
									</tr>
								</thead>
								<tbody>
									<?php
										//Consulta Cientes
										$iny_clientes = mysqli_query($mysqli,"select * from clientes where status='activo';") or die (mysqli_error());
										if(mysqli_num_rows($iny_clientes) > 0){
							              while($row = mysqli_fetch_array($iny_clientes)){
							                echo "<tr>
							                <td>".$row[0]."</td>
							                <td> ".$row[1]." ".$row[2]." ".$row[3]."</td>
							                <td>".$row[4]."</td>
							                <td>".$row[5]."</td>

							                <td>".$row[6]."</td>
											<td>".$row[8]."</td>
											<td><center>2 / 1</center></td>
							                <td> <a href='editar-cliente.php?id=$row[0]' type='button' class='btn btn-success btn-xs'>Autorizar</a> </td></tr> \n";
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
	 <script type="text/javascript">
			 $(document).ready(function() {
				 $('#tablita').DataTable( {
					 "order": [[ 0, "desc" ]]
				 } );
				} );
	 </script>
</body>

</html>

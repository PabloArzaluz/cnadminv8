<?php
	session_start(); // crea una sesion
	ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	$link = Conecta();
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	$pagina_actual = "clientes-juridico";
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!-->
<html lang="es" class="no-js">
<!--<![endif]-->

<head>
	<title>Clientes en Proceso Juridico | Credinieto</title>
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
						<li><a href="#">Clientes</a></li>
						<li class="active">Clientes en Proceso Juridico</li>
					</ul>
				</div>

			</div>
			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Clientes en Juridico</h2>
					<em>clientes que presentan un proceso juridico</em>
				</div>

				<div class="main-content">
					<!-- FEATURED DATA TABLE -->
					<div class="widget widget-table">
						<div class="widget-header">
							<h3><i class="fa fa-table"></i> Clientes Juridicos</h3> <em> -  clientes en proceso juridico</em></div>
						<div class="widget-content"> 
							<table id="featured-datatable" class="table table-sorting table-hover datatable">
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
										$iny_clientes = mysql_query("select * from clientes where status='activo';",$link) or die (mysql_error());
										if(mysql_num_rows($iny_clientes) > 0){
							              while($row = mysql_fetch_array($iny_clientes)){
							                echo "<tr>
							                <td>".$row[0]."</td>
							                <td> <a href='#'>".$row[1]." ".$row[2]." ".$row[3]."</a></td>
							                <td>".$row[4]."</td>
							                <td>".$row[5]."</td>

							                <td>".$row[6]."</td>
											<td>".$row[8]."</td>
											<td><center>2 / 1</center></td>
							                <td> <a href='editar-cliente.php?id=$row[0]' type='button' class='btn btn-warning btn-xs'>Editar</a> <a href='eliminarUsuario.php?id=$row[0]' type='button' class='btn btn-danger btn-xs'>Eliminar</a></td></tr> \n";
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
</body>

</html>

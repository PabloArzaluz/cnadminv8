<?php
	session_start(); // crea una sesion
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/clientes_puntuales.php");
	include("include/functions.php");
	
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	//Validar Permisos
	if(validarAccesoModulos('permiso_permisos') != 1) {
		header("Location: dashboard.php");
	}
	$pagina_actual = "permisos";
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!-->
<html lang="es" class="no-js">
<!--<![endif]-->

<head>
	<title>Permisos | Credinieto</title>
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
						<li><a href="clientes.php">Permisos</a></li>
						<li class="active">Permisos de Acceso</li>
					</ul>
				</div>

			</div>
			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Permisos de Acceso</h2>
					<em>permisos a los modulos del sitio</em>
				</div>

				<div class="main-content">
					<!-- FEATURED DATA TABLE -->
					<div class="widget widget-table">
						<div class="widget-header">
							<h3><i class="fa fa-table"></i> Permisos de Acceso</h3> <em> - </em></div>
						<div class="widget-content">
                            <?php
								//Operaciones
								if(isset($_GET['info'])){
									if($_GET['info'] == '1'){
										echo "<div class='alert alert-success'>
												<a href='' class='close'>&times;</a>
												<strong>Operacion Correcta.</strong> Se agrego correctamente el credito.
										</div>";
									}
									if($_GET['info'] == '2'){
										//FOLIO YA EXISTENTE
										echo "<div class='alert alert-danger'>
												<a href='' class='close'>&times;</a>
												<strong>Ocurrio un Error</strong> ERR.FOL.EXI
										</div>";
									}
				                }
							 ?>
							<?php
								//Conocer los ultimos 3 meses
								$query = mysqli_query($mysqli,"
								SELECT usuario.id_user AS IdUsuarioUser, username, level, nombre, apellidos, 
									permisos.idUsuario AS permisoUser, 
									permiso_pagos,
									permiso_inversionistas,
									permiso_clientes,
									permiso_prestamos,
									permiso_clientespuntuales,
									permiso_permisos,
									permiso_buscar,
									permiso_ver_inversionista_credito,
									permiso_eliminar_pagos,
									permiso_alertas_credito,
									permiso_crear_avales,
									permiso_editar_avales,
									permiso_eliminar_avales,
									permiso_reportes_grafica_pagos_mensuales,
									permiso_reportes_historico_cobranza,
									permiso_reportes_de_pago,
									permiso_reportes_r_i,
									permiso_reportes_prestamos,
									permiso_dashboard_indicador_creditosmes
									FROM usuario
									LEFT JOIN
									permisos
									ON usuario.id_user = permisos.idUsuario WHERE usuario.status = 1 AND level <> 5;
								") or die(mysqli_error());
								echo '<div class="table-responsive">';	
								echo '<table class="table">';
								echo "<thead>
								<th>idUser - Nivel</th>
								<th>nivel</th>
								<th>nombre</th>
								
								<th>permiso_pagos</th>
								<th>permiso_inversionista</th>
								<th>permiso_clientes</th>
								<th>permiso_prestamos</th>
								
								<th>permiso_clientespuntuales</th>
								<th>permiso_permisos</th>
								<th>permiso_buscar</th>
								<th>permiso_ver_inversiosta_credito</th>
								<th>permiso_eliminar_pagos</th>
								<th>permiso_alertas_credito</th>
								<th>permiso_crear_avales</th>
								<th>permiso_editar_avales</th>
								<th>permiso_eliminar_avales</th>
								<th>permiso_reportes_grafica_pagos_mensuales</th>
								<th>permiso_reportes_historico_cobranza</th>
								<th>permiso_reportes_de_pago</th>
								<th>permiso_reportes_r_i</th>
								<th>permiso_reportes_prestamos</th>
								<th>permiso_dashboard_indicador_creditosmes</th>
								</thead>";
								echo "<tbody>";
								if(mysqli_num_rows($query) > 0){
									while($row = mysqli_fetch_assoc($query)){
										echo "<tr>";
										echo "<td>".$row['IdUsuarioUser']."-".$row['permisoUser']."</td>";
										echo "<td>".$row['level']."</td>";
										
										echo "<td><b>".$row['nombre']." ".$row['apellidos']."</b></td>";
										
										//PAGOS
										if($row['permiso_pagos'] == 1){
											echo "<td><span class='label label-success'>Si</span></td>";
										}else{
											echo "<td><span class='label label-danger'>No</span></td>";
										}
										//Inversionista
										if($row['permiso_inversionistas'] == 1){
											echo "<td><span class='label label-success'>Si</span></td>";
										}else{
											echo "<td><span class='label label-danger'>No</span></td>";
										}
										//Clientes
										if($row['permiso_clientes'] == 1){
											echo "<td><span class='label label-success'>Si</span></td>";
										}else{
											echo "<td><span class='label label-danger'>No</span></td>";
										}
										//Prestamos
										if($row['permiso_prestamos'] == 1){
											echo "<td><span class='label label-success'>Si</span></td>";
										}else{
											echo "<td><span class='label label-danger'>No</span></td>";
										}
										
										//Clientes Puntuales
										if($row['permiso_clientespuntuales'] == 1){
											echo "<td><span class='label label-success'>Si</span></td>";
										}else{
											echo "<td><span class='label label-danger'>No</span></td>";
										}
										//Clientes Permisos
										if($row['permiso_permisos'] == 1){
											echo "<td><span class='label label-success'>Si</span></td>";
										}else{
											echo "<td><span class='label label-danger'>No</span></td>";
										}
										//Buscar
										if($row['permiso_buscar'] == 1){
											echo "<td><span class='label label-success'>Si</span></td>";
										}else{
											echo "<td><span class='label label-danger'>No</span></td>";
										}
										//Ver Inversionista en Credito
										if($row['permiso_ver_inversionista_credito'] == 1){
											echo "<td><span class='label label-success'>Si</span></td>";
										}else{
											echo "<td><span class='label label-danger'>No</span></td>";
										}
										//Ver Eliminar Pagos
										if($row['permiso_eliminar_pagos'] == 1){
											echo "<td><span class='label label-success'>Si</span></td>";
										}else{
											echo "<td><span class='label label-danger'>No</span></td>";
										}
										//Alertas Credito
										if($row['permiso_alertas_credito'] == 1){
											echo "<td><span class='label label-success'>Si</span></td>";
										}else{
											echo "<td><span class='label label-danger'>No</span></td>";
										}
										//Crear Avales
										if($row['permiso_crear_avales'] == 1){
											echo "<td><span class='label label-success'>Si</span></td>";
										}else{
											echo "<td><span class='label label-danger'>No</span></td>";
										}
										//Editr Avales
										if($row['permiso_editar_avales'] == 1){
											echo "<td><span class='label label-success'>Si</span></td>";
										}else{
											echo "<td><span class='label label-danger'>No</span></td>";
										}
										//Eliminar Avales
										if($row['permiso_eliminar_avales'] == 1){
											echo "<td><span class='label label-success'>Si</span></td>";
										}else{
											echo "<td><span class='label label-danger'>No</span></td>";
										}
										//Reportes Grafica Pagos Mensuales
										if($row['permiso_reportes_grafica_pagos_mensuales'] == 1){
											echo "<td><span class='label label-success'>Si</span></td>";
										}else{
											echo "<td><span class='label label-danger'>No</span></td>";
										}
										//Reportes Historico Cobranza
										if($row['permiso_reportes_historico_cobranza'] == 1){
											echo "<td><span class='label label-success'>Si</span></td>";
										}else{
											echo "<td><span class='label label-danger'>No</span></td>";
										}
										//Reportes de Pago 
										if($row['permiso_reportes_de_pago'] == 1){
											echo "<td><span class='label label-success'>Si</span></td>";
										}else{
											echo "<td><span class='label label-danger'>No</span></td>";
										}
										//Reportes R e I
										if($row['permiso_reportes_r_i'] == 1){
											echo "<td><span class='label label-success'>Si</span></td>";
										}else{
											echo "<td><span class='label label-danger'>No</span></td>";
										}
										//Reportes Prestamos
										if($row['permiso_reportes_prestamos'] == 1){
											echo "<td><span class='label label-success'>Si</span></td>";
										}else{
											echo "<td><span class='label label-danger'>No</span></td>";
										}
										//Dashnoard Indicardo Creditos Mes
										if($row['permiso_dashboard_indicador_creditosmes'] == 1){
											echo "<td><span class='label label-success'>Si</span></td>";
										}else{
											echo "<td><span class='label label-danger'>No</span></td>";
										}
										
										echo "</tr>";
										
																					
										
									}
								}else{
									echo "<tr><td>no hay resultados</td></tr>";
								}
								echo "</tbody>";
								echo "</table>";
								echo '</div>';
							?>

							
							 
							
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

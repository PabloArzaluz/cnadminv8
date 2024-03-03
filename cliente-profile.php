<?php
	session_start(); // crea una sesion
	ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/functions.php");
	$link = Conecta();
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	$pagina_actual = "clientes";
	//Validar Permisos
	if(validarAccesoModulos('permiso_clientes') != 1) {
		header("Location: dashboard.php");
	}

?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!-->
<html lang="es" class="no-js">
<!--<![endif]-->

<head>
	<title>Perfil de Cliente | Credinieto</title>
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
						<li><a href="clientes.php">Clientes</a></li>
						<li class="active">Ver Cliente</li>
					</ul>
				</div>
			</div>
			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Cliente</h2>
					<em>pagina de informacion de cliente</em>
				</div>
				<div class="main-content">
					<!-- NAV TABS -->
					<ul class="nav nav-tabs nav-tabs-custom-colored tabs-iconized">
						<li class="active"><a href="#profile-tab" data-toggle="tab"><i class="fa fa-user"></i> Perfil</a></li>
						<li><a href="#activity-tab" data-toggle="tab"><i class="fa fa-list" aria-hidden="true"></i> Historial de Creditos</a></li>
						<!--<li><a href="#settings-tab" data-toggle="tab"><i class="fa fa-gear"></i> Settings</a></li>-->
					</ul>
					<!-- END NAV TABS -->
					<div class="tab-content profile-page">
						<!-- PROFILE TAB CONTENT -->
						<?php
							$id_cliente = $_GET['id'];
							$consultar_informacion = "select * from clientes where id_clientes='".$_GET['id']."';";
							$iny_query = mysql_query($consultar_informacion,$link) or die(mysql_error());
							$fila_informacion = mysql_fetch_row($iny_query);
						?>
						<div class="tab-pane profile active" id="profile-tab">
							<div class="row">
								<div class="col-md-12">
									<div class="" style="text-align:right;">
										<a href="<?php echo 'editar-cliente.php?id='.$id_cliente; ?>" type="button" class="btn btn-sm btn-primary pull-right"><i class="fa fa-edit"></i> Editar Informacion</a>
									</div>
									<div class="user-info-right">
										<div class="basic-info">
											<h3><i class="fa fa-square"></i> Informacion Personal</h3>
											<p class="data-row">
												<span class="data-name">Nombre Completo</span>
												<span class="data-value"><?php echo $fila_informacion[1]." ".$fila_informacion[2]." ".$fila_informacion[3]; ?></span>
											</p>
											<p class="data-row">
												<span class="data-name">Direccion</span>
												<span class="data-value"><?php echo $fila_informacion[4]; ?></span>
											</p>
											<p class="data-row">
												<span class="data-name">Telefonos</span>
												<span class="data-value"><?php echo $fila_informacion[5]; ?></span>
											</p>
											<p class="data-row">
												<span class="data-name">email</span>
												<span class="data-value"><?php echo $fila_informacion[6]; ?></span>
											</p>
											<p class="data-row">
												<span class="data-name">Fecha Nacimiento</span>
												<span class="data-value"><?php echo $fila_informacion[7]; ?></span>
											</p>
										</div>
										<div class="basic-info">
											<h3><i class="fa fa-square"></i> Informacion laboral</h3>
											<p class="data-row">
												<span class="data-name">Domicilio Trabajo</span>
												<span class="data-value"><?php echo $fila_informacion[12]; ?></span>
											</p>
											<p class="data-row">
												<span class="data-name">Telefonos Trabajo</span>
												<span class="data-value"><?php echo $fila_informacion[13]; ?></span>
											</p>
										</div>
										<div class="contact_info">
											<h3><i class="fa fa-square"></i> Archivos</h3>
											<p class="data-row">
												<span class="data-name">Identificacion Oficial</span>
												<span class="data-value">
													<?php
														if($fila_informacion[10] == '' & $fila_informacion[14] == ''){
															echo "Aun no existe ningun archivo <i class='fa fa-times' aria-hidden='true'></i>";
														}else{
															echo "<a target='_blank' href='$fila_informacion[10]'>$fila_informacion[14] <i class='fa fa-external-link' aria-hidden='true'></i></a>";
														}
													?>
												</span>
											</p>
											<p class="data-row">
												<span class="data-name">Comprobante de Domicilio</span>
												<span class="data-value">
													<?php
														if($fila_informacion[11] == '' & $fila_informacion[15] == ''){
															echo "Aun no existe ningun archivo <i class='fa fa-times' aria-hidden='true'></i>";
														}else{
															echo "<a target='_blank' href='$fila_informacion[11]'>$fila_informacion[15] <i class='fa fa-external-link' aria-hidden='true'></i></a>";
														}
													?>
												</span>
											</p>

										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- END PROFILE TAB CONTENT -->
						<!-- ACTIVITY TAB CONTENT -->
						<div class="tab-pane activity" id="activity-tab">
							<table id="tablita" class="table table-sorting table-hover datatable">
								<thead>
									<tr>
										<th>Estatus</th>
										<th>Fecha de Prestamo</th>
										<th>Monto</th>
										<th>Interes</th>
										<th></th>
										
									</tr>
								</thead>
								<tbody>
									<?php
										//Consulta Pagos
										$iny_pagos = mysql_query("SELECT * FROM creditos WHERE id_cliente=$id_cliente order by fecha_prestamo desc;",$link) or die (mysql_error());
										if(mysql_num_rows($iny_pagos) > 0){
							              while($row = mysql_fetch_array($iny_pagos)){
							                echo "<tr><td>";
											if($row[12] == 1){
                                                echo "<span class='label label-success'>Activo</span>";
                                            }
                                              if($row[12]== 2){
                                                  echo "<span class='label label-default'>Finalizado</span>";
                                              }
                                              if($row[12] == 3){
                                                  echo "<span class='label label-danger'>En Juridico</span>";
                                              }
											  if($row[12] == 4){
												echo "<span class='label label-warning'>Vendido</span>";
											}
											echo "</td><td>".date("d/m/Y",strtotime($row[4]))."</td>
											<td>$".number_format(($row[5]),2)."</td>
							                <td>$row[6]%</td>											
							                <td> <a href='detalle-credito.php?id=$row[0]' type='button' class='btn btn-default btn-xs'>Ver Credito</a> </td></tr> \n";
							              }
							            }
										?>

								</tbody>
							</table>
						</div>
						<!-- END ACTIVITY TAB CONTENT -->
						<!-- SETTINGS TAB CONTENT -->
						<div class="tab-pane settings" id="settings-tab">
							<form class="form-horizontal" role="form">
								<fieldset>
									<h3><i class="fa fa-square"></i> Change Password</h3>
									<div class="form-group">
										<label for="old-password" class="col-sm-3 control-label">Old Password</label>
										<div class="col-sm-4">
											<input type="password" id="old-password" name="old-password" class="form-control">
										</div>
									</div>
									<hr />
									<div class="form-group">
										<label for="password" class="col-sm-3 control-label">New Password</label>
										<div class="col-sm-4">
											<input type="password" id="password" name="password" class="form-control">
										</div>
									</div>
									<div class="form-group">
										<label for="password2" class="col-sm-3 control-label">Repeat Password</label>
										<div class="col-sm-4">
											<input type="password" id="password2" name="password2" class="form-control">
										</div>
									</div>
								</fieldset>
								<fieldset>
									<h3><i class="fa fa-square"></i> Privacy</h3>
									<label class="fancy-checkbox">
										<input type="checkbox">
										<span>Show my display name</span>
									</label>
									<label class="fancy-checkbox">
										<input type="checkbox">
										<span>Show my birth date</span>
									</label>
									<label class="fancy-checkbox">
										<input type="checkbox">
										<span>Show my email</span>
									</label>
									<label class="fancy-checkbox">
										<input type="checkbox">
										<span>Show my online status on chat</span>
									</label>
								</fieldset>
								<h3><i class="fa fa-square"> </i>Notifications</h3>
								<fieldset>
									<div class="form-group">
										<label class="col-sm-5 control-label">Receive message from administrator</label>
										<ul class="col-sm-7 list-inline">
											<li>
												<input type="checkbox" checked class="bs-switch switch-small" data-off="default" data-on-label="<i class='glyphicon glyphicon-globe'></i>" data-off-label="<i class='glyphicon glyphicon-globe'></i>">
											</li>
											<li>
												<input type="checkbox" checked class="bs-switch switch-small" data-off="default" data-on-label="<i class='glyphicon glyphicon-phone'></i>" data-off-label="<i class='glyphicon glyphicon-phone'></i>">
											</li>
											<li>
												<input type="checkbox" checked class="bs-switch switch-small" data-off="default" data-on-label="<i class='glyphicon glyphicon-envelope'></i>" data-off-label="<i class='glyphicon glyphicon-envelope'></i>">
											</li>
										</ul>
									</div>
									<div class="form-group">
										<label class="col-sm-5 control-label">New product has been added</label>
										<ul class="col-sm-7 list-inline">
											<li>
												<input type="checkbox" class="bs-switch switch-small" data-off="default" data-on-label="<i class='glyphicon glyphicon-globe'></i>" data-off-label="<i class='glyphicon glyphicon-globe'></i>">
											</li>
											<li>
												<input type="checkbox" checked class="bs-switch switch-small" data-off="default" data-on-label="<i class='glyphicon glyphicon-phone'></i>" data-off-label="<i class='glyphicon glyphicon-phone'></i>">
											</li>
											<li>
												<input type="checkbox" checked class="bs-switch switch-small" data-off="default" data-on-label="<i class='glyphicon glyphicon-envelope'></i>" data-off-label="<i class='glyphicon glyphicon-envelope'></i>">
											</li>
										</ul>
									</div>
									<div class="form-group">
										<label class="col-sm-5 control-label">Product review has been approved</label>
										<ul class="col-sm-7 list-inline">
											<li>
												<input type="checkbox" checked class="bs-switch switch-small" data-off="default" data-on-label="<i class='glyphicon glyphicon-globe'></i>" data-off-label="<i class='glyphicon glyphicon-globe'></i>">
											</li>
											<li>
												<input type="checkbox" class="bs-switch switch-small" data-off="default" data-on-label="<i class='glyphicon glyphicon-phone'></i>" data-off-label="<i class='glyphicon glyphicon-phone'></i>">
											</li>
											<li>
												<input type="checkbox" checked class="bs-switch switch-small" data-off="default" data-on-label="<i class='glyphicon glyphicon-envelope'></i>" data-off-label="<i class='glyphicon glyphicon-envelope'></i>">
											</li>
										</ul>
									</div>
									<div class="form-group">
										<label class="col-sm-5 control-label">Others liked your post</label>
										<ul class="col-sm-7 list-inline">
											<li>
												<input type="checkbox" class="bs-switch switch-small" data-off="default" data-on-label="<i class='glyphicon glyphicon-globe'></i>" data-off-label="<i class='glyphicon glyphicon-globe'></i>">
											</li>
											<li>
												<input type="checkbox" class="bs-switch switch-small" data-off="default" data-on-label="<i class='glyphicon glyphicon-phone'></i>" data-off-label="<i class='glyphicon glyphicon-phone'></i>">
											</li>
											<li>
												<input type="checkbox" class="bs-switch switch-small" data-off="default" data-on-label="<i class='glyphicon glyphicon-envelope'></i>" data-off-label="<i class='glyphicon glyphicon-envelope'></i>">
											</li>
										</ul>
									</div>
								</fieldset>
							</form>
							<p class="text-center"><a href="#" class="btn btn-custom-primary"><i class="fa fa-floppy-o"></i> Save Changes</a></p>
						</div>
						<!-- END SETTINGS TAB CONTENT -->
					</div>
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

<?php
	session_start(); // crea una sesion
	ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/clientes_puntuales.php");
	include("include/functions.php");
	$link = Conecta();
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
						<form class="form-horizontal" role="form" method="GET" action="permisos.php?b=1" autocomplete="off" enctype="multipart/form-data">
							<div class="row">
							    <div class="col-sm-9">
									<div class="form-group">
										<label for="credito" class="col-sm-3 control-label">Nombre del Usuario</label>
										<div class="col-sm-9">
											<!-- SELECT2 -->
											<select name="usuario" id="credito" class="select2" required onchange="this.form.submit()">
												<option value="">Seleccione un Usuario</option>
													<?php
															$iny_creditos = mysql_query("SELECT 
                                                                usuario.id_user,
																usuario.username,
                                                                usuario.email,
                                                                usuario.level,
                                                                usuario.nombre,
                                                                usuario.apellidos
                                                            FROM
                                                                usuario
                                                            where usuario.status =1 AND id_user NOT IN (1);",$link) or die (mysql_error());
															if(mysql_num_rows($iny_creditos) > 0){
															  while($row = mysql_fetch_array($iny_creditos)){
																echo "<option value='$row[0]'>$row[4] $row[5] ";
																  
																if($row[5] == 3){
																	echo " ¡¡Credito en Juridico!!";
																}
																echo "</option>";
															  }
															}
															 ?>
											</select>
											<input type="hidden" name="estado" value="1">
											<!-- END SELECT2 -->
										</div>
									</div>
								</div>
								<div class="col-sm-3">
	                                        
	                                    </div>
							</div>
							<hr>
							<?php
								if(isset($_GET['estado'])){
									$conocer_datos_generales ="SELECT * FROM usuario where id_user = '".$_GET['usuario']."';";
									$iny_conocer_datos_generales = mysql_query($conocer_datos_generales,$link) or die(mysql_error());
									$f_ConocerDatosGenerales = mysql_fetch_assoc($iny_conocer_datos_generales);
								}
								

							?>
							<div class="row">
								<div class="col-xs-4">
									<div class="form-group">
										<label for="comentario-credito" class="col-sm-3 control-label">Nombre</label>
										<div class="col-md-9">
											<input type="text" class="form-control" disabled value="<?php if(isset($_GET['estado'])) echo $f_ConocerDatosGenerales['nombre']." ".$f_ConocerDatosGenerales['apellidos'];  ?>">
										</div>
									</div>
								</div>
								<div class="col-xs-4">
									<div class="form-group">
										<label for="comentario-credito" class="col-sm-3 control-label">Username</label>
										<div class="col-md-9">
											<input type="text" class="form-control" value="<?php if(isset($_GET['estado'])) echo $f_ConocerDatosGenerales['username']; ?>" disabled>
											
										</div>
									</div>
								</div>
								<div class="col-xs-4">
									<div class="form-group">
										<label for="comentario-credito" class="col-sm-3 control-label">Departamento</label>
										<div class="col-md-9">
											<input type="text" class="form-control" value="<?php if(isset($_GET['estado'])) echo $f_ConocerDatosGenerales['puesto']; ?>" disabled>
											
										</div>
									</div>
								</div>
							</div>
							
							<div class="row">
								
								<div class="col-xs-4">
									<div class="form-group">
										<label for="comentario-credito" class="col-sm-8 control-label">Acceso a Administrativo</label>
										<div class="col-md-4">
										<?php
												if(isset($_GET['estado'])){
													if($f_ConocerDatosGenerales['accesoAdministrativo'] == 1){
														echo "<span class='label label-success'>Si</span>";
													}else{
														echo "<span class='label label-default'>No</span>";
													}
												}
											?>											
										</div>
									</div>
								</div>
								<div class="col-xs-4">
									<div class="form-group">
										<label for="comentario-credito" class="col-sm-8 control-label">Acceso a Comercial</label>
										<div class="col-md-4">
											<?php
												if(isset($_GET['estado'])){
													if($f_ConocerDatosGenerales['accesoComercial'] == 1){
														echo "<span class='label label-success'>Si</span>";
													}else{
														echo "<span class='label label-default'>No</span>";
													}
												}
											?>
										</div>
									</div>
								</div>
								<div class="col-xs-4">
									<div class="form-group">
										<label for="comentario-credito" class="col-sm-3 control-label">Ultimo Ingreso</label>
										<div class="col-md-9">
										<input type="text" class="form-control" value="<?php if(isset($_GET['estado'])) echo $f_ConocerDatosGenerales['lastLogin']; ?>" disabled>
											
										</div>
									</div>
								</div>
							</div>
							
							
							
							</form>



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
							 
							
							
							 
							
						</div>
					</div>
					<?php
					//Inicia Mostrar Permisos
						if(isset($_GET['estado'])){
							$conocerPermisos = mysql_query("SELECT * FROM permisos where idUsuario='".$_GET['usuario']."';",$link) or die(mysql_error());
							$f_listaPermisos = mysql_fetch_assoc($conocerPermisos);
					?>
					<form action="_guarda_permisos.php" method="POST" name="editarpermisos">
					<div class="row">
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_pagos' class='top' data-toggle='tooltip'>Permiso Pagos</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_pagos" class="onoffswitch-checkbox" id="permiso_pagos" <?php if($f_listaPermisos['permiso_pagos'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_pagos">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_inversionistas' class='top' data-toggle='tooltip'>Permiso Inversionistas</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_inversionistas" class="onoffswitch-checkbox" id="permiso_inversionistas" <?php if($f_listaPermisos['permiso_inversionistas'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_inversionistas">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_clientes' class='top' data-toggle='tooltip'>Permiso Clientes</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_clientes" class="onoffswitch-checkbox" id="permiso_clientes" <?php if($f_listaPermisos['permiso_clientes'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_clientes">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_prestamos' class='top' data-toggle='tooltip'>Permiso Prestamos</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_prestamos" class="onoffswitch-checkbox" id="permiso_prestamos" <?php if($f_listaPermisos['permiso_prestamos'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_prestamos">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_clientespuntuales' class='top' data-toggle='tooltip'>Permiso Clientes Puntuales</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_clientespuntuales" class="onoffswitch-checkbox" id="permiso_clientespuntuales" <?php if($f_listaPermisos['permiso_clientespuntuales'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_clientespuntuales">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_permisos' class='top' data-toggle='tooltip'>Permiso Permisos</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_permisos" class="onoffswitch-checkbox" id="permiso_permisos" <?php if($f_listaPermisos['permiso_permisos'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_permisos">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_buscar' class='top' data-toggle='tooltip'>Permiso Buscar</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_buscar" class="onoffswitch-checkbox" id="permiso_buscar" <?php if($f_listaPermisos['permiso_buscar'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_buscar">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_ver_inversionista_credito' class='top' data-toggle='tooltip'>Permiso Ver Inversionista Credito</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_ver_inversionista_credito" class="onoffswitch-checkbox" id="permiso_ver_inversionista_credito" <?php if($f_listaPermisos['permiso_ver_inversionista_credito'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_ver_inversionista_credito">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_eliminar_pagos' class='top' data-toggle='tooltip'>Permiso Eliminar Pagos</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_eliminar_pagos" class="onoffswitch-checkbox" id="permiso_eliminar_pagos" <?php if($f_listaPermisos['permiso_eliminar_pagos'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_eliminar_pagos">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_alertas_credito' class='top' data-toggle='tooltip'>Permiso Alertas Credito</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_alertas_credito" class="onoffswitch-checkbox" id="permiso_alertas_credito" <?php if($f_listaPermisos['permiso_alertas_credito'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_alertas_credito">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_crear_avales' class='top' data-toggle='tooltip'>Permiso Crear Avales</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_crear_avales" class="onoffswitch-checkbox" id="permiso_crear_avales" <?php if($f_listaPermisos['permiso_crear_avales'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_crear_avales">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_editar_avales' class='top' data-toggle='tooltip'>Permiso Editar Avales</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_editar_avales" class="onoffswitch-checkbox" id="permiso_editar_avales" <?php if($f_listaPermisos['permiso_editar_avales'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_editar_avales">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_eliminar_avales' class='top' data-toggle='tooltip'>Permiso Eliminar Avales</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_eliminar_avales" class="onoffswitch-checkbox" id="permiso_eliminar_avales" <?php if($f_listaPermisos['permiso_eliminar_avales'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_eliminar_avales">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_reportes_grafica_pagos_mensuales' class='top' data-toggle='tooltip'>Permiso Reporte Grafica Pagos Mensuales</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_reportes_grafica_pagos_mensuales" class="onoffswitch-checkbox" id="permiso_reportes_grafica_pagos_mensuales" <?php if($f_listaPermisos['permiso_reportes_grafica_pagos_mensuales'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_reportes_grafica_pagos_mensuales">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_reportes_historico_cobranza' class='top' data-toggle='tooltip'>Permiso Reportes Historico Cobranza</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_reportes_historico_cobranza" class="onoffswitch-checkbox" id="permiso_reportes_historico_cobranza" <?php if($f_listaPermisos['permiso_reportes_historico_cobranza'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_reportes_historico_cobranza">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_reportes_de_pago' class='top' data-toggle='tooltip'>Permiso Reportes de Pago</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_reportes_de_pago" class="onoffswitch-checkbox" id="permiso_reportes_de_pago" <?php if($f_listaPermisos['permiso_reportes_de_pago'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_reportes_de_pago">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_reportes_r_i' class='top' data-toggle='tooltip'>Permiso Reportes R e I</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_reportes_r_i" class="onoffswitch-checkbox" id="permiso_reportes_r_i" <?php if($f_listaPermisos['permiso_reportes_r_i'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_reportes_r_i">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_reportes_prestamos' class='top' data-toggle='tooltip'>Permiso Reportes Prestamos</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_reportes_prestamos" class="onoffswitch-checkbox" id="permiso_reportes_prestamos" <?php if($f_listaPermisos['permiso_reportes_prestamos'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_reportes_prestamos">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_dashboard_indicador_creditosmes' class='top' data-toggle='tooltip'>Permiso Dashboard Indicador Creditos Mes</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_dashboard_indicador_creditosmes" class="onoffswitch-checkbox" id="permiso_dashboard_indicador_creditosmes" <?php if($f_listaPermisos['permiso_dashboard_indicador_creditosmes'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_dashboard_indicador_creditosmes">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_agregar_inmuebles' class='top' data-toggle='tooltip'>Permiso Agregar Inmuebles</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_agregar_inmuebles" class="onoffswitch-checkbox" id="permiso_agregar_inmuebles" <?php if($f_listaPermisos['permiso_agregar_inmuebles'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_agregar_inmuebles">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_agregar_cuentas_bancarias' class='top' data-toggle='tooltip'>Permisos Agregar Cuentas Bancarias</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_agregar_cuentas_bancarias" class="onoffswitch-checkbox" id="permiso_agregar_cuentas_bancarias" <?php if($f_listaPermisos['permiso_agregar_cuentas_bancarias'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_agregar_cuentas_bancarias">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_ver_documentacion_expediente' class='top' data-toggle='tooltip'>Permisos Ver Documentacion Expediente</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_ver_documentacion_expediente" class="onoffswitch-checkbox" id="permiso_ver_documentacion_expediente" <?php if($f_listaPermisos['permiso_ver_documentacion_expediente'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_ver_documentacion_expediente">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_editar_documentacion_expediente' class='top' data-toggle='tooltip'>Permiso Editar Documentacion Expediente</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_editar_documentacion_expediente" class="onoffswitch-checkbox" id="permiso_editar_documentacion_expediente" <?php if($f_listaPermisos['permiso_editar_documentacion_expediente'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_editar_documentacion_expediente">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_operaciones_adicionales_credito' class='top' data-toggle='tooltip'>Permiso Operaciones Adicionales Credito</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_operaciones_adicionales_credito" class="onoffswitch-checkbox" id="permiso_operaciones_adicionales_credito" <?php if($f_listaPermisos['permiso_operaciones_adicionales_credito'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_operaciones_adicionales_credito">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>
						
					</div>
					<div class="row">
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_ver_detalle_credito_info_adicional_inversionista' class='top' data-toggle='tooltip'>Permiso Detalle Credito Info Adicional Inversionistas</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_ver_detalle_credito_info_adicional_inversionista" class="onoffswitch-checkbox" id="permiso_ver_detalle_credito_info_adicional_inversionista" <?php if($f_listaPermisos['permiso_ver_detalle_credito_info_adicional_inversionista'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_ver_detalle_credito_info_adicional_inversionista">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_editar_monto_credito' class='top' data-toggle='tooltip'>Permiso Modificar Monto Creditos</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_editar_monto_credito" class="onoffswitch-checkbox" id="permiso_editar_monto_credito" <?php if($f_listaPermisos['permiso_editar_monto_credito'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_editar_monto_credito">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_inversionistas_editar' class='top' data-toggle='tooltip'>Permiso Inversionista Editar</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_inversionistas_editar" class="onoffswitch-checkbox" id="permiso_inversionistas_editar" <?php if($f_listaPermisos['permiso_inversionistas_editar'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_inversionistas_editar">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_inversionistas_crear' class='top' data-toggle='tooltip'>Permiso Inversionistas Crear</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_inversionistas_crear" class="onoffswitch-checkbox" id="permiso_inversionistas_crear" <?php if($f_listaPermisos['permiso_inversionistas_crear'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_inversionistas_crear">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>	
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_inversionistas_cambiar_credito' class='top' data-toggle='tooltip'>Permiso Inversionistas Cambiar Credito</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_inversionistas_cambiar_credito" class="onoffswitch-checkbox" id="permiso_inversionistas_cambiar_credito" <?php if($f_listaPermisos['permiso_inversionistas_cambiar_credito'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_inversionistas_cambiar_credito">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label class="col-md-7 control-label"><span title='permiso_credito_editar_informacion_basica' class='top' data-toggle='tooltip'>Permiso / Credito Modificar Informacion Basica</span></label>
								<div class="col-md-5">
									<label class="checkbox-inline">
									<div class="control-inline onoffswitch">
										<input type="checkbox" name="permiso_credito_editar_informacion_basica" class="onoffswitch-checkbox" id="permiso_credito_editar_informacion_basica" <?php if($f_listaPermisos['permiso_credito_editar_informacion_basica'] == "1") echo "checked"; ?>>
										<label class="onoffswitch-label" for="permiso_credito_editar_informacion_basica">
											<span class="onoffswitch-inner"></span>
											<span class="onoffswitch-switch"></span>
										</label>
									</div>
									</label>
								</div>
							</div>
						</div>					
					</div>
					<!-- BOTON de SUMIT GUARDAR PERMISOS -->
					<hr>
					<input type="hidden" name="idUsuario" value="<?php echo $_GET['usuario']; ?>">
					<div class="row">
						<div class="col-xs-12">
						<div class="form-group">
							<div class="col-sm-offset-8 col-sm-4">
								<button type="submit" class="btn btn-default btn-block">Guardar Permisos</button>
							</div>
						</div>
						</div>
					</div>
					</form>
					<?php
						}
						//Termina Mostrar PErmisos
					?>
					<hr>
					<br><br>
					<!-- END FEATURED DATA TABLE -->
				</div>
			</div>
			<!-- /main -->
			<!-- FOOTER -->
			<footer class="footer">
				&copy; 2022 Credinieto
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

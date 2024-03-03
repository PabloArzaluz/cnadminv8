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
	if(validarAccesoModulos('permiso_inversionistas') != 1) {
		header("Location: dashboard.php");
	}
	$pagina_actual = "inversionistas";
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
	<title>Inversionistas | Credinieto</title>
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
						<li><a href="#">Inversionistas</a></li>
						<li class="active">Todos</li>
					</ul>
				</div>

			</div>
			
			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Inversionistas</h2>
					<em>pagina de inversionistas</em>
					<div class="row">
						<?php
							    	
							$mesAnterior = fecha_meses("-1");
							$MesActual = date("m");
							$PagosMesInvActual = "select sum(monto) from pinversionistas where MONTH(fecha_captura) = $MesActual;";
							$inyPagosMesInvActual = mysql_query($PagosMesInvActual,$link) or die(mysql_error());
							$fPagosMesInvActual = mysql_fetch_row($inyPagosMesInvActual);
							
							$PagosMesInvAnterior = "select sum(monto) from pinversionistas where MONTH(fecha_captura) = $mesAnterior;";
							$inyPagosMesInvAnterior = mysql_query($PagosMesInvAnterior,$link) or die(mysql_error());
							$fPagosMesInvAnterior = mysql_fetch_row($inyPagosMesInvAnterior);
							
							$PagosInvCapital = "select sum(monto) from pinversionistas where MONTH(fecha_captura) = $MesActual and tipo_pago = 'capital';";
							$inyPagosInvCapital = mysql_query($PagosInvCapital,$link) or die(mysql_error());
							$fPagosInvCapital = mysql_fetch_row($inyPagosInvCapital);
						?>
						<div class="col-md-6 col-sm-6">
							<div class="number-chart">
								<div class="number pull-left"><span>$<?php echo number_format(($fPagosMesInvActual[0]),2); ?></span> <span>Pagos en este mes a Inversionistas</span></div>
								<div class="mini-stat">
									<div id="number-schart3" class="inlinesparskline"><?php 
										if(empty($fPagosInvCapital[0])){
											echo "$0.00";
										}else{
											echo "$".number_format(($fPagosInvCapital[0]),2); 
										}
										
										?></div>
									<p class="text-muted">
										pagos a capital este mes.
									</p>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="number-chart">
							<?php
									$conocer_capital_actual = "select sum(monto) from creditos where creditos.status=1 and id_inversionista <> 1;";
									$iny_conocer_capital_actual = mysql_query($conocer_capital_actual,$link) or die (mysql_error());
									$fCapitalActual = mysql_fetch_row($iny_conocer_capital_actual);
									$fCapitalActual[0];

									$conocer_pagos_capital = "select distinct id_pinversionistas,(pinversionistas.monto) from pinversionistas inner join creditos on creditos.id_inversionista = pinversionistas.id_inversionista 
																where creditos.status=1 and pinversionistas.tipo_pago=  'capital'; ";
									$iny_conocer_pagos_capital = mysql_query($conocer_pagos_capital,$link) or die (mysql_error());
									$fPagosCapital = mysql_fetch_row($iny_conocer_pagos_capital);
									$fPagosCapital[1];
									$TotalCapital = $fCapitalActual[0] - $fPagosCapital[1];
								?>
								<div class="number pull-left"><span>$<?php echo number_format((	$TotalCapital),2); ?></span> <span>Capital Actual en Inversionistas<br></span></div>
								<div class="mini-stat">
								

									
									<p class="text-muted">
										Sin contar creditos cerrados y descontando pagos realizados a capital.										
									</p>
								</div>
							</div>
						</div>
						<?php 
							$IntCobInvMes = 2;
						?>
						<!--<div class="col-md-6 col-sm-6">
							<div class="number-chart">
								<div class="number pull-left"><span>372,500</span> <span>LIKES</span></div>
								<div class="mini-stat">
									<div id="numbesr-chart4" class="inlinespasrkline">Loading...</div>
									<p class="text-muted"><i class="fa fa-caret-down red-font"></i> 6% lower than last week</p>
								</div>
							</div>
						</div>-->
							
			</div>
				</div>
				

				<div class="main-content">
					<!-- FEATURED DATA TABLE -->
					<div class="widget widget-table">
						<div class="widget-header">
							<h3><i class="fa fa-table"></i> Inversionistas</h3> <em> -  pagina donde se muestran los inversionistas</em></div>
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
									<?php if(validarAccesoModulos("permiso_inversionistas_crear") == 1){ ?>
									<a href="nuevo-inversionista.php" type="button" class="btn btn-success"><i class="fa fa-plus-square"></i> Agregar Nuevo Inversionista</a>
									<?php } ?>
								</div>
							</div>
							<table id="tablita" class="table table-sorting table-hover datatable">
								<thead>
									<tr>
										<th>Nombre Completo</th>
										<th>Tipo de Pago</th>
										<th>Comentarios</th>										
										<th>Operaciones</th>
									</tr>
								</thead>
								<tbody>
									<?php
										//Consulta Cientes
										$iny_clientes = mysql_query("select * from inversionistas where status='activo';",$link) or die (mysql_error());
										if(mysql_num_rows($iny_clientes) > 0){
							              while($row = mysql_fetch_array($iny_clientes)){
							                echo "<tr>
                                            <td> <a href='detalle-inversionista.php?id=$row[0]'>".$row[1]."</a></td>
							                <td>";
                                              if($row[3] == 1){
                                                  echo 'Pago Fijo Mensual';
                                              }
                                              if($row[3] == 2){
                                                  echo 'Pago Segun la fecha del prestamo';
                                              }
                                            echo "</td>
							                <td>".$row[2]."</td><td>";
											if(validarAccesoModulos("permiso_inversionistas_editar") == 1){
												echo " <a href='editar-inversionista.php?id=$row[0]' type='button' class='btn btn-warning btn-xs'>Editar</a> <a href='eliminar_inversionista.php?id=$row[0]' type='button' class='btn btn-danger btn-xs'>Eliminar</a>";
											}
											echo "</td></tr>";
                                            
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
			  "order": [[ 0, "desc" ]]
			  
			 
		 });
		} );
	 </script>
</body>

</html>

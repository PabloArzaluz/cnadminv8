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


	//PERMISOS
	if(validarAccesoModulos('permiso_inversionistas') != 1) {
		header("Location: dashboard.php");
	}
	//FIN PERMISOS

	$pagina_actual = "inversionistas";
    $fecha_actual = date("Y-m-d");

	function diferenciaDias($inicio, $fin)
		{
			$inicio = strtotime($inicio);
			$fin = strtotime($fin);
			$dif = $fin - $inicio;
			$diasFalt = (( ( $dif / 60 ) / 60 ) / 24);
			return ceil($diasFalt);
		}
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!-->
<html lang="es" class="no-js">
<!--<![endif]-->

<head>
	<title>Detalle Inversionista | Portal Credinieto</title>
	<?php
		include("include/head.php");
	?>
    <style>
        .tabla-prestamos{
            
            border-collapse: collapse;  
             width: 100%;
        }
        .tabla-prestamos td{
            padding: 5px;
        }
        .der{
            text-align: right;
        }
        .izq{
            text-align: left;
        }
        .linea{
            border-bottom: 1px solid #CACACB;
            
        }
        .titulo{
                font-family: "latolight";
            font-size: 12pt;
        }
        
        .tabla-inner td{
            padding: 5px;
        }
        
    </style>
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
						<li><a href="inversionistas.php">Inversionista</a></li>
						<li class="active">Detalles Inversionista</li>
					</ul>
                </div>
			</div>
			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Detalle Inversionista</h2>
					<em>vista general de inversionista</em>
				</div>
                    <?php
                        $id_inversionista = $_GET['id'];
                        $consultar_inversionista = "select * from inversionistas where id_inversionistas = '$id_inversionista';";
                        $iny_consultar_inversionista = mysqli_query($mysqli,$consultar_inversionista) or die (mysqli_error());
                        $fila_inversionista = mysqli_fetch_row($iny_consultar_inversionista);
                    ?>
				<div class="main-content">
					<!-- WIDGET WITH DROPDOWN -->
                    <div class="widget">
						<div class="widget-header">
							<h3><?php echo strtoupper($fila_inversionista[1]); ?></h3>
							<div class="btn-group widget-header-toolbar">
								<div class="btn-group">
									<?php if(validarAccesoModulos("permiso_inversionistas_editar") == 1){ ?>
									<button type="button" class="btn btn-default btn-default dropdown-toggle btn-xs" data-toggle="dropdown"><i class="fa fa-cog" aria-hidden="true"></i> Operaciones <span class="caret"></span></button>
									<ul class="dropdown-menu dropdown-menu-right" role="menu">
										<li class="dropdown-header">Operaciones Generales</li>
										<li><a href="#">Editar Informacion de Inversionista</a></li>
										<li><a href="#">Eliminar Inversionista</a></li>
										<!--<li><a href="#">Eliminar Credito</a></li>
										<li class="divider"></li>
										<li class="dropdown-header">Operaciones de Credito</li>
										<li </li><a href="finalizar-credito.php?id=17">Finalizar Credito</a></li>
										<li ><a href="credito-juridico.php?id=17">Mandar Credito a Juridico</a></li>-->
									</ul>
									<?php } ?>
								</div>
							</div>
						</div>
						<?php 
							//Consultar Creditos
							$conocer_total_creditos = mysqli_query($mysqli,"select count(id_inversionista) from creditos where id_inversionista=$id_inversionista;") or die(mysqli_error());
							$cantidad_creditos = mysqli_fetch_row($conocer_total_creditos);
						
						?>
						<div class="widget-content">
							<div class="row">
								<!--<div class="col-xs-3">
									<table class="table table-bordered table-striped">
										<tr><td><strong>Total de Creditos: </strong></td><td><span data-toggle='tooltip' title='Monday,  07 de December del 2015'>07/12/2015</span></td></tr>
									</table>
									
								</div>-->
								
								<div class="col-sm-3 col-sm-offset-9">
									<table class="table table-bordered table-striped">
										<tr><td><strong>Total de Creditos: </strong></td><td><?php echo $cantidad_creditos[0]; ?></td></tr>
									</table>
								</div>
							</div>
									
									<!-- CONOCER INFORMACION DE CREDITOS -->
									<?php
										$creditos_asociados = mysqli_query($mysqli,"select * from creditos where id_inversionista=$id_inversionista ORDER BY folio desc	;") or die(mysqli_error());
										$SaldoRestanteCreditos = 0;
										if(mysqli_num_rows($creditos_asociados)>0){
                                        	while($fCreditos = mysqli_fetch_array($creditos_asociados)){
												
												$conocer_informacion_cliente = mysqli_query($mysqli,"select * from clientes where id_clientes = $fCreditos[1];") or die(mysqli_error());
												$fCliente = mysqli_fetch_row($conocer_informacion_cliente);
												
												echo "<table style='width:100%;'>
														<tr style='border-bottom:1px solid #778899;'>
															<td style=''><strong><a href='detalle-credito.php?id=$fCreditos[0]'>Credito No: $fCreditos[21]</a></strong></td>
															<td style=''><strong>".strtoupper($fCliente[1])." ".strtoupper($fCliente[2])." ".strtoupper($fCliente[3])."</strong></td>
															<td style=''><strong> $ ".number_format(($fCreditos[5]),2)."</strong></td>
															<td style=''><strong> Interes hacia el Inversionista: <span class='label label-primary'>".$fCreditos[29]."%</span></strong></td>
															<td style=''>Fecha Alta: (FA): <strong>".date("d/m/Y",strtotime($fCreditos[28]))."</strong></td>";
														 if($fCreditos[12] == 1){
																//Activo
																echo "<td><span class='label label-success'>ACTIVO</span></td>";
															}
															if($fCreditos[12] == 2){
																//Activo
																echo "<td><span class='label label-default'>FINALIZADO</span></td>";
															}
															if($fCreditos[12] == 3){
																//Activo
																echo "<td><span class='label label-danger'>JURIDICO</span></td>";
															}

												echo "	</tr>
													</table><br>";
												echo "<div class='row'>
														<div class='col-xs-6'>";
												$conocer_pagos_inversionista = "select * from pinversionistas where id_credito = $fCreditos[0] AND tipo_pago='interes';";
												$iny_conocer_pagos_inversionista  = mysqli_query($mysqli,$conocer_pagos_inversionista) or die(mysqli_error());
												$acumuladopagosInteres = 0;
												if(mysqli_num_rows($iny_conocer_pagos_inversionista)>0){
													echo"<table class='table table-bordered'>
													<thead><th>Fecha</th><th>Monto</th></thead><tbody>
														";
                                        			while($fpagosInversionista = mysqli_fetch_array($iny_conocer_pagos_inversionista)){
														echo "<tr><td><span data-toggle='tooltip' title='".strftime('%A,  %d de %B del %Y',strtotime($fpagosInversionista[5]))."'>".date("d/m/Y",strtotime($fpagosInversionista[5]))."</span></td><td>$".number_format(($fpagosInversionista[3]),2)."</td></tr>";
														$acumuladopagosInteres += $fpagosInversionista[3];
													}
													echo "</tbody></table>";
												}else{
													echo "<div class='alert alert-warning'>
															<strong>Sin Informacion.</strong> No hay pagos registrados a interes
														</div>";
												}
												
												
												echo "<div class='col-sm-8 col-sm-offset-4'>
														<table class='table'>
															<thead><th><strong>Total Pagos Interes</strong></th><th>$".number_format(($acumuladopagosInteres),2)."</th></thead>
														</table>
													</div>";
												//Conocer Primer Pago
												
												
												
												$fecha_de_inicio = explode("-", $fCreditos[4]);
												$nuevafecha = strtotime ( '+1 month' , strtotime ( $fCreditos[4] ) ) ;
												$ano_proxima_fecha = date ( 'Y' , $nuevafecha );
												$mes_proxima_fecha = date ( 'm' , $nuevafecha );
												$dia_proxima_fecha = 15;
												$proxima_fecha = $ano_proxima_fecha."-".$mes_proxima_fecha."-".$dia_proxima_fecha;
												$dias_diferencia = diferenciaDias($fCreditos[4], $proxima_fecha);
												$pago_inicial = $fCreditos[5]*(((1.5/100)/30)*$dias_diferencia);
												echo '<div class="label label-default"><b>'.$dias_diferencia.' dias</b> desde <b>'.$fCreditos[4].'</b> hasta <b>'.$proxima_fecha.'</b>, por un total de $'.number_format(($pago_inicial),2).'</div>';
												
												echo "<br>";
												
												
												echo "</div>
												<div class='col-xs-6'>";
												$conocer_pagos_inversionista = "select * from pinversionistas where id_credito = $fCreditos[0] AND tipo_pago='capital';";
												$iny_conocer_pagos_inversionista  = mysqli_query($mysqli,$conocer_pagos_inversionista) or die(mysqli_error());
												$acumuladopagos = 0;
												$saldoinicial = $fCreditos[5];
												if(mysqli_num_rows($iny_conocer_pagos_inversionista)>0){
													echo"<table class='table table-bordered'>
													<thead><th>Fecha</th><th>Monto</th></thead><tbody>
														";
                                        			while($fpagosInversionista = mysqli_fetch_array($iny_conocer_pagos_inversionista)){
														echo "<tr><td><span data-toggle='tooltip' title='".strftime('%A,  %d de %B del %Y',strtotime($fpagosInversionista[5]))."'>".date("d/m/Y",strtotime($fpagosInversionista[5]))."</span></td><td>$".number_format(($fpagosInversionista[3]),2)."</td></tr>";
														$acumuladopagos += $fpagosInversionista[3];
													}
													echo "</tbody></table>";
												}else{
													echo "<div class='alert alert-warning'>
															<strong>Sin informacion.</strong> No hay pagos registrados a capital
														</div>";
												}
												$saldoRestante = $saldoinicial - $acumuladopagos;
												if($saldoRestante <= 0){
													$status = "success";
												}else{
													$status = "danger";
												}
												echo "<div class='col-sm-8 col-sm-offset-4'>
														<table class='table'>
															<thead><th><strong>Total Pagos </strong></th><th>$".number_format(($acumuladopagos),2)."</th></thead>
															<tr class='$status'><td><strong>Saldo Restante </strong></th><th>$".number_format(($saldoRestante),2)."</td></tr>
														</table>
													</div>";
												$SaldoRestanteCreditos = $SaldoRestanteCreditos + $saldoRestante;
												
												echo "</div>
														</div><br>";
											}
										}else{
											echo "<div class='alert alert-warning'>
													<strong>Sin Datos.</strong> No hay asociado ningun credito aún.
												</div>";
										}
										
									?>
									<!-- FIN CONOCER INFORMACION DE CREDITOS-->
									<hr>
								<div class="row">
									<div class="col-sm-6">
									<table class="table table-bordered table-striped">
										<tr><td><strong>Capital Acumulado: </strong></td><td><?php echo "$".number_format(($SaldoRestanteCreditos),2); ?></td></tr>
									</table>
								</div>
								<div class="col-sm-6">
									<table class="table table-bordered table-striped">
										<tr><td><strong>A pagar este mes de Interes: </strong></td><td><?php $interesAcumulado = ($SaldoRestanteCreditos/100)* 1.5; echo "$".number_format(($interesAcumulado),2); ?></td></tr>
									</table>
								</div>
								</div>
							
							

						</div>
					</div>
					<!-- END WIDGET WITH DROPDOWN -->
				</div>
			<!-- END DYNAMIC FORM FIELDS -->
            </div>
        
   
			<!-- /main -->
			<!-- FOOTER -->
			<footer class="footer">
				&copy; 2017 Syscom Leon
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
	<script src="assets/js/king-page.js"></script>
	<script src="assets/js/plugins/select2/select2.min.js"></script>
	
	<script src="assets/js/plugins/bootstrap-multiselect/bootstrap-multiselect.js"></script>

</body>

</html>

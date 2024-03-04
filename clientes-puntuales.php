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
	$pagina_actual = "clientes-puntuales";
	//PERMISOS
	if(validarAccesoModulos('permiso_prestamos') != 1) {
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
	<title>Clientes Puntuales | Credinieto</title>
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
						<li class="active">Clientes Puntuales</li>
					</ul>
				</div>

			</div>
			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Clientes Puntuales</h2>
					<em>ultimos 3 meses</em>
				</div>

				<div class="main-content">
					<!-- FEATURED DATA TABLE -->
					<div class="widget widget-table">
						<div class="widget-header">
							<h3><i class="fa fa-table"></i> Clientes Puntuales</h3> <em> -  ultimos 3 meses</em></div>
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
								$query_ConocerPagosCreditosUltimos3Meses = mysqli_query($mysqli,"SELECT 
								creditos.id_creditos,
								creditos.folio,
								concat(clientes.id_clientes,'-',clientes.nombres,' ',clientes.apaterno,' ',clientes.amaterno) AS Cliente,
								creditos.fecha_prestamo,
								pagos.fecha_pago,
								pagos.monto,
								pagos.comentarios,
							CASE 
								WHEN pagos.tipo_pago= 1 THEN '1-Pago de Interes'
								WHEN pagos.tipo_pago =2 THEN '2-Pago de Capital'
							END AS descripcionPago,
							CASE
								WHEN day(creditos.fecha_prestamo) >= day(pagos.fecha_pago) THEN '01-Pago Antes de la Fecha Limite'
								WHEN day(creditos.fecha_prestamo) < day(pagos.fecha_pago) THEN '02-Pago Fuera de Fecha Limite'
							END AS fechaPagoPuntual
							from creditos INNER JOIN pagos on creditos.id_creditos = pagos.id_credito 
							INNER JOIN clientes ON clientes.id_clientes = creditos.id_cliente
							WHERE 
								pagos.fecha_pago >= date_sub(curdate(), interval 3 month) 
							AND
								pagos.tipo_pago=1
							ORDER BY id_cliente asc,id_creditos asc;
							") or die(mysqli_error());
								echo '<table class="table">';
								echo "<thead><th>Folio de Pago</th><th>Cobro Previsto de Intereses</th><th>Cobrado en el Mes</th><th>Capital cobrado en el Mes</th><th>Otros Adeudos</th><th>Total Cobrado en el Mes</th></thead>";
								echo "<tbody>";
								if(mysqli_num_rows($query_ConocerPagosCreditosUltimos3Meses) > 0){
									$creditoTemporal = 0;
									$cadenaFila = "";
									$cliente = "";
									$contadorFila = 0;
									while($rowCreditos3Meses = mysqli_fetch_array($query_ConocerPagosCreditosUltimos3Meses)){
										if($cliente == "" || $cliente != $rowCreditos3Meses[2] ){
											echo "<tr class='info'><td colspan='6'><center><strong>".$rowCreditos3Meses[2]."</strong></center></td></tr> ";
											
										}			
										if($creditoTemporal == 0 || $creditoTemporal == $rowCreditos3Meses[0]){
											$contadorFila++;
											echo "<td>".$contadorFila."</td>";
										}else{
											
											echo "<td>".$contadorFila."</td>";
											$contadorFila = 1;
										}
			
																					
										$creditoTemporal = $rowCreditos3Meses[0];
										$cliente = $rowCreditos3Meses[2];
									}
								}else{
									echo "<tr><td>no hay resultados</td></tr>";
								}
								echo "</tbody>";
								echo "</table>";
								
							?>

							
							 
							<table id="tablita" class="table table-sorting table-hover datatable">
								<thead>
									<tr>
										<th># de Prestamo</th>
										<th>Nombre Completo</th>
										<th>Fecha Prestamo</th>
                                        <th>Estatus</th>
                                        <th>Saldo Prestamo</th>
										<th>Interes</th>
                                        <th>Pago de Intereses</th>
										<th>Operaciones</th>
									</tr>
								</thead>
								<tbody>
									<?php
										//Consulta Cientes
										$iny_clientes = mysqli_query($mysqli,"SELECT 
										creditos.id_creditos,
										creditos.folio,
										concat(clientes.id_clientes,'-',clientes.nombres,' ',clientes.apaterno,' ',clientes.amaterno) AS Cliente,
										creditos.fecha_prestamo,
										pagos.fecha_pago,
										pagos.monto,
										pagos.comentarios,
									CASE 
										WHEN pagos.tipo_pago= 1 THEN '1-Pago de Interes'
										WHEN pagos.tipo_pago =2 THEN '2-Pago de Capital'
									END AS descripcionPago,
									CASE
										WHEN day(creditos.fecha_prestamo) >= day(pagos.fecha_pago) THEN '01-Pago Antes de la Fecha Limite'
										WHEN day(creditos.fecha_prestamo) < day(pagos.fecha_pago) THEN '02-Pago Fuera de Fecha Limite'
									END AS fechaPagoPuntual
									from creditos INNER JOIN pagos on creditos.id_creditos = pagos.id_credito 
									INNER JOIN clientes ON clientes.id_clientes = creditos.id_cliente
									WHERE 
										pagos.fecha_pago >= date_sub(curdate(), interval 3 month) 
									AND
										pagos.tipo_pago=1
									ORDER BY id_cliente asc,id_creditos asc;
									") or die (mysqli_error());
									$row = mysqli_fetch_array($iny_clientes);
									var_dump($row);
										if(mysqli_num_rows($iny_clientes) > 0){
							              while($row = mysqli_fetch_array($iny_clientes)){
							                echo "<tr>
							                <td>".$row[0]."</td>
							                <td> ".$row[1]." ".$row[2]." ".$row[3]."</td>
							                <td>".date("d/m/Y",strtotime($row[4]))."</td>
							                <td>";
                                            if($row[5] == 1){
                                                echo "<span class='label label-success'>Activo</span>";
                                            }
                                              if($row[5]== 2){
                                                  echo "<span class='label label-default'>Finalizado</span>";
                                              }
                                              if($row[5] == 3){
                                                  echo "<span class='label label-danger'>En Juridico</span>";
											  }
											  if($row[5] == 4){
                                                  echo "<span class='label label-warning'>Vendido</span>";
                                              }
                                            $conocerSaldoRestante = "SELECT sum(monto) from pagos where id_credito= $row[0] and tipo_pago= 2;";
                                            $iny_conocerSaldoRestante = mysqli_query($mysqli,$conocerSaldoRestante) or die(mysqli_error());
				                            $fSaldoRestante = mysqli_fetch_row($iny_conocerSaldoRestante); 
				                            
				                            $saldoRestante = $row[6] - $fSaldoRestante[0];

                                            echo "</td><td><span title='Monto Credito: $ ".number_format(($row[5]),2)."' class='top' data-toggle='tooltip'>$ ".number_format(($saldoRestante),2)."</span></td>
                                            <td> ".$row[7]."% </td>
                                            </td><td>$ ".number_format(($row[5]),2)."</td>
                                            
							                <td> <a href='detalle-credito.php?id=$row[0]' type='button' class='btn btn-warning btn-xs'>Detalles</a> </td></tr> \n";
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

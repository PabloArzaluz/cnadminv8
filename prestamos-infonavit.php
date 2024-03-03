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
	$pagina_actual = "prestamos-infonavit";
	//Validar Permisos
	if(validarAccesoModulos('permiso_prestamos') != 1) {
		header("Location: dashboard.php");
	}
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!-->
<html lang="es" class="no-js">
<!--<![endif]-->

<head>
	<title>Prestamos "Infonavit" | Credinieto</title>
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
						<li><a href="prestamos.php">Prestamos</a></li>
						<li class="active">Prestamos Infonavit</li>
					</ul>
				</div>

			</div>
			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Prestamos Infonavit</h2>
					<em>filtro de creditos Infonavit</em>
				</div>

				<div class="main-content">
					<!-- FEATURED DATA TABLE -->
					<div class="widget widget-table">
						<div class="widget-header">
							<h3><i class="fa fa-table"></i> Prestamos Infonavit</h3> <em> -  pagina de creditos Infonavit</em></div>
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
									if($_GET['info'] == '3'){
										//ccredito elimados
										echo "<div class='alert alert-success'>
												<a href='' class='close'>&times;</a>
												<strong>Correcto.</strong> Se Elimino el credito.
										</div>";
									}
				                }
							 ?>
							<div class="col-lg-12 ">
								<div class="top-content">
									<a href="nuevo-prestamo.php" type="button" class="btn btn-success"><i class="fa fa-plus-square"></i> Agregar Nuevo Prestamo</a>
								</div>
							</div>
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
										$iny_clientes = mysql_query("SELECT
	creditos.id_creditos,
    clientes.nombres,
    clientes.apaterno,
    clientes.amaterno,
    creditos.fecha_prestamo,
    creditos.status,
    creditos.monto,
    creditos.interes,
    creditos.pago_mensual,
    creditos.folio
FROM
	creditos
INNER JOIN
	clientes
ON
	creditos.id_cliente = clientes.id_clientes WHERE creditos.infonavit=1;",$link) or die (mysql_error());
										if(mysql_num_rows($iny_clientes) > 0){
							              while($row = mysql_fetch_array($iny_clientes)){
							                echo "<tr>
							                <td>".$row[9]."</td>
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
                                            $iny_conocerSaldoRestante = mysql_query($conocerSaldoRestante,$link) or die(mysql_error());
				                            $fSaldoRestante = mysql_fetch_row($iny_conocerSaldoRestante);

				                            $saldoRestante = $row[6] - $fSaldoRestante[0];

                                            echo "</td><td><span title='Monto Credito: $ ".number_format(($row[6]),2)."' class='top' data-toggle='tooltip'>$ ".number_format(($saldoRestante),2)."</span></td>
                                            <td> ".$row[7]."% </td>
                                            </td><td>$ ".number_format(($row[8]),2)."</td>

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

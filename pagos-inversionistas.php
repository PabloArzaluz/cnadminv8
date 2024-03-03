<?php
	session_start(); // crea una sesion
	ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/functions.php");
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	//Validar Permisos
	if(validarAccesoModulos('permiso_inversionistas') != 1) {
		header("Location: dashboard.php");
	}
	$link = Conecta();

	$pagina_actual = "pagos-inversionistas";
    //Validar Permisos
	if(validarAccesoModulos('permiso_inversionistas') != 1) {
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
	<title>Pagos Inversionistas | Credinieto</title>
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
						<li><a href="pagos-inversionistas.php">Pagos Inversionistas</a></li>
						<li class="active">Todos</li>
					</ul>
				</div>

			</div>
			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Pagos Inversionistas</h2>
					<em>pagina de pagos a Inversionistas</em>
				</div>

				<div class="main-content">
					<!-- FEATURED DATA TABLE -->
					<div class="widget widget-table">
						<div class="widget-header">
							<h3><i class="fa fa-table"></i> Pagos Inversionistas</h3> <em> -  pagina de captura de pagos a Inversionistas</em></div>
						<div class="widget-content">
                            <?php
								//Operaciones
								if(isset($_GET['info'])){
									if($_GET['info'] == '1'){
										echo "<div class='alert alert-success'>
												<a href='' class='close'>&times;</a>
												<strong>Operacion Correcta.</strong> Se agrego correctamente el pago.
										</div>";
									}
									if($_GET['info'] == '2'){
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
									<a href="nuevo-pago-inversionista.php" type="button" class="btn btn-success"><i class="fa fa-plus-square"></i> Agregar Nuevo Pago a Inversionista</a>
								</div>
							</div>
							<table id="tablita" class="table table-sorting table-hover datatable">
								<thead>
									<tr>
										<th>IDPago</th>
										<th>Credito</th>
										<th>Inversionista</th>
										<th>Cliente</th>
										<th>Tipo Pago</th>
										<th>Monto Pago</th>
										<th>Fecha Captura</th>
										<th>Operaciones</th>
									</tr>
								</thead>
								<tbody>
									<?php
										//Consulta Pagos
										$iny_pagos = mysql_query("SELECT 
																pinversionistas.id_pinversionistas,
																pinversionistas.id_credito,
																pinversionistas.id_inversionista,
																inversionistas.nombre,
																clientes.nombres,
																clientes.apaterno,
																clientes.amaterno,
                                                                pinversionistas.tipo_pago,
																pinversionistas.monto,
																pinversionistas.fecha_captura,
																pinversionistas.usuario_captura,
																creditos.folio
																FROM
																pinversionistas
																INNER JOIN
																creditos
																ON
																creditos.id_creditos = pinversionistas.id_credito
																INNER JOIN
																clientes
																ON
																creditos.id_cliente = clientes.id_clientes
																INNER JOIN
																inversionistas
																ON
																creditos.id_inversionista = inversionistas.id_inversionistas;",$link) or die (mysql_error());
										if(mysql_num_rows($iny_pagos) > 0){
							              while($row = mysql_fetch_array($iny_pagos)){
							                echo "<tr>
											<td>$row[0]</td>
							                <td><a href='detalle-credito.php?id=$row[1]'>[$row[11]]</a></td>
							                <td><a href='detalle-inversionista.php?id=$row[2]'>".$row[3]."</a></td>
							                <td>".$row[4]." ".$row[5]." ".$row[6]."</td>
											<td>";
											if($row[7] == 'interes'){
                                                 echo "<span class='label label-success'>Pago de Intereses</span>";
                                             }
                                            if($row[7] == 'capital'){
                                                 echo "<span class='label label-primary'>Pago a Capital</span>";
                                             }
											  echo "</td>";
							                echo "<td>$".number_format(($row[8]),2)."</td>

							                
											<td>";
                                            $date = new DateTime($row[9]);
                                            echo date_format($date, 'd-m-Y g:i a');
                                            echo "</td>";
                                            
                                              
                                            
							                echo "<td> <a href='#' disabled type='button' class='btn btn-warning btn-xs'>Editar</a> </td></tr>";
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

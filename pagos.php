<?php
	session_start(); // crea una sesion
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	date_default_timezone_set('America/Mexico_City');
	setlocale(LC_ALL, 'es_MX.UTF-8');
	include("include/functions.php");
	
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	$pagina_actual = "pagos";
    //Validar Permisos
	if(validarAccesoModulos('permiso_pagos') != 1) {
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
	<title>Pagos | Credinieto</title>
	<?php
		include("include/head.php");
	?>
	<script src="//cdn.datatables.net/plug-ins/1.10.16/sorting/date-dd-MMM-yyyy.js"></script>
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
						<li><a href="pagos.php">Pagos</a></li>
						<li class="active">Todos</li>
					</ul>
				</div>

			</div>
			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Pagos</h2>
					<em>pagina de pagos</em>
				</div>

				<div class="main-content">
					<!-- FEATURED DATA TABLE -->
					<div class="widget widget-table">
						<div class="widget-header">
							<h3><i class="fa fa-table"></i> Pagos</h3> <em> -  pagina de captura de pagos</em></div>
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
									if($_GET['info'] == '4'){
										echo "<div class='alert alert-warning'>
												<a href='' class='close'>&times;</a>
												<strong>Operacion Correcta.</strong> Se elimino correctamente el pago.
										</div>";
									}

								}
							 ?>
							<div class="col-lg-2">
								<div class="top-content">
									
									<?php
										$ano_actual = date("Y");
										
										if(!isset($_GET['year'])){
											//echo "no hay año seleccionado, se seleccionara el actual";
											$anio = '2024';
										}else{
											//echo "seleccionar datos de año seleccionado";
											$anio = $_GET['year'];
										}
										if($anio!="0"){
											$conocer_pagos_filtrados_por_anio = "SELECT * FROM pagos_vista_simple where year(fecha_captura) = '$anio' order by fecha_captura desc";
											
										}
									?>
																				
											<label class="col-md-3 control-label" for="tipo-pago">Año</label>
											<div class="col-md-9">
											<?php 
												//Conocer años
												$conocer_years = "select year(fecha_captura) AS ANIO from pagos group by year(fecha_captura) ORDER BY ANIO DESC ;";
												$iny_conocer_years = mysqli_query($mysqli,$conocer_years) or die(mysqli_error());
											?>
												<select class="form-control" required name="tipo-pago" id="tipo-pago" onchange="cambiarYears(this)">
												<?php 
													if(mysqli_num_rows($iny_conocer_years) > 0){
							              				while($fila_years = mysqli_fetch_array($iny_conocer_years)){
															echo '<option ';
															if($anio == $fila_years[0]) echo "selected ";
															echo 'value="'.$fila_years[0].'">'.$fila_years[0].'</option>';
														
														  }
														}
												?>
												</select>
												
											</div>
										
									
								</div>
							</div>
							<div class="col-lg-10">
								<div class="top-content">
									<a href="nuevo-pago_v2.php" type="button" class="btn btn-success"><i class="fa fa-plus-square"></i> Agregar Nuevo Pago</a>
								</div>
							</div>
							<table id="tablita" class="table table-sorting table-hover datatable">
								<thead>
									<tr>
										<th>IDPago</th>
										<th>Folio Fisico</th>
										<th># Prestamo</th>
										<th>Cliente</th>
										<th>Monto Pago</th>
										<th>Metodo Pago</th>
										<th>Aplicado a</th>
										<th>Fecha/Hora Captura</th>
										<th>Tipo</th>
										
                                        <th>Operaciones</th>
									</tr>
								</thead>
								<tbody>
									<?php
										//Consulta Pagos
										$iny_pagos = mysqli_query($mysqli,$conocer_pagos_filtrados_por_anio) or die (mysqli_error());
										if(mysqli_num_rows($iny_pagos) > 0){
							              while($row = mysqli_fetch_array($iny_pagos)){
							                echo "<tr>
											<td>$row[0]</td>
							                <td><span class='badge'>$row[10]</span></td>
							                <td><a href='detalle-credito.php?id=$row[1]'>[".$row[11]."]</a></td>
							                <td>".$row[2]." ".$row[3]." ".$row[4]."</td>
											<td>$".number_format(($row[5]),2)."</td>";
											echo "<td><span class='texto-peque'>";
											if($row[12] == 100){
												echo "<i class='fa fa-money' aria-hidden='true'></i> Efectivo";
											}elseif($row[12] == 0){
												echo "<i class='fa fa-question' aria-hidden='true'></i> No Info";
											}else{
												echo "<i class='fa fa-university' aria-hidden='true'></i> ".$row[13]."<br><i class='fa fa-male' aria-hidden='true'></i> ".$row[14];
											}
											
											echo "</span></td>";
							                echo "<td>".date("d/m/Y",strtotime($row[6]))."</td>";
							                echo "<td>";
							                echo "<span title='".date('l,  d  F  Y, H:i:s',strtotime($row[7]))."' class='top' data-toggle='tooltip'>".date("d/m/Y",strtotime($row[7]))." <i class='fa fa-info-circle' aria-hidden='true'></i></span>";
											//echo "<span title='".strftime('%A,  %d de %B del %Y %I:%M:%S %p',strtotime($row[7]))."' class='top' data-toggle='tooltip'>".date("d/m/Y",strtotime($row[7]))." <i class='fa fa-info-circle' aria-hidden='true'></i></span>";
							                echo "</td>";
							                
                                            echo "<td>";
                                             if($row[8] == 1){
                                                 echo "<span class='label label-success'>Pago de Intereses</span>";
                                             }
                                            if($row[8] == 2){
                                                 echo "<span class='label label-primary'>Pago a Capital</span>";
                                             }
                                             if($row[8] == 3){
                                                 echo "<span class='label label-info'>Pago de Adeudos</span>";
                                             }
											 if($row[8] == 4){
												echo "<span class='label label-warning'>Pago de In. Moratorios</span>";
											}
											echo "</td><td>";
											if(validarAccesoModulos('permiso_eliminar_pagos') == 1){
												echo '<a href="eliminar-pago.php?idcredito='.$row[1].'&idpago='.$row[0].'" type="button" class="btn btn-danger btn-xs"><i class="fa fa-exclamation-circle"></i> Eliminar Pago</a>';
											}else{
												echo "";
											}
											// <a href='#' type='button' disabled='disabled' class='btn btn-default btn-xs'>Editar</a> ";
											echo "</td></tr> \n";
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
			  "order": [[ 0, "desc" ]],
			  "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
        ]
			 
		 });
		} );
	 </script>
	<script type="text/javascript">
		function cambiarYears(selectObject){
			var valor = selectObject.value;
			window.location = "pagos.php?year="+valor;
		}
	</script>
	
	
</body>

</html>

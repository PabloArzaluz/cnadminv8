<?php
	session_start(); // crea una sesion
	ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/functions.php");
	$link = Conecta();
	date_default_timezone_set('America/Mexico_City');
	setlocale(LC_ALL, 'es_MX.UTF-8');
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	//Validar Permisos
	if(validarAccesoModulos('permiso_reportes_de_pago') != 1) {
		header("Location: dashboard.php");
		exit();
	}
	$pagina_actual = "reporte-pago-generales-mas-pago-inver";
	$fecha = date("Y-m-d");
	$fecha_format = date("Y/m/d");
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!-->
<html lang="es" class="no-js">
<!--<![endif]-->

<head>
	<title>Reporte de Pagos | Credinieto</title>
	<?php
		include("include/head.php");
	?>
	<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
	<link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
	<script type="text/javascript">
		function calcularPagoMensual(){
			interesMensual = document.getElementById('interes-mensual').value;
			montoCredito = document.getElementById('monto-credito').value;
			pagoMensual = document.getElementById('pago-mensual').value;
			if (interesMensual.length != 0 && montoCredito.length != 0) {
				var interes = interesMensual / 100;
				var pagoM = montoCredito * interes;
				document.getElementById('pago-mensual').value = pagoM;
			}
		}
	</script>
	<script type="text/javascript">
		function alertaCreditoJuridico(id){
			document.getElementById("alerta").innerHTML = "";
			document.getElementById("monto-pago").value = "";
			var calo= id;
			
			<?php
				$conocer_en_juridico = mysql_query("select id_creditos from creditos where status=3;",$link) or die(mysql_error());
				echo "var myArr = [";
				while ($fila_juridico_conocer = mysql_fetch_array($conocer_en_juridico)) {
					echo "'$fila_juridico_conocer[0]',";
				}
					echo "];";
			?>
			if ( myArr.includes(calo) ) {
				document.getElementById("alerta").innerHTML = "<div class='alert alert-danger'><h3>El Cliente se encuentra en Juridico. Favor de pedir autorizacion para registrar pagos.</h3></div>";
			}
		}
	</script>
	<script type="text/javascript">
        $(document).ready(function() {  
            $('#credito').on("change", function(){
                
                $('#Info').html('Consultando... <img src="img/loading.gif"  alt="" /> ').fadeOut(1000);

                var username = $(this).val();       
                var dataString = 'username='+username;
                
                $.ajax({
                    type: "POST",
                    url: "ajax/get_info_credito.php",
                    data: dataString,
                    success: function(data) {
                        $('#Info').fadeIn(1000).html(data);
                        //alert(data);
                    }
                });
            });              
        });    
</script>
<script type="text/javascript">
        $(document).ready(function() {  
            $('#monto-pago').blur(function(){
                
                

                var monto = $(this).val();   
                var tipoP = $('#tipo-pago option:selected').attr('value');
                var credito = $('#credito option:selected').attr('value');
				var dataString = 'monto='+monto+'&tipo='+tipoP+'&credito='+credito;
                

                $.ajax({
                    type: "POST",
                    url: "ajax/check_pago.php",
                    data: dataString,
                    success: function(response) {
                     if (!$.trim(response)){   
						    
						}
						else{   
						   // Add response in Modal body
					      $('.modal-body').html(response);

					      // Display Modal
					      $('#empModal').modal('show'); 
						}  

                       
                    }
                });
            });              
        });    
</script>
<script type="text/javascript">
	function limpiarCampos(){
		document.getElementById("monto-pago").value="";
	}
</script>
<style>
    .tdfontmini{
        font-size:8pt;
    }
	.utilidadPositiva{
		color:green;
	}
	.utilidadNegativa{
		color:red;
	}
</style>
</head>

<body class="sidebar-fixed topnav-fixed forms-elements">
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
									<li class="active">Reporte de Pagos</li>
								</ul>
							</div>

						</div>

			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Reporte de Pagos</h2>
					<em>formulario para registro de nuevo pago</em>
				</div>
				<div class="main-content">
					<!-- HORIZONTAL FORM -->
					<div class="widget">
						<div class="widget-header">

							<h3><i class="fa fa-edit"></i> Reporte de Pagos</h3></div>
						<div class="widget-content">
							<?php
								//Operaciones
								if(isset($_GET['i'])){
									if($_GET['i'] == 'errf'){
										echo "<div class='alert alert-danger'>
												<a href='' class='close'>&times;</a>
												<strong>Ya existe Folio Fisico Registrado.</strong> Por favor verifica el folio fisico, existe un registro previo con el mismo numero. Verifica la informacion y vuelve a realizar la captura de pago. La informacion no se registro.
										</div>";
									}
								}
							?>
							<form class="form-horizontal" role="form" method="post" action="reporte-pagos-mas-pago-inver.php?b=1" autocomplete="off" enctype="multipart/form-data">
							<div class="row">
							    <div class="col-md-6">
									<div class="form-group">
										<label for="credito" class="col-sm-3 control-label">Credito</label>
										<div class="col-sm-9">
											<!-- SELECT2 -->
											<select disabled name="credito" id="credito" class="select2" required onchange="alertaCreditoJuridico(this.value)">
												<option value="">Todos</option>
													<?php
															$iny_creditos = mysql_query("SELECT 
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
                                                                creditos.id_cliente = clientes.id_clientes
                                                                where creditos.status = 1 OR creditos.status =3 ;",$link) or die (mysql_error());
															if(mysql_num_rows($iny_creditos) > 0){
															  while($row = mysql_fetch_array($iny_creditos)){
																echo "<option value='$row[0]'>[#$row[9]] $row[1] $row[2] $row[3] (FP: ".date("d/m/Y",strtotime($row[4])).") ";
																  
																if($row[5] == 3){
																	echo " ¡¡Credito en Juridico!!";
																}
																echo "</option>";
															  }
															}
															 ?>
											</select>
											<!-- END SELECT2 -->
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="credito" class="col-sm-3 control-label">Cliente</label>
										<div class="col-sm-9">
											<!-- SELECT2 -->
											<select disabled name="credito" id="credito" class="select2" required onchange="alertaCreditoJuridico(this.value)">
												<option value="">Todos</option>
													<?php
															$iny_creditos = mysql_query("SELECT 
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
                                                                creditos.id_cliente = clientes.id_clientes
                                                                where creditos.status = 1 OR creditos.status =3 ;",$link) or die (mysql_error());
															if(mysql_num_rows($iny_creditos) > 0){
															  while($row = mysql_fetch_array($iny_creditos)){
																echo "<option value='$row[0]'>[#$row[9]] $row[1] $row[2] $row[3] (FP: ".date("d/m/Y",strtotime($row[4])).") ";
																  
																if($row[5] == 3){
																	echo " ¡¡Credito en Juridico!!";
																}
																echo "</option>";
															  }
															}
															 ?>
											</select>
											<!-- END SELECT2 -->
										</div>
									</div>						
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6">
									<div class="form-group">
										<label for="datepicker" class="col-sm-3 control-label">Fecha Inicial</label>
										<div class="col-sm-9">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												<!--<input type="text" id="datepicker" class="form-control" name="fecha-pago" readonly required placeholder="Fecha de Pago (Año/Mes/Dia)">-->
												<input type="text" id="datepicker" class="form-control" name="fecha-inicial" required placeholder="Fecha Inicial">
											</div>
										</div>
									</div>						
								</div>	
								<div class="col-xs-6">
									<div class="form-group">
										<label for="datepicker2" class="col-sm-3 control-label">Fecha Final</label>
										<div class="col-sm-9">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												<!--<input type="text" id="datepicker" class="form-control" name="fecha-pago" readonly required placeholder="Fecha de Pago (Año/Mes/Dia)">-->
												<input type="text" id="datepicker2" class="form-control" name="fecha-final" required placeholder="Fecha Final">
											</div>
										</div>
									</div>						
								</div>							
							</div>
							<div class="row">
								<div class="col-xs-6">
									<div class="form-group">
										<label for="metodo-pago" class="col-sm-3 control-label">Metodo de Pago</label>
										<div class="col-sm-9">
											<select class="form-control" required name="metodo" id="metodo-pago">
												<option value="">Seleccione una opcion</option>
												<option value="200">Todos</option>
												<option value="100">Efectivo</option>
												<option value="300">Todos los Bancos</option>
												<?php
													$iny_creditos = mysql_query("SELECT * FROM cuentas_bancarias_pago where status = 1;",$link) or die (mysql_error());
													if(mysql_num_rows($iny_creditos) > 0){
														while($row = mysql_fetch_array($iny_creditos)){
															echo "<option value='$row[0]'>[Banco: $row[1]] Titular: $row[2] (Cuenta: $row[3]) ";
															echo "</option>";
														}
													}
												?>
											</select>
										</div>
									</div>						
								</div>
								<div class="col-xs-6">
									<div class="form-group">
										<label for="tipo-pago" class="col-sm-3 control-label">Tipo de Pago</label>
										<div class="col-sm-9">
											<select class="form-control" required name="tipo-pago" id="tipo-pago">
												<option value="">Seleccione una opcion</option>
												<option value="todos">Todos</option>
												<option value="capital">Pago de Capital</option>
												<option value="interes">Pago de Intereses</option>
												<option value="interes-moratorio">Pago de Intereses Moratorio</option>
											</select>
										</div>
									</div>						
								</div>						
							</div>
							<div class="row">
							<div class="col-xs-6">
									<div class="form-group">
										<label for="inversionista" class="col-sm-3 control-label">Inversionista</label>
										<div class="col-sm-9">
											<select class="form-control" name="inversionista" id="inversionista">
												<option value="">Todos</option>
												<?php
													$iny_creditos = mysql_query("SELECT * FROM inversionistas where status = 'activo' order by nombre asc;",$link) or die (mysql_error());
													if(mysql_num_rows($iny_creditos) > 0){
														while($row = mysql_fetch_array($iny_creditos)){
															echo "<option value='$row[0]'>$row[1]";
															echo "</option>";
														}
													}
												?>
											</select>
										</div>
									</div>						
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<div class="form-group">
										<div class="col-sm-3 col-sm-offset-5">
											
										</div>
	                                    <div class="col-sm-4">
										
	                                        <button type="submit" class="btn btn-success btn-block">Realizar Busqueda</button>
	                                    </div>
	                                </div>
                                </div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									
									<!-- Modal -->
								   <div class="modal fade" id="empModal" role="dialog">
								    <div class="modal-dialog modal-sm">
								 
								     <!-- Modal content-->
								     <div class="modal-content">
								      <div class="modal-header">
								        <button type="button" class="close" data-dismiss="modal">&times;</button>
								        <h4 class="modal-title">Informacion</h4>
								      </div>
								      <div class="modal-body">
								 
								      </div>
								      <div class="modal-footer">
								       <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
								      </div>
								     </div>
								    </div>
								   </div>

								</div>
							</div>
							</form>
						</div>
					</div>
					<!-- END HORIZONTAL FORM -->
					<!-- Mostrar reporte a partir de aqui-->
					<?php
						if(!isset($_GET['b'])){
							//echo "no se ha generado ninguna consulta";
						}else{
							//echo "Ya se genero una consulta";
							$fechaInicial 	= $_POST['fecha-inicial'];
							$fechaFinal 	= $_POST['fecha-final'];
							$metodo			= $_POST['metodo'];
							$tipo_pago 		= $_POST['tipo-pago'];
							$inversionista 	= $_POST['inversionista'];

							//CONSULTA PERRONA
							$arreglo_condiciones = array();
							
							//inicio tipo pago
							if($tipo_pago == "capital"){
								$var = " AND pagos2.tipo_pago='2' ";
								array_push($arreglo_condiciones,$var);
							}
							if($tipo_pago == "interes"){
								$var = " AND pagos2.tipo_pago='1' ";
								array_push($arreglo_condiciones,$var);
							}
							if($tipo_pago == "interes-moratorio"){
								$var = " AND pagos2.tipo_pago='4' ";
								array_push($arreglo_condiciones,$var);
							}
							if($tipo_pago == "todos"){
								//no se inserta nada
							}
							//FIN tipo de pago 
							//INICIO "METODO"
							if($metodo == "200"){
								//no hay que insertar nada;
							}
							elseif($metodo == "300"){
								$var = " AND metodo_pago NOT IN ('100') ";
								array_push($arreglo_condiciones,$var);
							}else{
								$var = " AND metodo_pago = '".$metodo."' ";
								array_push($arreglo_condiciones,$var);
							}
							//FIN METODO

							//INICIO "INVERSIONISTA"
							if($inversionista != ""){
								$var = " AND id_inversionista = '".$inversionista."' ";
								array_push($arreglo_condiciones,$var);
							}
							
							//FIN INVERSIONISTA
							
							
							//implode(" ",$arreglo_condiciones)."<br>";
							$consulta_reportes_con_inver = "SELECT 
							pagos2.folio_fisico,
							creditos.folio,
							pagos2.id_credito,
							clientes.nombres,clientes.apaterno,clientes.amaterno,
							pagos2.comentarios,
							pagos2.id_pagos, 
							pagos2.id_credito, 
							pagos2.tipo_pago, 
							pagos2.monto,pagos2.metodo_pago,
							cuentas_bancarias_pago.titular,
							cuentas_bancarias_pago.banco,
							  inversionistas.nombre as nombre_inversionista,
							pagos2.fecha_pago, pagos2.fecha_captura,
						  creditos.monto AS montocredito,creditos.id_inversionista, 
						  creditos.interes as interescredito,creditos.interes_inversionista,
							 (SELECT COALESCE(SUM(monto),0) FROM pagos WHERE tipo_pago = 2 AND id_credito = pagos2.id_credito) as pagosacapital
						  FROM pagos pagos2
						  inner join creditos on pagos2.id_credito = creditos.id_creditos
						  inner join clientes on clientes.id_clientes = creditos.id_cliente 
						  left join cuentas_bancarias_pago on cuentas_bancarias_pago.id_cuentasbancarias = pagos2.metodo_pago 
						  inner join inversionistas on inversionistas.id_inversionistas = creditos.id_inversionista
						  WHERE(pagos2.fecha_captura >= '".$fechaInicial." 00:00:00' AND pagos2.fecha_captura <='".$fechaFinal." 23:59:59') ".implode(" ",$arreglo_condiciones)." ORDER BY folio asc;";

							$iny_consulta = mysql_query($consulta_reportes_con_inver,$link) or die (mysql_error());
							if(mysql_num_rows($iny_consulta) > 0){
								echo '
								<div class="widget widget-table">
								<div class="widget-header">
									<h3><i class="fa fa-table"></i>Resultados</h3>
								</div>
								<div class="widget-content">
									<div class="table-responsive">
										<table id="tablita" class="table table-bordered datable" >
											<thead>
												<tr>
													<th>Folio Fisico</th>
													<th>Credito</th>
													<th>Nombres</th>
													<th>Monto</th>
													<th>Fecha de Pago</th>
													<th>Fecha Captura</th>
													<th>Tipo de Pago</th>
													<th>Comentarios</th>
													<th>Metodo de Pago</th>
													<th>Inversionista</th>
                                                    <th>Saldo Credito</th>
                                                    <th>Interes</th>
                                                    <th>Pago de Interes</th>
                                                    <th>Interes Inversionista</th>
                                                    <th>Monto a pagar Inver.</th>
                                                    <th>Utilidad</th>
												</tr>
											</thead>
											<tbody>
								';
								$suma = 0;
								$totalSaldoCredito = 0;
								$totalPagosIntereses = 0;
								$totalPagosInversionistas = 0 ;
								$totalUtilidad = 0;
								while($row = mysql_fetch_assoc($iny_consulta)){
									$suma += $row['monto'];
									echo '
									<tr>
									<td class="tdfontmini">'.$row['folio_fisico'].'</td>
									<td class="tdfontmini">#'.$row['folio'].'</td>
									<td class="tdfontmini">'.$row['nombres'].' '.$row['apaterno'].' '.$row['amaterno'].'</td>
									<td class="tdfontmini">$'.number_format(($row['monto']),2).'</td>
									<td class="tdfontmini">'.date('d/m/Y',strtotime($row['fecha_pago'])).'</td>
									<td class="tdfontmini">'.$row['fecha_captura'].'</td>';
									
									if($row['tipo_pago'] == 1)
										echo "<td><span class='label label-success'>Pago de Intereses</span></td>";
									if($row['tipo_pago'] == 2)
										echo "<td><span class='label label-primary'>Pago a Capital</span></td>";
									if($row['tipo_pago'] == 3)	
										echo "<td><span class='label label-info'>Pago de Adeudos</span></td>";
									if($row['tipo_pago'] == 4)
										echo "<td><span class='label label-warning'>Pago de In. Moratorios</span></td>";
									echo '<td class="tdfontmini">'.$row['comentarios'].'</td>';
									
									if($row['metodo_pago'] == 100){
										echo "<td class='tdfontmini'><span class='badge'><i class='fa fa-money' aria-hidden='true'></i> Efectivo</span></td>";
									}elseif($row['metodo_pago'] == 0){
										echo "<td class='tdfontmini><i class='fa fa-question' aria-hidden='true'></i> No Info</td>";
									}else{
										echo "<td class='tdfontmini'><span class='badge'><i class='fa fa-university' aria-hidden='true'></i> ".$row['banco']."</span><br><i class='fa fa-male' aria-hidden='true'></i> ".$row['titular']."</td>";
									}
									echo "<td class='tdfontmini'>".$row['nombre_inversionista']."</td>";
									$saldo_credito = $row['montocredito'] - $row['pagosacapital'];
									$totalSaldoCredito += $saldo_credito;
                                    echo "<td class='tdfontmini'>$".number_format($saldo_credito,2)."</td>";
                                    echo "<td class='tdfontmini'>".$row['interescredito']."% </td>";
									$pagoInteres = ($saldo_credito/100)*$row['interescredito'];
									$totalPagosIntereses += $pagoInteres;
                                    echo "<td class='tdfontmini'>$".number_format($pagoInteres,2)."</td>";
									
                                    echo "<td class='tdfontmini'>".$row['interes_inversionista']."% </td>";
									$pagoInteresInversionista = ($saldo_credito /100)*$row['interes_inversionista'];
									$totalPagosInversionistas += $pagoInteresInversionista;
                                    echo "<td class='tdfontmini'>$".number_format($pagoInteresInversionista,2)."</td>";
									$utilidad = $pagoInteres - $pagoInteresInversionista;
									$totalUtilidad += $utilidad;
                                    echo "<td class='tdfontmini";
									if($utilidad > 0){
										echo " utilidadPositiva ";
									}else{
										echo " utilidadNegativa ";
									}
									echo "'><strong>$".number_format($utilidad,2)."</strong></td>";
								echo '</tr>
									
									';
								}
								echo '
										</tbody>
										<thead>
											<tr>
												<th></th>
												<th></th>
												<th></th>
												<th><strong>$'.number_format(($suma),2).'</strong></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
                                                <th><strong>$'.number_format(($totalSaldoCredito),2).'</strong></th>
                                                <th></th>
                                                <th><strong>$'.number_format(($totalPagosIntereses),2).'</strong></th>
                                                <th></th>
												<th><strong>$'.number_format(($totalPagosInversionistas),2).'</strong></th>
                                                <th><strong>$'.number_format(($totalUtilidad),2).'</strong></th>
											</tr>
										</thead>
										</table>
									</div>
								</div>
							</div>
								';
							}else{
								echo '<div class="alert alert-warning alert-dismissable">
								<a href="" class="close">&times;</a>
								<strong>Sin Resultados</strong> No se encontraron resultados con la informacion especificada.
							</div>';
							}
						}
						
					?>
					<!-- Fin del Reporte-->
				</div>
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
	<script type="text/javascript">
			 $(document).ready(function() {
				$.fn.dataTable.moment( 'DD/MM/YYYY' );
				$.fn.dataTable.moment( 'YYYY-MM-DD HH:mm:ss' );
    			
				 $('#tablita').DataTable( {
					 "order": [[ 0, "desc" ]],
					 "paging": false
				 } );
				} );
	 </script>
	<!-- Javascript -->
	<script src="js/jquery-2.1.0.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/modernizr.js"></script>
	<script src="js/bootstrap-tour.custom.js"></script>
	<script src="js/jquery.slimscroll.min.js"></script>
	<script src="js/king-common.js"></script>
	<script src="js/bootstrap-switch.min.js"></script>
	<script src="assets/js/plugins/jquery-maskedinput/jquery.masked-input.min.js"></script>
	<script src="assets/js/plugins/bootstrap-multiselect/bootstrap-multiselect.js"></script>
	<script src="assets/js/jquery-ui/jquery-ui-1.10.4.custom.min.js"></script>
	<script src="assets/js/plugins/jqallrangesliders/jQAllRangeSliders-min.js"></script>
	<script src="assets/js/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.js"></script>
	<script src="assets/js/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.js"></script>
	<script src="assets/js/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>

	<script src="assets/js/plugins/daterangepicker/daterangepicker.js"></script>
	<script src="assets/js/plugins/moment/moment.min.js"></script>
	<script src="assets/js/plugins/bootstrap-slider/bootstrap-slider.js"></script>
	<script src="assets/js/plugins/select2/select2.min.js"></script>

	<script src="js/dataTables.bootstrap.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>				

	<script src="js/king-elements.js"></script>
	<script type="text/javascript">
	$(".js-example-placeholder-single").select2({
    placeholder: "Select a state",
    allowClear: true
});

	</script>
	
	 <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
	<script src="//cdn.datatables.net/plug-ins/1.13.7/sorting/datetime-moment.js"></script>
</body>

</html>

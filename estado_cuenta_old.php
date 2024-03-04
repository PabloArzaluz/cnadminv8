<?php
	session_start(); // crea una sesion
	include("include/configuration.php");
	date_default_timezone_set('America/Mexico_City');
	setlocale(LC_ALL, 'es_MX.UTF-8');

	//include('dbcon.php');
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/funciones.php");
	
	$date_actual = date("Y-m-d");
	$hora = date('g:i:s A');

?>
<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<title>Estado de Cuenta</title>
	 <link href="css/sticky-footer.css" rel="stylesheet">
	 <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>

	 <!-- Fav and touch icons -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-icon-144x144.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-icon-114x114.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-icon-72x72.png">
<link rel="apple-touch-icon-precomposed" sizes="57x57" href="ico/apple-icon-57x57.png">
<link rel="shortcut icon" href="ico/favicon.ico">
	<style type="text/css">
	.letragrande{font-size:12px;}
	</style>


  </head>
  <body>
    <div class="container">
    	<?php
		    $id_credito = $_GET['id']; 
		    $query = "
					SELECT 
	                    creditos.id_creditos,
	                    clientes.nombres,
	                    clientes.apaterno,
	                    clientes.amaterno,
	                    creditos.fecha_prestamo,
	                    creditos.status,
	                    creditos.monto,
	                    creditos.interes,
	                    creditos.pago_mensual,
	                    creditos.folio,
	                    creditos.interes_moratorio,
	                    creditos.fecha_cierre_credito
	                FROM
	                    creditos
	                INNER JOIN
	                    clientes
	                ON
	                    creditos.id_cliente = clientes.id_clientes
	                    where creditos.id_creditos = '".strtolower($id_credito)."';
	                ";
			$credito = mysql_query($query,$link) or die(mysql_error());
			$f_credito = mysql_fetch_row($credito);

	        
		?>
		<div class="row">
    		<div class="col-lg-12">
    			<div class="card card-default">
				  <div class="card-body">
				  	<div class="row">
				  		
				  		<div class="col-lg-6 offset-lg-6"><strong>Fecha de Impresion: </strong><?php echo strftime('%A,  %d de %B del %Y , ',strtotime($date_actual)); echo $hora; ?></div>
				  	</div>
				  	<div class="row">
				  		<div class="col-lg-9">
				  			<strong>Folio de Credito: </strong><?php echo $f_credito[9];?>
				  		</div>
				  	</div>
				  	<div class="row">
				  		<div class="col-lg-9">
				  			<strong>Cliente: </strong><?php echo $f_credito[1]." ".$f_credito[2]." ".$f_credito[3];?>
				  		</div>
				  	</div>
				  </div>
				 </div>
    		</div>
    	</div>
		<br>
		<div class="row">
			<div class="col-lg-12">
				<div class="card card-default">
				  <div class="card-body">
				  	<div class="row">
				  		<div class="col-sm-2">
					      <strong>Fecha de Inicio</strong><br> <?php echo strftime('%d-%B-%Y',strtotime($f_credito[4])); ?>
					    </div>
					    
				    <div class="col-sm-2">
				      <strong>Monto de Inicio</strong><br> <?php echo "$".number_format(($f_credito[6]),2); ?>
				    </div>
				     <div class="col-sm-2">
				      <strong>Interes</strong><br> <?php echo $f_credito[7]."%"; ?>
				    </div>
				    <div class="col-sm-2">
				      <strong>Interes Moratorio</strong><br> <?php echo $f_credito[10]."%"; ?>
				    </div>
				    <div class="col-sm-2">
				      <strong>Saldo Credito</strong><br> <?php echo "$".number_format((conocer_monto_deudor($f_credito[0])),2); ?>
				    </div>
				    <div class="col-sm-2">
				      <strong>Estatus</strong><br> 
				      <?php if($f_credito[5] == 1){
                            //Activo
                            echo "<span class='badge badge-success'>ACTIVO</span>";
                        }
                        if($f_credito[5] == 2){
                            //Activo
                            echo "<span class='badge badge-secondary'>FINALIZADO <span class='badge'>(".date("d/m/Y",strtotime($f_credito[11])).")</span></span>";
                        }
                        if($f_credito[5] == 3){
                            //Activo
                            echo "<span class='badge badge-secondary'>JURIDICO <span class='badge'>Finalizado: ".date("d/m/Y",strtotime($f_credito[11]))."</span></span>";
                        } ?>
				    </div>
				  	</div>
				  </div>
				</div>
			</div>
		</div>
		<br>
    	<div class="row">
    		<div class="col-sm-12">
    			<?php 
    				//Informacion

    				if(isset($_GET['info'])){
						if($_GET['info'] == 'errf'){
							echo "<div class='alert alert-danger'>
									<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
									  <span aria-hidden='true'>&times;</span>
									</button>
									<strong>Ya existe Folio Fisico Registrado.</strong> Por favor verifica el folio fisico, existe un registro previo con el mismo numero. Verifica la informacion y vuelve a realizar la captura de pago. La informacion no se registro.
							</div>";
						}
					}
    			?>
    		</div>	
    	</div>
  		<br>
  		<div class="row">
  			<div class="col-sm-12">
  				
  				<?php 
  					$fecha_inicio_credito= $f_credito[4];
			        $fecha_arranque_sistema = '2018-01-01';
			        $fecha_actual = $date_actual;

			        if($f_credito[10] == ""){
						$interesMoratorio = $f_credito[7];
					}else{
						$interesMoratorio = $f_credito[10];
					}
					echo "<table class='table table-bordered table-sm letragrande'>";
					
					$month_current = date('Y-m',strtotime($fecha_actual));
					$aux_current_month = date('Y-m-d', strtotime("{$month_current} + 1 month"));
					$last_day = date('Y-m-d', strtotime("{$aux_current_month} - 1 day"));
					$mas_5_meses_adicionales =  date('Y-m-d', strtotime("{$last_day} + 5 month"));
					if($fecha_inicio_credito > $fecha_arranque_sistema){
						//Realizar Arreglo desde que inicio el credito
						//Ultimo dia del mes Actual
                		$fecha_inicio_ciclo = $fecha_inicio_credito;
					}else{
						//Ultimo dia del mes Actual
                		$fecha_inicio_ciclo = $fecha_arranque_sistema;
                		//Realizar Arreglo desde el inicio de Sistema solo este año
					echo "<tr class='table-warning'><td colspan='7'><center><i class='fas fa-info'></i> Se mostraran unicamente registros a partir del 1° de Enero del 2018 </center></td></tr>";
					}
					
					
					
					//Ultimo dia del mes Actual
            		$month_current = date('Y-m',strtotime($fecha_actual));
					$aux_current_month = date('Y-m-d', strtotime("{$month_current} + 1 month"));
					$last_day = date('Y-m-d', strtotime("{$aux_current_month} - 1 day"));
					$mas_5_meses_adicionales =  date('Y-m-d', strtotime("{$last_day} + 5 month"));
					while (strtotime($fecha_inicio_ciclo) <= strtotime($mas_5_meses_adicionales)) {
                		$dia_credito_enero = date('Y-m',strtotime($fecha_inicio_ciclo))."-".date("d",strtotime($f_credito[4]));
                		$fecha_maxima_pago = date ("d-m-Y", strtotime("+5 days", strtotime($dia_credito_enero)));
                		//Conocer Estado de Pago

                		$fecha_pago_normal = date("d",strtotime($f_credito[4]))."-".date('m-Y',strtotime($fecha_inicio_ciclo));
                		if(strtotime($fecha_actual) < strtotime($fecha_pago_normal)){
                			$tipo_pago = "Pago A Tiempo";
                			$interes_a_cobrar = $f_credito[7];
                			$cadena_tipo_pago = "<span class='badge badge-info'>$tipo_pago</span>";
                		}
                		if(strtotime($fecha_actual) < strtotime($fecha_maxima_pago) && strtotime($fecha_actual) > strtotime($fecha_pago_normal)){
                			$tipo_pago = "En Prorroga";
                			$interes_a_cobrar = $f_credito[7];
                			$cadena_tipo_pago = "<span class='badge badge-warning'>$tipo_pago</span>";
                		}
                		if(strtotime($fecha_actual) > strtotime($fecha_maxima_pago)){
                			$tipo_pago = "Fuera de Tiempo";
                			$interes_a_cobrar = $interesMoratorio;
                			$cadena_tipo_pago = "<span class='badge badge-secondary'>$tipo_pago</span>";
                		}
                		echo "<tr class='table-active'><td colspan='7'><center><h5>".strftime('%B-%Y',strtotime($fecha_inicio_ciclo))." <small>Fecha Pago: $fecha_pago_normal / Fecha Limite: $fecha_maxima_pago $cadena_tipo_pago</small></h5></center></td></tr>";
                		//Conocer si hay pagos, si los hay, mostrarlos y el respectivo adeudo, si no los hay mostrar pago segun fecha
                		$conocer_pagos_recibidos_mes = "SELECT * FROM pagos WHERE id_credito = '$f_credito[0]' AND MONTH(fecha_pago)='".date('m',strtotime($fecha_inicio_ciclo))."' AND YEAR(fecha_pago) = '".date('Y',strtotime($fecha_inicio_ciclo))."' and tipo_pago=1;";
                		$iny_conocer_pagos_recibidos = mysql_query($conocer_pagos_recibidos_mes,$link) or die(mysql_error());
                		if(mysql_num_rows($iny_conocer_pagos_recibidos) > 0 ){
                				//Si hay pagos recibidos
                				while($f_pagos = mysql_fetch_array($iny_conocer_pagos_recibidos)){
                					echo "<tr >";

			                		echo "<td><i class='fas fa-calendar-check'></i> Pago Recibido</td>";
			                		echo "<td><b>Folio:</b> ".$f_pagos[8]."</td>";
			                		echo "<td><strong>Monto Pago:</strong> $".number_format(($f_pagos[5]),2)."</td>";
			                		echo "<td><strong>Fecha Captura: </strong><span class='top' data-toggle='tooltip' title='".date('d/m/Y g:i a',strtotime($f_pagos[2]))."'>".date('d/m/Y',strtotime($f_pagos[2]))."</span></td>";

			                		
			                		
			                		if($f_pagos[10] == ""){
			                			$interes_cobrado = "<i>No registrado</i>";
			                			echo "<td><strong>Interes Cobrado: </strong><i>No registrado</i></td>";
			                		}else{
			                			$interes_cobrado = $f_pagos[10];
			                			echo "<td><strong>Interes Cobrado: </strong>".$interes_cobrado."%</td>";
			                		}
			                		
			                		if($f_pagos[9] == ""){
			                			$saldo_credito = "<i>No registrado</i>";
			                			echo "<td><strong>Saldo Credito: </strong><i>No registrado</i></td>";
			                		}else{
			                			$saldo_credito = $f_pagos[9];
			                			echo "<td><strong>Saldo Credito: </strong>$".number_format(($saldo_credito),2)."</td>";
			                		}
			                		
			                		if($f_pagos[7] == ""){
			                			$comentarios = "Sin Comentarios registrados";
			                			$fa_icon = "<i class='far fa-comment'></i>";
			                		}else{
			                			$comentarios = $f_pagos[7];
			                			$fa_icon = "<i class='fas fa-comment-alt'></i>";
			                		}
			                		echo "<td><strong> Comentarios: <span title='".$comentarios."' class='top' data-toggle='tooltip'>$fa_icon</span></strong></td>";
			                		
			                		
			                		
		                		}
		                		//Conocer adeudos en pagos
			                		$conocer_adeudos_pagos = "SELECT COALESCE(saldo_mes_intereses,0) FROM pagos WHERE MONTH(fecha_pago)='".date('m',strtotime($fecha_inicio_ciclo))."' AND YEAR(fecha_pago)='".date('Y',strtotime($fecha_inicio_ciclo))."' AND id_credito='".$f_credito[0]."' ORDER BY id_pagos DESC limit 1;";
			                		$iny_ConocerAdeudosPagos = mysql_query($conocer_adeudos_pagos,$link) or die(mysql_error());
			                		$f_ConocerAdeudosPagos = mysql_fetch_row($iny_ConocerAdeudosPagos);
			                		if($f_ConocerAdeudosPagos[0] > 0){
			                			//Hay adeudos, mostrar pagos y formlario de pago
			                			echo "<tr>";
			                			echo "<td><center><span class='badge badge-warning'><i class='fas fa-exclamation-circle'></i> Existen Adeudos</span></center></td>";
			                			echo "<td><b>Adeudo por: </b> $".$f_ConocerAdeudosPagos[0]."</td>";
			                			echo "<td colspan='4'><strong>Interes a Cobrar:</strong> $interes_a_cobrar%</td>";
			                			
			                			$fecha_a_aplicar_pago = date('Y-m',strtotime($fecha_inicio_ciclo))."-01";
			                			
			                			echo "<td><button onclick='myFunction(".$f_credito[9].",".$f_ConocerAdeudosPagos[0].",\"".$fecha_actual."\",".$f_credito[0].",".$interes_a_cobrar.",\"".$fecha_a_aplicar_pago."\");' type='button' class='btn btn-sm btn-outline-success' data-toggle='modal' data-target='#exampleModal'>
								  Pagar Adeudo
								</button></td>";
			                			echo "</tr>";
			                		} else{
			                			echo "<tr>";
				                		echo "<td><center><span class='badge badge-success'><i class='fas fa-check-circle'></i> Sin Adeudos</span></center></td>";
				                		echo "</tr>";
			                		}
								
                		}else{
                			// No hay pagos recibidos
                			$conocer_saldo_credito = conocer_monto_deudor($f_credito[0]);
                			
                			$monto_a_pagar_mes = ($conocer_saldo_credito / 100) * $interes_a_cobrar;
                			echo "<tr>";
		                		echo "<td><i class='far fa-calendar-times'></i> No hay pagos recibidos</td>";
		                		echo "<td><strong>Monto a Pagar al dia de hoy: </strong>$".number_format(($monto_a_pagar_mes),2)."</td>";
		                		echo "<td colspan='4'><strong>Interes a Cobrar: </strong>".$interes_a_cobrar."%</td>";
		                		
		                		$fecha_a_aplicar_pago = date('Y-m',strtotime($fecha_inicio_ciclo))."-01";
		                		
		                		echo "<td><button onclick='myFunction(".$f_credito[9].",".$monto_a_pagar_mes.",\"".$fecha_actual."\",".$f_credito[0].",".$interes_a_cobrar.",\"".$fecha_a_aplicar_pago."\")' type='button' class='btn btn-sm btn-outline-success' data-toggle='modal' data-target='#exampleModal'>
								  Pagar Mes
								</button></td>";
		                		echo "</tr>";
		                		
                		}
                		$fecha_inicio_ciclo = date ("Y-m-d", strtotime("+1 month", strtotime($fecha_inicio_ciclo)));
					}
				
					echo "</table>"
  				?>
  			</div>
  		</div>
    </div>
    <footer class="footer fixed-bottom">
      <div class="container">
        <span class="text-muted">Está pagina únicamente es informativa por lo que no tiene ninguna validez legal. <a href="detalle-credito.php?id=<?php echo $id_credito; ?>"><i class="fas fa-undo-alt"></i> Regresar</a></span>
      </div>
    </footer>

    <!-- Inicio de modal -->
    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmar Pago</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="container">
      	<form method="post" action="_registro_pago_intereses.php" name="captura-pago">
      		<input type="hidden" name="id-credito" id="id-credito" >
      		<input type="hidden" name="fecha-aplicar-pago" id="fecha-aplicar-pago" >
      		<input type="hidden" name="monto-a-pagar" id="monto-a-pagar" >
			<div class="form-group row"> 
			    <label class="col-sm-5 col-form-label" for="numero-credito">Numero de Credito</label>
			    <div class="col-sm-7">
			    	<input class="form-control" id="numero-credito" required name="numero-credito"  readonly="readonly" placeholder="Numero de Credito" type="number"/>
			    </div>
			</div>
			<div class="form-group row"> 
			    <label class="col-sm-5 col-form-label" for="folio-pago">Folio de Pago</label>
			    <div class="col-sm-7">
			    	<input class="form-control" id="folio-pago" name="folio-pago" required type="number"/>
			    </div>
			</div>
			<div class="form-group row"> 
			    <label class="col-sm-5 col-form-label" for="monto-pago">Monto de Pago</label>
			    <div class="col-sm-7">
			    	<input class="form-control" id="monto-pago" name="monto-pago" required placeholder="Monto Pago" type="text"/>
			    </div>
			</div>
			<div class="form-group row"> 
			    <label class="col-sm-5 col-form-label" for="date">Fecha Aplicacion</label>
			    <div class="col-sm-7">
			    	<input class="form-control" id="date" name="date" required placeholder="YYYY/MM/DD" type="text"/>
			    </div>
			</div>
			<div class="form-group row"> 
			    <label class="col-sm-5 col-form-label" for="interes">Interes Cobrado</label>
			    <div class="col-sm-7">
			    	<input class="form-control" id="interes" name="interes" required readonly="readonly" placeholder="Interes Cobrado" type="text"/>
			    </div>
			</div>
		  	<div class="form-group row">
			    <label for="comentarios" class="col-sm-5 col-form-label">Comentarios</label>
			    <div class="col-sm-7">
			    	<textarea class="form-control" id="comentarios" name="comentarios" ></textarea>
			    </div>
		  	</div>
		       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Confirmar Pago</button>
        </form> 
      </div>
    </div>
  </div>
</div>
    <!-- Fin de Modal-->

	<!-- Extra JavaScript/CSS added manually in "Settings" tab -->
	<!-- Include jQuery -->
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script>
		function myFunction(FolioCredito,montoPago,fechaActual,idCredito,interesACobrar,fechaAAplicarPago) {
		    document.getElementById("folio-pago").value = "";
		    document.getElementById("comentarios").value = "";
		    
		   	document.getElementById("numero-credito").value = FolioCredito;
		   	document.getElementById("monto-pago").value = montoPago;
		   	document.getElementById("monto-a-pagar").value = montoPago;
		   	document.getElementById("date").value = fechaActual;
		   	document.getElementById("id-credito").value = idCredito;
		   	document.getElementById("interes").value = interesACobrar;
		   	document.getElementById("fecha-aplicar-pago").value = fechaAAplicarPago;
		}

	</script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript">
    	$(function () {
		  $('[data-toggle="tooltip"]').tooltip()
		})
		
    </script>
	<!-- Extra JavaScript/CSS added manually in "Settings" tab -->
	<!-- Include jQuery -->
	<!-- Include Date Range Picker -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
	<script>
		$(document).ready(function(){
			var date_input=$('input[name="date"]'); //our date input has the name "date"
			var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
			date_input.datepicker({
				format: 'yyyy-mm-dd',
				container: container,
				todayHighlight: true,
				autoclose: true,
				locale: 'es',
				showTodayButton: true,
			})
		})
	</script>
  </body>
</html>
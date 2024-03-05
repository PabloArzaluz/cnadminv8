<?php
	session_start();
    header('Content-Type: text/html; charset=UTF-8');
	include("include/configuration.php");
	include("conf/conecta.inc.php");
    include("conf/config.inc.php");
    include("include/functions.php"); 
    include("include/funciones.php");
    date_default_timezone_set('America/Mexico_City');
    setlocale(LC_ALL, 'es_MX.UTF-8');
	
    mysqli_set_charset($mysqli,'utf8');
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	$pagina_actual = "prestamos";
    $fecha_actual = date("Y-m-d");
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
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Detalle Credito | Portal Credinieto</title>
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
            font-weight: bold;
        }
        .linea{
            border-bottom: 1px solid #CACACB;

        }
        .titulo{
                font-family: "latolight";
                font-size: 12pt;
                text-align: center;
        }
        .tabla-inner{
             width:100%;
        }
        .tabla-inner td{
            padding:2px;
        }
        .tdfontmini{
            font-size:8pt;
        }
        .tdfontmini-warning{
            font-size:8pt;
            color:#1192EB;
        }
        .tdfontmini-danger{
            font-size:8pt;
            color:#E42D00;
        }
        .tdfontmini-green{
            font-size:8pt;
            color:#009E24;
        }
</style>

</head>

<body class="sidebar-fixed topnav-fixed">
	<!-- WRAPPER -->
	<div id="wrapper" class="wrapper">
		<?php
			include("include/top-bar.php");
			include("include/left-sidebar.php");
		 ?>
		<!-- MAIN CONTENT WRAPPER -->
		<div class="content-wrapper" id="main-content-wrapper">
			<div class="row">
				<div class="col-lg-4 ">
					<ul class="breadcrumb">
						<li><i class="fa fa-home"></i><a href="#">Inicio</a></li>
						<li><a href="prestamos.php">Prestamos</a></li>
						<li class="active">Detalles Prestamos</li>
					</ul>
                </div>
			</div>
			<!-- main -->
			<div class="content">
                <?php
                    $id_credito = $_GET['id'];
                    $fila_credito = conocer_informacion_credito($id_credito);
                ?>
				<div class="main-content">
                    <!-- DYNAMIC FORM FIELDS -->
					<div class="widget">
                        <div class="widget-header">
                            <h3><i class="fa fa-edit"></i> Detalle Prestamo</h3>
                        </div>
                        <div class="widget-content">
                            <?php
                                //Operaciones
                                if(isset($_GET['info'])){
                                    if($_GET['info'] == '4'){
                                        echo "<div class='alert alert-success'>
                                                <a href='' class='close'>&times;</a>
                                                <strong>Operacion Correcta.</strong> Se elimino correctamente el registro de pago del SAT
                                        </div>";
                                    }
                                    if($_GET['info'] == '1'){
                                        echo "<div class='alert alert-success'>
                                                <a href='' class='close'>&times;</a>
                                                <strong>Operacion Correcta.</strong> Se actualizo correctamente el numero de folio
                                        </div>";
                                    }
                                    if($_GET['info'] == '2'){
                                        echo "<div class='alert alert-success'>
                                                <a href='' class='close'>&times;</a>
                                                <strong>Operacion Correcta.</strong> Se actualizo correctamente la informacion del credito
                                        </div>";
                                    }
                                    if($_GET['info'] == '5'){
                                        echo "<div class='alert alert-success'>
                                                <a href='' class='close'>&times;</a>
                                                <strong>Operacion Correcta.</strong> Se actualizo correctamente la informacion del inversionista.
                                        </div>";
                                    }
                                }
                             ?>
                            <?php
                                $CONOCER_ALERTA_ACTUAL = "SELECT * from alerta_credito where idCredito = $id_credito AND status = 1 ORDER BY idAlertaCredito desc limit 1";
                                $INY_CONOCER_ALERTA_ACTUAL = mysqli_query($mysqli,$CONOCER_ALERTA_ACTUAL) or die(mysqli_error());
                                $alertaActivada = 0;
                                if(mysqli_num_rows($INY_CONOCER_ALERTA_ACTUAL) > 0 ){
                                    $alertaActivada = 1;
                                    $FILA_CONOCER_ALERTA_ACTUAL = mysqli_fetch_array($INY_CONOCER_ALERTA_ACTUAL);
                                }
                                if(validarAccesoModulos('permiso_alertas_credito') == 1){ 
                                if($alertaActivada == 1){
                                    echo '<div class="alert alert-warning">
										<strong>ALERTA ACTIVADA.</strong> Se tiene registrada una alerta para este credito para el dia '.date('d-F-Y',strtotime($FILA_CONOCER_ALERTA_ACTUAL[2])).'.  <a href="" data-toggle="modal" data-target="#myModal">Mostrar</a>
							        </div>';
                                    echo '
                                    
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="modal-title" id="myModalLabel">Alerta de Credito</h4>
												</div>
												<div class="modal-body">
													<p>
                                                        <strong>Comentarios:</strong>'.$FILA_CONOCER_ALERTA_ACTUAL[3].'
                                                        <br>
                                                        <strong>Fecha:</strong>'.date('d-F-Y',strtotime($FILA_CONOCER_ALERTA_ACTUAL[2])).'
                                                    </p>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cerrar</button>
													<a href="editar-alerta-credito.php?id='.$id_credito.'" type="button" class="btn btn-custom-primary"><i class="fa fa-check-circle"></i> Eliminar / Modificar</a>
												</div>
											</div>
										</div>
									</div>
                                    
                                    ';
                                }
                            }
                            
                            ?>      
									
                            <!-- INVOICE -->
                            <div class="invoice">
                                <!-- invoice header -->
					            <div class="invoice-header">
                                    <div class="row">
                                        <div class="col-lg-12 col-print-9">
                                            <table class="tabla-prestamos">
                                                <tr>
                                                    <td class="izq">
                                                        <?php
                                                            if($fila_credito[12] == 1){
                                                                //CREDITO ACTIVO
                                                                echo "<h3><span class='label label-success'>ACTIVO</span></h3>";
                                                            }
                                                            if($fila_credito[12] == 2){
                                                                //CREDITO FINALIZADO
                                                                echo "<h3><span class='label label-default'>FINALIZADO <span class='badge'>(";
                                                                if(is_null($fila_credito[23])){
                                                                    echo "Fecha no capturada";
                                                                }else{
                                                                    echo date("d/m/Y",strtotime($fila_credito[23]));
                                                                }
                                                                echo ")</span></span></h3>";
                                                            }
                                                            if($fila_credito[12] == 3){
                                                                //CREDITO JURIDICO
                                                                $CONOCER_FECHA_JURIDICO = "SELECT fecha_registro from juridicos where id_credito=$id_credito ORDER BY id_juridicos desc limit 1";
                                                                $INY_CONOCER_FECHA_JURIDICO = mysqli_query($mysqli,$CONOCER_FECHA_JURIDICO) or die(mysqli_error());
                                                                $FILA_CONOCER_FECHA_JURIDICO = mysqli_fetch_array($INY_CONOCER_FECHA_JURIDICO);
                                                                echo "<h3><span class='label label-danger'>JURIDICO <span class='badge'>Fecha: ".date("d/m/Y",strtotime($FILA_CONOCER_FECHA_JURIDICO[0]))."</span></span></h3>";
                                                            }
                                                            if($fila_credito[12] == 4){
                                                                //CCREDITO VENDIDO
                                                                echo "";
                                                                $conocer_informacion_credito_vendido = "SELECT fechahora,comentarios,statusanterior FROM creditos_vendidos WHERE idCredito = $id_credito;";
                                                                $iny_ConocInforCrediVendi = mysqli_query($mysqli,$conocer_informacion_credito_vendido) or die(mysqli_error());
                                                                
                                                                if(mysqli_num_rows($iny_ConocInforCrediVendi) > 0){
                                                                    $fVentaCredit = mysqli_fetch_array($iny_ConocInforCrediVendi);
                                                                    $infoVendidos = "Fecha Venta: ".$fVentaCredit[0]."<br>Comentarios: ".$fVentaCredit[1]."<br>Estatus Anterior: ".conocer_estatus_credito_cadena($fVentaCredit[2]);

                                                                    echo '<h3><span class="label label-warning">VENDIDO</span><a href="#" data-html="true" title="Informacion de Venta de Credito" data-toggle="popover" data-trigger="hover" data-content="'.$infoVendidos.'">
                                                                    <i class="fa fa-exclamation-circle"></i></a></h3>
                                                                ';
                                                                }
                                                            
                                                            }

                                                        ?>
                                                    </td>
                                                    <td class="izq"><td><center><span class="input-group-btn">
                                                        <a href="estado_cuenta.php?id=<?php echo $fila_credito[0]; ?>" class="btn btn-default" type="button"><i class="fa fa-book"></i>Ver Estado de Cuenta</a>
                                                    </span></center></td></td>
                                                    <td></td>
                                                    <td class="der">
                                                        <?php
                                                            if($_SESSION['level_user'] == 4 || $_SESSION['level_user'] == 5 || $_SESSION['level_user'] == 3){
                                                        ?>
                                                        <?php
                                                           if(validarAccesoModulos('permiso_operaciones_adicionales_credito') == 1) {
                                                           
                                                        ?>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-default btn-default dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cog" aria-hidden="true"></i> Operaciones <span class="caret"></span></button>
                                                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                                <li class="dropdown-header">Operaciones Generales</li>
                                                                <li><a href="modificar-folio.php?id=<?php echo $fila_credito[0]; ?>">Modificar Folio del Credito</a></li>
                                                                <li><a href="modificar-basico-credito.php?id=<?php echo $fila_credito[0]; ?>">Modificar Informacion de Credito</a></li>
                                                                <?php
                                                                    if($_SESSION['level_user'] < 4){
                                                                        //no permite Eliminar
                                                                        echo "<li class='disabled'><a href='#'>Eliminar Credito</a></li>";
                                                                    }else{
                                                                        //Permite eliminar
                                                                        echo "<li><a href='eliminar-credito.php?id=$id_credito'>Eliminar Credito</a></li>";
                                                                    }
                                                                ?>
                                                                <?php /*Validar Usuario permisos*/ if(validarAccesoModulos('permiso_alertas_credito') == 1){ ?>
                                                                <li>
                                                                    <?php 
                                                                        
                                                                        if( $alertaActivada ==1){
                                                                            //si hay registro
                                                                            echo '<a href="editar-alerta-credito.php?id='.$fila_credito[0].'"><i class="fa fa-bell"></i> Editar / Eliminar Alerta Programada</a>';
                                                                        }else{
                                                                            //no hay ningun registro
                                                                            echo '<a href="agregar-alerta-credito.php?id='.$fila_credito[0].'"><i class="fa fa-bell"></i> Agregar Alerta Programada</a>';
                                                                        }
                                                                        
                                                                    ?>
                                                                    
                                                                </li>
                                                                <?php } ?>
                                                                <li class="divider"></li>
                                                                <li class="dropdown-header">Operaciones de Credito</li>
                                                                <li <?php if($fila_credito[12]==2 || $fila_credito[12]==4){echo "class='disabled''"; } ?>><a href="finalizar-credito.php?id=<?php echo $id_credito; ?>">Finalizar Credito</a></li>
                                                                <?php
                                                                    if($fila_credito[12]==3){
                                                                        //Credito en Juridico
                                                                        echo "<li><a href='reactivar_credito.php?id=$id_credito'>Reactivar Credito</a></li>";

                                                                    }
                                                                    if($fila_credito[12]==1){
                                                                        //Credito Activo
                                                                        echo "<li><a href='credito-juridico.php?id=$id_credito&oper=add'>Mandar Credito a Juridico</a></li>";

                                                                    }
                                                                    if($fila_credito[12]==2){
                                                                        //Credito Finalizado
                                                                        echo "<li class='disabled'><a href='#'>Mandar Credito a Juridico</a></li>";

                                                                    }
                                                                ?>
                                                                <?php
                                                                    if($fila_credito[12]==4 || $_SESSION['level_user'] < 4){
                                                                        //No permite hacer uso de la funcion
                                                                        echo "<li class='disabled'><a href='#'>Vender Prestamo</a></li>";
                                                                    }else{
                                                                        //Permite eliminar
                                                                        echo "<li><a href='vender-credito.php?id=$id_credito'>Vender Prestamo</a></li>";
                                                                    }
                                                                ?>
                                                            </ul>
                                                        </div>
                                                        <?php
                                                            }
                                                        ?>
                                                        <?php
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="der">Numero de Credito:</td>
                                                    <td class="izq"><strong><?php echo $fila_credito[21]; ?></strong></td>
                                                    <td class="der">Capturado el:</td>
                                                    <td class="izq"><strong><?php $date = new DateTime($fila_credito[2]); echo date_format($date, 'd-m-Y g:i a');?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td class="der">Fecha de Alta (FA):</td>
                                                    <td class="izq"><strong>
                                                                <?php
                                                                    //se genera un nuevo camp para mostrar la fecha de alta como historica
                                                                    echo date("d/m/Y",strtotime($fila_credito[28]));
                                                                ?>
                                                                
                                                        
                                                        </strong></td>
                                                    <td class="der"></td>
                                                    <td class="der"></td>
                                                </tr>
                                                <tr>
                                                    
                                                    <td class="der">Fecha de Pago (FP):</td>
                                                    <td class="izq">
                                                        <strong>
                                                                <?php
                                                                    //la fecha de pago puede ser variable y modificada y con eso tambien cambiaria la vista de los pagos 
                                                                    echo date("d/m/Y",strtotime($fila_credito[4]));
                                                                ?>
                                                                <?php
                                                                    //Validar Permisos para modificar fecha 
                                                                    if($_SESSION['level_user'] > 3){
                                                                        echo '<a href="modificar_fecha_credito.php?id=',$id_credito,'" type="button" class="btn btn-info btn-xs">Modificar Fecha <i class="fa fa-lock"></i></a>';
                                                                    }else{
                                                                        echo '<a href="#" type="button" class="btn btn-info btn-xs" disabled>Modificar Fecha <i class="fa fa-lock"></i></a>';
                                                                    }
                                                                ?>
                                                        
                                                        </strong>
                                                        <?php
                                                            //Search other dates stored in same credit.
                                                            $conocer_fechas_existentes = "SELECT * FROM historfechcredmodif WHERE idCredito = $id_credito ORDER BY fechaHoraModificacion DESC;";
                                                            $iny_conocer_fechas_existentes = mysqli_query($mysqli,$conocer_fechas_existentes) or die(mysqli_error());

                                                            if(mysqli_num_rows($iny_conocer_fechas_existentes) > 0){
                                                                $cadena_fechas = "";
                                                                while ($fila_fechas = mysqli_fetch_array($iny_conocer_fechas_existentes)){
                                                                    $cadena_fechas = $cadena_fechas.$fila_fechas[3]."<br>";
                                                                }

                                                                ?>
                                                                <a href="#" data-html="true" title="Historial de Fechas" data-toggle="popover" data-trigger="hover" data-content="<?php echo $cadena_fechas; ?>">
                                                                        <span class='label label-warning'><i class="fa fa-exclamation-circle"></i> No es la fecha original</span>
                                                                </a>
                                                                <?php
                                                            }
                                                            ?>

																										</td>
                                                    <td class="der">Capturado por:</td>
                                                    <td class="izq"><strong>
                                                        <?php
                                                            $iny_usuario_captura = mysqli_query($mysqli,"select * from usuario where id_user='$fila_credito[3]';") or die(mysqli_error());
                                                            $fila_usuario_captura = mysqli_fetch_row($iny_usuario_captura);
                                                            echo $fila_usuario_captura[5]." ".$fila_usuario_captura[6];
                                                        ?>
                                                    </strong></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="der"></td>
                                                    <td class="izq"></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td class="der">Monto Total de Credito:</td>
                                                    <td><strong>$ <?php echo number_format(($fila_credito[5]),2); ?></strong></td>
                                                    <td class="der">Interes Mensual:</td>
                                                    <td><strong><?php echo $fila_credito[6]; ?> % </strong></td>
                                                </tr>
                                                <tr>
                                                    <td class="der">Pago de Intereses Mensual inicial:</td>
                                                    <td><strong>$ <?php echo number_format(($fila_credito[7]),2); ?></strong></td>
                                                    <td class="der">Interes Moratorio: </td>
                                                    <td><strong>
                                                        <?php
                                                            echo $fila_credito[22]."%";
                                                        ?>
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td class="der"> Monto Credito Anterior: <span class='badge'>AMPLIACIÓN</span></td>
                                                    <td><strong> 
                                                        <?php 
                                                            if($fila_credito[32] == "" || $fila_credito[32] == NULL || $fila_credito[32] == "0"){
                                                                echo "<span class='cursiva light small-text'>Sin informacion</span>";
                                                            }else{
                                                                echo "$ ".number_format(($fila_credito[32]),2); 
                                                            } 
                                                        ?>
                                                        </strong></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td class="der">Monto Credito Nuevo: <span class='badge'>AMPLIACIÓN</span></td>
                                                    <td><strong>
                                                        <?php 
                                                            if($fila_credito[33] == "" || $fila_credito[33] == NULL || $fila_credito[33] == "0"){
                                                                echo "<span class='cursiva light small-text'>Sin informacion</span>";
                                                            }else{
                                                                echo "$ ".number_format(($fila_credito[33]),2); 
                                                            } 
                                                        ?>
                                                        </strong></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
												<tr>
                                                    <td class="der"></td>
                                                    <td></td>
                                                    <td class="der">Poder:</td>
                                                    <td>
                                                        <?php
                                                            if($fila_credito[8] != "" && $fila_credito[9] != ""){
                                                                echo "<span class='label label-success'>Si</span> <a target='_blank' href='".$fila_credito[9]."'>".$fila_credito[8]." <i class='fa fa-external-link' aria-hidden='true'></i></a>";
                                                            }else{
                                                                echo "<span class='label label-default'>No se encontro ningun poder.</span><br>";
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="der">Comentario del Credito:</td>
                                                    <td>
                                                        <?php 
                                                            if($fila_credito[27] == ""){
                                                                echo "<span class='label label-default'>No se encontro ningun comentario</span>";
                                                            }else{
                                                                echo '<div class="alert alert-warning" role="alert">'.$fila_credito[27].'</div>'; 
                                                            }
                                                        ?>
                                                        </td>
                                                        <td class="der">Contrato:</td>
                                                    <td>
                                                        <?php
                                                            if($fila_credito[24] != "" && $fila_credito[25] != ""){
                                                                echo "<span class='label label-success'>Si</span> <a target='_blank' href='".$fila_credito[25]."'>".$fila_credito[24]." <i class='fa fa-external-link' aria-hidden='true'></i></a>";
                                                            }else{
                                                                echo "<span class='label label-default'>No se encontro ningun mutuo.</span><br>";
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="der">Credito Infonavit:</td>
                                                    <td >
                                                    <?php
                                                        if($fila_credito[30] == 1){
                                                            echo "<span class='label label-success'>SI</span>";
                                                        }else{
                                                            echo "<span class='label label-default'>NO</span><br>";
                                                        }
                                                    ?>
                                                    </td>
                                                    <td class="der" colspan="2"><!-- MODAL DIALOG -->
							                        <div class="widget">
                                                    <div class="widget-header">
							                            <h3><i class="fa fa-files-o"></i> Archivos Adicionales</h3>
                                                        <div class="btn-group widget-header-toolbar">
                                                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-upload"></i> Subir mas Archivos</button>
                                                        </div>
						                            </div>
								<div class="widget-content">
									<?php
                                        $conocer_archivos_adicionales = "SELECT * FROM archiv_adic_credito WHERE id_credito = $id_credito ORDER BY datetime DESC;";
                                        $iny_conocer_archivos_adicionales = mysqli_query($mysqli,$conocer_archivos_adicionales) or die(mysqli_error());

                                        if(mysqli_num_rows($iny_conocer_archivos_adicionales) > 0){
                                            echo '<table style="width:100%;">';
                                            while ($f_archivos_adicionales = mysqli_fetch_assoc($iny_conocer_archivos_adicionales)){
                                               
                                                echo '
                                                
                                                    <tr>
                                                        <td class="der tdfontmini">'.$f_archivos_adicionales["descripcion"].'</td>
                                                        <td class="tdfontmini"><a href="'.$f_archivos_adicionales["path"].'" target="_blank">'.$f_archivos_adicionales["nombreArchivo"].' <i class="fa fa-external-link" aria-hidden="true"></a></td>
                                                    </tr>
                                                
                                                ';

                                            }
                                            echo '</table>';
                                        }else{
                                            echo "<i>No hay archivos adicionales</i>";
                                        }
                                    ?>
									<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="modal-title" id="myModalLabel">Seleccionar Archivos Adicionales</h4>
												</div>
												<div class="modal-body">
                                                    <form action="carga_archivos_adicionales_credito.php" method="post" enctype="multipart/form-data">
                                                        <input class="form-control" type="text" name="descripcion" required placeholder="Descripcion"><br><br>
                                                        <input type="hidden" name="id-credito" value="<?php echo $id_credito; ?>">
                                                        <input type="file" id="myFile" name="archivo" required><br>
                                                        <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> Subir Archivo</button>
                                                    </form>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cerrar</button>
													
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- END MODAL DIALOG --></td>
                                                </tr>
                                                <tr>
                                                    <td class="der">Credito ISSEG:</td>
                                                    <td>
                                                        <?php
                                                            if($fila_credito[31] == 1){
                                                                echo "<span class='label label-success'>SI</span>";
                                                            }else{
                                                                echo "<span class='label label-default'>NO</span><br>";
                                                            }
                                                        ?>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr class="linea">
                                                    <td colspan="4" class="titulo">DATOS CLIENTE</td>
                                                </tr>
                                                    <?php
                                                        $conocer_cliente = "select * from clientes where id_clientes=".$fila_credito[1].";";
                                                        $iny_consultar_cliente = mysqli_query($mysqli,$conocer_cliente) or die (mysqli_error());
                                                        $fila_cliente = mysqli_fetch_row($iny_consultar_cliente);
                                                    ?>
                                                <tr>
                                                    <td class="der">Nombre: </td>
                                                    <td class="izq"><strong><a href="cliente-profile.php?id=<?php echo $fila_cliente[0]; ?>"><?php echo $fila_cliente[1]." ".$fila_cliente[2]." ".$fila_cliente[3]; 
                                                    categoriaClienteHTML($fila_cliente[16]);
                                                    ?></a></strong></td>
                                                    <td class="der">Direccion: </td>
                                                    <td><strong><?php echo $fila_cliente[4]; ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td class="der">Telefonos: </td>
                                                    <td><strong><?php echo $fila_cliente[5]; ?></strong></td>
                                                    <td class="der">Email: </td>
                                                    <td><strong><?php echo $fila_cliente[6]; ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td class="der">Fecha Nacimiento: </td>
                                                    <td><strong><?php echo date("d/m/Y",strtotime($fila_cliente[7])); ?></strong></td>
                                                    <td class="der">Domicilio Trabajo: </td>
                                                    <td><strong><?php echo $fila_cliente[12]; ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td class="der">Telefono Trabajo: </td>
                                                    <td><strong><?php echo $fila_cliente[13]; ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td class="der">Archivos: </td>
                                                    <td>
                                                        
                                                        Identificacion Oficial: <i>
                                                        <?php
                                                            if($fila_cliente[10] == "" || $fila_cliente[14] == ""){
                                                                 echo "<i>No existe archivo</i>";
                                                            }else{
                                                                echo "<a target='_blank' href='".$fila_cliente[10]."'>".$fila_cliente[14]." <i class='fa fa-external-link' aria-hidden='true'></i></a>";
                                                            }
                                                        ?>
                                                        </i>
                                                        <br>
                                                        Comprobante Domicilio: <i>
                                                        <?php
                                                            if($fila_cliente[11] == "" || $fila_cliente[15] == ""){
                                                                echo "<i>No existe archivo</i>";
                                                            }else{
                                                                echo "<a target='_blank' href='".$fila_cliente[11]."'>".$fila_cliente[15]." <i class='fa fa-external-link' aria-hidden='true'></i></a>";
                                                            }

                                                        ?>
                                                            </i>
                                                            
                                                    </td>
                                                    <td class="der">Historial de Creditos: </td>
                                                    <td>
                                                        <?php
                                                            $CONSULTA_SABER_CREDITOS = "select id_creditos,folio,fechadealta,monto, 
                                                            CASE status
                                                            WHEN 1 then 'ACTIVO'
                                                            WHEN 2 THEN 'FINALIZADO'
                                                            WHEN 3 THEN 'JURIDICO'
                                                            WHEN 4 THEN 'VENDIDO'
                                                            END AS status
                                                            from creditos where id_cliente='$fila_cliente[0]' AND id_creditos NOT IN (".$fila_credito[0].") order by fechadealta desc;";
                                                            $INY_CONSULTA_SABER_CREDITOS = mysqli_query($mysqli,$CONSULTA_SABER_CREDITOS) or die(mysqli_error());
                                                            if(mysqli_num_rows($INY_CONSULTA_SABER_CREDITOS) > 0){
                                                                echo "<table class='table table-striped'>";
                                                                while ($F_CONOCER_HISTORIAL_CREDITOS = mysqli_fetch_assoc($INY_CONSULTA_SABER_CREDITOS)){
                                                                    echo '
                                                                        <tr>
                                                                            <td class="der"><a href="detalle-credito.php?id='.$F_CONOCER_HISTORIAL_CREDITOS["id_creditos"].'">'.$F_CONOCER_HISTORIAL_CREDITOS["folio"].'</a></td>
                                                                            <td class="der">'.$F_CONOCER_HISTORIAL_CREDITOS["fechadealta"].'</td>
                                                                            <td class="der">$'.number_format(($F_CONOCER_HISTORIAL_CREDITOS["monto"]),2).'</td>
                                                                            <td class="der">'.$F_CONOCER_HISTORIAL_CREDITOS["status"].'</td>
                                                                        </tr>
                                                                    
                                                                    ';
                    
                                                                }
                                                                echo '</table>';
                                                            }else{
                                                                echo "<span class='label label-default'>Sin Creditos Anteriores</span>";
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                             </table>
                                        </div>
							        </div>
                            	</div>
						    </div>
                       		<!-- invoice footer -->
                            <?php
                                if($_SESSION['level_user'] == 4 || $_SESSION['level_user'] == 5){
                            ?>
                            <div class="invoice-footer">
                                <div class="row">


                                    <hr>
                                    <?php
                                        if($fila_credito[12] ==2 ){
                                            //Credito Finalizado

                                            if($fila_credito[14] == 1){
                                                $motivo = "Cliente Liquido el Credito.";
                                            }
                                            if($fila_credito[14] == 2){
                                                $motivo = "Hubo una equivocacion al momento de capturar.";
                                            }
                                            if($fila_credito[14] == 3){
                                                $motivo = "Renovacion";
                                            }
                                            if($fila_credito[14] == 4){
                                                $motivo = "Ampliación";
                                            }
                                    ?>
                                    <div class="col-sm-6 col-print-6 left-col">
                                            <blockquote class="invoice-notes">
                                                <strong>Notas de Credito Finalizado:</strong>
                                                <br><p><b>Motivo: </b><?php echo $motivo; ?><br>
                                                <br><b>Comentarios:</b><?php echo $fila_credito[15]; ?></p>
                                            </blockquote>
                                    </div>
                                    <?php
                                        }
                                    ?>
                                    <!-- En caso de estar en juridico o finalizado-->
                                </div>
						    </div>
                            <?php
                                }
                            ?>
                                <!-- end invoice footer -->
                                <!-- invoice action buttons -->
                                <!--<div class="invoice-buttons">
                                    <button class="btn btn-default print-btn"><i class="fa fa-print"></i> Print</button>
                                    <a href="#" class="btn btn-custom-primary"><i class="fa fa-arrow-right"></i> Proceed to Payment</a>
                                </div>-->
                                <!-- end invoice action buttons -->
					    </div>
					   <!-- INVOICE -->
				    </div>
                    <!--Inicio Documentacion Expediente -->
                    <?php if(validarAccesoModulos('permiso_ver_documentacion_expediente') == 3) { ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="widget">
                                <div class="widget-header">
                                    <h3><i class="fa fa-home"></i> Documentacion Expediente <a name="top"></a></h3>
                                    <div class="btn-group widget-header-toolbar">
                                    <?php if(validarAccesoModulos('permiso_agregar_inmuebles') == 1){ ?><button class="btn btn-active btn-sm" data-toggle="modal" data-target="#myModalInmueble"><i class="fa fa-plus"></i> Nuevo Inmueble</button><?php } //Fin Permiso Avales?>
                                        <a href="#" title="Focus" class="btn-borderless btn-focus"><i class="fa fa-eye"></i></a>
                                        <a href="#" title="Expand/Collapse" class="btn-borderless btn-toggle-expand"><i class="fa fa-chevron-up"></i></a>
                                    </div>
                                </div>
                                <div class="widget-content">
                                    <div class="row">
                                        <div class="col-sm-12">
										    <table class="table table-bordered table-sm">
                                                <thead><th>Status</th><th>Documento</th><th>Notario</th><th>Archivo</th><th>Inversionista</th><th>Inscrita RPP</th></thead>
                                                <tbody>
                                                    <tr>
                                                        <td><span class="badge"><i class="fa fa-close"></i></span></td>
                                                        <td><strong>Mutuo</strong></td>
                                                        <td><span class="label label-default">No se encontro ningun mutuo.</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="badge element-bg-color-green"><i class="fa fa-check"></i></span></td>
                                                        <td><strong>Reconocimiento</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="badge element-bg-color-green"><i class="fa fa-check"></i></span></td>
                                                        <td>Ratificacion de Pago </td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="badge element-bg-color-green"><i class="fa fa-check"></i></span></td>
                                                        <td>Dacion</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="badge element-bg-color-green"><i class="fa fa-check"></i></span></td>
                                                        <td>Compra Venta</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="badge element-bg-color-green"><i class="fa fa-check"></i></span></td>
                                                        <td>Poder</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="badge element-bg-color-green"><i class="fa fa-check"></i></span></td>
                                                        <td>Renovacion</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="badge element-bg-color-green"><i class="fa fa-check"></i></span></td>
                                                        <td>2do Credito</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="badge element-bg-color-green"><i class="fa fa-check"></i></span></td>
                                                        <td>Cancelacion</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="badge element-bg-color-green"><i class="fa fa-check"></i></span></td>
                                                        <td>Cancelacion</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="badge element-bg-color-green"><i class="fa fa-check"></i></span></td>
                                                        <td>Cancelacion</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                     <!--FIN DOCUMENTACION EXPEDIENTE-->
                     <?php } ?>
                    <div class="row">
                        <div class="col-md-9">
                            <!--Inicio INFORMACION DE JURIDICO-->
                            <?php
                                if($_SESSION['level_user'] == 4 || $_SESSION['level_user'] == 5){
                            ?>
                            <div class="widget">
                                <div class="widget-header">
                                    <h3><i class="fa fa-group"></i> Informacion Juridico</h3> <em> - historial de operaciones en juridico</em>
                                    <div class="btn-group widget-header-toolbar">
                                       
                                        <a href="#" title="Focus" class="btn-borderless btn-focus"><i class="fa fa-eye"></i></a>
                                        <a href="#" title="Expand/Collapse" class="btn-borderless btn-toggle-expand"><i class="fa fa-chevron-up"></i></a>
                                    </div>
                                </div>
                                <div class="widget-content">
                                    <?php
                                        $conocer_info_juridico = "SELECT id_juridicos,id_credito,fecha_registro, usuario.nombre, usuario.apellidos, juzgado, expediente, etapaprocesal, convenios_path, convenios_file_name, comentarios, fechareactivacion  FROM juridicos INNER JOIN usuario ON juridicos.usuario_registro = usuario.id_user WHERE id_credito='$id_credito' and juzgado <> '' ORDER BY fecha_registro DESC;";
                                        $iny_conocer_info_juridico = mysqli_query($mysqli,$conocer_info_juridico) or die(mysqli_error());
                                        if(mysqli_num_rows($iny_conocer_info_juridico) > 0){
                                          
                                            echo "<span class='label label-warning'>Actividad registrada en juridico, favor de validar. (Inicial)</span><br><br>";
                                    ?>

                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Fecha de Movimiento</th>
                                                    <th>Usuario Movimiento</th>
                                                    <th>Juzgado</th>
                                                    <th>Expediente</th>
                                                    <th>Etapa Procesal</th>
                                                    <th>Convenios</th>
                                                    <th>Comentarios</th>
                                                    <th>Fecha Reactivacion</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                while($row_juridico = mysqli_fetch_array($iny_conocer_info_juridico)){
                                            ?>
                                                        

                                                <tr>
                                                    <td width='5%'><?php echo $row_juridico[2]; ?></td>
                                                    <td width='10%'><?php echo $row_juridico[3]." ".$row_juridico[4]; ?></td>
                                                    <td width='10%'><?php echo $row_juridico[5]; ?></td>
                                                    <td width='10%'><?php echo $row_juridico[6]; ?></td>
                                                    <td width='5%'><?php echo $row_juridico[7]; ?></td>
                                                    <td width='15%'>
                                                        <?php
                                                            if($row_juridico[9] !=""){
                                                                echo "<a href='$row_juridico[8]'>$row_juridico[9] <i class='fa fa-external-link' aria-hidden='true'></i></a>";
                                                            }else{
                                                                echo "<i>Aun no se ha registrado ningun convenio</i>";
                                                            }
                                                        ?>
                                                    </td>
                                                    <td width='15%'><?php echo $row_juridico[10]; ?></td>
                                                    <td width='15%'><?php echo $row_juridico[11]; ?></td>
                                                    <td width='5%'><a href='credito-juridico.php?id=<?php echo $id_credito ?>&juridico=<?php echo $row_juridico[0]; ?>&oper=edit' type='button' class='btn btn-warning btn-xs'>Editar</a></td>
                                                </tr>
                                                <?php
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                               
                                    <?php
                                        }else{
                                            echo "<span class='label label-success'>No hay actividad registrada en juridico. (Inicial)</span><br>";
                                        }
        
                                    ?>
	                                
                                        
                                </div>
                            </div>
                            <?php
                                } 
                                //Vaidacion de solamente niveles puedan ver este modulo
                            ?>
                            <!--FIN avales-->
                        </div>
                    
                        <div class="col-md-3">
                            <!--Inicio otra informacion-->
                            <div class="widget">
                                <div class="widget-header">
                                    <h3><i class="fa fa-home"></i> + Info</h3>
                                    
                                    <div class="btn-group widget-header-toolbar">
                                        <a href="#" title="Expand/Collapse" class="btn-borderless"><i class="fa fa-edit">Editar</i></a>
                                        <a href="#" title="Focus" class="btn-borderless btn-focus"><i class="fa fa-eye"></i></a>
                                        <a href="#" title="Expand/Collapse" class="btn-borderless btn-toggle-expand"><i class="fa fa-chevron-up"></i></a>
                                    </div>
                                </div>
                                <div class="widget-content">
                                    <div class="row">
                                        <div class="col-sm-12">
										    
											    Asesor:
											    
                                                    <?php 
                                                            if($fila_credito[26] == "" || $fila_credito[26] == NULL){
                                                                echo "<span class='label label-default'>NA</span>";
                                                            }else{
                                                                echo "<span class='label label-primary'>".$fila_credito[26]."</span>"; 
                                                            }
                                                
                                                    ?>
                                                
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--FIN inmubles-->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <!--Inicio avales-->
                            <div class="widget">
                                <div class="widget-header">
                                    <h3><i class="fa fa-group"></i> Avales</h3> <em> - Lista de Avales que representan el credito</em>

                                    <div class="btn-group widget-header-toolbar">
                                        <?php if(validarAccesoModulos('permiso_crear_avales') == 1){ ?><a href="nuevo-aval.php?idCr=<?php echo $fila_credito[0]; ?>&idCl=<?php echo $fila_credito[1]; ?>" title="Expand/Collapse" class="btn-borderless"><i class="fa fa-plus"> Nuevo Aval</i></a><?php } //Fin Permiso Avales?>
                                        <a href="#" title="Focus" class="btn-borderless btn-focus"><i class="fa fa-eye"></i></a>
                                        <a href="#" title="Expand/Collapse" class="btn-borderless btn-toggle-expand"><i class="fa fa-chevron-up"></i></a>

                                    </div>
                                </div>
                                <div class="widget-content">
                                    <?php
                                        $conocer_avales = "SELECT * FROM avales where id_credito='$id_credito';";
                                        $iny_conocer_avales = mysqli_query($mysqli,$conocer_avales) or die(mysqli_error());
                                    ?>
	                                <table class="table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Nombre</th>
                                                <th>Parentesco</th>
                                                <th>Telefonos</th>
                                                <th>Archivos</th>
                                                <th>Operacion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if(mysqli_num_rows($iny_conocer_avales) > 0){
                                                    $contador_avales = 1;
                                                  while($fila_avales = mysqli_fetch_array($iny_conocer_avales)){
                                                    echo "
                                                        <tr>
                                                            <td width='5%'></td>
                                                            <td width='25%'>$fila_avales[2]</td>
                                                            <td width='5%''>$fila_avales[3]</td>
                                                            <td width='20%'>$fila_avales[4]</td>
                                                            <td width='45%'>";
															
															if($fila_avales[6] != "" && $fila_avales[6] != ""){
                                                                echo "Identificacion Oficial: <i><a target='_blank' href='$fila_avales[6]'>$fila_avales[5]<i class='fa fa-external-link' aria-hidden='true'></i></a></i><br>";
                                                            }else{
                                                                echo "Identificacion Oficial: <span class='label label-default'>No se encontro ninguna Identificacion Oficial.</span><br>";
                                                            }
                                                            if($fila_avales[8] != "" && $fila_avales[7] != ""){
                                                                echo "Comprobante Domicilio: <i><a target='_blank' href='$fila_avales[8]'>$fila_avales[7] <i class='fa fa-external-link' aria-hidden='true'></i></a></i><br>	";
                                                            }else{
                                                                echo "Comprobante Domicilio: <span class='label label-default'>No se encontro ningun Comprobante de Domicilio.</span><br>";
                                                            }

                                                    			echo "</td>
                                                            <td>";
                                                            if(validarAccesoModulos('permiso_editar_avales') == 1){
                                                                echo "<a href='editar_aval.php?idCr=".$fila_avales[1]."&idAv=".$fila_avales[0]."'>Editar</a> ";
                                                            }
                                                            if(validarAccesoModulos('permiso_eliminar_avales') == 1){ 
                                                                echo "<a href='eliminar_aval.php?id=".$fila_avales[0]."'>Eliminar</a>";
                                                            }
                                                            echo "</td>
                                                        </tr>
                                                    ";
                                                      $contador_avales++;
                                                  }
                                                }
                                            ?>


                                            <tr>
                                            <td colspan="5"></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--FIN avales-->
                        </div>
                    
                        <div class="col-md-5">
                            <!--Inicio inmubles-->
                            <div class="widget">
                                <div class="widget-header">
                                    <h3><i class="fa fa-home"></i> Inmuebles</h3>

                                    <div class="btn-group widget-header-toolbar">
                                    <?php if(validarAccesoModulos('permiso_agregar_inmuebles') == 1){ ?><button class="btn btn-active btn-sm" data-toggle="modal" data-target="#myModalInmueble"><i class="fa fa-plus"></i> Nuevo Inmueble</button><?php } //Fin Permiso Avales?>
                                        <a href="#" title="Focus" class="btn-borderless btn-focus"><i class="fa fa-eye"></i></a>
                                        <a href="#" title="Expand/Collapse" class="btn-borderless btn-toggle-expand"><i class="fa fa-chevron-up"></i></a>
                                    </div>
                                </div>
                                <div class="widget-content">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Folio Real</th>
                                                <th>Comentarios</th>
                                                <th>Archivos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $conocer_inmuebles = "select * from inmuebles where id_credito=".$fila_credito[0].";";
                                                $iny_consultar_inmuebles = mysqli_query($mysqli,$conocer_inmuebles) or die (mysqli_error());
                                                if(mysqli_num_rows($iny_consultar_inmuebles) > 0){
                                                  while($fila_inmuebles = mysqli_fetch_array($iny_consultar_inmuebles)){
                                                    echo "<tr>
                                                            <td>
                                                                <strong>$fila_inmuebles[3]</strong>
                                                            </td>
                                                            <td>
                                                                <strong>$fila_inmuebles[4]</strong>
                                                            </td>
                                                            <td>";
                                                                if($fila_inmuebles[5] !=""){
                                                                    echo "<a target='_blank' href='$fila_inmuebles[6]'>$fila_inmuebles[5] <i class='fa fa-external-link' aria-hidden='true'></i></a>";
                                                                }
                                                                if($fila_inmuebles[7] !=""){
                                                                    echo "<br><a href='$fila_inmuebles[8]'>$fila_inmuebles[7] <i class='fa fa-external-link' aria-hidden='true'></i></a>";
                                                                }
                                                                if($fila_inmuebles[9] !=""){
                                                                    echo "<br><a href='$fila_inmuebles[10]'>$fila_inmuebles[9] <i class='fa fa-external-link' aria-hidden='true'></i></a>";
                                                                }
                                                                if($fila_inmuebles[11] !=""){
                                                                    echo "<br><a href='$fila_inmuebles[12]'>$fila_inmuebles[11] <i class='fa fa-external-link' aria-hidden='true'></i></a>";
                                                                }
                                                                if($fila_inmuebles[13] !=""){
                                                                    echo "<br><a href='$fila_inmuebles[14]'>$fila_inmuebles[13] <i class='fa fa-external-link' aria-hidden='true'></i></a>";
                                                                }
                                                                if($fila_inmuebles[15] !=""){
                                                                    echo "<br><a href='$fila_inmuebles[16]'>$fila_inmuebles[15] <i class='fa fa-external-link' aria-hidden='true'></i></a>";
                                                                }
                                                                if($fila_inmuebles[17] !=""){
                                                                    echo "<br><a href='$fila_inmuebles[18]'>$fila_inmuebles[17] <i class='fa fa-external-link' aria-hidden='true'></i></a>";
                                                                }
                                                                if($fila_inmuebles[19] !=""){
                                                                    echo "<br><a href='$fila_inmuebles[20]'>$fila_inmuebles[19] <i class='fa fa-external-link' aria-hidden='true'></i></a>";
                                                                }
                                                                if($fila_inmuebles[21] !=""){
                                                                    echo "<br><a href='$fila_inmuebles[22]'>$fila_inmuebles[21] <i class='fa fa-external-link' aria-hidden='true'></i></a>";
                                                                }
                                                                if($fila_inmuebles[23] !=""){
                                                                    echo "<br><a href='$fila_inmuebles[24]'>$fila_inmuebles[23] <i class='fa fa-external-link' aria-hidden='true'></i></a>";
                                                                }
                                                            echo "</td>
                                                        </tr>";
                                                    }
                                                }
                                            ?>
                                            <div class="modal fade" id="myModalInmueble" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="modal-title" id="myModalLabel">Ingresar Informacion Adicional del Inmueble</h4>
												</div>
												<div class="modal-body">
                                                    <form action="_carga_adicionales_inmuebles.php" method="post" enctype="multipart/form-data">
                                                        <input class="form-control" type="text" name="folio-real" required placeholder="Folio Real"><br>
                                                        <textarea class="form-control" name="comentarios" id="" cols="20" rows="3" placeholder="Comentarios"></textarea><br><br>
                                                        <input type="hidden" name="id-credito" value="<?php echo $id_credito; ?>">
                                                        <input type="hidden" name="id-cliente" value="<?php echo $fila_cliente[0]; ?>">
                                                        <input type="file" id="myFile" name="archivo"><br>
                                                        <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> Guardar Informacion</button>
                                                    </form>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cerrar</button>
													
												</div>
											</div>
										</div>
									</div>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--FIN inmubles-->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <!--Inicio pagos-->
                            <div class="widget">
                                <div class="widget-header">
                                    <h3><i class="fa fa-credit-card"></i> Pagos</h3> <em> - lista de pagos que el cliente ha realizado</em>

                                    <div class="btn-group widget-header-toolbar">
                                        <a href="#" title="Expand/Collapse" class="btn-borderless"><i class="fa fa-edit">Editar</i></a>
                                        <a href="#" title="Focus" class="btn-borderless btn-focus"><i class="fa fa-eye"></i></a>
                                        <a href="#" title="Expand/Collapse" class="btn-borderless btn-toggle-expand"><i class="fa fa-chevron-up"></i></a>

                                    </div>
                                </div>
                                <div class="widget-content">
                                    <!-- invoice item table -->
        				            <div class="table-responsive">
        				                <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Fecha de Pago</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    //Conocer Meses transcurridos
                                                    $para_convertir_a_php = strtotime( $fila_credito[4] );
                                                    $fecha_a_partir_init = date( 'Y-m-01', $para_convertir_a_php );
                                                    $fecha_inicial = new DateTime($fecha_a_partir_init);
                                                    //$fecha_inicial= new DateTime($fila_credito[4]);
                                                    $mes_current = date("m");
                                                    $ano_current = date("Y");
                                                    $dia_ultimo_actual = date("d",(mktime(0,0,0,$mes_current+1,1,$ano_current)-1));
                                                    $fecha_actual = $ano_current."-".$mes_current."-".$dia_ultimo_actual;
                                                    $fecha_final= new DateTime($fecha_actual);
                                                    $fecha_inicial->format('Y-m-d');
                                                    $fecha_final->format('Y-m-d');
                                                    $unMes= new DateInterval("P1M");
                                                    while($fecha_inicial<=$fecha_final)
                                                    {
                                                        echo "<tr><td style='vertical-align:middle;'><center><strong>";
                                                        $formateoFecha = $fecha_inicial->format('Y-m-d');
                                                        echo date('F Y',strtotime($formateoFecha));

                                                        echo "</strong></center></td>";
                                                        $mes = $fecha_inicial->format('m');
                                                        $ano = $fecha_inicial->format('Y');
                                                        $fecha_completa = $fecha_inicial->format('d/m/Y');
                                                        $conocer_pago_mes = "select * from pagos where year(fecha_pago)='".$ano."' and month(fecha_pago)='".$mes."' and id_credito='".$fila_credito[0]."';";
                                                        $iny_conocer_pago_mes = mysqli_query($mysqli,$conocer_pago_mes) or die(mysqli_error());

                                                        if(mysqli_num_rows($iny_conocer_pago_mes)>0){
                                                            echo "<td><table class='table'>";
                                                           while($fila = mysqli_fetch_array($iny_conocer_pago_mes)){
                                                               echo "<tr>";
                                                               echo "<td><span class='badge'>Folio: $fila[8]</span></td>";
                                                               if($fila[6] == 1){
                                                                     echo "<td><span class='label label-success'>Pago de Intereses</span></td>";
                                                                 }
                                                                if($fila[6] == 2){
                                                                     echo "<td><span class='label label-primary'>Pago a Capital</span></td>";
                                                                 }
                                                                 if($fila[6] == 3){
                                                                     echo "<td><span class='label label-info'>Pago de Adeudos</span></td>";
                                                                 }
                                                                 if($fila[6] == 4){
                                                                    echo "<td><span class='label label-warning'>Pago de In. Moratorios</span></td>";
                                                                }
                                                                echo "<td>";
                                                               $date = new DateTime($fila[2]);
                                                                echo date_format($date, 'd/m/Y g:i a');
                                                                echo "</td><td>$".number_format(($fila[5]),2)."</td>";

                                                                echo "<td>".$fila[7]."</td>";
                                                                echo "</tr>";
                                                                //Conocer Si hay adeudo
                                                                $AdeudExisPago = "SELECT * FROM adeudos where folio_fisico='$fila[8]';";
                                                                $iny_AdeudExisPago = mysqli_query($mysqli,$AdeudExisPago) or die(mysqli_error());
                                                                if(mysqli_num_rows($iny_AdeudExisPago) > 0){
                                                                    $f_AdeudExisPago = mysqli_fetch_row($iny_AdeudExisPago);
                                                                    echo "<tr><td></td><td colspan='2'><span class='label label-warning'>Se capturo un adeudo debido a pago incompleto.</span></td><td>$".number_format(($f_AdeudExisPago[2]),2)."</td><td></td></tr>";

                                                                }
                                                            }
                                                            echo "</table></td>";
                                                        }else{
                                                            $mes_actual = date("m");
                                                            $anio_actual = date("Y");
                                                                $fecha_actual = date("Y-m-d");
                                                            //if($mes == ){

                                                            //}

                                                            echo "<td class='danger'><i>No hay pagos registrados</i></td>";
                                                        }
                                                        $fecha_inicial->add($unMes);
                                                        echo "</tr>";
                                                    }
                                                ?>
                                            </tbody>
        							     </table>
        				            </div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <table class="table table-bordered">
                                                <tr><th><center>Saldo Adeudos</center></th></tr>
                                                <?php
                                                        //Consultar Adeudos
                                                        $conocer_adeudos_cargos = "select COALESCE(sum(monto),0) as total_cargos from adeudos WHERE tipo='cargo' and id_credito='".$fila_credito[0]."';";
                                                        $iny_conocer_adeudos_cargos = mysqli_query($mysqli,$conocer_adeudos_cargos) or die(mysqli_error());
                                                        $fConocerAdeudosCargos = mysqli_fetch_row($iny_conocer_adeudos_cargos);

                                                        $conocer_adeudos_abonos = "select COALESCE(sum(monto),0) as total_abonos from pagos WHERE tipo_pago='3' and id_credito='".$fila_credito[0]."';";
                                                        $iny_conocer_adeudos_abonos = mysqli_query($mysqli,$conocer_adeudos_abonos) or die(mysqli_error());
                                                        $fConocerAdeudosAbonos = mysqli_fetch_row($iny_conocer_adeudos_abonos);

                                                        $totalSaldoAdeudos = $fConocerAdeudosCargos[0] - $fConocerAdeudosAbonos[0];

                                                    ?>
                                            <tr><td><center><?php echo "$ ".number_format(($totalSaldoAdeudos),2); ?></center></td></tr>
                                            </table>
                                            <table class="table table-bordered">
                                                <tr><th><center>Total Pagos de Interes</center></th></tr>
                                                <?php
                                                        $iny_conocer_intereses = mysqli_query($mysqli,"select sum(monto) as intereses from pagos where id_credito='".$fila_credito[0]."' and tipo_pago=1;")or die(mysqli_error());
                                                        if(mysqli_num_rows($iny_conocer_intereses)>0){
                                                             $fila_intereses = mysqli_fetch_row($iny_conocer_intereses);
                                                        }
                                                    ?>
                                            <tr><td><center><?php echo "$ ".number_format(($fila_intereses[0]),2); ?></center></td></tr>
                                            </table>
                                        </div>
                                        <div class="col-xs-6">
                                            <?php
                                                $iny_conocer_capital = mysqli_query($mysqli,"select sum(monto) as pagos_capital from pagos where id_credito='".$fila_credito[0]."' and tipo_pago=2;")or die(mysqli_error());
                                                if(mysqli_num_rows($iny_conocer_capital)>0){
                                                     $fila_capital = mysqli_fetch_row($iny_conocer_capital);
                                                        if($fila_capital[0] == ""){
                                                            $suma_capital = 0;
                                                        }else{
                                                            $suma_capital = $fila_capital[0];
                                                        }
                                                }
                                            ?>
                                            <table class="table table-bordered">
                                                <tr><td>Total Credito</td><td> $ <?php echo number_format(($fila_credito[5]),2); ?></td></tr>
                                                <tr><td>Total Pagos a Capital</td><td> $ <?php echo number_format(($suma_capital),2); ?></td></tr>
                                                <tr><td>Total Restante</td><td>$ <?php echo number_format(($fila_credito[5]-$suma_capital),2);?></td></tr>
                                            </table>
                                        </div>
                                    </div>
                                    <?php
                                        if($_SESSION['level_user'] == 4 || $_SESSION['level_user'] == 5){
                                    ?>
                                    <div class="row">
                                            <div class="col-xs-12">
                                                <legend>Pagos al SAT</legend>
                                            </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="panel panel-default">
                                              <div class="panel-body">

                                                    <div class="text-right">
                                                        <!--<a href="#" class="cart-box btn btn-warning btn-xs">
                                                            <i class="fa fa-refresh"></i> Actualizar Lista
                                                        </a>-->
                                                        <a href="nuevo-pago-sat.php?id=<?php echo $id_credito; ?>" class="btn btn-success btn-xs">
                                                        <i class="fa fa-plus"></i> Agregar Pagos al SAT</a>
                                                    </div>
                                                    <br>
                                                    <div class="shopping-cart-box">
                                                        <div id="shopping-cart-results">
                                                            <?php
                                                                $conocer_pagos_sat = "select * from pagos_sat where id_credito=$id_credito;";
                                                                $iny_conocer_pagos_sat = mysqli_query($mysqli,$conocer_pagos_sat) or die(mysqli_error());
                                                                if(mysqli_num_rows($iny_conocer_pagos_sat)>0){
                                                                    echo '<table class="table table-bordered table-condensed">
                                                                            <thead>
                                                                               <th>No.</th>
                                                                               <th>Fecha</th>
                                                                               <th>Monto</th>
                                                                                <th></th>
                                                                            </thead><tbody>';
                                                                            $contador =1;
                                                                            $sumapagossat = 0;
                                                                    while($fpagosat = mysqli_fetch_array($iny_conocer_pagos_sat)){
                                                                        echo "<tr><th scope='row'>$contador</th><td>".date("d/m/Y",strtotime($fpagosat[3]))."</td><td>$".number_format(($fpagosat[2]),2)."</td><td><a href='eliminar-pago-sat.php?idsat=$fpagosat[0]' type='button' class='btn btn-warning btn-xs'>Eliminar</a></td></tr>";
                                                                        $sumapagossat += $fpagosat[2];
                                                                        $contador++;
                                                                    }
                                                                    echo "</tbody>
                                                                        </table>";
                                                                    ?>
                                                                        <div class="row">
                                                                            <div class="col-xs-4 col-xs-offset-8">
                                                                                <table class='table table-bordered table-condensed'>
                                                                                    <tr><td><strong>Total Pagos SAT</strong></td><td>$<?php echo number_format(($sumapagossat),2); ?></td></tr>
                                                                                    <?php
                                                                                        $saldoSAT = $fila_credito[5]-$sumapagossat;
                                                                                        if($saldoSAT <= 0){
                                                                                            $statusSaldoSAT = "success";
                                                                                        }else{
                                                                                            $statusSaldoSAT = "danger";
                                                                                        }
                                                                                    ?>
                                                                                    <tr class="<?php echo $statusSaldoSAT; ?>"><td><strong>Saldo SAT</strong></td><td>$<?php echo number_format(($saldoSAT),2); ?></td></tr>
                                                                                    <tr><td colspan="2"><center>
                                                                                        <?php
                                                                                            if($statusSaldoSAT == "success"){
                                                                                                echo "<span class='label label-success'>Pagos Completos</span>";
                                                                                            }
                                                                                            if($statusSaldoSAT == "danger"){
                                                                                                echo "<span class='label label-success'>Pagos Pendientes</span>";
                                                                                            }

                                                                                        ?>

                                                                                        </center></td>
                                                                                    </tr>
                                                                            </table>
                                                                            </div>
                                                                        </div>
                                                                    <?php
                                                                }else{
                                                                    echo "<div class='alert alert-warning'>
                                                            <strong>Sin Informacion.</strong> No hay pagos registrados al SAT
                                                        </div>";
                                                                }
                                                            ?>

                                                            </table>
                                                        </div>
                                                    </div>

                                              </div>
                                            </div>

                                        </div>
                                    </div>
                                    <?php
                                        }
                                    ?>



                                    <!-- end invoice item table -->
                                </div>
                            </div>
                            <!--FIN pagos-->
                        </div>
                    </div>
                    <?php
                        if($_SESSION['level_user'] == 4 || $_SESSION['level_user'] == 5 || validarAccesoModulos('permiso_ver_inversionista_credito') == 1){
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <!--Inicio inversionistas-->
                            <div class="widget">
                                <div class="widget-header">
                                    <h3><i class="fa fa-briefcase"></i> Inversionistas</h3> <em> - inversionistas y detalle de pagos</em>

                                    <div class="btn-group widget-header-toolbar">
                                        <?php if(validarAccesoModulos("permiso_inversionistas_cambiar_credito") == 1){ ?>
                                        <!--<a disabled="disabled" href="editar_inversionista_credito.php?id=<?php //echo $fila_credito[0]; ?>" title="Editar Informacion" class="btn-borderless"><i class="fa fa-edit">Editar</i></a>-->
                                        <a href="#" title="Focus" class="btn-borderless btn-focus"><i class="fa fa-eye"></i></a>
                                        <a href="#" title="Expand/Collapse" class="btn-borderless btn-toggle-expand"><i class="fa fa-chevron-up"></i></a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="widget-content">
                                     <div class="row">
                                        <div class="col-xs-6">
                                            <!-- Nueva Tabla Inversionisias -->
                                            <table class="table table-bordered table-condensed">
                                                <thead><th colspan="8"><center>Inversionistas Asignados<center></th></thead>
                                                <tbody>
                                                    <tr><td class='tdfontmini'><center><b>Inversionista</b></center></td>
                                                    <td class='tdfontmini'><center><b>Monto</b></center></td>
                                                    <td class='tdfontmini'><center><b>Interes a Pagar Inversionista</b></center></td>
                                                    <td class='tdfontmini'><center><b>Comentarios</b></center></td>
                                                    <td class='tdfontmini'><center><b>Fecha Registro</b></center></td>
                                                    <td class='tdfontmini'><center><b>Total Pagos Inversionista</b></center></td>
                                                    <td class='tdfontmini'><center><b>Saldo Inversionista</b></center></td>
                                                    <td class='tdfontmini'><center><b>Oper</b></center></td></tr>
                                                    <?php
                                                        $conocerInversionistas = "select id_inversionistas_creditos,inversionistas_creditos.id_inversionista,nombre as nombreinversionista,monto,interes,inversionistas_creditos.comentarios,inversionistas_creditos.fecha_registro from inversionistas_creditos
                                                        INNER JOIN inversionistas on inversionistas.id_inversionistas = inversionistas_creditos.id_inversionista where inversionistas_creditos.id_credito=".$fila_credito[0].";";
                                                        $iny_ConocerInversionistas = mysqli_query($mysqli,$conocerInversionistas) or die ('Unable to execute query. '. mysqli_error($mysqli));
                                                        $cantidadcouenta = mysqli_num_rows($iny_ConocerInversionistas);
                                                        
                                                        if($cantidadcouenta>0){
                                                            $acumulado = 0;
                                                            while($f_Inversionistas = mysqli_fetch_assoc($iny_ConocerInversionistas)){
                                                                
                                                                //$conocer_NombreInv = mysqli_query($mysqli,"SELECT nombre from inversionistas where id_inversionistas=$f_InverAnt[1]") or die(mysqli_error());
                                                                //$f_NombreInv = mysqli_fetch_row($conocer_NombreInv);
                                                                
                                                                //Conocer Saldo Inversionista de Pagos realizados
                                                                $ConEstCredInv = mysqli_query($mysqli,"select sum(monto) from pinversionistas where id_credito=$id_credito and id_inversionista = ".$f_Inversionistas['id_inversionista']." and tipo_pago='capital';")or die(mysqli_error());
                                                                $f_ConEstCredInv = mysqli_fetch_row($ConEstCredInv);
                                                                if(empty($f_ConEstCredInv[0])){
                                                                    $pagos = 0;
                                                                }else{
                                                                   $pagos = $f_ConEstCredInv[0];
                                                                }
                                                                $saldo = $f_Inversionistas['monto']-$f_ConEstCredInv[0];
                                                                
                                                                if($saldo <= 0){
                                                                    $statusSaldo = "success";
                                                                }else{
                                                                    $statusSaldo = "danger";
                                                                }
                                                                //Permisos de Visualizacion
                                                                if($_SESSION['level_user'] == 4 || $_SESSION['level_user'] == 5 || validarAccesoModulos('permiso_ver_inversionista_credito') == 1){ 
                                                                    if($_SESSION['level_user'] == 3 || $_SESSION['level_user'] == 4 || $_SESSION['level_user'] == 5){ 
                                                                        echo "<tr>
                                                                        <td class='tdfontmini'>".$f_Inversionistas['nombreinversionista']."</td>";
                                                                        $acumulado = $acumulado + $f_Inversionistas['monto'];
                                                                        echo "<td class='tdfontmini'>$ ".number_format($f_Inversionistas['monto'],2)."</td>
                                                                        <td class='tdfontmini'>".$f_Inversionistas['interes']." % </td>
                                                                        <td class='tdfontmini'>".$f_Inversionistas['comentarios']."</td>
                                                                        <td class='tdfontmini'>".$f_Inversionistas['fecha_registro']."</td>
                                                                        <td class='tdfontmini'>$".number_format(($pagos),2)."</td>
                                                                        <td class='tdfontmini ".$statusSaldo."'>$".number_format(($saldo),2)." ";
                                                                        if($statusSaldo == "success"){
                                                                            echo "<span class='label label-success'>Credito Liquidado</span>";
                                                                        }
                                                                        if($statusSaldo == "danger"){
                                                                            echo "<span class='label label-warning'>Credito pendiente</span>";
                                                                        }
                                                                        echo "</td>";
                                                                        echo "<td class='tdfontmini'><a href='editar_inversionista_credito.php?id=".$fila_credito[0]."&incr=".$f_Inversionistas['id_inversionistas_creditos']."'>Editar</a></td>";
                                                                        echo "</tr>";
                                                                    }
                                                                }
                                                            }
                                                            echo "<tfoot>
                                                                    <tr>
                                                                        <td class='tdfontmini'><b>Sumatoria</b></td>
                                                                        <td class='tdfontmini'><b>$".number_format($acumulado,2)."</b></td>";
                                                                        if($acumulado == $fila_credito[5]){
                                                                            echo "<td class='tdfontmini-warning' colspan='6'>Sin posibilidad de agregar mas inversionistas, credito completo</td>";
                                                                        }
                                                                        if($acumulado > $fila_credito[5]){
                                                                            echo "<td class='tdfontmini-danger' colspan='6'>Los montos asignados a los inversionistas exceden el monto total del credito, verificar.</td>";
                                                                        }
                                                                        if($acumulado < $fila_credito[5]){
                                                                            echo "<td class='tdfontmini-green' colspan='6'>Monto aun disponible para asignar a inversionista</td>";
                                                                        }
                                                                        echo "</tr></tfoot>";
                                                        }else{
                                                            echo "<tr class='warning' ><td colspan='3'><center><i class='fa fa-info-circle' aria-hidden='true'></i> No existen Inversionistas Anteriores</center></td></tr>";
                                                        }
                                                    ?>
                                                </tbody>
                                           </table>
                                            
                                            
                                            
                                            
                                            
                                                <!-- Fin de Validacion de Comentarios-->
                                                <!-- Inicio de Validacion de Notas -->
                                            <?php  if($_SESSION['level_user'] == 3 || $_SESSION['level_user'] == 4 || $_SESSION['level_user'] == 5){ ?>
                                            <blockquote class="invoice-notes">
                                                <strong>Notas:</strong>
                                                <p><?php echo $fila_credito[14]; ?></p>
                                            </blockquote>
                                            <?php } ?>
                                                <!-- Fin de Validacion de Comentarios-->
                                        </div>
                                        <?php if(validarAccesoModulos('permiso_ver_detalle_credito_info_adicional_inversionista') == 1){ ?>
                                        <div class="col-xs-6">
                                           <table class="table table-bordered table-condensed">
                                                <thead><th colspan="3"><center>Historial de Inversionistas Anteriores<center></th></thead>
                                                <tbody>
                                                    <tr><td class='tdfontmini'><center><b>Inversionista</b></center></td><td class='tdfontmini'><center><b>Comentarios</b></center></td><td class='tdfontmini'><center><b>Fecha</b></center></td></tr>
                                                    <?php
                                                        $conocerInversionistaAnteriores = "select * from historial_inversionistas_creditos where id_credito=$fila_credito[0] order by fechahora desc;";
                                                        $iny_ConInvAnt = mysqli_query($mysqli,$conocerInversionistaAnteriores) or die(mysqli_error());
                                                        if(mysqli_num_rows($iny_ConInvAnt)>0){
                                                            while($f_InverAnt = mysqli_fetch_array($iny_ConInvAnt)){
                                                                $conocer_NombreInv = mysqli_query($mysqli,"SELECT nombre from inversionistas where id_inversionistas=$f_InverAnt[1]") or die(mysqli_error());
                                                                $f_NombreInv = mysqli_fetch_row($conocer_NombreInv);

                                                                echo "<tr><td class='tdfontmini'>$f_NombreInv[0]</td><td class='tdfontmini'>$f_InverAnt[5]</td><td class='tdfontmini'>$f_InverAnt[4]</td></tr>";
                                                            }
                                                        }else{
                                                            echo "<tr class='warning' ><td colspan='3'><center><i class='fa fa-info-circle' aria-hidden='true'></i> No existen Inversionistas Anteriores</center></td></tr>";
                                                        }
                                                    ?>
                                                </tbody>
                                           </table>
                                        </div>
                                        <?php } //FIn PERMISO INVERSIONISTAS HISOTIRAL?>
                                        
                                        <?php /*INICIO PERMISOS HISTORIAL DE INTERESES A PAGAR INVER*/ if(validarAccesoModulos('permiso_ver_detalle_credito_info_adicional_inversionista') == 1){ ?>
                                        <div class="col-xs-6">
                                           <table class="table table-bordered table-condensed table-xs">
                                                <thead><th colspan="3"><center>Historial de Interes a pagar Inversionista</center></th></thead>
                                                <tbody>
                                                    <tr><td class='tdfontmini'><center><b>Interes</b></center></td><td class='tdfontmini'><center><b>Fecha de Registro</b></center></td></tr>
                                                    <?php
                                                        $q_CONOCER_HISTORIAL_INTERES_A_PAGAR_INVERSIONISTA = "SELECT * FROM histor_inter_inver_credit where id_credito=$fila_credito[0] order by 1 desc;";
                                                        $i_CONOCER_HISTORIAL_INTERES_A_PAGAR_INVERSIONISTA = mysqli_query($mysqli,$q_CONOCER_HISTORIAL_INTERES_A_PAGAR_INVERSIONISTA) or die(mysqli_error());
                                                        if(mysqli_num_rows($i_CONOCER_HISTORIAL_INTERES_A_PAGAR_INVERSIONISTA)>0){
                                                            while($f_HISTO_INT_APAGAR_INVER = mysqli_fetch_assoc($i_CONOCER_HISTORIAL_INTERES_A_PAGAR_INVERSIONISTA)){
                                                                

                                                                echo "<tr><td class='tdfontmini'>".$f_HISTO_INT_APAGAR_INVER['interes']." %</td><td class='tdfontmini'>".$f_HISTO_INT_APAGAR_INVER['fecha_inicio']."</td></tr>";
                                                            }
                                                        }else{
                                                            echo "<tr class='warning' ><td colspan='3'><center><i class='fa fa-info-circle' aria-hidden='true'></i> No Registros Anteriores</center></td></tr>";
                                                        }
                                                    ?>
                                                </tbody>
                                           </table>
                                        </div>
                                        <?php } // FIN PERMISOS HISTORIAL INTERES A PAGAR INVERSIONISTA?>
                                    </div>
                                </div>
                            </div>
                            <!--FIN inversionistas-->
                        </div>
                    </div>
                    <?php
                        }
                    ?>
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
	<script type="text/javascript">

	$(document).ready(function(){
	  $('[data-toggle="popover"]').popover();
	});
	</script>

</body>

</html>

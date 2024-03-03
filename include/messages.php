<?php 
if(validarAccesoModulos('permiso_alertas_credito') == 1){ 
    //Generar Consulta
    $CONOCER_ALERTAS ='SELECT idAlertaCredito, creditos.folio, creditos.ID_CLIENTE, CONCAT(clientes.nombres," ",clientes.apaterno," ",clientes.amaterno) AS NOMBRE_cOMPLETO,alerta_credito.idCredito,fechaAlerta,comentario, alerta_credito.status  
	    FROM alerta_credito INNER JOIN creditos on alerta_credito.idCredito = creditos.id_creditos 
        inner join clientes ON creditos.id_cliente= clientes.id_clientes
        WHERE alerta_credito.STATUS=1 AND fechaAlerta < current_date  + INTERVAL 7 DAY ORDER BY FECHAaLERTA ASC;';
    $INY_CONOCER_ALERTAS = mysql_query($CONOCER_ALERTAS,$link) or die(mysql_error());
    $alertas = 0;
    if(mysql_num_rows($INY_CONOCER_ALERTAS) > 0 ){
        $alertas = 1;
        
    }


?>
<div class="row">
    <div class="col-md-12">
        <!-- DRAG AND DROP TODO LIST -->
        <div class="widget">
            <div class="widget-header">
                <h3><i class="fa fa-bell"></i> Alertas Atrasadas y Proximos 7 dias</h3> 
                <div class="btn-group widget-header-toolbar">
                    <a href="#" title="Focus" class="btn-borderless btn-focus"><i class="fa fa-eye"></i></a>
                    <a href="#" title="Expand/Collapse" class="btn-borderless btn-toggle-expand"><i class="fa fa-chevron-up"></i></a>
                    <a href="#" title="Remove" class="btn-borderless btn-remove"><i class="fa fa-times"></i></a>
                </div>
                
            </div>
            <div class="widget-content">
            <ul class="list-unstyled todo-list">
                <?php
                if($alertas > 0 ){
                    while ($FILA_CONOCER_ALERTAS = mysql_fetch_array($INY_CONOCER_ALERTAS)){
                        echo '
                    <li>
                        <p>
                        Credito: <a href="detalle-credito.php?id='.$FILA_CONOCER_ALERTAS[4].'">'.$FILA_CONOCER_ALERTAS[1].'</a>  |  Cliente: <a href="cliente-profile.php?id='.$FILA_CONOCER_ALERTAS[2].'">'.$FILA_CONOCER_ALERTAS[3].'</a> <a href="editar-alerta-credito.php?id='.$FILA_CONOCER_ALERTAS[4].'" class="btn btn-xs btn-info"><i class="fa fa-check-square-o"></i> Marcar Como Leido</a>';
                        if($FILA_CONOCER_ALERTAS[5] == $fecha_actual){
                            $tipo_alerta = "HOY";
                            $icono_alerta = "warning";
                        }elseif($FILA_CONOCER_ALERTAS[5] < $fecha_actual){
                            $tipo_alerta = "RETRASADA";
                            $icono_alerta = "danger";
                        }else{
                            $tipo_alerta = "NORMAL";
                            $icono_alerta = "success";
                        }
                        
                        echo '<span class="label label-'.$icono_alerta.'">'.$tipo_alerta.'</span>';
                        echo '<span class="short-description"><strong>'.$FILA_CONOCER_ALERTAS[6].'</strong></span>
                        <span class="date text-muted">'.date('d-F-Y',strtotime($FILA_CONOCER_ALERTAS[5])).'</span>
                    </p>
                </li>
                    ';
                    }
                    
                }else{
                    echo '<li>
                            <p>
                                <strong>No hay alertas retrasadas, ni en los proximos 7 dias</strong>
                                
                                
                            </p>
                        </li>';
                }
                ?>

                    
                    
                    
                   
                </ul>
            </div>
        </div>
        <!-- END DRAG AND DROP TODO LIST -->
    </div>
</div>
<?php
    }//Fina ValidaCion permisos
?>
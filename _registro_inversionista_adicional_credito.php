<?php
	session_start(); // crea una sesion
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");

	if(validarAccesoModulos('permiso_inversionistas_cambiar_credito') != 1) {
		header("Location: dashboard.php");
	}
    
	date_default_timezone_set('America/Mexico_City');
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}

	$fecha = date("Y-m-d");
  	$hora = date("G:i:s");
    $id_inversionista			= $_POST['inversionista'];
    $id_credito                 = $_POST['credito'];
	$monto_asignar_inver        = $_POST['monto_asignado'];
    $interes_asignado           = $_POST['interes-api'];    
    $comentarios                = $_POST['comentarios'];  

    $q_conocer_infoInverCred = "SELECT id_inversionistas_creditos,
        inversionistas_creditos.id_inversionista,
        nombre as nombreinversionista,
        inversionistas_creditos.monto as montoasignadoinver,
        inversionistas_creditos.interes,
        inversionistas_creditos.comentarios,
        inversionistas_creditos.fecha_registro,
        creditos.monto as montocredito
        from inversionistas_creditos 
        INNER JOIN inversionistas on inversionistas.id_inversionistas = inversionistas_creditos.id_inversionista 
        INNER join creditos on creditos.id_creditos = inversionistas_creditos.id_credito
        where inversionistas_creditos.id_credito=".$id_credito." and inversionistas_creditos.estatus_en_credito=1;"; 
    $iny_conocer_infoInverCred = mysqli_query($mysqli,$q_conocer_infoInverCred) or die (mysqli_error());
    $sumatoria_montos_asignados = 0;
    $montoCredito = 0;
    $inversionistasArr = array();
    while($fila_conocer_infoInverCred = mysqli_fetch_array($iny_conocer_infoInverCred)){
        $sumatoria_montos_asignados = $sumatoria_montos_asignados + $fila_conocer_infoInverCred['montoasignadoinver'];
        $montoCredito = $fila_conocer_infoInverCred['montocredito'];
        $inversionistasArr[] = $fila_conocer_infoInverCred['id_inversionista'];
    }
    $monto_disponible_para_asignar = $montoCredito - $sumatoria_montos_asignados;
    $error = 0;
    $stringError = "";

    if($monto_asignar_inver > $monto_disponible_para_asignar ){
        $error = $error + 1;
        $stringError .= "AmoMayDis_";
    }
    if(in_array($id_inversionista, $inversionistasArr)){
        $error = $error + 1;
        $stringError .= "AcRegIn_";
    }

    if($error == 0){
        $query_InsertaAdicional = "INSERT into 
                        inversionistas_creditos(
                            id_inversionista,
                            id_credito,
                            monto,
                            interes,
                            comentarios,
                            fecha_registro,
                            id_usuario_registro,
                            estatus_en_credito) 
                        VALUES(
                            '".$id_inversionista."',
                            '".$id_credito."',
                            '".$monto_asignar_inver."',
                            '".$interes_asignado."',
                            '".$comentarios."',
                            '".$fecha." ".$hora."',
                            '".$_SESSION['id_usuario']."',
                            1
                        );";

                        $iny_query_Inserta = mysqli_query($mysqli,$query_InsertaAdicional) or die(mysqli_error());

                        $query_REGISTRA_INFORMACION_HISTORICA_INTERES_INVER = "INSERT INTO histor_inter_inver_credit(id_credito,interes,fecha_inicio,id_inversionista) VALUES('$id_credito','$interes_asignado','$fecha $hora','$id_inversionista')";
                        $resultado_REGISTRA_INFORMACION_HISTORICA_INTERES_INVER= mysqli_query($mysqli,$query_REGISTRA_INFORMACION_HISTORICA_INTERES_INVER) or die(mysqli_error());
                        header('Location:detalle-credito.php?id='.$id_credito.'&inf=registrocorrecto');
    }else{
        header('Location:detalle-credito.php?id='.$id_credito.'&err='.$error.'&strErr='.$stringError);
    }
  ?>


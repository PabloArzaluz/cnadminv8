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

    $id_inversionista_credito			= $_POST['inver_credito'];
    
    $actualiza_estado_interes_inversionista = "UPDATE inversionistas_creditos SET estatus_en_credito = 0 WHERE id_inversionistas_creditos= $id_inversionista_credito ;";
    $iny_actualiza_estado_interes_inversionista = mysqli_query($mysqli,$actualiza_estado_interes_inversionista) or die (mysqli_error());

    

    $q_conocer_infoInverCred = "select id_inversionistas_creditos,inversionistas_creditos.id_inversionista as idinver,id_credito,inversionistas_creditos.monto as montoasignadoinver, inversionistas_creditos.interes as interesasignadoinver, inversionistas_creditos.comentarios, inversionistas.nombre as nombreinver,
        creditos.folio as folio_credito
        from inversionistas_creditos 
        inner join inversionistas on inversionistas_creditos.id_inversionista = inversionistas.id_inversionistas
        inner join creditos on creditos.id_creditos = inversionistas_creditos.id_credito
        where id_inversionistas_creditos= $id_inversionista_credito;"; 
    $iny_conocer_infoInverCred = mysqli_query($mysqli,$q_conocer_infoInverCred) or die (mysqli_error());
    $fila_conocer_infoInverCred = mysqli_fetch_assoc($iny_conocer_infoInverCred);

    //UPDATE HISTORIAL
    $q_inserta_historial_creditos = "INSERT INTO  historial_inversionistas_creditos(id_inversionista,id_credito,id_usuario,fechahora,comentarios) VALUES(".$fila_conocer_infoInverCred['idinver'].",".$fila_conocer_infoInverCred['id_credito'].",".$_SESSION['id_usuario'].",'$fecha $hora','".$fila_conocer_infoInverCred['comentarios']."');";
    $iny_inserta_historial_creditos = mysqli_query($mysqli,$q_inserta_historial_creditos) or die (mysqli_error());


     header('Location:detalle-credito.php?id='.$fila_conocer_infoInverCred['id_credito'].'&info=delinvercredo ');

  ?>


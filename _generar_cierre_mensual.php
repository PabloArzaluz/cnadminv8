<?php
	session_start(); // crea una sesion
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	
	date_default_timezone_set('America/Mexico_City');
	/*if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}*/
    /*
	$usuario = $_SESSION['id_usuario'];
	$fecha = date("Y-m-d");
  	$hora = date("G:i:s");

	$id_inversionista			= $_POST['inversionista'];
    $comentarios 		= $_POST['comentarios'];
    $id_credito= $_POST['credito'];
*/
    //Conocer Inversionista Actual    
    $CambInvEfec = "select * from creditos where id_creditos=3";
    $iny_CambInvEfec = mysqli_query($mysqli,$CambInvEfec) or die(mysqli_error());
    $f_CambInvEfec = mysqli_fetch_row($iny_CambInvEfec);
    echo $f_CambInvEfec[1];
    /*
    //Solo se actualizara el comentario debido a que no cambio el inversionista
    if($id_inversionista == $f_CambInvEfec[0]){
    	//Mismo Inversionista se actualizara el comentario
    	$ActInvComent = "UPDATE creditos SET comentarios_inversionista = '$comentarios' WHERE id_creditos='$id_credito';";
    	$iny_ActInvComent = mysqli_query($mysqli,$ActInvComent) or die(mysqli_error());
    	$ruta = "detalle-credito.php?id=".$id_credito."&info=5";
    	header('Location: '.$ruta);

    }else{
    	//Distinto Inversionista se actualizara la informacion 
    	$conocer_info_anterior = "select * from creditos where id_creditos= $id_credito";
    	$iny_conocer_info_anterior = mysqli_query($mysqli,$conocer_info_anterior) or die(mysqli_error());
    	$f_infoAnterior = mysqli_fetch_row($iny_conocer_info_anterior);
    	
    	//Actualizar registro
    	$ActInvComent = "UPDATE creditos SET id_inversionista = '$id_inversionista',comentarios_inversionista = '$comentarios' WHERE id_creditos='$id_credito';";
    	$iny_ActInvComent = mysqli_query($mysqli,$ActInvComent,) or die(mysqli_error());

    	//Insertar historial
    	$InsHisInv = "INSERT into historial_inversionistas_creditos(id_inversionista,id_credito,id_usuario,fechahora,comentarios) 
    	values ('$f_infoAnterior[10]','$id_credito','$usuario','$fecha $hora','$f_infoAnterior[11]');";
    	$iny_InsHisInv = mysqli_query($mysqli,$InsHisInv) or die(mysqli_error());

    	$ruta = "detalle-credito.php?id=".$id_credito."&info=5";
    	header('Location: '.$ruta);

    }*/
  ?>

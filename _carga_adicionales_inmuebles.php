<?php
    session_start(); // crea una sesion
	error_reporting(E_ALL); ini_set("display_errors", 1);
    include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
    include("include/functions.php");
	
	date_default_timezone_set('America/Mexico_City');
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
    if(validarAccesoModulos('permiso_agregar_inmuebles') == 0){
        header("Location: prestamos.php");
        return 0;
    }
	$fecha = date("Y-m-d");
  	$hora = date("G:i:s");
    $usuario_sube = $_SESSION['id_usuario'];
    $id_credito = $_POST['id-credito'];
    $id_cliente = $_POST['id-cliente'];
    $folio_real = $_POST['folio-real'];
    $comentarios = $_POST['comentarios'];

    
    if (is_uploaded_file($_FILES['archivo']['tmp_name'])){
        $archivo1 = explode(".",$_FILES['archivo']['name']);
        $nombre_archivo_original =  $_FILES['archivo']['name'];
        $nombre_aleatorio1 = mt_rand(0,9).mt_rand(100,9999).mt_rand(100,9999);
        $extension = strtolower(array_pop($archivo1));
        $nombre_generado_archivo1 =  $nombre_aleatorio1.".".$extension;
        $ruta = 'files/inmuebles/'.$nombre_generado_archivo1;
        move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta);
        chmod($ruta,0777);
        $insertar_informacion_archivo = "INSERT INTO inmuebles(id_credito,id_cliente,folio_real,comentarios,nombre_archivo1,ruta_archivo1) 
        VALUES('$id_credito','$id_cliente ','$folio_real','$comentarios','$nombre_archivo_original','$ruta');";
        $iny_consulta = mysqli_query($mysqli,$insertar_informacion_archivo) or die(mysqli_error());
        header("Location:detalle-credito.php?id=".$id_credito);
    }else{
        $insertar_informacion_archivo = "INSERT INTO inmuebles(id_credito,id_cliente,folio_real,comentarios) 
        VALUES('$id_credito','$id_cliente ','$folio_real','$comentarios');";
        $iny_consulta = mysqli_query($insertar_informacion_archivo,$link) or die(mysqli_error());
        header("Location:detalle-credito.php?id=".$id_credito);
        
    }


    
?>
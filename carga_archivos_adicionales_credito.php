<?php
    session_start(); // crea una sesion
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	
	date_default_timezone_set('America/Mexico_City');
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	$fecha = date("Y-m-d");
  	$hora = date("G:i:s");
    $usuario_sube = $_SESSION['id_usuario'];
    $id_credito = $_POST['id-credito'];
    $descripcion = $_POST['descripcion'];

    if (is_uploaded_file($_FILES['archivo']['tmp_name'])){
        $upload = $_FILES['archivo']['tmp_name']; 
            if(!empty($upload)) {
                if(isset($upload)){
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mime= finfo_file($finfo, $upload);
                    
                    switch($mime) {
                        case 'application/pdf':
                            $archivo1 = explode(".",$_FILES['archivo']['name']);
                            $nombre_archivo_original =  $_FILES['archivo']['name'];
                            $nombre_aleatorio1 = mt_rand(0,9).mt_rand(100,9999).mt_rand(100,9999);
                            $extension = strtolower(array_pop($archivo1));
                            $nombre_generado_archivo1 =  $nombre_aleatorio1.".".$extension;
                            $ruta = 'files/creditos/archivos-adicionales/'.$nombre_generado_archivo1;
                            move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta);
                            chmod($ruta,0755); 
                            $insertar_informacion_archivo = "INSERT INTO archiv_adic_credito(id_credito,usuario_sube,datetime,descripcion,nombreArchivo,path) 
                            VALUES('$id_credito','$usuario_sube','$fecha $hora','$descripcion','$nombre_archivo_original','$ruta');";
                            $iny_consulta = mysqli_query($mysqli,$insertar_informacion_archivo) or die(mysqli_error());
                            header("Location:detalle-credito.php?id=".$id_credito);
                        break;
                        default:
                            header("Location:detalle-credito.php?id=".$id_credito."&info=ErrorTipoArchivo");
                            break;
                    }
                }
            }
    }else{
        header("Location:detalle-credito.php?id=".$id_credito);
    }
/*
    
    
        
        
    }*/


    
?>
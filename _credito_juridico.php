<?php
	session_start(); // crea una sesion
	error_reporting(E_ALL); ini_set("display_errors", 1);
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	
	date_default_timezone_set('America/Mexico_City');
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	$fecha = date("Y-m-d");
  	$hora = date("G:i:s");

	//Tipo de OPeracion // Agregar Juridico
	if($_GET['oper'] == "add"){
		$id_credito 		= $_POST['id-credito'];
		$fecha_registro 	= $fecha." ".$hora;
		$usuario_registro 	= $_SESSION['id_usuario'];
		$juzgado			= $_POST['juzgado'];
		$expediente 		= $_POST['expediente'];
		$etapa_procesal 	= $_POST['etapa-procesal'];
		$comentarios 		= $_POST['comentarios'];

		$query_agregar_juridico = "INSERT INTO juridicos(id_credito, fecha_registro, usuario_registro, juzgado, expediente, etapaprocesal, convenios_path, convenios_file_name, comentarios) 
									VALUES('$id_credito', '$fecha_registro', '$usuario_registro', '$juzgado', '$expediente', '$etapa_procesal', '', '', '$comentarios');";
		$ini_query_agregar_juridico = mysqli_query($mysqli,$query_agregar_juridico) or die(mysqli_error());
		$last_id = mysqli_insert_id($link);

		//Carga de Archivo de Convenio
		if (is_uploaded_file($_FILES['convenio']['tmp_name'])){
			$archivo1 = explode(".",$_FILES['convenio']['name']);
			$nombre_archivo_original =  $_FILES['convenio']['name'];
			$nombre_aleatorio1 = mt_rand(0,9).mt_rand(100,9999).mt_rand(100,9999);
			$extension = strtolower(array_pop($archivo1));
			$nombre_generado_archivo1 =  $nombre_aleatorio1.".".$extension;
			$ruta = 'files/creditos/convenios/'.$nombre_generado_archivo1;
			move_uploaded_file($_FILES['convenio']['tmp_name'], $ruta);
			chmod($ruta,0777);
			//Actualizar en BD el archivo
			$actualizar_identificacion_oficial = "UPDATE juridicos set convenios_path='$ruta', convenios_file_name ='$nombre_archivo_original' where id_juridicos = $last_id;";
			$iny_consulta = mysqli_query($mysqli,$actualizar_identificacion_oficial) or die(mysqli_error());
		}

		//Al final modificar estatus del credito
		$query_update_credito = "UPDATE creditos SET status='3' WHERE id_creditos = '$id_credito';";
		$ini_query_agregar_juridico = mysqli_query($query_update_credito,$link) or die(mysqli_error());
	}
	
	//Tipo de OPeracion // editar Juridico
	if($_GET['oper']== "edit"){
		$id_juridico 		= $_POST['id_juridico'];

		$id_credito 		= $_POST['id-credito'];
		$fecha_registro 	= $fecha." ".$hora; // NO MODIFICAR
		$usuario_registro 	= $_SESSION['id_usuario'];
		$juzgado			= $_POST['juzgado'];
		$expediente 		= $_POST['expediente'];
		$etapa_procesal 	= $_POST['etapa-procesal'];
		$comentarios 		= $_POST['comentarios'];

		$actualizar_info_juridico = "UPDATE juridicos SET juzgado='$juzgado', expediente = '$expediente', etapaprocesal='$etapa_procesal', comentarios='$comentarios' WHERE id_juridicos=$id_juridico;";
		$iny_actualizar_info_juridico = mysqli_query($mysqli,$actualizar_info_juridico) or die(mysqli_error());

		if (is_uploaded_file($_FILES['convenio']['tmp_name'])){
			$archivo1 = explode(".",$_FILES['convenio']['name']);
			$nombre_archivo_original =  $_FILES['convenio']['name'];
			$nombre_aleatorio1 = mt_rand(0,9).mt_rand(100,9999).mt_rand(100,9999);
			$extension = strtolower(array_pop($archivo1));
			$nombre_generado_archivo1 =  $nombre_aleatorio1.".".$extension;
			$ruta = 'files/creditos/convenios/'.$nombre_generado_archivo1;
			move_uploaded_file($_FILES['convenio']['tmp_name'], $ruta);
			chmod($ruta,0777);
			$actualizar_identificacion_oficial = "UPDATE juridicos set convenios_path='$ruta', convenios_file_name ='$nombre_archivo_original' where id_juridicos = $id_juridico;";
			$iny_consulta = mysqli_query($mysqli,$actualizar_identificacion_oficial) or die(mysqli_error());
		}
	}

	unset($_SESSION['id_cliente']);
    unset($_SESSION['id_credito']);
    $ruta_regreso = "detalle-credito.php?id=".$id_credito;
    header('Location: '.$ruta_regreso);
   
    
   
    /*
    
    $query = "UPDATE creditos SET juzgado = '$juzgado',expediente = '$expediente',etapa_procesal = '$etapa_procesal', status='3',fecha_cierre_credito='$fecha' WHERE id_creditos = '$id_credito';";

    $resultado= mysqli_query($mysqli,$query) or die(mysqli_error());

    if (is_uploaded_file($_FILES['convenio']['tmp_name'])){
                $archivo1 = explode(".",$_FILES['convenio']['name']);
                $nombre_archivo_original =  $_FILES['convenio']['name'];
                $nombre_aleatorio1 = mt_rand(0,9).mt_rand(100,9999).mt_rand(100,9999);
                $extension = strtolower(array_pop($archivo1));
                $nombre_generado_archivo1 =  $nombre_aleatorio1.".".$extension;
                $ruta = 'files/creditos/convenios/'.$nombre_generado_archivo1;
                move_uploaded_file($_FILES['convenio']['tmp_name'], $ruta);
                chmod($ruta,0777);
                echo $actualizar_identificacion_oficial = "update creditos set convenio_file='$ruta', convenio_nombre ='$nombre_archivo_original' where id_creditos=$id_credito;";
                $iny_consulta = mysqli_query($mysqli,$actualizar_identificacion_oficial) or die(mysqli_error());
            }
    
    
*/
  ?>

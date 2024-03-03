<?php
	session_start(); // crea una sesion
	ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	$link = Conecta();
	date_default_timezone_set('America/Mexico_City');
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	$fecha = date("Y-m-d");
  	$hora = date("G:i:s");

	$id_credito = $_POST['id-prestamo'];
	$id_aval = $_POST['id-aval'];

    if($_POST['nombre-aval-1'] != "" && $_POST['parentesco-aval-1'] != "" && $_POST['telefono-aval-1'] != ""){
			
			$nombre_aval_1 = $_POST['nombre-aval-1'];
			$parentesco_aval_1 = $_POST['parentesco-aval-1'];
			$telefono_aval_1 = $_POST['telefono-aval-1'];

			$query = "UPDATE avales SET 
									nombre_completo = '$nombre_aval_1',
									parentesco = '$parentesco_aval_1',
									telefono = '$telefono_aval_1'
									WHERE id_avales=$id_aval";

		$resultado= mysql_query($query,$link) or die(mysql_error());
		

		if (is_uploaded_file($_FILES['comprobante-aval-1']['tmp_name'])){
			$archivo1 = explode(".",$_FILES['comprobante-aval-1']['name']);
			$nombre_archivo_original =  $_FILES['comprobante-aval-1']['name'];
			$nombre_aleatorio1 = mt_rand(0,9).mt_rand(100,9999).mt_rand(100,9999);
			$extension = strtolower(array_pop($archivo1));
			$nombre_generado_archivo1 =  $nombre_aleatorio1.".".$extension;
			$ruta = 'files/avales/comprobante-domicilio/'.$nombre_generado_archivo1;
			move_uploaded_file($_FILES['comprobante-aval-1']['tmp_name'], $ruta);
			chmod($ruta,0777);
			$actualizar_identificacion_oficial = "update avales set comprobante_file='$ruta', comprobante_nombre ='$nombre_archivo_original' where id_avales = $id_aval;";
			$iny_consulta = mysql_query($actualizar_identificacion_oficial,$link) or die(mysql_error());
		}
		
		if (is_uploaded_file($_FILES['identificacion-oficial-1']['tmp_name'])){
			$archivo1 = explode(".",$_FILES['identificacion-oficial-1']['name']);
			$nombre_archivo_original =  $_FILES['identificacion-oficial-1']['name'];
			$nombre_aleatorio1 = mt_rand(0,9).mt_rand(100,9999).mt_rand(100,9999);
			$extension = strtolower(array_pop($archivo1));
			$nombre_generado_archivo1 =  $nombre_aleatorio1.".".$extension;
			$ruta = 'files/avales/identificacion-oficial/'.$nombre_generado_archivo1;
			move_uploaded_file($_FILES['identificacion-oficial-1']['tmp_name'], $ruta);
			chmod($ruta,0777);
			$actualizar_identificacion_oficial = "update avales set identificacion_file='$ruta', identificacion_nombre ='$nombre_archivo_original' where id_avales = $id_aval;";
			$iny_consulta = mysql_query($actualizar_identificacion_oficial,$link) or die(mysql_error());
		}

    }




    //1 GUARDAR Y OTRO, 2 GUARDAR Y SIGUIENTE
	
	$id_prestamo = $_POST["id-prestamo"];
	$id_cliente = $_POST["id-cliente"];
	
	header('Location: detalle-credito.php?id='.$id_prestamo);


  ?>

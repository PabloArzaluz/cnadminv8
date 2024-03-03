<?php
	session_start(); // crea una sesion
	ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/functions.php");
	$link = Conecta();
	date_default_timezone_set('America/Mexico_City');

	RestringirAccesoModulosNoPermitidos("permiso_credito_editar_informacion_basica");

	if(!isset($_SESSION['id_usuario'])){
		header('Location: index.php');
	}else{
		 $id_credito			= $_POST['credito'];
		 $monto_credito			= $_POST['monto-credito'];
		 $pago_mensual			= $_POST['pago-mensual'];
		 //$fecha_inicial			= $_POST['fecha-inicial'];
		$interes_mensual		= $_POST['interes-mensual'];
		$interes_moratorio		= $_POST['interes-moratorio'];
		$competencia 			= $_POST['competencia'];
		$comentario_credito 	= $_POST['comentario-credito'];
		$infonavit 				= $_POST['infonavit'];
		$isseg 					= $_POST['isseg'];
		$actualizar_credito = "UPDATE creditos SET
		 						monto= '$monto_credito',
		 						pago_mensual = '$pago_mensual',
		 						
		 						interes = '$interes_mensual',
		 						interes_moratorio = '$interes_moratorio',
								competencia	= '$competencia',
								comentario_credito = '$comentario_credito',
								infonavit = '$infonavit',
								isseg = '$isseg'
		 					WHERE id_creditos = '$id_credito';";

		 $iny_actualizar_credito = mysql_query($actualizar_credito,$link) or die(mysql_error());

		 if (is_uploaded_file($_FILES['poder']['tmp_name'])){
		 	$archivo1 = explode(".",$_FILES['poder']['name']);
			$nombre_archivo_original =  $_FILES['poder']['name'];
			$nombre_aleatorio1 = mt_rand(0,9).mt_rand(100,9999).mt_rand(100,9999);
			$extension = strtolower(array_pop($archivo1));
			$nombre_generado_archivo1 =  $nombre_aleatorio1.".".$extension;
			$ruta = 'files/creditos/poder/'.$nombre_generado_archivo1;
			move_uploaded_file($_FILES['poder']['tmp_name'], $ruta);
			chmod($ruta,0777);
			$actualizar_identificacion_oficial = "update creditos set poder_file='$ruta', poder_nombre ='$nombre_archivo_original' where id_creditos='$id_credito';";
			$iny_consulta = mysql_query($actualizar_identificacion_oficial,$link) or die(mysql_error());
		}

		if (is_uploaded_file($_FILES['mutuo']['tmp_name'])){
			$archivo2 = explode(".",$_FILES['mutuo']['name']);
			$nombre_archivo_original2 =  $_FILES['mutuo']['name'];
			$nombre_aleatorio2 = mt_rand(0,9).mt_rand(100,9999).mt_rand(100,9999);
			$extension2 = strtolower(array_pop($archivo2));
			$nombre_generado_archivo2 =  $nombre_aleatorio2.".".$extension2;
			$ruta2 = 'files/creditos/mutuo/'.$nombre_generado_archivo2;
			move_uploaded_file($_FILES['mutuo']['tmp_name'], $ruta2);
			chmod($ruta2,0777);
			$actualizar_mutuo = "update creditos set mutuo_file='$ruta2', mutuo_nombre ='$nombre_archivo_original2' where id_creditos=$id_credito;";
			$iny_consulta2 = mysql_query($actualizar_mutuo,$link) or die(mysql_error());
		}

		$ruta = "detalle-credito.php?info=2&id=".$id_credito;
		header('Location: '.$ruta);
	}
  ?>

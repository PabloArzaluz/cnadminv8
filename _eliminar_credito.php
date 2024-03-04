<?php
	session_start(); // crea una sesion
	error_reporting(E_ALL); ini_set("display_errors", 1);
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	
	date_default_timezone_set('America/Mexico_City');

	
	if(!isset($_SESSION['id_usuario'])){
		header('Location: index.php');
	}else{
		if(!isset($_POST['credito'])){
			header('Location: dashboard.php');
		}else{
			//Se procede a la eliminacion del credito, junto con todo su relacionado
			$id_credito = $_POST['credito'];
			
			$eliminar_avales = "DELETE FROM avales WHERE id_credito ='$id_credito';";
			$iny_eliminar_avales = mysqli_query($mysqli,$eliminar_avales) or die(mysqli_error());

			$eliminar_adeudos = "DELETE FROM adeudos WHERE id_credito ='$id_credito';";
			$iny_eliminar_adeudos = mysqli_query($mysqli,$eliminar_adeudos) or die(mysqli_error());

			$eliminar_pagos = "DELETE FROM pagos WHERE id_credito ='$id_credito';";
			$iny_eliminar_pagos = mysqli_query($mysqli,$eliminar_pagos) or die(mysqli_error());

			$eliminar_pagos_sat = "DELETE FROM pagos_sat WHERE id_credito ='$id_credito';";
			$iny_eliminar_pagos_sat = mysqli_query($mysqli,$eliminar_pagos_sat) or die(mysqli_error());

			$eliminar_pinversionistas = "DELETE FROM pinversionistas WHERE id_credito ='$id_credito';";
			$iny_eliminar_pinversionistas = mysqli_query($mysqli,$eliminar_pinversionistas) or die(mysqli_error());

			$eliminar_inmuebles = "DELETE FROM inmuebles WHERE id_credito ='$id_credito';";
			$iny_eliminar_inmuebles = mysqli_query($mysqli,$eliminar_inmuebles) or die(mysqli_error());

			$eliminar_historial_inversionistas = "DELETE FROM historial_inversionistas_creditos WHERE id_credito ='$id_credito';";
			$iny_eliminar_historial_inversionistas = mysqli_query($mysqli,$eliminar_historial_inversionistas) or die(mysqli_error());

			$eliminar_credito = "DELETE FROM creditos WHERE id_creditos ='$id_credito';";
			$iny_eliminar_credito = mysqli_query($mysqli,$eliminar_credito) or die(mysqli_error());


			$ruta = "prestamos.php?info=3";
			header('Location:'.$ruta);

		}
	}
  ?>

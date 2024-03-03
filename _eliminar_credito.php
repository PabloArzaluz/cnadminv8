<?php
	session_start(); // crea una sesion
	ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	$link = Conecta();
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
			$iny_eliminar_avales = mysql_query($eliminar_avales,$link) or die(mysql_error());

			$eliminar_adeudos = "DELETE FROM adeudos WHERE id_credito ='$id_credito';";
			$iny_eliminar_adeudos = mysql_query($eliminar_adeudos,$link) or die(mysql_error());

			$eliminar_pagos = "DELETE FROM pagos WHERE id_credito ='$id_credito';";
			$iny_eliminar_pagos = mysql_query($eliminar_pagos,$link) or die(mysql_error());

			$eliminar_pagos_sat = "DELETE FROM pagos_sat WHERE id_credito ='$id_credito';";
			$iny_eliminar_pagos_sat = mysql_query($eliminar_pagos_sat,$link) or die(mysql_error());

			$eliminar_pinversionistas = "DELETE FROM pinversionistas WHERE id_credito ='$id_credito';";
			$iny_eliminar_pinversionistas = mysql_query($eliminar_pinversionistas,$link) or die(mysql_error());

			$eliminar_inmuebles = "DELETE FROM inmuebles WHERE id_credito ='$id_credito';";
			$iny_eliminar_inmuebles = mysql_query($eliminar_inmuebles,$link) or die(mysql_error());

			$eliminar_historial_inversionistas = "DELETE FROM historial_inversionistas_creditos WHERE id_credito ='$id_credito';";
			$iny_eliminar_historial_inversionistas = mysql_query($eliminar_historial_inversionistas,$link) or die(mysql_error());

			$eliminar_credito = "DELETE FROM creditos WHERE id_creditos ='$id_credito';";
			$iny_eliminar_credito = mysql_query($eliminar_credito,$link) or die(mysql_error());


			$ruta = "prestamos.php?info=3";
			header('Location:'.$ruta);

		}
	}
  ?>

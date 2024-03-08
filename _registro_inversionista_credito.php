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
	//echo $_POST['password'];
    $id_inversionista			= $_POST['inversionista'];
    
    //Variables de Session
    $id_credito = $_SESSION['id_credito'];
		
	$sumatoria_total_verificacion = 0;
	foreach($_POST['inversionista'] as $key => $value){
		$cantidad_asignada = $_POST['monto_asignado_inver'][$key];
		$sumatoria_total_verificacion = $sumatoria_total_verificacion + $cantidad_asignada;
	}
	if($sumatoria_total_verificacion == $_SESSION['ammount_new_loan']){
		//se procede a la insercion
		foreach($_POST['inversionista'] as $key => $value){
			$id_inversionistas = $_POST['inversionista'][$key];
			$cantidad_asignada = $_POST['monto_asignado_inver'][$key];
			$interes_asignado_inver = $_POST['interes_asignado_inver'][$key];
			$comentarios_asignado_inver = $_POST['comentarios_asignado_inver'][$key];

			$query = "INSERT into inversionistas_creditos(id_inversionista,id_credito,monto,interes,comentarios,fecha_registro,id_usuario_registro,estatus_en_credito) VALUES('".$id_inversionistas."','".$id_credito."','".$cantidad_asignada."','".$interes_asignado_inver."','".$comentarios_asignado_inver."','".$fecha." ".$hora."','".$_SESSION['id_usuario']."',1);";
			$resultado= mysqli_query($mysqli,$query) or die(mysqli_error());
			
			//Registro en archivo Historico los valores del Interes del Inversionista
			$query_REGISTRA_INFORMACION_HISTORICA_INTERES_INVER = "INSERT INTO histor_inter_inver_credit(id_credito,interes,fecha_inicio,id_inversionista) VALUES('$id_credito','$interes_asignado_inver','$fecha $hora','$id_inversionistas')";
    		$resultado_REGISTRA_INFORMACION_HISTORICA_INTERES_INVER= mysqli_query($mysqli,$query_REGISTRA_INFORMACION_HISTORICA_INTERES_INVER) or die(mysqli_error());

			unset($_SESSION['id_cliente']);
    		unset($_SESSION['id_credito']);
			unset($_SESSION['ammount_new_loan']);

    		header('Location: prestamos.php?info=1');
		}
	}else{
		header("Location:captura_inversionista.php?msg=Error");
	}

	

	//$id_cliente = mysqli_insert_id($mysqli);

    
  ?>


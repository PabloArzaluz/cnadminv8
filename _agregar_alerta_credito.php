<?php
	session_start(); // crea una sesion
	ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	$link = Conecta();
	date_default_timezone_set('America/Mexico_City');
	$date_actual = date("Y-m-d");
	$hora = date('H:i:s');

	
	if(!isset($_SESSION['id_usuario'])){
		header('Location: index.php');
	}else{
		$idCredito = $_POST['idCredito'];
		$fechaAlerta = $_POST['fecha-alerta'];
		$comentarios = $_POST['comentarios'];
		$fechahora = $date_actual." ".$hora;
		$usuarioCreacion = $_SESSION['id_usuario'];

		$insert_alerta_credito = "INSERT INTO alerta_credito(idCredito,fechaAlerta,comentario,status,fechaCreacion,usuarioCreacion) VALUES('$idCredito','$fechaAlerta','$comentarios',1,'$fechahora','$usuarioCreacion');";
		$iny_insert_alerta_credito = mysqli_query($mysqli,$insert_alerta_credito) or die ('Unable to execute query. '. mysqli_error($mysqli));

		$ruta_redirect = "detalle-credito.php?id=".$idCredito;
		header('Location: '.$ruta_redirect);
		/*
		if(!isset($_POST['fecha'])){
			header('Location: nuevo-prestamo.php?info=2');
		}else{
			if(empty($_POST['fecha'])){
				header('Location: nuevo-prestamo.php?info=3');
			}else{
				if($_POST['fecha'] == 0){
					header('Location: nuevo-prestamo.php?info=4');
				}else{

					$idCredito = $_POST['idCredito'];
					$fecha=  $_POST['fecha'];
					$fechaAnterior=  $_POST['fechaAnterior'];
					$usuarioModifico = $_SESSION['id_usuario'];

					//First Save the value Fecha Inicial received on table. After update Fecha inicial value on main table
					$insert_date_modified = "INSERT INTO historfechcredmodif(idCredito,fecha,fechaAnterior,fechaHoraModificacion,usuarioModifico) VALUES('$idCredito','$fecha','$fechaAnterior','$date_actual $hora','".$_SESSION['id_usuario']."');";
					$iny_insert_date_modified = mysqli_query($mysqli,$insert_date_modified) or die ('Unable to execute query. '. mysqli_error($mysqli));

					// After, update the main date on credit table.
					$modificar_fecha_credito_principal = "UPDATE creditos SET fecha_prestamo = '".$fecha."' 	WHERE id_creditos=".$idCredito.";";
					$iny_insert_date_modified = mysqli_query($mysqli,$modificar_fecha_credito_principal) or die ('Unable to execute query. '. mysqli_error($mysqli));

					$ruta_redirect = "detalle-credito.php?id=".$idCredito;
					header('Location: '.$ruta_redirect);

				}
			}
		}*/
	}
  ?>

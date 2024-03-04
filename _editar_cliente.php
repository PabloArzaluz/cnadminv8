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
	//PERMISOS
	if(validarAccesoModulos('permiso_clientes') != 1) {
		header("Location: dashboard.php");
	}
	//FIN PERMISOS
	$fecha = date("Y-m-d");
  	$hora = date("G:i:s");

	$idcliente = $_GET['id'];
    $nombre			= $_POST['nombre'];
    $apaterno 		= $_POST['apaterno'];
    $amaterno 		= $_POST['amaterno'];
	$direccion 		= $_POST['direccion'];
    $telefonos		= $_POST['telefonos'];
    $email			= $_POST['email'];
    $fnacimiento	= $_POST['fnacimiento'];
	$domiciliotrabajo	= $_POST['domiciliotrabajo'];
	$telefonotrabajo	= $_POST['telefonotrabajo'];
	if(!isset($_POST['categoria'])){
		$categoria = "";
	}else{
		$categoria = $_POST['categoria'];
	}
	


   $query= "UPDATE clientes SET
   					nombres 	= '$nombre',
					apaterno 	= '$apaterno',
					amaterno 	= '$amaterno',
					direccion 	= '$direccion',
					num_telefonos = '$telefonos',
					email = '$email',
					fnacimiento = '$fnacimiento',
					fcreacion = '$fecha $hora',
					status = 'activo',
					domiciliotrabajo = '$domiciliotrabajo',
					telefonotrabajo = '$telefonotrabajo',
					categoria = '$categoria'
				WHERE id_clientes = $idcliente;";
    			$resultado= mysqli_query($mysqli,$query) or die(mysqli_error());

			//Identificacion Oficial
		if (is_uploaded_file($_FILES['identificacion-oficial']['tmp_name'])){
			$archivo1 = explode(".",$_FILES['identificacion-oficial']['name']);
			$nombre_archivo_original =  $_FILES['identificacion-oficial']['name'];
			$nombre_aleatorio1 = mt_rand(0,9).mt_rand(100,9999).mt_rand(100,9999);
			$extension = strtolower(array_pop($archivo1));
			$nombre_generado_archivo1 =  $nombre_aleatorio1.".".$extension;
			$ruta = 'files/clientes/identificacion-oficial/'.$nombre_generado_archivo1;
			move_uploaded_file($_FILES['identificacion-oficial']['tmp_name'], $ruta);
			chmod($ruta,0777);
			$actualizar_identificacion_oficial = "update clientes set file_identificacion='$ruta', nombre_identificacion ='$nombre_archivo_original' where id_clientes=$idcliente;";
			$iny_consulta = mysqli_query($mysqli,$actualizar_identificacion_oficial) or die(mysqli_error());
		}

		if (is_uploaded_file($_FILES['comprobante-domicilio']['tmp_name'])){
			$archivo = explode(".",$_FILES['comprobante-domicilio']['name']);
			$nombre_archivo_original =  $_FILES['comprobante-domicilio']['name'];
			$nombre_aleatorio1 = mt_rand(0,9).mt_rand(100,9999).mt_rand(100,9999);
			$extension = strtolower(array_pop($archivo));
			$nombre_generado_archivo1 =  $nombre_aleatorio1.".".$extension;
			$ruta = 'files/clientes/comprobante-domicilio/'.$nombre_generado_archivo1;
			move_uploaded_file($_FILES['comprobante-domicilio']['tmp_name'], $ruta);
			chmod($ruta,0777);
			$upd = "update clientes set file_comprobantedomicilio='$ruta',nombre_comprobantedomicilio = '$nombre_archivo_original' where id_clientes=$idcliente;";
			$iny_consulta = mysqli_query($mysqli,$upd) or die(mysqli_error());
		}



		header('Location: clientes.php?info=1');

  ?>

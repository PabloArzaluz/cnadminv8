<?php
	session_start(); // crea una sesion
	ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/functions.php");
	$link = Conecta();
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
    			$resultado= mysql_query($query,$link) or die(mysql_error());

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
			$iny_consulta = mysql_query($actualizar_identificacion_oficial,$link) or die(mysql_error());
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
			$iny_consulta = mysql_query($upd,$link) or die(mysql_error());
		}



		header('Location: clientes.php?info=1');

  ?>

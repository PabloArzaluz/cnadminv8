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
	//echo $_POST['password'];

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


/*

    echo $nombre;

    echo "<br/>";

    echo $apaterno;

    echo "<br/>";

    echo $direccion;

    echo "<br/>";

    echo $telefonos;

    echo "<br/>";

    echo $amaterno;

    echo "<br/>";

    echo $email;

    echo "<br/>";

    echo $fnacimiento;

*/

   $query= "INSERT INTO clientes (nombres,apaterno,amaterno,direccion,num_telefonos,email,fnacimiento,fcreacion,status,file_identificacion,file_comprobantedomicilio,domiciliotrabajo,telefonotrabajo,categoria)

   				VALUES

			('$nombre',

				'$apaterno',

				'$amaterno',

				'$direccion',

				'$telefonos',

				'$email',

				'$fnacimiento',

				'$fecha $hora',

				'activo',

				'',

				'',

				'$domiciliotrabajo',

				'$telefonotrabajo',
				'$categoria')";

    			$resultado= mysql_query($query,$link) or die(mysql_error());



				$id_cliente = mysql_insert_id();



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

			$actualizar_identificacion_oficial = "update clientes set file_identificacion='$ruta', nombre_identificacion ='$nombre_archivo_original' where id_clientes=$id_cliente;";

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

			$upd = "update clientes set file_comprobantedomicilio='$ruta',nombre_comprobantedomicilio = '$nombre_archivo_original' where id_clientes=$id_cliente;";

			$iny_consulta = mysql_query($upd,$link) or die(mysql_error());

		}







       header('Location: clientes.php?info=3');



  ?>


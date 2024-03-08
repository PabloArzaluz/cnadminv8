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

	//1 GUARDAR Y OTRO, 2 GUARDAR Y SIGUIENTE
	$info = $_POST["info"];
	$id_prestamo = $_POST["id-prestamo"];
	$id_cliente = $_POST["id-cliente"];
	$folio_real			= $_POST['folio-real'];
    $comentarios 		= $_POST['comentarios'];

   $query= "INSERT INTO inmuebles (id_credito, id_cliente, folio_real, comentarios, nombre_archivo1, ruta_archivo1, nombre_archivo2, ruta_archivo2, nombre_archivo3, ruta_archivo3, nombre_archivo4, ruta_archivo4, nombre_archivo5, ruta_archivo5, nombre_archivo6, ruta_archivo6, nombre_archivo7, ruta_archivo7, nombre_archivo8, ruta_archivo8, nombre_Archivo9, ruta_archivo9, nombre_archivo10, ruta_archivo10)
   				VALUES
			('$id_prestamo',
				'$id_cliente',
				'$folio_real',
				'$comentarios',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'')";

    			//$resultado= mysqli_query($mysqli,$query) or die(mysqli_error());

				//$id_cliente_insertado = mysqli_insert_id($mysqli);


		if (isset($_POST['info']) && $_POST['info'] == '1'){
			//Guardar y registrar otro inmueble
			header('Location: nuevo-prestamo-inmuebles.php?info=3&id='.$id_prestamo.'&cl='.$id_cliente);
		 }
		 if (isset($_POST['info']) && $_POST['info'] == '2'){
 			//Guardar y siguiente
 			header('Location: captura_inversionista.php');
 		 }
  ?>

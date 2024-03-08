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

    if(isset($_POST['folio-real']) && isset($_POST['comentarios'])){
        if(empty($_POST['folio-real']) && empty($_POST['comentarios'])){
            $id_prestamo = $_POST["id-prestamo"];
            $id_cliente = $_POST["id-cliente"];
            header('Location: nuevo-prestamo-inmuebles.php?info=4&id='.$id_prestamo.'&cl='.$id_cliente);
        }else{
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

    			$resultado= mysqli_query($mysqli,$query) or die(mysqli_error());

				$id_cliente_insertado = mysqli_insert_id($mysqli);


		if (is_uploaded_file($_FILES['file1']['tmp_name'])){
			$archivo1 = explode(".",$_FILES['file1']['name']);
			$nombre_archivo_original =  $_FILES['file1']['name'];
			$nombre_aleatorio1 = mt_rand(0,9).mt_rand(100,9999).mt_rand(100,9999);
			$extension = strtolower(array_pop($archivo1));
			$nombre_generado_archivo1 =  $nombre_aleatorio1.".".$extension;
			$ruta = 'files/inmuebles/'.$nombre_generado_archivo1;
			move_uploaded_file($_FILES['file1']['tmp_name'], $ruta);
			chmod($ruta,0777);
			$actualizar_identificacion_oficial = "update inmuebles set ruta_archivo1='$ruta', nombre_archivo1 ='$nombre_archivo_original' where id_inmuebles = $id_cliente_insertado;";
			$iny_consulta = mysqli_query($mysqli,$actualizar_identificacion_oficial) or die(mysqli_error());
		}
		if (is_uploaded_file($_FILES['file2']['tmp_name'])){
			$archivo1 = explode(".",$_FILES['file2']['name']);
			$nombre_archivo_original =  $_FILES['file2']['name'];
			$nombre_aleatorio1 = mt_rand(0,9).mt_rand(100,9999).mt_rand(100,9999);
			$extension = strtolower(array_pop($archivo1));
			$nombre_generado_archivo1 =  $nombre_aleatorio1.".".$extension;
			$ruta = 'files/inmuebles/'.$nombre_generado_archivo1;
			move_uploaded_file($_FILES['file2']['tmp_name'], $ruta);
			chmod($ruta,0777);
			$actualizar_identificacion_oficial = "update inmuebles set ruta_archivo2='$ruta', nombre_archivo2 ='$nombre_archivo_original' where id_inmuebles = $id_cliente_insertado;";
			$iny_consulta = mysqli_query($mysqli,$actualizar_identificacion_oficial) or die(mysqli_error());
		}
		if (is_uploaded_file($_FILES['file3']['tmp_name'])){
			$archivo1 = explode(".",$_FILES['file3']['name']);
			$nombre_archivo_original =  $_FILES['file3']['name'];
			$nombre_aleatorio1 = mt_rand(0,9).mt_rand(100,9999).mt_rand(100,9999);
			$extension = strtolower(array_pop($archivo1));
			$nombre_generado_archivo1 =  $nombre_aleatorio1.".".$extension;
			$ruta = 'files/inmuebles/'.$nombre_generado_archivo1;
			move_uploaded_file($_FILES['file3']['tmp_name'], $ruta);
			chmod($ruta,0777);
			$actualizar_identificacion_oficial = "update inmuebles set ruta_archivo3='$ruta', nombre_archivo3 ='$nombre_archivo_original' where id_inmuebles = $id_cliente_insertado;";
			$iny_consulta = mysqli_query($mysqli,$actualizar_identificacion_oficial) or die(mysqli_error());
		}
		if (is_uploaded_file($_FILES['file4']['tmp_name'])){
			$archivo1 = explode(".",$_FILES['file4']['name']);
			$nombre_archivo_original =  $_FILES['file4']['name'];
			$nombre_aleatorio1 = mt_rand(0,9).mt_rand(100,9999).mt_rand(100,9999);
			$extension = strtolower(array_pop($archivo1));
			$nombre_generado_archivo1 =  $nombre_aleatorio1.".".$extension;
			$ruta = 'files/inmuebles/'.$nombre_generado_archivo1;
			move_uploaded_file($_FILES['file4']['tmp_name'], $ruta);
			chmod($ruta,0777);
			$actualizar_identificacion_oficial = "update inmuebles set ruta_archivo4='$ruta', nombre_archivo4 ='$nombre_archivo_original' where id_inmuebles = $id_cliente_insertado;";
			$iny_consulta = mysqli_query($mysqli,$actualizar_identificacion_oficial) or die(mysqli_error());
		}
		if (is_uploaded_file($_FILES['file5']['tmp_name'])){
			$archivo1 = explode(".",$_FILES['file5']['name']);
			$nombre_archivo_original =  $_FILES['file5']['name'];
			$nombre_aleatorio1 = mt_rand(0,9).mt_rand(100,9999).mt_rand(100,9999);
			$extension = strtolower(array_pop($archivo1));
			$nombre_generado_archivo1 =  $nombre_aleatorio1.".".$extension;
			$ruta = 'files/inmuebles/'.$nombre_generado_archivo1;
			move_uploaded_file($_FILES['file5']['tmp_name'], $ruta);
			chmod($ruta,0777);
			$actualizar_identificacion_oficial = "update inmuebles set ruta_archivo5='$ruta', nombre_archivo5 ='$nombre_archivo_original' where id_inmuebles = $id_cliente_insertado;";
			$iny_consulta = mysqli_query($mysqli,$actualizar_identificacion_oficial) or die(mysqli_error());
		}
		if (is_uploaded_file($_FILES['file6']['tmp_name'])){
			$archivo1 = explode(".",$_FILES['file6']['name']);
			$nombre_archivo_original =  $_FILES['file6']['name'];
			$nombre_aleatorio1 = mt_rand(0,9).mt_rand(100,9999).mt_rand(100,9999);
			$extension = strtolower(array_pop($archivo1));
			$nombre_generado_archivo1 =  $nombre_aleatorio1.".".$extension;
			$ruta = 'files/inmuebles/'.$nombre_generado_archivo1;
			move_uploaded_file($_FILES['file6']['tmp_name'], $ruta);
			chmod($ruta,0777);
			$actualizar_identificacion_oficial = "update inmuebles set ruta_archivo6='$ruta', nombre_archivo6 ='$nombre_archivo_original' where id_inmuebles = $id_cliente_insertado;";
			$iny_consulta = mysqli_query($mysqli,$actualizar_identificacion_oficial) or die(mysqli_error());
		}
		if (is_uploaded_file($_FILES['file7']['tmp_name'])){
			$archivo1 = explode(".",$_FILES['file7']['name']);
			$nombre_archivo_original =  $_FILES['file7']['name'];
			$nombre_aleatorio1 = mt_rand(0,9).mt_rand(100,9999).mt_rand(100,9999);
			$extension = strtolower(array_pop($archivo1));
			$nombre_generado_archivo1 =  $nombre_aleatorio1.".".$extension;
			$ruta = 'files/inmuebles/'.$nombre_generado_archivo1;
			move_uploaded_file($_FILES['file7']['tmp_name'], $ruta);
			chmod($ruta,0777);
			$actualizar_identificacion_oficial = "update inmuebles set ruta_archivo7='$ruta', nombre_archivo7 ='$nombre_archivo_original' where id_inmuebles = $id_cliente_insertado;";
			$iny_consulta = mysqli_query($mysqli,$actualizar_identificacion_oficial) or die(mysqli_error());
		}
		if (is_uploaded_file($_FILES['file8']['tmp_name'])){
			$archivo1 = explode(".",$_FILES['file8']['name']);
			$nombre_archivo_original =  $_FILES['file8']['name'];
			$nombre_aleatorio1 = mt_rand(0,9).mt_rand(100,9999).mt_rand(100,9999);
			$extension = strtolower(array_pop($archivo1));
			$nombre_generado_archivo1 =  $nombre_aleatorio1.".".$extension;
			$ruta = 'files/inmuebles/'.$nombre_generado_archivo1;
			move_uploaded_file($_FILES['file8']['tmp_name'], $ruta);
			chmod($ruta,0777);
			$actualizar_identificacion_oficial = "update inmuebles set ruta_archivo8='$ruta', nombre_archivo8 ='$nombre_archivo_original' where id_inmuebles = $id_cliente_insertado;";
			$iny_consulta = mysqli_query($mysqli,$actualizar_identificacion_oficial) or die(mysqli_error());
		}
		if (is_uploaded_file($_FILES['file9']['tmp_name'])){
			$archivo1 = explode(".",$_FILES['file9']['name']);
			$nombre_archivo_original =  $_FILES['file9']['name'];
			$nombre_aleatorio1 = mt_rand(0,9).mt_rand(100,9999).mt_rand(100,9999);
			$extension = strtolower(array_pop($archivo1));
			$nombre_generado_archivo1 =  $nombre_aleatorio1.".".$extension;
			$ruta = 'files/inmuebles/'.$nombre_generado_archivo1;
			move_uploaded_file($_FILES['file9']['tmp_name'], $ruta);
			chmod($ruta,0777);
			$actualizar_identificacion_oficial = "update inmuebles set ruta_archivo9='$ruta', nombre_archivo9 ='$nombre_archivo_original' where id_inmuebles = $id_cliente_insertado;";
			$iny_consulta = mysqli_query($mysqli,$actualizar_identificacion_oficial) or die(mysqli_error());
		}
		if (is_uploaded_file($_FILES['file10']['tmp_name'])){
			$archivo1 = explode(".",$_FILES['file10']['name']);
			$nombre_archivo_original =  $_FILES['file10']['name'];
			$nombre_aleatorio1 = mt_rand(0,9).mt_rand(100,9999).mt_rand(100,9999);
			$extension = strtolower(array_pop($archivo1));
			$nombre_generado_archivo1 =  $nombre_aleatorio1.".".$extension;
			$ruta = 'files/inmuebles/'.$nombre_generado_archivo1;
			move_uploaded_file($_FILES['file10']['tmp_name'], $ruta);
			chmod($ruta,0777);
			$actualizar_identificacion_oficial = "update inmuebles set ruta_archivo10='$ruta', nombre_archivo10 ='$nombre_archivo_original' where id_inmuebles = $id_cliente_insertado;";
			$iny_consulta = mysqli_query($mysqli,$actualizar_identificacion_oficial) or die(mysqli_error());
		}

		if (isset($_POST['info']) && $_POST['info'] == '1'){
			//Guardar y registrar otro inmueble
			header('Location: nuevo-prestamo-inmuebles.php?info=3&id='.$id_prestamo.'&cl='.$id_cliente);
		 }
		 if (isset($_POST['info']) && $_POST['info'] == '2'){
 			//Guardar y siguiente
 			header('Location: captura_inversionista.php');
 		 } 
        }
    }

	
  ?>

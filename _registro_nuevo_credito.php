<?php
	session_start(); // crea una sesion
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	
	date_default_timezone_set('America/Mexico_City');

	if(!isset($_SESSION['id_usuario'])){
		header('Location: index.php');
	}else{
		if(!isset($_POST['folio'])){
			header('Location: nuevo-prestamo.php?info=2');
		}else{
			if(empty($_POST['folio'])){
				header('Location: nuevo-prestamo.php?info=3');
			}else{
				if($_POST['folio'] == 0){
					header('Location: nuevo-prestamo.php?info=4');
				}else{
					//INICIO Determinar si ya existe el folio indicado
					$folio = $_POST['folio'];
					$conocer_folio = "SELECT * FROM creditos WHERE folio = '$folio';";
					$iny_conocer_folio = mysqli_query($mysqli,$conocer_folio) or die(mysqli_error());
					if(mysqli_num_rows($iny_conocer_folio)<=0){
						$fecha = date("Y-m-d");
					  	$hora = date("G:i:s");
						$usuario_captura = 	$_SESSION['id_usuario'];
					    $id_cliente			= $_POST['cliente'];
					    $fecha_inicial 		= $_POST['fecha-inicial'];
						$interes_mensual 		= $_POST['interes-mensual'];
						$interes_moratorio 		= $_POST['interes-moratorio'];
					    $monto_credito	= $_POST['monto-credito'];
						$pago_mensual	= $_POST['pago-mensual'];
						$competencia	= $_POST['competencia'];
						$comentario_credito = $_POST['comentario-credito'];
						$fechadealta = $_POST['fechadealta'];
						$infonavit = $_POST['infonavit'];
						$isseg = $_POST['isseg'];
						
						$monto_credito_anterior_amp = $_POST['monto-credito-anterior-amp'];
						$monto_credito_nuevo_amp = $_POST['monto-credito-nuevo-amp'];
						$query= "INSERT INTO creditos (
								id_cliente,
								fecha_captura,
								usuario_captura,
								fecha_prestamo,
								monto,
								interes,
								pago_mensual,
								poder_nombre,
								poder_file,
								id_inversionista,
								comentarios_inversionista,
								status,
								comentarios_credito,
								motivo_finalizacion_credito,
								comentario_finalizacion_credito,
								juzgado,
								expediente,
								etapa_procesal,
								convenio_nombre,
								convenio_file,
								folio,
								interes_moratorio,
								mutuo_nombre,
								mutuo_file,
								competencia,
								comentario_credito,
								fechadealta,
								infonavit,
								isseg,
								
								monto_credito_anterior_amp,
								monto_credito_nuevo_amp
								)
					   				VALUES
								('$id_cliente',
									'$fecha $hora',
									'$usuario_captura',
									'$fecha_inicial',
									'$monto_credito',
									'$interes_mensual',
									'$pago_mensual',
									'',
									'',
									'1',
									'',
									'1',
									'',
									'',
									'',
									'',
									'',
									'',
									'',
									'',
									'$folio',
									'$interes_moratorio',
									'',
									'',
									'$competencia',
									'$comentario_credito',
									'$fechadealta',
									'$infonavit',
									'$isseg',
									
									'$monto_credito_anterior_amp',
									'$monto_credito_nuevo_amp'
					                )";

					    $resultado= mysqli_query($mysqli,$query) or die(mysqli_error());
					    $id_cliente_insertado = mysqli_insert_id();
						//Se inicializa la variable Credito para el proceso de registro
			            if(isset($_SESSION['id_credito'])){
		                    unset($_SESSION['id_credito']);
		                }
		                $_SESSION['id_credito'] = $id_cliente_insertado;

						//Se inicializa la variable Cliente para el proceso de registro
		                if(isset($_SESSION['id_cliente'])){
		                    unset($_SESSION['id_cliente']);
		                }
		                $_SESSION['id_cliente'] = $id_cliente;

						//Se inicializa la variable monto Credito para el proceso de registro en Inversionista
		                if(isset($_SESSION['monto_credito_registro_credito'])){
		                    unset($_SESSION['monto_credito_registro_credito']);
		                }
		                $_SESSION['ammount_new_loan'] = $monto_credito;

						if (is_uploaded_file($_FILES['poder']['tmp_name'])){
							$archivo1 = explode(".",$_FILES['poder']['name']);
							$nombre_archivo_original =  $_FILES['poder']['name'];
							$nombre_aleatorio1 = mt_rand(0,9).mt_rand(100,9999).mt_rand(100,9999);
							$extension = strtolower(array_pop($archivo1));
							$nombre_generado_archivo1 =  $nombre_aleatorio1.".".$extension;
							$ruta = 'files/creditos/poder/'.$nombre_generado_archivo1;
							move_uploaded_file($_FILES['poder']['tmp_name'], $ruta);
							chmod($ruta,0777);
							$actualizar_identificacion_oficial = "update creditos set poder_file='$ruta', poder_nombre ='$nombre_archivo_original' where id_creditos=$id_cliente_insertado;";
							$iny_consulta = mysqli_query($mysqli,$actualizar_identificacion_oficial) or die(mysqli_error());
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
							$actualizar_mutuo = "update creditos set mutuo_file='$ruta2', mutuo_nombre ='$nombre_archivo_original2' where id_creditos=$id_cliente_insertado;";
							$iny_consulta2 = mysqli_query($mysqli,$actualizar_mutuo) or die(mysqli_error());
						}

						$ruta = "nuevo-prestamo-avales.php?info=1&id=".$id_cliente_insertado."&cl=".$id_cliente;
						header('Location:'.$ruta);
					}else{
						header('Location: nuevo-prestamo.php?info=2');
					}
				}
			}
		}
	}
  ?>

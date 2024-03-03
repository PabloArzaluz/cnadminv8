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
					$id_credito = $_POST['credito'];
					$conocer_folio = "SELECT * FROM creditos WHERE folio = '$folio';";
					$iny_conocer_folio = mysql_query($conocer_folio,$link) or die(mysql_error());
					if(mysql_num_rows($iny_conocer_folio)<=0){
						$query = "UPDATE creditos SET folio='$folio' where id_creditos='$id_credito';";
					    $resultado= mysql_query($query,$link) or die(mysql_error());
					    $ruta = "detalle-credito.php?info=1&id=".$id_credito;
						header('Location:'.$ruta);
					}else{
						header('Location: prestamos.php?info=1');
					}
				}
			}
		}
	}
  ?>

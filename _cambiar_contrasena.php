<?php
	session_start(); // crea una sesion
	error_reporting(E_ALL); ini_set("display_errors", 1);
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}

	$old_password =  $_POST['old-password'];
    $pass1 = $_POST['password1'];
    $pass2 = $_POST['password2'];
    $username = $_SESSION['id_usuario'];

    //Validar Contraseña Iguales
    if($pass1 != $pass2){
    	header('Location: page-profile.php?info=1');
    }else{

    }
	
	if($pass1 == $pass2){
		//Validar Contraseña Actual
		$conocer_contrasena = "select password from usuario where id_user='$username' and password ='$old_password';";
 		$validar_contrasena = mysqli_query($mysqli,$conocer_contrasena) or die(mysqli_error());
 		if(mysqli_num_rows($validar_contrasena)>0){
 			//Contraseña correcta cambiar password
 			$cambiar_contrasena = "UPDATE usuario SET password ='$pass1' where id_user='$username';";
 			$cambiar_contrasena_actual = mysqli_query($cambiar_contrasena,$link) or die(mysqli_error());
 			header('Location: page-profile.php?info=3');
 		}else{
 			//la contraseña no es la actual correcta
 			header('Location: page-profile.php?info=2');
 		}

	}
 ?>

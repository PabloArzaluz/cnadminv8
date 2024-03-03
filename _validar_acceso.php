<?php
	session_start(); // crea una sesion
	error_reporting(E_ALL); ini_set("display_errors", 1);
	//ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/funciones.php");
	$link = Conecta();
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}

	//echo $_POST['password'];
    $username= $_POST['user'];
    $pass = $_POST['password'];
    //$contraseña= md5($pass);

	$contrasena= $pass;
	$selecciona_usuario = "select * from usuario where username='$username' and password = '$contrasena' and status=1";
	$validar_acceso = mysqli_query($mysqli,$selecciona_usuario) or die(mysqli_error());

 	if(mysqli_num_rows($validar_acceso)>0){
		
 		$fila = mysqli_fetch_row($validar_acceso);

		//Validar Permiso a Portal Administrativo
		if($fila[9] != 1){
			//Sin permiso a portal Administrativo
			
			header('Location: index.php?alert=1&det=SAA');
			return 0; 
		}

 		$_SESSION['id_usuario'] = $fila[0];
 		$_SESSION['level_user'] = $fila[4];
		$_SESSION['nombre_user'] = $fila[5];
		//Registra acceso en BD
		$query_registrarLogAcceso = "INSERT INTO logacceso(idUser,horaacceso) values(".$fila[0].",'".horafecha()."');";
		$registrarLogAcceso = mysqli_query($mysqli,$query_registrarLogAcceso) or die (mysqli_error());
		$query_registrarLastLogin = "UPDATE usuario set lastLogin='".horafecha()."' WHERE id_user='".$fila[0]."';";
		$registrarLastLogin = mysqli_query($mysqli,$query_registrarLastLogin) or die (mysqli_error());
		//Fin Registra Acceso en BD
		
		//Genera Permisos
		$selecciona_permisos = "select * from permisos where idUsuario='".$fila[0]."';";
		$iny_selecciona_permisos =  mysqli_query($selecciona_permisos,$link) or die(mysqli_error());
		$filaPermisos = mysqli_fetch_assoc($iny_selecciona_permisos);
		$_SESSION['permisos_modulos'] = $filaPermisos;
		
		
 		header('Location: dashboard.php');

 	}else{
 		header('Location: index.php?alert=1');
 	}
 ?>

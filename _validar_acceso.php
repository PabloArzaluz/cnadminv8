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
	$validar_acceso = mysql_query($selecciona_usuario,$link) or die(mysql_error());

 	if(mysql_num_rows($validar_acceso)>0){
		
 		$fila = mysql_fetch_row($validar_acceso);

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
		$registrarLogAcceso = mysql_query($query_registrarLogAcceso,$link) or die (mysql_error());
		$query_registrarLastLogin = "UPDATE usuario set lastLogin='".horafecha()."' WHERE id_user='".$fila[0]."';";
		$registrarLastLogin = mysql_query($query_registrarLastLogin,$link) or die (mysql_error());
		//Fin Registra Acceso en BD
		
		//Genera Permisos
		$selecciona_permisos = "select * from permisos where idUsuario='".$fila[0]."';";
		$iny_selecciona_permisos =  mysql_query($selecciona_permisos,$link) or die(mysql_error());
		$filaPermisos = mysql_fetch_assoc($iny_selecciona_permisos);
		$_SESSION['permisos_modulos'] = $filaPermisos;
		
		
 		header('Location: dashboard.php');

 	}else{
 		header('Location: index.php?alert=1');
 	}
 ?>

<?php
	session_start(); // crea una sesion
	include("include/configuration.php");
	
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/funciones.php");
	
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}

	if(isset($_POST['user'])){
		
		$username= $_POST['user'];
		$pass = $_POST['password'];
		//$contraseña= md5($pass);
	
		//procedural 
		$mysqliConnProc   = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
		$stmt = $mysqliConnProc->prepare("SELECT id_user,level,nombre,accesoAdministrativo from usuario where username=? and password = ? and status=1 limit 1");
		$stmt->bind_param("ss",$username,$pass);
		$stmt->execute();
		$stmt->bind_result($id_usuario,$nivel_user,$nombre_user,$permisoPortalAdmin);
		$stmt->store_result();
	
		if($stmt->num_rows == 1){
			while($stmt->fetch()){
				if($permisoPortalAdmin != 1){
					//Sin permiso a portal Administrativo
					header('Location: index.php?alert=1&det=SAA');
					return 0; 
				}
			//Hay coincodencia
			$_SESSION['id_usuario'] = $id_usuario;
			 $_SESSION['level_user'] = $nivel_user;
			$_SESSION['nombre_user'] = $nombre_user;
			
			//Registra acceso en BD
			$query_registrarLogAcceso = "INSERT INTO logacceso(idUser,horaacceso) values(".$id_usuario.",'".horafecha()."');";
			$registrarLogAcceso = mysqli_query($mysqli,$query_registrarLogAcceso) or die (mysqli_error());
			$query_registrarLastLogin = "UPDATE usuario set lastLogin='".horafecha()."' WHERE id_user='".$id_usuario."';";
			$registrarLastLogin = mysqli_query($mysqli,$query_registrarLastLogin) or die (mysqli_error());
			//Fin Registra Acceso en BD
			
			//Genera Permisos
			$selecciona_permisos = "select * from permisos where idUsuario='".$id_usuario."';";
			$iny_selecciona_permisos =  mysqli_query($mysqli,$selecciona_permisos) or die(mysqli_error());
			$filaPermisos = mysqli_fetch_assoc($iny_selecciona_permisos);
			$_SESSION['permisos_modulos'] = $filaPermisos;
			 header('Location: dashboard.php');
			}
		}else{
			header('Location: index.php?alert=1');
		}
		$stmt->close();
	}else{
		//No se recibieron datos POST
		header('Location: index.php');
	}
	
 ?>

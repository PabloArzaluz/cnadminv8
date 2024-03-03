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
    if(validarAccesoModulos('permiso_agregar_cuentas_bancarias') != 1) {
		header("Location: dashboard.php");
        return 0;
	}
	$fecha = date("Y-m-d");
  	$hora = date("G:i:s");

    $banco			    = $_POST['banco'];
    $titular            = $_POST['titular'];
    $numerocuenta 	    = $_POST['numerocuenta'];
    $cuenta 		    = $_POST['clabe'];
    $fecharegistro      = $fecha." ".$hora;
    $usuario_registro   = $_SESSION['id_usuario'];

    
    $query = "INSERT INTO 
                    cuentas_bancarias_pago(banco,titular,numero_cuenta,clabe,status,fecha_registro,usuario_registro) 
                    VALUES(
                        '$banco',
                        '$titular',
                        '$numerocuenta',
                        '$clabe',
                        1,
                        '$fecharegistro',
                        '$usuario_registro'
                    );";
    $resultado= mysql_query($query,$link) or die(mysql_error());
	//$id_cliente = mysql_insert_id();
    //unset($_SESSION['id_cliente']);
    //unset($_SESSION['id_credito']);
    header('Location: cuentas-bancarias.php?info=1');
?>


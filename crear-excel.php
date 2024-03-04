<?php
    session_start(); // crea una sesion
    include("include/configuration.php");
    include("conf/conecta.inc.php");
	include("conf/config.inc.php");
    
	header("Content-Type: application/xls");    
	header("Content-Disposition: attachment; filename=documento_exportado_" . date('Y:m:d:m:s').".xls");
	header("Pragma: no-cache"); 
	header("Expires: 0");

	
	
	$output = $_SESSION['reporte-intereses-ri'];
		
		echo $output;
	
	
?>
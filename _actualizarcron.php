<?php
	session_start(); // crea una sesion
	ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	$link = Conecta();
	date_default_timezone_set('America/Mexico_City');
	$date_actual = date("Y-m-d");
	$hora = date('H:i:s');

	function obtenerDireccionIP()
{
    if (!empty($_SERVER ['HTTP_CLIENT_IP'] ))
      $ip=$_SERVER ['HTTP_CLIENT_IP'];
    elseif (!empty($_SERVER ['HTTP_X_FORWARDED_FOR'] ))
      $ip=$_SERVER ['HTTP_X_FORWARDED_FOR'];
    else
      $ip=$_SERVER ['REMOTE_ADDR'];

    return $ip;
}


	//Conocer Saldo al dia de hoy hasta el final del mes. 
	$query_ConocerInteresesPrevistosHastaFinMes = "SELECT DAY(fechapago) as fecha_pago, ROUND(SUM(pagointeres),2) AS total_intereses_previstos FROM saldos_creditos_activos WHERE EXTRACT(DAY FROM fechapago) >= EXTRACT(DAY FROM CURDATE()) GROUP BY fecha_pago order by fecha_pago asc;";
	$iny_ConocerInteresesPrevistosHastaFinMes = mysqli_query($mysqli,$query_ConocerInteresesPrevistosHastaFinMes) or die ('Unable to execute query. '. mysqli_error($mysqli));
	//$f_ConocerInteresesPrevistosHastaFinMes = mysqli_fetch_assoc($iny_ConocerInteresesPrevistosHastaFinMes);
	$arraytJSON = array();
	$sumaInteresesPrevistos = "";
	while($f_ConocerInteresesPrevistosHastaFinMes = mysqli_fetch_assoc($iny_ConocerInteresesPrevistosHastaFinMes)){
		$arraytJSON[] = $f_ConocerInteresesPrevistosHastaFinMes;
		 $sumaInteresesPrevistos  += $f_ConocerInteresesPrevistosHastaFinMes['total_intereses_previstos'];
}
	$sumaInteresesPrevistos;
	$jsonEncode =  json_encode($arraytJSON);

	$qry_insertaHistoricoPagoIntereses = "INSERT INTO hist_calc_int_payments(datetime,monto_a_fin_mes,json_result) VALUES('".$date_actual." ".$hora."','".$sumaInteresesPrevistos."','".$jsonEncode."');";
	$iny_insertaHistoricoPagoIntereses = mysqli_query($mysqli,$qry_insertaHistoricoPagoIntereses) or die ('Unable to execute query. '. mysqli_error($mysqli));
	
	//Historial de Ejecucaciones de Script
	$actualizar_alerta_credito_eliminar = "INSERT INTO inserciones_automaticas(datetimes,dirip) VALUES('".$date_actual." ".$hora."' ,'".obtenerDireccionIP()."');";
	$iny_actualizar_alerta_credito_eliminar = mysqli_query($mysqli,$actualizar_alerta_credito_eliminar) or die ('Unable to execute query. '. mysqli_error($mysqli));
		
  ?>

<?php

	session_start(); // crea una sesion
	ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
	date_default_timezone_set('America/Mexico_City');
	setlocale(LC_ALL, 'es_MX.UTF-8');

	include("../conf/conecta.inc.php");
	include("../conf/config.inc.php");
	$link = Conecta();
    if($_REQUEST){
        $monto 	= $_REQUEST['monto']; //monto
        $tipoPago 	= $_REQUEST['tipo']; //tipo de PAgo
        $credito 	= $_REQUEST['credito']; //tipo de PAgo  

        $InformacionCredito = "SELECT
                                    c.id_creditos,
                                    c.monto as monto_credito,
                                    c.monto - COALESCE(SUM(CASE WHEN p.tipo_pago = 2 THEN p.monto ELSE 0 END), 0) AS saldo_credito,
                                    c.interes
                                FROM
                                    creditos c
                                LEFT JOIN
                                    pagos p ON c.id_creditos = p.id_credito where id_creditos=$credito";
        $iny_InformacionCredito = mysql_query($InformacionCredito, $link) or die(mysql_error());
        $f_InformacionCredito = mysql_fetch_assoc($iny_InformacionCredito); 
        $monto_a_pagar_regular = ($f_InformacionCredito["saldo_credito"]/100)*$f_InformacionCredito["interes"];
        $excedente = $monto - $monto_a_pagar_regular;
        
        echo json_encode(array("monto_pago"=>$monto,"tipo_pago"=>$tipoPago,"tipo_pago"=>$credito,"monto_credito"=>$f_InformacionCredito["monto_credito"],"saldo_credito"=>$f_InformacionCredito["saldo_credito"],"interes"=>$f_InformacionCredito["interes"],"monto_pagar_regular"=>$monto_a_pagar_regular,"excedente"=>$excedente));
}



?>
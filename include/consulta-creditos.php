<?php
 
echo '<select class="form-control" name="credito" id="credito">';
ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
include("../conf/conecta.inc.php");
include("../conf/config.inc.php");
$link = Conecta();
$consulta= "SELECT creditos.id_creditos,creditos.id_inversionista,clientes.nombres,clientes.apaterno,clientes.amaterno,creditos.fecha_prestamo,creditos.monto,creditos.folio FROM creditos INNER JOIN clientes on clientes.id_clientes = creditos.id_cliente ORDER BY creditos.folio desc;"; 
$resultado= mysql_query($consulta,$link) or die (mysql_error());
?>
<option value="">Seleccione un Credito</option>
<?php
while($fila = mysql_fetch_array($resultado)){
	//CONOCER SALDO CREDITOS
	$conocer_pagos_inversionista = "SELECT SUM(monto) FROM pinversionistas WHERE TIPO_PAGO='capital' AND id_credito = ".$fila[0].";";
	$iny_conocer_pagos_inversionista  = mysql_query($conocer_pagos_inversionista,$link) or die(mysql_error());
	$f_SumaPagoInversionista = mysql_fetch_row($iny_conocer_pagos_inversionista);
	$monto_credito = $fila[6];
	$saldoRestante = $monto_credito - $f_SumaPagoInversionista[0];
	//FIN SALDO CREDITOS
		if($fila[1] == $_GET['c']){
			if($saldoRestante > 0 ){
				echo "<option value='".$fila[0]."'> ".$fila[7]." - ".$fila[3]." ".$fila[4]." ".$fila[2]." (".date("d/m/Y",strtotime($fila[5])).") $".number_format(($fila[6]),2)." [Saldo Restante: $".number_format(($saldoRestante),2)."]</option>";;
			}
			
		}
	}

echo '</select>';

?>
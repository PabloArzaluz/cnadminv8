<?php
 
echo '<select class="form-control" name="credito" id="credito">';
include("include/configuration.php");
include("../conf/conecta.inc.php");
include("../conf/config.inc.php");

$consulta= "SELECT 
inversionistas_creditos.id_credito,
inversionistas_creditos.id_inversionista,
clientes.nombres, 
clientes.apaterno,
clientes.amaterno,
creditos.fecha_prestamo,
creditos.monto,
inversionistas_creditos.monto as montoasignadoinversionista,
creditos.folio
from inversionistas_creditos
inner join creditos on creditos.id_creditos = inversionistas_creditos.id_credito
inner join clientes on creditos.id_cliente = clientes.id_clientes ORDER BY creditos.folio asc;"; 
$resultado= mysqli_query($mysqli,$consulta) or die (mysqli_error());
?>
<option value="">Seleccione un Credito</option>
<?php
while($fila = mysqli_fetch_assoc($resultado)){
	//CONOCER SALDO CREDITOS
	$conocer_pagos_inversionista = "SELECT SUM(monto) FROM pinversionistas WHERE TIPO_PAGO='capital' AND id_credito = ".$fila['id_credito'].";";
	$iny_conocer_pagos_inversionista  = mysqli_query($mysqli,$conocer_pagos_inversionista) or die(mysqli_error());
	$f_SumaPagoInversionista = mysqli_fetch_row($iny_conocer_pagos_inversionista);
	$monto_credito = $fila['montoasignadoinversionista'];
	$saldoRestante = $monto_credito - $f_SumaPagoInversionista[0];
	//FIN SALDO CREDITOS
		if($fila['id_inversionista'] == $_GET['c']){
			if($saldoRestante > 0 ){
				echo "<option value='".$fila['id_credito']."'> ".$fila['folio']." - ".$fila['apaterno']." ".$fila['amaterno']." ".$fila['nombres']." (".date("d/m/Y",strtotime($fila['fecha_prestamo'])).") $".number_format(($fila['montoasignadoinversionista']),2)." [Saldo Restante: $".number_format(($saldoRestante),2)."]</option>";;
			}
			
		}
	}

echo '</select>';

?>
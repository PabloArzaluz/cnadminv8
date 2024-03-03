<?php
    include("conf/config.inc.php");

    


    function clientes_puntuales_obtener_ultimos_3_meses($credito){
        $newConn->mysqli;
		$consultar_credito = "select * from creditos where id_creditos = '$credito';";
		$iny_consultar_credito = mysqli_query($newConn,$consultar_credito) or die (mysqli_error());
		$fila_credito = mysqli_fetch_row($iny_consultar_credito);
		return $fila_credito;
    }
?>
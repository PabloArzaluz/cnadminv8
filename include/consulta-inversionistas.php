<?php
$consulta= "SELECT * FROM inversionistas where status='activo';"; 
$resultado= mysql_query($consulta,$link) or die (mysql_error());
 
while($fila = mysql_fetch_array($resultado)){
	echo "<option value='".$fila[0]."'>".$fila[1]."</option>";	
}
?>
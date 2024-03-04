<?php
$consulta= "SELECT * FROM inversionistas where status='activo';"; 
$resultado= mysqli_query($mysqli,$consulta) or die (mysqli_error());
 
while($fila = mysqli_fetch_array($resultado)){
	echo "<option value='".$fila[0]."'>".$fila[1]."</option>";	
}
?>
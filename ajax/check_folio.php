<?php
sleep(1);
include("../include/configuration.php");
include("../conf/config.inc.php");
if($_REQUEST)
{
	$username 	= $_REQUEST['username'];
	$query = "select * from creditos where folio = '".strtolower($username)."'";
	$results = mysqli_query($mysqli, $query) or die(mysqli_error());
	if($username == ""){
		echo '<span class="label label-warning"><input type="hidden" id="folio_validador" value="" required><i class="fa fa-exclamation-triangle fa-fw"></i> Introduce un numero de Credito</span><script type="text/javascript">document.getElementById("folio").value="";</script>';
	return 0;
	}
	if(mysqli_num_rows(@$results) > 0) // not available
	{
		echo '<span class="label label-danger"><input type="hidden" id="folio_validador" value=""><i class="fa fa-times fa-fw"></i> Numero de Credito ya Registrado</span><script type="text/javascript">document.getElementById("folio").value="";</script>';
	}
	else
	{
		echo '<span class="label label-success"><input type="hidden" id="folio_validador" value="0"><i class="fa fa-check fa-fw"></i> Numero de Credito Disponible</span>';
	}
	
}
?>
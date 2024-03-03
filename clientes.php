<?php
	session_start(); // crea una sesion
	ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	include("include/functions.php");
	$link = Conecta();
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
	$pagina_actual = "clientes";
	//Validar Permisos
	if(validarAccesoModulos('permiso_clientes') != 1) {
		header("Location: dashboard.php");
	}
	function acortar($texto,$largo) {
        if(strlen($texto) >= 20){
            return substr($texto,0,$largo).'...';
    	}else{
            return $texto;
        }
    }
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!-->
<html lang="es" class="no-js">
<!--<![endif]-->

<head>
	<title>Clientes | Credinieto</title>
	<?php
		include("include/head.php");
	?>
</head>

<body class="sidebar-fixed topnav-fixed ">
	<!-- WRAPPER -->
	<div id="wrapper" class="wrapper">
		<?php
			include("include/top-bar.php");
			include("include/left-sidebar.php");
		 ?>
		<!-- MAIN CONTENT WRAPPER -->
		<div id="main-content-wrapper" class="content-wrapper ">
			<div class="row">
				<div class="col-lg-4 ">
					<ul class="breadcrumb">
						<li><i class="fa fa-home"></i><a href="#">Inicio</a></li>
						<li><a href="#">Clientes</a></li>
						<li class="active">Activos</li>
					</ul>
				</div>

			</div>
			<!-- main -->
			<div class="content">
				<div class="main-header">
					<h2>Clientes</h2>
					<em>clientes registrados</em>
				</div>

				<div class="main-content">
					<!-- FEATURED DATA TABLE -->
					<div class="widget widget-table">
						<div class="widget-header">
							<h3><i class="fa fa-table"></i> Clientes</h3> <em> -  clientes regulares</em></div>
						<div class="widget-content">

							<?php
								//Operaciones
								if(isset($_GET['info'])){
									if($_GET['info'] == '2'){
										echo "<div class='alert alert-success'>
												<a href='' class='close'>&times;</a>
												<strong>Operacion Correcta.</strong> Se elimino correctamente el cliente
										</div>";
									}
									if($_GET['info'] == '1'){
										echo "<div class='alert alert-success'>
												<a href='' class='close'>&times;</a>
												<strong>Operacion Correcta.</strong> Se modifico correctamente el cliente
										</div>";
									}
									if($_GET['info'] == '3'){
											echo "<div class='alert alert-success'>
													<a href='' class='close'>&times;</a>
													<strong>Operacion Correcta.</strong> Se agrego correctamente el cliente
											</div>";
										}


								}
							 ?>

							<div class="col-lg-12 ">
								<div class="top-content">
									<a href="nuevo-cliente.php" type="button" class="btn btn-success"><i class="fa fa-plus-square"></i> Agregar Nuevo Cliente </a>
								</div>
							</div>
							<table id="featured-datatable" class="table table-sorting table-hover datatable">
								<thead>
									<tr>
										<!--<th># de Cliente</th>-->
										<th>Nombre Completo</th>
										<th>Direccion</th>
										<th>Telefonos</th>
										
										<th>Creditos / Activos</th>
                                        <th>Juridico</th>
										<th>Operaciones</th>
									</tr>
								</thead>
								<tbody>

									<?php
										//Consulta Cientes
										$iny_clientes = mysql_query("select * from clientes where status='activo';",$link) or die (mysql_error());
										if(mysql_num_rows($iny_clientes) > 0){
							              while($row = mysql_fetch_array($iny_clientes)){
												$nombre_completo = $row[1]." ".$row[2]." ".$row[3];
												$conocer_creditos = "SELECT  (SELECT COUNT(*)FROM   creditos where id_cliente = '".$row[0]."') AS total_creditos,(SELECT COUNT(*)FROM creditos where id_cliente = '".$row[0]."' and status= 1) AS total_activos,(SELECT COUNT(*)FROM creditos where id_cliente = '".$row[0]."' and status= 3) AS total_juridico;";
                                           		$iny_conocer_creditos = mysql_query($conocer_creditos,$link) or die(mysql_error());
				                            	$fcreditos = mysql_fetch_row($iny_conocer_creditos); 
							                if($fcreditos[2] > 0){
							                	echo "<tr class='danger'>";
							                }else{
							                	echo "<tr>";
							                }
							                
											echo "<td> <a href='cliente-profile.php?id=".$row[0]."'>".$nombre_completo."</a>";
											categoriaClienteHTML($row[16]);
											echo "</td>
							                <td><span class='top' data-toggle='tooltip' title='".$row[4]."' data-original-title='Tooltip on right'>".acortar($row[4],12)."</span></td>


							                <td><span class='top' data-toggle='tooltip' title='".$row[5]."'data-original-title='Tooltip on right'>".acortar($row[5],20)."</span></td>
											
											<td><center>";
                                             
                                              echo $fcreditos[0]." / ".$fcreditos[1];
                                              echo "</center></td>
                                              ";
                                              if($fcreditos[2] > 0){
                                                echo "<td><span class='badge red-bg'>$fcreditos[2]</span></td>";  
                                              }else{
                                                   echo "<td><span class='badge'>$fcreditos[2]</span></td>";  
                                              }
                                              
                                                  echo "
							                <td> <a href='editar-cliente.php?id=$row[0]' type='button' class='btn btn-warning btn-xs'>Editar</a> <a href='eliminar_cliente.php?id=$row[0]' type='button' class='btn btn-danger btn-xs'>Eliminar</a></td></tr>";
							              }
							            }
										?>

								</tbody>
							</table>
						</div>
					</div>
					<!-- END FEATURED DATA TABLE -->
				</div>
			</div>
			<!-- /main -->
			<!-- FOOTER -->
			<footer class="footer">
				&copy; 2017 Syscom León
			</footer>
			<!-- END FOOTER -->
		</div>
		<!-- END CONTENT WRAPPER -->
	</div>
	<!-- END WRAPPER -->

	<!-- Javascript -->
	
	 <script src="assets/js/bootstrap/bootstrap.js"></script>
	 <script type="text/javascript">$(function(){$('[data-toggle="tooltip"]').tooltip()})</script>
   <script type="text/javascript">$(".top").tooltip({placement:"top"});</script>

	 <script type="text/javascript">
		 $(document).ready(function() {
		 $('#tablita').DataTable();
		 } );
		 $('#tablita').dataTable( {
     "order": [[ 2, "desc" ]]
} );
	 </script>
<?php
		include("include/footer-js.php")
	 ?>
</body>

</html>

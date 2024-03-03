<?php
	//Funcion para mostrar tipo de cliente
	function categoriaClienteHTML($categoriaCliente){
		//Devolver HTML de Cliente
		if($categoriaCliente == ""){
			$cadena = "";
		}
		if($categoriaCliente == '0'){ // Es clasico
			$cadena = " <span class='texto-peque'><i style='color:#bababa;' class='fa fa-leaf'> Clasico</i></span>";
		}
		if($categoriaCliente == 1 ){ // Es Dorado
			$cadena = " <span class='texto-peque'><i style='color:#CBBF00;' class='fa fa-fire'> Dorado</i></span>";
		}
		if($categoriaCliente == 2 ){ // Es Premium
			$cadena = " <span class='texto-peque'><i style='color:#2a2a2a;' class='fa fa-certificate'> Premium</i></span>";
		}
		echo $cadena;
	}

	function validarAccesoModulos($modulo){
		$arreglo_permisos = $_SESSION['permisos_modulos'];
		return $arreglo_permisos[$modulo];
		
	}

	function RestringirAccesoModulosNoPermitidos($modulo){
        $arreglo_permisos = $_SESSION['permisos_modulos'];
        if($arreglo_permisos[$modulo] != 1){
            header("Location: dashboard.php");
        }
	}



	
?>

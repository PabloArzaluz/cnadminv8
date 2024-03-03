<?php
	session_start(); // crea una sesion
	ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	$link = Conecta();
	date_default_timezone_set('America/Mexico_City');
	$date_actual = date("Y-m-d");
	$hora = date('H:i:s');

	
	if(!isset($_SESSION['id_usuario'])){
		header('Location: index.php');
	}else{
        
        $idUsuario = $_POST['idUsuario'];

        //Permiso Pagos
        if(filter_has_var(INPUT_POST,'permiso_pagos')) {
			$permiso_pagos = 1;
        }else{
            $permiso_pagos = 0;
        }
		$actualiza_permiso_pagos  = "UPDATE permisos SET permiso_pagos=$permiso_pagos WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_pagos = mysqli_query($mysqli,$actualiza_permiso_pagos) or die ('Unable to execute query. '. mysqli_error($mysqli));
        
		//permiso_inversionistas
        if(filter_has_var(INPUT_POST,'permiso_inversionistas')) {
			$permiso_inversionistas=1;
        }else{
            $permiso_inversionistas=0;
        }
		$actualiza_permiso_inversionistas  = "UPDATE permisos SET permiso_inversionistas=$permiso_inversionistas WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_inversionistas = mysqli_query($mysqli,$actualiza_permiso_inversionistas) or die ('Unable to execute query. '. mysqli_error($mysqli));

		//ppermiso_clientes
        if(filter_has_var(INPUT_POST,'permiso_clientes')) {
			$permiso_clientes=1;
        }else{
            $permiso_clientes=0;
        }
		$actualiza_permiso_clientes  = "UPDATE permisos SET permiso_clientes=$permiso_clientes WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_clientes = mysqli_query($mysqli,$actualiza_permiso_clientes) or die ('Unable to execute query. '. mysqli_error($mysqli));

		//permiso_prestamos
        if(filter_has_var(INPUT_POST,'permiso_prestamos')) {
			$permiso_prestamos=1;
        }else{
            $permiso_prestamos=0;
        }
		$actualiza_permiso_prestamos  = "UPDATE permisos SET permiso_prestamos=$permiso_prestamos WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_prestamos = mysqli_query($mysqli,$actualiza_permiso_prestamos) or die ('Unable to execute query. '. mysqli_error($mysqli));
		
		//permiso_clientespuntuales
        if(filter_has_var(INPUT_POST,'permiso_clientespuntuales')) {
			$permiso_clientespuntuales=1;
        }else{
            $permiso_clientespuntuales=0;
        }
		$actualiza_permiso_clientespuntuales  = "UPDATE permisos SET permiso_clientespuntuales=$permiso_clientespuntuales WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_clientespuntuales = mysqli_query($mysqli,$actualiza_permiso_clientespuntuales) or die ('Unable to execute query. '. mysqli_error($mysqli));

		//permiso_permisos
        if(filter_has_var(INPUT_POST,'permiso_permisos')) {
			$permiso_permisos=1;
        }else{
            $permiso_permisos=0;
        }
		$actualiza_permiso_permisos  = "UPDATE permisos SET permiso_permisos=$permiso_permisos WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_permisos = mysqli_query($mysqli,$actualiza_permiso_permisos) or die ('Unable to execute query. '. mysqli_error($mysqli));

		//permiso_buscar
        if(filter_has_var(INPUT_POST,'permiso_buscar')) {
			$permiso_buscar=1;
        }else{
            $permiso_buscar=0;
        }
		$actualiza_permiso_buscar  = "UPDATE permisos SET permiso_buscar=$permiso_buscar WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_buscar = mysqli_query($mysqli,$actualiza_permiso_buscar) or die ('Unable to execute query. '. mysqli_error($mysqli));

		//permiso_ver_inversionista_credito
        if(filter_has_var(INPUT_POST,'permiso_ver_inversionista_credito')) {
			$permiso_ver_inversionista_credito=1;
        }else{
            $permiso_ver_inversionista_credito=0;
        }
		$actualiza_permiso_ver_inversionista_credito  = "UPDATE permisos SET permiso_ver_inversionista_credito=$permiso_ver_inversionista_credito WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_ver_inversionista_credito = mysqli_query($mysqli,$actualiza_permiso_ver_inversionista_credito) or die ('Unable to execute query. '. mysqli_error($mysqli));

		//permiso_eliminar_pagos
        if(filter_has_var(INPUT_POST,'permiso_eliminar_pagos')) {
			$permiso_eliminar_pagos=1;
        }else{
            $permiso_eliminar_pagos=0;
        }
		$actualiza_permiso_eliminar_pagos  = "UPDATE permisos SET permiso_eliminar_pagos=$permiso_eliminar_pagos WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_eliminar_pagos = mysqli_query($mysqli,$actualiza_permiso_eliminar_pagos) or die ('Unable to execute query. '. mysqli_error($mysqli));

		//permiso_alertas_credito
        if(filter_has_var(INPUT_POST,'permiso_alertas_credito')) {
			$permiso_alertas_credito=1;
        }else{
            $permiso_alertas_credito=0;
        }
		$actualiza_permiso_alertas_credito  = "UPDATE permisos SET permiso_alertas_credito=$permiso_alertas_credito WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_alertas_credito = mysqli_query($mysqli,$actualiza_permiso_alertas_credito) or die ('Unable to execute query. '. mysqli_error($mysqli));

		//permiso_crear_avales
        if(filter_has_var(INPUT_POST,'permiso_crear_avales')) {
			$permiso_crear_avales=1;
        }else{
            $permiso_crear_avales=0;
        }
		$actualiza_permiso_crear_avales  = "UPDATE permisos SET permiso_crear_avales=$permiso_crear_avales WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_crear_avales = mysqli_query($mysqli,$actualiza_permiso_crear_avales) or die ('Unable to execute query. '. mysqli_error($mysqli));

		//permiso_editar_avales
        if(filter_has_var(INPUT_POST,'permiso_editar_avales')) {
			$permiso_editar_avales=1;
        }else{
            $permiso_editar_avales=0;
        }
		$actualiza_permiso_editar_avales  = "UPDATE permisos SET permiso_editar_avales=$permiso_editar_avales WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_editar_avales = mysqli_query($mysqli,$actualiza_permiso_editar_avales) or die ('Unable to execute query. '. mysqli_error($mysqli));

		//permiso_eliminar_avales
        if(filter_has_var(INPUT_POST,'permiso_eliminar_avales')) {
			$permiso_eliminar_avales=1;
        }else{
            $permiso_eliminar_avales=0;
        }
		$actualiza_permiso_eliminar_avales  = "UPDATE permisos SET permiso_eliminar_avales=$permiso_eliminar_avales WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_eliminar_avales = mysqli_query($mysqli,$actualiza_permiso_eliminar_avales) or die ('Unable to execute query. '. mysqli_error($mysqli));


		//permiso_reportes_grafica_pagos_mensuales
        if(filter_has_var(INPUT_POST,'permiso_reportes_grafica_pagos_mensuales')) {
			$permiso_reportes_grafica_pagos_mensuales=1;
        }else{
            $permiso_reportes_grafica_pagos_mensuales=0;
        }
		$actualiza_permiso_reportes_grafica_pagos_mensuales  = "UPDATE permisos SET permiso_reportes_grafica_pagos_mensuales=$permiso_reportes_grafica_pagos_mensuales WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_reportes_grafica_pagos_mensuales = mysqli_query($mysqli,$actualiza_permiso_reportes_grafica_pagos_mensuales) or die ('Unable to execute query. '. mysqli_error($mysqli));

		//permiso_reportes_historico_cobranza
        if(filter_has_var(INPUT_POST,'permiso_reportes_historico_cobranza')) {
			$permiso_reportes_historico_cobranza=1;
        }else{
            $permiso_reportes_historico_cobranza=0;
        }
		$actualiza_permiso_reportes_historico_cobranza  = "UPDATE permisos SET permiso_reportes_historico_cobranza=$permiso_reportes_historico_cobranza WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_reportes_historico_cobranza = mysqli_query($mysqli,$actualiza_permiso_reportes_historico_cobranza) or die ('Unable to execute query. '. mysqli_error($mysqli));

		//permiso_reportes_de_pago
        if(filter_has_var(INPUT_POST,'permiso_reportes_de_pago')) {
			$permiso_reportes_de_pago=1;
        }else{
            $permiso_reportes_de_pago=0;
        }
		$actualiza_permiso_reportes_de_pago  = "UPDATE permisos SET permiso_reportes_de_pago=$permiso_reportes_de_pago WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_reportes_de_pago = mysqli_query($mysqli,$actualiza_permiso_reportes_de_pago) or die ('Unable to execute query. '. mysqli_error($mysqli));

		//permiso_reportes_r_i
        if(filter_has_var(INPUT_POST,'permiso_reportes_r_i')) {
			$permiso_reportes_r_i=1;
        }else{
            $permiso_reportes_r_i=0;
        }
		$actualiza_permiso_reportes_r_i  = "UPDATE permisos SET permiso_reportes_r_i=$permiso_reportes_r_i WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_reportes_r_i = mysqli_query($mysqli,$actualiza_permiso_reportes_r_i) or die ('Unable to execute query. '. mysqli_error($mysqli));

		//permiso_reportes_prestamos
        if(filter_has_var(INPUT_POST,'permiso_reportes_prestamos')) {
			$permiso_reportes_prestamos=1;
        }else{
            $permiso_reportes_prestamos=0;
        }
		$actualiza_permiso_reportes_prestamos  = "UPDATE permisos SET permiso_reportes_prestamos=$permiso_reportes_prestamos WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_reportes_prestamos = mysqli_query($mysqli,$actualiza_permiso_reportes_prestamos) or die ('Unable to execute query. '. mysqli_error($mysqli));

		//permiso_dashboard_indicador_creditosmes
        if(filter_has_var(INPUT_POST,'permiso_dashboard_indicador_creditosmes')) {
			$permiso_dashboard_indicador_creditosmes=1;
        }else{
            $permiso_dashboard_indicador_creditosmes=0;
        }
		$actualiza_permiso_dashboard_indicador_creditosmes  = "UPDATE permisos SET permiso_dashboard_indicador_creditosmes=$permiso_dashboard_indicador_creditosmes WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_dashboard_indicador_creditosmes = mysqli_query($mysqli,$actualiza_permiso_dashboard_indicador_creditosmes) or die ('Unable to execute query. '. mysqli_error($mysqli));

        //permiso_agregar_inmuebles
        if(filter_has_var(INPUT_POST,'permiso_agregar_inmuebles')) {
			$permiso_agregar_inmuebles=1;
        }else{
            $permiso_agregar_inmuebles=0;
        }
		$actualiza_permiso_agregar_inmuebles  = "UPDATE permisos SET permiso_agregar_inmuebles=$permiso_agregar_inmuebles WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_agregar_inmuebles = mysqli_query($mysqli,$actualiza_permiso_agregar_inmuebles) or die ('Unable to execute query. '. mysqli_error($mysqli));

        //permiso_agregar_cuentas_bancarias
        if(filter_has_var(INPUT_POST,'permiso_agregar_cuentas_bancarias')) {
			$permiso_agregar_cuentas_bancarias=1;
        }else{
            $permiso_agregar_cuentas_bancarias=0;
        }
		$actualiza_permiso_agregar_cuentas_bancarias  = "UPDATE permisos SET permiso_agregar_cuentas_bancarias=$permiso_agregar_cuentas_bancarias WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_agregar_cuentas_bancarias = mysqli_query($mysqli,$actualiza_permiso_agregar_cuentas_bancarias) or die ('Unable to execute query. '. mysqli_error($mysqli));

        //permiso_ver_documentacion_expediente
        if(filter_has_var(INPUT_POST,'permiso_ver_documentacion_expediente')) {
			$permiso_ver_documentacion_expediente=1;
        }else{
            $permiso_ver_documentacion_expediente=0;
        }
		$actualiza_permiso_ver_documentacion_expediente  = "UPDATE permisos SET permiso_ver_documentacion_expediente=$permiso_ver_documentacion_expediente WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_ver_documentacion_expediente = mysqli_query($mysqli,$actualiza_permiso_ver_documentacion_expediente) or die ('Unable to execute query. '. mysqli_error($mysqli));

        //permiso_editar_documentacion_expediente
        if(filter_has_var(INPUT_POST,'permiso_editar_documentacion_expediente')) {
			$permiso_editar_documentacion_expediente=1;
        }else{
            $permiso_editar_documentacion_expediente=0;
        }
		$actualiza_permiso_editar_documentacion_expediente  = "UPDATE permisos SET permiso_editar_documentacion_expediente=$permiso_editar_documentacion_expediente WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_editar_documentacion_expediente = mysqli_query($mysqli,$actualiza_permiso_editar_documentacion_expediente) or die ('Unable to execute query. '. mysqli_error($mysqli));

        //permiso_operaciones_adicionales_credito
        if(filter_has_var(INPUT_POST,'permiso_operaciones_adicionales_credito')) {
			$permiso_operaciones_adicionales_credito=1;
        }else{
            $permiso_operaciones_adicionales_credito=0;
        }
		$actualiza_permiso_operaciones_adicionales_credito  = "UPDATE permisos SET permiso_operaciones_adicionales_credito=$permiso_operaciones_adicionales_credito WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_operaciones_adicionales_credito = mysqli_query($mysqli,$actualiza_permiso_operaciones_adicionales_credito) or die ('Unable to execute query. '. mysqli_error($mysqli));

        //permiso_ver_detalle_credito_historial_inversionista
        if(filter_has_var(INPUT_POST,'permiso_ver_detalle_credito_info_adicional_inversionista')) {
			$permiso_ver_detalle_credito_info_adicional_inversionista=1;
        }else{
            $permiso_ver_detalle_credito_info_adicional_inversionista=0;
        }
		$actualiza_permiso_ver_detalle_credito_info_adicional_inversionista  = "UPDATE permisos SET permiso_ver_detalle_credito_info_adicional_inversionista=$permiso_ver_detalle_credito_info_adicional_inversionista WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_ver_detalle_credito_info_adicional_inversionista = mysqli_query($mysqli,$actualiza_permiso_ver_detalle_credito_info_adicional_inversionista) or die ('Unable to execute query. '. mysqli_error($mysqli));

        //permiso_editar_monto_credito
        if(filter_has_var(INPUT_POST,'permiso_editar_monto_credito')) {
			$permiso_editar_monto_credito=1;
        }else{
            $permiso_editar_monto_credito=0;
        }
		$actualiza_permiso_editar_monto_credito  = "UPDATE permisos SET permiso_editar_monto_credito=$permiso_editar_monto_credito WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_editar_monto_credito = mysqli_query($mysqli,$actualiza_permiso_editar_monto_credito) or die ('Unable to execute query. '. mysqli_error($mysqli));

        //permiso_inversionistas_editar
        if(filter_has_var(INPUT_POST,'permiso_inversionistas_editar')) {
			$permiso_inversionistas_editar=1;
        }else{
            $permiso_inversionistas_editar=0;
        }
		$actualiza_permiso_inversionistas_editar  = "UPDATE permisos SET permiso_inversionistas_editar=$permiso_inversionistas_editar WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_inversionistas_editar = mysqli_query($mysqli,$actualiza_permiso_inversionistas_editar) or die ('Unable to execute query. '. mysqli_error($mysqli));

        //permiso_inversionistas_crear
        if(filter_has_var(INPUT_POST,'permiso_inversionistas_crear')) {
			$permiso_inversionistas_crear=1;
        }else{
            $permiso_inversionistas_crear=0;
        }
		$actualiza_permiso_inversionistas_crear  = "UPDATE permisos SET permiso_inversionistas_crear=$permiso_inversionistas_crear WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_inversionistas_crear = mysqli_query($mysqli,$actualiza_permiso_inversionistas_crear) or die ('Unable to execute query. '. mysqli_error($mysqli));

        //permiso_inversionistas_cambiar_credito
        if(filter_has_var(INPUT_POST,'permiso_inversionistas_cambiar_credito')) {
			$permiso_inversionistas_cambiar_credito=1;
        }else{
            $permiso_inversionistas_cambiar_credito=0;
        }
		$actualiza_permiso_inversionistas_cambiar_credito  = "UPDATE permisos SET permiso_inversionistas_cambiar_credito=$permiso_inversionistas_cambiar_credito WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_inversionistas_cambiar_credito = mysqli_query($mysqli,$actualiza_permiso_inversionistas_cambiar_credito) or die ('Unable to execute query. '. mysqli_error($mysqli));

        //ppermiso_credito_editar_informacion_basica
        if(filter_has_var(INPUT_POST,'permiso_credito_editar_informacion_basica')) {
			$permiso_credito_editar_informacion_basica=1;
        }else{
            $permiso_credito_editar_informacion_basica=0;
        }
		$actualiza_permiso_credito_editar_informacion_basica  = "UPDATE permisos SET permiso_credito_editar_informacion_basica=$permiso_credito_editar_informacion_basica WHERE idUsuario = '$idUsuario';";
        $iny_actualiza_permiso_credito_editar_informacion_basica = mysqli_query($mysqli,$actualiza_permiso_credito_editar_informacion_basica) or die ('Unable to execute query. '. mysqli_error($mysqli));


        //Redirige
        $ruta_redirect = "permisos.php?usuario=".$idUsuario."&estado=1";
		header('Location: '.$ruta_redirect);

	}
  ?>

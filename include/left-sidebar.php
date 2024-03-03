<!-- LEFT SIDEBAR -->
<div id="left-sidebar" class="left-sidebar ">
    <!-- main-nav -->
    <div class="sidebar-scroll">
        <nav class="main-nav">
            <ul class="main-menu">
                <li <?php if(isset($pagina_actual)){if($pagina_actual == "dashboard"){echo "class='active'";}}?>><a href="dashboard.php"><i class="fa fa-dashboard fa-fw"></i><span class="text">Dashboard </span></a></li>
                <?php
					if(validarAccesoModulos('permiso_clientes') == 1) {
				?>
                <li <?php if(isset($pagina_actual)){if($pagina_actual == "clientes" || $pagina_actual == "cliente-juridico"){echo "class='active'";}}?>><a href="#" class="js-sub-menu-toggle"><i class="fa fa-users"></i><span class="text">Clientes</span>
							<i class="toggle-icon fa fa-angle-left"></i></a>
					<ul class="sub-menu <?php if(isset($pagina_actual)){if($pagina_actual == "clientes" || $pagina_actual == "clientes-juridico"){echo "open";}}?>">
						<li <?php if(isset($pagina_actual)){if($pagina_actual == "clientes"){echo "class='active'";}}?>><a href="clientes.php"><span class="text">Clientes</span></a></li>
						<li <?php if(isset($pagina_actual)){if($pagina_actual == "clientes-juridico"){echo "class='active'";}}?>><a href="clientes-juridico.php"><span class="text">Clientes en Juridico</span></a></li>
				    </ul>
				</li>
				<?php } ?>
				<?php
					if(validarAccesoModulos('permiso_prestamos') == 1){
				?>
                <li <?php if(isset($pagina_actual)){if($pagina_actual == "prestamos" || $pagina_actual == "prestamos-juridico" || $pagina_actual == "prestamos-vendidos" || $pagina_actual == "prestamos-infonavit" || $pagina_actual == "prestamos-isseg"){echo "class='active'";}}?>><a href="#" class="js-sub-menu-toggle"><i class="fa fa-balance-scale" aria-hidden="true"></i><span class="text">Prestamos</span>
							<i class="toggle-icon fa fa-angle-left"></i></a>
					<ul class="sub-menu <?php if(isset($pagina_actual)){if($pagina_actual == "prestamos" || $pagina_actual == "prestamos-juridico" || $pagina_actual == "prestamos-vendidos" || $pagina_actual == "prestamos-infonavit" || $pagina_actual == "prestamos-isseg"){echo "open";}}?>">
						<li <?php if(isset($pagina_actual)){if($pagina_actual == "prestamos"){echo "class='active'";}}?>><a href="prestamos.php"><span class="text">Prestamos</span></a></li>
						<li <?php if(isset($pagina_actual)){if($pagina_actual == "prestamos-juridico"){echo "class='active'";}}?>><a href="prestamos-juridico.php"><span class="text">Prestamos en Juridico</span></a></li>
						<li <?php if(isset($pagina_actual)){if($pagina_actual == "prestamos-vendidos"){echo "class='active'";}}?>><a href="prestamos-vendidos.php"><span class="text">Prestamos Vendidos</span></a></li>
						<li <?php if(isset($pagina_actual)){if($pagina_actual == "prestamos-infonavit"){echo "class='active'";}}?>><a href="prestamos-infonavit.php"><span class="text">Prestamos INFONAVIT</span></a></li>
						<li <?php if(isset($pagina_actual)){if($pagina_actual == "prestamos-isseg"){echo "class='active'";}}?>><a href="prestamos-isseg.php"><span class="text">Prestamos ISSEG</span></a></li>
				    </ul>
				</li>

				<?php } ?>
                <?php
					if(validarAccesoModulos('permiso_inversionistas') == 1){
				?>
                <li <?php if(isset($pagina_actual)){if($pagina_actual == "inversionistas" || $pagina_actual == "pagos-inversionistas"){echo "class='active'";}}?>><a href="#" class="js-sub-menu-toggle"><i class="fa fa-usd" aria-hidden="true"></i><span class="text">Inversionistas</span>
							<i class="toggle-icon fa fa-angle-left"></i></a>
					<ul class="sub-menu <?php if(isset($pagina_actual)){if($pagina_actual == "inversionistas" || $pagina_actual == "pagos-inversionistas"){echo "open";}}?>">
						<li <?php if(isset($pagina_actual)){if($pagina_actual == "inversionistas"){echo "class='active'";}}?>><a href="inversionistas.php"><span class="text">Inversionistas</span></a></li>
						<li <?php if(isset($pagina_actual)){if($pagina_actual == "pagos-inversionistas"){echo "class='active'";}}?>><a href="pagos-inversionistas.php"><span class="text">Pagos Inversionistas</span></a></li>
				    </ul>
				</li>
				<?php } ?>
                <li <?php if(isset($pagina_actual)){if($pagina_actual == "pagos"){echo "class='active'";}}?>><a href="pagos.php"><i class="fa fa-money" aria-hidden="true"></i><span class="text">Pagos </span></a></li>
                <?php
					if(validarAccesoModulos('permiso_reportes_grafica_pagos_mensuales') == 1 || validarAccesoModulos('permiso_reportes_historico_cobranza') == 1 || validarAccesoModulos('permiso_reportes_de_pago') == 1 || validarAccesoModulos('permiso_reportes_r_i') == 1){
				?>
                <li <?php if(isset($pagina_actual)){if($pagina_actual == "reportes-pago-mensual-intereses" || $pagina_actual == "historico-cobranza" || $pagina_actual == "reporte-pago-generales" || $pagina_actual == "reporte-apertura-creditos-pagos" || $pagina_actual == "reporte-prestamos" || $pagina_actual == "reporte-pago-generales-mas-pago-inver"){echo "class='active'";}}?>><a href="#" class="js-sub-menu-toggle"><i class="fa fa-bar-chart" aria-hidden="true"></i><span class="text">Reportes</span>
							<i class="toggle-icon fa fa-angle-left"></i></a>
					<ul class="sub-menu <?php if(isset($pagina_actual)){if($pagina_actual == "reportes-grafica-pagos-mensuales" || $pagina_actual == "historico-cobranza" || $pagina_actual == "reporte-pago-generales" || $pagina_actual == "reporte-apertura-creditos-pagos" || $pagina_actual == "reporte-prestamos" || $pagina_actual == "reporte-pago-generales-mas-pago-inver"){echo "open";}}?>">
						<?php if(validarAccesoModulos('permiso_reportes_grafica_pagos_mensuales') == 1) { ?><li <?php if(isset($pagina_actual)){if($pagina_actual == "reportes-grafica-pagos-mensuales"){echo "class='active'";}}?>><a href="reporte_pago_mensual_intereses.php"><span class="text">Grafica de Pagos Mensuales</span></a></li><?php } ?>
						<?php if(validarAccesoModulos('permiso_reportes_historico_cobranza') == 1) { ?><li <?php if(isset($pagina_actual)){if($pagina_actual == "historico-cobranza"){echo "class='active'";}}?>><a href="historico_cobro_mensual.php"><span class="text">Historico de Cobranza</span></a></li><?php } ?>
						<?php if(validarAccesoModulos('permiso_reportes_de_pago') == 1) { ?><li <?php if(isset($pagina_actual)){if($pagina_actual == "reporte-pago-generales"){echo "class='active'";}}?>><a href="reporte-pagos.php"><span class="text">Reporte de Pagos</span></a></li><?php } ?>
						<?php if(validarAccesoModulos('permiso_reportes_de_pago') == 1) { ?><li <?php if(isset($pagina_actual)){if($pagina_actual == "reporte-pago-generales-mas-pago-inver"){echo "class='active'";}}?>><a href="reporte-pagos-mas-pago-inver.php"><span class="text">Reporte de Pagos + Pago Inversionista</span></a></li><?php } ?>
						<?php if(validarAccesoModulos('permiso_reportes_r_i') == 1) { ?><li <?php if(isset($pagina_actual)){if($pagina_actual == "reporte-apertura-creditos-pagos"){echo "class='active'";}}?>><a href="reporte-apertura-creditos.php"><span class="text">Pago de Intereses R y I</span></a></li><?php } ?>
						<?php if(validarAccesoModulos('permiso_reportes_prestamos') == 1) { ?><li <?php if(isset($pagina_actual)){if($pagina_actual == "reporte-prestamos"){echo "class='active'";}}?>><a href="reporte-prestamos.php"><span class="text">Reporte de Prestamos</span></a></li><?php } ?>
						<!--<li <?php if(isset($pagina_actual)){if($pagina_actual == "reportes-pago-capital"){echo "class='active'";}}?>><a href="clientes-juridico.php"><span class="text">Pagos de Capital Mensual</span></a></li>-->
				    </ul>
				</li>
				<?php } ?>
                <!--<li <?php if(isset($pagina_actual)){if($pagina_actual == "autorizaciones"){echo "class='active'";}}?>><a href="autorizaciones.php"><i class="fa fa-key" aria-hidden="true"></i><span class="text">Autorizaciones <span class="badge label-warning">3</span></span></a></li>-->
				<?php 
					if(validarAccesoModulos('permiso_clientespuntuales') == 1){
				?>
				<li <?php if(isset($pagina_actual)){if($pagina_actual == "clientes-puntuales"){echo "class='active'";}}?>><a href="clientes-puntuales.php"><i class="fa fa-certificate" aria-hidden="true"></i><span class="text">Clientes Puntuales </span></a></li>
				<?php 
					}
					if(validarAccesoModulos('permiso_permisos') == 1){
				?>
				<li <?php if(isset($pagina_actual)){if($pagina_actual == "permisos"){echo "class='active'";}}?>><a href="permisos.php"><i class="fa fa-key" aria-hidden="true"></i><span class="text">Permisos</span></a></li>
				<?php
					}
				?>
				<?php if(validarAccesoModulos('permiso_agregar_cuentas_bancarias') == 1) { ?><li <?php if(isset($pagina_actual)){if($pagina_actual == "configuraciones" || $pagina_actual == "tabla-intereses" ||  $pagina_actual == "reporte-apertura-creditos-pagos" || $pagina_actual == "cuentas-bancarias"  ){echo "class='active'";}}?>><a href="#" class="js-sub-menu-toggle"><i class="fa fa-cogs" aria-hidden="true"></i><span class="text">Configuraciones</span>
							<i class="toggle-icon fa fa-angle-left"></i></a>
					<ul class="sub-menu <?php if(isset($pagina_actual)){if($pagina_actual == "configuraciones" || $pagina_actual == "tabla-intereses" || /*$pagina_actual == "reporte-pago-generales" ||*/ $pagina_actual == "reporte-apertura-creditos-pagos" || $pagina_actual == "cuentas-bancarias" ){echo "open";}}?>">
						<!--<li <?php if(isset($pagina_actual)){if($pagina_actual == "tabla-intereses"){echo "class='active'";}}?>><a href="configuracion-tabla-intereses.php"><span class="text">Tabla de Intereses Moratorios</span></a></li>-->
						<?php if(validarAccesoModulos('permiso_agregar_cuentas_bancarias') == 1) { ?><li <?php if(isset($pagina_actual)){if($pagina_actual == "cuentas-bancarias"){echo "class='active'";}}?>><a href="cuentas-bancarias.php"><span class="text">Cuentas Bancarias de Pago</span></a></li><?php } ?>
						
						
						
						
				    </ul>
					<?php } ?>
				</li>
            </ul>
        </nav>
        <!-- /main-nav -->
    </div>
</div>
<!-- END LEFT SIDEBAR -->

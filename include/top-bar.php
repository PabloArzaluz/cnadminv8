<!-- TOP BAR -->
<div class="top-bar navbar-fixed-top">
    <div class="container">
        <div class="clearfix">
            <a href="#" class="pull-left toggle-sidebar-collapse"><i class="fa fa-bars"></i></a>
            <!-- logo -->
            <div class="pull-left left logo">
                <a href="dashboard.php"><img src="img/credinieto-logo.png" alt="Dashboard - Portal Credinieto" /></a>
                <h1 class="sr-only">Dashboard Portal Credinieto</h1>
            </div>
            <!-- end logo -->
            <div class="pull-right right">
                <!-- search box -->
                
                <div class="searchbox">
                    <div id="tour-searchbox" class="input-group">
                        <input type="search" class="form-control" id="busqueda" placeholder="ingresa una busqueda..." onkeypress="handleEnter(event)">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" onclick="busqueda()"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </div>
                
                <!-- end search box -->
                <!-- top-bar-right -->
                <div class="top-bar-right">
                    <!--<div class="notifications">
                        <ul>
                            <!-- notification: general -->
                            <!--<li class="notification-item general">
                                <div class="btn-group">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-bell"></i><span class="count">8</span>
                                        <span class="circle"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li class="notification-header">
                                            <em>Tienes 8 notificaciones</em>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-comment green-font"></i>
                                                <span class="text">New comment on the blog post</span>
                                                <span class="timestamp">1 minute ago</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-user green-font"></i>
                                                <span class="text">New registered user</span>
                                                <span class="timestamp">12 minutes ago</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-comment green-font"></i>
                                                <span class="text">New comment on the blog post</span>
                                                <span class="timestamp">18 minutes ago</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-shopping-cart red-font"></i>
                                                <span class="text">4 new sales order</span>
                                                <span class="timestamp">4 hours ago</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-edit yellow-font"></i>
                                                <span class="text">3 product reviews awaiting moderation</span>
                                                <span class="timestamp">1 day ago</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-comment green-font"></i>
                                                <span class="text">New comment on the blog post</span>
                                                <span class="timestamp">3 days ago</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-comment green-font"></i>
                                                <span class="text">New comment on the blog post</span>
                                                <span class="timestamp">Oct 15</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-warning red-font"></i>
                                                <span class="text red-font">Low disk space!</span>
                                                <span class="timestamp">Oct 11</span>
                                            </a>
                                        </li>
                                        <li class="notification-footer">
                                            <a href="#">View All Notifications</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            
                        </ul> 
                    </div>-->
                    <!-- logged user and the menu -->
                    <div class="logged-user">
                        <div class="btn-group">
                            <a href="#" class="btn btn-link dropdown-toggle" data-toggle="dropdown">
                                <!--<img src="img/avatar-men.png" alt="Avatar Usuario" />-->
                                <span class="name">¡Hola! <b> <?php echo $_SESSION['nombre_user']; ?></b> </span> <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="page-profile.php">
                                        <i class="fa fa-user"></i>
                                        <span class="text">Mi Perfil</span>
                                    </a>
                                </li>
                                <!--<li>
                                    <a href="#">
                                        <i class="fa fa-cog"></i>
                                        <span class="text">Configuración</span>
                                    </a>
                                </li>-->
                                <li>
                                    <a href="logout.php">
                                        <i class="fa fa-power-off"></i>
                                        <span class="text">Salir</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- end logged user and the menu -->
                </div>
                <!-- end top-bar-right -->
            </div>
        </div>
    </div>
    <!-- /container -->
</div>
<!-- END TOP BAR -->

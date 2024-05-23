<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       include("../php/Conexion.php");  
       $v_usuario =  $_SESSION['user'];

       $strSql="select * from admusuarios where UserName='".$v_usuario."'";

       $rsUsuarios= mysqli_query($conexion,$strSql);
       $regUsuarios= mysqli_fetch_assoc($rsUsuarios);
       $x_tipoUsuario = $regUsuarios['IdTipoUsuario'];
    }  
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/jqvmap@1.5.1/dist/jqvmap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/weathericons@2.1.0/css/weather-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
<title>Sistema Aticus Software ALT64Pro</title>

<link href="./vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="./vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

<link href="./vendors/nprogress/nprogress.css" rel="stylesheet">

<link href="./vendors/iCheck/skins/flat/green.css" rel="stylesheet">

<link href="./vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">

<link href="./vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />

<link href="./vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

<link href="./build/css/custom.min.css" rel="stylesheet">

</head>
<body class="nav-md">
<div class="container body">
<div class="main_container">
<div class="col-md-3 left_col">
<div class="left_col scroll-view">
<div class="navbar nav_title" style="border: 0;">
<a href="index.html" class="site_title"><img src='./src/img/logo.png' width = '35' height = '25' ><span>  Compuvargas</span></a>
</div>
<div class="clearfix"></div>

<div class="profile clearfix">
<div class="profile_pic">
<img src="images/img.jpg" alt="..." class="img-circle profile_img">
</div>
<div class="profile_info">
<span>Welcome,</span>
<h2>John Doe</h2>
</div>
</div>

<br />

<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
<div class="menu_section">
<h3>Menú</h3>


<ul class="nav side-menu">


                	<?php
	                	$SqlMenu='select * from admpermisosmenu where IdTipoUsuario='.$x_tipoUsuario;

	                	$rsMenu=mysqli_query($conexion,$SqlMenu);
	                	while($reg= mysqli_fetch_array($rsMenu))
	                	{
	                		$SqlMenu2='select * from admmenu where IdMenuItem='.$reg['IdMenuItem']. " and admmenu.Estado='A'";
	                		$rsMenu2=mysqli_query($conexion,$SqlMenu2);
	                		while($reg2=mysqli_fetch_array($rsMenu2))
	                		{
	                			echo "<li><a><i class='menu_icon ".$reg2['Icono']."'></i>".utf8_encode($reg2['MenuDescripcion'])."</a>";
	                			       "<ul class='nav child_menu'>";

	                        	$sqlSubMenu="select admmenu.MenuDescripcion as NombreMenu,admmenu.IdPrograma,admprogramas.Ruta,admmenu.Icono as Icono ".
	                        				 " from admmenu,admpermisosprogramas,admprogramas ".
	                        	            " where admmenu.MenuPadre=".$reg2['IdMenuItem'].
	                        				  " and admpermisosprogramas.IdTipoUsuario=".$x_tipoUsuario.
	                        				  " and admprogramas.IdPrograma = admmenu.IdPrograma ".
	                        				  " and admpermisosprogramas.IdPrograma = admprogramas.IdPrograma";

	                        	$rsSubMenu = mysqli_query($conexion,$sqlSubMenu);
	                        	echo  "<ul class='nav child_menu'>";
	                        	while($regSubMenu= mysqli_fetch_array($rsSubMenu))
	                        	{
	                        		echo "<li><a href=".utf8_encode($regSubMenu['Ruta'])."</a>".utf8_encode($regSubMenu['NombreMenu'])."</li>";
	                        	}
	                        	echo "</ul></li>";
	                		}
	                	}

                	?>


</ul>
</div>
</div>


<div class="sidebar-footer hidden-small">
<a data-toggle="tooltip" data-placement="top" title="Settings">
<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
</a>
<a data-toggle="tooltip" data-placement="top" title="FullScreen">
<span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
</a>
<a data-toggle="tooltip" data-placement="top" title="Lock">
<span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
</a>
<a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
</a>
</div>

</div>
</div>

<div class="top_nav">
<div class="nav_menu">
<div class="nav toggle">
<a id="menu_toggle"><i class="fa fa-bars"></i></a>
</div>
<nav class="nav navbar-nav">
<ul class=" navbar-right">
<li class="nav-item dropdown open" style="padding-left: 15px;">
<a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
<img src="images/img.jpg" alt="">John Doe
</a>
<div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
<a class="dropdown-item" href="javascript:;"> Profile</a>
<a class="dropdown-item" href="javascript:;">
<span class="badge bg-red pull-right">50%</span>
<span>Settings</span>
</a>
<a class="dropdown-item" href="javascript:;">Help</a>
<a class="dropdown-item" href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
</div>
</li>


</div>
</li>
</ul>
</li>
</ul>
</nav>
</div>
</div>




<div class="right_col" role="main">

                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-1">
                                        <i class="pe-7s-wine"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text"><span class="count">23569</span></div>
                                            <div class="stat-heading">Items Ingresados</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-2">
                                        <i class="pe-7s-users"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text"><span class="count">34</span></div>
                                            <div class="stat-heading">Clientes Registrados</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-3">
                                        <i class="pe-7s-cart"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text"><span class="count">349</span></div>
                                            <div class="stat-heading">Proveedores</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-4">
                                        <i class="pe-7s-user"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text"><span class="count">2986</span></div>
                                            <div class="stat-heading">Usuarios del Sistema</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<div class="row">
<div class="col-md-4 col-sm-4 ">
<div class="x_panel tile fixed_height_320">
<div class="x_title">
<h2>Marcas más vendidas</h2>
<ul class="nav navbar-right panel_toolbox">

</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<h4>App Usage across versions</h4>
<div class="widget_summary">
<div class="w_left w_25">
<span>0.1.5.2</span>
</div>
<div class="w_center w_55">
<div class="progress">
<div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 66%;">
<span class="sr-only">60% Complete</span>
</div>
</div>
</div>
<div class="w_right w_20">
<span>123k</span>
</div>
<div class="clearfix"></div>
</div>
<div class="widget_summary">
<div class="w_left w_25">
<span>0.1.5.3</span>
</div>
<div class="w_center w_55">
<div class="progress">
<div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 45%;">
<span class="sr-only">60% Complete</span>
</div>
</div>
</div>
<div class="w_right w_20">
<span>53k</span>
</div>
<div class="clearfix"></div>
</div>
<div class="widget_summary">
<div class="w_left w_25">
<span>0.1.5.4</span>
</div>
<div class="w_center w_55">
<div class="progress">
<div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
<span class="sr-only">60% Complete</span>
</div>
</div>
</div>
 <div class="w_right w_20">
<span>23k</span>
</div>
<div class="clearfix"></div>
</div>
<div class="widget_summary">
<div class="w_left w_25">
<span>0.1.5.5</span>
</div>
<div class="w_center w_55">
<div class="progress">
<div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 5%;">
<span class="sr-only">60% Complete</span>
</div>
</div>
</div>
<div class="w_right w_20">
<span>3k</span>
</div>
<div class="clearfix"></div>
</div>
<div class="widget_summary">
<div class="w_left w_25">
<span>0.1.5.6</span>
</div>
<div class="w_center w_55">
<div class="progress">
<div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 2%;">
<span class="sr-only">60% Complete</span>
</div>
</div>
</div>
<div class="w_right w_20">
<span>1k</span>
</div>
<div class="clearfix"></div>
</div>
</div>
</div>
</div>
<div class="col-md-4 col-sm-4 ">
<div class="x_panel tile fixed_height_320 overflow_hidden">
<div class="x_title">
<h2>Dispositivos más vendidos</h2>
<ul class="nav navbar-right panel_toolbox">

</ul>

<div class="clearfix"></div>
</div>
<div class="x_content">
<table class="" style="width:100%">
<tr>
<th style="width:37%;">
<p>Top 5</p>
</th>
<th>
<div class="col-lg-7 col-md-7 col-sm-7 ">
<p class="">Device</p>
</div>
<div class="col-lg-5 col-md-5 col-sm-5 ">
<p class="">Progress</p>
</div>
</th>
</tr>
<tr>
<td>
<canvas class="canvasDoughnut" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
</td>
<td>
<table class="tile_info">
<tr>
<td>
<p><i class="fa fa-square blue"></i>IOS </p>
</td>
<td>30%</td>
</tr>
<tr>
<td>
<p><i class="fa fa-square green"></i>Android </p>
 </td>
<td>10%</td>
</tr>
<tr>
<td>
<p><i class="fa fa-square purple"></i>Blackberry </p>
</td>
<td>20%</td>
</tr>
<tr>
<td>
<p><i class="fa fa-square aero"></i>Symbian </p>
</td>
<td>15%</td>
</tr>
<tr>
<td>
<p><i class="fa fa-square red"></i>Others </p>
</td>
<td>30%</td>
</tr>
</table>
</td>
</tr>
</table>
</div>
</div>
</div>
<div class="col-md-4 col-sm-4 ">
<div class="x_panel tile fixed_height_320">
<div class="x_title">
<h2>Cores más vendidos</h2>
<ul class="nav navbar-right panel_toolbox">
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<div class="dashboard-widget-content">
<ul class="quick-list">
<li><i class="fa fa-calendar-o"></i><a href="#">Settings</a>
</li>
<li><i class="fa fa-bars"></i><a href="#">Subscription</a>
</li>
<li><i class="fa fa-bar-chart"></i><a href="#">Auto Renewal</a> </li>
<li><i class="fa fa-line-chart"></i><a href="#">Achievements</a>
</li>
<li><i class="fa fa-bar-chart"></i><a href="#">Auto Renewal</a> </li>
<li><i class="fa fa-line-chart"></i><a href="#">Achievements</a>
</li>
<li><i class="fa fa-area-chart"></i><a href="#">Logout</a>
</li>
</ul>
<div class="sidebar-widget">
<h4>Profile Completion</h4>
<canvas width="150" height="80" id="chart_gauge_01" class="" style="width: 160px; height: 100px;"></canvas>
<div class="goal-wrapper">
<span id="gauge-text" class="gauge-value pull-left">0</span>
<span class="gauge-value pull-left">%</span>
<span id="goal-text" class="goal-value pull-right">100%</span>
</div>
</div>
</div>
</div>
</div>
</div>
</div>










<footer>
<div class="pull-right">
Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
</div>
<div class="clearfix"></div>
</footer>

</div>
</div>

<script src="./vendors/jquery/dist/jquery.min.js"></script>

<script src="./vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

 <script src="./vendors/fastclick/lib/fastclick.js"></script>

<script src="./vendors/nprogress/nprogress.js"></script>

<script src="./vendors/Chart.js/dist/Chart.min.js"></script>

<script src="./vendors/gauge.js/dist/gauge.min.js"></script>

<script src="./vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>

<script src="./vendors/iCheck/icheck.min.js"></script>

<script src="./vendors/skycons/skycons.js"></script>

<script src="./vendors/Flot/jquery.flot.js"></script>
<script src="./vendors/Flot/jquery.flot.pie.js"></script>
<script src="./vendors/Flot/jquery.flot.time.js"></script>
<script src="./vendors/Flot/jquery.flot.stack.js"></script>
<script src="./vendors/Flot/jquery.flot.resize.js"></script>

<script src="./vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
<script src="./vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
<script src="./vendors/flot.curvedlines/curvedLines.js"></script>

<script src="./vendors/DateJS/build/date.js"></script>

<script src="./vendors/jqvmap/dist/jquery.vmap.js"></script>
<script src="./vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
<script src="./vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>

<script src="./vendors/moment/min/moment.min.js"></script>
<script src="./vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

<script src="./build/js/custom.min.js"></script>
</body>
</html>

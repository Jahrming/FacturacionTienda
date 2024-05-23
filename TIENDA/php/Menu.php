<?php
  session_start();
  if(!isset($_SESSION['user']))
  {
    header("location:index.php");
  }

  $user=$_SESSION['user'];
  require 'conexion.php';

  /*
  $RegTickes=mysqli_query($conexion, "select * from tickets where IdEstado='U'");
  $RegCentroCostos=mysqli_query($conexion, "select * from centrocosto");
  $RegTicketsSol=mysqli_query($conexion, "select * from tickets where IdEstado='F' and IdUsuario='".$user."'");
    
  $RegClientes=mysqli_query($conexion, "select * from usuarios where IdTipoUsuario= 'U'" );
  */
  $StrSql2 = "SELECT * FROM configuracion_basica ";
  $ResultSet2=mysqli_query($conexion,$StrSql2);
  $registro2=  mysqli_fetch_assoc($ResultSet2);
  $NombreEmpresa= $registro2['DescripcionEmpresa'];
  $NombreLargo=$registro2['NombreLargo'];
  $NombreCorto=$registro2['NombreCorto'];
  
  
  //Obtengo los datos del Usuario
  $StrSql3 = "SELECT * FROM usuarios WHERE idUsuario = '$user' ";
  $ResultSet3=mysqli_query($conexion,$StrSql3);
  $fila = mysqli_fetch_assoc($ResultSet3);
  $v_UsuarioSistema=$fila['IdUsuario'];
  $v_NombreUsuario=$fila['UsuarioApellidos'].' '.$fila['UsuarioNombres'];
  $v_TipoUsuario=$fila['IdTipoUsuario'];

  
  $StrSql4="SELECT * FROM TipoUsuarios where IdTipoUsuario='".$v_TipoUsuario."'";
 
  $ResultSet4=mysqli_query($conexion,$StrSql4);
  $filaTipoUsuario=  mysqli_fetch_assoc($ResultSet4);
  $v_DescripcionTipoUsuario=$filaTipoUsuario['DescripcionTipoUsuario'];
 
  $_Html = "";
  // Obtengo los Programas Autorizados para el usuario logoneado
  $StrSql5="SELECT * FROM adm_menu WHERE padre_hijo = 'P' AND estado = 'A' ";
  $ResultSet5=mysqli_query($conexion,$StrSql5);
  
  while ($registro3=  mysqli_fetch_array($ResultSet5))
  {
     $v_MenuPadre=$registro3['idMenuItem'];
     $v_MenuNombre=$registro3['desc_menu'];
     $_Html=$_Html."<li class='treeview'> 
                  <a href=''>
                    <i class='fa fa-book'></i> <span>$v_MenuNombre</span>
                    <span class='pull-right-container'> <i class='fa fa-angle-left pull-right'></i> </span>
                  </a> 
                  <ul class='treeview-menu'>";
        
            $StrSql6="select a.desc_menu as nombreprograma,a.programa as rutapro 
                        FROM adm_menu a,adm_permisos_programas b 
                        where b.IdTipoUsuario=  '".$v_TipoUsuario."'"
                   . " and a.idMenuItem = b.idprograma  ".
                    " and a.menupadre=".$v_MenuPadre.
                    " and a.estado = 'A';
        
            $ResultSet6=mysqli_query($conexion,$StrSql6); 
            while($registroHijos= mysqli_fetch_array($ResultSet6))
            {
                $v_NombreModulo = $registroHijos['nombreprograma'];
                $v_RutaPrograma= $registroHijos['rutapro'];
                $_Html=$_Html."<li class='active' onclick='set_cookie(\"cookie_id_program\",\"$v_NombreModulo\")'><a href='$v_RutaPrograma'>
                        <i class='fa fa-circle-o'></i> $v_NombreModulo </a></li>
                      ";
            }     
            $_Html=$_Html."
                    </ul>
                    </li>
                      ";
    }
  
  $CodigoHtml = "
  <!DOCTYPE html>
  <html>
  <head>
    
    <script type='text/javascript' src='../js/funciones.js'>          </script>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title> SISTEMA HELP DESK PHD </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.6 -->
    <link rel='stylesheet' href='../css/bootstrap.min.css'>
    <!-- Font Awesome -->
    <link rel='stylesheet' href='../css/font-awesome.min.css'>
    <!-- Ionicons -->
    <link rel='stylesheet' href='../css/ionicons.min.css'>
    <!-- Theme style -->
    <link rel='stylesheet' href='../css/AdminLTE.min.css'>
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel='stylesheet' href='../css/_all-skins.min.css'>
    <!-- jvectormap -->
    <link rel='stylesheet' href='../js/jquery-jvectormap-1.2.2.css'>
    <!-- Date Picker -->
    <link rel='stylesheet' href='../css/datepicker3.css'>
    <!-- Daterange picker -->
    <link rel='stylesheet' href='../css/daterangepicker.css'>
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel='stylesheet' href='../css/bootstrap3-wysihtml5.min.css'>
  </head>
  <body class='hold-transition skin-red sidebar-mini'>
    <div class='wrapper'>
      <header class='main-header'>
        <!-- Logo -->
        <a href='#' class='logo'>
          <span class='logo-mini'><b>$NombreCorto </b></span>
          <span class='logo-lg'>  <b>$NombreCorto </b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->

        <nav class='navbar navbar-static-top'>
          <a href='#' class='sidebar-toggle' data-toggle='offcanvas' role='button' title='Menu'> </a>      
         <CENTER> <h4 style='color:rgba(255,255,255,1);'> $NombreEmpresa </h4> </CENTER>
        </nav>
      </header>

      <!-- Left side column. contains the logo and sidebar -->
            <aside class='main-sidebar'>
        <!-- sidebar: style can be found in sidebar.less -->
        <section class='sidebar'>
          <!-- Sidebar user panel -->
          <div class='user-panel'>

            <div class='pull-left info'>
              <p> <h4> $user </h4>$v_DescripcionTipoUsuario
              </p>
            </div>
          </div>
          
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class='sidebar-menu'>
            <li class='header' style='color:rgba(0,255,0);background:rgba(233, 47, 122, 1)'> <center>MENU PRINCIPAL </center></li>
            $_Html
             <li>
              <a href='SalirSistema.php'>
                <i class='fa fa-power-off'></i> <span>Salir del Sistema</span>
              </a>
            </li>
          
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class='content-wrapper'>
        <!-- Content Header (Page header) -->
        <!-- Main content -->
        <section class='content'>
          <!-- Small boxes (Stat box) -->
          <div class='row'>
            <div class='col-lg-3 col-xs-6'>
              <!-- small box -->
              <div class='small-box bg-aqua'>
                <div class='inner'>
                  <h3>NUMERO DE USUARIOS</h3>
                  <p>Tickets sin Asignar</p>
                </div>
                <div class='icon'>
                  <i class='ion ion-person'></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class='col-lg-3 col-xs-6'>
              <!-- small box -->
              <div class='small-box bg-green'>
                <div class='inner'>
                  <h3><sup style='font-size: 20px'></sup></h3>
                  <p>Centro Costos</p>
                </div>
                <div class='icon'>
                  <i class='ion ion-stats-bars'></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class='col-lg-3 col-xs-6'>
              <!-- small box -->
              <div class='small-box bg-yellow'>
                <div class='inner'>
                  <h3></h3>
                  <p>Tickets Terminados</p>
                </div>
                <div class='icon'>
                  <i class='ion ion-person-stalker'></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class='col-lg-3 col-xs-6'>
              <!-- small box -->
              <div class='small-box bg-fuchsia  '>
                <div class='inner'>
                  <h3><sup style='font-size: 20px'></sup></h3>
                  <p>Usuarios</p>
                </div>
                <div class='icon'>
                  <i class='ion ion-pie-graph'></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
          </div>
          <!-- /.row -->
          <!-- Main row -->
          <div class='row'>
          	<center>      <img src='../img/' width=35%> </center>  
                <br>
                <center>Bienvenido :".$v_NombreUsuario." 
          </div>
    	  
                      
          <!-- /.row (main row) -->

        </section>
        <!-- /.content -->

      </div>
      <!-- /.content-wrapper -->
      <footer class='main-footer'>
        <div class='pull-right hidden-xs'>
          <b>Version</b> 1.0
        </div>
        <strong>Desarrollado por  <a href='#'>Alumnos de 6to c </a></strong> - si Todos los derechos son reservados &copy; 
      </footer>

    </div>
    <!-- ./wrapper -->

    <!-- jQuery 2.2.3 -->
    <script src='../js/jquery-2.2.3.min.js'></script>
    <!-- jQuery UI 1.11.4 -->
    <script src='../js/jquery-ui.min.js'></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.6 -->
    <script src='../js/bootstrap.min.js'></script>
    <!-- Sparkline -->
    <script src='../js/jquery.sparkline.min.js'></script>
    <!-- jvectormap -->
    <script src='../js/jquery-jvectormap-1.2.2.min.js'></script>
    <script src='../js/jquery-jvectormap-world-mill-en.js'></script>
    <!-- jQuery Knob Chart -->
    <script src='../js/jquery.knob.js'></script>
    

    <script src='../js/app.min.js'></script>
<p style='font-size:16pt;color:red' id='mi_mensaje' name='mi_mensaje'>  </p>
  </body>
  </html>
  ";
echo $CodigoHtml;
<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../Login.php");
    }
    else
    {
       include("Conexion.php");  
       $x_usuario           =  $_SESSION['user'];
       $strSql              =  "select * from admusuarios 
                                where UserName='$x_usuario' ";
       $rsUsuarios          =  mysqli_query($conexion,$strSql);
       $regUsuarios         =  mysqli_fetch_assoc($rsUsuarios);
       $x_tipoUsuario       =  $regUsuarios['IdTipoUsuario'];
       $x_nombres           =  $regUsuarios['NombresUsuario'];
       $x_apellidos         =  $regUsuarios['ApellidosUsuario'];
       $x_cedula            =  $regUsuarios['CedulaUsuario'];
       $x_paisnacimiento    =  $regUsuarios['IdPaisNacimiento'];
       $x_paisresidencia    =  $regUsuarios['IdPaisResidencia'];
       $x_ciudadresidencia  =  $regUsuarios['CiudadResidencia'];
       $x_emailrecuperacion =  $regUsuarios['EmailRecuperacion'];
       $x_telefonos         =  $regUsuarios['Telefonos'];
       $x_fecnac            =  $regUsuarios['FechaNacimiento'];
       $x_estadoresidencia  =  $regUsuarios['EstadoResidencia'];
       $x_numeropasaporte   =  $regUsuarios['NumeroPasaporte'];

       $sql          =  "select * from paises where id=".$x_paisnacimiento;
       $rsPais       =  mysqli_query($conexion,$sql);
       $regPais      =  mysqli_fetch_assoc($rsPais);
       $nombrePaisNac=  $regPais['iso'].'-'.$regPais['nombre'];
       $sql          =  "select * from paises where id=".$x_paisresidencia;
       $rsPais       =  mysqli_query($conexion,$sql);
       $regPais      =  mysqli_fetch_assoc($rsPais);
       $nombrePaisRes=  $regPais['iso'].'-'.$regPais['nombre'];     

       $sqlVehiculos  = "select * from vehiculos where username = '$x_usuario'";
       $rsv           = mysqli_query($conexion,$sqlVehiculos);
       $regv          = mysqli_fetch_assoc($rsv);
       $x_placa       = $regv["placa"];
       $x_marca       = $regv["marca"];
       $x_modelo      = $regv["modelo"];
       $x_anio        = $regv["anio"];
       $x_kilometraje = $regv["kilometraje"];

    }  

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>VIP RECRUITERS</title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/logo01.png" rel="icon">

  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="../assets/vendor/venobox/venobox.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Vlava - v2.1.0
  * Template URL: https://bootstrapmade.com/vlava-free-bootstrap-one-page-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body >

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <div class="container d-flex align-items-center">

      <div class="logo mr-auto">
        <h1 class="text-light"><a href="../index.html"><span><img src="../assets/img/logo01.png">VIP RECRUITERS</span></a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li><a href="#about">Usuario</a></li>
          <li><a href="#services">Documentos</a></li>
          <li><a href="#faq">Info Vehículo</a></li>      
          <li><a href="#contact">Fotos Vehículo</a></li>      
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </nav><!-- .nav-menu -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero">
    <div class="hero-container">
      <h1>Bienvenido, <?php echo $x_nombres.' '.$x_apellidos; ?></h1>
      <h2>GRACIAS POR PERTENECER AL STAFF PARA LAS MAS GRANDES CADENAS VIP DE NEW YOR DRIVERS</h2>
      <a href="#about" class="btn-get-started scrollto">Empecemos</a>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container">

        <div class="row content">
          <div class="col-lg-6">
            <h2>DATOS GENERALES DEL REGISTRADO</h2>
            <h3></h3>
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0">
            <ul>
              <li><i class="ri-check-double-line"></i><h4>Nacionalidad:</h4><h5><?php echo $nombrePaisNac;?></h5></li>
              <li><i class="ri-check-double-line"></i><h4>País de Residencia:</h4><h5><?php echo $nombrePaisRes;?></h5></li>
              <li><i class="ri-check-double-line"></i><h4>Estado Residencia:</h4><h5><?php echo $nombrePaisNac;?></h5></li>
              <li><i class="ri-check-double-line"></i><h4>Ciudad Residencia:</h4><h5><?php echo $x_ciudadresidencia;?></h5></li>
              <li><i class="ri-check-double-line"></i><h4>Fecha Nacimiento:</h4><h5><?php echo $x_fecnac;?></h5></li>
              <li><i class="ri-check-double-line"></i><h4>Teléfonos:</h4><h5><?php echo $x_telefonos;?></h5></li> 
              <li><i class="ri-check-double-line"></i><h4>Número Passaport:</h4><h5><?php echo $x_numeropasaporte;?></h5></li>                                         
            </ul>
          </div>
        </div>

      </div>
    </section><!-- End About Section -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services section-bg">
      <div class="container">
        <div class="section-title">
          <h2>Documentos Personales Cargados</h2>
          <p><b>VIP RECRUITERS,</b> En Esta sección se carga la documentación solicitada, si no los has ingresado entra aquí <a href="cdp.php">Cargar Documentos Personales</a></p>
        </div>

        <div class="row content">
          <div class="col-md-10">
            <div class="table">
              <center>
                <table>
                    <tr><td><center>DOCUMENTO SOLICITADO</center></td><td>DOCUMENTO CARGADO</td><td>CARGAR</td></tr>
                    <tr><td>CÉDULA/ID/RUC</td><td></td><td></td></tr>
                    <tr><td>PASSAPORTE</td><td></td><td></td></tr>
                    <tr><td>LICENCIA CONDUCIR</td><td></td><td></td></tr>
                    <tr><td>FOTO FRENTE</td><td></td><td></td></tr>
                    <tr><td>FOTO PERFIL</td><td></td><td></td></tr>    
                    <tr><td>FOTO CUERPO ENTERO(VESTIDO FORMAL)</td><td></td><td></td></tr>
                </table> 
              </center>                
            </div>                                                
          </div>
        </div>
      </div>

    </section><!-- End Services Section -->
    <!-- ======= Frequently Asked Questions Section ======= -->
  
    <!-- ======= Frequently Asked Questions Section ======= -->
    <section id="faq" class="faq">
      <br>
      <br>
      <div class="container">

        <div class="section-title">
          <h2>Información Vehículo</h2>
        </div>

        <div class="container">
        <div class="section-title">
          <center><h4>Datos del vehículo</h4></center>
          <center><p><b>VIP RECRUITERS,</b> En Esta sección se ingresa la información del auto, actualiza la información <a href="dveh.php">aquí</a></p></center>
        </div>
 
            <div class="form-row">
                <div class="col-md-6 form-group">
                  <label>VIN NUMBER</label>
                  <input type="text" name="vinnumber" class="form-control" id="vinnumber" placeholder="Vin Number" data-rule="minlen:4" data-msg="Please enter at least 4 chars" value="<?php echo $x_placa ;?>" readonly="yes">
                  <div class="validate"></div>
                </div>
                <div class="col-md-6 form-group">
                  <label>MARCA</label>
                  <input type="text" class="form-control" name="marca" id="subject" placeholder="Marca" value="<?php echo $x_marca ;?>" readonly="yes">
                  <div class="validate"></div>
                </div>  
            </div>     
            <div class="form-row">
                <div class="col-md-6 form-group">
                  <label>MODELO</label>
                  <input type="text" name="MODELO" class="form-control" id="MODELO" placeholder="MODELO" value="<?php echo $x_modelo ;?>" readonly="yes">
                  <div class="validate"></div>
                </div>
                <div class="col-md-6 form-group">                    
                  <label>AÑO</label>
                  <input type="text" name="anio" class="form-control" id="anio" placeholder="anio" value="<?php echo $x_anio ;?>" readonly="yes">
                  <div class="validate"></div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 form-group">
                  <label>KILOMETRAJE</label>
                  <input type="numeric" name="KILOMETRAJE" class="form-control" id="KILOMETRAJE" placeholder="KILOMETRAJE" data-rule="minlen:4" data-msg="Please enter at least 4 chars" value="<?php echo $x_kilometraje ;?>" readonly="yes" >
                  <div class="validate"></div>
                </div>
            </div> 
  

      </div>
    </section><!-- End Frequently Asked Questions Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact section-bg">
      <div class="container">
        <div class="section-title">
          <h2>Fotos del vehículo</h2>
          <p><b>VIP RECRUITERS,</b> Aquí debes cargar las fotos del vehículo tal como se solicita la foto delante y atras por favor que se aprecie la placa, carga las fotos <a href="fveh.php">aquí</a></p>
        </div>
            <div class="row content">
              <div class="col-md-10">
                <div class="table">
                  <center>
                    <table>
                        <tr><td><center>ITEMS</center></td><td>DOCUMENTO CARGADO</td><td>CARGAR</td></tr>
                        <tr><td>MATRICULA</center></td><td></td><td></td></tr>
                        <tr><td>PERFIL DERECHO</td><td></td><td></td></tr>
                        <tr><td>PERFIL IZQUIERDO</td><td></td><td></td></tr>
                        <tr><td>FRENTE</td><td></td><td></td></tr>
                        <tr><td>TRASERO</td><td></td><td></td></tr>
                        <tr><td>ARRIBA</td><td></td><td></td></tr>
                        <tr><td>INTERIOR (LIMPIO)</td><td></td><td></td></tr>    
                    </table> 
                  </center>                
                </div>                                                
              </div>
            </div>
        </div>
      </div>
    </section>
  </main><!-- End #main -->

   <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">

      <div class="container">

        <div class="row  justify-content-center">
          <div class="col-lg-6">
            <h5><img src="../assets/img/logo02.png"></h5>
            <p>Qué esperas para unirte a nuestra de red de reclutamientos de choferes para gente VIP.</p>
          </div>
        </div>

        <div class="row footer-newsletter justify-content-center">
          <div class="col-lg-6">

            </form>
          </div>
        </div>

        <div class="social-links">
          <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
          <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
          <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
          <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
          <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
        </div>

      </div>
    </div>

    <div class="container footer-bottom clearfix">
      <div class="copyright">
        &copy; Copyright <strong><span>VIP RECRUITERS</span></strong>. All Rights Reserved 2020
      </div>
      <!--<div class="credits">-->
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/vlava-free-bootstrap-one-page-template/ -->
       <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div> -->
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/jquery/jquery.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>
  <script src="../assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../assets/vendor/venobox/venobox.min.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>

</html>
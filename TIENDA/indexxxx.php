<?php
if(!isset($_SESSION['user']))
{
  @session_start();
  include('./php/Conexion.php');
  $sqlAlmacen='select * from almacenes';
  $rs = mysqli_query($conexion,$sqlAlmacen);
  $listaAlmacenes ='';
  while($reg = mysqli_fetch_array($rs))
  {
    $listaAlmacenes.="<option value='".$reg['IdAlmacen']."'>".$reg['DescripcionAlmacen']."</option>";
  }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="./assets/img/ATICUSLOGO01.PNG">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <title>ATICUS SOFTWARE POR ALT64</title>
    <!-- Custom styles for this template -->
    <link href="./assets/css/signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form class="form-signin" method="post" action="./php/validarUsuario.php">
    
      <h1 class="h3 mb-4 font-weight-normal"></h1>
      	<h1>EL SITIO COMPUVARGAS YA NO EXISTE</h1>
      	<br>
      	<h1></h1>
      <div></div>
      <p class="mt-5 mb-3 text-muted">&copy; </p>
    </form>
  </body>
</html>

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
    <link rel="icon" href="./assets/img/alabahia.jpeg">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <title>ATICUS SOFTWARE POR ALT64</title>
    <!-- Custom styles for this template -->
    <link href="./assets/css/signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form class="form-signin" method="post" action="./php/validarUsuario.php">
      <img class="mb-4" src="./assets/img/ATICUSLOGO01.PNG" alt="" width="120" height="120">
      <img class="mb-4" src="./assets/img/alabahia.jpeg" alt="" width="120" height="120">      
      <h1 class="h3 mb-4 font-weight-normal">Bienvenido</h1>
      <label for="usuario" class="sr-only">Email address</label>
      <input type="text" id="usuario"  name="usuario" class="form-control" placeholder="Ingrese Usuario" required autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required> 
      <select id='almacen' name='almacen' class="select-control"  required="yes">
         <option value=''>Seleccionar</option>
            <?php  echo $listaAlmacenes;       ?>
      </select>       
      <div class="checkbox mb-3">
        <!--<label>
          <input type="checkbox" value="remember-me"> Remember me
        </label> -->
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Inicie Sesión</button>
      <div></div>
      <p class="mt-5 mb-3 text-muted">&copy; 2020 ALT64</p>
    </form>
  </body>
</html>

<?php
 if (!isset($_SESSION['user']))
 {
     @session_start();
 }
 ?>
<html>
    <head>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/estilo.css" rel="stylesheet">
        <link href="../css/signin.css" rel="stylesheet">
        <title>Sistema Help Desk 1.0</title>
    </head>
  <body class="text-center">
    
    <form class="form-signin" method="POST" action="ValidarUsuario.php">
 
      <h1 class="h3 mb-3 font-weight-normal">Por favor inicie sesión</h1>
      <label for="Usuario" class="sr-only">Usuario</label>
      <input type="text" id="inputUsuario" class="form-control" name="usuario" placeholder="System User" required autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="inputPassword" name="clave" class="form-control" placeholder="Password" required autofocus="">
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Recordarme
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Enter System</button>
      <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
    </form>
  </body>
</html>


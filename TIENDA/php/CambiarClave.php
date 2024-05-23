<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       $v_usuario=$_SESSION['user'];
       include("Conexion.php");    
       $v_IdCurso=$_REQUEST['IdCurso'];
       $Sql="Select * from admusuarios  where UserName='$v_usuario'";
       $rs  =   mysqli_query($conexion,$Sql);
       $reg =   mysqli_fetch_assoc($rs);
       $x_passwordActual = $reg['password'];
       


    }

  ?>  
<head>
      <title> SISTEMA IMPORTBOOKS</title>
      <script type='text/javascript' src='../js/funciones.js'>          </script>
      <script type='text/javascript' src='../js/alertifyjs/alertify.js'>  </script>
      <script type='text/javascript' language='javascript' src='../js/jquery.js'> </script>
      <meta http-equiv='Content-Type' content='text/html'; charset='utf-8'/>
      <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'/>
      <link rel='stylesheet' href='../css/estilos.css' >
      <link rel='stylesheet' href='../css/bootstrap.min.css'>
      <link rel='stylesheet' href='../js/alertifyjs/css/alertify.css' />

</head>
<!---   <body onload='return inicio(\"\")'>    -->
<body>
<section>
  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' action='ActualizarContrasena.php'>  
      <div class='container'>
        <div class='panel panel-default'>
            <?php echo"<div class='panel-heading' style='font-size: 20px;color:#0080FF;font-weight:bold;'>Modificar Password
              <button class='btn btn-primary btn-sm' title='Regresar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span></button>";?>
            <?php echo"<button class='btn btn-primary btn-sm' title='Grabar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' type='submit'> <span class='glyphicon glyphicon-floppy-disk'></span> </button>";?>
              <button class='btn btn-primary btn-sm' title='Limpiar' style='font-size:16px;color:#0080FF;background-color:#FFBF00;border:none' type='button'><span class='glyphicon glyphicon-refresh'></span> </button>                 
            </div>
          <div class="panel-body">

                <div class="form-row">
                  <div class='form-group'>  
                        <label for='f_claveactual' class='control-label col-md-2'>Contraseña Actual:</label>
                        <input class='form-control' name='claveactual' type='password' placeholder='Contraseña actual' required>
                  </div>
                  <input type='hidden' value='".$v_usuario."' name='usuario'>
                  <div class='form-group'>    
                      <label for='f_nuevaclave' class='control-label col-md-2'>Contraseña Nueva:</label>
                      <input class='form-control' name='clavenueva' id='nuevacontrasena' type='password' placeholder='Contraseña nueva' required>
                  </div>

                  <div class='form-group'>    
                      <label for='f_confirmanuevaclave' class='control-label col-md-2'>Confirma Contraseña:</label>
                      <input class='form-control' name='confirmaclave' type='password' placeholder='Confirma Contraseña nueva' required>
                  </div>
                </div>

              </div>            
          </div>   
        </div>
  
 </form>
</section>

<p style='font-size:16pt;color:red' id='mi_mensaje' name='mi_mensaje'>  </p>
</body>
</html>
   


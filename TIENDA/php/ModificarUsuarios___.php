<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       
       include("Conexion.php");    
       $CodigoHtml='' ;
       #btener datos de los tickets
       $v_usuario=$_REQUEST['IdUsuario'];
       
       #Obtengo informacion del usuario
       $SqlDatosUsuario="Select * from usuarios where IdUsuario='".$v_usuario."'";
       $ResultSetUsuario=  mysqli_query($conexion,$SqlDatosUsuario);
       $reg_usuario=mysqli_fetch_assoc($ResultSetUsuario);
       $v_Apellidos=  $reg_usuario['UsuarioApellidos'];
       $v_Nombres= $reg_usuario['UsuarioNombres'];
       $v_IdTipoUsuario= $reg_usuario['IdTipoUsuario'];
       $v_Clave = $reg_usuario['UsuarioPassword'];
       
       
       $v_email= $reg_usuario['UsuarioEmail'];
       $v_Estado=$reg_usuario['Estado'];
 
       ##########################################
       #Obtener datos de los Tipo de Usuaio     #
       ##########################################       
       $ListaTU='';
       $SqlTU="Select * from tipousuarios where IdTipoUsuario='".$v_IdTipoUsuario."'";
       $ResultTU=  mysqli_query($conexion, $SqlTU);
       $reg_TU= mysqli_fetch_assoc($ResultTU);
       $v_TU=$reg_TU['IdTipoUsuario'];
       $NombreTU=$reg_TU['DescripcionTipoUsuario'];
       $ListaTU=$ListaTU."<option value='".$v_TU."' Selected>".$NombreTU."</option>";
       
       $SqlTU="Select * from tipousuarios where IdTipoUsuario!='".$v_TU."'";
       $ResultTU=  mysqli_query($conexion, $SqlTU);
       while($reg_TU= mysqli_fetch_assoc($ResultTU))
       {
            $v_TU=$reg_TU['IdTipoUsuario'];
            $NombreTU=$reg_TU['DescripcionTipoUsuario'];
            $ListaTU=$ListaTU."<option value='".$v_TU."'>".$NombreTU."</option>";              
       }           
             
    }
     ?>  


<head>
    <title> SISTEMA ACADEMICO </title>
    <script type='text/javascript' src='../js/funciones.js'> 					</script>
    <script type='text/javascript' src='../js/alertifyjs/alertify.js'> 	</script>
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
    <div class='container'>   
    <form id='formulario'  role='form' method='POST' enctype='multipart/form-data' action='ActualizaUsuario.php'>
       <section   style='color:#0080FF; background-color: #FFBF00'>
            <h2 align=left>&nbspMODIFICAR USUARIO
               <?php echo "<button class='btn btn-primary btn-lg' title='Regresar' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span> </button>";?>
               <?php          
               echo "<button id='btn_grabar' class='btn btn-primary btn-lg' title='Grabar' onclick='' type='submit' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none'><span class='glyphicon glyphicon-floppy-save'></span></button>";
               ?>
               <button class='btn btn-primary btn-lg' title='Limpiar btn-lg' onclick='' type='reset' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none'><span class='glyphicon glyphicon-refresh'></span></button> 
            </h2>
        </section >
        <div class="form-row">
          <div class="form-group col-md-6">
            <label style='color:#0080FF' for="f_usuario">&nbsp&nbspUsuario:&nbsp&nbsp</label>
            <input style='color:#0080FF' type="text" class="form-control" id="userName" name="Usuario" readonly value=<?php echo $v_usuario;?>>
          </div>
          <div class="form-group col-md-6">
            <label style='color:#0080FF' for="inputPassword4">Password:</label>
            <input style='color:#0080FF' type="password" name='Clave' class="form-control" id="Clave" placeholder="Password" value=<?php echo $v_Clave;?> >
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-12">
            <label style='color:#0080FF'  for="f_apellidos">&nbsp&nbspApellidos: </label>
            <input style='color:#0080FF' type="text" class="form-control" id="Apellidos" name='Apellidos' placeholder="Apellidos" value='<?php echo $v_Apellidos;?>'>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-12">
            <label style='color:#0080FF'  for="f_nombres">&nbsp&nbspNombres:</label>
            <input style='color:#0080FF' type="text" name='Nombres' class="form-control" id="Nombres" placeholder="Nombres" value='<?php echo $v_Nombres?>'>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label style='color:#0080FF' for="f_mail">&nbsp&nbsp@Mail:&nbsp&nbsp</label>
            <input style='color:#0080FF' type="text" class="form-control" id="email" name="email" placeholder="Email" value=<?php echo $v_email?>>
          </div>
          <div class="form-group col-md-6">
            <label style='color:#0080FF' for="tipoUsuario">Tipo Usuario(Rol):</label>
            <select style='color:#0080FF' id='TipoRol' name='TipoRol' class="form-control" id="TipoRol" required>
                <option value=''>Seleccionar</option>
                <?php echo $ListaTU; ?>
            </select>              
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label style='color:#0080FF' for="tipoUsuario">&nbsp&nbspEstados:</label>
              <select style='color:#0080FF' id='Estado' name='Estado' class='form-control input-sm' required' >
                <option value=''>Seleccionar</option>
                <option value='A'>Activo</option>
                <option value='I'>Inactivo</option> 
              </select>           
          </div>
        </div>

     
    </form>
   </div>
 </section>
<p style='font-size:16pt;color:red' id='mi_mensaje' name='mi_mensaje'>  </p>
</body>
</html>

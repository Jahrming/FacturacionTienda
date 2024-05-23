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
       


       #Obtener datos de los roles
       $ListaRoles='';
       $SqlRoles="Select * from tipousuarios";
       $ResultRoles=  mysqli_query($conexion, $SqlRoles);
       while($reg_Roles=  mysqli_fetch_array($ResultRoles))
       {
           $TipoRol=$reg_Roles['IdTipoUsuario'];
           $NombreRol=$reg_Roles['DescripcionTipoUsuario'];
           $ListaRoles=$ListaRoles.
              "<option value='".$TipoRol."'>".$NombreRol."</option>";
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
    <form id='Formulario' name='Formulario' role='form' method='POST' enctype='multipart/form-data' action='GrabaUsuario.php'>
       <section   style='color:#0080FF; background-color: #FFBF00'>
            <h2 align=left>&nbspNUEVO USUARIO
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
            <input style='color:#0080FF' type="text" class="form-control" id="Usuario" name="Usuario" placeholder="Username" onblur='return VerificarDatosUsuario()'>
          </div>
          <div class="form-group col-md-6">
            <label style='color:#0080FF' for="inputPassword4">Password:</label>
            <input style='color:#0080FF' type="password" name='Clave' class="form-control" id="Clave" placeholder="Password">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-12">
            <label style='color:#0080FF'  for="f_apellidos">&nbsp&nbspApellidos: </label>
            <input style='color:#0080FF' type="text" class="form-control" id="Apellidos" name='Apellidos' placeholder="Apellidos">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-12">
            <label style='color:#0080FF'  for="f_nombres">&nbsp&nbspNombres:</label>
            <input style='color:#0080FF' type="text" name='Nombres' class="form-control" id="Nombres" placeholder="Nombres">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label style='color:#0080FF' for="f_mail">&nbsp&nbsp@Mail:&nbsp&nbsp</label>
            <input style='color:#0080FF' type="text" class="form-control" id="email" name="email" placeholder="Email">
          </div>
          <div class="form-group col-md-6">
            <label style='color:#0080FF' for="tipoUsuario">Tipo Usuario(Rol):</label>
            <select style='color:#0080FF' id='TipoRol' name='TipoRol' class="form-control" id="TipoRol" required>
                <option value=''>Seleccionar</option>
                <?php
                   echo $ListaRoles;
                 ?>
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
   
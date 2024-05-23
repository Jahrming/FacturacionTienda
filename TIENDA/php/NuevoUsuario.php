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
       $SqlRoles="Select * from admtipousuario";
       $ResultRoles=  mysqli_query($conexion, $SqlRoles);
       while($reg_Roles=  mysqli_fetch_array($ResultRoles))
       {
           $TipoRol=$reg_Roles['IdTipoUsuario'];
           $NombreRol=$reg_Roles['DescripcionTipoUsuario'];
           $ListaRoles=$ListaRoles.
              "<option value='".$TipoRol."'>".$NombreRol."</option>";
       }  
       $ListaCC='';
       $SqlCC="Select * from admcentrocosto";
       $ResultCC=  mysqli_query($conexion, $SqlCC);
       while($reg_CC=  mysqli_fetch_array($ResultCC))
       {
           $TipoCC=$reg_CC['IdCentroCosto'];
           $NombreCC=$reg_CC['DescripcionCentroCosto'];
           $ListaCC=$ListaCC.
              "<option value='".$TipoCC."'>".$NombreCC."</option>";
       }   
       $ListaEstados='';
       $SqlEstados="SELECT * FROM admestados ";
       $rsestados= mysqli_query($conexion,$SqlEstados);
       $descEstado = $regEstados['DescripcionEstado'];
       while($regEstados=  mysqli_fetch_array($rsestados))
       {
           $IdEstado=$regEstados['IdEstado'];
           $DescripcionEstado=$regEstados['DescripcionEstado'];
           $ListaEstados.=
              "<option value='".$IdEstado."'>".$DescripcionEstado."</option>";
       }  

     } 
 ?>
       

<head>
			<title> SISTEMA IMPORTBOOKS</title>
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
  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' action='GrabarUsuario.php'>  
      <div class='container'>
        <div class='panel panel-default'>
            <?php echo"<div class='panel-heading' style='font-size: 20px;color:#0080FF;font-weight:bold;'>Nuevo Usuario
              <button class='btn btn-primary btn-sm' title='Regresar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' onClick='window.location=\"ConsultaUsuarios.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span></button>";?>
            <?php echo"<button class='btn btn-primary btn-sm' title='Grabar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' type='submit'> <span class='glyphicon glyphicon-floppy-disk'></span> </button>";?>
              <button class='btn btn-primary btn-sm' title='Limpiar' style='font-size:16px;color:#0080FF;background-color:#FFBF00;border:none' type='button'><span class='glyphicon glyphicon-refresh'></span> </button>                 
            </div>
          <div class="panel-body">
              <div class="panel-body" style="width:75%; float:left; display:block;"> 
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
                    <label style='color:#0080FF'  for="f_nombres">&nbsp&nbspCédula:</label>
                    <input style='color:#0080FF' type="text" name='Cedula' class="form-control" id="Cedula" placeholder="No. Cédula">
                  </div>
                </div>       
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF'  for="f_nombres">&nbsp&nbspCentro Costo:</label>
                    <select style='color:#0080FF' id='cc' name='cc' class="form-control" id="cc" required>
                        <option value=''>Seleccionar</option>
                        <?php
                           echo $ListaCC;
                         ?>
                    </select> 
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
                  <div class="form-group col-md-4">
                    <label style='color:#0080FF'  for="f_telefonos">Teléfonos:</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="Telefonos" name="Telefonos" placeholder="Teléfonos">
                  </div>
                </div>   
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label style='color:#0080FF'  for="f_LugarNacimiento">Lugar Nacimiento:</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="LugarNacimiento" name="LugarNacimiento" placeholder="Lugar Nacimiento">
                  </div>
                </div>  
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label style='color:#0080FF'  for="f_fechaNac">Fecha Nacimiento:</label>
                    <input style='color:#0080FF' type="date" class="form-control" id="fechaNac" name="fechaNac">
                  </div>
                </div>  
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="estado">&nbsp&nbspEstado:</label>
                      <select style='color:#0080FF' id='Estado' name='Estado' class='form-control' required' >
                        <option value=''>Seleccionar</option>
                        <?php
                           echo $ListaEstados;
                         ?>
                      </select>          
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
   
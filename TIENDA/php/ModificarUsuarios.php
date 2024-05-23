<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       
      include("Conexion.php");    
      $v_usuario=$_REQUEST['IdUsuario'];
      $SqlDatosUsuario="Select * from admusuarios where IdUsuario='".$v_usuario."'";
      $ResultSetUsuario=  mysqli_query($conexion,$SqlDatosUsuario);
      $regUsuario=mysqli_fetch_assoc($ResultSetUsuario);
      $v_UserName=$regUsuario['UserName'];
      $v_CedulaUsuario=$regUsuario['CedulaUsuario'];
      $v_NombresUsuario= $regUsuario['NombresUsuario'];
      $v_ApellidosUsuario= $regUsuario['ApellidosUsuario']; 
      $v_Password=$regUsuario['Password'];
      $v_EmailUsuario=$regUsuario['EmailUsuario'];
      $v_IdArea=$regUsuario['IdArea'];
      $v_IdTipoUsuario=$regUsuario['IdTipoUsuario'];
      $v_Telefonos=$regUsuario['Telefonos'];
      $v_Direccion=$regUsuario['Direccion'];
      $v_FechaNacimiento=$regUsuario['FechaNacimiento'];
      $v_LugarNacimiento=$regUsuario['LugarNacimiento'];
      $v_EstadoUsuario=$regUsuario['EstadoUsuario'];


       #Obtener datos de los roles
       $ListaRoles='';
       $SqlRoles="Select * from admtipousuario where IdTipoUsuario=".$v_IdTipoUsuario;
       $ResultRoles=  mysqli_query($conexion, $SqlRoles);
       $reg_Roles=  mysqli_fetch_assoc($ResultRoles);
       $IdTipoUsuario=$reg_Roles['IdTipoUsuario'];
       $DescripcionTipoUsuario=$reg_Roles['DescripcionTipoUsuario'];
       $ListaRoles.="<option value='".$IdTipoUsuario."' Selected>".$DescripcionTipoUsuario."</option>";
       $SqlRoles="Select * from admtipousuario";
       $ResultRoles=  mysqli_query($conexion, $SqlRoles);
       while($reg_Roles=  mysqli_fetch_array($ResultRoles))
       {
           $TipoRol=$reg_Roles['IdTipoUsuario'];
           $NombreRol=$reg_Roles['DescripcionTipoUsuario'];
           $ListaRoles.="<option value='".$TipoRol."'>".$NombreRol."</option>";
       }  
       #Obtener lista de centrocosto
       $ListaCC='';
       $SqlCC="Select * from admcentrocosto where IdCentroCosto=".$v_IdArea;
       $ResultCC  =  mysqli_query($conexion, $SqlCC);
       $reg_CC    =  mysqli_fetch_assoc($ResultCC);
       $IdCentroCosto=$reg_CC['IdCentroCosto'];
       $DescripcionCC=$reg_CC['DescripcionCentroCosto'];
       $ListaCC="<option value='".$IdCentroCosto."' Selected>".$DescripcionCC."</option>";

       $SqlCC="Select * from admcentrocosto ";
       $ResultCC  =  mysqli_query($conexion, $SqlCC);
       $reg_CC    =  mysqli_fetch_assoc($ResultCC);
       while($reg_CC=  mysqli_fetch_array($ResultCC))
       {
          $IdCentroCosto=$reg_CC['IdCentroCosto'];
          $DescripcionCC=$reg_CC['DescripcionCentroCosto'];
          $ListaCC.="<option value='".$IdCentroCosto."' >".$DescripcionCC."</option>";
       }  
       #Obtener lista de estados
       $ListaEstados='';
       $SqlEstados  ="SELECT * FROM admestados where IdEstado='".$v_EstadoUsuario."'";
       $rsestados   = mysqli_query($conexion,$SqlEstados);
       $regEstados  = mysqli_fetch_assoc($rsestados);
       $IdEstado    = $regEstados['IdEstado'];
       $descEstado  = $regEstados['DescripcionEstado'];
       $ListaEstados="<option value='".$IdEstado."' Selected>".$descEstado."</option>";

       $SqlEstados="SELECT * FROM admestados ";
       $rsestados= mysqli_query($conexion,$SqlEstados);
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
  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' action='ActualizaUsuario.php'>  
      <div class='container'>
        <div class='panel panel-default'>
            <?php echo"<div class='panel-heading' style='font-size: 20px;color:#0080FF;font-weight:bold;'>Modificar Usuario
              <button class='btn btn-primary btn-sm' title='Regresar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' onClick='window.location=\"ConsultaUsuarios.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span></button>";?>
            <?php echo"<button class='btn btn-primary btn-sm' title='Grabar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' type='submit'> <span class='glyphicon glyphicon-floppy-disk'></span> </button>";?>               
            </div>
          <div class="panel-body">
              <div class="panel-body" style="width:75%; float:left; display:block;"> 
                <div class="form-row">
                  <input type='hidden' name='IdUsuario' value='<?php echo $v_usuario;?>'>
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="f_usuario">&nbsp&nbspUsuario:&nbsp&nbsp</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="Usuario" name="Usuario" readonly='yes' value='<?php echo $v_UserName;?>'>
                  </div>
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="inputPassword4">Password:</label>
                    <input style='color:#0080FF' type="password" name='Clave' class="form-control" id="Clave" readonly='yes' value='<?php echo $v_Password;?>'>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label style='color:#0080FF'  for="f_apellidos">&nbsp&nbspApellidos: </label>
                    <input style='color:#0080FF' type="text" class="form-control" id="Apellidos" name='Apellidos' placeholder="Apellidos"  value='<?php echo $v_ApellidosUsuario;?>'>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label style='color:#0080FF'  for="f_nombres">&nbsp&nbspNombres:</label>
                    <input style='color:#0080FF' type="text" name='Nombres' class="form-control" id="Nombres" placeholder="Nombres" value='<?php echo $v_NombresUsuario;?>'>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF'  for="f_nombres">&nbsp&nbspCédula:</label>
                    <input style='color:#0080FF' type="text" name='Cedula' class="form-control" id="Cedula" placeholder="No. Cédula" value='<?php echo $v_CedulaUsuario;?>'>
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
                    <input style='color:#0080FF' type="text" class="form-control" id="email" name="email" placeholder="Email" value='<?php echo $v_EmailUsuario;?>'>
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
                    <input style='color:#0080FF' type="text" class="form-control" id="Telefonos" name="Telefonos" placeholder="Teléfonos" value='<?php echo $v_Telefonos;?>'>
                  </div>
                </div>   
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label style='color:#0080FF'  for="f_LugarNacimiento">Lugar Nacimiento:</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="LugarNacimiento" name="LugarNacimiento" placeholder="Lugar Nacimiento" value='<?php echo $v_LugarNacimiento;?>'>
                  </div>
                </div>  
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label style='color:#0080FF'  for="f_fechaNac">Fecha Nacimiento:</label>
                    <input style='color:#0080FF' type="date" class="form-control" id="fechaNac" name="fechaNac" value='<?php echo $v_FechaNacimiento;?>'>
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
   
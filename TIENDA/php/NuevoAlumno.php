<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       
       include("Conexion.php");    
       ###############################################################################
       #Obtener datos de las Etnia                                                   #
       ###############################################################################
       $ListaEtnias='';
 

       $SqlEtnias="Select * from etnias ";
       $ResultEtnias=  mysqli_query($conexion, $SqlEtnias);
       while($reg_Etnias=  mysqli_fetch_array($ResultEtnias))
       {
           $Etnia=$reg_Etnias['IdEtnia'];
           $NombreEtnia=$reg_Etnias['EtniaDescripcion'];
           $ListaEtnias.= "<option value='".$Etnia."' >".$NombreEtnia."</option>";
              
       }           
      
       ###############################################################################################
       #Obtener datos Sexo                                                                           #
       ###############################################################################################
  
       $ListaSexo='';
       $SqlSexo="Select * from sexo ";
       $ResultSexo=  mysqli_query($conexion, $SqlSexo);
       while($reg_Sexo=  mysqli_fetch_array($ResultSexo))
       {
           $Sexo=$reg_Sexo['IdSexo'];
           $NombreSexo=$reg_Sexo['SexoDescripcion'];
           $ListaSexo.= "<option value='".$Sexo."' >".$NombreSexo."</option>";
              
       }     
       // becas
       $ListaBecas='';
       $SqlBecas="Select * from becas ";
       $ResultBecas=  mysqli_query($conexion, $SqlBecas);
       while($reg_becas=  mysqli_fetch_array($ResultBecas))
       {
           $beca=$reg_becas['idbeca'];
           $NombreBeca=$reg_becas['descripcionbeca'];
           $ListaBecas.= "<option value='".$beca."' >".$NombreBeca."</option>";
              
       }  
        // parentesco
       $ListaParentesco='';
       $Sql="Select * from parentesco ";
       $rs=  mysqli_query($conexion, $Sql);
       while($reg=  mysqli_fetch_array($rs))
       {
           $IdParentesco=$reg['IdParentesco'];
           $DescripcionParentesco=$reg['DescripcionParentesco'];
           $ListaParentesco.= "<option value='".$IdParentesco."' >".$DescripcionParentesco."</option>";
              
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
      <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' action='GrabarNuevoAlumno.php'>   
       <section   style='color:#0080FF; background-color: #FFBF00' ;font-family: Verdana' >
            <h2 align=left>&nbspNUEVO ALUMNO
               <?php echo "<button class='btn btn-primary btn-lg' title='Regresar' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span> </button>";?>
               <?php          
               echo "<button id='btn_grabar' class='btn btn-primary btn-lg' title='Grabar' onclick='' type='submit' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none'><span class='glyphicon glyphicon-floppy-save'></span></button>";
               ?>
               <button class='btn btn-primary btn-lg' title='Limpiar btn-lg' onclick='' type='reset' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none'><span class='glyphicon glyphicon-refresh'></span></button> 
            </h2>
        </section >

        <div class="form-row">
          <div class="form-group col-md-12">
            <label style='color:#0080FF' for="f_cedula">&nbsp&nbspCédula:&nbsp&nbsp</label>
            <input style='color:#0080FF' type="text" class="form-control" id="Cedula" name='Cedula' placeholder="Cédula" onblur='return VerificarAlumno()'>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label style='color:#0080FF'  for="f_apellidos">&nbsp&nbspApellidos: </label>
            <input style='color:#0080FF' type="text" class="form-control" id="Apellidos" name='Apellidos' placeholder="Apellidos">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label style='color:#0080FF'  for="f_nombres">&nbsp&nbspNombres:</label>
            <input style='color:#0080FF' type="text"  id="Nombres" name='Nombres' class="form-control" placeholder="Nombres">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-3">
            <label style='color:#0080FF' for="BirthDay:">BirthDay:</label>
            <input style='color:#0080FF' type='date' class="form-control" id="FechaNacimiento" name='FechaNacimiento' required value=''>
          </div>
          <div class="form-group col-md-3">
            <label style='color:#0080FF' for="inputState">BirthPlace:</label>
            <input style='color:#0080FF' type='text' class="form-control" id="LugarNacimiento" name='LugarNacimiento' required value=''>
          </div>
          <div class="form-group col-md-3">
            <label  style='color:#0080FF' for="Sexo">Sexo:</label>
            <select style='color:#0080FF' id='Sexo' name='Sexo' class='form-control input-sm' required' >
                <option value=''>Seleccionar</option>".
                   <?php echo $ListaSexo;?>
            </select>
          </div>
          <div class="form-group col-md-3">
            <label style='color:#0080FF' for="Celular">Celular:</label>
            <input style='color:#0080FF' type='text' class="form-control" id="Celular" name='Celular' required value=''>
          </div>          
        </div>
         <input type='hidden'  id='IdRepresentante' name='IdRepresentante' value=''>
         <div class="form-row">      
          
          <div class="form-group col-md-2">
            
            <label style='color:#0080FF' for="Representante">Cédula Representante:</label>
            <input style='color:#0080FF' type='text' class="form-control" id="CedulaRepresentante" name='CedulaRepresentante' required value=''>
          </div>
          <div class="form-group col-md-1">
            <label style='color:#FFFFFF' for="f_buscar">Buscar</label>
            <button style='color:#0080FF' class='btn btn-primary btn-md' title='' onClick="popup('representante')" type='button'> <span class='glyphicon glyphicon-search' ></span> </button>
          </div>
          <div class="form-group col-md-5">
            <label style='color:#0080FF' for="inputState">Nombre Representante:</label>
            <input style='color:#0080FF' type='text' class="form-control" id="NombreRepresentante" name='NombreRepresentante' required value=''>
          </div>
          <div class="form-group col-md-4">
            <label style='color:#0080FF' for="inputState">Parentesco:</label>
            <select style='color:#0080FF' id="Parentesco" name='Parentesco' class='form-control input-sm' required' >
                <option value=''>Seleccionar</option>".
                   <?php echo $ListaParentesco;?>
            </select>


          </div>
        </div>    





        <div class="form-row">
          <div class="form-group col-md-6">
            <label style='color:#0080FF' for="Direccion">Direccion:</label>
            <input style='color:#0080FF' type='text' class="form-control" id="Direccion" name='Direccion' required value=''>
          </div>
          <div class="form-group col-md-3">
            <label style='color:#0080FF' for="inputState">Telefono Convencional:</label>
            <input style='color:#0080FF' type='text' class="form-control" id="TelefonoConvencional" name='TelefonoConvencional' required value=''>
          </div>
          <div class="form-group col-md-3">
            <label  style='color:#0080FF' for="Etnia">Etnia:</label>
            <select  style='color:#0080FF' id='Etnia' name='Etnia' class='form-control input-sm' required >
                <option value=''>Seleccionar</option>
                   <?php echo $ListaEtnias;?>
            </select>
          </div>
        </div>
        


        <div class="form-row">
          <div class="form-group col-md-5">
            <label style='color:#0080FF' for="Representante">Persona Contacto:</label>
            <input style='color:#0080FF' type='text' class="form-control" id='PersonaContacto' name='PersonaContacto' required value=''>
          </div>
          <div class="form-group col-md-3">
            <label style='color:#0080FF' for="telefonoContacto">Telf Contacto:</label>
            <input style='color:#0080FF' type='text' class="form-control" id="telefonoContacto" name='telefonoContacto' required value=''>
          </div>
          <div class="form-group col-md-4">
            <label style='color:#0080FF' for="Enfermedad">Enfermedad:</label>
            <input style='color:#0080FF' type='text' class="form-control" id="Enfermedad" name='Enfermedad' required value=''>
          </div>
        </div>




        <div class="form-row">
           <div class="form-group col-md-3">
            <label  style='color:#0080FF' for="beca">Beca:</label>
            <select  style='color:#0080FF' id='beca' name='beca' class='form-control input-sm' required >
                <option value=''>Seleccionar</option>
                   <?php echo $ListaBecas;?>
            </select>
          </div>  
          <div class="form-group col-md-6">
            <label style='color:#0080FF' for="Email:">Email:</label>
            <input style='color:#0080FF' type='text' class="form-control" id='PersonaContacto' name='Email' required value=''>
          </div>



         </div>  
    </form>
   </div>
 </section>
<p style='font-size:16pt;color:red' id='mi_mensaje' name='mi_mensaje'>  </p>
</body>





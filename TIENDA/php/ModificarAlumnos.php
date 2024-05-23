<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {  
       include("Conexion.php");    
       $v_IdAlumno=$_REQUEST['IdAlumno'];
       $SqlAlumnos="Select * from alumnos where IdAlumno=$v_IdAlumno";
       $ResultSetAlumnos=  mysqli_query($conexion,$SqlAlumnos);
       $reg_Alumnos=mysqli_fetch_assoc($ResultSetAlumnos);
       //Datos alumnos para mostrar
            $v_IdAlumno                 = $reg_Alumnos['IdAlumno'];
            $v_Cedula                   = $reg_Alumnos['Cedula'];
            $v_Apellidos                = $reg_Alumnos['Apellidos'];
            $v_Nombres                  = $reg_Alumnos['Nombres'];
            $v_LugarNacimiento          = $reg_Alumnos['LugarNacimiento'];
            $v_FechaNacimiento          = $reg_Alumnos['FechaNacimiento'];
            $v_IdRepresentante          = $reg_Alumnos['IdRepresentante'];
            $v_IdParentesco             = $reg_Alumnos['IdParentesco'];
            $v_Sexo                     = $reg_Alumnos['Sexo'];
            $v_Direccion                = $reg_Alumnos['direccion1'];
            $v_Telefono                 = $reg_Alumnos['TelefonoConvencional1'];
            $v_TelefonoMovil            = $reg_Alumnos['TelefonoMovil'];
            $v_PersonaContacto          = $reg_Alumnos['PersonaContacto'];
            $v_PersonaContactoTelefono  = $reg_Alumnos['PersonaContactoTelefono'];
            $v_Email                    = $reg_Alumnos['Mail'];
            $v_foto                     = $reg_Alumnos['Foto'];
            $v_Etnia                    = $reg_Alumnos['idEtnia'];
            $v_beca                     = $reg_Alumnos['IdBeca'];
            $v_Enfermedad               = $reg_Alumnos['Enfermedades'];
            $v_Estado                   = $reg_Alumnos['Estado'];
      #**************************************
      #  Obtener nombre del representante
      #**************************************
            if($v_IdRepresentante==null){
                $v_nombresRepresentante= '';
                $v_cedulaRepresentante = '';
            }
            else
            { 
                $Sql="Select * from representantes where IdRepresentante=".$v_IdRepresentante;
       
                $rs=  mysqli_query($conexion, $Sql);
                $reg=  mysqli_fetch_array($rs);
                $v_nombresRepresentante= $reg['apellidos'].' '.$reg['nombres'];
                $v_cedulaRepresentante = $reg['cedula'];
            }

       ###############################################################################
       #Obtener datos de las Etnia                                                   #
       ###############################################################################
       $ListaEtnias='';
       $SqlEtnias="Select * from etnias where IdEtnia=".$v_Etnia;
       $ResultEtnias=  mysqli_query($conexion, $SqlEtnias);
       $reg_Etnias=  mysqli_fetch_array($ResultEtnias);
       $Etnia=$reg_Etnias['IdEtnia'];
       $NombreEtnias=$reg_Etnias['EtniaDescripcion'];
       $ListaEtnias.="<option value='".$Etnia."' Selected>".$NombreEtnias."</option>";    

       $SqlEtnias="Select * from etnias where IdEtnia!=".$v_Etnia;
       $ResultEtnias=  mysqli_query($conexion, $SqlEtnias);
       while($reg_Etnias=  mysqli_fetch_array($ResultEtnias))
       {
           $Etnias=$reg_Etnias['IdEtnia'];
           $NombreEtnias=$reg_Etnias['EtniaDescripcion'];
           $ListaEtnias.= "<option value='".$Etnia."' >".$NombreEtnias."</option>";
              
       }                
       ###############################################################################################
       #Obtener datos Sexo                                                                           #
       ###############################################################################################
       $ListaSexo='';
       $SqlSexo="Select * from sexo where IdSexo='".$v_Sexo."'";
       $ResultSexo=  mysqli_query($conexion, $SqlSexo);
       $reg_Sexo=  mysqli_fetch_assoc($ResultSexo);
       $Sexo=$reg_Sexo['IdSexo'];
       $NombreSexo=$reg_Sexo['SexoDescripcion'];
       $ListaSexo.="<option value='".$Sexo."' Selected>".$NombreSexo."</option>";    

       $SqlSexo="Select * from sexo where IdSexo !='".$v_Sexo."'";
       $ResultSexo=  mysqli_query($conexion, $SqlSexo);
       while($reg_Sexo=  mysqli_fetch_array($ResultSexo))
       {
           $Sexo=$reg_Sexo['IdSexo'];
           $NombreSexo=$reg_Sexo['SexoDescripcion'];
           $ListaSexo.= "<option value='".$Sexo."' >".$NombreSexo."</option>";     
       }     
       #############################################################################################
       # becas
       #############################################################################################
       $ListaBecas='';
       if($v_beca!=null)
       { 
          $Sqlbecas="Select * from becas where idbeca=".$v_beca;
          $Resultbecas=  mysqli_query($conexion, $Sqlbecas);
          $reg_becas=  mysqli_fetch_assoc($Resultbecas);
          $beca=$reg_becas['idbeca'];
          $NombreBeca=$reg_becas['descripcionbeca'];
          $ListaBecas.="<option value='".$beca."' Selected>".$NombreBeca."</option>";    
    

         $Sqlbecas="Select * from becas where idbeca !=".$v_beca;
         $Resultbecas=  mysqli_query($conexion, $Sqlbecas);
         while($reg_becas=  mysqli_fetch_array($Resultbecas))
         {
             $Beca=$reg_becas['idbeca'];
             $NombreBeca=$reg_becas['descripcionbeca'];
             $ListaBecas.= "<option value='".$Beca."' >".$NombreBeca."</option>";     
         }     
       }
       else
       {
         $Sqlbecas="Select * from becas order by 1 ";
         $Resultbecas=  mysqli_query($conexion, $Sqlbecas);
         while($reg_becas=  mysqli_fetch_array($Resultbecas))
         {
             $Beca=$reg_becas['idbeca'];
             $NombreBeca=$reg_becas['descripcionbeca'];
             $ListaBecas.= "<option value='".$Beca."' >".$NombreBeca."</option>";     
         }           
       }

       #*****************************************************
       #  Obtener informacion de los parentesco
       #*****************************************************
       $ListaParentesco='';
            if($v_IdParentesco==null){
                 $ListaParentesco.= "<option value=''></option>";
                 $Sql="Select * from parentesco ";
                 $rs=  mysqli_query($conexion, $Sql);
                 while($reg=  mysqli_fetch_array($rs))
                 {
                     $IdParentesco=$reg['IdParentesco'];
                     $DescripcionParentesco=$reg['DescripcionParentesco'];
                     $ListaParentesco.= "<option value='".$IdParentesco."' >".$DescripcionParentesco."</option>";
                 }  
            }
            else
            { 
                 $Sql="Select * from parentesco where IdParentesco=".$v_IdParentesco;
                 $rs=  mysqli_query($conexion, $Sql);
                 while($reg=  mysqli_fetch_array($rs))
                 {
                     $IdParentesco=$reg['IdParentesco'];
                     $DescripcionParentesco=$reg['DescripcionParentesco'];
                     $ListaParentesco.= "<option value='".$IdParentesco."' Selected>".$DescripcionParentesco."</option>";
                        
                 }       
                 $Sql="Select * from parentesco where IdParentesco !=".$v_IdParentesco;
                 $rs=  mysqli_query($conexion, $Sql);
                 while($reg=  mysqli_fetch_array($rs))
                 {
                     $IdParentesco=$reg['IdParentesco'];
                     $DescripcionParentesco=$reg['DescripcionParentesco'];
                     $ListaParentesco.= "<option value='".$IdParentesco."' >".$DescripcionParentesco."</option>";
                        
                 }
            }
       // Estados
       $ListaEstado='';
       $v_descEstado='';
       if($v_Estado=='A') {
          $v_descEstado="Activo";
       } 
       if($v_Estado=='I') {
          $v_descEstado="Inactivo";
       }     
       $ListaEstado.= "<option value='$v_Estado' Selected>$v_descEstado</option>";    
       $ListaEstado.= "<option value='A' >Activo</option>";     
       $ListaEstado.= "<option value='I' >Inactivo</option>";


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
      <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' action='ActualizarAlumno.php'>   
       <section   style='color:#0080FF; background-color: #FFBF00' ;font-family: Verdana' >
            <h2 align=left>&nbspMODIFICAR ALUMNOS
               <?php echo "<button class='btn btn-primary btn-lg' title='Regresar' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none' onClick='window.location=\"ConsultaAlumnos.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span> </button>";?>
               <?php          
               echo "<button id='btn_grabar' class='btn btn-primary btn-lg' title='Grabar' onclick='' type='submit' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none'><span class='glyphicon glyphicon-floppy-save'></span></button>";
               ?>
               <button class='btn btn-primary btn-lg' title='Limpiar btn-lg' onclick='' type='reset' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none'><span class='glyphicon glyphicon-refresh'></span></button> 
            </h2>
        </section >

 
         <div class="form-row">
           <div class="form-group col-md-6">
             <label style='color:#0080FF' for='f_cedula'>&nbsp&nbspId Alumno:&nbsp&nbsp</label>
             <input style='color:#0080FF' type="text" class="form-control" id="IdAlumno" name='IdAlumno' readonly value='<?php echo $v_IdAlumno;?>'>
           </div>
           <div class="form-group col-md-6">
             <label style='color:#0080FF' for='f_cedula'>&nbsp&nbspCédula:&nbsp&nbsp</label>
             <input style='color:#0080FF' type="text" class="form-control" id="Cedula" name='Cedula' readonly value='<?php echo $v_Cedula;?>'>
           </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label style='color:#0080FF'  for="f_apellidos">&nbsp&nbspApellidos: </label>
            <input style='color:#0080FF' type="text" class="form-control" id="Apellidos" name='Apellidos' placeholder="Apellidos" value='<?php echo $v_Apellidos;?>'>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label style='color:#0080FF'  for="f_nombres">&nbsp&nbspNombres:</label>
            <input style='color:#0080FF' type="text"  id="Nombres" name='Nombres' class="form-control" placeholder="Nombres" value='<?php echo $v_Nombres;?>'>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-3">
            <label style='color:#0080FF' for="BirthDay:">BirthDay:</label>
            <input style='color:#0080FF' type='date' class="form-control" id="FechaNacimiento" name='FechaNacimiento' required value='<?php echo $v_FechaNacimiento;?>'>
          </div>
          <div class="form-group col-md-3">
            <label style='color:#0080FF' for="inputState">BirthPlace:</label>
            <input style='color:#0080FF' type='text' class="form-control" id="LugarNacimiento" name='LugarNacimiento' required value='<?php echo $v_LugarNacimiento;?>'>
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
            <input style='color:#0080FF' type='text' class="form-control" id="Celular" name='Celular' required value='<?php echo $v_TelefonoMovil;?>'>
          </div>          
        </div>
         <input type='hidden'  id='IdRepresentante' name='IdRepresentante' value='<?php echo $v_IdRepresentante;?>' />
         <div class="form-row">      
          
          <div class="form-group col-md-2">
            
            <label style='color:#0080FF' for="Representante">Cédula Representante:</label>
            <input style='color:#0080FF' type='text' class="form-control" id="CedulaRepresentante" name='CedulaRepresentante' required value='<?php echo $v_cedulaRepresentante;?>'>
          </div>
          <div class="form-group col-md-1">
            <label style='color:#FFFFFF' for="f_buscar">Buscar</label>
            <button style='color:#0080FF' class='btn btn-primary btn-md' title='' onClick="popup('representante')" type='button'> <span class='glyphicon glyphicon-search' ></span> </button>
          </div>
          <div class="form-group col-md-5">
            <label style='color:#0080FF' for="inputState">Nombre Representante:</label>
            <input style='color:#0080FF' type='text' class="form-control" id="NombreRepresentante" name='NombreRepresentante' required value='<?php echo $v_nombresRepresentante;?>'>
          </div>
          <div class="form-group col-md-4">
            <label style='color:#0080FF' for="inputState">Parentesco:</label>
            <select style='color:#0080FF' id="Parentesco" name='Parentesco' class='form-control input-sm' required="true">
                <option value=''>Seleccionar</option>".
                   <?php echo $ListaParentesco;?>
            </select>


          </div>
        </div>    

        <div class="form-row">
          <div class="form-group col-md-6">
            <label style='color:#0080FF' for="Direccion">Direccion:</label>
            <input style='color:#0080FF' type='text' class="form-control" id="Direccion" name='Direccion' required value='<?php echo $v_Direccion;?>'>
          </div>
          <div class="form-group col-md-3">
            <label style='color:#0080FF' for="inputState">Telefono Convencional:</label>
            <input style='color:#0080FF' type='text' class="form-control" id="TelefonoConvencional" name='TelefonoConvencional' required value='<?php echo $v_Telefono;?>'>
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
            <input style='color:#0080FF' type='text' class="form-control" id='PersonaContacto' name='PersonaContacto' required value='<?php echo $v_PersonaContacto;?>'>
          </div>
          <div class="form-group col-md-3">
            <label style='color:#0080FF' for="telefonoContacto">Telf Contacto:</label>
            <input style='color:#0080FF' type='text' class="form-control" id="telefonoContacto" name='telefonoContacto' required value='<?php echo $v_PersonaContactoTelefono;?>'>
          </div>
          <div class="form-group col-md-4">
            <label style='color:#0080FF' for="Enfermedad">Enfermedad:</label>
            <input style='color:#0080FF' type='text' class="form-control" id="Enfermedad" name='Enfermedad' required value='<?php echo $v_Enfermedad;?>'>
          </div>
        </div>




        <div class="form-row">
          <div class="form-group col-md-6">
            <label style='color:#0080FF' for="Email:">Email:</label>
            <input style='color:#0080FF' type='text' class="form-control" id='PersonaContacto' name='Email' required value='<?php echo $v_Email;?>'>
          </div>
          <div class="form-group col-md-3">
            <label  style='color:#0080FF' for="Estado">Estado:</label>
            <select  style='color:#0080FF' id='Estado' name='Estado' class='form-control input-sm' required >
                   <?php echo $ListaEstado;?>
            </select>
          </div>
           <div class="form-group col-md-3">
            <label  style='color:#0080FF' for="beca">Beca:</label>
            <select  style='color:#0080FF' id='beca' name='beca' class='form-control input-sm' required >
                   <?php echo $ListaBecas;?>
            </select>
          </div>  

         </div>  
    </form>
   </div>
 </section>
<p style='font-size:16pt;color:red' id='mi_mensaje' name='mi_mensaje'>  </p>
</body>





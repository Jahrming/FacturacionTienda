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
    <form id='formulario'  role='form' method='POST' enctype='multipart/form-data' action='GrabarNuevoRepresentante.php'>
       <section   style='color:#0080FF; background-color: #FFBF00' ;font-family: Verdana' >
            <h2 align=left>&nbspNUEVO REPRESENTANTE
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
            <input style='color:#0080FF' type="text" class="form-control" id="Cedula" name='Cedula' placeholder="Cédula">
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
            <input style='color:#0080FF' type="text" name='Nombres' class="form-control" id="Nombres" placeholder="Nombres">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label style='color:#0080FF' for="Celular">Celular:</label>
            <input style='color:#0080FF' type='text' class="form-control" id="Celular" name='Celular' required value=''>
          </div>          
          <div class="form-group col-md-8">
            <label style='color:#0080FF' for="Direccion">Direccion:</label>
            <input style='color:#0080FF' type='text' class="form-control" id="Direccion" name='Direccion' required value=''>
          </div>
        </div>  
        <div class="form-row">
          <div class="form-group col-md-4">
            <label style='color:#0080FF' for="inputState">Telefonos :</label>
            <input style='color:#0080FF' type='text' class="form-control" id="Telefonos" name='Telefonos' required value=''>
          </div>
          <div class="form-group col-md-4">
            <label style='color:#0080FF' for="Representante">Email:</label>
            <input style='color:#0080FF' type='text' class="form-control" id='Email' name='Email' required value=''>
          </div>
          <div class="form-group col-md-4">
              <label  style='color:#0080FF' for="estado">Estado:</label>
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





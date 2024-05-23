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
       $ListaCursos='';
 

       $Sql="Select c.IdCurso as IdCurso,n.NivelDescripcion as NombreNivel,f.descripcionFormacion as DescFormacion, ".
       				 " c.IdParalelo as IdParalelo ".
       				"from cursos c,niveles n, formaciones f ".
       			   " where c.idNivel = n.idNivel ".
       			   "   and c.IdFormacion = f.IdFormacion ";

       $rs=  mysqli_query($conexion, $Sql);
       while($reg=  mysqli_fetch_array($rs))
       {
           $IdCurso=$reg['IdCurso'];
           $DescCurso=$reg['NombreNivel'].' '.$reg['IdParalelo'].' '.$reg['DescFormacion'];
           $ListaCursos.= "<option value='".$IdCurso."' >".$DescCurso."</option>";
              
       }           
      
       ###############################################################################################
       #Obtener datos Sexo                                                                           #
       ###############################################################################################
  
       $ListaSexo='';
       $SqlSexo="Select * from Sexo ";
       $ResultSexo=  mysqli_query($conexion, $SqlSexo);
       while($reg_Sexo=  mysqli_fetch_array($ResultSexo))
       {
           $Sexo=$reg_Sexo['IdSexo'];
           $NombreSexo=$reg_Sexo['SexoDescripcion'];
           $ListaSexo.= "<option value='".$Sexo."' >".$NombreSexo."</option>";
              
       }     
  
   }
  ?>
<!DOCTYPE html>
<html>
	<head>
	  <title> SISTEMA ACADEMICO </title>
	  <script type='text/javascript' language='javascript' src='../js/funciones.js'> 			</script>
	  <script type='text/javascript' language='javascript' src='../js/alertifyjs/alertify.js'> 	</script>
	  <script type='text/javascript' language='javascript' src='../js/jquery.js'> 				</script>
	  <meta http-equiv='Content-Type' content='text/html'; charset='utf-8'/>
	  <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'/>
	  <link rel='stylesheet' href='../css/estilos.css' >
	  <link rel='stylesheet' href='../css/bootstrap.min.css'>
	  <link rel='stylesheet' href='../js/alertifyjs/css/alertify.css'>
	</head>
<!---   <body onload='return inicio(\"\")'>    -->
<body>

<section>
    <div class='container'>   
    <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' action='GrabarRegistroMatricula.php'>
       <section   style='color:#0080FF; background-color: #FFBF00' ;font-family: Verdana' >
            <h2 align=left>&nbspREGISTRO MATRICULA
               <?php echo "<button class='btn btn-primary btn-lg' title='Regresar' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span> </button>";?>
               <?php          
               echo "<button id='btn_grabar' class='btn btn-primary btn-lg' title='Grabar' onclick='' type='submit' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none'><span class='glyphicon glyphicon-floppy-save'></span></button>";
               ?>
               <button class='btn btn-primary btn-lg' title='Limpiar btn-lg' onclick='' type='reset' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none'><span class='glyphicon glyphicon-refresh'></span></button> 
            </h2>
        </section >
        <input type='hidden' id='IdRepresentante' name='IdRepresentante' value=''/>
        <div class="form-row">
          <div class="form-group col-md-3">
            <label style='color:#0080FF' for="f_cedula">&nbsp&nbspCédula Representante:&nbsp&nbsp</label>
            <input style='color:#0080FF' type="text" class="form-control" id="CedulaRepresentante" name='CedulaRepresentante' placeholder="CedulaRepresentante">
          </div>
          <div class="form-group col-md-1">
          	<label style='color:#FFFFFF' for="f_buscar">Bus</label>
            <button style='color:#0080FF' class='btn btn-primary btn-md' title='' onClick="popup('representante')" type='button'> <span class='glyphicon glyphicon-search' ></span> </button>
          </div>
		  <div class="form-group col-md-8">
            <label style='color:#0080FF'  for="f_apellidos">&nbsp&nbspNombres Respresentante: </label>
            <input style='color:#0080FF' type="text" class="form-control" id="NombreRepresentante" name='NombreRepresentante' readonly="yes">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-2">
            <label style='color:#0080FF' for="f_cedula">&nbspId Estudiante:&nbsp&nbsp</label>
            <input style='color:#0080FF' type="text" class="form-control" id="IdEstudiante" name='IdEstudiante' placeholder="Id Estudiante" readonly="yes">
          </div>

          <div class="form-group col-md-3">
            <label style='color:#0080FF' for="f_cedula">&nbsp&nbspCédula Estudiante:&nbsp&nbsp</label>
            <input style='color:#0080FF' type="text" class="form-control" id="Cedula" name='CedulaEstudiante' placeholder="CédulaEstudiante" readonly="yes">
          </div>

          <div class="form-group col-md-1">
          	<label style='color:#FFFFFF' for="f_buscarEstudiante">Finder</label>
            <button style='color:#0080FF' class='btn btn-primary btn-md' title='' onClick=
            	popup_estudiante(document.getElementById('IdRepresentante').value)
            	 type='button'> <span class='glyphicon glyphicon-search' ></span> </button>
          </div>

          <div class="form-group col-md-6">
            <label style='color:#0080FF'  for="f_apellidos">&nbsp&nbspNombres Estudiante: </label>
            <input style='color:#0080FF' type="text" class="form-control" id="NombresEstudiante" name='NombresEstudiante' readonly="yes">
          </div>
        </div>


	  <div class="form-row">
          <div class="form-group col-md-4">
            <label  style='color:#0080FF' for="Curso">Curso:</label>
            <select style='color:#0080FF' id='Curso' name='Curso' class='form-control input-sm' required' >
                <option value=''>Seleccionar</option>
                   <?php echo $ListaCursos;?>
            </select>
          </div>     
          <div class="form-group col-md-8">
            <label style='color:#0080FF'  for="f_PersonaMatricula">&nbsp&nbspPersona Matricula: </label>
            <input style='color:#0080FF' type="text" class="form-control" id="PersonaMatricula" name='PersonaMatricula' >
          </div>            	
      </div>

    </form>
   </div>
 </section>
<p style='font-size:16pt;color:red' id='mi_mensaje' name='mi_mensaje'>  </p>
</body>
</html>






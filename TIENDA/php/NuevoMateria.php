<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       
       include("conexion.php");    
       $CodigoHtml='' ;
       #btener datos de los tickets
       

       #Obtener datos de los niveles
       $ListaNiveles='';
       $SqlNiveles="Select * from niveles ";
       $ResultNiveles=  mysqli_query($conexion, $SqlNiveles);
       while($reg_Niveles=  mysqli_fetch_array($ResultNiveles))
       {
           $CodigoNivel=$reg_Niveles['idNivel'];
           $NombreNivel=$reg_Niveles['NivelDescripcion'];
           $ListaNiveles=$ListaNiveles.
                   "<option value='".$CodigoNivel."'>".$NombreNivel."</option>";
              
       }  
       
       #Obtener datos de los paralelos
       $ListaParalelos='';
       $SqlParalelos="Select * from paralelos";
       $ResultParalelos=  mysqli_query($conexion, $SqlParalelos);
       while($reg_Paralelos=  mysqli_fetch_array($ResultParalelos))
       {
           $CodigoParalelo=$reg_Paralelos['idParalelo'];
           $NombreParalelo=$reg_Paralelos['DescParalelo'];
           $ListaParalelos.=
              "<option value='".$CodigoParalelo."'>".$NombreParalelo."</option>";
       }   
       
       #Obtener datos de los periodos lectivos
       $ListaPeriodosLectivos='';
       $SqlPeriodosLectivos="Select * from PeriodosLectivo";
       $ResultPeriodosLectivos=  mysqli_query($conexion, $SqlPeriodosLectivos);
       while($reg_PeriodosLectivos=  mysqli_fetch_array($ResultPeriodosLectivos))
       {
           $TipoPeriodosLectivos=$reg_PeriodosLectivos['IdPeriodoLectivo'];
           $NombrePeriodosLectivos=$reg_PeriodosLectivos['AnioInicial'].'-'.$reg_PeriodosLectivos['AnioFinal'];
           $ListaPeriodosLectivos=$ListaPeriodosLectivos.
              "<option value='".$TipoPeriodosLectivos."'>".$NombrePeriodosLectivos."</option>";
       }   
       #Obtener datos formacion
       $ListaFormacion='';
       $SqlFormacion="Select * from Formaciones";
       $ResultFormacion=  mysqli_query($conexion, $SqlFormacion);
       while($reg_Formacion=  mysqli_fetch_array($ResultFormacion))
       {
           $IdFormacion=$reg_Formacion['IdFormacion'];
           $NombreFormacion=$reg_Formacion['DescripcionFormacion'];
           $ListaFormacion.=
              "<option value='".$IdFormacion."'>".$NombreFormacion."</option>";
       }               
       
     }
  ?>
<!DOCTYPE html>
<html>
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
<section>

    <form id='formulario'  role='form' method='POST' enctype='multipart/form-data' action='GrabaNuevoMateria.php'>
       <section   style="color:#0080FF; background-color: #FFBF00; font-family:Verdana ;" />
            <h2 align=left>&nbspNUEVO MATERIA
               <?php echo "<button class='btn btn-primary btn-lg' title='Regresar' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span> </button>";?>
               <?php          
               echo "<button id='btn_grabar' class='btn btn-primary btn-lg' title='Grabar' onclick='' type='submit' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none'><span class='glyphicon glyphicon-floppy-save'></span></button>";
               ?>
            </h2>
      </section>
         <div class="form-row">
            <div class="form-group col-md-12">
             <label style='color:#0080FF' for="f_nivel">&nbsp&nbspNiveles:&nbsp&nbsp</label>
             <center><select style='color:#0080FF' id='Nivel' name='IdNivel' class='form-control input-sm' required' >
                <option value=''>Seleccionar</option>
                  <?php echo $ListaNiveles;?>
             </select></center>
            </div>
          
          
            <div class="form-group col-md-12">
             <label style='color:#0080FF' for="f_codigoMateria">&nbsp&nbspCodigo Materia:</label>
             <center><input style='color:#0080FF' id="CodigoMateria" type='text' name='CodigoMateria' class="form-control" placeholder="Codigo Materia"></center>
            </div>
          
        </div>

       <div class="form-row">
          <div class="form-group col-md-12">
            <label style='color:#0080FF' for="f_nombreMateria">&nbsp&nbspNombre Materia:&nbsp&nbsp</label>
              <input style='color:#0080FF' id="NombreMateria" type='text' name='NombreMateria' class="form-control" placeholder="Mombre Materia">
          </div>
          <div class="form-group col-md-12">
            <label style='color:#0080FF' for="inputPassword4">Horas Materia:</label>
            <input style='color:#0080FF' id="HorasMaterias" type='numeric' name='HorasMaterias'  class="form-control" placeholder="Horas  Materias">
          </div>
        </div>


        <div class="form-row">
          <div class="form-group col-md-12">
            <label style='color:#0080FF' for="f_nombreMateria">&nbsp&nbspCréditos:&nbsp&nbsp</label>
            <input style='color:#0080FF' type='numeric' name='Creditos'  class='form-control input-sm' required >
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-12">
            <label style='color:#0080FF' for="f_nombreMateria">&nbsp&nbspEstado:&nbsp&nbsp</label>
              <select id='Estado' name='Estado' class='form-control input-sm' required' >
                <option value=''>Seleccionar</option>
                <option value='A'>Activo</option>
                <option value='I'>Inactivo</option> 
              </select>
          </div>
        </div>  
    </form>
 </section>
<p style='font-size:16pt;color:red' id='mi_mensaje' name='mi_mensaje'>  </p>
</body>
</html>
   
<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       
       
       include("conexion.php");    

       #btener datos de los tickets
       $v_IdMateria=$_REQUEST['IdMateria'];
       $Sql="Select * from materias  where idMaterias=".$v_IdMateria;
       $rs  =   mysqli_query($conexion,$Sql);
       $reg =   mysqli_fetch_assoc($rs);
       $v_codigoMateria=$reg['MateriaCodigo'];
       $v_nombreMateria =$reg['MateriaDescripcion'];
       $v_horasMateria =$reg['MateriasHoras'];
       $v_creditoMateria =$reg['MateriaCredito'];
       $v_estadoMateria =$reg['MateriaEstado'];

       $SqlNiv="Select * from niveles where idNivel =".$v_IdMateria;
       $rsNiveles=  mysqli_query($conexion, $SqlNiv);
       $regNiveles= mysqli_fetch_assoc($rsNiveles);
       $v_IdNivel =$regNiveles['idNivel'];
       $v_Nombre=$regNiveles['NivelDescripcion'];
       $lisNiveles="<option value='".$v_IdNivel."' Selected>".$v_Nombre."</option>";

       $SqlNiv="Select * from niveles where IdNivel !=".$v_IdMateria;
       $rsNiveles=  mysqli_query($conexion, $SqlNiv);
       while ( $regNiveles= mysqli_fetch_assoc($rsNiveles))
       {
         $v_IdNivel =$regNiveles['idNivel'];
         $v_Nombre=$regNiveles['NivelDescripcion'];
         $lisNiveles.="<option value='".$v_IdNivel."'>".$v_Nombre."</option>";        
       }

       $ListaEstado='';
       $v_descEstado='';
       if($v_estadoMateria=='A') {
          $v_descEstado="Activo";
       } 
       if($v_estadoMateria=='I') {
          $v_descEstado="Inactivo";
       }     

       $ListaEstado.="<option value='".$v_estadoMateria."' Selected>".$v_descEstado."</option>";    
       $ListaEstado.= "<option value='A' >Activo</option>";     
       $ListaEstado.= "<option value='I' >Inactivo</option>";


        
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

    <form id='formulario'  role='form' method='POST' enctype='multipart/form-data' action='ActualizarMateria.php'>
       <section   style="color:#0080FF; background-color: #FFBF00; font-family:Verdana ;" />
            <h2 align=left>&nbspMODIFICAR MATERIA
               <?php echo "<button class='btn btn-primary btn-lg' title='Regresar' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span> </button>";?>
               <?php          
               echo "<button id='btn_grabar' class='btn btn-primary btn-lg' title='Grabar' onclick='' type='submit' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none'><span class='glyphicon glyphicon-floppy-save'></span></button>";
               ?>
            </h2>
      </section>
         <div class="form-row">
            <div class="form-group col-md-12">
             <label style='color:#0080FF' for="f_nivel">&nbsp&nbspNiveles:&nbsp&nbsp</label>
             <center><select style='color:#0080FF' id='Nivel' name='IdNivel' class='form-control input-sm' disabled="yes"  >
                <option value=''>Seleccionar</option>
                  <?php echo $lisNiveles;?>
             </select></center>
            </div>
          
          
            <div class="form-group col-md-12">
             <label style='color:#0080FF' for="f_codigoMateria">&nbsp&nbspCodigo Materia:</label>
             <center><input style='color:#0080FF' id="CodigoMateria" type='text' name='CodigoMateria' class="form-control" placeholder="Codigo Materia" value='<?php echo $v_codigoMateria;?>' readonly></center>
             <input type="hidden" name='idmateria' value='<?php echo $v_IdMateria;?>'>
            </div>
            <div class="form-group col-md-12">
             <input type="hidden" name='idmateria' value='<?php echo $v_IdMateria;?>'>
            </div>
          
        </div>
        
       <div class="form-row">
          <div class="form-group col-md-12">
            <label style='color:#0080FF' for="f_nombreMateria">&nbsp&nbspNombre Materia:&nbsp&nbsp</label>
              <input style='color:#0080FF' id="NombreMateria" type='text' name='NombreMateria' class="form-control" placeholder="Mombre Materia" value='<?php echo $v_nombreMateria;?>'>
          </div>
          <div class="form-group col-md-12">
            <label style='color:#0080FF' for="inputPassword4">Horas Materia:</label>
            <input style='color:#0080FF' id="HorasMaterias" type='numeric' name='HorasMaterias'  class="form-control" placeholder="Horas  Materias" value='<?php echo $v_horasMateria;?>'>
          </div>
        </div>


        <div class="form-row">
          <div class="form-group col-md-12">
            <label style='color:#0080FF' for="f_nombreMateria">&nbsp&nbspCréditos:&nbsp&nbsp</label>
            <input style='color:#0080FF' type='numeric' name='Creditos'  class='form-control input-sm' required value='<?php echo $v_creditoMateria;?>'>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-12">
            <label style='color:#0080FF' for="f_nombreMateria">&nbsp&nbspEstado:&nbsp&nbsp</label>
              <select style='color:#0080FF' id='Estado' name='Estado' class='form-control input-sm' required' >
                <?php echo $ListaEstado;?>'>
              </select>
          </div>
        </div>  
    </form>
 </section>
<p style='font-size:16pt;color:red' id='mi_mensaje' name='mi_mensaje'>  </p>
</body>
</html>
   
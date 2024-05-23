<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       
       include("Conexion.php");    
       $v_IdCurso=$_REQUEST['IdCurso'];
       $Sql="Select * from cursos  where IdCurso=".$v_IdCurso;
       $rs  =   mysqli_query($conexion,$Sql);
       $reg =   mysqli_fetch_assoc($rs);
       $v_IdFormacion=$reg['IdFormacion'];
       $v_IdNivel =$reg['IdNivel'];
       $v_IdPeriodoLectivo =$reg['IdPeriodoLectivo'];
       $v_IdParalelo =$reg['IdParalelo'];
       $v_capacidad=$reg['Capacidad'];
       $v_disponibles=$reg['Disponibles'];
       $v_IdJornada=$reg['IdJornada'];
       $v_EstadoCurso=$reg['EstadoCursos'];


       $SqlNiv="Select * from niveles where idNivel =".$v_IdNivel;
       $rsNiveles=  mysqli_query($conexion, $SqlNiv);
       $regNiveles= mysqli_fetch_assoc($rsNiveles);
       $v_IdNivel =$regNiveles['idNivel'];
       $v_Nombre=$regNiveles['NivelDescripcion'];
       $lisNiveles="<option value='".$v_IdNivel."' Selected>".$v_Nombre."</option>";



       // Paralelos
       $ListaParalelos='';
       $SqlParalelos="Select * from paralelos where IdParalelo!='".$v_IdParalelo."'";
       $ResultParalelos=  mysqli_query($conexion, $SqlParalelos);
       while($reg_Paralelos=  mysqli_fetch_array($ResultParalelos))
       {
           $CodigoParalelo=$reg_Paralelos['idParalelo'];
           $NombreParalelo=$reg_Paralelos['DescParalelo'];
           $ListaParalelos.=
              "<option value='".$CodigoParalelo."'>".$NombreParalelo."</option>";
       }   
       $SqlParalelos="Select * from paralelos where IdParalelo='".$v_IdParalelo."'";
       $ResultParalelos=  mysqli_query($conexion, $SqlParalelos);
       while($reg_Paralelos=  mysqli_fetch_array($ResultParalelos))
       {
           $CodigoParalelo=$reg_Paralelos['idParalelo'];
           $NombreParalelo=$reg_Paralelos['DescParalelo'];
           $ListaParalelos.=
              "<option value='".$CodigoParalelo."' selected>".$NombreParalelo."</option>";
       }       
       // Formacion
       $ListaFormacion='';
       $SqlFormacion="Select * from formaciones where IdFormacion!=".$v_IdFormacion;
       $ResultFormacion=  mysqli_query($conexion, $SqlFormacion);
       while($reg_Formacion=  mysqli_fetch_array($ResultFormacion))
       {
           $IdFormacion=$reg_Formacion['IdFormacion'];
           $NombreFormacion=$reg_Formacion['DescripcionFormacion'];
           $ListaFormacion.=
              "<option value='".$IdFormacion."'>".$NombreFormacion."</option>";
       }               
       $SqlFormacion="Select * from formaciones where IdFormacion=".$v_IdFormacion;
       $ResultFormacion=  mysqli_query($conexion, $SqlFormacion);
       while($reg_Formacion=  mysqli_fetch_array($ResultFormacion))
       {
           $IdFormacion=$reg_Formacion['IdFormacion'];
           $NombreFormacion=$reg_Formacion['DescripcionFormacion'];
           $ListaFormacion.=
              "<option value='".$IdFormacion."' selected>".$NombreFormacion."</option>";
       }     
       //Periodos Lectivos
       $ListaPeriodosLectivos='';
       $SqlPeriodosLectivos="Select * from periodoslectivo where IdPeriodoLectivo=".$v_IdPeriodoLectivo;
       $ResultPeriodosLectivos=  mysqli_query($conexion, $SqlPeriodosLectivos);
       while($reg_PeriodosLectivos=  mysqli_fetch_array($ResultPeriodosLectivos))
       {
           $TipoPeriodosLectivos=$reg_PeriodosLectivos['IdPeriodoLectivo'];
           $NombrePeriodosLectivos=$reg_PeriodosLectivos['AnioInicial'].'-'.$reg_PeriodosLectivos['AnioFinal'];
           $ListaPeriodosLectivos=$ListaPeriodosLectivos.
              "<option value='".$TipoPeriodosLectivos."' selected>".$NombrePeriodosLectivos."</option>";
       }   
       $SqlPeriodosLectivos="Select * from periodoslectivo where IdPeriodoLectivo!=".$v_IdPeriodoLectivo;
       $ResultPeriodosLectivos=  mysqli_query($conexion, $SqlPeriodosLectivos);
       while($reg_PeriodosLectivos=  mysqli_fetch_array($ResultPeriodosLectivos))
       {
           $TipoPeriodosLectivos=$reg_PeriodosLectivos['IdPeriodoLectivo'];
           $NombrePeriodosLectivos=$reg_PeriodosLectivos['AnioInicial'].'-'.$reg_PeriodosLectivos['AnioFinal'];
           $ListaPeriodosLectivos=$ListaPeriodosLectivos.
              "<option value='".$TipoPeriodosLectivos."' >".$NombrePeriodosLectivos."</option>";
       }   
       // Estados

       $ListaEstado='';
       $v_descEstado='';
       if($v_EstadoCurso=='A') {
          $v_descEstado="Activo";
       } 
       if($v_EstadoCurso=='I') {
          $v_descEstado="Inactivo";
       }     

       $ListaEstado.= "<option value='".$v_EstadoCurso."' Selected>".$v_descEstado."</option>";    
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

    <form id='formulario'  role='form' method='POST' enctype='multipart/form-data' action='ActualizarCurso.php'>
       <section   style="color:#0080FF; background-color: #FFBF00; font-family:Verdana ;" />
            <h2 align=left>&nbspMODIFICAR CURSO
               <?php echo "<button class='btn btn-primary btn-lg' title='Regresar' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span> </button>";?>
               <?php          
               echo "<button id='btn_grabar' class='btn btn-primary btn-lg' title='Grabar' onclick='' type='submit' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none'><span class='glyphicon glyphicon-floppy-save'></span></button>";
               ?>
            </h2>
      </section>

         <div class="form-row">
            <div class="form-group col-md-12">
             <label style='color:#0080FF' for="f_IdNivel">&nbsp&nbspId Curso:&nbsp&nbsp</label>
             <center><input style='color:#0080FF' id='IdCurso' name='IdCurso' class='form-control input-sm' readonly=""
             value = '<?php echo $v_IdCurso;?>' >
            </div>
          
          
         <div class='form-row'>
            <div class="form-group col-md-12">
             <label style='color:#0080FF'for="f_periodolectivo">Periodo Lectivo:</label>     
              <select id='IdPeriodoLectivo' name='IdPeriodoLectivo' class='form-control input-sm' required' >
                 <?php echo $ListaPeriodosLectivos;?>
              </select>
           </div>  
         </div>  
          
         <div class='form-row'>
            <div class="form-group col-md-12">
             <label style='color:#0080FF'for="f_niveles">Niveles:</label>     
              <select id='IdNivel' name='IdNivel' class='form-control input-sm' required' disabled="yes" >
                 <?php echo $lisNiveles;?>
              </select>
           </div>  
         </div>  

         <div class='form-row'>
            <div class="form-group col-md-12">
             <label style='color:#0080FF'for="f_niveles">Formación:</label>     
              <select id='IdFormacion' name='IdFormacion' class='form-control input-sm' required' >
               <option value=''>Seleccionar</option>"
                 <?php echo $ListaFormacion;?>
              </select>
           </div>  
         </div>  
         <div class='form-row'>
            <div class="form-group col-md-12">
             <label style='color:#0080FF'for="f_paralelos">Paralelos:</label>     
              <select id='IdParalelo' name='IdParalelo' class='form-control input-sm' required' >
                 <?php echo $ListaParalelos;?>
              </select>
           </div>  
         </div>  

         <div class='form-row'>
            <div class="form-group col-md-12">
             <label style='color:#0080FF'for="f_paralelos">Estado:</label>     
              <select id='Estado' name='Estado' class='form-control input-sm' required' >
                <?php echo $ListaEstado;?>
              </select>
           </div>  
         </div> 

    </form>
 </section>
<p style='font-size:16pt;color:red' id='mi_mensaje' name='mi_mensaje'>  </p>
</body>
</html>
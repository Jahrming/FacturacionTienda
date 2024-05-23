<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       
       include("Conexion.php");    

       // Estados

       $ListaEstado='';
       $v_descEstado='';
    
       $ListaEstado.= "<option value='A' >Activo</option>";     
       $ListaEstado.= "<option value='I' >Cerrado</option>";
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

    <form id='formulario'  role='form' method='POST' enctype='multipart/form-data' action='GrabarNuevoPeriodoLectivo.php'>
       <section   style="color:#0080FF; background-color: #FFBF00; font-family:Verdana ;" />
            <h2 align=left>&nbspNUEVO PERIODO LECTIVO
               <?php echo "<button class='btn btn-primary btn-lg' title='Regresar' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none' onClick='window.location=\"ConsultaPeriodosLectivos.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span> </button>";?>
               <?php          
               echo "<button id='btn_grabar' class='btn btn-primary btn-lg' title='Grabar' onclick='' type='submit' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none'><span class='glyphicon glyphicon-floppy-save'></span></button>";
               ?>
            </h2>
      </section>

         <div class="form-row">
            <div class="form-group col-md-12">
             <label style='color:#0080FF' for="f_IdNivel">&nbsp&nbspId Periodo Lectivo:&nbsp&nbsp</label>
             <center><input style='color:#0080FF' id='IdPeriodoLectivo' name='IdPeriodoLectivo' class='form-control input-sm' readonly="true"
             value = '' ></center>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-12">
             <label style='color:#0080FF' for="f_IdNivel">&nbsp&nbspAño Inicial:&nbsp&nbsp</label>
             <center><input style='color:#0080FF' id='anioInicial' name='anioInicial' class='form-control input-sm' 
             value = '' ></center>
            </div>
         </div> 
         <div class="form-row">
            <div class="form-group col-md-12">
             <label style='color:#0080FF' for="f_IdNivel">&nbsp&nbspAño Final:&nbsp&nbsp</label>
             <center><input style='color:#0080FF' id='anioFinal' name='anioFinal' class='form-control input-sm'
             value = '' ></center>
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
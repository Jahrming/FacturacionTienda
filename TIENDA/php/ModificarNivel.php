<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       
       include("Conexion.php");    
       $v_IdNivel=$_REQUEST['IdNivel'];
       $Sql="Select * from niveles  where IdNivel=".$v_IdNivel;

       $rs  =   mysqli_query($conexion,$Sql);
       $reg =   mysqli_fetch_assoc($rs);
       $v_IdNivel     = $reg['idNivel'];
       $v_DescNivel   = $reg['NivelDescripcion'];
       $v_Matricula   = $reg['ValorMatricula'];
       $v_Pension     = $reg['ValorPension'];
       $v_Estado      = $reg['Estado'];

       // Estados

       $ListaEstados='';
       $v_descEstado='';
       if($v_Estado=='A') {
          $v_descEstado="Activo";
       } 
       if($v_Estado=='I') {
          $v_descEstado="Inactivo";
       }     

       $ListaEstado.= "<option value='".$v_Estado."' Selected>".$v_descEstado."</option>";    
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

    <form id='formulario'  role='form' method='POST' enctype='multipart/form-data' action='ActualizarNivel.php'>
       <section   style="color:#0080FF; background-color: #FFBF00; font-family:Verdana ;" />
            <h2 align=left>&nbspMODIFICAR NIVELES
               <?php echo "<button class='btn btn-primary btn-lg' title='Regresar' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span> </button>";?>
               <?php          
               echo "<button id='btn_grabar' class='btn btn-primary btn-lg' title='Grabar' onclick='' type='submit' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none'><span class='glyphicon glyphicon-floppy-save'></span></button>";
               ?>
            </h2>
      </section>

         <div class="form-row">
            <div class="form-group col-md-12">
             <label style='color:#0080FF' for="f_IdNivel">&nbsp&nbspId Nivel:&nbsp&nbsp</label>
             <center><input style='color:#0080FF' id='IdNivel' name='IdNivel' class='form-control input-sm' readonly="true"
             value = '<?php echo $v_IdNivel;?>' >
            </div>
          
          
         <div class='form-row'>
            <div class="form-group col-md-12">
             <label style='color:#0080FF'for="f_DescripcionNivel">Descripcion:</label>     
              <input style='color:#0080FF' id='DescripcionNivel' name='DescripcionNivel' class='form-control input-sm' readonly="true"
             value = '<?php echo $v_DescNivel;?>' >
           </div>  
         </div>  

         <div class='form-row'>
            <div class="form-group col-md-12">
             <label style='color:#0080FF'for="f_ValorMatricula">Valor Matricula:</label>     
              <input style='color:#0080FF' id='ValorMatricula' name='ValorMatricula' class='form-control input-sm' 
             value = '<?php echo $v_Matricula;?>' >
           </div>  
         </div>  

         <div class='form-row'>
            <div class="form-group col-md-12">
             <label style='color:#0080FF'for="f_ValorPension">Valor Pensión:</label>     
              <input style='color:#0080FF' id='ValorPension' name='ValorPension' class='form-control input-sm' 
             value = '<?php echo $v_Matricula;?>' >
           </div>  
         </div>  

        

         <div class='form-row'>
            <div class="form-group col-md-12">
             <label style='color:#0080FF'for="f_estado">Estado:</label>     
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
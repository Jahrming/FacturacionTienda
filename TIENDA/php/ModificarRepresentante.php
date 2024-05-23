<?php
    SESSION_START();

    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       
       include("Conexion.php");    

       #btener datos de los tickets
       $v_IdRepresentante=$_REQUEST['IdRepresentante'];
       //echo $v_usuario;
       #Obtengo informacion del usuario
       $Sql="Select * from representantes where IdRepresentante=$v_IdRepresentante";
       $rs=  mysqli_query($conexion,$Sql);
       $regRepresentante=mysqli_fetch_assoc($rs);
       //Datos alumnos para mostrar
            $v_descEstado='';
            $v_usuario=$_SESSION["user"];
            $v_Cedula=$regRepresentante['cedula'];
            $v_Apellidos=$regRepresentante['apellidos'];
            $v_Nombres=$regRepresentante['nombres'];
            $v_Direccion=$regRepresentante['direccion'];
            $v_Telefonos=$regRepresentante['telefonos'];
            $v_Celular=$regRepresentante['celular'];
            $v_Email=$regRepresentante['mail'];
            $v_Estado=$regRepresentante['estado'];
            $ListaEstado='';
            if($v_Estado=='A'){ $v_descEstado='Activo';}else{$v_descEstado='Inctivo';}
            $ListaEstado.="<option value='".$v_Estado."' Selected>".$v_descEstado."</option>";
            $ListaEstado.="<option value='A' >ACTIVO</option>";
            $ListaEstado.="<option value='I' >INACTIVO</option>";

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

    <form id='formulario'  role='form' method='POST' enctype='multipart/form-data' action='ActualizarRepresentante.php'>
       <section   style="color:#0080FF; background-color: #FFBF00; font-family:Verdana ;" />
            <h2 align=left>&nbspMODIFICAR REPRESENTANTE
               <?php echo "<button class='btn btn-primary btn-lg' title='Regresar' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none' onClick='window.location=\"ConsultaRepresentantes.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span> </button>";?>
               <?php          
               echo "<button id='btn_grabar' class='btn btn-primary btn-lg' title='Grabar' onclick='' type='submit' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none'><span class='glyphicon glyphicon-floppy-save'></span></button>";
               ?>
            </h2>
        </section>
        <div class="form-row">
          <div class="form-group col-md-12">
            <label style='color:#0080FF' for="f_cedula">&nbsp&nbspId Representante:&nbsp&nbsp</label>
            <input style='color:#0080FF' type="text" class="form-control" id="IdRepresentante" name='IdRepresentante' value='<?php echo $v_IdRepresentante;?> ' readonly > 
          </div>
        </div>
       <div class="form-row">
          <div class="form-group col-md-12">
            <label style='color:#0080FF' for="f_cedula">&nbsp&nbspCédula:&nbsp&nbsp</label>
            <input style='color:#0080FF' type="text" class="form-control" id="Cedula" name='Cedula' placeholder="Cédula" value='<?php echo $v_Cedula;?> '>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label style='color:#0080FF'  for="f_apellidos">&nbsp&nbspApellidos: </label>
            <input style='color:#0080FF' type="text" class="form-control" id="Apellidos" name='Apellidos' placeholder="Apellidos" value='<?php echo $v_Apellidos;?> '>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label style='color:#0080FF'  for="f_nombres">&nbsp&nbspNombres:</label>
            <input style='color:#0080FF' type="text" name='Nombres' class="form-control" id="Nombres" placeholder="Nombres" value='<?php echo $v_Nombres;?> '>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label style='color:#0080FF' for="Celular">Celular:</label>
            <input style='color:#0080FF' type='text' class="form-control" id="Celular" name='Celular' required value='<?php echo $v_Celular;?> '>
          </div>          
          <div class="form-group col-md-8">
            <label style='color:#0080FF' for="Direccion">Direccion:</label>
            <input style='color:#0080FF' type='text' class="form-control" id="Direccion" name='Direccion' required value='<?php echo $v_Direccion;?> '>
          </div>
        </div>  
        <div class="form-row">
          <div class="form-group col-md-4">
            <label style='color:#0080FF' for="inputState">Telefonos :</label>
            <input style='color:#0080FF' type='text' class="form-control" id="Telefonos" name='Telefonos' required value='<?php echo $v_Telefonos;?> '>
          </div>
          <div class="form-group col-md-4">
            <label style='color:#0080FF' for="Representante">Email:</label>
            <input style='color:#0080FF' type='text' class="form-control" id='Email' name='Email' value='<?php echo $v_Email;?> '>
          </div>
          <div class="form-group col-md-4">
              <label  style='color:#0080FF' for="estado">Estado:</label>
              <select style='color:#0080FF' id='Estado' name='Estado' class='form-control input-sm' required' >
                  <?php echo $ListaEstado;?>
              </select>
            </div>
        </div> 
    </form>
   </div>
 </section>
<p style='font-size:16pt;color:red' id='mi_mensaje' name='mi_mensaje'>  </p>
</body>
</html>"
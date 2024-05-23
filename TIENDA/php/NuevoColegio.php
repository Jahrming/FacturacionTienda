<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       
       include("Conexion.php");    
       $ListaCiudades='';
       $SqlCiudad="Select * from ciudades";
       $ResultCiudad=  mysqli_query($conexion, $SqlCiudad);
       while($reg_Ciudad=  mysqli_fetch_array($ResultCiudad))
       {
           $IdCiudad=$reg_Ciudad['IdCiudad'];
           $NombreCiudad=$reg_Ciudad['DescripcionCiudad'];
           $ListaCiudades.="<option value='".$IdCiudad."'>".$NombreCiudad."</option>";
       }    
       $ListaEstados='';
       $SqlEstados="SELECT * FROM admestados ";
       $rsestados= mysqli_query($conexion,$SqlEstados);
       $descEstado = $regEstados['DescripcionEstado'];
       while($regEstados=  mysqli_fetch_array($rsestados))
       {
           $IdEstado=$regEstados['IdEstado'];
           $DescripcionEstado=$regEstados['DescripcionEstado'];
           $ListaEstados.=
              "<option value='".$IdEstado."'>".$DescripcionEstado."</option>";
       }  

     } 
 ?>
       

<head>
			<title> SISTEMA IMPORTBOOKS</title>
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
  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' action='GrabarColegio.php'>  
      <div class='container'>
        <div class='panel panel-default'>
            <?php echo"<div class='panel-heading' style='font-size: 20px;color:#0080FF;font-weight:bold;'>Nuevo Colegio
              <button class='btn btn-primary btn-sm' title='Regresar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' onClick='window.location=\"ConsultaProveedores.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span></button>";?>
            <?php echo"<button class='btn btn-primary btn-sm' title='Grabar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' type='submit'> <span class='glyphicon glyphicon-floppy-disk'></span> </button>";?>
              <button class='btn btn-primary btn-sm' title='Limpiar' style='font-size:16px;color:#0080FF;background-color:#FFBF00;border:none' type='button'><span class='glyphicon glyphicon-refresh'></span> </button>                 
            </div>
          <div class="panel-body">
              <div class="panel-body" style="width:100%; float:left; display:block;"> 
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label style='color:#0080FF' for="inputPassword4">Nombre Institución:</label>
                    <input style='color:#0080FF' type="text" name='nombre' class="form-control" id="nombre" placeholder="Nombre Institución">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label style='color:#0080FF' >Nombre Contacto:</label>
                    <input style='color:#0080FF' type="text" name='nombreContacto' class="form-control" id="nombreContacto" placeholder="Nombre del Contacto Institución">
                  </div>
                </div>   
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label style='color:#0080FF' >Ciudad:</label>
                    <input style='color:#0080FF' type="text" name='Ciudad' class="form-control" id="Ciudad" placeholder="Ciudad donde esta la Institución">
                  </div>
                </div>                   
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label style='color:#0080FF'  for="f_direccion">Porcentaje Descuento %:</label>
                    <input style='color:#0080FF' type="number" step="0.01" class="form-control" id="porcentaje" name='porcentaje' step="0.01" value='0' placeholder="Ingrese Porcentaje">                    
                  </div>
                </div>                             
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label style='color:#0080FF'  for="f_direccion">Dirección:</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="direccion" name='direccion' placeholder="Ingrese Dirección">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF'  for="f_direccion">Teléfonos:</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="Telefonos" name='Telefonos' placeholder="Ingrese Teléfonos">
                  </div>
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="f_mail">Email:</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="email" name="email" placeholder="Email">
                  </div>                  
                </div>   
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="estado">Estado:</label>
                      <select style='color:#0080FF' id='Estado' name='Estado' class='form-control' >
                        <option value=''>Seleccionar</option>
                        <?php
                           echo $ListaEstados;
                         ?>
                      </select>          
                  </div>
                </div>
              </div>            
          </div>   
        </div>
  
 </form>
</section>

<p style='font-size:16pt;color:red' id='mi_mensaje' name='mi_mensaje'>  </p>
</body>
</html>
   
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
      <?php  include('head.php');?> 

</head>
<!---   <body onload='return inicio(\"\")'>    -->
<body>
<section>
  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' action='GrabarProveedor.php'>  
      <div class='container'>
        <div class='panel panel-default'>
            <?php echo"<div class='panel-heading' style='font-size: 20px;color:#0080FF;font-weight:bold;'>Nuevo Provedor
              <button class='btn btn-primary btn-sm' title='Regresar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' onClick='window.location=\"ConsultaProveedores.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span></button>";?>
            <?php echo"<button class='btn btn-primary btn-sm' title='Grabar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' type='submit'> <span class='glyphicon glyphicon-floppy-disk'></span> </button>";?>
              <button class='btn btn-primary btn-sm' title='Limpiar' style='font-size:16px;color:#0080FF;background-color:#FFBF00;border:none' type='button'><span class='glyphicon glyphicon-refresh'></span> </button>                 
            </div>
          <div class="panel-body">
              <div class="panel-body" style="width:75%; float:left; display:block;"> 
                <div class="form-row">
                  <div class="form-group col-md-8">
                    <label style='color:#0080FF' for="f_ruc">RUC/Cédula</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="ruc" maxlength="13" minlength="10" name="ruc" placeholder="RUC" required="yes" onblur='return VerificarDatosUsuario()' onkeypress="tabuladorIndex(event,this)">
                  </div>
                  <div class="form-group col-md-8">
                    <label style='color:#0080FF' for="inputPassword4">Descripción Razon Social:</label>
                    <input style='color:#0080FF' type="text" name='nombre' class="form-control" id="nombre"  required="yes" placeholder="Nombre Proveedor"  onkeypress="tabuladorIndex(event,this)" required="yes">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label style='color:#0080FF'  for="f_direccion">Dirección:</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="direccion" name='direccion'  required="yes"  placeholder="Ingrese Dirección"  onkeypress="tabuladorIndex(event,this)" required="yes">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF'  for="f_nombres">Ciudad:</label>
                    <select style='color:#0080FF' id='ciudad' name='ciudad' class="form-control" id="cc" required  onkeypress="tabuladorIndex(event,this)" required="yes">
                        <option value=''>Seleccionar</option>
                        <?php
                           echo $ListaCiudades;
                         ?>
                    </select> 
                  </div>
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="f_mail">@Mail:</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="email" name="email" placeholder="Email" required="yes"  onkeypress="tabuladorIndex(event,this)">
                  </div>                  
                </div>   
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label style='color:#0080FF'  for="f_telefonos">Teléfonos:</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="Telefonos" name="Telefonos" placeholder="Teléfonos" required="yes"  onkeypress="tabuladorIndex(event,this)" required="yes">
                  </div>
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="estado">Estado:</label>
                      <select style='color:#0080FF' id='Estado' name='Estado' class='form-control' required="yes"  onkeypress="tabuladorIndex(event,this)" required="yes">
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
<script type="text/javascript">
  function tabuladorIndex(e,obj)
  {
    
    //alert(e.keyCode);
    idElemento = obj.id;    
    //alert(idElemento);
    if (e.keyCode == 13)
    {
      switch(idElemento)
      {
         case 'ruc':
           document.getElementById('nombre').focus();
           break;
         case 'nombre':
           document.getElementById('direccion').focus();     
           break;    
         case 'direccion':
           document.getElementById('ciudad').focus();    
           break;     
         case 'ciudad':
           document.getElementById('email').focus();   
           break;                  
         case 'email':
           document.getElementById('Telefonos').focus();    
           break; 
         case 'Telefonos':
           document.getElementById('estado').focus();       
           break;  

      }
    }
  
  }
</script>
</html>
   
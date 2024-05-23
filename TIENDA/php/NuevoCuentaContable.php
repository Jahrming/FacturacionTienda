<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       
       include("Conexion.php");    
       $ListaTipoCuenta='';
       $SqlTipoCuenta="Select * from contipocuenta";
       $ResultTipoCuenta=  mysqli_query($conexion, $SqlTipoCuenta);
       while($reg_TipoCuenta=  mysqli_fetch_array($ResultTipoCuenta))
       {
           $IdTipoCuenta=$reg_TipoCuenta['CodigoTipoCuenta'];
           $NombreTipoCuenta=$reg_TipoCuenta['DescripcionTipoCuenta'];
           $ListaTipoCuenta.="<option value='".$IdTipoCuenta."'>".$NombreTipoCuenta."</option>";
       }    
       #----Cuenta Padre ----------------
       $ListaCuentaPadre='';
       $SqlCuentaPadre="Select * from conplancuentas";
       $ResultCuentaPadre=  mysqli_query($conexion, $SqlCuentaPadre);
       while($reg_CuentaPadre=  mysqli_fetch_array($ResultCuentaPadre))
       {
           $CuentaContablePadre=$reg_CuentaPadre['CuentaContable'];
           $NombreCuentaContable=$reg_CuentaPadre['DescripcionCuentaContable'];
           $ListaCuentaPadre.="<option value='".$CuentaContablePadre."'>".$NombreCuentaContable."</option>";
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
    <style type="text/css">
        .sinborde   { border: 0;   }
        body,select { font-family: arial, 'Times New Roman',Times, serif;
                      font-size: 12px;} 
        input{
          padding: 3px;
          margin: 3px;
        }
        ul{
          float: left;
          background-color: #eee;
          cursor:pointer;
        }
        li{
          float: left;
          padding: 12px;
        }
        #sugerencias {
                font-size: 11px;
                box-shadow: 2px 2px 8px 0 rgba(0,0,0,.2);
                height: auto;
                position: absolute;
                /*top: 45px;*/
                z-index: 9999;
                width: 400px;
                float: left;
        }
        #filtrarProductos {
                font-size: 11px;
                box-shadow: 2px 2px 8px 0 rgba(0,0,0,.2);
                height: auto;
                position: absolute;
                /*top: 45px;*/
                z-index: 9999;
                width: 400px;
                float: left;
        }
 
        #sugerencias .suggest-element {
                background-color: #EEEEEE;
                border-top: 1px solid #d6d4d4;
                cursor: pointer;
                padding: 8px;
                width: 400%;
                float: left;
        }

    </style>

</head>
<!---   <body onload='return inicio(\"\")'>    -->
<body>
<section>
  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' action='GrabarNuevaCuenta.php'>  
      <div class='container'>
        <div class='panel panel-default'>
            <?php echo"<div class='panel-heading' style='font-size: 18px;color:#0080FF;font-weight:bold;'>Nuevo Cuenta Contable
              <button class='btn btn-primary btn-sm' title='Regresar' style='font-size:18px;color:#0080FF;background-color:    #FFBF00;border:none' onClick='window.location=\"ConsultaPlanCuentas.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span></button>";?>
            <?php echo"<button class='btn btn-primary btn-sm' title='Grabar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' type='submit'> <span class='glyphicon glyphicon-floppy-disk'></span> </button>";?>
              <button class='btn btn-primary btn-sm' title='Limpiar' style='font-size:16px;color:#0080FF;background-color:#FFBF00;border:none' type='button'><span class='glyphicon glyphicon-refresh'></span> </button>                 
            </div>
          <div class="panel-body">
              <div class="panel-body" style="width:100%; float:left; display:block;">    
                <div class="form-row">               
                   <div class="form-group col-md-3">
                     <label style='color:#0080FF'  for="f_nombres">Tipo Cuenta:</label>
                        <select style='color:#0080FF' id='TipoCuenta' name='TipoCuenta' class="form-control" id="cc" required>
                            <option value=''>Seleccionar</option>
                            <?php
                               echo $ListaTipoCuenta;
                             ?>
                        </select> 
                   </div>
                   <div class="form-group col-md-3">
                      <label style='color:#0080FF'  for="f_nombres">Nivel:</label>
                        <select style='color:#0080FF' id='Nivel' name='Nivel' class="form-control" required>
                          <option value=''>Seleccionar</option>
                          <option value=1>1</option>
                          <option value=2>2</option>
                          <option value=3>3</option>
                          <option value=4>4</option>
                          <option value=5>5</option>
                          <option value=6>6</option>
                          <option value=7>7</option>              
                          <option value=8>8</option>
                        </select> 
                   </div>               
                   <div class="form-group col-md-3">
                     <label style='color:#0080FF'  for="f_nombres">Resumen o Detalle:</label>
                        <select style='color:#0080FF' id='rs' name='rs' class="form-control" required>
                          <option value=''>Seleccionar</option>
                          <option value='R'>Resumen</option>
                          <option value='D'>Detalle</option>
                        </select> 
                   </div> 
                  <div class="form-group col-md-3">
                    <label style='color:#0080FF' for="f_ruc">Año</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="anio" name="anio" placeholder="Año" onblur='return VerificarDatosUsuario()'>
                  </div>                   

                </div> 
                <div class="form-row">  
                   <div class="form-group col-md-11">
                     <label style='color:#0080FF'  for="f_nombres">Cuenta Padre:</label>
                     <input style='color:#0080FF' type="text" class="form-control" id="CuentaPadre" name="CuentaPadre" placeholder="Cuenta Contable Padre" >
                    <div id="sugerencias" class='list-group'></div>
                   </div>  
    
                </div>    
               <div class="form-row">    
                  <div class="form-group col-md-2">
                    <label style='color:#0080FF' for="f_ruc">Prefijo:</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="prefijo" name="prefijo" placeholder="prefijo" value='' readonly="yes">
                  </div>                                              
                   <div class="form-group col-md-3">
                       <label style='color:#0080FF' for="f_ruc">Numero Cuenta</label>
                       <input style='color:#0080FF' type="text" class="form-control" id="NumeroCuenta" name="NumeroCuenta" placeholder="Número de Cuenta" onblur='return VerificarDatosUsuario()'>
                   </div>
                   <div class="form-group col-md-7">
                       <label style='color:#0080FF' for="f_ruc">Descripción Cuenta</label>
                       <input style='color:#0080FF' type="text" class="form-control" id="NombreCuentaContable" name="NombreCuentaContable" placeholder="Nombre Cuenta Contable" required="yes">
                   </div>
               </div>
               <div class="form-row">  
                <div class="form-group col-md-3">
                    <label style='color:#0080FF' for="estado">Estado:</label>
                      <select style='color:#0080FF' id='Estado' name='Estado' class='form-control' required' >
                        <option value=''>Seleccionar</option>
                        <?php
                           echo $ListaEstados;
                         ?>
                      </select>          
                </div>
              </div>
            </div>            
          </div>   
  
 </form>
</section>

<p style='font-size:16pt;color:red' id='mi_mensaje' name='mi_mensaje'>  </p>
</body>


<script type="text/javascript">
$(document).ready(function(){
  
  $("#CuentaPadre").keyup(function(){ 
      var busquedaCuentaPadre = $(this).val();
      var anioPlanCuenta = $('#anio').val();
      var tipoCuenta = $('#TipoCuenta').val();
      
      if(busquedaCuentaPadre.length>2)
      {
        $.ajax({
          url: 'retornaDatosCuentasContables.php',
          method:  'POST',
          contentType: 'application/x-www-form-urlencoded',
          data: {'Criterio': busquedaCuentaPadre,'Anio':anioPlanCuenta,'TipoCuenta':tipoCuenta},
            success: function(data){
              $('#sugerencias').html(data);
              $('.list-group-item').on('click', function(){
                       var CuentaContablePadre  = $(this).attr('lCuentaContable');
                       var DescripcionCuentaContablePadre   = $(this).attr('nombreCuentaContable');
                      // var tipdoc        = $(this).attr('tipdoc');
                      $('#CuentaPadre').val(CuentaContablePadre+' - ' + DescripcionCuentaContablePadre);
                      $('#prefijo').val(CuentaContablePadre);
                      $('.list-group-item').fadeOut(1000);
                });
            }
        })
        .done(function() {
          console.log("success");
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
       
      }

  })
})
</script>

</html>
   
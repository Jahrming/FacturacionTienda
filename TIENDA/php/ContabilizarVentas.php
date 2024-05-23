<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
        include("Conexion.php");   
        $v_numCedula='';
        $v_nombres='';
        $v_valor='';
        
        $sql="SELECT * from systemprofile ";
        $rs       =  mysqli_query($conexion, $sql);
        $registro =  mysqli_fetch_assoc($rs);
        $cobraIva =  $registro['CobraIva'];
        $ivaActual=  $registro['VigenteIva']; 
        $periodoLectivo = $registro['PeriodoLectivoActual'];

       #---------Carga Proveedores ---------#
       $SqlProveedores="Select * from proveedores where EstadoProveedor='A'";       
       $ResultProveedores=  mysqli_query($conexion, $SqlProveedores);
       while($reg_Proveedores=  mysqli_fetch_array($ResultProveedores))
       {
           $IdProveedor=$reg_Proveedores['IdProveedor'];
           $DescProveedor=$reg_Proveedores['DescripcionProveedor'];
           $ListaProveedores.=
              "<option value='".$IdProveedor."'>".$DescProveedor."</option>";
       }  
       #---------Carga Forma de Pago Proveedores ---------#
       $ListaFormaPagoProveedores='';
       $SqlFormaPagoProveedores="Select * from formapagoproveedores where EstadoFormaPago='A'";    
       $ResultFormaPagoProveedores=  mysqli_query($conexion, $SqlFormaPagoProveedores);
       while($reg_FormaPagoProveedores=  mysqli_fetch_array($ResultFormaPagoProveedores))
       {
           $IdFormaPagoProveedor=$reg_FormaPagoProveedores['IdFormaPagoProveedor'];
           $DescFormaPagoProveedor=$reg_FormaPagoProveedores['DescripcionFormaPago'];
           $ListaFormaPagoProveedores.=
              "<option value='".$IdFormaPagoProveedor."'>".$DescFormaPagoProveedor."</option>";
       }  
       #---------Carga Forma de Pago Proveedores ---------#
       $ListaEstadoFinanciero='';
       $SqlEstados="Select * from estadofinancierofacturaproveedor where Estado='A'";       
       $ResultEstados=  mysqli_query($conexion, $SqlEstados);
       while($reg_Estados=  mysqli_fetch_array($ResultEstados))
       {
           $IdEstado=$reg_Estados['IdEstadoFinanciero'];
           $DescEstadoFinanciero=$reg_Estados['DescripcionEstadoFinanciero'];
           $ListaEstadoFinanciero.=
              "<option value='".$IdEstado."'>".$DescEstadoFinanciero."</option>";
       }  
       #----------Cierres de ventas pendientes de cerrar------------------
       $ListaCierresVentas='';
       $SqlCierres="Select * from concierresdiarios where Estado='G'";       
       $ResultCierres=  mysqli_query($conexion, $SqlCierres);
       while($reg_Cierres=  mysqli_fetch_array($ResultCierres))
       {
           $IdCierre=$reg_Cierres['IdCierreDiario'];
           $DescripcionCierre= $reg_Cierres['IdCierreDiario'].'|'.$reg_Cierres['FechaCierreDiario'];
           $ListaCierresVentas.=
              "<option value='".$IdCierre."'>".$DescripcionCierre."</option>";
       }         
       #-----lleno el grid con los datos para el asiento --------------------------
       $SqlCierreDiario = "SELECT (SELECT DESCRIPCIONCUENTACONTABLE FROM CONPLANCUENTAS
                            WHERE CUENTACONTABLE IN (SELECT CUENTACONTABLEVENTASCONTADO FROM CONCIERRESDIARIOS)) AS NombreCuenta,
                                  VENTASCONTADO VALOR,CUENTACONTABLEVENTASCONTADO CUENTA,'D' Tipo
                            FROM CONCIERRESDIARIOS
                           WHERE IDCIERREDIARIO = $IdCierreDiario
                          UNION
                          SELECT  (SELECT DESCRIPCIONCUENTACONTABLE FROM CONPLANCUENTAS
                                    WHERE CUENTACONTABLE IN (SELECT CUENTACONTABLEVENTASCREDITO FROM CONCIERRESDIARIOS)) AS NombreCuenta,
                            VENTASCREDITO VALOR,CUENTACONTABLEVENTASCREDITO CUENTA,'D' Tipo
                           FROM CONCIERRESDIARIOS
                          WHERE IDCIERREDIARIO = 1
                          UNION 
                            SELECT
                            (SELECT DESCRIPCIONCUENTACONTABLE FROM CONPLANCUENTAS
                                   WHERE CUENTACONTABLE IN (SELECT CUENTACONTABLEVENTASCHEQUE FROM CONCIERRESDIARIOS)) AS NombreCuenta,
                            VENTASCHEQUE VALOR,CUENTACONTABLEVENTASCHEQUE CUENTA,'D' Tipo
                           FROM CONCIERRESDIARIOS
                          WHERE IDCIERREDIARIO = $IdCierreDiario
                          UNION 
                            SELECT
                            (SELECT DESCRIPCIONCUENTACONTABLE FROM CONPLANCUENTAS
                                   WHERE CUENTACONTABLE IN (SELECT CUENTACONTABLEVENTASTC FROM CONCIERRESDIARIOS)) AS NombreCuenta,
                            VENTASTC  VALOR,CUENTACONTABLEVENTASTC CUENTA,'D' Tipo
                           FROM CONCIERRESDIARIOS
                          WHERE IDCIERREDIARIO = $IdCierreDiario
                          UNION 
                          SELECT
                            (SELECT DESCRIPCIONCUENTACONTABLE FROM CONPLANCUENTAS
                                    WHERE CUENTACONTABLE IN (SELECT CUENTACONTABLEVENTASCONTADOTARIFA0 FROM CONCIERRESDIARIOS)) AS NombreCuenta,
                                   VENTASCONTADOTARIFA0 VALOR,CUENTACONTABLEVENTASCONTADOTARIFA0 CUENTA,'H' Tipo
                            FROM CONCIERRESDIARIOS
                          WHERE IDCIERREDIARIO = $IdCierreDiario
                          UNION
                           SELECT
                            (SELECT DESCRIPCIONCUENTACONTABLE FROM CONPLANCUENTAS
                                   WHERE CUENTACONTABLE IN (SELECT CUENTACONTABLEVENTASCONTADOTARIFA12 FROM CONCIERRESDIARIOS)) AS NombreCuenta,
                                   VENTASCONTADOTARIFA12 VALOR,CUENTACONTABLEVENTASCONTADOTARIFA12 CUENTA,'H' Tipo
                            FROM CONCIERRESDIARIOS
                          WHERE IDCIERREDIARIO = $IdCierreDiario
                          UNION
                           SELECT
                            (SELECT DESCRIPCIONCUENTACONTABLE FROM CONPLANCUENTAS
                                   WHERE CUENTACONTABLE IN (SELECT CUENTACONTABLEVENTASCREDTIOTARIFA12 FROM CONCIERRESDIARIOS)) AS NombreCuenta,
                                   VENTASCREDITOTARIFA12 VALOR,CUENTACONTABLEVENTASCREDITOTARIFA12 CUENTA,'H' Tipo
                            FROM CONCIERRESDIARIOS
                          WHERE IDCIERREDIARIO = $IdCierreDiario
                          UNION 
                          SELECT
                            (SELECT DESCRIPCIONCUENTACONTABLE FROM CONPLANCUENTAS
                                   WHERE CUENTACONTABLE IN (SELECT CUENTACONTABLEVENTASTCTARIFA0 FROM CONCIERRESDIARIOS)) AS NombreCuenta,
                            VENTASTCTARIFA0 VALOR,CUENTACONTABLEVENTASTCTARIFA0 CUENTA,'H' Tipo
                           FROM CONCIERRESDIARIOS
                          WHERE IDCIERREDIARIO = $IdCierreDiario
                          UNION 
                          SELECT  
                            (SELECT DESCRIPCIONCUENTACONTABLE FROM CONPLANCUENTAS
                                   WHERE CUENTACONTABLE IN (SELECT CUENTACONTABLEVENTASTCTARIFA12 FROM CONCIERRESDIARIOS)) AS NombreCuenta,
                            VENTASTCTARIFA12 VALOR,CUENTACONTABLEVENTASTCTARIFA12 CUENTA,'H' Tipo
                          FROM CONCIERRESDIARIOS
                          WHERE IDCIERREDIARIO = $IdCierreDiario
                          UNION 
                          SELECT  
                            (SELECT DESCRIPCIONCUENTACONTABLE FROM CONPLANCUENTAS
                                   WHERE CUENTACONTABLE IN (SELECT CUENTACONTABLEIVACOBRADO FROM CONCIERRESDIARIOS)) AS NombreCuenta,
                            IVACOBRADOTARIFA12 VALOR,CUENTACONTABLEIVACOBRADO CUENTA,'H' Tipo
                          FROM CONCIERRESDIARIOS
                          WHERE IDCIERREDIARIO = $IdCierreDiario";
           $xValorCuentaCaja              = 0;
           $xCuentaContable               = '';
           $xValorCuentasxCobrarClientes  = 0;
           $codigoHtmlGrid ='';
           while($reg_CierreDiario=  mysqli_fetch_array($ResultCierres))
           {
             if($reg_CierreDiario['VALOR'] > 0)
             {
                if($reg_CierreDiario['Tipo']=='D')
                {
                   $codigoHtmlGrid= "<tr><td>".$reg_CierreDiario['CUENTA']."</td><td>".$reg_CierreDiario['NombreCuenta'].
                               "</td><td>".$reg_CierreDiario['VALOR']."</td><td></td></tr>";
                }
                else
                {
                   $codigoHtmlGrid= "<tr><td>".$reg_CierreDiario['CUENTA']."</td><td>".$reg_CierreDiario['NombreCuenta'].
                               "</td><td></td><td>".$reg_CierreDiario['VALOR']."</td></tr>";               
                }
              }


           }           
       date_default_timezone_set('UTC');
       $fechaHoy = date('d/m/yy');

      }
  
?>
<!DOCTYPE html>
<html>
  <head>
    <title> SISTEMA IMPORTBOOKS </title>
    <script type='text/javascript' language='javascript' src='../js/funciones.js'>      </script>
    <script type='text/javascript' language='javascript' src='../js/alertifyjs/alertify.js'>  </script>
    <script type='text/javascript' language='javascript' src='../js/jquery.js'>         </script>
    <meta http-equiv='Content-Type' content='text/html'; charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'/>
    <link rel='stylesheet' href='../css/estilos.css' >
    <link rel='stylesheet' href='../css/bootstrap.css'>
    <link rel='stylesheet' href='../js/alertifyjs/css/alertify.css'>

    <style type="text/css">
        .sinborde   { border: 0;   }
        body,select { font-family: arial, 'Times New Roman',Times, serif;
                      font-size: 12px;} 

    </style>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">


  </head>
<!---   <body onload='return inicio(\"\")'>    -->
<body >

<section>

  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' action="GrabarFacturaProveedor.php" >  
      <div class='container'>
        <div class='panel panel-default'>
            <div class="panel-heading" style="font-size: 20px;color:#0080FF;font-weight:bold;">CONTABILIZAR VENTAS
              <?php echo "<button class='btn btn-primary btn-sm' title='Regresar' style='font-size:12px;color:#0080FF;background-color:    #FFFF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span> </button>";?>
              <button type="submit" class="btn btn-primary btn-sm" title='Grabar' onClick='trampa();' style='font-size:12px;color:#0080FF;background-color:#FFFF00;border:none'><span class='glyphicon glyphicon-floppy-save'></span></button>
              <button class='btn btn-primary btn-sm' title='Limpiar btn-sm' onclick='' type='reset' style='font-size:12px;color:#0080FF;background-color:#FFFF00;border:none'><span class='glyphicon glyphicon-refresh'></span></button> 
            </div>
          <div class="panel-body">
              <div class="panel-body" style="width:100%; float:left; display:block;"> 
                  <div class="form-row"  >
                      <input type='hidden' id='IdProveedor' name='IdProveedor' value=''>
                      <input type='hidden' id='NumeroFilas' name='NumeroFilas' value='0'/>

                      <input type='hidden' id='Email' name='Email' >
                      <input type='hidden' id='Direccion' name='Direccion' >
                      <input type='hidden' id='ivaActual' name='ivaActual' value='<?php echo $ivaActual;?>' >
                      <div class="form-group col-md-6">
                          <label style='color:#0080FF' for="proveedor">Fecha de Cierres:</label>
                          <select style='color:#0080FF' id='IdCierre' name='IdCierre' class="form-control" required="yes" onchange="plantillaContable()">
                            <option value=''>Seleccionar</option>
                            <?php echo $ListaCierresVentas;?>
                          </select>
                      </div>
                      <div class="form-group col-md-6">
                              <label style='color:#0080FF'  for="f_apellidos">Fecha Contabilizació: </label>
                              <input style='color:#0080FF' type="text" class="form-control" id="FecContabilizar" name='FecContabilizar' required="yes" readonly="yes" value= "<?php echo $fechaHoy;?> "> 


                      </div>        
                  </div> 
  
              </div>

             </div>              
          </div>            
        </div>   

  <div class="container">
    <div class='panel panel-default'>
      <div class="panel-heading" style="font-size: 12px;color:#0080FF;font-weight:bold;" >DETALLE DE ASIENTO</div>
       <div class="panel-body" style="width:100%; display:block;">


           <table class='table table-bordered table-hover' id='tabla1'>
              <style> table {font-family: arial, 'Times New Roman', Times, serif;
                           border-collapse: collapse;
                           width: 80%;
                           font-size: 12px;}
            </style>   
            <?php
               $iconoEliminar = 'glyphicon glyphicon-trash';
               $codigoHtml= "<span class='".$iconoEliminar."'></span>";
            ?>
            <thead class='fixedHeader' >
              <tr>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='15%'><b><center>Cuenta</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='65%'><b><center>Nombre Cuenta</center></b></th>                
                <th bgcolor='#FFFF00' style='color: #0080FF' width='10%'><b><center>Debe</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='10%'><b><center>Haber</center></b></th>

                <!---<th bgcolor='#FFFF00' style='color: #0080FF' width='5%'><b><center><?php echo $codigoHtml;?></center></b></th>-->
                <!--- <?php echo $codigoHtmlGrid;?>-->
              </tr>
            </thead>
            <tbody id='detalle'>
            </tbody>
        </table>    
     </div>
  </div>
</div>

 </form>
</section>
<p style='font-size:16pt;color:red' id='mi_mensaje' name='mi_mensaje'>  </p>
</body>


<script type="text/javascript">
   var xhr;
   var existeProducto=0;

function plantillaContable()
{
      var IdCierre =document.getElementById('IdCierre').value;
      alert(IdCierre);
        //setearTabla();
        $.ajax({

                  url: 'retornaDatosContabVentas.php',
                  data: {'criterio': IdCierre},
                  type: 'POST',
                  contentType: 'application/x-www-form-urlencoded',
                  dataType: 'JSON',

                  success: function(data)
                  {
                   var i        =   0;
                   var html     =   '';
                   var contador =   0;
                   var nregs    =   data.VALOR.length;
                   var totalDebe =  0;
                   var totalHaber = 0 ;
                   for(i=0;i<nregs;i++)
                   {
                     html='<tr><td>'+data.CUENTA[i]+'</td>';
                     if (data.Tipo[i]=='D')
                     {
                        html=html+'<td>'+data.NombreCuenta[i]+'</td><td>'+data.VALOR[i]+'</td><td></td>';
                        totalDebe=totalDebe+parseFloat(data.VALOR[i]);
                     }
                     else
                     {
                        html=html+'<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'+data.NombreCuenta[i]+'</td><td></td><td>'+data.VALOR[i]+'</td>';
                        totalHaber=totalHaber+parseFloat(data.VALOR[i]);
                     }
                     html=html+'</tr>';
                     $('#detalle').append(html);
                   }
                   html="<tr><td colspan='2'  align='right' bgcolor='#C6F870' style='color:#2E64FE;'>Totales:</td><td bgcolor='#FE2E64' style='color:#81F79F;'>"+totalDebe+"</td><td  bgcolor='#FE2E64' style='color:#81F79F;'>"+totalHaber+'</td></tr>';
                   $('#detalle').append(html);
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

</script>
</html> 

   
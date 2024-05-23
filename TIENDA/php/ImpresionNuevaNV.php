<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
        $v_usuario=$_SESSION['user'];
        $xIdAlmacen = $_SESSION['idalmacen'];
        include("Conexion.php");  
        $xIdMov   = $_REQUEST['IdMov'];
        #---- Datos Factura ------------------------------
        $StrSql="select * from movta where  IdMov=$xIdMov and TipDoc=2";
        $ResultSet= mysqli_query($conexion,$StrSql);
        $regMovta= mysqli_fetch_assoc($ResultSet);
        $xIdCaja        = $regMovta['IdCaja'];
        $xIdTipDoc        = $regMovta['IdIdTipDoc'];
        $xFecha         = $regMovta['Fecha'];
        $xSubtotal        = $regMovta['SubTotal'];
        $xDescuento             = $regMovta['Descuento'];
        $xImpuesto              = $regMovta['Impuesto'];
        $xTotal         = $regMovta['Total'];
        $xIdAlmacen       = $regMovta['IdAlmacen'];
        $xIdCliente       = $regMovta['IdCliente'];
        $xFactSri         = $regMovta['FactSri'];
        $xEstado        = $regMovta['Estado'];
        $x_audit_usuario    = $regMovta['aud_usuario_proc'];
        $x_audit_fecha  = $regMovta['aud_fecha_proc'];
        #------- Informacion del cliente ------------------
        $StrSql="select * from clientes where IdCliente=$xIdCliente";
        $ResultSet= mysqli_query($conexion,$StrSql);
        $regCli= mysqli_fetch_assoc($ResultSet);

        $xCedulaCliente   = $regCli['CedulaRUC'];
        $xNombreCliente   = $regCli['Apellidos'].' '.$regCli['Nombres'];
        $xDireccionCliente= $regCli['Direccion'];
        $xTelefonoCliente = $regCli['Telefonos'];
        $xEmailCliente    = $regCli['Email'];
        #------ Informacion de la emoresa ----------------
        $StrSql="select * from systemprofile";
        $ResultSet= mysqli_query($conexion,$StrSql);
        $regProfile= mysqli_fetch_assoc($ResultSet);

        $xRucEmpresa      = $regProfile['RUC'];
        $xNombreEmpresa   = $regProfile['NombreEmpresa'];
        $xDireccionEmpresa= $regProfile['Direccion'];
        $xTelefonoEmpresa = $regProfile['Telefonos'];
        $xPorcentajeIva   = $regProfile['Iva'];


        $CodigoHtml="";
        $CodigoHtml.="            
        <!DOCTYPE html>
        <html>
            <head>

                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                    <title>SISTEMA POS ALT-64 | COMPROBANTE DE VENTA </title>
                    <style>
                    @page { margin: 180px 50px; }
                            #header { position: fixed; left: 0px; top: -200px; right: 0px; height: 200px; text-align: center; }
                            #footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 50px; text-align: center;}
                    #footer .page:after { content: counter(page, upper-arial); }
                    </style>
                    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
            </head>
            <body>
                <div id='header' style='font-size: 13px;'>
                    <br>
                    <center>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>                                                
                        <b style='font-size: 16px;'>ALABAHIA.COM</b></font><br>
                        
                        <b>VENTAS AL POR MAYOR DE MÁQUINAS Y EQUIPOS DE OFICINA</b></font><br>
                        <b>INCLUSO PARTES Y PIEZAS DE COMPUTADORAS</b></font><br>
                        <b>VENTAS AL POR MAYOR DE OTROS APARATOS, ARTICULOS Y EQUIPOS DE USO DOMÉSTICO</b></font><br>
                        <b>Dir:XXXXXXXXXXX</b></font><br>
                        <b>XXXXXXX</b></font><br>
                        <b>Telf.: 4444444 Cel.: 09555555</b></font><br>
                        <b></b>Email: ALABAHIA@hotmail.com</font><br><br>
                        <b style='font-size: 16px;'>No. ".str_pad($xFactSri,7,'0',STR_PAD_LEFT)."</b>                                                                                              
                        <br>
                    </center>
            
                    <style>
                        table {
                        font-family: 'Poppins', sans-serif;
                        border-collapse: collapse;
                        width: 100%;
                        font-size: 10px;
                        }
                    </style>";
                    $CodigoHtml.="<table  width=100% >";
                    $CodigoHtml.="<tr><td width=15%></td><td width=25%></td><td width=15%></td><td width=45%></td></tr>";
                    $CodigoHtml.="<tr><td style='font-size: 10px;'>CÉDULA/RUC:   </td><td style='font-size: 10px;'>".$xCedulaCliente."</td>".
                                     "<td style='font-size: 10px;'>NOMBRE:       </td><td style='font-size: 10px;'>".$xNombreCliente."</td></tr>";
                    $CodigoHtml.="<tr><td style='font-size: 10px;'>FECHA:        </td><td style='font-size: 10px;'>".$x_audit_fecha. "</td>".
                                     "<td style='font-size: 10px;'>TELÉFONOS:    </td><td style='font-size: 10px;'>".$xTelefonoCliente."</td></tr>";
                    $CodigoHtml.="<tr><td style='font-size: 10px;'>EMAIL:        </td><td style='font-size: 10px;'>".$xEmailCliente."</td>".
                                     "<td style='font-size: 10px;'>DIRECCIÓN:    </td><td style='font-size: 10px;'>".$xDireccionCliente."</td></tr>";   
                    $CodigoHtml.="<tr><td style='font-size: 10px;'>REFERENCIA:   </td><td style='font-size: 10px;'>".str_pad($xIdMov,7,'0',STR_PAD_LEFT)."</td>".
                                     "<td style='font-size: 10px;'>    </td><td style='font-size: 10px;'></td></tr>";                                        
                    $CodigoHtml.="</table>";
                    $CodigoHtml.="<center></center>";
                    $codigoHtml.="<br><br><br><br><br><br>";
                    $codigoHtml.="<br><br><br><br><br><br>";     
                    $CodigoHtml.="<table  width=100% >";                    
                    $CodigoHtml.="<tr><td width=15%></td><td style='font-size: 12px;color:#FFFFFF;' width=25%>A</td><td width=15%></td><td width=45%></td></tr>";    
                    $CodigoHtml.="<tr><td width=15%></td><td style='font-size: 12px;color:#FFFFFF;' width=25%>A</td><td width=15%></td><td width=45%></td></tr>";   
                    $CodigoHtml.="</table>";                                                                               
                    $CodigoHtml.="<table  width=100% >";
                    $CodigoHtml.="<tr><td width=15% ALIGN='CENTER' style='background-color: #000000; color: #FFFFFF;'><b>ÍTEMS</b></td><td width=40% ALIGN='CENTER' style='background-color: #000000; color: #FFFFFF;'><b>DESCRIPCIÓN</b></td><td width=15% ALIGN='CENTER' style='background-color: #000000; color: #FFFFFF;'><b>CANTIDAD</b></td><td width=15% ALIGN='CENTER' style='background-color: #000000; color: #FFFFFF;'><b>PRECIO UNIT.</b></td><td width=15% ALIGN='CENTER' style='background-color: #000000; color: #FFFFFF;'><b>TOTAL</b></td></tr>";
     
                           
                            #----- Detalle Factura --------------------------------
                             $StrSql = "SELECT * FROM movref WHERE IdMov = $xIdMov";
                             $rs     = mysqli_query($conexion,$StrSql);
                             while($regDetalle= mysqli_fetch_array($rs))
                             {
                              $xIdReferencia     = $regDetalle['IdReferencia'];
                              $xCantidad         = $regDetalle['Cantidad'];
                              $xPrecio           = $regDetalle['Precio'];
                              $xTotalLinea       = $regDetalle['TotalLinea'];
                              $StrSql            = "SELECT DescripcionReferencia FROM referencias WHERE IdReferencia = $xIdReferencia";
                              $rsDetalle         = mysqli_query($conexion,$StrSql);
                              $regReferencia     = mysqli_fetch_assoc($rsDetalle);
                              $xDescripcionItem  = $regReferencia['DescripcionReferencia'];
                              $CodigoHtml.=        "<tr style='font-size: 10px;'>".
                                                      "<td>".str_pad($xIdReferencia,7,'0',STR_PAD_LEFT)."</td>".
                                                      "<td>".substr($xDescripcionItem,0,40)."</td>".
                                                      "<td ALIGN='right'>".number_format($xCantidad,2,'.',',')."</td>".                                                      
                                                      "<td ALIGN='right'>".number_format($xPrecio,2,'.',',')."</td>".
                                                      "<td ALIGN='right'>".number_format($xTotalLinea,2,'.',',')."</td></tr>";

                                    $strSeries="select * from ventasitemsseries where IdMov=$xIdMov".
                                                " and IdReferencia=$xIdReferencia";
                                    $rsseries = mysqli_query($conexion,$strSeries);
                                    $CodigoHtml.="<tr style='font-size: 10px;'><td colspan='5'>Números de Serie</td></tr>";
                                    while($regcomseries= mysqli_fetch_array($rsseries))
                                    {
                                        $CodigoHtml.="<tr style='font-size: 10px;'><td colspan='5'>".$regcomseries['IdNumeroSerie']."</td></tr>";
                                    }



                             }
                             $CodigoHtml.="<tr></td><td colspan='5'> </td><td style='font-size: 12px;color:#FFFFFF;'>1 </td></tr>";
                             $CodigoHtml.="<tr></td><td colspan='5'> </td><td style='font-size: 12px;color:#FFFFFF;'>2 </td></tr></table>";


                             $CodigoHtml.="<table width=100%>
                                             <tr><td width=30% ALIGN='CENTER' ><b>Firma Autorizada</b></td>
                                                 <td width=5% ALIGN='CENTER' ></td>
                                                 <td width=30% ALIGN='CENTER' ><b>Recibí Conforme</b></td>
                                                 <td width=5% ALIGN='CENTER' ></td>
                                                 <td width=15% style='font-size: 10px;'>SUBTOTAL:</td><td width=15% style='font-size: 10px;' ALIGN='right'>$".number_format($xSubtotal,2,'.',',')."</td></tr>";
                            $CodigoHtml.="<tr><td colspan='4'></td><td>DESCUENTO:</td><td style='font-size: 10px;' ALIGN='right'>$".number_format($xDescuento,2,'.',',')."</td></tr>";
                            $CodigoHtml.="<tr><td colspan='4'></td><td>TOTAL    :</td><td style='font-size: 10px;' ALIGN='right'>$".number_format($xTotal,2,'.',',')."</td></tr>"; 
                            $CodigoHtml.="<tr><td ALIGN='CENTER'>---------------------------------</td><td></td><td ALIGN='CENTER'>--------------------------------</td><td></td><td></td></tr></table>";    


                           // $CodigoHtml.="<tr><td colspan='6'></td></tr></table>  ";                      

                            
        
                             $CodigoHtml.="<br>";
                             $CodigoHtml.="<br>";
                             $CodigoHtml.="<div style='width:50%;'>";
                             $CodigoHtml.="<table border=1 >";
                            // $CodigoHtml.="<tr><td width=50%></td><td width=50></td></tr>";
                             $CodigoHtml.="<tr><td colspan='2' ALIGN='CENTER'>FORMAS DE PAGO</td></tr>";
                             #------ Formas de Pago----------------
                             $StrSql = "SELECT * FROM formapagofactura WHERE IdMovta = $xIdMov";
                             $rs     = mysqli_query($conexion,$StrSql);
                             while ($regFPago= mysqli_fetch_array($rs))
                             {
                                $xIdFormapago= $regFPago['IdFormaPago'];
                                $xIdTarjeta  = $regFPago['IdTarjetas'];
                                $xIdBanco    = $regFPago['IdBanco'];
                                $xValorFormaPago = $regFPago['Valor'];
                                #-----ontiene nombre forma pago------------------------------
                                $StrSql="select * from formapago where IdFormaPago=$xIdFormapago";
                                $rsFormaPago  = mysqli_query($conexion,$StrSql);
                                $regFormaPagos= mysqli_fetch_assoc($rsFormaPago);
                                $xNombreFormaPago = $regFormaPagos['DescripcionFormaPago'];
                                #-----ontiene nombre bancos------------------------------
                                $StrSql="select * from bancos where IdBanco=$xIdBanco";
                                $rsBanco  = mysqli_query($conexion,$StrSql);
                                $regBanco= mysqli_fetch_assoc($rsBanco);
                                $xNombreBanco = $regBanco['DescripcionBanco'];
                                #-----ontiene nombre tarjetas------------------------------
                                $StrSql="select * from tarjetas where IdTarjeta=$xIdTarjeta";
                                $rsTarjetas   = mysqli_query($conexion,$StrSql);
                                $regTarjeta= mysqli_fetch_assoc($rsTarjetas);
                                $xNombreTarjeta = $regTarjeta['DescripcionTarjeta'];     
                                #---------arma String con todo el desglose del pago ----#                           
                                $strFormaPago =$xNombreFormaPago." ".$xNombreTarjeta." ".$xNombreBanco;
                                $CodigoHtml.="<tr><td>$strFormaPago</td><td ALIGN='right'>$".number_format($xValorFormaPago,2,'.',',')."</td></tr>";
                            } 
                            //$CodigoHtml.="<tr><td></td><td></td></tr>
                            $CodigoHtml.="</table></div>";
                            $CodigoHtml.="<br>";
                            $CodigoHtml.="<br>";
                            $CodigoHtml.="<center style='font-size: 10px;font-family: Poppins, sans-serif;'>MUCHAS GRACIAS POR SU COMPRA</center><br>";
                            $CodigoHtml.="<center style='font-size: 10px;font-family: Poppins, sans-serif;'>SALIDA LA MERCADERÍA NO SE ACEPTAN DEVOLUCIONES</center>";                            
                           // $CodigoHtml.="</div>";                         
                            $CodigoHtml.="</body>";
                            $CodigoHtml.="</html>";   
          }
    //echo $CodigoHtml;

                            require_once 'dompdf/autoload.inc.php';
                             use Dompdf\Dompdf;
                             define('DOMPDF_ENABLE_AUTOLOAD', false);
                             $documentopdf = new Dompdf();
                            // $documentopdf->setPaper('A4','PORTRAIT');
                             $documentopdf->load_html($CodigoHtml);
                             $documentopdf->render();
                             //$documentopdf->stream("ComprobanteFactProv_".$xIdFactProv.".pdf");
                             $documentopdf->stream("ComprobanteNV.pdf");
   
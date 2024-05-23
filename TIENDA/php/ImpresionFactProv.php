<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
        $v_usuario=$_SESSION['user'];
        include("Conexion.php");  
        $xIdFactProv    = $_REQUEST['IdFact'];
        #---- Datos Factura ------------------------------
        $StrSql="select * from factprov where  IdFacturaProveedor=".$xIdFactProv;
        $ResultSet= mysqli_query($conexion,$StrSql);
        $regFactProv= mysqli_fetch_assoc($ResultSet);
        $xIdFactProvSRI                  = $regFactProv['IdFacturaProveedorSRI'];
        $xFechaFactura                   = $regFactProv['Fecha'];
        $xIdProveedor                    = $regFactProv['IdProveedor'];
        $xSubTotal                       = $regFactProv['SubTotal'];
        $xDescuento              = $regFactProv['Descuento'];
        $xImpuesto               = $regFactProv['Iva'];
        $xTotal                          = $regFactProv['Total'];
        $xIdFormaPago            = $regFactProv['IdFormaPago'];
        $xIdAlmacen                    = $regFactProv['IdAlmacen'];
        $xEstadoFinancieroFactura= $regFactProv['EstadoFinancieroFactura'];
        $xEstadoFactura          = $regFactProv['EstadoFactura'];
        $xAuditUsuario           = $regFactProv['aud_usuario_proc'];
        $xAuditFecha             = $regFactProv['aud_fecha_proc'];
        #------- Informacion del proveedor ------------------
        $StrSql="select * from proveedores where IdProveedor=$xIdProveedor";
        $ResultSet= mysqli_query($conexion,$StrSql);
        $regProv  = mysqli_fetch_assoc($ResultSet);
        $xRUC               = $regProv['RUC'];
        $xNombreProveedor   = $regProv['DescripcionProveedor'];
        $xDireccionProveedor= $regProv['Direccion'];
        $xTelefonos         = $regProv['Telefonos'];
        $xEmail             = $regProv['Email'];
        #------ Informacion de la emoresa ----------------
        $StrSql="select * from systemprofile";
        $ResultSet= mysqli_query($conexion,$StrSql);
        $regProfile= mysqli_fetch_assoc($ResultSet);

        $xRucEmpresa      = $regProfile['RUC'];
        $xNombreEmpresa   = $regProfile['NombreEmpresa'];
        $xDireccionEmpresa= $regProfile['Direccion'];
        $xTelefonoEmpresa = $regProfile['Telefonos'];

        $CodigoHtml="";
        $CodigoHtml.="            
        <!DOCTYPE html>
        <html>
            <head>

                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                    <title>SISTEMA POS ALT-64 | INGRESO DE COMPRA-FACTURA DE PROVEEDORES </title>
                    <style>
                    @page { margin: 180px 50px; }
                            #header { position: fixed; left: 0px; top: -200px; right: 0px; height: 200px; text-align: center; }
                            #footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 50px; text-align: center;}
                    #footer .page:after { content: counter(page, upper-arial); }
                    </style>
                    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
                    
            </head>
            <body>
                <div id='header' >
                    <br>
                    <center style='font-size: 12px;color:#0080FF;font-weight:bold;'>
                        <br>
                        <br>
                        <font size=4><b>INGRESO DE COMPRAS</b></font><br>
                        <font size=4><b>".$xNombreEmpresa."</b></font><br>
                        <font size=4><b>".$xDireccionEmpresa."</b></font><br>
                        <br>
                    </center>

                        <center style='font-size: 12px;'>Detalle de Factura </center>
                        <br>
                    <table width='100%' cellspacing='0' style='font-size: 11px;'>
                        <tr>
                            <td><b>Código</b></td>
                            <td><b>Descripción</b></td>
                            <td><b>Cant.</b></td>
                            <td><b>P. Unit</b></td>
                            <td><b>Valor</b></td>
                        </tr>";
                             #----- Detalle Factura --------------------------------
                             $StrSql = "SELECT * FROM factprovdetalle WHERE IdFacturaProveedor = $xIdFactProv";
                             $rs     = mysqli_query($conexion,$StrSql);
                             while($regDetalle= mysqli_fetch_array($rs))
                             {
                                $xSecuencial    = $regDetalle['Secuencial'];
                                $xIdReferencia  = $regDetalle['IdReferencia'];
                                $xCantidad      = $regDetalle['Cantidad'];
                                $xPrecioCompra  = $regDetalle['PrecioCompra'];
                                $xTotalBruto    = $regDetalle['TotalBruto'];
                                $xDescuentod    = $regDetalle['Descuento'];
                                $xSubtotald     = $regDetalle['Subtotal'];
                                $xIvad          = $regDetalle['Iva'];
                                $xTotalLinea    = $regDetalle['TotalLinea'];
                              
                                $StrSql = "SELECT DescripcionReferencia FROM referencias WHERE IdReferencia = $xIdReferencia";
                                $rsRefe             = mysqli_query($conexion,$StrSql);
                                $regReferencia      = mysqli_fetch_assoc($rsRefe);
                                $xDescripcionItem   = $regReferencia['DescripcionReferencia'];
                                $CodigoHtml.="<tr><td>$xIdReferencia</td><td>$xDescripcionItem</td><td>$xCantidad</td><td>$xPrecioCompra</td><td>$xTotalLinea</td></tr>";
                                    // impresion de las series
                                   /* $strSeries="select * from comprasitemsseries where IdMov=$xIdFactProv".
                                                " and IdReferencia=$xIdReferencia";
                                    $rsseries = mysqli_query($conexion,$strSeries);
                                    $CodigoHtml.="<tr><td colspan='5'></td></tr>";
                                    $CodigoHtml.="<tr><td colspan='5'>Numeros de Serie</td></tr>";
                                    while($regcomseries= mysqli_fetch_array($rsseries))
                                    {
                                        $CodigoHtml.="<tr><td colspan='5'>".$regcomseries['IdNumeroSerie']."</td></tr>";
                                    }*/


                                    $strSeries="select * from comprasitemsseries where IdMov=$xIdFactProv".
                                                " and IdReferencia=$xIdReferencia";
                                    $rsseries = mysqli_query($conexion,$strSeries);
                                    $CodigoHtml.="<tr style='font-size: 10px;'><td colspan='5'><b>Números de Serie : </b>";
                                    // $CodigoHtml.="<tr style='font-size: 10px;'><td colspan='5'>";
                                    $contador=0;
                                    //$contadorRegistros=0;
                                    $cantidadRegistros = $rsseries->num_rows;
                                    while($regcomseries= mysqli_fetch_array($rsseries))
                                    {
                                        // $contadorRegistros++;
                                        $contador++;
                                        if($contador<$cantidadRegistros)
                                            $CodigoHtml.=$regcomseries['IdNumeroSerie']." - ";
                                        else
                                        
                                            $CodigoHtml.=$regcomseries['IdNumeroSerie'];
                                        // $contador=0;
                                        // $CodigoHtml.="<tr style='font-size: 10px;'><td colspan='5'>";
                                        
                                        
                                    }
                                    $CodigoHtml.="</td></tr>";





                             }
                             $CodigoHtml.="</table>";
                             $CodigoHtml.="<br>";
                             $CodigoHtml.="<table width='100%' cellspacing='0' style='font-size: 11px;'>";
                             $CodigoHtml.="<tr><td colspan='4'>Subtotal:  </td><td>$xSubTotal  </td></tr>";
                             $CodigoHtml.="<tr><td colspan='4'>Descuento: </td><td>$xDescuento </td></tr>";
                             $CodigoHtml.="<tr><td colspan='4'>Impuesto:  </td><td>$xImpuesto  </td></tr>"; 
                             $CodigoHtml.="<tr><td colspan='4'>Total:     </td><td>$xTotal     </td></tr>"; 
                             $CodigoHtml.="</table>";
                             $CodigoHtml.="<br>";
                             $CodigoHtml.="<center>Forma de Pago<center>";
                             $CodigoHtml.="<table width='100%' cellspacing='0' style='font-size: 11px;'>";
                             #------ Formas de Pago----------------
                             $StrSql = "SELECT * FROM formapagoproveedores WHERE IdFormaPagoProveedor = $xIdFormaPago";
                             $rsFormaPago    = mysqli_query($conexion,$StrSql);
                             while ($regFormaPagos= mysqli_fetch_array($rsFormaPago))
                             {
                                $xNombreFormaPago = $regFormaPagos['DescripcionFormaPago'];
                                $CodigoHtml.="<tr><td>FormaPago</td><td>$xNombreFormaPago</td></tr>";
                            } 
                            $CodigoHtml.="</table>";
                            $CodigoHtml.="<br>";
                            $CodigoHtml.="<table width='100%' cellspacing='0' style='font-size: 11px;>";
                            $CodigoHtml.="<tr><td >Comprobante No.  </td><td colspan='2'>".$xIdFactProv.         "</td></tr>";
                            $CodigoHtml.="<tr><td >Cédula Ruc:      </td><td colspan='2'>".$xRUC."</td></tr>";
                            $CodigoHtml.="<tr><td >Nombre Proveedor:</td><td colspan='2'>".$xNombreProveedor."</td></tr>";
                            $CodigoHtml.="<tr><td >Fecha Ingereso  :</td><td colspan='2'>".$xAuditFecha."</td></tr>";
                            $CodigoHtml.="<tr><td >No. Factura Proveedor:</td><td colspan='2'>".$xIdFactProvSRI ."</td></tr>";
                            $CodigoHtml.="<tr><td >No. Ingreso Compra:</td><td colspan='2'>".$xIdFactProv."</td></tr>";
                            $CodigoHtml.="</table>";
                            $CodigoHtml.="</div></body></html>";   
 

          }




    //echo $CodigoHtml;
                           //---------Impresion del ingreso de la factura
                            require_once 'dompdf/autoload.inc.php';
                             use Dompdf\Dompdf;
                             define('DOMPDF_ENABLE_AUTOLOAD', false);
                             $documentopdf = new Dompdf();
                            // $documentopdf->setPaper('A4','PORTRAIT');
                             $documentopdf->load_html($CodigoHtml);
                             $documentopdf->render();
                             //$documentopdf->stream("ComprobanteFactProv_".$xIdFactProv.".pdf");
                             $documentopdf->stream("ComprobanteFact.pdf");
                            // $documentopdf->stream("ComprobanteFactProv_".$xIdFactProv.".pdf",array("Attachment"=>false)); 
    /*require_once("dompdf/autoload.inc.php");
        use Dompdf\Dompdf;
    $documentopdf= new DOMPDF();
    
    //$documentopdf->loadHtml($purocodigo);
    $documentopdf->loadHtml(ob_get_clean());
    $documentopdf->loadHtml($CodigoHtml);
    	//    $dompdf->load_html(utf8_encode($purocodigo));
    	  //  ini_set("memory_limit","128M");
    	    $documentopdf->render();
    	 //   $documentopdf->stream("Li.pdf",array("Attachment"=>0));
    $documentopdf->stream("ComprobanteFactProv_".$xIdFactProv.".pdf",array("Attachment"=>false)); 
   */
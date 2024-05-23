<?php 

  $IdFactura=300;
  {
        include("Conexion.php");
        $sqlSystem              = "SELECT * FROM systemprofile";
        $rsSystem               = mysqli_query($conexion,$sqlSystem);
        $regSystem              = mysqli_fetch_assoc($rsSystem);
        $xRUC                   = $regSystem['RUC'];
        $xNombreEmpresa         = $regSystem['NombreEmpresa'];
        $xNombreComercial       = $regSystem['NombreComercial'];
        $xRazonSocial           = $regSystem['NombreEmpresa'];
        $xDireccion             = $regSystem['Direccion'];
        $xTarifaImpuesto        = $regSystem['Iva'];
        $xMailVendedor          = $regSystem['email'];
        $strFacturasXML="";
        $contadorArchivos=0;

        $cabeceraXML ="<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?>\r";
        $cabeceraXML.="<factura id=\"comprobante\" version=\"1.0.0\">\r";
        $datosEmisor ="<infoTributaria>\r";
        $datosEmisor.="   <ambiente>2</ambiente>\r";
        $datosEmisor.="   <tipoEmision>1</tipoEmision>\r";
        $datosEmisor.="   <razonSocial>".$xRazonSocial."</razonSocial>\r";
        $datosEmisor.="   <nombreComercial>".$xNombreComercial."</nombreComercial>\r";
        $datosEmisor.="   <ruc>".$xRUC."</ruc>\r";
        $datosEmisor.="   <claveAcceso>0000000000000000000000000000000000000000000000000</claveAcceso>\r";
        $datosEmisor.="   <codDoc>01</codDoc>\r";
        $datosEmisor.="   <estab>001</estab>\r";
        $datosEmisor.="   <ptoEmi>001</ptoEmi>\r";
        $strXML = $cabeceraXML.$datosEmisor;
    
        $sqlFacturasXML= "select a.IdMov as IdMov,a.Fecha as fechaEmision,'$xDireccion' as dirEstablecimiento, 
        				      '000' as ContribuyenteEspecial,'SI' as ObligadoLlevarContabilidad,
        				      '000-000-000000000' as guiaRemision,
        				      TRIM(CONCAT(e.Apellidos,' ',IFNULL(e.nombres,''))) AS razonSocialComprador,
        				      e.CedulaRUC as identificacionComprador,e.Direccion as direccionComprador,a.SubTotal as TotalBruto,
        				      0 as totalSubsidio, a.Descuento as totalDescuento,2 as codigo,2 as codigoPorcentaje, (SubTotal-a.Descuento) as baseImponible,Impuesto as valor,0 as propina,
        				      'DOLAR' as moneda,Total as total, e.Email as email,a.Total as Total,e.IdTipoDocumento as IdTipoDoc,a.FactSri as SecSRI
						from movta a, clientes e
                        where a.IdMov =$IdFactura and a.IdCliente = e.IdCliente";

        $rsFacturasXML = mysqli_query($conexion,$sqlFacturasXML);
        
        while($regFacturasXML= mysqli_fetch_array($rsFacturasXML))
        {
           
           $IdMov                =    $regFacturasXML['IdMov'];
           $SecuencialSRI        =    $regFacturasXML['SecSRI'];
           $anio                 =    substr($regFacturasXML['fechaEmision'],0,4);
           $mes                  =    substr($regFacturasXML['fechaEmision'],5,2);
           $dia                  =    substr($regFacturasXML['fechaEmision'],8,2);
           $fecha                =    $dia.'/'.$mes.'/'.$anio;
           $eMail                =    $regFacturasXML['email'];


           $TipoIdentificacion = "";
           switch ($regFacturasXML['IdTipoDoc']) {
             case 'C':
               $TipoIdentificacion = "05";
               break;
             case 'R':
               $TipoIdentificacion = "04";
               break;
             case 'P':
               $TipoIdentificacion = "06";
               break;
           }
           $strFacturasXML.="    <secuencial>".str_pad($SecuencialSRI,9,'0',STR_PAD_LEFT)."</secuencial>\r";
           $strFacturasXML.="    <dirMatriz>".$xDireccion."</dirMatriz>\r";
           $strFacturasXML.=" </infoTributaria>\r";
           $strFacturasXML.="<infoFactura>\r";
           

           $xDireccionComprador='';
           if($regFacturasXML['identificacionComprador']=='9999999999999')
           { 
           	  $TipoIdentificacion = "07";
           	  $xDireccionComprador = $xDireccion;
              $razonSocialComprador = 'CONSUMIDOR FINAL';
              $eMail = $xMailVendedor ;
           }
           else
           {
           	  $xDireccionComprador=$regFacturasXML['direccionComprador'];
           }
           switch ($xTarifaImpuesto) 
           {
             case 10:
               $xcodigoPorcentaje = "0";
               break;
             case 12:
               $xcodigoPorcentaje = "2";
               break;
             case 14:
               $xcodigoPorcentaje = "3";
               break;               
           }

           $strFacturasXML.="   <fechaEmision>".$fecha."</fechaEmision>\r";
           $strFacturasXML.="   <dirEstablecimiento>".$regFacturasXML['dirEstablecimiento']."</dirEstablecimiento>\r";
           $strFacturasXML.="   <contribuyenteEspecial>000</contribuyenteEspecial>\r";
           $strFacturasXML.="   <obligadoContabilidad>SI</obligadoContabilidad>\r";
           $strFacturasXML.="   <tipoIdentificacionComprador>".$TipoIdentificacion."</tipoIdentificacionComprador>\r";
           $strFacturasXML.="   <guiaRemision>000-000-000000000</guiaRemision>\r";
           $strFacturasXML.="   <razonSocialComprador>".$regFacturasXML['razonSocialComprador']."</razonSocialComprador>\r";
           $strFacturasXML.="   <identificacionComprador>".$regFacturasXML['identificacionComprador']."</identificacionComprador>\r";
           $strFacturasXML.="   <direccionComprador>".$xDireccionComprador."</direccionComprador>\r";
           $strFacturasXML.="   <totalSinImpuestos>".number_format(($regFacturasXML['TotalBruto']-$regFacturasXML['totalDescuento']),2)."</totalSinImpuestos>\r";
           $strFacturasXML.="   <totalSubsidio>0.00</totalSubsidio>\r";
           $strFacturasXML.="   <totalDescuento>".number_format($regFacturasXML['totalDescuento'],2)."</totalDescuento>\r";
           $strFacturasXML.="   <totalConImpuestos>\r";
           
           #------ calcula la base 0 y base iva--------------------
           $xSubTotalBase0=0;
           $xSubTotalBaseIva=0;
           $xValorIvaBaseIva=0;
           $sqlFacturaDetalles= "select * from movref,referencias where movref.IdMov = $IdMov and movref.IdReferencia= referencias.IdReferencia";
           $rsFacturaDetalles = mysqli_query($conexion,$sqlFacturaDetalles);
           while($regFacturaDetalle= mysqli_fetch_array($rsFacturaDetalles))
           {
              if($regFacturaDetalle['ValorImpto']==0)
              {
                 $xSubTotalBase0=$xSubTotalBase0+$regFacturaDetalle['SubTotalLinea'];
              }
              else
              {
                 $xSubTotalBaseIva=$xSubTotalBaseIva+$regFacturaDetalle['SubTotalLinea'];
                 $xValorIvaBaseIva=$xSubTotalBaseIva*($xTarifaImpuesto/100);
              }
           }

              #-------------------------------------------------------------------------------------------------------
               $strFacturasXML.="     <totalImpuesto>\r";
               $strFacturasXML.="         <codigo>2</codigo>\r";
               $strFacturasXML.="         <codigoPorcentaje>0</codigoPorcentaje>\r";
               $strFacturasXML.="         <baseImponible>".round($xSubTotalBase0,2)."</baseImponible>\r";
               $strFacturasXML.="         <valor>0</valor>\r";
               $strFacturasXML.="     </totalImpuesto>\r"; 
               $strFacturasXML.="     <totalImpuesto>\r";     
               $strFacturasXML.="         <codigo>2</codigo>\r";
               $strFacturasXML.="         <codigoPorcentaje>2</codigoPorcentaje>\r";
               $strFacturasXML.="         <baseImponible>".round($xSubTotalBaseIva,2)."</baseImponible>\r";
               $strFacturasXML.="         <valor>".round($xValorIvaBaseIva,2)."</valor>\r";
               $strFacturasXML.="     </totalImpuesto>\r";
          
               $strFacturasXML.="   </totalConImpuestos>\r";
               $strFacturasXML.="   <propina>0</propina>\r";
               $strFacturasXML.="   <importeTotal>".round($regFacturasXML['Total'],2)."</importeTotal>\r";
               $strFacturasXML.="   <moneda>DOLAR</moneda>\r";
               $strFacturasXML.="   <pagos>\r"; 
           ####################################
           #   Detalle de formas de pago      #
           ####################################
           $sqlFormasPago   = "SELECT formapagofactura.IdFormaPago as IdFormaPago,formapagofactura.Valor as valorFormaPago ".
                              " FROM formapagofactura,movta where movta.IdMov = formapagofactura.IdMovta ".
                              " and movta.IdMov = $IdMov";
           $rsFormaPago     = mysqli_query($conexion,$sqlFormasPago);
           while($regFormasPago= mysqli_fetch_array($rsFormaPago))
           {
              switch($regFormasPago['IdFormaPago']) 
              {
                case 1:  #---Efectivo
                  $xCodigoFormaPago="01";
                  break;
                case 3:  #---t Debito
                  $xCodigoFormaPago="16";
                  break;
                case 4:  #---tc
                  $xCodigoFormaPago="19";
                  break;
              }
              $strFacturasXML.="      <pago>\r";    
              $strFacturasXML.="         <formaPago>$xCodigoFormaPago</formaPago>\r";
              $strFacturasXML.="         <total>".round($regFormasPago['valorFormaPago'],2)."</total>\r";
              $strFacturasXML.="      </pago>\r";                        
           }
           $strFacturasXML.="   </pagos>\r";
           $strFacturasXML.="</infoFactura>\r";
           #------------------------------------------------------------------------------------------------#
           #                  Generacion del detalle                                                        #
           #------------------------------------------------------------------------------------------------#
           $strSQLDetalle       = "select movref.IdReferencia as codigoPrincipal,CargaIva as cargaIva,
           								  referencias.Isbn as codigoAuxiliar,DescripcionReferencia as descripcion,
           								  Cantidad as cantidad,Precio as precioUnitario, Precio as precioSinSusidio, 
           								  movref.Descuento as descuento,ValorImpto as valorImpuesto,movref.Descuento as descuento,
           								  (TotalBruto-movref.Descuento) as precioTotalSinImpuesto  from movref, referencias 
           						   where IdMov = $IdMov and movref.IdReferencia= referencias.IdReferencia";
           $rsDetalle            =   mysqli_query($conexion,$strSQLDetalle);
           $strFacturasXML      .=   "<detalles>\r";
           $xBaseImponible       =   0;
           $xValorImpuesto       =   0;
           $xcodigoPorcentajeDet =   '';

           while($regDetalleXML  =   mysqli_fetch_array($rsDetalle))
           {
           	    if($regDetalleXML['cargaIva']=="S")
           	    {
           	    	$xBaseImponible 		= $regDetalleXML['precioTotalSinImpuesto'];
           	    	$xValorImpuesto 		= $regDetalleXML['valorImpuesto'];
           	    	$xcodigoPorcentajeDet 	= '2';
                  $xTarifaImpuesto    = $xTarifaImpuesto;
           	    }
           	    else
           	    {
           	        $xBaseImponible 		  = $regDetalleXML['precioTotalSinImpuesto'];	
           	        $xValorImpuesto 		  = 0;
           	        $xcodigoPorcentajeDet ='0';
                    $xTarifaImpuesto      = 0;
           	    }
 		        $strFacturasXML.="    <detalle>\r";
                    $strFacturasXML.="    <codigoPrincipal>".$regDetalleXML['codigoPrincipal']."</codigoPrincipal>\r";
                    $strFacturasXML.="    <codigoAuxiliar>".$regDetalleXML['codigoAuxiliar']."</codigoAuxiliar>\r";
                    $strFacturasXML.="    <descripcion>".utf8_encode($regDetalleXML['descripcion'])."</descripcion>\r";
                    $strFacturasXML.="    <cantidad>".$regDetalleXML['cantidad']."</cantidad>\r";
                    $strFacturasXML.="    <precioUnitario>".round($regDetalleXML['precioUnitario'],2)."</precioUnitario>\r";
                    $strFacturasXML.="    <precioSinSubsidio>0</precioSinSubsidio>\r";
                    $strFacturasXML.="    <descuento>".round($regDetalleXML['descuento'],2)."</descuento>\r";
                    $strFacturasXML.="    <precioTotalSinImpuesto>".round($regDetalleXML['precioTotalSinImpuesto'],2)."</precioTotalSinImpuesto>\r";
                    $strFacturasXML.="    <impuestos>\r";
                        $strFacturasXML.="        <impuesto>\r";
                            $strFacturasXML.="        <codigo>2</codigo>\r";       
                            $strFacturasXML.="        <codigoPorcentaje>".$xcodigoPorcentajeDet."</codigoPorcentaje>\r";
                            $strFacturasXML.="        <tarifa>".round($xTarifaImpuesto,2)."</tarifa>\r";
                            $strFacturasXML.="        <baseImponible>".round($xBaseImponible,2)."</baseImponible>\r";
                            $strFacturasXML.="        <valor>".round($xValorImpuesto,2)."</valor>\r";
                        $strFacturasXML.="        </impuesto>\r";
                    $strFacturasXML.="    </impuestos>\r";
                $strFacturasXML.="    </detalle>\r";
           }
      
           $strFacturasXML.="</detalles>\r";
           $strFacturasXML.="<infoAdicional>\r";
           $strFacturasXML.="     <campoAdicional nombre=\"Email:\">".$eMail."</campoAdicional>\r";
           $strFacturasXML.="</infoAdicional>\r";
           $strFacturasXML.="</factura>\r";
        
           $archivoXML  = $strXML.$strFacturasXML;
           $puroarchivo = 	"01-01-00".$IdMov.".XML";
           $rutaArchivo = "../xml/01-01-00".$IdMov.".XML";
           $archivo = fopen($rutaArchivo, "w");
           fwrite($archivo,$archivoXML);
           fclose($archivo);	
           $archivoXML="";
           $strFacturasXML="";
           $archivo=null;
           $contadorArchivos++;
           //$array_archivos[$contadorArchivos-1]=$puroarchivo; //$arr [$contadorArchivos-1]=$rutaArchivo;
           //$array_archivos
        }
           /*for($j=0;$j<$contadorArchivos;$j++)
           {
              //echo $array_archivos[$j];
              header("Content-disposition: attachment; filename=".$array_archivos[$j]);
              header("Content-type: MIME");
              readfile($array_archivos[$j]);   

           }

         // header('Location:Mensajes.php?mensaje=XML generados exitosamente&Destino=../inicio/menu.php' );*/


 }



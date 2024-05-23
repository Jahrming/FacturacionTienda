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
        $xFechaInicio = $_POST['FechaInicio'];
        $xFechaFin    = $_POST['FechaFin'];

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
                    <title>SISTEMA POS ALT-64 | CUADRE DE CAJA </title>
                    <link rel='stylesheet' href='../css/estilos.css' >
                    <link rel='stylesheet' href='../css/bootstrap.min.css'>
                    <link rel='stylesheet' href='../js/alertifyjs/css/alertify.css'>
                    <link href='../css_temas/helper.css' rel='stylesheet'>
                    <link href='../css_temas/style.css' rel='stylesheet'>
                    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
                    <style>
                      @page { margin: 180px 50px; }
                              #header { position: fixed; left: 0px; top: -200px; right: 0px;
                               height: 200px; text-align: center; }
                              #footer { position: fixed; left: 0px; bottom: -180px; right: 0px; 
                               height: 50px; text-align: center;}
                      #footer .page:after { content: counter(page, upper-arial); }
                      table {
                            font-family: 'Poppins', sans-serif;
                            border-collapse: collapse;
                            width: 100%;
                            font-size: 12px;
                            }
                    </style>       
            </head>
            <body>
                <style>
                    body {  font-family: 'Poppins', sans-serif;
                            border-collapse: collapse;
                            width: 100%;
                            font-size: 12px;}
                </style>
                <div id='header'>
                    <br>
                    <center>
                        <br><br>
                        <font size=4><b>".$xNombreEmpresa."</b></font><br>
                        <font size=4><b>".$xDireccionEmpresa."</b></font><br>
                        <br>
                    </center>
                        <font size=4><b>REPORTE DE VENTAS POR CLIENTES</b></font><br>
                        <br>
                        <font size=4><b>Fecha Desde:".$xFechaInicio."</b></font><br>
                        <font size=4><b>Fecha Hasta:".$xFechaFin."</b></font><br>
                    <center>Detalle Reporte </center>
                    <br>
                    <table width='100%' cellspacing='0'  style=\"font-family:Arial,'Arial', serif;\">
                        <tr>
                          <td bgcolor='#FFFF00' style='color: #0080FF' width='40%' colspan='7'><b>Colegio</b></td>
                        </tr><tr>
                          <td bgcolor='#FFFF00' style='color: #0080FF' width='40%'  colspan='2'><b><center>Libro</center></b></td>
                          <td bgcolor='#FFFF00' style='color: #0080FF' width='12%'><b><center>Cantidad</center></b></td>
                          <td bgcolor='#FFFF00' style='color: #0080FF' width='12%'><b><center>Subtotal</center></b></td>
                          <td bgcolor='#FFFF00' style='color: #0080FF' width='12%'><b><center>Descuento</center></b></td>
                          <td bgcolor='#FFFF00' style='color: #0080FF' width='12%'><b><center>Iva</center></b></td>
                          <td bgcolor='#FFFF00' style='color: #0080FF' width='12%'><b><center>Total</center></b></td>
                        </tr>";
                     $xCantidades=0;
                     $xSubtotal=0;
                     $xDescuento=0;
                     $xImpuesto=0;
                     $xTotal=0;
                     $xTotalLibrosxCliente=0;
                     $xSubTotalxCliente=0;
                     $xTotalDescuentoxCliente=0;
                     $xTotalImpuestoxCliente=0;
                     $xTotalxCliente=0;                     
                     #----- Detalle Reporte --------------------------------
                     #----Primer imprimimos el nombre del colegio ----------
                     $strSQlColegio="SELECT movta.IdEmpresa as IdEmpresa,colegios.DescripcionColegio 
                                       FROM movta, movref, colegios, referencias
                                      WHERE Fecha >='$xFechaInicio' AND Fecha <='$xFechaFin' 
                                        AND movta.idmov = movref.idmov 
                                        AND movta.idempresa = colegios.idcolegio 
                                        AND movref.IdReferencia = referencias.IdReferencia
                                   GROUP BY 1 ";


                              $rs =  mysqli_query($conexion,$strSQlColegio);
                              while ($reg= mysqli_fetch_array($rs) ) 
                              {
                                $CodigoHtml.="<tr><td colspan='7'>".$reg['DescripcionColegio']."</td></tr>";
                                $strSQlDetalle="SELECT DescripcionReferencia,SUM(movref.Cantidad) as Cantidad, 
                                                    SUM(movref.TotalBruto) AS Subtotal, 
                                                    SUM(movref.Descuento) AS Descuento, SUM(movref.ValorImpto) AS Impuesto, 
                                                    IFNULL(SUM(movref.TotalLinea),0) AS Total FROM movta, movref, referencias
                                            WHERE   Fecha >='$xFechaInicio' AND Fecha <='$xFechaFin' 
                                            AND     movta.IdMov = movref.IdMov 
                                            AND     movta.IdEmpresa = ".$reg['IdEmpresa']." 
                                            AND     movref.IdReferencia = referencias.IdReferencia
                                            GROUP BY 1 ORDER BY 2 ";
                                $rsDetalle =  mysqli_query($conexion,$strSQlDetalle);
                                while ($regDetalle= mysqli_fetch_array($rsDetalle) ) 
                                {
                                    $CodigoHtml.="<tr>
                                      <td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".utf8_encode($regDetalle['DescripcionReferencia'])."</td>
                                      <td align='right'>".number_format($regDetalle['Cantidad'],0)."</td>
                                      <td align='right'>".number_format($regDetalle['Subtotal'],2)."</td>
                                      <td align='right'>".number_format($regDetalle['Descuento'],2)."</td>
                                      <td align='right'>".number_format($regDetalle['Impuesto'],2)."</td>
                                      <td align='right'>".number_format($regDetalle['Total'],2)."</td>
                                          </tr>";
                                      $xTotalLibrosxCliente=$xTotalLibrosxCliente+$regDetalle['Cantidad'];
                                      $xSubTotalxCliente=$xSubTotalxCliente+$regDetalle['Subtotal'];
                                      $xTotalDescuentoxCliente=$xTotalDescuentoxCliente+$regDetalle['Descuento'];
                                      $xTotalImpuestoxCliente=$xTotalImpuestoxCliente+$regDetalle['Impuesto'];
                                      $xTotalxCliente=$xTotalxCliente + $regDetalle['Total'];      

                                      $xCantidades=$xCantidades+$regDetalle['Cantidad'];
                                      $xSubtotal=$xSubtotal+$regDetalle['Subtotal'];
                                      $xDescuento=$xDescuento+$regDetalle['Descuento'];
                                      $xImpuesto=$xImpuesto+$regDetalle['Impuesto'];
                                      $xTotal=$xTotal+$regDetalle['Total'];
                                }

                              
                              $CodigoHtml.="<tr><td></td></tr>";
                              $CodigoHtml.="<tr><td></td></tr>";
                              $CodigoHtml.="<tr><td colspan='2'>Total ".$reg['DescripcionColegio']."</td>
                                    <td align='right'>".number_format($xTotalLibrosxCliente,0)."</td>
                                    <td align='right'>".number_format($xSubTotalxCliente,2)."</td>
                                    <td align='right'>".number_format($xTotalDescuentoxCliente,2)."</td>
                                    <td align='right'>".number_format($xTotalImpuestoxCliente,2)."</td>
                                    <td colspan='2'  align='right'>".number_format($xTotalxCliente,2)."</td></tr>";
                                      $xTotalLibrosxCliente=0;
                                      $xSubTotalxCliente=0;
                                      $xTotalDescuentoxCliente=0;
                                      $xTotalImpuestoxCliente=0;
                                      $xTotalxCliente=0;    
                                      $CodigoHtml.="<tr><td></td></tr>";
                                      $CodigoHtml.="<tr><td></td></tr>";
                                      $CodigoHtml.="<tr><td></td></tr>";
                                      $CodigoHtml.="<tr><td></td></tr>";
                                      $CodigoHtml.="<tr><td></td></tr>";                                        
                              }

                              $CodigoHtml.="<tr><td></td></tr>";
                              $CodigoHtml.="<tr><td></td></tr>";
                              $CodigoHtml.="<tr><td></td></tr>";
                              $CodigoHtml.="<tr><td></td></tr>";
                              $CodigoHtml.="<tr><td></td></tr>";
                              $CodigoHtml.="<tr><td></td></tr>";

                              $CodigoHtml.="<tr><td colspan='2'>Totales </td>
                                    <td align='right'>".number_format($xCantidades,0)."</td>
                                    <td align='right'>".number_format($xSubtotal,2)."</td>
                                    <td align='right'>".number_format($xDescuento,2)."</td>
                                    <td align='right'>".number_format($xImpuesto,2)."</td>
                                    <td colspan='2'  align='right'>".number_format($xTotal,2)."</td></tr>";


                            $CodigoHtml.="</table>";
                            $CodigoHtml.="<br>";
                  $CodigoHtml.="</div>";                         
                  $CodigoHtml.="</body>";
                  $CodigoHtml.="</html>";   


}

    require_once("dompdf/autoload.inc.php");
    use Dompdf\Dompdf;
    $documentopdf= new DOMPDF();
    $documentopdf->set_option('defaultFont', 'Arial'); 
    $documentopdf->setPaper('A4','PORTRAIT');
    //$documentopdf->loadHtml($purocodigo);
    $documentopdf->loadHtml(ob_get_clean());
    $documentopdf->loadHtml($CodigoHtml);
      //    $dompdf->load_html(utf8_encode($purocodigo));
        //  ini_set("memory_limit","128M");
          $documentopdf->render();
       //   $documentopdf->stream("Li.pdf",array("Attachment"=>0));
    $documentopdf->stream("ReporteVentasxClientes_".$xFechaInicio."_".$xFechaFin.".pdf",array("Attachment"=>false)); 


   
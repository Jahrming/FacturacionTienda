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
                    <title>SISTEMA POS ALT-64 | REPORTE DE VENTAS POR FECHAS</title>
                    <style>
                    @page { margin: 180px 50px; }
                            #header { position: fixed; left: 0px; top: -200px; right: 0px; height: 200px; text-align: center; }
                            #footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 50px; text-align: center;}
                    #footer .page:after { content: counter(page, upper-arial); }
                    </style>
                    <link rel='stylesheet' href='../css/estilos.css' >
                    <link rel='stylesheet' href='../css/bootstrap.min.css'>
                    <link rel='stylesheet' href='../js/alertifyjs/css/alertify.css'>
                    <link href='../css_temas/helper.css' rel='stylesheet'>
                    <link href='../css_temas/style.css' rel='stylesheet'>
                    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>                    
            </head>
            <body>
                <div id='header'>
                    <br>
                    <center>
                        <br>
                        <br>
                       <style='font-family:Poppins,Sans-serif;font-size:16px';color:#0080FF;background-color:#FFBF00;border:none'><b>REPORTE DE VENTAS POR FECHAS</b></font><br>
                       <style='font-family:Poppins,sans-serif;font-size:16px';color:#0080FF;background-color:#FFBF00;border:none'><b>".$xNombreEmpresa."</b></font><br>
                        <style='font-family: Poppins, sans-serif;font-size:16px';color:#0080FF;background-color:#FFBF00;border:none'><b>".$xDireccionEmpresa."</b></font><br>
                    </center>
                    <center>
                        <br>
                        <font size=4><b>Fecha Desde:".$xFechaInicio."</b></font><br>
                        <font size=4><b>Fecha Hasta:".$xFechaFin."</b></font><br>
                    </center>
                        <center>Detalle Reporte </center>
                        <br>
                    <table width='100%' cellspacing='0'>
                        <tr>
                          <td bgcolor='#FFFF00' style='color: #0080FF' width='16%'><b><center>Fecha</center></b></td>
                          <td bgcolor='#FFFF00' style='color: #0080FF' width='18%'><b><center>Subtotal</center></b></td>
                          <td bgcolor='#FFFF00' style='color: #0080FF' width='18%'><b><center>Descuento</center></b></td>
                          <td bgcolor='#FFFF00' style='color: #0080FF' width='18%'><b><center>Iva</center></b></td>
                          <td bgcolor='#FFFF00' style='color: #0080FF' width='18%'><b><center>Total</center></b></td>
                        </tr>";
                     #----- Detalle Reporte --------------------------------
                    $strSQl="SELECT Fecha, SUM(SubTotal) as Subtotal, SUM(Descuento) as Descuento, SUM(Impuesto) as Impuesto, IFNULL(SUM(Total),0) as Total FROM movta ".
                            " WHERE Fecha >='$xFechaInicio' AND Fecha <='$xFechaFin' GROUP BY Fecha "; 

                    $rs =  mysqli_query($conexion,$strSQl);
                    while ($reg= mysqli_fetch_array($rs) ) 
                    {
                        $CodigoHtml.="<tr>
                              <td ><b>".$reg['Fecha']."</b></td>
                              <td align='right'>".$reg['Subtotal']."</td>
                              <td align='right'>".$reg['Descuento']."</td>
                              <td align='right'><b>".$reg['Impuesto']."</td>
                              <td align='right'><b>".$reg['Total']."</td>
                              </tr>";
                    }


                  $CodigoHtml.="</table>";
                  $CodigoHtml.="<br>";

                  $CodigoHtml.="</div>";                         
                  $CodigoHtml.="</body>";
                  $CodigoHtml.="</html>";   


}

        require_once("dompdf/autoload.inc.php");
        use Dompdf\Dompdf;
    $documentopdf= new DOMPDF();
    $documentopdf->setPaper('A4','PORTRAIT');
    //$documentopdf->loadHtml($purocodigo);
    $documentopdf->loadHtml(ob_get_clean());
    $documentopdf->loadHtml($CodigoHtml);
      //    $dompdf->load_html(utf8_encode($purocodigo));
        //  ini_set("memory_limit","128M");
          $documentopdf->render();
       //   $documentopdf->stream("Li.pdf",array("Attachment"=>0));
    $documentopdf->stream("ComprobantexIdMov.pdf",array("Attachment"=>false)); 


   
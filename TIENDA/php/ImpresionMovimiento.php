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
        $xIdMovimiento  = $_REQUEST['IdMovimiento'];
        #------ Informacion del sistema  ----------------
        $StrSql="select * from systemprofile";
        $ResultSet= mysqli_query($conexion,$StrSql);
        $regProfile= mysqli_fetch_assoc($ResultSet);
        $xRucEmpresa      = $regProfile['RUC'];
        $xNombreEmpresa   = $regProfile['NombreEmpresa'];
        $xDireccionEmpresa= $regProfile['Direccion'];
        $xTelefonoEmpresa = $regProfile['Telefonos'];
        #---- Datos cabecera ------------------------------
        $StrSql="select * from movimientosinventarios where  IdMovInventario=".$xIdMovimiento;
        $ResultSet= mysqli_query($conexion,$StrSql);
        $regMovimiento= mysqli_fetch_assoc($ResultSet);
        $xFecha                  = $regMovimiento['FechaMovimiento'];
        $xIdTipoMovimiento       = $regMovimiento['IdCodigoTraslado'];
        $xIdAlmacen              = $regMovimiento['IdAlmacen'];
        $xIdBodegaOrigen         = $regMovimiento['IdBodegaOrigen'];
        $xIdBodegaDestino        = $regMovimiento['IdBodegaDestino'];
        $xUsuario                = $regMovimiento['aud_usuario_proc'];
        $xAuditFecha             = $regMovimiento['aud_fecha_proc'];
        $xObservacion            = $regMovimiento['Observacion'];
        #------- Informacion de las tablas  ------------------
        $sqlTraslados="select * from traslados where IdCodigoTraslado='$xIdTipoMovimiento'";
        $ResultSetTraslados= mysqli_query($conexion,$sqlTraslados);
        $regTraslados  = mysqli_fetch_assoc($ResultSetTraslados);
        $xNombreTipoTraslados  = $regTraslados['DescripcionTraslado'];
        #------ Informacion de las bodegas  ----------------
        $sqlBodegasO="select * from  bodegas where IdBodega =$xIdBodegaOrigen";
        $ResultSetBodegaO= mysqli_query($conexion,$sqlBodegasO);
        $regBodegaO  = mysqli_fetch_assoc($ResultSetBodegaO);
        $xNombreBodegaO  = $regBodegaO['DescripcionBodega'];
        $sqlBodegasD="select * from  bodegas where IdBodega =$xIdBodegaDestino";
        $ResultSetBodegaD= mysqli_query($conexion,$sqlBodegasD);
        $regBodegaD  = mysqli_fetch_assoc($ResultSetBodegaD);
        $xNombreBodegaD  = $regBodegaD['DescripcionBodega'];        

        $CodigoHtml="";
        $CodigoHtml.="            
        <!DOCTYPE html>
        <html>
            <head>

                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                    <title>SISTEMA POS ALT-64 | ".$xNombreTipoTraslados." </title>
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
                    <center style='font-size: 10px;color:#0080FF;font-weight:bold;'>
                        <br>
                        <br>
                        <font size=4><b>$xNombreTipoTraslados</b></font><br>
                        <font size=4><b>".$xNombreEmpresa."</b></font><br>
                        <font size=4><b>".$xDireccionEmpresa."</b></font><br>
                        <br>
                    </center>

                        <center style='font-size: 10px;'>Detalle de Items </center>
                        <br>
                    <table width='100%' cellspacing='0' style='font-size: 11px;'>
                        <tr>
                            <td><b>Código</b></td>
                            <td><b>Descripción</b></td>
                            <td><b>Cant.</b></td>
                        </tr>";
                             #----- Detalle  --------------------------------
                             $StrSql = "SELECT * FROM movimientosinventariosdetalle WHERE IdMovInventario = $xIdMovimiento";
                             $rs     = mysqli_query($conexion,$StrSql);
                             while($regDetalle= mysqli_fetch_array($rs))
                             {
                                $xSecuencial    = $regDetalle['Secuencial'];
                                $xIdReferencia  = $regDetalle['IdReferencia'];
                                $xCantidad      = $regDetalle['Cantidad'];
                                $StrSql = "SELECT DescripcionReferencia FROM referencias WHERE IdReferencia = $xIdReferencia";
                                $rsRefe             = mysqli_query($conexion,$StrSql);
                                $regReferencia      = mysqli_fetch_assoc($rsRefe);
                                $xDescripcionItem   = $regReferencia['DescripcionReferencia'];
                                $CodigoHtml.="<tr><td>$xIdReferencia</td><td>$xDescripcionItem</td><td>$xCantidad</td><td></tr>";
                             }
                             $CodigoHtml.="</table>";
                             $CodigoHtml.="<br>";
                             $CodigoHtml.="<table width='100%' cellspacing='0' style='font-size: 11px;'>";
                             $CodigoHtml.="<tr><td colspan='4'>Fecha:  </td><td>$xFecha  </td></tr>";
                             $CodigoHtml.="<tr><td colspan='4'>Usuario: </td><td>$v_usuario</td></tr>";
                             $CodigoHtml.="<tr><td colspan='4'>No. Movimiento:  </td><td>$xIdMovimiento</td></tr>"; 
                             $CodigoHtml.="<tr><td colspan='4'>Bodega Origen:   </td><td>$xNombreBodegaO     </td></tr>";
                             $CodigoHtml.="<tr><td colspan='4'>Bodega Destino:  </td><td>$xNombreBodegaD     </td></tr>"; 

                             $CodigoHtml.="</table>";
                             $CodigoHtml.="<br>Observación: ".substr($xObservacion, 0,80);
                             $CodigoHtml.="<br>".substr($xObservacion, 81,120);
                             
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
                             $documentopdf->stream("ComprobanteMovInv.pdf");
   




   
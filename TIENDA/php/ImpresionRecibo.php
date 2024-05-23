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
        $v_IdPago=$_REQUEST['IdPago'];
        $StrSql="select * from pagos where  IdPago=".$v_IdPago;
        $ResultSet= mysqli_query($conexion,$StrSql);
        $regPago= mysqli_fetch_assoc($ResultSet);
        $v_IdRegistroMatricula = $regPago['IdRegistroMatricula'];
        $v_IdRepresentante      = $regPago['IdRepresentante'];
        $v_FechaPago            = $regPago['FechaPago'];
        $v_TotalBruto           = $regPago['TotalBruto'];
        $v_Descuento            = $regPago['Descuento'];
        $v_Iva                  = $regPago['Iva'];
        $TotalPago              = $regPago['TotalPago'];

        $StrSql="select * from registromatricula where  idRegistroMatricula=$v_IdRegistroMatricula";
        $ResultSet= mysqli_query($conexion,$StrSql);
        $regMat= mysqli_fetch_assoc($ResultSet);

        $v_IdAlumno  = $regMat['IdAlumno'];
        $v_IdCurso   = $regMat['IdCurso'];

        $StrSql="select * from alumnos where IdAlumno =$v_IdAlumno";
        $ResultSet= mysqli_query($conexion,$StrSql);
        $regAlumno= mysqli_fetch_assoc($ResultSet);

        $v_Nombres = $regAlumno['Apellidos'].' '.$regAlumno['Nombres'];

        $StrSql="select * from representantes where IdRepresentante =$v_IdRepresentante";
        $ResultSet= mysqli_query($conexion,$StrSql);
        $regRepre= mysqli_fetch_assoc($ResultSet);

        $v_NombresRepresentante = $regRepre['apellidos'].' '.$regRepre['nombres'];


        $StrSql="select * from cursos where IdCurso =$v_IdCurso";
        $ResultSet= mysqli_query($conexion,$StrSql);
        $regCurso = mysqli_fetch_assoc($ResultSet);
        $v_IdNivel  = $regCurso['IdNivel'];
        $v_IdParalelo = $regCurso['IdParalelo'];
        $v_IdFormacion = $regCurso['IdFormacion'];

        $StrSql="select * from formaciones where IdFormacion =$v_IdFormacion";
        $ResultSet= mysqli_query($conexion,$StrSql);
        $regFormacion = mysqli_fetch_assoc($ResultSet);
        $v_DescripcionFormacion  = $regFormacion['DescripcionFormacion'];
        
        $StrSql="select * from niveles where IdNivel =$v_IdNivel";
        $ResultSet= mysqli_query($conexion,$StrSql);
        $regNivel = mysqli_fetch_assoc($ResultSet);
        $v_DescNivel  = $regNivel['NivelDescripcion'];



        $CodigoHtml='';
        $CodigoHtml.="            
        <!DOCTYPE html>
        <html>
            <head>

                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                    <title>SISTEMA COLEGIO | REGISTRO DE PAGOS </title>
                    <style>
                    @page { margin: 180px 50px; }
                            #header { position: fixed; left: 0px; top: -200px; right: 0px; height: 200px; text-align: center; }
                            #footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 50px; text-align: center;}
                    #footer .page:after { content: counter(page, upper-arial); }
                    </style>
                    
            </head>
            <body>
                    <div id='header'>
                            <br>
                            <center>
                                    <BR>
                                    <BR>
                                    <font size=4><b>UNIDAD EDUCATIVA PILAR ROOS</b></font><br>
                                    <font size=4><b>RECIBO DE PAGO</b></font><br>
                                    <BR>

                            </center>
                            <table width='100%' cellspacing='0'>
                                <tr><td><b>Número de Comprobante: </b></td><td>".$v_IdPago."</td></tr>
                                <tr><td><b>Representante: </b></td><td>".$v_NombresRepresentante."</td></tr>
                                <tr><td><b>Fecha Pago:    </b></td><td>".$v_FechaPago."</td></tr>
                                <tr><td><b>Estudiante:    </b></td><td>".$v_Nombres."</td></tr>
                                <tr><td><b>Curso:         </b></td><td>[".$v_IdCurso."]-".$v_DescNivel.' '.
                                                         $v_DescripcionFormacion.' '.$v_IdParalelo."</td></tr>
                            </table>
                            <br> 
                            <font size=2>
                            <table border='0' width='100%' cellspacing='0' cellpadding='0'>

                            </div>
                            <div id='footer'>
                            <p class='page' >Detalle de Pagos</p>
                            </div>
                            <div id='content'>
                                <table border='0' width='100%' cellspacing='0' cellpadding='0'><tr>
                                    <td bgcolor='#01DF01' style='color: #8A0886'><b><center>TipoObligacion</center></b></td>
                                    <td bgcolor='#01DF01' style='color: #8A0886'><b><center>Secuencial Obligación</center></b></td>
                                    <td bgcolor='#01DF01' style='color: #8A0886'><b><center>Descripción Obligación</center></b></td>
                                    <td bgcolor='#01DF01' style='color: #8A0886'><b><center>Valor Pagado</center></b></td></tr>";

                                        $StrSql = " SELECT registroobligaciones.DescripcionObligacion 
                                                        as DescripcionObligacion, registroobligaciones.SecuencialObligacion
                                                         as numero,
                                                         registroobligaciones.DescripcionObligacion as NombreObligacion, 
                                                         pagosdetalle.Valor as valor 
                                                         FROM pagos, pagosdetalle ,registroobligaciones,tipoobligacion 
                                                         WHERE pagos.IdPago = pagosdetalle.IdPago
                                                         AND pagos.IdPago = $v_IdPago 
                                                         AND pagos.IdRegistroMatricula = registroobligaciones.IdRegistroMatricula 
                                                         AND registroobligaciones.SecuencialObligacion = pagosdetalle.SecuencialObligacion 
                                                        AND tipoobligacion.IdTipoObligacion = registroobligaciones.IdTipoObligacion  "; 
                                        
                                        $rs = mysqli_query($conexion,$StrSql);
                                        $Total=0;
                                        while($regPagos = mysqli_fetch_array($rs))
                                        {
                                            $CodigoHtml.= "<tr><td>".$regPagos['DescripcionObligacion']."</td><td>".$regPagos['numero'].
                                                "</td><td>".$regPagos['NombreObligacion']."</td><td>".$regPagos['valor']."</td></tr>";
                                            $Total=$Total+$regPagos['valor'];

                                        }
                                    $CodigoHtml.="<td colspan='3' align='right'><b>Total</b></td><td align='right'>".$Total."</td></tr>";  
                                    $CodigoHtml.=" 
                                 </table>    
                            </div>
                        </div>
                </body>
        </html>";    
    }

    //echo $CodigoHtml;

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
    $documentopdf->stream("RegistroPago.pdf",array("Attachment"=>false)); 


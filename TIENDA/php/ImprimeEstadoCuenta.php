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
        $v_IdRegistroMatricula=$_REQUEST['IdRegistroMatricula'];
      

        $StrSql="select * from registromatricula where  idRegistroMatricula=$v_IdRegistroMatricula";
        $ResultSet= mysqli_query($conexion,$StrSql);
        $regMat= mysqli_fetch_assoc($ResultSet);
        $v_IdAlumno  = $regMat['IdAlumno'];
        $v_IdCurso   = $regMat['IdCurso'];
        $v_IdRepresentante = $regMat['IdRepresentante'];


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
                    <title>SISTEMA COLEGIO | ESTADO DE CUENTA </title>
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
                                    <font size=4><b>ESTADO DE CUENTA</b></font><br>
                                    <BR>

                            </center>
                            <table width='100%' cellspacing='0'>
                                <tr><td><b>Número de Matricula: </b></td><td>".$v_IdRegistroMatricula."</td></tr>
                                <tr><td><b>Representante: </b></td><td>".$v_NombresRepresentante."</td></tr>
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
                                    <td><b><center>#</center></b></td>
                                    <td><b><center>Tipo</center></b></td>
                                    <td><b><center>Sec.</center></b></td>
                                    <td><b><center>Obligación</center></b></td>
                                    <td><b><center>Valor</center></b></td>
                                    <td><b><center>Pagado</center></b></td>
                                    <td><b><center>Pendiente</center></b></td>
                                    <td><b><center>Fecha Pago</center></b></td>";

                                        $Sql="select c.DescripcionTipoObligacion as NombreObligacion,
                                                     b.SecuencialObligacion as Secuencia,
                                                     b.DescripcionObligacion as DescripcionObligacion,
                                                     b.Valor as valor,
                                                     b.ValorPagado as valorPagado,
                                                     b.ValorPendiente as valorPendiente,
                                                     b.FechaRegistroPago as FechaPago
                                                from registromatricula a, registroobligaciones b, tipoobligacion c 
                                               where a.idRegistroMatricula = b.IdRegistroMatricula 
                                                 and a.IdRepresentante= $v_IdRepresentante
                                                 and a.IdAlumno   = $v_IdAlumno
                                                 and b.IdTipoObligacion = c.IdTipoObligacion ";
                                        $Total=0;
                                        $rs = mysqli_query($conexion,$Sql);    
                                        $contador=0;   
                                        $totalPagado=0;
                                        $totalPendiente=0;                                 
                                        while($regObligaciones = mysqli_fetch_array($rs))
                                        {
                                            if($regObligaciones['valorPagado']>0){
                                                $totalPagado=$totalPagado+$regObligaciones['valorPagado'];
                                            }
                                            else
                                            {
                                                $totalPendiente=$totalPendiente+$regObligaciones['valor'];
                                            }
                                            if($regObligaciones['FechaPago']==null)
                                            {
                                                $fechaPago="No registra";
                                            }
                                            else
                                            {
                                                $fechaPago=$regObligaciones['FechaPago'];
                                            }
                                            $contador++;
                                            $v_valor=0;
                                            $v_vpagado=0;
                                            $v_vpendiente=0;

                                            if($regObligaciones['valorPagado']==0){$v_vpagado=0;}else{$v_vpagado=$regObligaciones['valorPagado'];}
                                            if($regObligaciones['valorPendiente']==0){$v_vpendiente=0;}else{$v_vpendiente=$regObligaciones['valorPendiente'];}
                                            $CodigoHtml.="<tr><td>".$contador."</td>".    
                                                "<td>".$regObligaciones['NombreObligacion']."</td>".
                                                "<td>".$regObligaciones['Secuencia']."</td>".
                                                "<td>".$regObligaciones['DescripcionObligacion']."</td>".
                                                "<td>".$regObligaciones['valor']."</td>".
                                                "<td>".$v_vpagado."</td>".
                                                "<td>".$v_vpendiente."</td>".
                                                "<td>".$fechaPago."</td></tr>";
                                        }
                                        $CodigoHtml.="<tr><td colspan='7' align='right' style='font-size: 16px;'>Pagado    : </td><td style='font-size: 16px;background-color:#58FA82'>".$totalPagado."</td></tr>";
                                        $CodigoHtml.="<tr><td colspan='7' align='right' style='font-size: 16px;'>Pendiente : </td><td style='font-size: 16px;background-color:#FA5858'>".$totalPendiente."</td></tr>";
                                 $CodigoHtml.="</table>";
                            $CodigoHtml.="</div>";
                        $CodigoHtml.="</div>";
                $CodigoHtml.="</body>";
        $CodigoHtml.="</html>" ;  
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
    $documentopdf->stream("RegistroPago.pdf",array("Attachment"=>false)); 
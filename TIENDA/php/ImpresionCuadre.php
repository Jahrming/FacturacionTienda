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
        $xIdAsignacion 	= $_REQUEST['IdAsignacion'];
        $contadorFA = $_REQUEST['CantFa'];
        $contadorNC = $_REQUEST['CantNc'];
        $contadorNV = $_REQUEST['CantNv'];
        #---- Datos Factura ------------------------------
        $StrSql="select * from controlcaja a,admusuarios b,turnos c
                  where  a.IdAsignacion=".$xIdAsignacion.
                  " and  a.IdTurno     = c.IdTurno 
                    and  a.IdCajero    = b.IdUsuario ";

        $ResultSet        = mysqli_query($conexion,$StrSql);
        $regControlCaja   = mysqli_fetch_assoc($ResultSet);
        $xIdCaja 				  = $regControlCaja['IdCaja'];
        $xTurnoInicio    	= $regControlCaja['HoraInicio'];
        $xTurnoFin      	= $regControlCaja['HoraFin'];
        $xCajero   				= $regControlCaja['ApellidosUsuario'].' '.$regControlCaja['NombresUsuario'];
        $x_audit_usuario 	= $regControlCaja['aud_usuario_proc'];
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
                        <center>Cuadre de Caja</center>
                        <br>
                    <table width='100%' cellspacing='0'>
                        <tr>
                          	<td><b>Rubro</b></td>
                           	<td><b>Ingreso Manual</b></td>
                            <td><b>Sistema</b></td>
                        </tr>";
                            #-------------------------------
                            # Detalle del Cuadre -
                            #-------------------------------
                             $i=0;
                             $j=0;
                             $Supervisor="";
                             $arrRubros= array('','Efectivo','Tarjetas de Credito','Ventas a Crédito','Ventas a Cheque', 'Ventas otros','Total');
                             $StrSql = "SELECT * FROM cuadrescaja where IdAsignacion=$xIdAsignacion";       
                             $rs  	 = mysqli_query($conexion,$StrSql);
                             while($regCuadre= mysqli_fetch_array($rs))
                             {

                               if($regCuadre['IdTipoCuadre']=='M')
                               {
                                  $arrCuadreM=array('',$regCuadre['CuadreValorEfectivo'],$regCuadre['CuadreValorTC'],$regCuadre['CuadreValorCredito'],$regCuadre['CuadreValorCheques'],$regCuadre['CuadreValorOtros'],$regCuadre['Total'] );

                               }
                               if($regCuadre['IdTipoCuadre']=='S')
                               {
                                  $arrCuadreS=array('',$regCuadre['CuadreValorEfectivo'],$regCuadre['CuadreValorTC'],$regCuadre['CuadreValorCredito'],$regCuadre['CuadreValorCheques'],$regCuadre['CuadreValorOtros'],$regCuadre['Total'] );
                               }
                               $Supervisor=$regCuadre['aud_usuario_proc'];
                              }
                              $strResultado='';
                              for($i=1;$i<=6;$i++)
                              {
                                $CodigoHtml.="<tr><td>$arrRubros[$i]</td><td>$arrCuadreM[$i]</td><td>$arrCuadreS[$i]</td></tr>";
                              }
                              $xResultado=$arrCuadreS[6]-$arrCuadreM[6];
                              if($xResultado<0)
                              {
                                $strResultado="SOBRANTE";
                              }
                              else
                              {
                                if($xResultado=0)
                                {
                                  $strResultado="CUADRADO";
                                }
                                else
                                {
                                  $strResultado="FALNTANTE";
                                }                                   
                              }
                              $CodigoHtml.="<tr><td colspan=2>Cantidad Facturas:</td><td>".$CantFa."<td></tr>";
                              $CodigoHtml.="<tr><td colspan=2>Cantidad Notas de Venta:</td><td>".$CantNv."<td></tr>";
                              $CodigoHtml.="<tr><td colspan=2>Cantidad Notas de Crédito:</td><td>".$CantNc."<td></tr>";
                              $CodigoHtml.="<tr><td span 3>".$strResultado.': '.abs($xResultado)."</td></tr>";
                              $CodigoHtml.="<tr><td span 5><br></td></tr>";
                              $CodigoHtml.="<tr><td span 5><br></td></tr>";
                              $CodigoHtml.="<tr><td>Firma Supervisor</td><td>Firma Cajero</tr>";
                              $CodigoHtml.="<tr><td></td></tr>";
                              $CodigoHtml.="<tr><td></td></tr>";
                              $CodigoHtml.="<tr><td></td></tr>";
                              $CodigoHtml.="<tr><td>________________</td><td>______________</tr>";
                              $CodigoHtml.="<tr><td>$Supervisor</td></tr>";
                              $CodigoHtml.="</table>";
                              $CodigoHtml.="<br>";


                            $CodigoHtml.="</div>";                         
                            $CodigoHtml.="</body>";
                            $CodigoHtml.="</html>";   
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
    $documentopdf->stream("Cuadre".$xIdAsignacion.".pdf",array("Attachment"=>false)); 
   
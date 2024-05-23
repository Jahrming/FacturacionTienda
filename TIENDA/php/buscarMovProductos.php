
<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       header('Content-Type: text/html; charset=UTF-8');  
       include("Conexion.php");  
       $_usuario=$_SESSION['user'];
       $xIdAlmacen = $_SESSION['idalmacen'];

       $xFechaInicio = $_POST['fechaInicio'];
       $xItem        = $_POST['IdReferencia'];
       $xSaldoInicial=0;

      $strSQl="SELECT  histrx.IdDocReferencia AS docref,histrx.idcodigotraslado AS CodTrasl,
                       histrx.FechaTrx AS FechaTrx, traslados.DescripcionTraslado AS DescripcionTraslado, 
                       (select bodegas.DescripcionBodega from bodegas where bodegas.IdBodega =histrx.IdOrigen ) BodegaOrigen,
                       (select bodegas.DescripcionBodega from bodegas where bodegas.IdBodega =histrx.IdDestino ) BodegaDestino,
                       IFNULL((histrx.CantidadTrx*Signo),0) AS cantidad  
                 FROM  histrx, traslados, bodegas 
                WHERE  histrx.idreferencia = $xItem AND 
                       histrx.idcodigotraslado = traslados.idcodigotraslado AND 
                       histrx.IdAlmacen = $xIdAlmacen AND 
                       bodegas.IdBodega = $xIdAlmacen AND
                       histrx.FechaTrx > '$xFechaInicio' 
                       ORDER BY 3  ";

          $x_observacion = "";
          $rs =  mysqli_query($conexion,$strSQl);
          while ($reg= mysqli_fetch_assoc($rs) ) 
          {
            if($reg['CodTrasl']=='AN' || $reg['CodTrasl']=='II' || $reg['CodTrasl']=='AP' || $reg['CodTrasl']=='NE')
            {
              $strsql2= "select * from movimientosinventarios where IdMovInventario=".$reg['docref'].
                                  " and IdCodigoTraslado='".$reg['CodTrasl']."'";
                            
              $rs2=mysqli_query($conexion,$strsql2);
              $reg2= mysqli_fetch_assoc($rs2);
              
            }
              $arreglo['FechaTrx'][]              = $reg['FechaTrx'];
              $arreglo['DescripcionTraslado'][]   = $reg['DescripcionTraslado'];
              $arreglo['BodegaOrigen'][]          = $reg['BodegaOrigen'];
              $arreglo['BodegaDestino'][]         = $reg['BodegaDestino'];
              $arreglo['Observacion'][]           = $reg2['Observacion'];
              $arreglo['cantidad'][]              = $reg['cantidad'] ;
              $reg2['Observacion']='';
          }
          echo json_encode($arreglo);
      }



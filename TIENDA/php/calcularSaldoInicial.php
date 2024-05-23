
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

        $strSQl="SELECT IFNULL(SUM(CantidadTrx*Signo),0) as saldoInicial FROM histrx, traslados
                  WHERE histrx.idreferencia = $xItem
                    AND histrx.idcodigotraslado = traslados.idcodigotraslado
                    AND fechatrx <= '$xFechaInicio'
                    AND histrx.IdAlmacen = $xIdAlmacen ";

          $rs =  mysqli_query($conexion,$strSQl);
          while ($reg= mysqli_fetch_assoc($rs) ) 
          {
            $xSaldoInicial= $reg['saldoInicial'];       
          }

         echo $xSaldoInicial;

      }



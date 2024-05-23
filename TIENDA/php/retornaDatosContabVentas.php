


<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       include("Conexion.php");  
        $_usuario=$_SESSION['user'];
        $IdCierreDiario= $_POST['criterio'];
        #$x_anio = $_POST['Anio'];
        #$x_TipoCuenta = $_POST['TipoCuenta'];

        $html='';

       $SqlCierreDiario = "SELECT (SELECT DESCRIPCIONCUENTACONTABLE FROM CONPLANCUENTAS
                            WHERE CUENTACONTABLE IN (SELECT CUENTACONTABLEVENTASCONTADO FROM CONCIERRESDIARIOS)) AS NombreCuenta,
                                  VENTASCONTADO VALOR,CUENTACONTABLEVENTASCONTADO CUENTA,'D' Tipo
                            FROM CONCIERRESDIARIOS
                           WHERE IDCIERREDIARIO = $IdCierreDiario
                          UNION
                          SELECT  (SELECT DESCRIPCIONCUENTACONTABLE FROM CONPLANCUENTAS
                                    WHERE CUENTACONTABLE IN (SELECT CUENTACONTABLEVENTASCREDITO FROM CONCIERRESDIARIOS)) AS NombreCuenta,
                            VENTASCREDITO VALOR,CUENTACONTABLEVENTASCREDITO CUENTA,'D' Tipo
                           FROM CONCIERRESDIARIOS
                          WHERE IDCIERREDIARIO = $IdCierreDiario
                          UNION 
                            SELECT
                            (SELECT DESCRIPCIONCUENTACONTABLE FROM CONPLANCUENTAS
                                   WHERE CUENTACONTABLE IN (SELECT CUENTACONTABLEVENTASCHEQUE FROM CONCIERRESDIARIOS)) AS NombreCuenta,
                            VENTASCHEQUE VALOR,CUENTACONTABLEVENTASCHEQUE CUENTA,'D' Tipo
                           FROM CONCIERRESDIARIOS
                          WHERE IDCIERREDIARIO = $IdCierreDiario
                          UNION 
                            SELECT
                            (SELECT DESCRIPCIONCUENTACONTABLE FROM CONPLANCUENTAS
                                   WHERE CUENTACONTABLE IN (SELECT CUENTACONTABLEVENTASTC FROM CONCIERRESDIARIOS)) AS NombreCuenta,
                            VENTASTC  VALOR,CUENTACONTABLEVENTASTC CUENTA,'D' Tipo
                           FROM CONCIERRESDIARIOS
                          WHERE IDCIERREDIARIO = $IdCierreDiario
                          UNION 
                          SELECT
                            (SELECT DESCRIPCIONCUENTACONTABLE FROM CONPLANCUENTAS
                                    WHERE CUENTACONTABLE IN (SELECT CUENTACONTABLEVENTASCONTADOTARIFA0 FROM CONCIERRESDIARIOS)) AS NombreCuenta,
                                   VENTASCONTADOTARIFA0 VALOR,CUENTACONTABLEVENTASCONTADOTARIFA0 CUENTA,'H' Tipo
                            FROM CONCIERRESDIARIOS
                          WHERE IDCIERREDIARIO = $IdCierreDiario
                          UNION
                           SELECT
                            (SELECT DESCRIPCIONCUENTACONTABLE FROM CONPLANCUENTAS
                                   WHERE CUENTACONTABLE IN (SELECT CUENTACONTABLEVENTASCONTADOTARIFA12 FROM CONCIERRESDIARIOS)) AS NombreCuenta,
                                   VENTASCONTADOTARIFA12 VALOR,CUENTACONTABLEVENTASCONTADOTARIFA12 CUENTA,'H' Tipo
                            FROM CONCIERRESDIARIOS
                          WHERE IDCIERREDIARIO = $IdCierreDiario
                          UNION
                           SELECT
                            (SELECT DESCRIPCIONCUENTACONTABLE FROM CONPLANCUENTAS
                                   WHERE CUENTACONTABLE IN (SELECT CUENTACONTABLEVENTASCREDITOTARIFA12 FROM CONCIERRESDIARIOS)) AS NombreCuenta,
                                   VENTASCREDITOTARIFA12 VALOR,CUENTACONTABLEVENTASCREDITOTARIFA12 CUENTA,'H' Tipo
                            FROM CONCIERRESDIARIOS
                          WHERE IDCIERREDIARIO = $IdCierreDiario
                          UNION 
                          SELECT
                            (SELECT DESCRIPCIONCUENTACONTABLE FROM CONPLANCUENTAS
                                   WHERE CUENTACONTABLE IN (SELECT CUENTACONTABLEVENTASTCTARIFA0 FROM CONCIERRESDIARIOS)) AS NombreCuenta,
                            VENTASTCTARIFA0 VALOR,CUENTACONTABLEVENTASTCTARIFA0 CUENTA,'H' Tipo
                           FROM CONCIERRESDIARIOS
                          WHERE IDCIERREDIARIO = $IdCierreDiario
                          UNION 
                          SELECT  
                            (SELECT DESCRIPCIONCUENTACONTABLE FROM CONPLANCUENTAS
                                   WHERE CUENTACONTABLE IN (SELECT CUENTACONTABLEVENTASTCTARIFA12 FROM CONCIERRESDIARIOS)) AS NombreCuenta,
                            VENTASTCTARIFA12 VALOR,CUENTACONTABLEVENTASTCTARIFA12 CUENTA,'H' Tipo
                          FROM CONCIERRESDIARIOS
                          WHERE IDCIERREDIARIO = $IdCierreDiario
                          UNION 
                          SELECT  
                            (SELECT DESCRIPCIONCUENTACONTABLE FROM CONPLANCUENTAS
                                   WHERE CUENTACONTABLE IN (SELECT CUENTACONTABLEIVACOBRADO FROM CONCIERRESDIARIOS)) AS NombreCuenta,
                            IVACOBRADOTARIFA12 VALOR,CUENTACONTABLEIVACOBRADO CUENTA,'H' Tipo
                          FROM CONCIERRESDIARIOS
                          WHERE IDCIERREDIARIO = $IdCierreDiario";

           $xValorCuentaCaja              = 0;
           $xCuentaContable               = '';
           $xValorCuentasxCobrarClientes  = 0;
           $html ='';
           $ResultCierres = mysqli_query($conexion,$SqlCierreDiario);

           while($reg=  mysqli_fetch_array($ResultCierres))
           {
             if($reg['VALOR'] > 0)
             {
                $arreglo['CUENTA'][]= $reg['CUENTA'];
                $arreglo['NombreCuenta'][]= $reg['NombreCuenta'];
                $arreglo['Tipo'][]= $reg['Tipo'];
                $arreglo['VALOR'][]= $reg['VALOR'];             
             }
           }           

         echo json_encode($arreglo);

    }



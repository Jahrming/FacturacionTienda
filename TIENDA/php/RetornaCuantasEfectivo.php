

<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       include("Conexion.php");  
       $IdAsignacion= $_POST['IdAsignacion'];
       $SqlControlCaja="select * from controlcaja  ".
                        " where IdAsignacion=".$IdAsignacion;
       
       $rs= mysqli_query($conexion,$SqlControlCaja);
       $regControlCaja = mysqli_fetch_assoc($rs);
       $IdCaja         = $regControlCaja['Caja'];
       $IdCajero       = $regControlCaja['Cajero'];

       $sqlCantidadVtasEfectivo="select count(*) as Cantidad from movta,formapagofactura ".
                                " where movta.IdMov = formapagofactura.IdMovta ".
                                "   and movta.TipDoc = 1 ".
                                "   and movta.IdAsignacion= $IdAsignacion".
                                "   and formapagofactura.IdFormapago = 1 ";

       $rsCantidadVentasEfectivo=mysqli_query($conexion,$sqlCantidadVtasEfectivo);
       $regCantVtasEfectivo=mysqli_fetch_assoc($rsCantidadVentasEfectivo);
       $xCantVtasEfectivoFacturas = $regCantVtasEfectivo['Cantidad'];

       $sqlCantidadVtasEfectivo="select count(*) as Cantidad from movta,formapagofactura ".
                                " where movta.IdMov = formapagofactura.IdMovta ".
                                "   and movta.TipDoc = 3 ".
                                "   and movta.IdAsignacion= $IdAsignacion".
                                "   and formapagofactura.IdFormapago = 1 ";

       $rsCantidadNCEfectivo=mysqli_query($conexion,$sqlCantidadNCEfectivo);
       $regCantVtasEfectivoNC=mysqli_fetch_assoc($rsCantidadNCEfectivo);
       $xCantVtasNCEfectivo = $regCantNCEfectivo['Cantidad'];



       echo $xCantVtasEfectivo;

    }

      


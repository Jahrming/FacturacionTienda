

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
        $v_criterio= $_POST['Criterio'];
        $v_IdAlmacen = $_SESSION['idalmacen'];        
        $html='';
        $sql   ="select IdReferencia, CodigoBarra,DescripcionReferencia,Pvp,CargaIva,Iva,pvpfinal
                 from   referencias,systemprofile where DescripcionReferencia like '%$v_criterio%'".
                 " AND   systemprofile.IdEmpresa=$v_IdAlmacen";
        $rs       =  mysqli_query($conexion, $sql);
        while($row= mysqli_fetch_array($rs))
        {
             $html.="<a href='#' class='list-group-item' IdRef='".$row['IdReferencia']."' codigoBarra='".$row['CodigoBarra']."' descProducto='".$row['DescripcionReferencia']."' pvp='".$row['Pvp']."' cargaIva='".$row['CargaIva']."' Iva='".$row['Iva']."' PvpFinal='".$row['pvpfinal']."'>".$row['DescripcionReferencia']."</a>";
        }

        echo $html;
 
  }
      




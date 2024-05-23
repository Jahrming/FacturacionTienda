

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
        $html='';
        $sql   ="select IdReferencia, CodigoBarra,DescripcionReferencia,Pvp
                 from   referencias,systemprofile where DescripcionReferencia like '%$v_criterio%'";    
        $rs       =  mysqli_query($conexion, $sql);
        while($row= mysqli_fetch_array($rs))
        {
             $html.="<a href='#' class='list-group-item' IdRef='".$row['IdReferencia']."' codigoBarra='".$row['CodigoBarra']."' descProducto='".$row['DescripcionReferencia']."' pvp='".$row['Pvp']."' >".$row['DescripcionReferencia']."</a>";
        }

        echo $html;
 
  }
      




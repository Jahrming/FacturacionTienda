
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
       $v_criterio= $_POST['criterio'];
       $v_buscarPor= $_POST['BuscarPor'];
       //$v_buscarPor='A';
       //########## buscar por Apellidos ##################
       if($v_buscarPor=='N')
       {
         $strSQl="SELECT a.IdReferencia as Refe,a.Isbn as Isbn, a.DescripcionReferencia as Descripcion, IFNULL(b.stock,0) as saldo,
                         IFNULL(a.Pvp ,0) as pvp, IFNULL(a.AnioEdicion ,0) as Anio, a.CodigoBarra as Barra 
                    FROM referencias a , stock b
                   WHERE a.DescripcionReferencia like '%".$v_criterio."%' and a.IdReferencia = b.IdReferencia ";
                  
       }
      //########## buscar por Nombres ##################
      if($v_buscarPor=='C')
      {
         $strSQl="SELECT a.IdReferencia as Refe,a.Isbn as Isbn, a.DescripcionReferencia as Descripcion, IFNULL(b.stock,0) as saldo,
                         IFNULL(a.Pvp ,0) as pvp, IFNULL(a.AnioEdicion ,0) as Anio, a.CodigoBarra as Barra 
                    FROM referencias a , stock b
                   WHERE a.Isbn like '%".$v_criterio."%' and a.IdReferencia = b.IdReferencia  ";

       }

       $rs =  mysqli_query($conexion,$strSQl);
       while ($reg= mysqli_fetch_assoc($rs) ) 
       {

          $arreglo['data'][]= $reg;       
       }

          echo json_encode($arreglo);

      }



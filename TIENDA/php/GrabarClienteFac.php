

<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
       
        header("location:../index.php");
    }
    else
    {
        include("Conexion.php");
        $v_usuario              =   $_SESSION['user'];
        $v_TipDoc               =   $_POST['IdTipDoc'];
        $v_CedulaRuc            =   $_POST['NumDoc'];
        $v_Apellidos            =   $_POST['NombreCliente'];
        $v_Nombres              =   '.'; 
        $v_Telefonos            =   $_POST['Telefonos'];
        $v_Direccion            =   $_POST['Direccion'];
        $v_Email                =   $_POST['Email'];
        $v_Estado               =   'A';

        $SqlInsert="INSERT INTO clientes ( IdCliente,IdTipoDocumento,CedulaRUC,Apellidos,Telefonos,
                                           Direccion,Email,Estado,aud_usuario_proc,aud_fecha_proc) 
                         VALUES ('0','$v_TipDoc','$v_CedulaRuc','$v_Apellidos','$v_Telefonos',
                                                '$v_Direccion','$v_Email','$v_Estado','$v_usuario',now())";
            if ($conexion->query($SqlInsert)==TRUE)
            {
               $last_id=$conexion->insert_id;
               $strSQl  =   "select IdCliente,CedulaRUC from clientes where IdCliente=$last_id";
               $rs      =   mysqli_query($conexion,$strSQl);
               $reg     =   mysqli_fetch_assoc($rs);
               echo implode("_;_", $reg);
            }
            else
            {
                echo "Error: ".$SqlInsert."<br>".$conexion->error;
            }
            //$conexion->close();
        
        }
       

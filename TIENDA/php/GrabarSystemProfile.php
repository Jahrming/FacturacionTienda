<?php

  SESSION_START();
  if(!isset($_SESSION['user']))
  {
          header("location:../index.php");
  }
  else
  {
      include("Conexion.php");
     $ruc                     = $_POST['ruc'];
     $nombreEmpresa           = $_POST['nombre'];
     $Direccion               = $_POST['direccion'];
     $Telefonos               = $_POST['Telefonos'];
     $Iva 		                = $_POST['iva'];
     $SoloEfectivo            = $POST['soloEfectivo'];
     $v_usuarioGraba          = $_SESSION['user'];
     $xsoloEfectivo           = $_POST['soloEfectivo'];
     $xasignarCajero          = $_POST['asignarCajero'];
     $xdenominacionMonedas    = $_POST['denominacionMonedas'];
     $xnombreGerente          = $_POST['repLegal'];
     $xEmail                  = $_POST['email'];
     $xNombreComercial        = $_POST['nombreComercial'];

      $SqlUpdate="update systemprofile set   RUC                  =       '$ruc',
                                          NombreEmpresa           =       '$nombreEmpresa',
                                          Gerente                 =       '$xnombreGerente',
                                          NombreComercial         =       '$xNombreComercial',
                                          Direccion               =       '$Direccion',
                                          Iva                     =        $Iva,
                                          Telefonos               =       '$Telefonos',
                                          aud_usuario_proc        =       '$v_usuarioGraba',
                                          aud_fecha_proc          =        now() ,
                                          SoloEfectivo            =       '$xsoloEfectivo',
                                          AsignarCajero           =       '$xasignarCajero',
                                          DenominacionMonedas    =        '$xdenominacionMonedas',
                                          email                  =        '$xEmail' ";



          if ($conexion->query($SqlUpdate)==TRUE)
          {
            header('Location:Mensajes.php?mensaje=Autor actualizado exitosamente&Destino=../inicio/menu.php');
          }
          else
          {
              echo "Error: ".$SqlUpdate."<br>".$conexion->error;
          }
          $conexion->close();
      }
       

<?php
  
  $Servidor = "localhost";
  $Base_Datos = "facturacion";
  $usuario = "xsaltos";   //usuario del motor de base de datos
  $clave = "xsaltos" ;  // clave del usuario del motor de la base de datos

  $conexion = new mysqli($Servidor,$usuario,$clave);
  mysqli_select_db($conexion,$Base_Datos);

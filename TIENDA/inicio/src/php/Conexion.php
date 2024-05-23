<?php
   $Servidor="localhost";
   $Base_Datos="compuvargas";
   $usuario="root";
   $clave = "root";

   $conexion = new mysqli($Servidor,$usuario,$clave);
   
    if(!$conexion)
    {
       echo 'error en el acceso a la base de daatos';
       //die('Error en la comunicación con la base de datos');
   }
   else {
     mysqli_select_db($conexion,$Base_Datos);
   }
   //$base=  mysql_select_db($DB,$conexion);
/* $
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


<?php
/*$mail = "Prueba de mensaje";
//Titulo
$titulo = "Sistema help desk PHD 1.0";
//cabecera
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
//dirección del remitente 
$headers .= "From: Geeky Theory < xsaltos@hotmail.com >\r\n";
//Enviamos el mensaje a tu_dirección_email 
$bool = mail(" xsaltos@hotmail.com",$titulo,$mail,$headers);
if($bool){
    echo "Mensaje enviado";
}else{
    echo "Mensaje no enviado";
}*/
$to = "xavier_saltos@yahoo.com";
$subject = "Mensaje Enviado";
$contenido = "Nombre:  \n";
$contenido .= "Email:     \n\n";
$contenido .= "Comentario:  \n\n";
$header = "From: xsaltos@hotmail.com\nReply-To:xsaltos@hotmail.com \n";
$header .= "Mime-Version: 1.0\n";
$header .= "Content-Type: text/plain";
if(mail($to, $subject, "$contenido ","cssa"  ,$header)){
echo "Mail Enviado.";
}
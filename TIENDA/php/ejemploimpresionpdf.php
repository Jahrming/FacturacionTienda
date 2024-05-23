<?php


require_once 'dompdf/autoload.inc.php';
 use Dompdf\Dompdf;
 define('DOMPDF_ENABLE_AUTOLOAD', false);
 $html= "<!DOCTYPE html>".
 "<html>".
 "<head>".
  "<title>PULEINA</title>".
 "</head>".
 "<body>".
 "<h1>HOLA!</h1>".
 "</body>".
 "</html>";
 $dompdf = new Dompdf();
 $dompdf->load_html($html);
 $dompdf->render();
 $dompdf->stream("sample1.pdf");



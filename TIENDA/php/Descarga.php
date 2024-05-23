<?php


    	header("Content-disposition: attachment; filename=hola.txt");
        header("Content-type: MIME");
        readfile("hola.txt");
?>
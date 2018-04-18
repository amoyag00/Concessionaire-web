<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_FILES["archivo"])){
    $xmlContent = file_get_contents($_FILES["archivo"]["tmp_name"]);
    $productos = new SimpleXMLElement($xmlContent);
    
    echo $productos->Producto[0]->attributes();
}
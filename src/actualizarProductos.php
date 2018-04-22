<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'models/Producto.php';

if(is_uploaded_file($_FILES["archivo"]["tmp_name"])){
    $xmlContent = file_get_contents($_FILES["archivo"]["tmp_name"]);
    $productos = new SimpleXMLElement($xmlContent);
    //echo $productos->Producto[0]->attributes();
    for($i=0;$i<sizeof($productos);$i++){
        $elemento = $productos->Producto[$i];
      
        //echo $elemento->attributes()["id"];

        $nuevoProducto = new \Models\Producto();
        
        $datos = array(
            "nombrePro" => NULL,
            "nombre" => $elemento->Nombre,
            "caracteristicas" => $elemento->Caracteristicas,
            "precio" => $elemento->Precio,
            "disponible" => $elemento->Disponible,
        );

        $nuevoProducto->setAttributes($datos);
        $nuevoProducto->updateOrInsert($elemento->attributes()["id"]);
        
        goBack();
    }
}
else{    
    echo '<script type="text/javascript">
            alert("No se ha introducido un archivo de actualizacion");
          </script>';
}

function goBack(){
    header("Location: {$_SERVER["HTTP_REFERER"]}");
}
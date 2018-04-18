<?php
require_once 'isConcessionaire.php';
require_once 'Pedido.php';

header("Content-type: application/json; charset=utf-8");

$obj= json_decode($_POST["data"]);

switch($obj->peticion){
    case "listarPedidos":
        echo json_encode(Pedido::listPedidosOfConc($_SESSION["user"]));
        break;
}

?>

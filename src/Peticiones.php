<?php
namespace Peticiones;
require_once 'isConcessionaire.php';
require_once 'models/Pedido.php';
require_once 'models/Producto.php';

header("Content-type: application/json; charset=utf-8");

$obj= json_decode($_POST["data"]);

switch($obj->peticion){
    case "listarPedidos":
        echo json_encode(\Models\Pedido::listPedidosOfConc($_SESSION["user"]));
        break;
    case "registrarPedido":
        $pedido= new \Models\Pedido();
        $attributes=array("conc_name"=>$_SESSION["user"],
                            "status"=>0);
        $pedido->setAttributes($attributes);
        $pedido_id=$pedido->insert();
        break;
    case "listarProductos":
        $p=new Producto();
        echo json_encode($p->filter("seat"));
        break;   
}

?>

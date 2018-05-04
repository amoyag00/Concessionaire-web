<?php
namespace Peticiones;
//require_once 'isConcessionaire.php';
require_once 'isLogin.php';
require_once 'models/Pedido.php';
require_once 'models/Producto.php';
require_once 'models/ListaProductos.php';

header("Content-type: application/json; charset=utf-8");

$obj= json_decode($_POST["data"]);

switch($obj->peticion){
    case "listarPedidos":
        $pedidos=\Models\Pedido::listPedidosOfConc($_SESSION["user"]);
        foreach($pedidos as $pedido){
            $pedido->listaProductos=\Models\ListaProductos::getListaProd($pedido->pedido_id);
        }
        echo json_encode($pedidos);
        
        break;
    case "registrarPedido":
        $pedido= new \Models\Pedido();
       
        $pedido_id=$pedido->insert($_SESSION["user"]);
        $lp=new \Models\ListaProductos();
        foreach($obj->cart_items as $item){
            $lp->insert($item->id,$pedido_id,$item->quantity);
        }
        echo json_encode($obj->cart_items);
        break;
    case "listarProductos":
        echo json_encode(\Models\Producto::getAll());
        break;
    case "filtrarPedidos":
        echo json_encode(\Models\Pedido::filterPedidos($obj->param, $obj->filter,$_SESSION["user"]));
        break;
    case "listaPedidosCompleta": 
        echo json_encode(\Models\Pedido::getAll($_SESSION["user"]));
        break;
    case "listaNoConfirmados":
        echo json_encode(\Models\Pedido::getNotConfirmed($_SESSION["user"]));
        break;
    
}
?>
<?php
namespace Peticiones;
//require_once 'isConcessionaire.php';
require_once 'isLogin.php';
require_once 'models/Pedido.php';
require_once 'models/Producto.php';
require_once 'models/Usuario.php';
require_once 'models/ListaProductos.php';

use \Models\Pedido as Pedido;
use \Models\ListaProductos as ListaProductos;
use \Models\Producto as Producto;
use \Models\Usuario as Usuario;

header("Content-type: application/json; charset=utf-8");

$datos = filter_var($_POST["data"], FILTER_SANITIZE_STRING);

$obj= json_decode($_POST["data"]);

switch($obj->peticion){
    case "listarPedidos":
        $pedidos=Pedido::listPedidosOfConc($_SESSION["user"]);
        foreach($pedidos as $pedido){
            $pedido->listaProductos=ListaProductos::getListaProd($pedido->pedido_id);
        }
        echo json_encode($pedidos);
        
        break;
    case "registrarPedido":
        $pedido= new Pedido();
       
        $pedido_id=$pedido->insert($_SESSION["user"]);
        $lp=new ListaProductos();
        foreach($obj->cart_items as $item){
            $lp->insert($item->id,$pedido_id,$item->quantity);
        }
        echo json_encode($obj->cart_items);
        break;
    case "listarProductos":
        echo json_encode(Producto::getAll());
        break;
    case "filtrarPedidos":
        $pedidos=Pedido::filterPedidos($obj->param, $obj->filter,$_SESSION["user"],$obj->fechaParam);
        foreach($pedidos as $pedido){
            $pedido->listaProductos=ListaProductos::getListaProd($pedido->pedido_id);
        }
        echo json_encode($pedidos);
        
        break;
    case "listaPedidosCompleta": 
        echo json_encode(Pedido::getAll($_SESSION["user"]));
        break;
    case "listaNoConfirmados":
        echo json_encode(Pedido::getNotConfirmed($_SESSION["user"]));
        break;
    case "confirm":
        Pedido::confirm($obj->pedido, $obj->producto);
        if($obj->all){
            echo json_encode(Pedido::getAll($_SESSION["user"]));
        }
        else{
            echo json_encode(Pedido::getNotConfirmed($_SESSION["user"]));
        }
        break;
    case "updateProducto":
        $lp=new ListaProductos();
        $lp->update($obj->cantidad, $obj->producto_id, $obj->pedido_id);
        $pedidos=Pedido::listPedidosOfConc($_SESSION["user"]);
        foreach($pedidos as $pedido){
            $pedido->listaProductos=ListaProductos::getListaProd($pedido->pedido_id);
        }
        echo json_encode($pedidos);
        break;
    case "deleteProductoPedido":
        $lp=new ListaProductos();
        $lp->delete($obj->pedido_id,$obj->producto_id );
        $pedidos=Pedido::listPedidosOfConc($_SESSION["user"]);
        foreach($pedidos as $pedido){
            $pedido->listaProductos=ListaProductos::getListaProd($pedido->pedido_id);
        }
        echo json_encode($pedidos);
        break;
    case "deletePedido":
        $pedido=new Pedido();
        $pedido->delete($obj->pedido_id);
                $pedidos=Pedido::listPedidosOfConc($_SESSION["user"]);
        foreach($pedidos as $pedido){
            $pedido->listaProductos=ListaProductos::getListaProd($pedido->pedido_id);
        }
        echo json_encode($pedidos);
        break;
    case "filtrarProductos":
        echo json_encode(Producto::filter($obj->filter));
        break;
    case "logout":
        $u=new Usuario();
        $u->logout($_SESSION["user"]);
	session_unset();
        break;
		
	case "expulsar":
        $u=new Usuario();
        $u->logout($obj->name);
        break;
	
	case "bloquear":
        $u=new Usuario();
        $u->bloquear($obj->name);
        break;
	
	case "desbloquear":
        $u=new Usuario();
        $u->desbloquear($obj->name);
        break;
	
	case "deleteUser":
        $u=new Usuario();
        $bien = $u->eliminar($obj->name);
        if($bien<=0){
			$incorrecto = "EL USUARIO NO SE HA PODIDO ELIMINAR";
			echo json_encode($incorrecto);
		}else{
			$correcto = "EL USUARIO HA SIDO ELIMINADO";
			echo json_encode($correcto);
        }
        break;	
		
	case "registrarUsuario":
        $u=new Usuario();
		$bien = $u->insert($obj->name,$obj->password,$obj->type);
		if($bien<=0){
			$incorrecto = "EL USUARIO NO SE HA PODIDO REGISTRAR";
			echo json_encode($incorrecto);
		}else{
			$correcto = "EL USUARIO HA SIDO REGISTRADO";
			echo json_encode($correcto);
        }
        break;	
	case "listaUsuarios":
		 $u=new Usuario();
		
		$usr=$u->listarUsuarios();
		echo json_encode($usr);
		
        break;
		
	case "listaMensajes":
		$adm=new Usuario();
		
		$mensajes=$adm->getMessages($obj->filtro);
		echo json_encode($mensajes);
		
        break;
		
	case "mensajeLeido":
		$adm=new Usuario();
		
		$adm->mensajeLeido($obj->id);
		
        break;
	case "mensajeNoLeido":
		$adm=new Usuario();
		
		$adm->mensajeNoLeido($obj->id);
		
        break;	
	case "nuevoMensaje":
		$usr=new Usuario();
		
		$usr->addMessages($obj->name,$obj->email,$obj->consult);
		
        break;
	
}
?>

<?php
namespace Models;
require_once 'DBConnection.php';


class ListaProductos{

	private $conn;
	private $producto_id;
    private $pedido_id;
    private $cantidad;
	
	function __construct() {
        $this->conn = DBConnection::getConnection();
    }

	function setAttributes($data){
        $this->producto_id=$data["producto_id"];
        $this->pedido_id=$data["pedido_id"];
        $this->cantidad=$data["cantidad"];
    }
	
	function insert(){
        $statement=$this->conn->prepare("INSERT INTO ListaProductos VALUES(?,?,?)");
		$statement->bind_param("iii",$producto_id, $pedido_id, $cantidad);
		$statement->execute();
        $statement->close();
	}
	
	function update($data){
		$statement=$this->conn->prepare("SELECT pedido_id FROM Pedido WHERE nombreCon = ?");
        $statement->bind_param("s",$username);
        $statement->execute();
		$statement->bind_result($pedido_id);
		$statement->close();
		
		$statement2=$this->conn->prepare("UPDATE ListaProductos SET cantidad = ? WHERE pedido_id= ?");
		$statement2->bind_param("is", $data, $pedido_id);
		$result=$statement2->get_result();
		$statement2->close();
		
		return $result->fetch_assoc();
	}
	
	static function getListaProd($pedido_id){
            $conn = DBConnection::getConnection();
            $statement = $conn->prepare("SELECT Producto.nombre, Producto.nombrePro, Producto.precio, ListaProductos.cantidad, ListaProductos.estado
										 FROM (ListaProductos
										 INNER JOIN Producto ON ListaProductos.producto_id = Producto.producto_id)
										 WHERE ListaProductos.pedido_id = ?");
            $statement->bind_param("i", $pedido_id);
            $statement->execute();
            $lista = $statement->get_result();
            $listaProductos = array();
            while ($fila = $lista->fetch_assoc()) {
                $listaProductos[] = $fila;
            }
            $statement->close();
            return $listaProductos;
        }
	
	/*function getListaProdProv($pedido_id){
		
		$statement=$this->conn->prepare("SELECT Producto.nombre, Producto.precio, ListaProductos.cantidad
										 FROM ((ListaProductos
										 INNER JOIN Producto ON ListaProductos.producto_id = Producto.producto_id)
										 INNER JOIN Pedido ON ListaProductos.pedido_id = Pedido.pedido_id)
										 WHERE Proveedor.nombreProv = ? AND ListaProductos.pedido_id = ?;");
		$statement->bind_param("si",$username,$pedido_id);

		$statement->execute();
		$statement->fetch();

	}*/
}
?>
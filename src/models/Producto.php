<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Models;
require_once 'DBConnection.php';

class Producto{
    private $connection;
    private $producto_id;
    private $proveedor;
    private $nombre;
    private $caracteristicas;
    private $precio;
    private $disponible;
    
    function __construct() {
        $this->connection = DBConnection::getConnection();
    }
    
    function setAttributes($data){
        $this->proveedor = $data["nombrePro"];
        $this->nombre = $data["nombre"];
        $this->caracteristicas = $data["caracteristicas"];
        $this->precio = $data["precio"];
        $this->disponible = $data["disponible"];
    }
    
    function getAttributes(){
        return array(
            "producto_id" => $this->producto_id,
            "proveedor" => $this->proveedor,
            "nombre" => $this->nombre,
            "caracteristicas" => $this->caracteristicas,
            "precio" => $this->precio,
            "disponible" => $this->disponible,
       );
    }
    
    function insert(){
        $statement = $this->connection->prepare("INSERT INTO Producto(nombrePro, nombre, caracteristicas, precio, disponible) VALUES(?,?,?,?,?)");
        $statement->bind_param("sssii", $this->proveedor, $this->nombre, $this->caracteristicas, $this->precio, $this->disponible);
        $statement->execute();
        $statement->close();
    }
    
    function getProducto($p_id){
        $statement = $this->connection->prepare("SELECT * FROM Producto WHERE producto_id=?");
        $statement->bind_param("i", $p_id);
        $statement->execute();
        $producto = $statement->get_result();
        
        if($fila = $producto->fetch_assoc()){
            $this->setAttributes($fila);
        }
        $statement->close();
    }
    
    static function getListaProductosProveedor($prov_name){
        $connection = DBConnection::getConnection();
        $statement = $connection->prepare("SELECT producto_id, nombre, precio, disponible FROM Producto WHERE nombrePro=?");
        $statement->bind_param("s", $prov_name);
        $statement->execute();
        $lista = $statement->get_result();
        $listaProductos = array();
        
        while($fila = $lista->fetch_assoc()){
            $listaProductos[] = $fila;
        }
        $statement->close();
        
        return $listaProductos;
    }
    
    static function getAll(){
        $connection = DBConnection::getConnection();
        $statement = $connection->prepare("SELECT * FROM Producto");
        $statement->execute();
        $lista = $statement->get_result();
        $listaProductos = array();
        
        while($fila = $lista->fetch_assoc()){
            $listaProductos[] = $fila;
        }
        $statement->close();
        
        return $listaProductos;
    }
    
    function updateOrInsert($p_id){
        $statement = $this->connection->prepare("INSERT INTO Producto (producto_id, nombrePro, nombre, caracteristicas, precio, disponible) VALUES(?,?,?,?,?,?) ON DUPLICATE KEY UPDATE producto_id = VALUES(producto_id) nombrePro = VALUES(nombrePro), nombre = VALUES(nombre), caracteristicas = VALUES(caracteristicas), precio = VALUES(precio), disponible = VALUES(disponible)");
        $statement->bind_param("isssii", $p_id, $this->proveedor, $this->nombre, $this->caracteristicas, $this->precio, $this->disponible);
        $statement->execute();
        $statement->close();
    }
}
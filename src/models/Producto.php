<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'DBConnection.php';
class Producto{
    private $connection;
    private $producto_id;
    private $proveedor;
    private $nombre;
    private $caracteristicas;
    private $precio;
    private $disponible;
    
    function __construct($proveedor, $nombre, $caracteristicas, $precio, $disponible) {
        $this->connection = DBConnection::getConnection();
        $this->proveedor = $proveedor;
        $this->nombre = $nombre;
        $this->caracteristicas = $caracteristicas;
        $this->precio = $precio;
        $this->disponible = $disponible;
    }
    
    function setAttributes($data){
        $this->proveedor = $data["proveedor"];
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
}
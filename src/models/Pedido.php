<?php
namespace Models;
    require_once 'DBConnection.php';
    
    class Pedido{
        private $connection;
        private $pedido_id;
        private $conc_name;
        private $date;
        private $status;
        
        function __construct(){
            $this->connection=DBConnection::getConnection();
        }
        
        function setAttributes($data){
            $this->conc_name=$data["conc_name"];
        }
        
        function getAttributes(){
            return array(
                    "pedido_id"=> $this->pedido_id,
                    "conc-name"=> $this->conc_name,
                    "date"=> $this->date,
            );
           
        }
        
        static function confirm($pedido, $producto){
            $connection=DBConnection::getConnection();
            $statement = $connection->prepare("UPDATE ListaProductos SET estado=1 WHERE pedido_id=? AND producto_id=?");
            $statement->bind_param("ii", $pedido, $producto);
            $statement->execute();
            $statement->close();
        }
        
        static function getAll($nombre){
            $connection=DBConnection::getConnection();
            //$statement = $connection->prepare("SELECT pedido_id, nombreCon, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM Pedido WHERE pedido_id IN (SELECT pedido_id FROM ListaProductos WHERE producto_id IN (SELECT producto_id FROM Producto WHERE nombrePro=?))");
            $statement = $connection->prepare("SELECT ListaProductos.pedido_id, DATE_FORMAT(Pedido.fecha, '%d/%m/%Y') AS fecha, Producto.nombre, ListaProductos.cantidad, Pedido.nombreCon, ListaProductos.estado FROM ListaProductos INNER JOIN Producto ON Producto.producto_id = ListaProductos.producto_id INNER JOIN Pedido ON Pedido.pedido_id=ListaProductos.pedido_id WHERE Producto.nombrePro=? ORDER BY pedido_id;");
            $statement->bind_param("s", $nombre);
            $statement->execute();
            $result = $statement->get_result();
            $pedidos = array();
   
            while($fila=$result->fetch_assoc()){
                $pedidos [] =$fila;
            }
            $statement->close();
            
            return $pedidos;
        }
        
        static function getNotConfirmed($nombre){
            $connection=DBConnection::getConnection();
            //$statement = $connection->prepare("SELECT pedido_id, nombreCon, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM pedido WHERE pedido_id IN (SELECT pedido_id FROM listaproductos WHERE estado=0 AND producto_id IN (SELECT producto_id FROM producto WHERE nombrePro=?))");
            $statement = $connection->prepare("SELECT ListaProductos.pedido_id, DATE_FORMAT(Pedido.fecha, '%d/%m/%Y') AS fecha, Producto.nombre, ListaProductos.cantidad, Pedido.nombreCon, ListaProductos.estado, Producto.producto_id FROM ListaProductos INNER JOIN Producto ON Producto.producto_id = ListaProductos.producto_id INNER JOIN Pedido ON Pedido.pedido_id=ListaProductos.pedido_id WHERE Producto.nombrePro=? AND ListaProductos.estado=0 ORDER BY pedido_id;");
            $statement->bind_param("s", $nombre);
            $statement->execute();
            $result = $statement->get_result();
            $pedidos = array();
            
            while($fila=$result->fetch_assoc()){
                $pedidos [] =$fila;
            }
            $statement->close();
            
            return $pedidos;
        }
       
        static public function listPedidosOfConc($conc_name){
            $connection=DBConnection::getConnection();
            $statement=$connection->prepare("SELECT pedido_id, nombreCon, DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha FROM Pedido WHERE nombreCon=?");
            $statement->bind_param("s",$conc_name);
            $statement->execute();
            $result=$statement->get_result();
            $pedidos =[];
            while($row=$result->fetch_object()){
                $pedidos [] =$row;
            }
            $statement->close();
            //$this->conn->close();
            return $pedidos;
        }
        
        static public function filterPedidos($param, $filter, $conc, $fechaParam){
            $connection=DBConnection::getConnection();
            if($param=="Fecha"){
                if($fechaParam==="Posterior"){
                    $statement=$connection->prepare("SELECT pedido_id, nombreCon, DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha "
                        . "FROM Pedido WHERE DATE_FORMAT(fecha,'%d/%m/%Y') > ? AND nombreCon=?");
                        $statement->bind_param("ss", $filter,$conc);
                }else if($fechaParam==="Previo"){
                     $statement=$connection->prepare("SELECT pedido_id, nombreCon, DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha "
                        . "FROM Pedido WHERE DATE_FORMAT(fecha,'%d/%m/%Y') < ? AND nombreCon=?");
                        $statement->bind_param("ss", $filter,$conc);
                }else if($fechaParam==="Exacta"){
                     $statement=$connection->prepare("SELECT pedido_id, nombreCon, DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha "
                        . "FROM Pedido WHERE DATE_FORMAT(fecha,'%d/%m/%Y') LIKE ? AND nombreCon=?");
                        $statement->bind_param("ss", $filter,$conc);
                }
                
            }else if ($param=="Proveedor"){
                $filter="%".$filter."%";
                $statement=$connection->prepare("SELECT pedido.pedido_id, DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha FROM Pedido"
                        . " INNER JOIN listaproductos ON listaproductos.pedido_id=pedido.pedido_id "
                        . "INNER JOIN producto ON producto.producto_id=listaproductos.producto_id "
                        . "WHERE nombreCon=? AND producto.nombrePro LIKE ? ");
                        $statement->bind_param("ss",$conc, $filter);
            }else if($param=="Producto"){
                $filter="%".$filter."%";
                $statement=$connection->prepare("SELECT pedido.pedido_id, DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha FROM Pedido"
                        . " INNER JOIN listaproductos ON listaproductos.pedido_id=pedido.pedido_id "
                        . "INNER JOIN producto ON producto.producto_id=listaproductos.producto_id "
                        . "WHERE nombreCon=? AND producto.nombre LIKE ? ");
                        $statement->bind_param("ss",$conc, $filter);
            }
            $statement->execute();
            $result=$statement->get_result();
            $pedidos =[];
            while($row=$result->fetch_object()){
                $pedidos [] =$row;
            }
            $statement->close();
            //$this->conn->close();
            return $pedidos;
        }
        
        function loadPedido($id){
            $statement=$this->connection->prepare("SELECT * FROM Pedido WHERE pedido_id=?");
            $statement->bind_param("s",$id);
            $statement->execute();
            $result=$statement->get_result();
            if($row=$result->fetch_assoc()){
                $this->setAttributos($row);
            }
            $statement->close();
            //$this->conn->close();
        }
        
        
        function insert($nombreCon){
            $statement=$this->connection->prepare("INSERT INTO Pedido(nombreCon) VALUES(?)");
            $statement->bind_param("s", $nombreCon);
            $statement->execute();
            $statement->close();
            return $this->connection->insert_id;
            //$this->conn->close();
        }
        
        function delete($pedido_id){
            $statement=$this->connection->prepare("DELETE FROM Pedido WHERE pedido_id=?");
	    $statement->bind_param("i",$pedido_id);
            $statement->execute();
            $statement->close();
        }
    }

?>

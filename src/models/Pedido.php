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
        
        static function getProductosPedido($id){
            $connection=DBConnection::getConnection();
            $statement = $connection->prepare("SELECT * FROM Producto WHERE producto_id IN (SELECT producto_id FROM ListaProductos WHERE pedido_id IN (SELECT pedido_id FROM Pedido WHERE pedido_id=?))");
            $statement->bind_param("s", $id);
            $statement->execute();
            $result = $statement->get_result();
            $productos = array();
            
            while($fila=$result->fetch_assoc()){
                $productos [] =$fila;
            }
            $statement->close();
            
            return $productos;
        }
        
        static function getAll($nombre){
            $connection=DBConnection::getConnection();
            $statement = $connection->prepare("SELECT pedido_id, nombreCon, estado, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM Pedido WHERE pedido_id IN (SELECT pedido_id FROM ListaProductos WHERE producto_id IN (SELECT producto_id FROM Producto WHERE nombrePro=?))");
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
            $statement = $connection->prepare("SELECT pedido_id, nombreCon, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM pedido WHERE pedido_id IN (SELECT pedido_id FROM listaproductos WHERE estado=0 AND producto_id IN (SELECT producto_id FROM producto WHERE nombrePro=?))");
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
        
        static public function filterPedidos($param, $filter, $conc){
            $connection=DBConnection::getConnection();
   
            if($param=="Fecha"){
                $statement=$connection->prepare("SELECT pedido_id, nombreCon, DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha "
                        . "FROM Pedido WHERE DATE_FORMAT(fecha,'%d/%m/%Y') > ? AND nombreCon=?");
                        $statement->bind_param("ss", $filter,$conc);
            }else if ($param=="Proveedor"){
                $statement=$connection->prepare("SELECT pedido_id, nombreCon, DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha"
                        . " FROM Pedido WHERE ? LIKE ?");
                        $statement->bind_param("ss",$param, $filter);
            }else if($param=="Producto"){
                
            }
            $statement->execute();
            $result=$statement->get_result();
            $pedidos =[];
            while($row=$result->fetch_assoc()){
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
    }

?>

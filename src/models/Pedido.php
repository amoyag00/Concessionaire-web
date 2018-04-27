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
            $this->date=$data["date"];
            $this->status=$data["status"];
        }
        
        function getAttributes(){
            return array(
                    "pedido_id"=> $this->pedido_id,
                    "conc-name"=> $this->conc_name,
                    "date"=> $this->date,
            );
           
        }
        
        static function getAll(){
            $connection=DBConnection::getConnection();
            $statement = $connection->prepare("SELECT pedido_id, nombreCon, estado, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM Pedido");
            $statement->execute();
            $result = $statement->get_result();
            $pedidos = array();
            
            while($fila=$result->fetch_assoc()){
                $pedidos [] =$fila;
            }
            $statement->close();
            
            return $pedidos;
        }
        
        static function getNotConfirmed(){
            $connection=DBConnection::getConnection();
            $statement = $connection->prepare("SELECT pedido_id, nombreCon, estado, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM Pedido WHERE estado=0");
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
            while($row=$result->fetch_assoc()){
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
        
        
        function insert(){
            $statement=$this->connection->prepare("INSERT INTO Pedido(nombreCon, fecha) VALUES(?,?)");
            $statement->bind_param("ss",$this->conc_name,$this->date);
            $statement->execute();
            $statement->close();
            return $this->connection->lastInsertId();
            //$this->conn->close();
        }
    }

?>

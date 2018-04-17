<?php
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
                    "status"=> $this->status,
            );
           
        }
        
        static public function listPedidosOfConc($conc_name){
            $connection=DBConnection::getConnection();
            $statement=$connection->prepare("SELECT * FROM Pedido WHERE nombreCon = ?");
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
            $statement=$this->connection->prepare("INSERT INTO Pedido(nombreCon, fecha, estado) VALUES(?,?,?)");
            $statement->bind_param("sss",$this->conc_name,$this->date, $this->status);
            $statement->execute();
            $statement->close();
            //$this->conn->close();
        }
    }

?>

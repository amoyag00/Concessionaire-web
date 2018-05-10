<?php
namespace Models;
require_once 'DBConnection.php';
    
class Administrador{
	
	private $conn;
	
	function getMessages($filtro){
		 
        $this->conn=DBConnection::getConnection();
        if($filtro=="noLeidos"){
			$statement=$this->conn->prepare("SELECT mensaje_id, name, email, consulta, leido FROM mensaje WHERE leido=0 ORDER BY mensaje_id DESC LIMIT 100");
		}else{
			$statement=$this->conn->prepare("SELECT mensaje_id, name, email, consulta, leido FROM mensaje  ORDER BY mensaje_id DESC LIMIT 100");
		}
        $statement->execute();
        $result = $statement->get_result();
        $mensajes = array();
            while ($fila = $result->fetch_assoc()) {
                $mensajes[] = $fila;
            }
		
        return $mensajes;

    }

	function mensajeLeido($id){
		$this->conn=DBConnection::getConnection();
        $statement=$this->conn->prepare("UPDATE mensaje SET leido=1 WHERE mensaje_id = ?");
        $statement->bind_param("i",$id);
        $statement->execute();
        $statement->close();
	}
	
}
?>
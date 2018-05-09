<?php
namespace Models;
require_once 'DBConnection.php';
    
class Administrador{
	
	private $conn;
	
	function getMessages(){
		 
        $this->conn=DBConnection::getConnection();
        $statement=$this->conn->prepare("SELECT name, email, consulta FROM mensaje ORDER BY mensaje_id DESC LIMIT 100");
        $statement->execute();
        $result = $statement->get_result();
        $mensajes = array();
            while ($fila = $result->fetch_assoc()) {
                $mensajes[] = $fila;
            }
		
        return $mensajes;

    }

	
}
?>
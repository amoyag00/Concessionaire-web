<?php
namespace Models;
require_once 'DBConnection.php';
class Usuario{
    private $conn;
    private $username;
    private $password;
    private $type;
    
    
    function setAttributes($data){
        $this->username=$data["username"];
        $this->password=$data["password"];
        $this->type=$data["type"];
    }
    
    function checkPassword($username, $password){
        $this->conn=DBConnection::getConnection();
        $statement=$this->conn->prepare("SELECT tipo, logged FROM Usuario WHERE nombre=? AND contrasena=?");
        $statement->bind_param("ss",$username,$password);
        $statement->execute();
        $result=$statement->get_result();
        $statement->close();
        //$this->conn->close();
        return $result->fetch_assoc();

    }
	
	function checkUsuario($username){
        $this->conn=DBConnection::getConnection();
        $statement=$this->conn->prepare("SELECT nombre FROM Usuario WHERE nombre=?;");
        $statement->bind_param("ss",$username,$password);
        $statement->execute();
        $result=$statement->get_result();
        $statement->close();
        //$this->conn->close();
        return $result->fetch_assoc();

    }
    
    function logout($username){
        $this->conn=DBConnection::getConnection();
        $statement=$this->conn->prepare("UPDATE Usuario SET logged=0 WHERE nombre = ?");
        $statement->bind_param("s",$username);
        $statement->execute();
        $statement->close();
    }
	
    function login($username){
        $this->conn=DBConnection::getConnection();
        $statement=$this->conn->prepare("UPDATE Usuario SET logged=1 WHERE nombre = ?");
        $statement->bind_param("s",$username);
        $statement->execute();
        $statement->close();
    }
    
	function bloquear($username){
        $this->conn=DBConnection::getConnection();
        $statement=$this->conn->prepare("UPDATE Usuario SET bloqueado=1 WHERE nombre = ?");
        $statement->bind_param("s",$username);
        $statement->execute();
        $statement->close();
    }
	
	function desbloquear($username){
        $this->conn=DBConnection::getConnection();
        $statement=$this->conn->prepare("UPDATE Usuario SET bloqueado=0 WHERE nombre = ?");
        $statement->bind_param("s",$username);
        $statement->execute();
        $statement->close();
    }
	
    /*function insert(){
        $this->conn=DBConnection::getConnection();
        $statement=$this->conn->prepare("INSERT INTO Usuario(nombre,contrasena,tipo) VALUES(?,?,?)");
        $statement->bind_param("sss",$this->username,$this->password, $this->type);
        $statement->execute();
        $affectedRows=mysqli_affected_rows($this->conn);//used for testing;
        $statement->close();
        return $affectedRows;
    }*/
	function insert($username, $password, $type){
        $this->conn=DBConnection::getConnection();
        $statement=$this->conn->prepare("INSERT INTO usuario(nombre,contrasena,tipo) VALUES(?,?,?)");
        $statement->bind_param("sss",$username,$password, $type);
        $statement->execute();
        $affectedRows=mysqli_affected_rows($this->conn);//used for testing;
        $statement->close();
        return $affectedRows;
    }
    
	function eliminar($username){
        $this->conn=DBConnection::getConnection();
        $statement=$this->conn->prepare("DELETE FROM usuario WHERE nombre = ?;");
        $statement->bind_param("s",$username);
        $statement->execute();
		$affectedRows=mysqli_affected_rows($this->conn);//used for testing;
        $statement->close();
        return $affectedRows;
    }
	
    function getType($username){
        $this->conn=DBConnection::getConnection();
        $statement=$this->conn->prepare("SELECT tipo FROM Usuario WHERE nombre = ?");
        $statement->bind_param("s",$username);
        $statement->execute();
        $statement->bind_result($type);
        $statement->fetch();
        $statement->close();
        //$this->conn->close();
        return $type;
    }
	
	function addMessages($name,$email,$consult){
		 
        $this->conn=DBConnection::getConnection();
        $statement=$this->conn->prepare("INSERT INTO mensaje(name,email,consulta) VALUES(?,?,?)");
		$statement->bind_param("sss",$name, $email, $consult);
        $statement->execute();
        $affectedRows=mysqli_affected_rows($this->conn);//used for testing;
        $statement->close();
        return $affectedRows;

    }
	
	function listarUsuarios(){
		 
        $this->conn=DBConnection::getConnection();
        $statement=$this->conn->prepare("SELECT nombre, tipo FROM Usuario");
        $statement->execute();
        $result = $statement->get_result();
        $listaUsr = array();
            while ($fila = $result->fetch_assoc()) {
                $listaUsr[] = $fila;
            }
		
        return $listaUsr;

    }
    
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
<?php
include 'DBConnection.php';
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
        $statement=$this->conn->prepare("SELECT tipo FROM Usuario WHERE nombre=? AND contrasena=?");
        $statement->bind_param("ss",$username,$password);
        $statement->execute();
        $result=$statement->get_result();
        $statement->close();
        //$this->conn->close();
        return $result->fetch_assoc();

    }
    
    function insert(){
        $statement=$this->conn->prepare("INSERT INTO Usuario VALUES(?, ?,?)");
        $statement->bind_param("sss",$this->username,$this->password, $this->type);
        $statement->execute();
        $statement->close();
        
        switch($this->type){
            case "concessionaire":
                $statement=$this->conn->prepare("INSERT INTO Concesionario VALUES(?)");
                $statement->bind_param("s",$this->username);
                $statement->execute();
                $statement->close();
                break;
            case "provider":
                $statement=$this->conn->prepare("INSERT INTO Proveedor VALUES(?)");
                $statement->bind_param("s",$this->username);
                $statement->execute();
                $statement->close();
                break;
        }
        //$this->conn->close();
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
}
?>
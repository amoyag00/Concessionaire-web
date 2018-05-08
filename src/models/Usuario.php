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
    
    function insert(){
        $this->conn=DBConnection::getConnection();
        $statement=$this->conn->prepare("INSERT INTO Usuario(nombre,contrasena,tipo) VALUES(?,?,?)");
        $statement->bind_param("sss",$this->username,$this->password, $this->type);
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
}
?>
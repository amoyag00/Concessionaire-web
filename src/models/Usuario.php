<?php
include 'DBConnection.php';
class Usuario{
    private $conn;
    
    function __construct(){
        $this->conn=DBConnection::getConnection();
    }
    function checkPassword($username, $password){
        $statement=$this->conn->prepare("SELECT * FROM Usuario WHERE nombre=? AND contrasena=?");
        $statement->bind_param("ss",$username,$password);
        $statement->execute();
        $result=$statement->get_result();
        $statement->close();
        return $result->num_rows==1;
    }
    
    function insert($username, $password, $concessionaire){
        $statement=$this->conn->prepare("INSERT INTO Usuario VALUES(?, ?,?)");
        $statement->bind_param("sss",$username,$password, $concessionaire);
        $statement->execute();
        $statement->close();
    }
    
    function getType($username){
        $statement=$this->conn->prepare("SELECT tipo FROM Usuario WHERE nombre=?");
        $statement->bind_param("s",$username);
        $statement->execute();
        $statement->bind_result($type);
        $statement->fetch();
        $statement->close();
        return $type;
    }
}
?>
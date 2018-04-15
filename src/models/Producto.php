<?php
include 'DBConnection.php';
$p=new Producto();
 $p->filter("motor");
class Producto{
    private $conn;
    
    function __construct(){
        $this->conn=DBConnection::getConnection();
    }
    
    function filter($pattern){
        $statement=$this->conn->prepare("SELECT * FROM Producto WHERE nombre LIKE ?");
        $regexp="%".$pattern."%";
        $statement->bind_param("s",$regexp);
        $statement->execute();
        $result=$statement->get_result();
        $result->fetch();
        
        $statement->close();
        return $result;
    }
    
    function insert($username, $password, $concessionaire){
        $statement=$this->conn->prepare("INSERT INTO Usuario VALUES(?, ?,?)");
        $statement->bind_param("sss",$username,$password, $concessionaire);
        $statement->execute();
        $statement->close();
    }
    
}

?>

<?php
namespace Login;
include 'models/Usuario.php';
use \Models\Usuario as Usuario;

if( isset($_POST["user"]) && isset($_POST["password"]) ){
    $user = FILTER_VAR($_POST["user"],FILTER_SANITIZE_STRING);
    $pass = FILTER_VAR($_POST["password"],FILTER_SANITIZE_STRING);
    $u = new Usuario();
    $result=$u->checkPassword($user,$pass);
    
    if(!empty($result["tipo"]) && $result["logged"]===0 && $result["bloqueado"]===0){
        session_start();
        session_regenerate_id();
        $_SESSION["user"]=$user;
        $_SESSION["type"]=$result["tipo"];
        $u->login($user);
       
        if($_SESSION["type"]=="provider"){
            header("Location: providerHome.php");
        }else if($_SESSION["type"]=="concessionaire"){
            header("Location: concessionaireHome.php");
        }else if($_SESSION["type"]=="administrator"){
			header("Location: adminHome.php");
        }
    }else{
        header("Location: index.html");
    }
    
}else{
    header("Location: index.html");
}


?>

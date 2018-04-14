<?php
include 'models/Usuario.php';
if( isset($_POST["user"]) && isset($_POST["password"]) ){
    $user = FILTER_VAR($_POST["user"],FILTER_SANITIZE_STRING);
    $pass = FILTER_VAR($_POST["password"],FILTER_SANITIZE_STRING);
    $u = new Usuario();
    if($u->checkPassword($user,$pass)){
        session_start();
        session_regenerate_id();
        $_SESSION["user"]=$user;
        $_SESSION["type"]=$u->getType($user);
       
        if($_SESSION["type"]=="provider"){

        }else if($_SESSION["type"]=="concessionaire"){
            header("Location: concessionaireHome.php");
        }else if($_SESSION["type"]=="admin"){

        }
    }else{
        header("Location: index.html");
    }
    
}else{
    header("Location: index.html");
}


?>
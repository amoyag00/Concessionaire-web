<?php
if( isset($_POST["user"]) && isset($_POST["password"]) ){
    $user = $_POST["user"];
    $pass = $_POST["password"];
    //go to data base
    session_start();
    session_regenerate_id();
    $_SESSION["user"]=$user;
    //$_SESSION["type"]=type;
    
    /* if(userType=="provider"){
        
    }else if(userType=="concessionaire"){
        
    }else if(userType=="admin"){
        
    } */
}else{
    header("Location: login.html");
}

?>
<?php
session_start();
if( !isset($_SESSION["type"]) || $_SESSION["type"]!="provider"){
    header("Location: login.html");
    exit();
}

?>
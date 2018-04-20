<?php
namespace Is;
session_start();
if( !isset($_SESSION["type"]) || $_SESSION["type"]!="concessionaire"){
    header("Location: index.html");
    exit();
}

?>
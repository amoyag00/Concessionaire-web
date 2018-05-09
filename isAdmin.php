<?php
namespace Is;
session_start();
if( !isset($_SESSION["type"]) || $_SESSION["type"]!="administrator"){
    header("Location: index.html");
    exit();
}

?>
<?php
session_start();
if( !isset($_SESSION["type"]) || $_SESSION["type"]!="admin"){
    header("Location: index.html");
    exit();
}

?>
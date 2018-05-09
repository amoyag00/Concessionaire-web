<?php

namespace Is;
session_start();
if( !isset($_SESSION["user"])){
    header("Location: index.html");
    exit();
}


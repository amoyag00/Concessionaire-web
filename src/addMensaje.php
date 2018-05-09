<?php
namespace Mensaje;
include 'models/Usuario.php';
use \Models\Usuario as Usuario;

if(isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["consulta"]) ){

	$name = FILTER_VAR($_POST["name"],FILTER_SANITIZE_STRING);
    $email = FILTER_VAR($_POST["email"],FILTER_SANITIZE_STRING);
    $consult = FILTER_VAR($_POST["consulta"],FILTER_SANITIZE_STRING);

	$u = new Usuario();

	$u->addMessages($name,$email, $consult);
	
	header("Location:contacto.php");
	
}else{
	
	header("Location:contacto.php");
	
}
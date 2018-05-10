<?php
namespace Administrator;
    require_once 'isAdmin.php';
	require_once 'models/Usuario.php';

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Administrator</title>
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css"/>
        <link href="https://fonts.googleapis.com/css?family=Orbitron|Economica|Gugi" rel="stylesheet"/> 
        <link rel="icon" type="image/png" href="img/logo.png"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="adminScript.js"></script> 
    </head>
	
	<body id="body-admin">
		<header>
            <?php
            require_once 'header.php';
            ?>
        </header>
		<select id='filterMsj'>
						<option value='todos'>Todos</option>
						<option value='noLeidos'>No Leidos</option>     
		</select>
	<button class="log-out" value="out">Log out</button>
	
		<nav id="admin-nav">
			<button type="button" id="gestion" disabled="">Gestionar Usuarios</button>
			<button type="button" id="mensajes">Mensajes</button>
		</nav>
	
	
	
		<div id="main-div">
			
			
		</div>
	</body>
    <footer>
        <?php
            require_once 'footer.php';
        ?>
    </footer>
</html>
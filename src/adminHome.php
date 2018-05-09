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
	<button class="log-out" value="out">Log out</button>
		<nav id="admin-nav">
			<button type="button" id="gestion" disabled="">Gestionar Usuarios</button>
			<button type="button" id="mensajes">Mensajes</button>
		</nav>
	
		<div id="main-div">
			
			<!--<div id="gestion-div">-->
				 <form action="" method="post" class="anyadir-user">
					<div id="row">
						<h1 class="anyadir-user">Añadir Usuario</h1>
					</div>
					
					<div id="row">
						<label class="anyadir-user">Nombre de usuario</label>
						<input type="text" name="Nombre de Usuario" placeholder="Usuario" class="anyadir-user"/>
					</div>
					
					<div id="row">
						<div id="row">
							<label class="anyadir-user">Tipo de usuario</label>
						</div>
						<div id="row">	
									
									<input type="radio" id="column" value="concessionaire" name="tipo" class="anyadir-user"/><a class="anyadir-user">Concesionario</a>
									</div><div id="row">	
									<input type="radio" id="column" value="provider" name="tipo" class="anyadir-user"/><a class="anyadir-user">Proveedor</a>
								
								
						</div>		
							
						
					</div>
					
					<div id="row">
						<label class="anyadir-user">Introduce una contraseña</label>					
						<input type="password" id="password" name="Contraseña" placeholder="Contraseña" class="anyadir-user"/>
					</div>
					
					<!--<div id="row">
						<label class="anyadir-user">Repite la contraseña</label>
						<input type="password" name="Repetir contraseña" placeholder="Contraseña" class="anyadir-user"/>
					</div>-->
					
					<div id="row">
						<button value="Añadir usuario" class="anyadir-user" id="anyadir-user">Añadir usuario</button> 
					</div>
                    
				</form>
			
				
				 <form action="" method="post" class="delete-user">
					<div id="row">
						<h1 class="delete-user">Eliminar Usuario</h1>
					</div>
					
					<div id="row">
						<label class="delete-user">Nombre de usuario</label>
						<input type="text" name="Nombre de Usuario" placeholder="Usuario" class="delete-user"/>
					</div>
					
					<!--<div id="row">
						<div id="row">
							<label class="delete-user">Tipo de usuario</label>
						</div>
						<div id="row">	
									
									<input type="radio" id="column" value="concessionaire" name="tipo" class="delete-user"/><a class="delete-user">Concesionario</a>
									</div><div id="row">	
									<input type="radio" id="column" value="provider" name="tipo" class="delete-user"/><a class="delete-user">Proveedor</a>
								
								
						</div>		
							
						
					</div>-->
					
					<div id="row">
						<button value="Eliminar usuario" class="delete-user" id="delete-user">Eliminar usuario</button> 
					</div>
                    
				</form>
				
				
				 <form action="" method="post" class="expulsar-user">
					<div id="row">
						<h1 class="expulsar-user">Expulsar Usuario</h1>
					</div>
					
					<div id="row">
						<label class="expulsar-user">Nombre de usuario</label>
						<input type="text" name="Nombre de Usuario" placeholder="Usuario" class="expulsar-user"/>
					</div>
					
					<!--<div id="row">
						<div id="row">
							<label class="expulsar-user">Tipo de usuario</label>
						</div>
						<div id="row">	
									
									<input type="radio" id="column" value="concessionaire" name="tipo" class="expulsar-user"/><a class="expulsar-user">Concesionario</a>
									</div><div id="row">	
									<input type="radio" id="column" value="provider" name="tipo" class="expulsar-user"/><a class="expulsar-user">Proveedor</a>
								
								
						</div>		
							
						
					</div>-->
					
					<div id="row">
						<button value="Expulsar usuario" class="expulsar-user" id="expulsar-user">Expulsar usuario</button> 
					</div>
                    
				</form>
			
			<!--</div>-->
		</div>
	</body>
    <footer>
        <?php
            require_once 'footer.php';
        ?>
    </footer>
</html>
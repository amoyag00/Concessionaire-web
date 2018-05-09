<?php 
namespace contact;
?>
<!Doctype html>
<html>
    <head>
        <title>Contacto</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css"/>
        <link href="https://fonts.googleapis.com/css?family=Orbitron|Economica|Gugi" rel="stylesheet"> 
        <link rel="icon" type="image/png" href="img/logo.png">
    </head>
    <header>
        <?php
            require_once 'header.php';
        ?>
    </header>
    <body  id="contact-body">
        
        <div id="contact-div">
            <h1 class="contact">Envíanos tus consultas</h1>
            <form action="addMensaje.php" method="post" class="contact">
                <input type="text" name="name" placeholder="Nombre" class="contact"/>
                <input type="text" name="email" placeholder="Email" class="contact"/>
                <textarea name="consulta" placeholder="Escribe tu consulta" class="contact"></textarea>
                <input type="submit" name="send" value="Enviar" class="contact"/>
            </form>
        </div>
    </body>
    <footer>
        <?php
            require_once 'footer.php';
        ?>
    </footer>
</html>



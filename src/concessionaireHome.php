<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Concessionaire</title>
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css"/>
        <link href="https://fonts.googleapis.com/css?family=Orbitron|Economica|Gugi" rel="stylesheet"/> 
        <link rel="icon" type="image/png" href="img/logo.png"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="script.js"></script> 
    </head>
    
    <body id="body-conc">
        <header>
            <?php
            require_once 'header.php';
            ?>
        </header>
        <div id="search-cart">
            <button id="cart" src="img/cart.png"><span>2</span></button>
            <input type="text" id="search" placeholder="buscar" />
        </div>
       
        <nav id="conc-nav">
            <button type="button" id="mis-pedidos">Mis pedidos</button>
            <button type="button" id="realizar-pedido">Realizar pedido</button>
        </nav>
         <div id="productos-pedidos">
            <div class="producto" id="1">
                <span>nombre producto</span>
                Cantidad<input type="number"/>
                <span>precio €</span>
                <button type="button" class="pedido-button"> Añadir al carro</button>
            </div>
        </div>
    </body>
    <footer>
        <?php
            require_once 'footer.php';
        ?>
    </footer>
</html>

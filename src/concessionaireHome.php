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
            <button id="cart" src="img/cart.png"><span>0</span></button>
            <select id="filter">
                <option value="date">Fecha</option>
                <option value="provider">Proveedor</option>
                <option value="producto">Producto</option>
                
            </select>
            <input type="text" id="search" placeholder="Filtrar" />
            <div id="dropdown">
                <table id="dropdown-table">
                    <tr id="header-row">
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>Total: </td>
                        <td id="total-price"></td>
                        
                    </tr>
                       
                </table>
                
                
                <button id="pedir">Realizar pedido</button>
            </div>
        </div>
       
        <nav id="conc-nav">
            <button type="button" id="mis-pedidos">Mis pedidos</button>
            <button type="button" id="realizar-pedido">Realizar pedido</button>
        </nav>
         <div id="productos-pedidos">
            
        </div>
    </body>
    <footer>
        <?php
            require_once 'footer.php';
        ?>
    </footer>
</html>

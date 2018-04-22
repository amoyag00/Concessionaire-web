<?php
namespace Concessionaire;
    require_once 'isConcessionaire.php';
    require_once 'models/Pedido.php';
    require_once 'models/Producto.php';
?>
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
            <button id="ver-todo">Ver todo</button>
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
            <button type="button" id="mis-pedidos-button" disabled="">Mis pedidos</button>
            <button type="button" id="realizar-pedido-button">Realizar pedido</button>
        </nav>
        
        <div id="main-div">
             <?php
            
            $pedidos = \Models\Pedido::listPedidosOfConc($_SESSION["user"]);
            if(count($pedidos)>0){ 
                $total=0;
                foreach($pedidos as $pedido){ ?>
                    <table class='pedido'>
                        <tr>
                            <th><?php echo "Pedido ID: ".$pedido["pedido_id"] ?></th>
                            <th><?php echo "Fecha: ".$pedido["fecha"]?></th>
                        </tr>
                        <tr>
                            <th>Producto</th>
                            <th>Proveedor</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Estado</th>
                            
                        </tr>
                        <tr>
                            <td><?php ?></td>
                            <td><?php ?></td>
                            <td><?php ?></td>
                            <td><?php ?></td>
                            
                        </tr>
                        <tr>
                            <td id='total-price'> <?php echo "Total: ".$total." €" ?></td>
                        </tr>
                    </table>
          <?php }             
            } ?>
                  
        </div>
    </body>
    <footer>
        <?php
            require_once 'footer.php';
        ?>
    </footer>
</html>

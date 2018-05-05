<?php
namespace Concessionaire;
    require_once 'isConcessionaire.php';
    require_once 'models/Pedido.php';
    require_once 'models/Producto.php';
    require_once 'models/ListaProductos.php';
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
	<script src="concessionaireHome.js"></script> 
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
                <option value="Proveedor">Proveedor</option>
                <option value="Fecha">Fecha</option>
                <option value="Producto">Producto</option>
                
            </select>
            <select id="fecha-filter">
                <option value="Previo">Previo a</option>
                <option value="Posterior">Posterior a</option>
                <option value="Exacta">Fecha exacta</option>        
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
            <button type="button" id="mis-pedidos-button" >Mis pedidos</button>
            <button type="button" id="realizar-pedido-button">Realizar pedido</button>
        </nav>
        
        <div id="main-div">
             <!-- <?php
            $pedidos=\Models\Pedido::listPedidosOfConc($_SESSION["user"]);
            foreach($pedidos as $pedido){
                $pedido->listaProductos=\Models\ListaProductos::getListaProd($pedido->pedido_id);
            }

            if(count($pedidos)>0){ 
                $totalMoney=0;
                $allUnconfirmed=true;
                $saveChanges=false;
                foreach($pedidos as $pedido){
                    $totalMoney=0;
                    $allUnconfirmed=true;
                    ?> <table class='pedido' id='<?php echo $pedido->pedido_id ?>'>
                                    <tr>
                                        <th>Pedido ID: <?php echo $pedido->pedido_id ?> </th>
                                        <th>Fecha: <?php echo $pedido->fecha ?></th>
                                    </tr>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Proveedor</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Estado</th>
                                        <th></th>
                                    </tr>
                    <?php $listaProductos=$pedido->listaProductos;
                    foreach($listaProductos as $producto){ ?>
                        <tr>
                            <td> <?php echo $producto["nombre"] ?></td>
                            <td><?php  echo $producto["nombrePro"] ?></td>
                            <td><?php echo $producto["precio"] ?></td>

                    <?php  if($producto["estado"]===1){ ?>
                            <td> <?php echo $producto["cantidad"] ?></td>
                            <td> Confirmado </td>
                            <?php   $allUnconfirmed=false;
                        }else{ ?>
                            <td><input type='number' value=<?php echo $producto["cantidad"] ?> min='1' class='product-quantity'/></td>
                            <td> Sin confirmar </td>
                            <td><button id='<?php echo $pedido->pedido_id ?>' class='pedido-delete'>X</button></td>
                           <?php  $saveChanges=true;
                        } ?>
                        </tr>
                        <?php $totalMoney+=$producto["precio"];              

                    }
                    if($allUnconfirmed){ ?>
                        <tr><td><button class=delete-all-pedido>Eliminar pedido</button></td></tr>

              <?php }
                    if($saveChanges){ ?>
                        <tr><td><button class='save-changes'>Save changes</button></td></tr>
             <?php  } ?>
                    <tr><td> Total:<?php echo $totalMoney ?>€</td></tr></table>
             <?php  }
            }
                ?>  -->
        </div>
    </body>
    <footer>
        <?php
            require_once 'footer.php';
        ?>
    </footer>
</html>

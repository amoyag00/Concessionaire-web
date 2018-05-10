<?php
namespace Provider;
require_once 'isProvider.php';
require_once 'models/Pedido.php';
require_once 'models/Producto.php';

use \Models\Pedido as Pedido;
use \Models\Producto as Producto;
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="https://fonts.googleapis.com/css?family=Orbitron|Economica|Gugi" rel="stylesheet"/> 
        <link rel="icon" type="image/png" href="img/logo.png"/>
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="providerHome.js"></script>
    </head>
    <body id="body-prov">
        <header>
            <?php
            require_once 'header.php';
            ?>
        </header>
        
        <section>
            
            <button class="log-out" value="out">Log out</button>
            
            <div id="lists">
                <h2>Listas</h2>
                
                <input id="all" type="radio" name="filtro" checked="true" class="list-filter">
                <label for="all">Ver todos</label>
                
                <input id="not-confirmed" type="radio" name="filtro" class="list-filter">
                <label for="not-confirmed">Ver no confirmados</label>
                
                <button class="desplegable" value="Lista de pedidos" id="pedidos">Lista de pedidos</button>
                <div class="panel-lista" id="lista-pedidos">
                </div>
                
                <button class="desplegable" value="Lista de productos" id="productos">Lista de productos</button>
                <div class="panel-lista" id="lista-productos">
                    <table id="tabla-productos">
                        <tr>
                            <th scope="col" class="cabecera-producto">Identificador</th>
                            <th scope="col" class="cabecera-producto">Nombre</th>
                            <th scope="col" class="cabecera-producto">Precio</th>
                            <th scope="col" class="cabecera-producto">Disponibilidad</th>
                        </tr>
                    <?php
                        $lista = Producto::getListaProductosProveedor($_SESSION["user"]);
                        
                        for($i=0;$i<sizeof($lista);$i++){ 
                            $producto = $lista[$i] ?>
                            <tr>
                            <?php
                                for($j=0;$j<sizeof($producto);$j++){ ?>
                                    <td class="celda-producto">
                                    <?php 
                                        if($j==0){
                                            echo $producto["producto_id"];
                                        }
                                        else if($j==1){
                                            echo $producto["nombre"];
                                        }
                                        else if($j==2){
                                            echo $producto["precio"];
                                        }
                                        else{
                                            if($producto["disponible"]){
                                                echo "Producto disponible";
                                            }
                                            else{
                                                echo "Producto de baja";
                                            }
                                        } ?>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
                
                <div id="file">
                    <h2>Actualizar productos</h2>
                    
                    <form method="POST" action="actualizarProductos.php" enctype="multipart/form-data">
                        <label>Seleccionar archivo XML</label>
                        <input type="file" name="archivo" class="input-file">
                        <input type="submit" name="actualizar" value="Actualizar" class="input-file">
                    </form>
                </div>
            
        </section>
        
        <footer>
            <?php
            require_once 'footer.php';
            ?>
        </footer>
    </body>
</html>

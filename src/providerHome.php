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
            
            <div id="lists">
                <h2>Listas</h2>
                
                <input id="all" type="radio" name="filtro" checked="true">
                <label for="all">Ver todos</label>
                
                <input id="not-confirmed" type="radio" name="filtro">
                <label for="not-confirmed">Ver no confirmados</label>
                
                <button class="desplegable" value="Lista de pedidos">Lsta de pedidos</button>
                <div class="panel-lista">
                    <label>Lista de pedidos</label>
                </div>
                
                <button class="desplegable" value="Lista de productos">Lista de productos</button>
                <div class="panel-lista">
                    <table id="tabla-productos">
                        <tr>
                            <td scope="col">Identificador</td>
                            <td scope="col">Nombre</td>
                            <td scope="col">Disponibilidad</td>
                        </tr>
                    <?php
                        error_reporting(E_ALL);
                        ini_set('display_errors', 1);
                        require_once 'models/Producto.php';
                        session_start();
                        session_regenerate_id();
                        $lista = \Models\Producto::getListaProductosProveedor($_SESSION["user"]);
                        
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
                                        else{
                                            if($producto["disponible"]){
                                                echo "Producto disponible";
                                            }
                                            else{
                                                echo "Producto agotado";
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

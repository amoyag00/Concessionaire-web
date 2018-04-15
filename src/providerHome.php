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
                
                <button class="desplegable" value="Lista de productos">Lista de productos</button>
                <div class="panel-lista">
                    <label>Lista de productos</label>
                </div>

                <button class="desplegable" value="Lista de pedidos">Lista de pedidos</button>
                <div class="panel-lista">
                    <label>Lista de pedidos</label>
                </div>
            </div>
                
                <div id="file">
                    <h2>Actualizar productos</h2>
                    
                    <label>Seleccionar archivo XML</label>
                    <input type="file" name="archivo" class="input-file">
                    <input type="submit" name="actualizar" value="Actualizar" class="input-file">
                </div>
            
        </section>
        
        <footer>
            <?php
            require_once 'footer.php';
            ?>
        </footer>
    </body>
</html>

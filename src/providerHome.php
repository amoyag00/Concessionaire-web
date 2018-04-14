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
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="providerHome.js"></script>
    </head>
    <body id="body-conc">
        <header>
            <?php
            require_once 'header.php';
            ?>
        </header>
        
        <section>
            <button class="desplegable" value="Lista de productos">Lista de productos</button>
            <div class="panel-lista">
                <label>Lista de productos</label>
            </div>
            
            <button class="desplegable" value="Lista de pedidos">Lista de pedidos</button>
            <div class="panel-lista">
                <label>Lista de pedidos</label>
            </div>
        </section>
        
        <footer>
            <?php
            require_once 'footer.php';
            ?>
        </footer>
    </body>
</html>

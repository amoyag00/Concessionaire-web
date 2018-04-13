$(document).ready(function(){
     $('#realizar-pedido').on("click",pedidoHandler);
    
});

function pedidoHandler(){
   $('#cart').css('visibility','visible');
}

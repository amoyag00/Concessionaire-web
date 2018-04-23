$(document).ready(function(){
     $('#realizar-pedido-button').on("click",realizarPedidoHandler);
     $('#cart').on("click",showDropdown);
     $('#main-div').on("click",".add-cart",addToCart);
     $('#dropdown-table').on("click",".delete-button",deleteFromCart);
     $('#mis-pedidos-button').on("click",misPedidosHandler);
     $('#ver-todo').on("click",verTodoHandler);
     $('#pedir').on("click",registrarPedido);
     $('#search').keypress(filter);
});

var cartItems=new Array();
var searchedItems=new Array();
var currentPrice=0.0;



function purchasedItem(id, quantity){
    this.id=id;
    this.quantity=quantity;
}

function item(id, name, features, price, provider){
    this.id=id;
    this.name=name;
    this.features=features;
    this.price=price;
    this.provider=provider;
}

function showDropdown(){
    if($('#dropdown').css("display")==="block"){
        $('#dropdown').css("display","none");
    }else{
        $('#dropdown').css("display","block");
    }

}

function addToCart(){
    var id=$(this).parent().attr('id');
    var item=getItemOfId(id, searchedItems);
    var name=item.name;
    var quantity=$(this).prevAll().eq(1).val();
    var price=item.price;
    
   
     currentPrice+=price*quantity;
    $('#dropdown-table #total-price').html(currentPrice+" €");
     var auxItem=getItemOfId(id,cartItems);
    if(auxItem!==null){
        auxItem.quantity=parseInt(auxItem.quantity)+parseInt(quantity);
        $("#"+id).parent().prev().html(auxItem.quantity);
    }else{
         $('#dropdown-table #header-row').after(
            ' <tr>'+
                    '<td>'+name+'</td>'+
                    '<td>'+price+'€</td>'+
                    '<td>'+quantity+'</td>'+
                    '<td><button id='+id+' class="delete-button">X</button></td>'+
                    '</tr>');
       cartItems.push(new purchasedItem(id, quantity)); 
    }
    
    $('#cart span').text(cartItems.length);
    
}

function deleteFromCart(){
    var id=$(this).attr("id");
    var purchasedItem=getItemOfId(id,cartItems);
    var quantity=purchasedItem.quantity;
    var price=getItemOfId(id,searchedItems).price;
   $(this).parent().parent().remove();
    for (var i=0;i<cartItems.length;i++){
        if(cartItems[i].id===id){
            cartItems.splice(i,1);
        }
    }
    currentPrice-=price*quantity;
    $('#dropdown-table #total-price').html(currentPrice + "€");
     $('#cart span').text(cartItems.length);
}

function getItemOfId(id, array){
    for (var i=0;i<array.length;i++){
        if(array[i].id==id){/* dont add another = */
            
            return array[i];
        }
    }
    return null;
}


function misPedidosHandler(){
    $('#cart').css('visibility','hidden');
    $('#filter').css('visibility','visible');
    $('#dropdown').css("display","none");
    $("#main-div").empty();
    //Buttons
    $(this).prop("disabled",true);
    $('#realizar-pedido-button').prop("disabled",false);
    //Content
    peticionAjax("Peticiones.php","data="+JSON.stringify({"peticion":"listarPedidos"}),showPedidos);
}
 
function showPedidos(data){
    var pedidos=JSON.parse(data);
    for(var i=0;i<pedidos.length;i++){
        var tabla="<table class='pedido'>"+
                        "<tr>"+
                            "<th>Pedido ID: "+pedidos[i].pedido_id +"</th>"+
                            "<th>Fecha: "+pedidos[i].fecha +"</th>"+
                        "</tr>"+
                        "<tr>" +
                            "<th>Producto</th>" +
                            "<th>Proveedor</th>" +
                            "<th>Precio</th>" +
                            "<th>Cantidad</th>" +
                            "<th>Estado</th>" +
                            "<th></th>" +
                        "</tr>";
                        
        /*for(var j=0;j<listaproducos.length;j++){
             tabla+="<tr>"+
            "<td>Motor g324</td>" +
            "<td>Tesla</td>" +
            "<td>5 €</td>" +
            "<td>2</td>" +
            "<td>Sin confirmar</td>" +
            "</tr>";
        }*/
         
        tabla+="<tr>"+
                        "<td>Total: "+"€</td>" +
                        "</tr>" +
                        "</table>";
        $('#main-div').append(tabla);   
    }

}

function realizarPedidoHandler(){
   $('#cart').css('visibility','visible');
   $('#filter').css('visibility','hidden');
   //Buttons
   $(this).prop("disabled",true);
   $('#mis-pedidos-button').prop("disabled",false);
    //Content
    $("#main-div").empty();
    peticionAjax("Peticiones.php","data="+JSON.stringify({"peticion":"listarProductos"}),showProductos);
}

function showProductos(data){
    var productos=JSON.parse(data);
    for(var i=0;i<productos.length;i++){
        var producto_id = productos[i].producto_id;
        var nombre = productos[i].nombre;
        var nombrePro = productos[i].nombrePro;
        var precio = productos[i].precio;
        var caracteristicas =productos[i].caracteristicas;
        searchedItems.push(new item(producto_id, nombre, caracteristicas, precio, nombrePro));
        var producto = "<div class='producto' id=" + producto_id + ">" +
                "<span class='product-name'>" + nombre + "</span>" +
                "<span class='provider-name'>" + "<b>Proveedor: </b>" + nombrePro + "</span>" +
                "<span class='features'>" + "<b>Caracteristicas: </b>" + caracteristicas + "</span>" +
                "<b>Cantidad: </b><input type='number' value='1'min='1' class='product-quantity'/>" +
                "<span class='product-price'>" + "<b>€/unidad: </b>" + precio + "</span>" +
                "<button type='button' class='add-cart'> Añadir al carro</button></div>";

        $('#main-div').append(producto);
         
    }
   
}

function peticionAjax(script, data, callback){
    var request= new XMLHttpRequest();
    request.onreadystatechange= function(){
        if(this.readyState==4 && this.status==200){
            if(callback!=null){
                callback(this.responseText);
            }
        }
    };
    request.open("POST",script,true);//method script async
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(data);
}

function verTodoHandler(){
    $("#main-div").empty();
    if($('#mis-pedidos-button').is(':disabled')){
        peticionAjax("Peticiones.php","data="+JSON.stringify({"peticion":"listarPedidos"}),showPedidos);
    }else{
        peticionAjax("Peticiones.php","data="+JSON.stringify({"peticion":"listarProductos"}),showProductos);
    }
}

function registrarPedido(){
    if(cartItems.length===0){
        alert("No ha añadido productos al pedido");
    }else{
        peticionAjax("Peticiones.php","data="+JSON.stringify({"peticion":"registrarPedido"}),showPedidos);
    }
    
}

function filter(event){
    if(event.which==13){ //enter
       $("#main-div").empty();
        if($('#mis-pedidos-button').is(':disabled')){
            var param=$('#filter').val();
            var filter=$('#search').val();
            peticionAjax("Peticiones.php","data="+JSON.stringify({"peticion":"filtrarPedidos","param":param,"filter":filter}),showPedidos);
        }else{
            peticionAjax("Producto.php","data="+JSON.stringify({"peticion":"listarProductos"}),showProductos);
        } 
    }
    
}




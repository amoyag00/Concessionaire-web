$(document).ready(function(){
     $('#realizar-pedido').on("click",pedidoHandler);
     $('#cart').on("click",showDropdown);
     $('#productos-pedidos').on("click",".add-cart",addToCart);
     $('#dropdown-table').on("click",".delete-button",deleteFromCart);
     $('#mis-pedidos').on("click",misPedidosHandler);
});

var cartItems=new Array();
var searchedItems=new Array();
searchedItems.push(new item(1,"g-34 motor","very good",5,"tesla"));
var currentPrice=0.0;

function pedidoHandler(){
   $('#cart').css('visibility','visible');
   $("#productos-pedidos").empty();
   $('#filter').css('visibility','hidden');
   $(this).prop("disabled",true);
   $('#mis-pedidos').prop("disabled",false);
   //quitar cuando haya bbdd
   $('#productos-pedidos').append("<div class='producto' id='1'>"+
                "<img src='img/logo.png' class='product-img'></img>"+
                "<span class='product-name'>g-34 motor</span>"+
                "Cantidad<input type='number' value='1'min='1' class='product-quantity'/>"+
                "<span class='product-price'>5 €</span>"+
                "<button type='button' class='add-cart'> Añadir al carro</button></div>");
}

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
    $('#dropdown').css("display","none");
    $("#productos-pedidos").empty();
    $('#filter').css('visibility','visible');
    $(this).prop("disabled",true);
    $('#realizar-pedido').prop("disabled",false);
    
    peticionAjax('Peticiones.php','data='+JSON.stringify({"peticion":"listarPedidos"}),showPedidos);
}
 
function showPedidos(data){
    alert('log');
    var pedidos=JSON.parse(data);
    
    for(var i=0;i<pedidos.length;i++){
        var tabla="<table class='pedido'>"+
                        "<tr>" +
                            "<th>Nombre</th>" +
                            "<th>Proveedor</th>" +
                            "<th>Precio</th>" +
                            "<th>Cantidad</th>" +
                            "<th>Estado</th>" +
                            "<th></th>" +
                        "</tr>"+
                        "<tr>"+
                            "<th><Pedido ID: "+pedidos[i].pedido_id +"></th>"+
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
                        "<td>Total: 10€</td>" +
                        "<td id='total-price'></td>" +
                        "</tr>" +
                        "</table>"
        $('#productos-pedidos').append(tabla);   
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
    //request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(data);
}




$(document).ready(function(){
     $('#realizar-pedido').on("click",pedidoHandler);
     $('#cart').on("click",showDropdown);
     $('.add-cart').on("click",addToCart);
     $('#dropdown-table').on("click",".delete-button",deleteFromCart);
     $('#mis-pedidos').on("click",misPedidosHandler);
});

var cartItems=new Array();
var searchedItems=new Array();
searchedItems.push(new item(1,"g-34 motor","very good",5,"tesla"));
var currentPrice=0.0;

function pedidoHandler(){
   $('#cart').css('visibility','visible');
   $('#filter').css('visibility','hidden');
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
    
    $('#dropdown-table #header-row').after(
            ' <tr>'+
                    '<td>'+name+'</td>'+
                    '<td>'+price+'€</td>'+
                    '<td>'+quantity+'</td>'+
                    '<td><button id='+id+' class="delete-button">X</button></td>'+
                    '</tr>');
     currentPrice+=price*quantity;
    $('#dropdown-table #total-price').html(currentPrice+" €");
    cartItems.push(new purchasedItem(id, quantity));
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
}


function misPedidosHandler(){
    $('#cart').css('visibility','hidden');
    $("#productos-pedidos").empty();
    $('#filter').css('visibility','visible');
    
}


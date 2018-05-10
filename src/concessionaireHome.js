$(document).ready(function(){
     $('#realizar-pedido-button').on("click",realizarPedidoHandler);
     $('#cart').on("click",showDropdown);
     $('#main-div').on("click",".add-cart",addToCart);
     $('#dropdown-table').on("click",".delete-button",deleteFromCart);
     $('#mis-pedidos-button').on("click",misPedidosHandler);
     $('#ver-todo').on("click",verTodoHandler);
     $('#pedir').on("click",registrarPedido);
     $('#main-div').on("click",".save-changes",updatePedido);
     $('#main-div').on("click",".pedido-delete",pedidoDeleteProduct);
     $('#main-div').on("click",".delete-all-pedido",deletePedido);
     $('#search').keypress(filter);
     $('#search-cart').on("change","#filter",comboBoxHandler);
     $('.log-out').on("click",logout);
});

var cartItems=new Array();
var searchedItems=new Array();
var listaPedidos=new Array();
var currentPrice=0.0;

function Pedido(id){
    this.id=id;
    this.allUnconfirmed=true;
    this.listaProductos=new Array();
    this.addProducto=function(producto){
        this.listaProductos.push(producto);
    };
}
function productoPedido(nombrePro, estado, cantidad,producto_id){
    this.nombrePro=nombrePro;
    this.estado=estado;
    this.cantidad=cantidad;
    this.id=producto_id;
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
    //$('#dropdown-table #total-price').html(currentPrice+" €");
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
    listaPedidos=[];
    var pedidos=JSON.parse(data);
    var totalMoney=0;
    var allUnconfirmed=true;
    for(var i=0;i<pedidos.length;i++){
        var ped=new Pedido(pedidos[i].pedido_id);
        listaPedidos.push(ped);
        totalMoney=0;
        allUnconfirmed=true;
        var tabla="<table class='pedido' id='"+pedidos[i].pedido_id+"'>"+
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
        var listaProductos=pedidos[i].listaProductos;
        for(var j=0;j<listaProductos.length;j++){
            var proPed=new productoPedido(listaProductos[j].nombrePro,listaProductos[j].estado,listaProductos[j].cantidad, listaProductos[j].producto_id );
            ped.addProducto(proPed);
            tabla+="<tr id='"+listaProductos[j].producto_id+"'>"+
                        "<td>"+listaProductos[j].nombre+"</td>"+
                        "<td>"+listaProductos[j].nombrePro+"</td>"+
                        "<td>"+listaProductos[j].precio+"</td>";
                
                        
            if(listaProductos[j].estado===1){
                tabla+= "<td>"+listaProductos[j].cantidad+"</td>";
                tabla+="<td> Confirmado </td>";
                allUnconfirmed=false;
                ped.allUnconfirmed=false;
            }else{
                tabla+="<td><input type='number' value="+listaProductos[j].cantidad+" min='1' class='product-quantity'/></td>";
                tabla+="<td> Sin confirmar </td>";
                tabla+='<td><button id='+pedidos[i].pedido_id+' class="pedido-delete">X</button>\n\
                <button class=save-changes>Save changes</button></td>';

            }
            tabla+="</tr>";
            totalMoney+=parseInt(listaProductos[j].precio)*parseInt(listaProductos[j].cantidad);             
                    
        }
        if(allUnconfirmed){
            tabla+="<tr><td><button class=delete-all-pedido>Eliminar pedido</button></td></tr>";  
        }
       
        tabla+="<tr><td> Total: "+totalMoney+"€</td></tr></table>";
        $('#main-div').append(tabla);  
                  
    }
    
}

function realizarPedidoHandler(){
   $('#cart').css('visibility','visible');
   $('#filter').css('visibility','hidden');
   $('#fecha-filter').css('visibility','hidden');
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
        peticionAjax("Peticiones.php","data="+JSON.stringify({"peticion":"registrarPedido","cart_items":cartItems}));
        
        $('#dropdown-table tbody').children( 'tr:not(:first)' ).remove();
        cartItems=[];
        $('#cart span').text(0);
    }
    
}

function filter(event){
    if(event.which==13){ //enter
       $("#main-div").empty();
        if($('#mis-pedidos-button').is(':disabled')){
            var param=$('#filter').val();
            var filter=$('#search').val();
            var fechaParam="null";
            if(param==='Fecha'){
                fechaParam=$('#fecha-filter').val();
            }
            peticionAjax("Peticiones.php","data="+JSON.stringify({"peticion":"filtrarPedidos","param":param,"filter":filter,"fechaParam":fechaParam}),showPedidos);
        }else{
          var filter=$('#search').val();
          peticionAjax("Peticiones.php","data="+JSON.stringify({"peticion":"filtrarProductos","filter":filter}),showProductos);
        } 
    }
}

function updatePedido(){
    var pedido_id=$(this).parent().parent().parent().parent().attr('id');
    var producto_id=$(this).parent().parent().attr('id');
    var cantidad=$("table#"+pedido_id+" tr#"+producto_id+" input").val();
    
    
    var pedido=getItemOfId(pedido_id,listaPedidos);
    var producto=getItemOfId(producto_id,pedido.listaProductos);
    var estado=producto.estado;

    if(estado===0){
        $('#cart').css('visibility','hidden');
        $('#filter').css('visibility','visible');
        $('#dropdown').css("display","none");
        $("#main-div").empty();
        peticionAjax("Peticiones.php","data="+JSON.stringify({"peticion":"updateProducto","pedido_id":pedido_id,"cantidad":cantidad,"producto_id":producto_id}), showPedidos);
    }
    
}

function pedidoDeleteProduct(){
    var pedido_id=$(this).parent().parent().parent().parent().attr('id');
    var producto_id=$(this).parent().parent().attr('id');
    
    var pedido=getItemOfId(pedido_id,listaPedidos);
    var producto=getItemOfId(producto_id,pedido.listaProductos);
    var estado=producto.estado;
    if(estado===0){
        $('#cart').css('visibility','hidden');
        $('#filter').css('visibility','visible');
        $('#dropdown').css("display","none");
        $("#main-div").empty();
        peticionAjax("Peticiones.php","data="+JSON.stringify({"peticion":"deleteProductoPedido","pedido_id":pedido_id,"producto_id":producto_id}), showPedidos);
    }
    
}
function deletePedido(){
    var pedido_id=$(this).parent().parent().parent().parent().attr('id');
  
    var pedido=getItemOfId(pedido_id,listaPedidos);
    if(pedido.allUnconfirmed){
        $('#cart').css('visibility','hidden');
        $('#filter').css('visibility','visible');
        $('#dropdown').css("display","none");
        $("#main-div").empty();
        peticionAjax("Peticiones.php","data="+JSON.stringify({"peticion":"deletePedido","pedido_id":pedido_id}), showPedidos);
    }
    
}

function comboBoxHandler(){
    if($('#filter').val()==='Fecha'){
        $('#fecha-filter').css('visibility','visible');
    }else{
         $('#fecha-filter').css('visibility','hidden');
    }
}

function logout(){
    peticionAjax("Peticiones.php","data="+JSON.stringify({"peticion":"logout"}),goIndex);
    
}
function goIndex(){
    document.location.href = "index.html";
}





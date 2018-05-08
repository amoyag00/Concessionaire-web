/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    $(".desplegable").click(function(){
        var panel = $(this).next();
        //alert($(panel).css("display"));
        $(this).toggleClass("active");
        /*if($(panel).css("display") === "block"){
            $(panel).css("display","none");
        }
        else{
            $(panel).css("display","block");
        }*/
        //alert(panel.style.maxHeight);
        if($(panel).css("display") === "none"){
            $(panel).show(500);
        }
        else{
            $(panel).hide(500);
        }
    });
    
    $("#pedidos").click(function(){
        if($("#all").is(":checked")){
        //alert(JSON.stringify({"peticion":"listaPedidosCompleta"}));
            ajaxRequest("data="+JSON.stringify({"peticion":"listaPedidosCompleta"}) ,"Peticiones.php");
        }
        else{
            ajaxRequest("data="+JSON.stringify({"peticion":"listaNoConfirmados"}) ,"Peticiones.php");
        }
    });

    $(".list-filter").on("change", filterHandler);
    
    $(document).on("click", ".confirm", confirmation);
    
    /*$(".confirmed-filter").click(function(){
        ajaxRequest("data="+JSON.stringify({"peticion":"listaNoConfirmados"}) ,"Peticiones.php");
    });*/
});

function confirmation(){
    var pedido = $(this).parent().parent().parent().children(":first");
    var producto = $(this).parent().parent();
    var all;
        
    if($("#all").is(":checked")){
        //alert(JSON.stringify({"peticion":"listaPedidosCompleta"}));
        all = 1;
    }
    else{
        all = 0;
    }

    var idPedido = $(pedido).children(":first").text().substring(2);
    /*alert(parseInt(idPedido));
    alert($(producto).children(":first").text());
    alert(all);*/

    ajaxRequest("data="+JSON.stringify({"peticion":"confirm", "pedido": parseInt(idPedido), "producto": $(producto).children(":first").text(), "all": all }), "Peticiones.php"); 
}

function filterHandler(){
    /*alert($("#all").attr("checked"));
    alert($("#not-confirmed").attr("checked"));*/
    if($("#all").is(":checked")){
        //alert(JSON.stringify({"peticion":"listaPedidosCompleta"}));
        ajaxRequest("data="+JSON.stringify({"peticion":"listaPedidosCompleta"}) ,"Peticiones.php");
    }
    else{
        ajaxRequest("data="+JSON.stringify({"peticion":"listaNoConfirmados"}) ,"Peticiones.php");
    }
}

function tablaPedidos(respuesta){
    //console.log(respuesta);
    var listaPedidos = JSON.parse(respuesta);
    var contenido = "";
    
    for(i=0;i<listaPedidos.length;i++){
        var pedido = listaPedidos[i];

        var tabla = "<table id='tabla-pedidos'>"+
                    "<tr>"+
                        "<th scope='col' class='cabecera-pedido'>ID "+pedido.pedido_id+"</th>"+
                        "<th scope='col' class='cabecera-pedido'>Concesionario "+pedido.nombreCon+"</th>"+
                        "<th scope='col' class='cabecera-pedido'>Fecha "+pedido.fecha+"</th>"+
                    "</tr>";
            
        var producto = listaPedidos[i];
        
        for(j=i+1; j<=listaPedidos.length && pedido.pedido_id==producto.pedido_id;j++){
            tabla = tabla+"<tr>"+
                            "<th scope='col' class='cabecera-producto'>Producto</th>"+
                            "<th scope='col' class='cabecera-producto'>Cantidad</th>"+
                            "<th scope='col' class='cabecera-producto'>Estado</th>"+
                          "</tr>\n";
                  
            tabla = tabla+"<tr>"+
                            "<td class='celda-pedido'>"+producto.nombre+"</td>"+
                            "<td class='celda-pedido'>"+producto.cantidad+"</td>";
                  
            if(producto.estado==1){
                tabla = tabla+"<td class='celda-pedido'>";
                tabla = tabla+"Confirmado";
                tabla = tabla+"</td>";
            }
            else{
                tabla = tabla+"<td class='celda-pedido'>";
                tabla = tabla+"<button class='confirm' value='confirmed'>Confirmar</button>";
                tabla = tabla+"</td>";
            }
            
            tabla = tabla+"</tr>"
            producto = listaPedidos[j];
            
        }
        i = i+j-2;
        contenido = contenido+tabla+"</table>";
    }

    $("#lista-pedidos").empty();
    $("#lista-pedidos").append(contenido);
}

function ajaxRequest(data, script){
    var request = new XMLHttpRequest();
        
        request.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
               // alert("llega");
               //alert(JSON.parse(this.responseText));
               //alert(this.responseText);
               //console.log(this.responseText);
               tablaPedidos(this.responseText);
            }
        };
        //alert(data);
        request.open("POST", script, true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send(data);
}

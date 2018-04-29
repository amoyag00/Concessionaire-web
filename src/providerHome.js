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

    $(".list-filter").on("change", filterHandler);
    
    /*$(".confirmed-filter").click(function(){
        ajaxRequest("data="+JSON.stringify({"peticion":"listaNoConfirmados"}) ,"Peticiones.php");
    });*/
});

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
    var tabla = "<table id='tabla-pedidos>"+
                    "<tr> "+
                        "<th scope='col'>ID</th>"+
                        "<th scope='col'>Concesionario</th>"+
                        "<th scope='col'>Fecha</th>"+
                        "<th scope='col'>Estado</th>"+
                    "</tr>";
    /*alert(tabla);
    for(i=0;i<listaPedidos.length;i++){
        var pedido = listaPedidos[i];
        tabla = tabla+"<tr>";
        //console.log(pedido.pedido_id);
        for(j=0;j<listaPedidos[i].length;j++){
            tabla = tabla+"<td>";
            if(j==0){
                tabla = tabla+pedido.pedido_id;
            }
            else if(j==1){
                tabla = tabla+pedido.nombreCon;
            }
            else if(j==2){
                tabla = tabla+pedido.fecha;
            }
            else{
                if(pedido.estado==1){
                    tabla = tabla+"Confirmado";
                }
                else{
                    tabla = tabla+"<button class='confirm' value='confirmed'>Confirmar</button>";
                }
            }
            tabla = tabla+"</td>";
        }
        tabla = tabla+"</tr>"
    }*/
    tabla = tabla+"</table>";
    $("#lista-pedidos").empty();
    $("#lista-pedidos").append(tabla);
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
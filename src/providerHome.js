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
        ajaxRequest("data="+JSON.stringify({"peticion":"listaPedidosCompleta"}) ,"Peticiones.php");
    }
    else{
        
    }
}

function ajaxRequest(data, script){
    var request = new XMLHttpRequest();
        
        request.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
               // alert("llega");
               //alert(JSON.parse(this.responseText));
               //alert(this.responseText);
               console.log(this.responseText);
            }
        };
        
        request.open("POST", script, true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send(data);
}



$(document).ready(function(){

	 
	 $('input[name=send]').on("click",enviar);

});

function enviar(){
	var nombre=$('input[name=name]').val();
	var email = $('input[name=email]').val();
	var consulta= $('textarea').val();
	//alert("hola");
	peticionAjax("Peticiones.php","data="+JSON.stringify({"peticion":"nuevoMensaje","name":nombre,"email":email,"consult":consulta}));
}

function peticionAjax(script, data, callback){
	var request= new XMLHttpRequest();
	//alert("hola");
    request.onreadystatechange = function(aEvt){
        if(this.readyState==4 && this.status==200){
            if(callback!=null){
                callback(this.responseText);
            }
        }
    };
    request.open("POST",script,false);//method script sync
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(data);
	//alert("Acabado");
}
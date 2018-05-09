$(document).ready(function(){
    
	$('#gestion').on('click',gestionHandler);
	$('#mensajes').on("click",mensajesHandler);
	
    $('#main-div').on("click","#anyadir-user",anyadirUser);
	$('#main-div').on("click",".delete-user:submit",deleteUser);
	$('#main-div').on("click",".expulsar-user:submit",expulsarUser);
	
	$('#main-div').on("click","tr",showContent);
	
	$('.log-out').on("click",logout);
	
});

var listaMensajes=new Array();

function gestionHandler(){
 
   //Buttons
   $(this).prop("disabled",true);
   $('#mensajes').prop("disabled",false);
    //Content
    $("#main-div").empty();
	showGestion();
 }

 function anyadirUser(){

	
    var nombreUser = $(".anyadir-user:text").val();
	var contrasena = $("#password").val();
    var tipo = $('input[name=tipo]:checked').val();
	//alert("Anyadir");
	peticionAjax("Peticiones.php","data="+JSON.stringify({"peticion":"registrarUsuario","name":nombreUser,"password":contrasena,"type":tipo}),alerta);
	
 } 
function expulsarUser(){
	
	var nombreUser = $(".expulsar-user:text").val();
	//var tipo = $('input[name=tipo]:checked').val();
	alert("Expulsar");
	peticionAjax("Peticiones.php","data="+JSON.stringify({"peticion":"expulsar","name":nombreUser}),alerta);
	
}
function deleteUser(){
	
	var nombreUser = $(".delete-user:text").val();
	//var tipo = $('input[name=tipo]:checked').val();
	alert("Borrar");
	peticionAjax("Peticiones.php","data="+JSON.stringify({"peticion":"deleteUser","name":nombreUser}),alerta);
	
}

function alerta(data){
	var info=JSON.parse(data);
	//alert(info);
}

function mensajesHandler(){
   //Buttons
   $(this).prop("disabled",true);
   $('#gestion').prop("disabled",false);
    //Content
    $("#main-div").empty();
	peticionAjax("Peticiones.php","data="+JSON.stringify({"peticion":"listaMensajes"}), showMensajes);
	
}

function peticionAjax(script, data, callback){
    var request= new XMLHttpRequest();
	alert("Peticion");
    request.onreadystatechange= function(){
        if(this.readyState==4 && this.status==200){
            if(callback!=null){
                alert(this.responseText);
                callback(this.responseText);
            }
        }
    };
    request.open("POST",script,true);//method script async
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(data);
	alert("Acabada");

}

function showMensajes(data){
	listaMensajes = [];
	var mensajes=JSON.parse(data);
	//mensajes.length

	var contenedor="<div id='contenedorTabla'></div>";
	$('#main-div').append(contenedor);
	
	var tabla = 	"<table id='mensaje' class='mensaje'>"+
							"<tr id='-1' class='mensaje'>"+
								"<th class='mensaje' >Nombre</td>"+
								"<th class='mensaje' >Email</td>"+					
							"</tr>";
	
	for(var i=0;i<mensajes.length;i++){
		
		var consulta=mensajes[i].consulta;
		
		listaMensajes.push(consulta);
	
		var nombre = mensajes[i].name;
		var email = mensajes[i].email;
		
		//alert("Fila "+i+": "+nombre+" "+email+" "+mensajes[i].consulta);
		
		tabla += "<tr class='mensaje' id="+i+">"+
						"<td class='mensaje' >"+nombre+"</td>"+
						"<td class='mensaje' >"+email+"</td>"+					
					 "</tr>";
						
		
		
	}
	
	tabla +="</table>";
	
	alert(listaMensajes);
	
	var vistaMensajes = "<div id='vistaMensajes'> </div>";
	
	$('#contenedorTabla').append(tabla);
	$('#main-div').append(vistaMensajes);

}
function showContent(){
	
	$('#vistaMensajes').empty();
	//alert($(this).attr("id"));
	if($(this).attr("id")<0){
		var vistaMensajes = "<p class='vistaMensajes'></p>";
	}else{
	var vistaMensajes = "<p class='vistaMensajes'> "+listaMensajes[$(this).attr("id")]+"</p>";
	}
	$('#vistaMensajes').append(vistaMensajes);
}


function logout(){
    peticionAjax("Peticiones.php","data="+JSON.stringify({"peticion":"logout"}),goIndex);
    
}

function goIndex(){
    document.location.href = "index.html";
}

function showGestion(){
	
	var formularios ="<form action='' method='post' class='anyadir-user'>"+
							"<div id='row'>"+
								"<h1 class='anyadir-user'>Añadir Usuario</h1>"+
							"</div>"+
							"<div id='row'>"+
								"<label class='anyadir-user'>Nombre de usuario</label>"+
								"<input type='text' name='Nombre de Usuario' placeholder='Usuario' class='anyadir-user'/>"+
							"</div>"+
							"<div id='row'>"+						
							"<div id='row'>"+
								"<label class='anyadir-user'>Tipo de usuario</label>"+
							"</div>"+
							
								"<div id='row'>"+						
									"<input id='column' type='radio' value='concessionaire' name='tipo' class='anyadir-user'/><a class='anyadir-user'>Concesionario</a>"+		
								"</div><div id='row'>"+							
									"<input id='column' type='radio' value='provider' name='tipo' class='anyadir-user'/><a class='anyadir-user'>Proveedor</a>"+							
								"</div>"+
							"</div>"+
							"<div id='row'>"+
								"<label class='anyadir-user'>Introduce una contraseña</label>"+		
								"<input type='password' id='password' name='Contraseña' placeholder='Contraseña' class='anyadir-user'/>"+
							"</div>"+
							"<!-- <div id='row'>"+
								"<label class='anyadir-user'>Repite la contraseña</label>"+
								"<input type='password' name='Repetir contraseña' placeholder='Contraseña' class='anyadir-user'/>"+
							"</div> -->"+
							"<div id='row'>"+
								"<button value='Añadir usuario' class='anyadir-user' id='anyadir-user'>Añadir usuario</button> "+
							"</div>"+
						"</form>"+
						"<form action='' method='post' class='delete-user'>"+
							"<div id='row'>"+
								"<h1 class='delete-user'>Eliminar Usuario</h1>"+
							"</div>"+
							"<div id='row'>"+
								"<label class='delete-user'>Nombre de usuario</label>"+
								"<input type='text' name='Nombre de Usuario' placeholder='Usuario' class='delete-user'/>"+
							"</div>"+					
															
							"<div id='row'>"+
								"<button value='Eliminar usuario' class='delete-user' id='delete-user'>Eliminar usuario</button> "+
							"</div>"+                    
						"</form>"+				 
						"<form action='' method='post' class='expulsar-user'>"+
							"<div id='row'>"+
								"<h1 class='expulsar-user'>Expulsar Usuario</h1>"+
							"</div>"+					
							"<div id='row'>"+
								"<label class='expulsar-user'>Nombre de usuario</label>"+
								"<input type='text' name='Nombre de Usuario' placeholder='Usuario' class='expulsar-user'/>"+
							"</div>"+
						
							"<div id='row'>"+
								"<button value='Expulsar usuario' class='expulsar-user' id='expulsar-user'>Expulsar usuario</button> "+
							"</div>"+                  
						"</form>";
					
					

		$('#main-div').append(formularios);
}



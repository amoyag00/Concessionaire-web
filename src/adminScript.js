$(document).ready(function(){
    
	$('#gestion').on('click',gestionHandler);
	$('#mensajes').on("click",mensajesHandler);
	
    $('#main-div').on("click","#anyadir-user",anyadirUser);
	$('#main-div').on("click","#delete-user",deleteUser);
	$('#main-div').on("click","#expulsar-user",expulsarUser);
	$('#main-div').on("click","#bloquear-user",bloquearUser);
	$('#main-div').on("click","#desbloquear-user",desbloquearUser);

	$('#main-div').on("click","tr.mensaje",showContent);
	$('#filterMsj').keypress(filter);

	
	
	$('.log-out').on("click",logout);
	
});

var listaMensajes=new Array();
var listaID=new Array();

var listaUsuarios=new Array();

function gestionHandler(){
 
   //Buttons
   $(this).prop("disabled",true);
   $('#mensajes').prop("disabled",false);
   	$('#filterMsj').css('visibility','Hidden');

    //Content
    $("#main-div").empty();
	showGestion();
 }

 function filter(event){

	if(event.which==13){
		$("#main-div").empty();
        
		var param=$('#filterMsj').val();

		peticionAjax("Peticiones.php","data="+JSON.stringify({"peticion":"listaUsuarios"}), showListaUsuarios);
		peticionAjax("Peticiones.php","data="+JSON.stringify({"peticion":"listaMensajes","filtro":param}), showMensajes);
		
	}
	
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
	//alert("Expulsar");
	peticionAjax("Peticiones.php","data="+JSON.stringify({"peticion":"expulsar","name":nombreUser}));
	
}

function bloquearUser(){
	
	var nombreUser = $(".expulsar-user:text").val();
	//var tipo = $('input[name=tipo]:checked').val();
	alert("Bloquear");
	peticionAjax("Peticiones.php","data="+JSON.stringify({"peticion":"bloquear","name":nombreUser}));
	
}

function desbloquearUser(){
	
	var nombreUser = $(".expulsar-user:text").val();
	//var tipo = $('input[name=tipo]:checked').val();
	alert("Desbloquear");
	peticionAjax("Peticiones.php","data="+JSON.stringify({"peticion":"desbloquear","name":nombreUser}));
	
}

function deleteUser(){
	
	var nombreUser = $(".delete-user:text").val();
	//var tipo = $('input[name=tipo]:checked').val();
	//alert("Borrar");
	peticionAjax("Peticiones.php","data="+JSON.stringify({"peticion":"deleteUser","name":nombreUser}),alerta);
	
}

function alerta(data){
	var info=JSON.parse(data);
	alert(info);
}

function mensajesHandler(){
   //Buttons
   $(this).prop("disabled",true);
   $('#gestion').prop("disabled",false);
    //Content
	//alert("Mostrar");
    $("#main-div").empty();
	/*var filtro = "<select id='filterMsj'>"+
						"<option value='todos'>Todos</option>"+
						"<option value='noLeidos'>No Leidos</option>"  +      
					"</select>";*/
	
	$('#filterMsj').css('visibility','visible');
	
	var param=$('#filterMsj').val();

	peticionAjax("Peticiones.php","data="+JSON.stringify({"peticion":"listaUsuarios"}), showListaUsuarios);
	peticionAjax("Peticiones.php","data="+JSON.stringify({"peticion":"listaMensajes","filtro":param}), showMensajes);
	
}

function peticionAjax(script, data, callback){
	var request= new XMLHttpRequest();
	
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

function showMensajes(data){
	listaMensajes = [];
	listaID=[];
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
		listaID.push(mensajes[i].mensaje_id);
		
		var nombre = mensajes[i].name;
		var email = mensajes[i].email;
		
		//alert("Fila "+i+": "+nombre+" "+email+" "+mensajes[i].consulta);
		
		tabla += "<tr class='mensaje leido_"+mensajes[i].leido+"' id="+i+">"+
						"<td class='mensaje' >"+nombre+"</td>"+
						"<td class='mensaje' >"+email+"</td>"+					
					 "</tr>";
						
		
		
	}
	
	tabla +="</table>";
	
	//alert(listaMensajes);
	
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
	
	var id= listaID[$(this).attr("id")];
	//alert($(this).attr("id"));
	//alert(id);
	
	peticionAjax("Peticiones.php","data="+JSON.stringify({"peticion":"mensajeLeido","id":id}));
	
	$(this).addClass("leido_1");
	
	$('#vistaMensajes').append(vistaMensajes);
	
}

function showListaUsuarios(data){
	
	listaUsuarios=[];
	
	var listaUsers = JSON.parse(data);
	
	var contenedor="<div id='contenedorUsr'></div>";
	$('#main-div').append(contenedor);
	
	var tabla = 	"<table id='userName' class='userName'>"+
							"<tr id='-1' class='userName'>"+
								"<th class='userName' >Usuario</td>"+
										
							"</tr>";
	
	for(var i=0;i<listaUsers.length;i++){
		
		var nombreUsr=listaUsers[i].nombre;
		
		listaUsuarios.push(nombreUsr);
		
		var bloqueado=listaUsers[i].bloqueado;

		
		tabla += "<tr class='userName' id='bloqueado_"+bloqueado+"'>"+
					"<td class='userName'  id='bloqueado_"+bloqueado+"'>"+nombreUsr+"</td>"+
				 "</tr>";
	}
	tabla +="</table>";
	
	//alert(listaUsuarios);
	
	$('#contenedorUsr').append(tabla);
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
								"<h1 class='expulsar-user'>Gestionar Usuario</h1>"+
							"</div>"+					
							"<div id='row'>"+
								"<label class='expulsar-user'>Nombre de usuario</label>"+
								"<input type='text' name='Nombre de Usuario' placeholder='Usuario' class='expulsar-user'/>"+
							"</div>"+
						
							"<div id='row'>"+
								"<button value='Bloquear usuario' class='bloquear-user' id='bloquear-user'>Bloquear usuario</button>"+
								"<button value='Desbloquear usuario' class='desbloquear-user' id='desbloquear-user'>Desbloquear usuario</button>"+
								"<button value='Expulsar usuario' class='expulsar-user' id='expulsar-user'>Desloguear usuario</button>"+
							"</div>"+                  
						"</form>";
					
					

		$('#main-div').append(formularios);
}




// validamos formulario de cambio de clave
function validarFormPass() {
	var v_clave = document.getElementById("clave");
    var v_clave2 = document.getElementById("clave2");
    var error = false;

  	document.getElementById("avisosOK").style.display = "none";
  	
    if (v_clave.value.length == 0){
    	EstiloError("clave");
    	error = true;
    }else{
    	RestaurarEstilos("clave");
    }
    
    if (v_clave2.value.length == 0){
    	EstiloError("clave2");
    	error = true;
    }else{
    	RestaurarEstilos("clave2");
    }
    if (!error){
    	 if (v_clave.value == v_clave2.value && v_clave.value.length > 0 && v_clave2.value.length > 0){
  	    	RestaurarEstilos("clave");
  	    	RestaurarEstilos("clave2");
  	    	document.cambioPass.submit();
  	    }else{
  	    	document.getElementById("errores").style.display = "block";
  	    	
  	    	EstiloError("clave");
  	    	EstiloError("clave2");
  		}
    	
    }else{
    	document.getElementById("errores").style.display = "block";
    }
}

// validamos formulario de consulta
function validarFormConsulta(){
	var consulta = document.getElementById("consulta");
	document.getElementById("errores").style.display = "none";
	if (consulta.value.length == 0){
		EstiloError("consulta");
		document.getElementById("errores").style.display = "block";
    }else{
    	document.formConsulta.submit();
    }
}

/* validamos el formulario de alta de nuevo banner */
function validarFormAltaBanner( modo ){
	
	var v_nombre = document.getElementById("nombre");
	var v_url 	 = document.getElementById("url");
	var v_descripcion = document.getElementById("descripcion");
	var v_imagen = document.getElementById("imagen");
	var error = false;
	 
	// restauramos avisos
	document.getElementById("errorExtension").style.display = "none";
	if (document.getElementById("erroresFile") != null){
		document.getElementById("erroresFile").style.display = "none";
	}
	
	
	// validamos que se han informado todos los campos
	if (v_nombre.value.length == 0){
		EstiloError("nombre");
    	error = true;
    }else{
    	RestaurarEstilos("nombre");
    }
	
	if (v_url.value.length == 0){
		EstiloError("url");
    	error = true;
    }else{
    	RestaurarEstilos("url");
    }
	
	
	if (v_descripcion.value.length== 0){
		EstiloError("descripcion");
    	error = true;
    }else{
    	RestaurarEstilos("descripcion");
    }
	
	// solo validamos el fichero en el modo ALTA, no edicion
	if (modo == "alta"){
		if (v_imagen.value.length == 0){
			EstiloError("imagen");
	    	error = true;
	    }else{
	    	var ruta_imagen = v_imagen.value;
	    	// validamos que la extension sea correcta
	    	if (ruta_imagen.indexOf(".jpg") >= 0 || ruta_imagen.indexOf(".png") >= 0 || ruta_imagen.indexOf(".gif") >= 0 || ruta_imagen.indexOf(".bmp") >= 0){
	    		RestaurarEstilos("imagen");
	    	}else{
	    		document.getElementById("errorExtension").style.display = "block";
	    		EstiloError("imagen");
	    		error = true;
	    	}
	    }
	}
		
	if (!error){
		document.grabarNuevoBanner.submit();
	}else{
		document.getElementById("errores").style.display = "block";
	}
}

/* funciones para marcar input text de rojo */
function RestaurarEstilos(elemento){
        document.getElementById(elemento).style.background = "#FFF";
        document.getElementById(elemento).style.color = "#000";
}

function EstiloError(elemento){
        document.getElementById(elemento).style.background = "#F75155";
        document.getElementById(elemento).style.color = "#FFF";
}


// ajax
function nuevoAjax(){
	var xmlhttp=false;
 	try {
 		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
 	} catch (e) {
 		try {
 			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
 		} catch (E) {
 			xmlhttp = false;
 		}
  	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
 		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

// configuracion rapida de banners
//ACTIVO
function ActualizarActivo(bannerID, activo, idUsuario){
	if (activo == "activo.png" || activo == "ambar.png"){
		activo = 0;
		estado = 0;
	}else{
		activo = 1;
		estado = 1;
	}
	var contenedor;
	contenedor = document.getElementById('box-banners');
	ajax=nuevoAjax();
	ajax.open("POST", "funciones_ajax.php?fun=actualizarBannerActivo&bannerID="+bannerID+"&activo="+activo+"&usuario="+idUsuario+"&estado="+estado,true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
		contenedor.innerHTML = ajax.responseText
	 	}
	}
	ajax.send(null)
}
//ESTADO
function ActualizarEstado(bannerID, estado, idUsuario){
	
	if (estado == "stop.png"){
		estado = 1;
		activo = 1;
	}else if (estado == "pause.png"){
		estado = 1;
		activo = 1;
	}else{
		estado = 0;
		activo = 1;
	}
	var contenedor;
	contenedor = document.getElementById('box-banners');
	ajax=nuevoAjax();
	ajax.open("POST", "funciones_ajax.php?fun=actualizarBannerEstado&bannerID="+bannerID+"&activo="+activo+"&usuario="+idUsuario+"&estado="+estado,true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
		contenedor.innerHTML = ajax.responseText
	 	}
	}
	ajax.send(null)
}
//ELIMINAR BANNER
function EliminarBanner(bannerID, idUsuario){
	///confirmamos dialog
	var quest = confirm("¿Estás seguro de borrar el banner?");
	
	if (quest ==true){
		var contenedor;
		contenedor = document.getElementById('box-banners');
		ajax=nuevoAjax();
		ajax.open("POST", "funciones_ajax.php?fun=eliminarBanner&bannerID="+bannerID+"&usuario="+idUsuario,true);
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
			contenedor.innerHTML = ajax.responseText
		 	}
		}
		ajax.send(null)
	}
}


// para el login, si se pulsa ENTER es como submitear el form
function iSubmitEnter(oEvento, oFormulario){
    var iAscii;
    
    if (oEvento.keyCode)
        iAscii = oEvento.keyCode;
    else if (oEvento.which)
        iAscii = oEvento.which;
    else
        return false;
        
    if (iAscii == 13) oFormulario.submit();

    return true; 
}
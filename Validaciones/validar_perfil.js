$(document).on("ready", inicio);

function inicio(){
	$("#usuario").blur(validarUsuario);
	$("#contra").blur(validarContra);
	$("#recontra").blur(validarReContra);
	$("#nombre").blur(validarNombre);
	$("#telefono").blur(validarTel);
	$("#rfc").blur(validarRFC);
}

function validarUsuario(){
	var expresion, usuario;

	usuario = document.getElementById("usuario").value;
	expresion = /^[a-z\d_]{5,14}$/i;

	if (!expresion.test(usuario)){
		$("#iconousuario").remove();
		$("#usuario").parent().parent().attr("class", "form-group has-error has-feedback");
		$("#usuario").parent().append("<span id='iconousuario' class='glyphicon glyphicon-remove form-control-feedback'></span>");
		return false;
	}else{
		$("#iconousuario").remove();
		$("#usuario").parent().parent().attr("class", "form-group has-success has-feedback");
		$("#usuario").parent().append("<span id='iconousuario' class='glyphicon glyphicon-ok form-control-feedback'></span>");
		return true;
	}

}

function validarContra(){
	var expresion, contra;

	contra = document.getElementById("contra").value;
	expresion = /^[a-z\d_]{5,30}$/i;

	if (!expresion.test(contra)){
		$("#iconoContra").remove();
		$("#contra").parent().parent().attr("class", "form-group has-error has-feedback");
		$("#contra").parent().append("<span id='iconoContra' class='glyphicon glyphicon-remove form-control-feedback'></span>");
		return false;
	}else{
		$("#iconoContra").remove();
		$("#contra").parent().parent().attr("class", "form-group has-success has-feedback");
		$("#contra").parent().append("<span id='iconoContra' class='glyphicon glyphicon-ok form-control-feedback'></span>");
		return true;
	}
}

function validarReContra(){
	var recontra, contra;

	contra = document.getElementById("contra").value;
	recontra = document.getElementById("recontra").value;

	if (contra != recontra ) {
		$("#iconoReContra").remove();
		$("#recontra").parent().parent().attr("class", "form-group has-error has-feedback");
		$("#recontra").parent().append("<span id='iconoReContra' class='glyphicon glyphicon-remove form-control-feedback'></span>");
		$("#aviso").append("<span id='mensajeaviso'>Las contraseñas no coinciden.</span>");
		return false;
	}else{
		$("#iconoReContra").remove();
		$("#mensajeaviso").remove();
		$("#recontra").parent().parent().attr("class", "form-group has-success has-feedback");
		$("#recontra").parent().append("<span id='iconoReContra' class='glyphicon glyphicon-ok form-control-feedback'></span>");
		return true;
	}

}

function validarNombre(){
	var nombre, expresion;

	nombre = document.getElementById("nombre").value;
	expresion = /^([A-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$/;

	if (!expresion.test(nombre)) {
		$("#iconoNombre").remove();
		$("#nombre").parent().parent().attr("class", "form-group has-error has-feedback");
		$("#nombre").parent().append("<span id='iconoNombre' class='glyphicon glyphicon-remove form-control-feedback'></span>");
		return false;
	}else{
		$("#iconoNombre").remove();
		$("#nombre").parent().parent().attr("class", "form-group has-success has-feedback");
		$("#nombre").parent().append("<span id='iconoNombre' class='glyphicon glyphicon-ok form-control-feedback'></span>");
		return true;
	}
}

function validarTel(){
	var tel, expresion;

	tel = document.getElementById("telefono").value;
	expresion = /^\+?\d{1,3}?[- .]?\(?(?:\d{2,3})\)?[- .]?\d\d\d[- .]?\d\d\d\d$/;

	if (!expresion.test(tel)) {
		$("#iconoTel").remove();
		$("#telefono").parent().parent().attr("class", "form-group has-error has-feedback");
		$("#telefono").parent().append("<span id='iconoTel' class='glyphicon glyphicon-remove form-control-feedback'></span>");
		return false;
	}else{
		$("#iconoTel").remove();
		$("#telefono").parent().parent().attr("class", "form-group has-success has-feedback");
		$("#telefono").parent().append("<span id='iconoTel' class='glyphicon glyphicon-ok form-control-feedback'></span>");
		return true;
	}
}

function validarRFC(){
	var rfc, expresion;

	rfc = document.getElementById("rfc").value;
	expresion = /^([A-ZÑ\x26]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1]))((-)?([A-Z\d]{3}))?$/;

	if (expresion.test(rfc)) {
		$("#iconoRFC").remove();
		$("#rfc").parent().parent().attr("class", "form-group has-success has-feedback");
		$("#rfc").parent().append("<span id='iconoRFC' class='glyphicon glyphicon-ok form-control-feedback'></span>");
		return true;
	}else if (rfc == "" || rfc.length == 0) {
		$("#iconoRFC").remove();
		$("#rfc").parent().parent().attr("class", "form-group has-success has-feedback");
		$("#rfc").parent().append("<span id='iconoRFC' class='glyphicon glyphicon-ok form-control-feedback'></span>");
		return true;
	}else{
		$("#iconoRFC").remove();
		$("#rfc").parent().parent().attr("class", "form-group has-error has-feedback");
		$("#rfc").parent().append("<span id='iconoRFC' class='glyphicon glyphicon-remove form-control-feedback'></span>");
		return false;
	}
}

function validar(){
	if (validarUsuario() && validarContra() && validarReContra() && validarNombre() && validarTel() && validarRFC()) {
		return true;
	}else{
		swal("Aviso!","Verifica los datos.", "warning");
		return false;
	}
}
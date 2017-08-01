function validar(){
	var user, contra,expresion;
	user = document.getElementById("usuario").value;
	contra = document.getElementById("contra").value;

	if(user == ""){
		swal("","El campo de usuario esta vacio.","warning")
		return false;
	}else if (contra == ""){
		swal("","El campo contraseña esta vacio.","warning")
		return false;
	}
}

function validarAddCliente(){
	var nombre, apa, ama, tel, direc, email, rfc;

	nombre = document.getElementById("nombre").value;
	apa = document.getElementById("apa").value;
	ama = document.getElementById("ama").value;
	tel = document.getElementById("tel").value;
	direc = document.getElementById("direc").value;
	email = document.getElementById("email").value;
	rfc = document.getElementById("rfc").value;

	if (nombre == "") {
		swal("","El nombre esta vacio.","warning")
		return false;
	}else if (apa == ""){
		swal("","El apellido paterno esta vacio.","warning")
		return false;
	}
	else if (ama == ""){
		swal("","El apellido materno esta vacio.","warning")
		return false;
	}
	else if (tel == ""){
		swal("","El teléfono esta vacio.","warning")
		return false;
	}
	else if (direc == ""){
		swal("","La dirección esta vacio.","warning")
		return false;
	}else if (email == ""){
		swal("","El email esta vacio.","warning")
		return false;
	}else if (rfc == ""){
		swal("","La RFC esta vacio.","warning")
		return false;
	}
}
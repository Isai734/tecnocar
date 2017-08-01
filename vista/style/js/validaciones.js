
//VALIDAR QUE LOS CAMPOS NO ESTE VACIOS EN EL LOGIN
function validar() {
    var user, contra, expresion;
    user = document.getElementById("usuario").value;
    contra = document.getElementById("contra").value;

    if (user == "") {
        swal("", "El campo de usuario esta vacio.", "warning")
        return false;
    } else if (contra == "") {
        swal("", "El campo contraseña esta vacio.", "warning")
        return false;
    }
}


//VALIDAR SI EL USUARIO YA EXISTE
function existUser(user,clave) {

    for (var i = 0; i < user.length; i++) {
        if (user[i]['usuario'] == clave)
            return true;
    }
    return false;
}

function validarlogin(users) {

    var user, contra, recontra;
    user = document.getElementById("usuario").value;
    contra = document.getElementById("contra").value;
    recontra = document.getElementById("recontra").value;
    if(existUser(users,user)){
        swal("", "El campo de usuario esta vacio.", "warning")
        return false;
    }else if (user == "") {
        swal("", "El campo de usuario esta vacio.", "warning")
        return false;
    } else if (contra == "") {
        swal("", "El campo contraseña esta vacio.", "warning")
        return false;
    } else if (contra != recontra) {
        swal("", "Contraseñas no coinciden", "warning")
        return false;
    }
    validarAddCliente();
}

function validarAddCliente() {
    //clave, nombre, apellido_paterno, apellido_materno, telefono, direccion, email, cp, rfc, especialidad, tipo, status
    var nombre, apa, ama, tel, direc, email, rfc, user;


    nombre = document.getElementById("nombre").value;
    apa = document.getElementById("apellido_paterno").value;
    ama = document.getElementById("email").value;
    tel = document.getElementById("telefono").value;
    direc = document.getElementById("direccion").value;
    email = document.getElementById("email").value;
    rfc = document.getElementById("rfc").value;
    user = document.getElementById("usuario").value;

    if (usuario == "") {
        swal("", "El campo usuario esta vacio.", "warning");
    }
    if (nombre == "") {
        swal("", "El nombre esta vacio.", "warning")
        return false;
    } else if (apa == "") {
        swal("", "El apellido paterno esta vacio.", "warning")
        return false;
    }
    else if (ama == "") {
        swal("", "El apellido materno esta vacio.", "warning")
        return false;
    }
    else if (tel == "") {
        swal("", "El teléfono esta vacio.", "warning")
        return false;
    }
    else if (direc == "") {
        swal("", "La dirección esta vacio.", "warning")
        return false;
    } else if (email == "") {
        swal("", "El email esta vacio.", "warning")
        return false;
    } else if (rfc == "") {
        swal("", "La RFC esta vacio.", "warning")
        return false;
    }
}

function validarAuto() {
    //placa, marca, modelo, modelo, anio, transmision, cliente_clave
    var placa, marca;
    placa = document.getElementById("placa").value;
    marca = document.getElementById("marca").value;

    if (placa == "") {
        swal("", "Debe escribir una placa.", "warning")
        $("#placa").parent().parent().attr("class", "form-group has-error");
        return false;
    } else if (marca == "") {
        swal("", "Escriba una marca para el carro.", "warning")
        return false;
    }
}


///VALIDAR AUTOS MODULO ADMINISTRADOR
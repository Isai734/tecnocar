<?php
session_start();
include '../../modelo/ConexionBD.php';
include '../../control/persona.php';
include '../../control/login.php';
include '../../utilidades/Constantes.php';
include '../../utilidades/ExcepcionApi.php';
$metodo = $_GET['metodo']
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registro de cliente.</title>
    <link rel="stylesheet" type="text/css" href="../../vista/style/sweet/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="../../vista/style/sweet/twitter.css">
</head>
<body>
<script src="../../vista/style/js/jquery-3.2.0.min.js"></script>
<script src="../../vista/style/sweet/sweetalert.min.js"></script>
<?php

$_POST['tipo'] = "CLIENTE";
//EJECUTAR CONSULTA
$str = json_encode($_POST);
$resultado = null;
$url = "";
switch ($metodo) {
    case "add":
        $resultado = persona::createPersona(json_decode($str));
        $_POST[login::PERSONA_CLAVE] = $resultado[persona::ID_PERSONA];
        $str = json_encode($_POST);
        $resultado = login::createLogin(json_decode($str));
        $url = "../index.php";
        if ($resultado["estado"]==Constantes::CODIGO_EXITO) {
            $login = login::getLogin($_POST['usuario']);
            //$user = $login[login::NOMBRE_TABLA];
            $_SESSION[login::NOMBRE_TABLA] = $login[login::NOMBRE_TABLA];
        }
        break;
    case "update":
        $_POST[persona::ID_PERSONA] = $_SESSION[login::NOMBRE_TABLA][login::PERSONA_CLAVE];
        $_POST["usuarion"] = $_POST["usuario"];
        $_POST["usuario"] = $_SESSION[login::NOMBRE_TABLA][login::USUARIO];
        $str = json_encode($_POST);
        $resultado = persona::updatePersona(json_decode($str));
        if (!equals()) {
            $resultado = login::updateLogin(json_decode($str));
            $url = "logout.php";
        } else {
            $url = "perfil.php";
        }
        break;
    case "delete":
        $resultado = persona::deletePersona($_GET['id']);
        break;
}

function equals()
{
    $pass = $_SESSION[login::NOMBRE_TABLA][login::CONTRASENIA];
    if ($_POST['usuario'] == $_POST["usuarion"]) {
        if ($pass == $_POST['contrasenia']) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

if ($resultado['estado'] != Constantes::CODIGO_EXITO) { ?>
    <script>
        swal({
                title: "Mensaje!",
                text: "Error al realizar el registro.",
                type: "error",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Aceptar",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    window.location = "<?=$url?>";
                }
            });
    </script>
<?php }else{ ?>
    <script>
        swal({
                title: "Mensaje!",
                text: "Resgistro realizado exitosamente.",
                type: "success",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Aceptar",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    window.location = "<?=$url?>";
                }
            });
    </script>
<?php } ?>

<?php
?>

</body>
</html>

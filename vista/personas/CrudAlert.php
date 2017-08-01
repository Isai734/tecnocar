<?php
session_start();
include '../../modelo/ConexionBD.php';
include '../../control/persona.php';
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
    <link rel="stylesheet" type="text/css" href="../style/sweet/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="../style/sweet/twitter.css">
</head>
<body>
<script src="../style/js/jquery-3.2.0.min.js"></script>
<script src="../style/sweet/sweetalert.min.js"></script>
<?php

$_POST['tipo'] = $_GET['tipo'];
//EJECUTAR CONSULTA
$str = json_encode($_POST);
$resultado = null;
switch ($metodo) {
    case "add":
        $tipo = $_GET['tipo'];
        $resultado = persona::createPersona(json_decode($str));
        break;
    case "update":
        $resultado = persona::updatePersona(json_decode($str));
        break;
    case "delete":
        $resultado = persona::deletePersona($_GET['id']);
        break;
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
                    window.location = "AddPersona.php?tipo=<?php echo $_GET['tipo'];?>";
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
                    window.location = "QueryPersona.php?tipo=<?php echo $_GET['tipo'];?>";
                }
            });
    </script>
<?php } ?>

<?php
?>

</body>
</html>

<?php
session_start();
include '../../modelo/ConexionBD.php';
include '../../control/auto.php';
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
    <title>Registro del auto.</title>
    <link rel="stylesheet" type="text/css" href="../style/sweet/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="../style/sweet/twitter.css">
</head>
<body>
<script src="../style/js/jquery-3.2.0.min.js"></script>
<script src="../style/sweet/sweetalert.min.js"></script>
<?php
//EJECUTAR CONSULTA

if (isset($_GET['clave']) & !empty($_GET['clave'])) {
    //echo $_GET['id'];
    $_POST[auto::CLIENTE_CLAVE] = $_GET['clave'];
}

$str = json_encode($_POST);
$resultado = null;
switch ($metodo) {
    case "add":
        $resultado = auto::createAuto(json_decode($str));
        break;
    case "update":
        $resultado = auto::updateAuto(json_decode($str));
        break;
    case "delete":
        $resultado = auto::deleteAuto($_GET['id']);
        break;
}

if ($resultado['estado'] != Constantes::CODIGO_EXITO) { ?>

    <script>
        swal({
                title: "Mensaje!",
                text: "Error al intentar acceder al registro.",
                type: "error",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Aceptar",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    window.location = "AddAuto.php";
                }
            });
    </script>
<?php }else{ ?>
    <script>
        swal({
                title: "Mensaje!",
                text: "<?php echo $resultado['mensaje'];?>",
                type: "success",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Aceptar",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    window.location = "QueryAutos.php<?php if (!empty($_GET['id'])) echo "?id=" . $_GET['id'];?>";
                }
            });
    </script>
<?php } ?>

<?php
?>

</body>
</html>

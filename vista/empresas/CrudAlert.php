<?php
session_start();
include '../../modelo/ConexionBD.php';
include '../../control/empresa.php';
include '../../utilidades/Constantes.php';
include '../../utilidades/ExcepcionApi.php';
$metodo = $_GET['metodo']
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registro de la Empresa.</title>
    <link rel="stylesheet" type="text/css" href="../style/sweet/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="../style/sweet/twitter.css">
</head>
<body>
<script src="../style/js/jquery-3.2.0.min.js"></script>
<script src="../style/sweet/sweetalert.min.js"></script>
<?php
//EJECUTAR CONSULTA
if (isset($_GET['id']) & !empty($_GET['id'])) {
    $_POST[empresa::CLAVE] = $_GET['id'];
}
$str = json_encode($_POST);
$resultado = null;
switch ($metodo) {
    case "add":
        $resultado = empresa::createEmpresa(json_decode($str));
        break;
    case "update":
        $resultado = empresa::updateEmpresa(json_decode($str));
        break;
    case "delete":
        $resultado = empresa::deleteEmpresa($_GET['id']);
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
                    window.location = "AddEmpresa.php";
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
                    window.location = "QueryEmpresa.php";
                }
            });
    </script>
<?php } ?>

<?php
?>

</body>
</html>

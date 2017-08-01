<?php
include '../../modelo/ConexionBD.php';
include '../../control/producto.php';
include '../../control/empresa.php';
include '../../control/persona.php';
include '../../control/servicio.php';
include '../../control/cita.php';
include '../../control/orden.php';
include '../../control/auto.php';
include '../../utilidades/Constantes.php';
include '../../utilidades/ExcepcionApi.php';
session_start();
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
$resultado=null;
switch ($metodo) {
    case "add":
        $resultado = orden::transaccionarOrden($_SESSION['post']);
        break;
    case "update":
        $resultado = producto::updateProducto(json_decode($str));
        break;
    case "delete":
        $resultado = producto::deleteProducto($_GET['id']);
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
                    window.location = "../cotizacion/QueryCotizacion.php";
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
                    window.location = "../ordns_servicios/recepccionAuto.php";
                }
            });
    </script>
<?php } ?>

<?php
?>

</body>
</html>
